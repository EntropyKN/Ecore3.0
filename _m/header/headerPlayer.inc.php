<?php

$F.='<div id="menuFixed">';
		$F.='<div id="saving">'.L_thinking_over.'</div>';

		
		$F.='<a class="hd_menuR appmemu opacityMenu" id="hd_nav_settings" href="#"><img id="hd_nav_settings_img" src="/img/menu/app32x26.png" width="32" height="26" alt="" /></a>';
/*		$F.='<a title="back to DashBoard" href="/" class="logoCont opacityMenu tip">';
			$F.='<img id="logoOff" src="/img/hand32x32.png" width="32" height="32" alt="" />';
		$F.='</a>';*/
		

		
		$F.='<a title="'.L_show_last_exchange.'" href="#" class="showLastExc hd_menuR opacityMenu tip">';
			$F.='<img src="/img/menu/reload32x26.png" width="32" height="26" alt="" />';
		$F.='</a>';
		$F.='<a title="'.L_show_session_info.'" href="#" class="showInfo hd_menuR opacityMenu tip" data-show="1">';
			$F.='<img src="/img/menu/info32x26.png" width="32" height="26" alt="" />';
		$F.='</a>';

		/*$F.='<a href="#" id="musicoff" class="hd_menuR opacityMenu">'; //data-toff="'.L_music_off.'" data-ton="'.L_music_on.'"   title="'.L_music_off.'" 
			$F.='<img src="/img/menu/audioon32x26.png" data-s="on" width="32" height="26" alt="" />';
		$F.='</a>';		
		*/
		/////////////////////////////// menus
		$F.='<div id="hd_settings_box_cont" class="boxfb">';
			$F.='<div class="pointer_up"></div>';
			$F.='<div id="hd_settings_box">';
				include ("settingBox.inc.php");
			$F.='</div>';
		$F.='</div>';

$F.='</div>';
$O.=$F;


        ?>