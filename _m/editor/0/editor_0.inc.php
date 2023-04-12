<?php
require_once(C_ROOT."/_m/editor/0/data.inc.php");
$JSA[]=''.C_DIR.'/_m/editor/editorCommon.js?'.PAGE_RANDOM;
$JSA[]=''.C_DIR.'/_m/editor/0/editor_0.js?'.PAGE_RANDOM;

$CSSA[]=''.C_DIR.'/_m/editor/editCommon.css?'.PAGE_RANDOM;
$CSSA[]=''.C_DIR.'/_m/editor/0/editor_0.css?'.PAGE_RANDOM;



$HEAD_ADD.='<script type="text/javascript">var F1='.json_encode($F1).';var F1t='.json_encode($F1t).';var F1f='.json_encode($F1f).'</script>';


$O.='<div id="mask" class="opacity50"></div>';
$O.='<div id="core" data-gameId="'.$gameId.'">';
require_once(C_ROOT."/_m/header/header.inc.php");

//if ($D) $O.=print_r($D,true);
//$O.="step 1/3<br />";
	$O.='<div class="gymSep">';
	//if ($_COOKIE["debug"])	$O.="<span id=\"fill\" >Fill</span>";
	$O.=L_the_game;
	$O.='</div>';
	
for ($f = 0; $f < sizeof($F1); $f++) {
	$addClassLine="";
	
	$O.='<div class="line'.$addClassLine.'" id="L_'.$F1[$f].'" >';
		
		$O.='<div class="field">';
			$O.=$F1t[$f];
			if ($F1t[$f]) $O.=":";
		$O.="</div>";
		$inA=explode(",",$F1f[$f]);
		$value=$D[	$F1[$f]	];
		
		$addClass="";
		//if ($F1[$f]=="valid_until")  		$addClass='  class="datepicker-here" data-autoClose="true" data-position="bottom left"  data-language="it" readonly="readonly" data-timepicker="false" data-min-view="days" data-view="days" ';
		//if ($F1[$f]=="stepsBefore") 	$addClass=" class=\"hidden\"";
		if ($inA[0]=="input")
			$O.='<input id="'.$F1[$f].'" '.$addClass.' value="'.$value.'" type="text">';
		if ($inA[0]=="area"){
			$O.='<textarea rows="4" id="'.$F1[$f].'" class="get textarea" cols="50">'.$value.'</textarea>';
            
			if ($F1[$f]=="Goal_1" ||$F1[$f]=="Goal_2"  ) 
				$O.='<a class="addGymGoal" id="addg_'.$F1[$f].'" href="#">+ '.L_add_game_goal.'</a>';

		}



		if ($inA[0]=="select"){


			 $O.='<select class="select60" id="'.$F1[$f].'"';						 
			 $O.='>';
			 
			 for ($x = $inA[1]; $x <= $inA[2]; $x++) {
				$selected=""; if ($x==$value) $selected=' selected="selected"';
				$xprint=$x;
				//if ($F1[$f]=="audio"){$xprint=L_no; if ($x>0) $xprint=L_yes;}
				$O.='<option value="'.$x.'"'.$selected.'>'.$xprint.'</option>';
			 }
			 $O.='</select>';
			 
			 
			 
		}


		
		
		// lang
		if ($inA[0]=="language"){
			if (!$value) $value=$_SESSION["lang"];
			$O.='<select size="'.$selectSize.'" name="'.$F1[$f].''.PAGE_RANDOM.'" class="select230" id="'.$F1[$f].'">';
			foreach($languages_names as $code => $langg) {
				$selected=""; if ($value==$code) $selected=' selected="selected"';				
				
				$O.='<option '.$selected.' value="'.$code.'">'.$langg.'</option>'; //selected="selected"
			}

			$O.='</select>';
		}

		//////////////////////////////////////
		$selectSize=1;
//////////////////////////////////////////////
	if ($inA[0]=="fontSelect"){
            $HEAD_ADD.='<style>';
			$QAF=sql_query	("SELECT * FROM fonts where 1 order by name ASC");
			while (	$fontS=sql_assoc($QAF)	){
                $fontS["class"]=str_replace(".","_",$fontS["file"])."_font";
                
				$D["fonts"][]=$fontS;
                $HEAD_ADD.='
@font-face {
  font-family: "'.$fontS["class"].'";
  src: url("/data/fonts/'.$fontS["file"].'")    format(\''.$fontS["fformat"].'\');
}
.'.$fontS["class"].'{
    font-family: \''.$fontS["class"].'\';
    font-size: '.$fontS["balloonSize"].'px!important;
}

';
                
                
				//$D["coversID"][]=$covers["id"];
				//$D["coversPath"][]=$covers["file"];
			}    
            $HEAD_ADD.='</style>';
    
			$O.='<select size="1" name="'.$F1[$f].''.PAGE_RANDOM.'" class="select230" id="'.$F1[$f].'">';
            $selected=""; $selectedClass="";
            if (!$D["balloonFont"]) $selected=' selected="selected"';	            
            $O.='<option data-c="default" '.$selected.' value="NULL">Arial, Helvetica, sans-serif</option>'; //Helvetica Neue,
			foreach($D["fonts"] as $k => $font) {
				$selected=""; 
                if ($font["file"]==$D["balloonFont"]) {
                    $selected=' selected="selected"';
                    $selectedClass=$font["class"];
                }
				$O.='<option data-c="'.$font["class"] .'" '.$selected.' value="'.$font["file"].'">'.$font["name"].'</option>'; //selected="selected"		//
			}
            
			$O.='</select>';
            $O.="<div class=\"clear\"></div>";
            $O.="<div id=\"balloon_container\">";
        //Ecco una frase di test <br />con il carattere <br /><span id="fontSelected">default</span>.<br />Non male eh?<  <img src="/img/pointer_left.png" id="leftArrow" alt="" data-top="22" style="right: -17px; top: 22px; display: none;">
            $O.='<div id="balloon"';
            if ($selectedClass) $O.=' class="'.$selectedClass.'"';
            $O.='<span>'.L_BALLOON_FONT_TEST_SENTENCE.'</span>
            <img src="/img/pointer_right.png" id="rightArrow" alt="">
            </div>';


            $O.="</div>";
    }


    if ($inA[0]=="dontShowDebriefScore"){

			$O.='<select size="'.$selectSize.'" name="'.$F1[$f].''.PAGE_RANDOM.'" class="select230" id="'.$F1[$f].'">';
            $selected0="";$selected1="";
            if ($value==0) $selected0='selected="selected"';
            if ($value==1) $selected1='selected="selected"';
            
			$O.='<option '.$selected0.' value="0">'.L_show.'</option>'; //selected="selected"
            $O.='<option '.$selected1.' value="1">'.L_dont_show.'</option>'; //selected="selected"
			$O.='</select>';
             $O.="<div class=\"clear\"></div>";
            $O.='<div class="selectFollowUp">';
            $O.=L_SHOWDONTSHOW_scores_in_the_debrief_page;
            //$O.=" $value";
            $O.='</div>';
    }


    
    /////////////////////////////////////////////
	$O.="</div>";	
	

    if ($F1[$f]=="Goal_3" && $gameId>0 && $D["cover"]  && $D["cover"]!="0_640.jpg") {
        $O.='<div class="gymSep">'.L_cover.'</div>';
        $O.='<img class="cover" src="/data/gameCover/'.$D["cover"].time().'" alt="" />';
        $O.='<div class="coverSpecification">'.L_EDITOR_0_COVER_CAPTION.'</div>'; 
    }
    if ($F1[$f]=="Goal_3") $O.='<div class="gymSep">Fonts</div>';
    if ($F1[$f]=="balloonFont") $O.='<div class="gymSep">Score in debrief</div>';
}
$O.='<div class="line lastLine">';
$O.='<div id="errorList"><div>'.L_sorry_the_following_fields_marked_in_red_are_not_correct.':</div><span></span></div>';
	$O.='<div id="S1" class="editButt noselect"><span class="l1">'.L_save.'</span><span class="l2">'.L_go_to_next_step.'</span><img class="editButtArrow" src="/img/arrowBigRight.png" alt="" /></div>';
$O.="</div>";	

if ($_COOKIE["debug"]){
	$O.="<pre>";
	$O.=print_r($D, true);
	$O.="</pre>";
}
$O.="<br /><br /><br /><br /><br /><br /><br /><br /></div>";//

?>


