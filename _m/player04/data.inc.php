<?php
if (!$DIRA[2] || !is_numeric($DIRA[2])) {header("location:/?/".$DIRA[2]."__NOT_FOUND");exit();}


require_once($_SERVER['DOCUMENT_ROOT']."/config/php.function.youtube.inc.php");
function is_wordwall($url) {  
    //https://wordwall.net/resource/39252

    $url=strtolower($url);
    $url=str_replace("//www.","://", $url);
    $url=str_replace("http://","https://", $url);
    $start=substr($url, 0,30);
    if ($start!="https://wordwall.net/resource/") return false;
    $id=str_replace($start,"", $url);
    if (intval($id)) return intval($id);
	return false;	
}
function replaceSomeTags($s) {
    $s=str_replace("<eq>", "",  $s);
    $s=str_replace("</eq>", "",  $s);
    return $s;
}

######## DATA EXCHANGE

$G=sql_fetch_assoc(	sql_query("
SELECT 
G.gameId,
G.language,
G.title,
G.Description,
G.Goal_1,G.Goal_2,G.Goal_3,G.Goal_4,
G.Goal_5,
G.steps,
G.usr_female_avatar_id,
G.usr_male_avatar_id,
G.usr_description,
G.usr_goal1,
G.usr_goal1,
G.usr_goal1,
G.status,
G.structure,
G.forkFrom,

G.balloonFont,
G.endCredits,
G.videoIntro,
F.balloonSize,F.fformat
FROM games G 
        LEFT JOIN fonts F on G.balloonFont=F.file
		WHERE gameId='".(trim($DIRA[2]))."'
"));



//$G["Description"].="<credits>Ingegnere_capo: Arny Drive</credits><credits>Tech Supervisor: Arnaldo Maria</credits>";
$G["credits"]=creditsFromDescription($G["Description"]);
$G["Description"]=delete_all_between("<credits>", "</credits>",$G["Description"] );
$G["Description"]=strip_tags($G["Description"]);






if ( !$G['gameId']	) {header("location:/?/".$DIRA[2]."__NOT_FOUND");exit();}
$strS="SELECT 
/*A.*,*/
S.step,
S.scene,
concat ('".SCENARIOPATH."', S.scenario_id,'_1024.jpg') scenario,
S.avatar_id,
S.avatar_size,
S.avatar_pos,
S.balloon_pos,
S.arrowY,
S.arrowPos,
S.avatar_sentence,
S.avatar_audio,
concat ('".AUDIOPATH."', S.avatar_audio) avatar_audio,
S.compulsoryAttachments,
S.answer_1,S.ascore_1,S.goto1,
S.answer_2,S.ascore_2,S.goto2,
S.answer_3,S.ascore_3,S.goto3,
S.answer_4,S.ascore_4,S.goto4,
S.type,
feedback_1, feedback_1_audio,
feedback_2, feedback_2_audio,
feedback_3, feedback_3_audio,
feedback_4, feedback_4_audio,
IF(feedback_1_scenario_id IS NOT NULL , concat ('".SCENARIOPATH."', S.feedback_1_scenario_id,'_1024.jpg'), null) as feedback_1_scenario,
IF(feedback_2_scenario_id IS NOT NULL , concat ('".SCENARIOPATH."', S.feedback_2_scenario_id,'_1024.jpg'), null) as feedback_2_scenario,
IF(feedback_3_scenario_id IS NOT NULL , concat ('".SCENARIOPATH."', S.feedback_3_scenario_id,'_1024.jpg'), null) as feedback_3_scenario,
IF(feedback_4_scenario_id IS NOT NULL , concat ('".SCENARIOPATH."', S.feedback_4_scenario_id,'_1024.jpg'), null) as feedback_4_scenario

FROM games_steps S 
/*LEFT JOIN avatars A on A.id=S.avatar_id */
WHERE S.gameId =".$G['gameId']." 

ORDER BY step ASC";  /*ids ASC, */
$G["strS"]=$strS;




$qS=sql_query($strS);
if (sql_error()) {
	echo sql_error();
	die();
}

$FACTOR=2;
$G["AB"]=array();
$stepC=0;
while (	$ST=sql_fetch_assoc($qS)	){

    $ST["avatar_sentence"]=replaceSomeTags($ST["avatar_sentence"]);
    $ST["answer_1"]=replaceSomeTags($ST["answer_1"]);
    $ST["answer_2"]=replaceSomeTags($ST["answer_2"]);
    $ST["answer_3"]=replaceSomeTags($ST["answer_3"]);
    $ST["answer_4"]=replaceSomeTags($ST["answer_4"]);


	$ST["answerN"]=2;if ($ST["answer_3"]) $ST["answerN"]=3;if ($ST["answer_4"]) $ST["answerN"]=4;;if ($ST["answer_5"]) $ST["answerN"]=5;
    if (!$ST["avatar_pos"]) $ST["avatar_pos"]="264,3";
    
	$ST["avatar_posA"]=explode(",",$ST["avatar_pos"] ); $ST["avatar_posA"][0]=$ST["avatar_posA"][0]*$FACTOR;$ST["avatar_posA"][1]=$ST["avatar_posA"][1]*$FACTOR;
	$ST["balloon_posA"]=explode(",",$ST["balloon_pos"] ); 
	$ST["balloon_posA"][0]=$ST["balloon_posA"][0]*$FACTOR;
	$ST["balloon_posA"][1]=$ST["balloon_posA"][1]*$FACTOR;

	$ST["arrowY"]=$ST["arrowY"]*$FACTOR;
    
    // attachment

	$ST["A"]=array();
	$ST["attQ"]="SELECT scene, title, path, type, mime
	FROM games_steps_attachments WHERE gameId=".$G['gameId']." AND step=".$ST['step']." ORDER BY idAttachment ASC";
    
    
	$aA=sql_query($ST["attQ"]);
	if (sql_error()) {
        $ST["attQE"]=sql_error();
        echo "<pre>";print_r($G);die;
    }
	//unset ($ST["attQ"]);
	$mimePlayer=array('mp4','webm','ogg','jpeg','png');
    
	while (	$ATT=sql_fetch_assoc($aA)	){	
		
		$ATT["info"]=$ATT["type"];
        
        //if ($ATT["mime"]) $ATT["info"]=$ATT["mime"];
        $tmpi=explode(".", $ATT["path"]);
        if (!$ATT["mime"]) 
            $ATT["info"]=strtolower($tmpi[	(sizeof($tmpi)-1)			]); // estensione
        else
            $ATT["info"]=$ATT["mime"];
        
        
        $ATT["open"]="out";
        if ($ATT["info"]=="jpeg" || $ATT["info"]=="jpg" || $ATT["info"]=="png" || $ATT["info"]=="gif") $ATT["open"]="in";
        if ($ATT["info"]=="mp4" || $ATT["info"]=="mp3" || $ATT["info"]=="ogg" || $ATT["info"]=="webm") $ATT["open"]="in";
        if ($ATT["info"]=="pdf") $ATT["open"]="in";
        
		if ($ATT["open"]=="in") { //if ($ATT["type"]=="attach") {
			

			#####################
			if ($ATT["info"]=="jpeg" || $ATT["info"]=="jpg" || $ATT["info"]=="png"|| $ATT["info"]=="gif") {

				//$ATT["open"]="in";
				$size=@getimagesize($_SERVER['DOCUMENT_ROOT']."/".$ATT["path"]);
				$ATT["H"]=$size[1];
				$ATT["W"]=$size[0];
				$ATT["majordim"]="W";
				if ($ATT["H"]>$ATT["W"]) $ATT["majordim"]="H";
				if ($ATT["H"]==$ATT["W"]) $ATT["majordim"]="H";
				//////////////////
				if ($ATT["majordim"]=="W") {
					if ($ATT["W"]<1000)  {
						$ATT["W1"]=$ATT["W"];
					}else{
						$ATT["W1"]=1000;
					}
					$ATT["H1"]="auto";
				}
				
				if ($ATT["majordim"]=="H") {
					if ($ATT["H"]<562.50)  {
						$ATT["H1"]=$ATT["H"];
					}else{
						$ATT["H1"]=562.50;
					}
					$ATT["W1"]="auto";
				}				
				/////////////			
			} // jpg png
            
            // video
			if ($ATT["info"]=="mp4"|| $ATT["info"]=="webm" || $ATT["info"]=="ogg") {
                if ($ATT["type"]=="attach") 
                    $ATT["getVideoProp"]=getVideoProp($_SERVER['DOCUMENT_ROOT']."/".$ATT["path"]);
                else 
                    $ATT["getVideoProp"]=getVideoProp($ATT["path"],true);
                    
				
				$ATT["H"]=$ATT["getVideoProp"]["resolution_y"];
				$ATT["W"]=$ATT["getVideoProp"]["resolution_x"];
                unset ($ATT["getVideoProp"]);
                
				$ATT["majordim"]="W";
				if ($ATT["H"]>$ATT["W"])    $ATT["majordim"]="H";
				if ($ATT["H"]==$ATT["W"])   $ATT["majordim"]="H";
				//////////////////
				if ($ATT["majordim"]=="W") {
					if ($ATT["W"]<1000)  {
						$ATT["W1"]=$ATT["W"];
					}else{
						$ATT["W1"]=1000;
					}
					$ATT["H1"]="auto";
				}
				
				if ($ATT["majordim"]=="H") {
					if ($ATT["H"]<562.50)  {
						$ATT["H1"]=$ATT["H"];
					}else{
						$ATT["H1"]=562.50;
					}
					$ATT["W1"]="auto";
				}	
                
				/////////////			
			} // mp4
            
            
		}// type attach
		
		//is_youtube_video
		if ($ATT["type"]=="link") {
			if (is_youtube_video($ATT["path"])) {
				$ATT["open"]="in";
				$ATT["info"]="youtube";
				$ATT["ytid"]=yt_url2id($ATT["path"]);            
            } 
            $wwID=is_wordwall($ATT["path"]);
			if ($wwID) {
				$ATT["open"]="in";
				$ATT["info"]="wordwall";
				$ATT["wwid"]=$wwID;  
            }            
            
		}		
		$ATT["test"]=$ATT["scene"]." vs ".$ST["scene"];
		if ($ATT["scene"]==$ST["scene"]){
            $ST["A"][]=$ATT;
        } else {
            //$ST["compulsoryAttachments"]=0;  //TOLTO
            $ATT["test"].=" caseNO";
        }
		//$ST[	$ATT["scene"]		][]=$ATT;
	}
	$G["AB"][			$ST["scene"].$ST["step"]				]=$stepC	;
	
	$G["ss"][		$ST["scene"]	][		($ST["step"]-1)		]=$ST;
	
	$G["s"][$stepC]=$ST;
	//echo "<pre>";print_r($ST);print_r($G);die;
	$stepC++;
}
$G["avatarsIds"]=array();
if ($G["s"]) foreach($G["s"] as $stepIndex => $step) {
	if ($step["avatar_id"]!=1000	&& 	!in_array($step["avatar_id"], $G["avatarsIds"])	) 	$G["avatarsIds"][]=$step["avatar_id"];
	
	//$O.='<div class="avatar_'.$step["avatar_id"].'_talk wait_S avatarSpriteTalkOff" ></div>';
}

//////////////////////// inizialize Match
if (!$_SESSION["idm_playing"]) {
	//sql_query("TRUNCATE `matches`");sql_query("TRUNCATE `matches_step`");
	$G["Q1"]="INSERT INTO `matches` (`gameId`, `uid`, `start`) VALUES (".$G["gameId"].", ".$_SESSION["uid"].", ".C_TIME.")";
	sql_query($G["Q1"]);
	if (sql_error()) {
		echo sql_error();
		die();
	}
	$G["idm"]=sql_id();	
	
}

///////////////////////////

$G["ss"]["A"][	sizeof ($G["ss"]["A"])-1				]["avatar_sentence"]=turnLinksOn(		$G["ss"]["A"][	sizeof ($G["ss"]["A"])-1				]["avatar_sentence"]		);
$G["ss"]["A"][	sizeof ($G["ss"]["A"])-2				]["avatar_sentence"]=turnLinksOn(		$G["ss"]["A"][	sizeof ($G["ss"]["A"])-2				]["avatar_sentence"]		);

//////////////////////////

$HEAD_ADD.='<script type="text/javascript">';
$HEAD_ADD.='var G='.json_encode($G).';';
$HEAD_ADD.='</script>';


$AUDIOHTML.='<audio  preload="auto" class="aud" id="aansw" src="" type="audio/mpeg" controls="controls"></audio>'; 
$AUDIOHTML.='<audio  preload="auto" class="aud" id="fx1" src="/data/audiosys/Device-start-up-sound-effect.mp3" type="audio/mpeg" controls="controls"></audio>'; 
$AUDIOHTML.='<audio  preload="auto" class="aud" id="fx2" src="/data/audiosys/Mario_Jumping-Mike_Koenig-989896458.mp3" type="audio/mpeg" controls="controls"></audio>'; 

//$AUDIOHTML.= '<audio  loop preload="auto" class="aud" id="auback" src="/data/audiosys/playerloop02.mp3" type="audio/mpeg"></audio>'; 
$totalSize=0;



function getVideoProp($path2Video, $remote=false){
    
    require_once($_SERVER['DOCUMENT_ROOT']."/config/plugin/getID3-master/getid3/getid3.php");
    
    if (!$remote){
        $getID3 = new getID3();
        $fileinfo = $getID3->analyze($path2Video);
        return $fileinfo["video"];
    }else{
        return;
        //return "remote";
        if ($fp_remote = fopen($path2Video, 'rb')) {
            $localtempfilename = tempnam('/tmp', 'getID3');
            if ($fp_local = fopen($localtempfilename, 'wb')) {
                while ($buffer = fread($fp_remote, 8192)) {
                    fwrite($fp_local, $buffer);
                }
                fclose($fp_local);
                // Initialize getID3 engine
                $getID3 = new getID3;
                $fileinfo = $getID3->analyze($localtempfilename);
                // Delete temporary file
                unlink($localtempfilename);
                
            }
            fclose($fp_remote);
            return $fileinfo["video"];
        }
        
    }
}

//$O="<pre>".print_r($D,true)."</pre>";$O.="<pre>".print_r($D,true)."</pre>";
//echo "<pre>";print_r($G);die;














?>