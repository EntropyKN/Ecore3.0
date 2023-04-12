<?php

$F.='<div id="menuFixedCover">';
$F.='</div>';	

//$F.='<div id="core">'; // closed in footer	

$F.='<div id="menuFixed">';
		if (loggedIn()	 ) $F.='<a class="hd_menuR appmemu opacityMenu" id="hd_nav_settings" href="#"><img id="hd_nav_settings_img" src="/img/menu/appWhite32x26.png" width="32" height="26" alt="" /></a>';
		$F.='<a href="/" class="logo">';
			$F.='<img src="/img/logo/logoStoryGame1.png" width="188" height="auto" alt="" />';
		$F.='</a>';
		$logoClaimIn="";
		if ($pageID=="home") 	$logoClaimIn=L_dashboard;
		//if ($pageID=="insights") 	$logoClaimIn=L_insights;
		//if ($pageID=="groups") 	$logoClaimIn=L_groups;
		
		if ($pageID=="editor") 	{
			$logoClaimIn=L_editor." <span>1/2</span>";
			if ($editorstep)	$logoClaimIn=L_editor." <span>2/2</span>";
			$F.='<span id="nowEditing">'.L_no_title.'</span><div id="saving">'.L_saving.'</div>';
		}
		/*
		if ($_SESSION["ulevel"]>0 ) {
			include ("search.inc.php");		
		}
		*/
		if ($logoClaimIn && $pageID!="player") $F.='<span class="logoClaimIn">'.$logoClaimIn.'</span>';
		if ($pageID!="login" && $pageID!="editor" && $pageID!="player" && $_SESSION["shown_name"]){
			
			$F.='<div id="personalityC">';
				$F.='<div id="personality">';
				$F.=$_SESSION["shown_name"];
				$F.='</div>';
				$F.='<div id="personalityS">';
						$F.=ULEV;
				$F.='</div>';
//			$F.="personalityC";
			$F.='</div>';		
		}
		
		
		// menus
		if (loggedIn()	 ) {
		$F.='<div id="hd_settings_box_cont" class="boxfb">';
			$F.='<div class="pointer_up"></div>';
			$F.='<div id="hd_settings_box">';
				include ("settingBox.inc.php");
			$F.='</div>';
		$F.='</div>';	
		}
$F.='</div>';

/*if ($_COOKIE["debug"]){ 
	if (!$_SESSION['emailvalidate']) {
		$JSA[]='/'.C_DIR.'_m/login/resendSignupEmail.js?123';
	
		$F.='<div id="adviceArea">';
			$F.='<div id="adviceAreaIn">';
				$F.='<div class="adviceTitle">'.L_please_confirm_your_email_by_clicking_on_the_link_we_sent_you.'</div>';
				$F.='<div class="adviceSubTitle">';
					$F.="<a id=\"resendSignupEmail\" href=\"#\">".L_send_me_the_email_again."</a>";
					//data-email=\"".$_SESSION["email"]."\" data-name=\"".urlencode($_SESSION["shown_name"])."\" 
					$F.=" (".$_SESSION["email"].")";
				$F.='</div>';
				
			$F.='</div>';
		$F.='</div>';
	}
}
*/		


//			$F.=print_r($_SESSION,true);
//	$F.=print_r($L,true);
		

$O.=$F;


        ?>