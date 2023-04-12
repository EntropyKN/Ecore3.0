<?php

$JSA[]=''.C_DIR.'/_m/groups2.0/groups.js?'.PAGE_RANDOM;
$CSSA[]=''.C_DIR.'/_m/groups2.0/groups.css';

$page["titlePre"]=L_groups." ";

	require_once(C_ROOT."/config/php.function.group.php");
	
	// trasmit new group
	$idtrans=0;if ($DIRA[2] && is_numeric($DIRA[2]) ) $idtrans=$DIRA[2];
	$tsaved=0;if ($DIRA[3] && is_numeric($DIRA[3]) ) $tsaved=date("H:i",$DIRA[3]);
	///

	$D=getGroup(0);
$O.='<div id="mask" class="opacity50"></div>';
$O.='<div id="core" data-idtrans="'.$idtrans.'" data-tsaved="'.$tsaved.'">';
	require_once(C_ROOT."/_m/header/header.inc.php");

	$O.='<div id="coreIn">';


$O.='<img id="bigicon" src="/img/ico/groupsImage.png" width="205" height="159" alt="" />';

################## FORM
require_once(C_ROOT."/_m//groups2.0/data.inc.php");
$s=0;
########### LIST
$O.='<div id="row'.$s.'" class="row rowHead">';
	$O.='<div id="A'.$s.'" class="A">';
		$O.=L_group;
	$O.="</div>";
	$O.='<div id="B'.$s.'" class="A B">';
		$O.=L_users;
	$O.="</div>";
	$O.='<div id="C'.$s.'" class="A B">';
		$O.=L_games;
	$O.="</div>";
$O.="</div>";


	$O.='<div id="listContainer">';
// header



	

if (!empty($D["d"]))  {
	foreach( $D["d"] as $k => $v ) {
	$id=$v["idgroup"];
	
	$O.='<div id="row'.$id.'" class="row" >'; //data-js="'.$v["dataJs"].'"
		$O.='<div id="tit_'.$id.'" class="A" title="'.$v["description_it"].'">';
			$O.=Cut_str($v["name"], 34, "...")."";
		$O.="</div>";

		// users		
		//$title=print_r($v["users"], true);
		$O.='<div id="usrC_'.$id.'" class="A B" title="'.$v["userTitle"].'">';
			$O.=sizeOf($v["users"]);
		$O.="</div>";
		
		// gyms
		//$title=print_r($v["gyms"], true);
		$O.='<div id="gymC_'.$id.'" class="A B" title="'.$v["gymTitleWeb"].'">';
			$O.=sizeOf($v["gyms"]);
		$O.="</div>";
		
		
		// more?
		/*$O.='<div id="C'.$id.'" class="A B">';
			$O.="-";
		$O.="</div>";*/
			
	$O.="</div>";
	}
}else{
	$O.='<div class="nogroup" >';
	$O.=L_create_the_first_group;
	$O.="</div>";
}
$O.="</div>";//listcont


$O.='<div id="formG">';

	$O.='<div class="triangle new_group" id="formGmenuT">';
	$O.='<a href="#" class="" id="formGmenu">';
		$O.=L_new_group;
	$O.="</a>";
	$O.="</div>";




	$O.='<div id="titleG">';
		$O.=L_new_group;
	$O.="</div>";
	
	for ($f = 0; $f < sizeof($F1); $f++) {
	
		if ($F1t[$f]) {
			if ($F1[$f]!="insightesrCSV") {
				$O.='<div class="clear"></div>';
				$O.='<div class="field">';
					$O.=$F1t[$f];$O.=":";
					if ($F1[$f]=="name") $O.='<div id="'.$F1[$f].'_error" class="ERROR_MSG">'.L_the_groups_name_is_too_short.'</div>';
				$O.="</div>";
			}
		}
		
		$addClass="";
		if (!$F1Show[$f] && !$_COOKIE["debugx"]) $addClass="hide";
		
		if ($F1f[$f]=="input") $O.='<input id="'.$F1[$f].'" maxlength="60" value=""  class="'.$addClass.'" type="text">'; //$value
		if ($F1f[$f]=="area")	$O.='<textarea rows="2" id="'.$F1[$f].'" class="'.$addClass.'" cols="50"></textarea>';
		
		
		// specific
		if ($F1[$f]=="gymsCSV") {
			$O.='<div class="tagArea" id="gymArea">';
			$O.="<span class=\"notyet\">(".L_nothing_yet.")</span>";
			$O.="</div>";
		}

		if ($F1[$f]=="usersCSV") {
			$O.='<div class="tagArea" id="usersArea">';
			$O.="<span class=\"notyet\">(".L_nothing_yet.")</span>";
			$O.="</div>";
		}		
		

	}
	
			$O.='<div class="clear"></div>';
			$O.='<div id="tagInContainer">';
				$O.='<a href="#" id="closeTagIn">';
					$O.="X";
				$O.="</a>";
				$O.='<input type="text" value="" id="tagIN" name="tagIN'.$PAGE_RANDOM.'">';
				$O.='<div id="tagIN_fake" class="tagIN_fake_off">'.L_add_games_and_users;
				$O.='</div>';
				$O.='<div id="tagInAutoSuggestSelected">0</div>';
				$O.='<div id="tagInAutoSuggest">';
					$O.='<div class="loading"></div>';
				$O.='</div>';				
			$O.='</div>';	


			////// insighters
			$O.='<div class="clear"></div>';
			$O.='<div class="field" id="insightersF">';
				$O.=$F1t[$f];$O.=L_insighters.":";
			$O.="</div>";

			$O.='<div class="EtagArea" id="insightersArea">';
			$O.="<span class=\"notyet\">(".L_nothing_yet.")</span>";
			$O.="</div>";

			$O.='<div class="clear"></div>';
			$O.='<div id="EtagInContainer">';
				$O.='<a href="#" id="EcloseTagIn">';
					$O.="X";
				$O.="</a>";
				$O.='<input type="text" value="" id="EtagIN" name="EtagIN'.$PAGE_RANDOM.'">';
				$O.='<div id="EtagIN_fake" class="EtagIN_fake_off">'.L_add_insighters;
				$O.='</div>';
				$O.='<div id="EtagInAutoSuggestSelected">0</div>';
				$O.='<div id="EtagInAutoSuggest">';
					$O.='<div class="loading"></div>';
				$O.='</div>';				
			$O.='</div>';

			
			// save
			$O.='<div id="saveGroup" class="button_action_blue noselect">'.L_save.'</div>';
			$O.='<div class="clear"></div>';
			//$O.='<a  href="#" class="download_group_activity excel">'.L_activity.' </a>';
			$O.='<a href="#" class="red" id="deleteGroup">';
				$O.=L_delete_this_group;
			$O.="</a>";
			$O.='<div id="sureDelGroup">'.L_are_you_sure.'';
				$O.='<br /><a href="#" class="" id="noDelGroup">';
				$O.=L_cancel;
				$O.="</a>";
			
				$O.='<a href="#" class="red" id="yesDelGroup">';
				$O.=L_yes;
				$O.="</a>";

				
			$O.='</div>';	

$O.="</div>";// formG



$O.='<div class="clear"></div>';
/// END FORM

if ($_COOKIE["debug"])				{
					$O.="<pre>";	
					$O.=print_r($_SESSION,true);
					$O.=print_r($D,true);
					$O.="</pre>";
				}


$O.="<br /><br /><br />
</div>";//coreIN
$O.="</div>";//core