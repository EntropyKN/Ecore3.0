<?php // MOBILE E SAFARI
$PRELOAD=true;

$MP4RND="";
//$MP4RND="?".rand(1, 18000);
$MP4RND="?nochachepliz";
$HEAD_ADD.='<script id="MathJax-script" async src="/js/plugins/mathJax-es5/tex-chtml.js"></script><script src="/js/plugins/mjxgui.js?'.PAGE_RANDOM.'"></script>';

//if ($PRELOAD) $JSA[]=''.C_DIR.'/_m/player01/preload.js?'.PAGE_RANDOM;

//$JSA[]='/js/plugins/seamlessloop.js';
$JSA[]=''.C_DIR.'/_m/player04/player.js?'.PAGE_RANDOM;
//$CSSA[]=C_PROTOCAL.'://fonts.googleapis.com/css?family=Cherry+Cream+Soda'; //Anton|Lalezar

$CSSA[]=''.C_DIR.'/_m/player04/player.css?'.PAGE_RANDOM;
$CSSA[]=''.C_DIR.'/_m/avatars.css.php?screenW=1000'; //<--!
//$CSSA[]=''.C_DIR.'/_m/player04/endCredits.css?'.PAGE_RANDOM;
require_once("data.inc.php");
############## font
if ($G["balloonFont"] )
     $HEAD_ADD.='
<style>
@font-face {
  font-family: "baloonFont";
  src: url("/data/fonts/'.$G["balloonFont"].'")    format(\''.$G["fformat"].'\');
}
#balloon{
    font-family: \'baloonFont\';
    font-size: '.$G["balloonSize"].'px!important;
}
</style>';

$page["titlePre"]=$G['title']." - ";
##################################
/*
//if ($PRELOAD){
	//$PL='<div id="preload">';
		$PL.='<div id="preloadin">';
			$PL.='<div class="container">';
				$PL.='<div class="progress">';
					$PL.='<div id="progress" class="progress-bar active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%';
					$PL.='</div>';
				$PL.='</div>';
				
			   $PL.=' <div class="progressTc">';
					$PL.='<div id="progressT" class="progress-bar active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%';
					$PL.='</div>';
				$PL.='</div>';    
			$PL.='</div>';	
		$PL.="</div>";
	//$PL.="</div>";
	//$O.=$PL;
//}
*/
$O.='<div id="mask" class="opacity50"></div>';
$O.='<div id="core" data-device="'.deviceType().'">';

require_once(C_ROOT."/_m/header/headerPlayer.inc.php");

$O.='<div id="player">'; // style="background: rgba(0, 0, 0, 0) url('.$imgOffice.') no-repeat scroll 0 0;"
	$O.='<div id="playmask"></div>'; 
		$O.='<div id="attachViewer"><div id="attachViewerClose">X '.L_close.'</div>'; 
		$O.='<div id="attachViewerIN"></div>';
		//$O.='<iframe id="ytplayer" width="1000" height="562.50" src="https://www.youtube.com/embed/OkQlrIQhUMQ?autoplay=0" frameborder="0"/></iframe>'; 
	$O.='</div>'; 
	
	//;
	
	$O.='<div id="attachShow">';
	  $O.='<span id="attachShowMask">';
		$O.='<div id="compulsoyNotAt" class="attachTxt">'.L_please_take_a_look_at_the_following_attachments_before_answering.':</div>';
		$O.='<div id="compulsoyAtt" class="attachTxt">'.L_you_cant_answer_before_reading_the_following_attachments.':</div>';
		$O.='<div id="attachShowImg">';
			$O.='<a class="atta" data-read="0" target="_blank" id="att_1" href="#"><img class="attImg" src="/img/ico/link60.png" alt="" title="a" /><div class="view"></div></a>';
			$O.='<a class="atta" data-read="0" target="_blank" id="att_2" href="#" ><img class="attImg" src="/img/ico/attach60.png" alt="" title="v" /><div class="view"></div></a>';
			$O.='<a class="atta" data-read="0" target="_blank" id="att_3" href="#"><img class="attImg" src="/img/ico/link60.png" alt="" title="a" /><div class="view"></div></a>';
			$O.='<a class="atta" data-read="0" target="_blank" id="att_4" href="#" ><img class="attImg" src="/img/ico/attach60.png" alt="" title="v" /><div class="view"></div></a>';
			$O.='<a class="atta" data-read="0" target="_blank" id="att_5" href="#" ><img class="attImg" src="/img/ico/attach60.png" alt="" title="v" /><div class="view"></div></a>';
		$O.='</div>'; 
	  $O.='</span>';
	$O.='</div>'; 	
	$O.='<div id="debriefsplash">';
		$O.='<img id="debriefsplashimg" src="img/terraFinalSplash.jpg" width="100%" alt="" />';
	///
		$O.='<div class="debriefsplashT">';
			$O.=$G['title'];
		$O.="</div>";
		$O.='<div class="debriefsplashTT">';
			$O.=L_end_of_match;
		$O.="</div>";
		$O.='<div class="debriefsplashTTT">';
		$O.='<div id="debevaulating">';
			$O.='<img id="debevaulatingImg" src="/img/loader43x11.gif" alt="" /><br />';
			$O.="<span>";
			$O.=L_evaluating_your_performance;
			$O.="</span>";	
		$O.="</div>";
			$O.='<a href="/?debrief/'.$G["idm"].'" class="btn noselect">';	//idm
				$O.=L_the_complete_results;
			$O.="</a>";
		$O.="</div>";	


	$O.="</div>"; // splash end

///////////////
if ($G["endCredits"] )
    $O.='<div id="endCredits"><div id="gradientG"></div><div id="titles"><div id="titlecontent">'.$G["endCredits"].'</div></div></div>';
////////////////


	require_once("explain.inc.php");

$O.='<div id="playerNover">'; 
	if ($G["avatarsIds"]) foreach($G["avatarsIds"] as $k => $avid) {
		$O.='<div class="avatar_'.$avid.'_talk wait_S avatarSpriteTalkOff" ></div>';
		$O.='<img class="preload" src="/data/avatar_prev/1/'.$avid.'_10Kx1098_talk.png" alt="">';
	}

	$O.='<div id="balloon"><span>...</span><img src="/img/pointer_left.png" id="leftArrow" alt="" /><img src="/img/pointer_right.png" id="rightArrow" alt="" /></div>';
	$O.='<div  id="avatarSpriteTalk" class="avatar_0_talk wait_S" ></div>';
	$O.='<div  id="avatarSprite" data-currentAvatar="0" data-pos="0,0" data-currentSize="S" class="avatar_0 wait_S" title=""></div>';
	
	$O.='<img id="scenario" src="'.$G["s"][0]["scenario"].'" width="1000" alt="" />	';


	
	$O.="</div>";//playerNover
	require_once("console.inc.php");
$O.="</div>";//player

$O.=$AUDIOHTML;

$O.='<div class="clear"></div>';
$O.='<input type="text" value="0" id="currentscene" >';
/*if ($_SESSION["uid"]==3 || $_SESSION["uid"]==58) {
    $O.="<pre>".print_r($_SESSION,true)."</pre>";
    $O.="<pre>".print_r($G,true)."</pre>";
}
*/
$O.="
<br />
<br />
<br />
<br />
<br />

<br /><br /><br />
"; 


$O.="</div>";//core

?>
