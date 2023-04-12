<?php 
////////////////////////////

// https://to.sgameup.com/_m/ajax.generatePlayerAudio.php?gameId=226

$IDM=$DIRA[2];



if (!$IDM || !is_numeric($IDM))  die("this match is not over yet");

include_once($_SERVER['DOCUMENT_ROOT']."/config/php.function.games.php");
$D=finalCalc2($DIRA[2],false);
$D["idm"]=$DIRA[2];
if (!$D["match"]["end"])  die("this match is not over yet");
$HEAD_ADD.='<script type="text/javascript">';
$HEAD_ADD.='var S='.json_encode($D["s"]).';';
$HEAD_ADD.='</script>';




///////////////////////////// graph data
if (!$D["game"]["dontShowDebriefScore"]) {

    $D["gdata"]=array();
    foreach($D["s"] as $k => $v) {
        //$O.="$k $v <br />";
        
        $D["sss"][]=$v;
        if ($k<sizeof($D["s"])-1)
        $D["gdata"][]=array(
            "name"=>floatval( ($k+1)),
            "steps"=>$v["scorePercent"],
            "Q"=>text_cut($v["question"], 72),
            //"pictureSettings"=>array("src"=>"/data/scenarios/".$v["scenario_id"]."_640.jpg")
            "winningPercStart"=>$D["game"]["winningPercStart"]
        );
    }

    $HEAD_ADD.='<script type="text/javascript">';
    $HEAD_ADD.='var data='.json_encode(( $D["gdata"])).';';
    $HEAD_ADD.='</script>';
}

///////////////////////////// cambiare
$commentBasic=array(
    "L1"=>"L1",// 0.00  12.49
    "L2"=>"L2", // >=12.50
    "L3"=>"L3",   //>=25.00 
    "L4"=>"L4",   // >=37.50

    "W1"=> "W1", //>=50
    "W2"=> "W2", // >=62.5
    "W3"=> "W3",   // >=75.00
    "W4"=> "W4",   //>=87.50
    );



if ($D["game"]["winningPercStart"]==50.00) 
    $commentBasic=array(
        "L1"=>L_L1_SHORT_COMMENT,// 0.00  12.49
        "L2"=>L_L2_SHORT_COMMENT, // >=12.50
        "L3"=>L_L3_SHORT_COMMENT,   //>=25.00 
        "L4"=>L_L4_SHORT_COMMENT,   // >=37.50

        "W1"=>L_W1_SHORT_COMMENT, //>=50
        "W2"=>L_W2_SHORT_COMMENT, // >=62.50
        "W3"=>L_W3_SHORT_COMMENT,   // >=75.00
        "W4"=>L_W4_SHORT_COMMENT,   //>=87.50
    );

if ($D["game"]["winningPercStart"]==62.50) 
    $commentBasic=array(
        "L1"=>L_L1_SHORT_COMMENT,// 0.00  12.49
        "L2"=>L_L2_SHORT_COMMENT, // >=12.50
        "L3"=>L_L2_SHORT_COMMENT,   //>=25.00 
        "L4"=>L_L3_SHORT_COMMENT,   // >=37.50

        "W1"=>L_L4_SHORT_COMMENT, //>=50
        "W2"=>L_W1_SHORT_COMMENT, // >=62.50
        "W3"=>L_W2_SHORT_COMMENT,   // >=75.00
        "W4"=>L_W4_SHORT_COMMENT,   //>=87.50
    );

if ($D["game"]["winningPercStart"]==75.00) 
    $commentBasic=array(
        "L1"=>L_L1_SHORT_COMMENT,// 0.00  12.49
        "L2"=>L_L2_SHORT_COMMENT, // >=12.50
        "L3"=>L_L2_SHORT_COMMENT,   //>=25.00 
        "L4"=>L_L3_SHORT_COMMENT,   // >=37.50

        "W1"=>L_L3_SHORT_COMMENT, //>=50
        "W2"=>L_L4_SHORT_COMMENT, // >=62.50
        "W3"=>L_W1_SHORT_COMMENT,   // >=75.00
        "W4"=>L_W4_SHORT_COMMENT,   //>=87.50
    );
if ($D["game"]["winningPercStart"]==87.50) 
    $commentBasic=array(
        "L1"=>L_L1_SHORT_COMMENT,// 0.00  12.49
        "L2"=>L_L2_SHORT_COMMENT, // >=12.50
        "L3"=>L_L2_SHORT_COMMENT,   //>=25.00 
        "L4"=>L_L3_SHORT_COMMENT,   // >=37.50

        "W1"=>L_L3_SHORT_COMMENT, //>=50
        "W2"=>L_L3_SHORT_COMMENT, // >=62.50
        "W3"=>L_L4_SHORT_COMMENT,   // >=75.00
        "W4"=>L_W4_SHORT_COMMENT,   //>=87.50
    );

///////////////////////
$NOTE="";
if (!$D["game"]["dontShowDebriefScore"]) {
    $NOTE.="<span class=\"lll\">".L_the_scale_of_values_varies_from_0_to_100_percent."</span> ";
    
    $the_winning_area_goes=str_replace(
    "#X#",
    str_replace(".00","", $D["game"]["winningPercStart"])  ."%"
    , L_the_winning_area_goes_from_X_to_Y);
    
    //$the_winning_area_goes=str_replace("#X#","50%", $the_winning_area_goes);
    $the_winning_area_goes=str_replace("#Y#","100%", $the_winning_area_goes);

    $NOTE.="<span class=\"lll\">".$the_winning_area_goes."</span> ";


    $NOTE.="<span class=\"lll\">";
        $NOTE.="<strong>";
        $NOTE.=L_reached_score;
        $NOTE.="</strong>";
        $NOTE.=": ";
        $NOTE.=''.$D["scorePercent"].'%';
        //$NOTE.=''.str_replace(".00","", $D["scorePercent"]).'%';
    $NOTE.="</span>";

}



$NOTE.="<span class=\"lll\">";
	$NOTE.="<strong>";
	$NOTE.=L_total_time_played;
	$NOTE.="</strong>";
	$NOTE.=": ";
	$NOTE.=getElapsedTimeString($D["match"]["end"]-$D["match"]["start"]);
$NOTE.="</span>";


//////////////////////
$CSSA[]=''.C_DIR.'/_m/debrief/response.css?'.PAGE_RANDOM;
$CSSA[]=''.C_DIR.'/_m/avatars.css.php?screenW=1000'; //<--!

//$CSSA[]='//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
//$CSSA[]='https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.min.css';
$CSSA[]='/js/plugins/jquery-ui/1.13.2/jquery-ui.min.css';

//$JSA[]='https://code.jquery.com/ui/1.13.2/jquery-ui.js';
//$JSA[]='https://code.jquery.com/ui/1.13.2/jquery-ui.min.js';
$JSA[]='/js/plugins/jquery-ui/1.13.2/jquery-ui.min.js';


//$JSA[]='https://cdn.amcharts.com/lib/5/index.js';
//$JSA[]='https://cdn.amcharts.com/lib/5/xy.js';
//$JSA[]='https://cdn.amcharts.com/lib/5/themes/Animated.js';
if (!$D["game"]["dontShowDebriefScore"]) {
    $JSA[]='/js/plugins/amcharts.com/5/index.js';
    $JSA[]='/js/plugins/amcharts.com/5/xy.js';
    $JSA[]='/js/plugins/amcharts.com/5/Animated.js';
}
// Nel Match Movie vuoi che la tua voce sia maschile o femminile?<small>le voci non binary non sono ancora disponibili</small>
$HEAD_ADD.='<script type="text/javascript">var L_CHOICE_VOICE_TEXT="'.L_CHOICE_VOICE_TEXT.'";var L_feminine="'.L_feminine.'";var L_masculine="'.L_masculine.'";</script>';

$JSA[]=''.C_DIR.'/_m/debrief/debrief.js?'.PAGE_RANDOM;
//$JSA[]=''.C_DIR.'/_m/debrief/graph.js?'.PAGE_RANDOM;
if (!$D["game"]["dontShowDebriefScore"]) $JSA[]=''.C_DIR.'/_m/debrief/graphH.js?'.PAGE_RANDOM;


$O.='<div id="mask" class="opacity50"></div>';
$O.='<div id="dialog" title=""></div>';

$sexSession=$_SESSION["sex"];
if ($sexSession=="female") $sexSession="F";
if ($sexSession=="female") $sexSession="M";
if (!$sexSession) $sexSession="na";

////////////////////// player
$O.='<div id="player" data-sexSession="'.$sexSession.'" data-playing="0" data-close="0" data-playing="0"><div id="closeP" data-play="videoc1">X</div>'; // style="background: rgba(0, 0, 0, 0) url('.$imgOffice.') no-repeat scroll 0 0;"
	$O.='<div id="playmask"></div>';
    $O.='<div id="playerTitles"><span class="cell"><li id="li1">'.L_end_of_match.'</li><li id="li2"><a class="playMovie" href="#">'.L_watch_again.'</a></li></span></div>';
    $O.='<div id="playerNover">'; 
	if ($D["avatarsIds"]) foreach($D["avatarsIds"] as $k => $avid) {
		$O.='<div class="avatar_'.$avid.'_talk wait_S avatarSpriteTalkOff" ></div>';
		$O.='<img class="preload" src="/data/avatar_prev/1/'.$avid.'_10Kx1098_talk.png" alt="">';
	}

	$O.='<div id="balloon"><span>...</span><img src="/img/pointer_left.png" id="leftArrow" alt="" /><img src="/img/pointer_right.png" id="rightArrow" alt="" /></div>';
	$O.='<div  id="avatarSpriteTalk" class="avatar_0_talk wait_S" ></div>';
	$O.='<div  id="avatarSprite" data-currentAvatar="0" data-pos="0,0" data-currentSize="S" class="avatar_0 wait_S" title=""></div>';
	
	$O.='<img id="scenario" src="'.$G["s"][0]["scenario"].'" width="1000" alt="" />	';


	
	$O.="</div>";//playerNover

$O.="</div>";//player


$AUDIOHTML.='<audio  preload="auto" class="aud" id="aask" src="" type="audio/mpeg" controls="controls"></audio>'; 
$AUDIOHTML.='<audio  preload="auto" class="aud" id="aansw" src="" type="audio/mpeg" controls="controls"></audio>'; 
$AUDIOHTML.='<audio  preload="auto" class="aud" id="fx1" src="/data/audiosys/Device-start-up-sound-effect.mp3" type="audio/mpeg" controls="controls"></audio>'; 
$AUDIOHTML.='<audio  preload="auto" class="aud" id="fx2" src="/data/audiosys/Mario_Jumping-Mike_Koenig-989896458.mp3" type="audio/mpeg" controls="controls"></audio>'; 

$O.=$AUDIOHTML;

$O.='<div class="clear"></div>';


//////////////////////
$O.='<div id="core" data-gameId="'.$gameId.'">';

require_once(C_ROOT."/_m/header/header.inc.php");
$O.='<div id="coreIn">';
	


/////////////////////////
	$O.="<span class=\"note\">$NOTE</span>";
	
	$O.='<div class="titleD">';
		$O.=$D["game"]["title"];
	$O.="</div>";

    // credits:
    $G["credits"]=creditsFromDescription($D["game"]["Description"]);
    $G["Description"]=delete_all_between("<credits>", "</credits>",$D["game"]["Description"] );
    $G["Description"]=strip_tags($D["game"]["Description"]);    
    if ($G["credits"]) $O.=$G["credits"]."<br />";
    
	$O.='<div class="subtitle">';
		$O.=L_session_date." ";
		// timestamp2red($ts, $mode="long", $lang="it")
		$O.=L_from." ".timestamp2red($D["match"]["start"], $mode="long",$_SESSION["lang"]);
		$O.=" ".L_to." "." ".timestamp2red($D["match"]["end"], $mode="long", $_SESSION["lang"]);
		//;
	$O.="</div>";
	
	
	

$page["titlePre"]=L_game_debriefing." - ".$D["game"]['title']." ".timestamp2red($D["match"]["start"], "long", $_SESSION["lang"])." - ";

/////////////////////////

$O.='<div class="titleRes">'.$commentBasic[				$D["spread"]["spread"]			] ;
if (!$D["game"]["dontShowDebriefScore"]) $O.=': '.$D["scorePercent"].'%';
$O.='</div>';

$O.='<div class="commentQ">'.$D["comment"]	.'</div>';

//////////// graph
if (!$D["game"]["dontShowDebriefScore"]) {
    $O.='<div id="chartdiv" style="margin:20px 0;width: 100%;height:236px;"></div>';
    $O.='<div class="clear"></div>';
}else{

    $O.='<div class="clear" style="margin:25px 0 0 0"></div>';
}
//////////////////////////////////////////// match movie only if the game's status is playable
if ($D["game"]["status"]=="playable" || $D["gameId"]==226) {
	$O.= '<a id="playMovieFooter" class="playMovie" href="#">';
        if (!$D["game"]["dontShowDebriefScore"]) $O.='<span id="mask1"></span>';
		$O.='<span class="watchtext">'.L_watch_the_full_movie_of_your_match.'</span>';
		$O.='<img id="hollywood" src="/img/moviecover860x120dark.png" class="opacity75" alt="" />';
		
	$O.= '</a>';
}else{

    $O.='<div id="noMovieMatch">'.L_the_full_movie_of_your_match_will_be_avaible_when_the_game_will_be_playable.'</div>';

}

$O.='</div>';//coreIn
$O.='</div>';//core
$O.='<div class="clear"></div>';

if ($_COOKIE["debug"]
){
	$O.="<pre>";
    //$O.=print_r($_SESSION, true);
	$O.=print_r($D, true);
	$O.="</pre>";
}

$O.="<br /><br /><br /><br /><br /><br /><br /><br /></div>";//


?>