<?php
error_reporting(E_ALL ^ E_NOTICE);ini_set("display_errors",1);
// https://to.sgameup.com/_m/ajax.generatePlayerAudio.php?gameId=226
// https://to.sgameup.com/_m/ajax.generatePlayerAudio.php?gameId=226&force=1&log=1&NOAUDIOGENERATION

// https://to.sgameup.com/_m/ajax.generatePlayerAudio.php?gameId=226&NOAUDIOGENERATION=1

//if (!$IDM || !is_numeric($IDM)) header('Content-Type: application/json; charset=utf-8');

$_GET["force"]=1; // GENERA SEMPRE!

include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
if (!$_SESSION["uid"]) {
	$D["response"]=false;
	$D["reason"]="mm sounds like you're not logged at the moment";
	if (!$IDM && !is_numeric($IDM)) echo json_encode($D);
    else return $generatePlayerAudio=$D;
    
	return;
}
if ($gameIdA && is_numeric($gameIdA))  {
    $T=sql_queryt("SELECT gameId FROM matches WHERE idm=$IDM");
    $D["gameId"]=$gameIdA;
    
}else{
    $D=$_GET;// debug
    $D=array_map("trim",$D);
}
 
$D["response"]=true;

if (!$D["gameId"]  || !is_numeric($D["gameId"])   ) {
	$D["response"]=false;
	$D["reason"]="no game";
	echo json_encode($D);
	return;
}
$gid=$D["gameId"];
$gidPre=$D["gameId"]."_answ";

//G.status,
$D["Q"]="SELECT idStep, concat (step, scene) SS, step, scene, answer_1,answer_2,answer_3 ,answer_4,  G.language,S.avatar_id, 
A.voiceId_it,
A.voiceId_en   

FROM 
games_steps S
RIGHT JOIN games G ON G.gameId=S.gameId
RIGHT JOIN avatars  A ON A.id=S.avatar_id
WHERE 

(answer_1 is not null OR  answer_2 is not null OR answer_3 is not null OR answer_4 is not null )
AND 
audioAnwers IS NULL AND 
S.gameId= ".db_string($D["gameId"])." order BY step ASC, scene ASC
"; //

if ($_GET["force"]) $D["Q"]=str_replace("audioAnwers IS NULL AND ", "", $D["Q"]);
$D["avatar_voices_used"]=array();
//$D["Qe"]=sql_error();
$SQ=sql_query($D["Q"]);
$Kstep=0;
while (	$S=sql_assoc($SQ)	){
	$Kstep++;
    $D["language"]=$S["language"];if ($D["language"]!="en" && $D["language"]!="it") $D["language"]!="en";
   // unset ($S["voiceId_".])
    $D["avatar_voices_used"][]=$S["voiceId_".$S["language"]] ;//        $S["avatar_id"];
    
    unset ( $S["step"], $S["scene"], $S["language"], $S["avatar_id"]);
    
    $S["audioAnwers"]=array(
        $gidPre."_".$S["SS"]."_1M", $gidPre."_".$S["SS"]."_1F",
        $gidPre."_".$S["SS"]."_2M", $gidPre."_".$S["SS"]."_2F",
        $gidPre."_".$S["SS"]."_3M", $gidPre."_".$S["SS"]."_3F",
        $gidPre."_".$S["SS"]."_4M", $gidPre."_".$S["SS"]."_4F",
    );
    if (is_null($S["answer_4"])) {
        unset($S["answer_4"]);
        unset ($S["audioAnwers"][6], $S["audioAnwers"][7] );
    
    }
        
	$D["s"][	$S["SS"]	]=$S;
    unset ($D["s"][	$S["SS"]	] ["SS"]);
}

if (!$Kstep){
    if (!$D["log"]) unset ($D["Q"],$D["avatar_voices_used"]);

	$D["response"]=true;
	$D["reason"]="nothing to generate";
    if (!$IDM || !is_numeric($IDM)) echo  json_encode($D);
    else return $generatePlayerAudio=$D ;    

	return;
}


$D["avatar_voices_used"]=array_unique($D["avatar_voices_used"]);


// select right avatar voice m & F
$D["avatar_id_M_dataQ"]=("SELECT id, voiceId_".$D["language"]." from avatars where sex='m' AND voiceId_".$D["language"]." not in (".implode(", ",$D["avatar_voices_used"] ).") ");
$D["avatar_id_F_dataQ"]=("SELECT id, voiceId_".$D["language"]." from avatars where sex='f' AND voiceId_".$D["language"]." not in (".implode(", ",$D["avatar_voices_used"] ).") ");


$D["avatar_id_M_data"]=sql_queryt("SELECT id, voiceId_".$D["language"]." from avatars where sex='m' AND voiceId_".$D["language"]." not in (".implode(", ",$D["avatar_voices_used"] ).") ");
$D["avatar_id_F_data"]=sql_queryt("SELECT id, voiceId_".$D["language"]." from avatars where sex='f' AND voiceId_".$D["language"]." not in (".implode(", ",$D["avatar_voices_used"] ).") ");

$D["voice_id_M"]=$D["avatar_id_M_data"]["voiceId_".$D["language"]];
if (!$D["voice_id_M"]){
    $dvM=sql_queryt("select voiceId_".$D["language"]." from avatars where sex='m' ORDER BY id DESC limit 0,1"); 
    $D["voice_id_M"]=$dvM["voiceId_".$D["language"]];
}

$D["voice_id_F"]=$D["avatar_id_F_data"]["voiceId_".$D["language"]];
if (!$D["voice_id_F"]){
    $dvF=sql_queryt("select voiceId_".$D["language"]." from avatars WHERE sex='f' ORDER BY id DESC limit 0,1"); 
    $D["voice_id_F"]=$dvF["voiceId_".$D["language"]];
}

// voice id data
$D["voiceSQ"]=("select gender, id, voiceName, langCode from TTSvoices WHERE id in (".$D["voice_id_F"].", ".$D["voice_id_M"].")");
$SQv=sql_query("select gender,id, voiceName, langCode from TTSvoices WHERE id in (".$D["voice_id_F"].", ".$D["voice_id_M"].")");
if (sql_error()){
	$D["response"]=false;
	$D["reason"]="error:".sql_error();
	echo json_encode($D);
	return;
}

while (	$AA=sql_assoc($SQv)	){
    $D["voices"][ $AA["id"]  ]=array( "gender"=>$AA["gender"],"voiceName"=>$AA["voiceName"],"langCode"=>$AA["langCode"]  );
}




$totalGenerated=0;
////////////////////////////////////////////////////////// generate audio and update step

include_once($_SERVER['DOCUMENT_ROOT']."/config/php.function.tts.php");

$sexR=array("MALE", "FEMALE");
$voiceIdSex=array($D["voice_id_M"],$D["voice_id_F"]);
$sexC=0;
foreach($D["s"] as $S => $V){
    
    $R=array();
    
    $z=0;

    
    foreach($V["audioAnwers"] as $s => $c){
        $voiceID=$voiceIdSex[$sexC];
        //$voiceIDTEST="$sexC ".$voiceIdSex[$sexC];
    
        $z++; $text2audio=false;
        $file=$c.".mp3";
        if ($z==1 ||$z==2 ) $text2audio=$V["answer_1"];
        if ($z==3 ||$z==4 ) $text2audio=$V["answer_2"];
        if ($z==5 ||$z==6 ) $text2audio=$V["answer_3"];
        if ($z==7 ||$z==8 ) $text2audio=$V["answer_4"];
        
        //////////////////////////////
        
        if (!$_GET["NOAUDIOGENERATION"]) {
            $audioFile=getSound($text2audio,$D["voices"][$voiceID]["langCode"],$D["voices"][$voiceID]["voiceName"]);

            if (!$audioFile){
                $R["errorAudioFile"][]=$text2audio.",".$D["voices"][$voiceID]["langCode"].",".$D["voices"][$voiceID]["voiceName"];
                //$G["response"]=false;$G["reason"]="there has been a problem generating the audio file";echo json_encode($G);return;

            }else{
                file_put_contents($_SERVER['DOCUMENT_ROOT']. '/data/audio/'.$file, $audioFile       );        
            }
        }
        
  
        //
        $R[$file]="$z) ".$text2audio." sex:".$sexC." ".$sexR[$sexC]." voiceID=".$voiceID. " call: ".$D["voices"][$voiceID]["voiceName"].", ".$D["voices"][$voiceID]["langCode"]." ";
        
        $sexC++; if ($sexC>1) $sexC=0;
        
        
     $totalGenerated++;   
    }
    
    $R["q"]="UPDATE `games_steps` SET `audioAnwers` = '".db_string(implode(",",$V["audioAnwers"]))."' 
    , 	audioAnwersUpdate=".C_TIME."
    WHERE `games_steps`.`idStep` = ".$V["idStep"];
    sql_query($R["q"]);
    $D["s"][$S]["___ERRORR___"]=sql_error();
    $D["s"][$S]["report"]=$R;
    
}


//unset ($D[s]);
//echo json_encode($D);

if ($D["log"]) 
    echo json_encode($D);

else
    if (!$IDM || !is_numeric($IDM)) echo  json_encode(array("response"=>true, "total generated"=>$totalGenerated)    );
    else return $generatePlayerAudio=array("response"=>true, "total generated"=>$totalGenerated) ;


?>