<?php

$JSA[]=''.C_DIR.'/_m/editor/editorCommon.js?'.PAGE_RANDOM;

$HEAD_ADD.='<script id="MathJax-script" async src="/js/plugins/mathJax-es5/tex-chtml.js"></script><script src="/js/plugins/mjxgui.js?'.PAGE_RANDOM.'"></script>';

$CSSA[]=''.C_DIR.'/_m/editor/editCommon.css?'.PAGE_RANDOM;
$CSSA[]=''.C_DIR.'/_m/editor/0/editor_0.css?'.PAGE_RANDOM;
$CSSA[]=''.C_DIR.'/_m/editor/1/editor_1.css?'.PAGE_RANDOM;
$CSSA[]=''.C_DIR.'/_m/editor/1/cables.css.php?'.PAGE_RANDOM;
$CSSA[]=''.C_DIR.'/_m/avatars.css.php?screenW=500'; //<--!
//$CSSA[]='//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$CSSA[]='/js/plugins/jquery-ui/1.13.2/jquery-ui.min.css';
//$JSA[]='https://code.jquery.com/ui/1.13.2/jquery-ui.js';
$JSA[]='/js/plugins/jquery-ui/1.13.2/jquery-ui.min.js';
$JSA[]=''.C_DIR.'/_m/editor/1/editor_1.js?'.PAGE_RANDOM;


#### DATA STEP FORM
/*		scenario
		avatar
		avatar's position
		avatar's sentence=>audio		
		camera on protagonist only		
		answers_N	--->answers' score
*/

$F1=array(
"scene",
"scenario_id",
"avatar_id",
//"avatar_pos_id",
"avatar_sentence",
//"camera_protagonist",
"answer_1",
"ascore_1",
"answer_2",
"ascore_2",
"answer_3",
"ascore_3",
"answer_4",
"ascore_4",
);

$F1t=array(
L_scenario,
L_avatar,
//L_avatar_position,
L_avatar_sentence,
//L_camera_on_protagonist_only,
L_answer." 1",
"",
L_answer." 2",
"",
L_answer." 3",
"",
L_answer." 4"	,
""		//L_score
);

//$F1f=array();


#### DATA GAME
$strG="SELECT G.* FROM games G WHERE G.gameId =".$gameId." ";

$D=sql_fetch_assoc(sql_query($strG));
/*
if ($D["status"]=="playable") {
	header("location: /");
	exit();
}
	
*/







// 
$DtoJS=$D; // NOTE
$SQ=sql_query("SELECT * FROM games_steps WHERE gameId =".$gameId." ORDER BY step ASC, scene ASC");	//
$Kstep=0;
while (	$S=sql_assoc($SQ)	){
	$Kstep++;
	$D["s"][		$S["step"]	][		$S["scene"]				]=$S;
}


// first step/scene from url 

$D["startStep"]=1;$D["startScene"]="A";

if ($DIRA[4] && is_numeric($DIRA[4]))   $D["startStep"]=$DIRA[4];
if ($D["startStep"] && $DIRA[5]   )     $D["startScene"]=strtoupper($DIRA[5]); //&& in_array($DIRA[5], array("A","B","C", "D") )
if (    empty ($D["s"][$D["startStep"]] [$D["startScene"]] )    ) {
    $D["startStep"]=1;$D["startScene"]="A";
}
$DtoJS["startStep"]=$D["startStep"]; $DtoJS["startScene"]=$D["startScene"];
//////////


$HEAD_ADD.='<script type="text/javascript">var D='.json_encode($DtoJS).';var F1='.json_encode($F1).';var F1t='.json_encode($F1t).';</script>';
$HEAD_ADD.='<script type="text/javascript">var L_DO_YOU_REALLY_WANT_TO_DELETE_THIS_STEP="'.L_DO_YOU_REALLY_WANT_TO_DELETE_THIS_STEP.'";var L_DO_YOU_REALLY_WANT_TO_DELETE_THIS_SCENE="'.L_DO_YOU_REALLY_WANT_TO_DELETE_THIS_SCENE.'";var L_yes="'.L_yes.'";var L_cancel="'.L_cancel.'"; var L_sentence="'.L_sentence.'";L_avatar_sentence="'.L_avatar_sentence.'"; var L_loosing_end="'.L_loosing_end.'";var L_winning_end="'.L_winning_end.'"; var L_COMPULSORY_ATTACHMENTS_YES="'.L_COMPULSORY_ATTACHMENTS_YES.'";var L_COMPULSORY_ATTACHMENTS_NO="'.L_COMPULSORY_ATTACHMENTS_NO.'";</script>';

############### DATA ENDS


$singleEdit=false;

$O.='<div id="dialog" title=""></div>';

// pop
/*
$O.='<div class="popup">';
	$O.='<div class="popin">';
		$O.=L_do_you_want_to_save_the_changes;
		$O.='<div class="popLine">';
			$O.='<div class="popButt pos" id="ipos">'.L_yes.'</div>';
			$O.='<div class="popButt neg" id="ineg">'.L_no.'</div>';
		$O.='</div>';
	$O.='</div>';
$O.='</div>';
*/
$O.='<div id="spinLoad"></div>';
$O.='<div id="mask" class="opacity50"></div>';




$O.='<div id="core" data-gameId="'.$gameId.'" data-step="1" data-scene="A" data-steps="'.$D["steps"].'"  data-cmtedit="null" >';


//
	require_once(C_ROOT."/_m/header/header.inc.php");	
		$O.='<input id="title" type="text" value="'.$D["title"].'">';
		
/*$O.='<div id="coverMask">';
	$O.='<img src="/data/covers/'.$D["coverPath"].'" width="100%" height="auto" alt="" />';
$O.='</div>';
*/

$O.='<div id="upContainer" class="">';
	//$O.='<div id="mask" class="opacity50"></div>';
	$O.='<div id="upContainerL" class="">';


	$O.='</div>';	

	$O.='<div id="upContainerR" class="">';
			## title
		$O.='<div id="stepTit">Step <span id="stepRef">1</span>/'.$D["steps"];
        $O.='<span id="sceneRef">A</span>';
		$O.='</div>';
		$O.='<div id="stepTitEnding">';$O.='</div>';
		$O.='<div class="clear"></div>';			
		/*
		
		scenario
		avatar
		avatar's position
		avatar's sentence=>audio		
		camera on protagonist only		
		answers
		answers' score
    [0] => scenario_id
    [1] => avatar_id
    [2] => avatar_sentence
    [3] => answer_1
    [4] => ascore_1
    [5] => answer_2
    [6] => ascore_2
    [7] => answer_3
    [8] => ascore_3
    [9] => answer_4
    [10] => ascore_4		
		
		*/

/*
jBAm3KDRWdSVTNnTYFKr4g== stands for add|95|2|C cyrpta
from
*/
//$scenarioReference=crypta("add|95|2|C")

 foreach($F1 as $key => $f){
	
	switch ($f) {
		case "scenario_id":
			// select scenario
			/*$O.='<select size="1" name="'. $f.''.PAGE_RANDOM.'" class="select230" id="'.$f.'">';
				$O.='<option value="0">'.L_select_scenario.' 0</option>'; 			
				$scenarioQ=sql_query	("SELECT S.id, S.name FROM scenarios S WHERE S.invisble=0 AND (S.propertyUid=0 OR S.propertyUid=".$_SESSION["uid"].") order by name ASC");
				//echo sql_error();
				$AFC=0;
				while (	$scenario=sql_assoc($scenarioQ)	){
					//$sourceS="/data/avatar_prev/".$scenario["id"].".mp4";
					$O.='<option id="'.$scenario["id"].'" value="'.$scenario["id"].'"'.$selected.'>'.$scenario["name"].'</option>';
					$AFC++;
				}
			 $O.='</select>';
			 $O.='<a id="scenarioHandlerLink" href="/?/scenarios/jBAm3KDRWdSVTNnTYFKr4g==">';
                $O.='<img src="/img/ico/plus12.png" alt="" />'; //
             $O.='</a>';
			// select avatar
			$O.='<select size="1" name="avatar_id'.PAGE_RANDOM.'" class="select230" id="avatar_id">';
				$O.='<option value="0" selected="selected">'.L_select_avatar.'</option>'; 			
				$QAF=sql_query	("SELECT id, name FROM avatars where 1 AND  id!=4 order by FIELD(id, 1000) ASC  , name ASC");
				while (	$avatar=sql_assoc($QAF)	){
					if ($avatar["name"]=="L_no_avatar") $avatar["name"]=L_no_avatar;
					$O.='<option id="'.$avatar["id"].'" value="'.$avatar["id"].'"'.$selected.'>'.$avatar["name"].'</option>';
				}
			 $O.='</select>';			 
			 */
            /////
            $O.='<div id="selectDataZone">';
                $O.='<div data-defVal="'.L_select_avatar.'" class="pickD" id="pickAvatar"><span class="pickAvatarT">'.L_select_avatar.'</span></div>';
                //<img id="dartDownAv" class="dartDown" src="/img/ico/blu_d16.png" alt="" />
                $O.='<a href="#" data-defVal="'.L_select_scenario.'" class="pickD" id="scenarioHandlerLink"><span>'.L_select_scenario.'</span><img class="dartDown" src="/img/ico/blu_r16.png" alt="" /></a>';
                $O.='<div id="pickAvatarList">';
				$QAF=sql_query	("SELECT id, name FROM avatars where invisble=0 AND (propertyUid is null OR propertyUid=".$_SESSION["uid"].")
order by id=1000 ASC, name ASC"); //FIELD(id, 1000) ASC,
				while (	$avatar=sql_assoc($QAF)	){
					//if ($avatar["name"]=="L_no_avatar") $avatar["name"]=L_no_avatar;
					if ($avatar["id"]!=1000) $O.='<div class="avtrI" id="avtr_'.$avatar["id"].'" >';
                    else $O.='<div class="avtrI avtrINOAVTR" id="avtr_'.$avatar["id"].'" >';
                        if ($avatar["id"]!=1000) {
                            $O.='<div class="avtrImg" style="background-image: url(\'/data/avatar_prev/1/'.$avatar["id"].'_10Kx1098_wait.png\')"></div>';//;background-size: 2400px;
                            $O.='<div id="avtrName_'.$avatar["id"].'" class="avtrName">'.$avatar["name"].'</div>';
                        }else{
                        $O.='<div class="avtrNameNOAVTR">'.L_no_avatar.'</div>';
                        }
                        
                    $O.='</div>';
                    
				}                
                
                $O.='</div>';    
            $O.='</div>';
            /////
            
			$O.='<div class="clear"></div>';
            $O.='<div id="fakePlayerSPACING"></div>';
            //$O.='<div id="fakePlayerAVATARlimit"></div>';
			$O.='<div id="fakePlayer">'; //pointer_left.png
				$O.='<div id="balloon"><span>Hola chico!</span><img src="/img/pointer_left.png" id="leftArrow" alt="" /><img src="/img/pointer_right.png" id="rightArrow" alt="" /></div>';
				$O.='<img src="/data/scenarios/0_640.jpg" class="sceneimg" alt="" />';
				//$O.='<div id="avatar" class="avatar_500 wait_1"></div>';
				//$O.='<div id="avatar" class="avatar_H260 wait_1"></div>';
				
				//$O.='<div class="avatar_1 wait_W500"></div>';  left:277px;top:16px
				$O.='<div  id="avatarSprite" data-currentAvatar="0" data-pos="264,3" data-currentSize="S" class="avatar_0 wait_S" title="'.L_drag_to_reposition.'"></div>';
				
				//$O.='<div class="monster3_500"></div>';
				
				//$O.='<img src="/data/avatar_prev/1/1_listen_w360.gif" class="sceneavatar" alt="" />';
//				$O.='<img src="/data/avatar_prev/0/0_listen_w360.png?'.PAGE_RANDOM.'" class="sceneavatar sceneavatarPrimo" alt="" />';
			$O.='</div>';	
			
			$O.='<div id="avatarDims">';
				$O.='<span>'.L_avatar_size.":</span>";
				$O.='<a href="#" id="as_XS">XS</a> ';
				$O.='<a href="#" class="don" id="as_S">S</a> ';
				$O.='<a href="#" id="as_M">M</a> ';
				$O.='<a href="#" id="as_L">L</a> ';
				$O.='<a href="#" id="as_XL">XL</a> ';
				
			$O.='</div>';	
			//$O.='<div class="monster1_500"></div>';

			//$O.='<div class="avatar_3_500"></div>';
		break;

		case "avatar_sentence":
/*
Rayo de sol,
buscador del inspiraciòn,
forma el paisaje de la vida,
dibujas a pintadas libres,
el tango de la naturaleza,
como el toque suave
de la mano velazqueziana
en su lienzo "las meninas".
*/		
		
			$O.='<div id="avatar_sentence_title" class="subtitle"><span>'.L_avatar_sentence.'</span>:<div id="digit" class="advice">'.L_digit.'</div><div id="fx_avatar_sentence" class="fx"></div></div>';
			$O.='<textarea maxlength="800" rows="4" id="avatar_sentence" class="get textarea" cols="50" style="height: 55px;"></textarea>';
			$O.='<div id="audioManage">';$O.='</div>';	
			//if ($D["audio"]){
			$O.='<div class="audioline">';
				$O.='';
			
				$O.='<div id="loadingAudio" class="loading"></div>';
				$O.='<img id="imgAudio" src="/img/ico/audio16off.png?asd" alt=""  />';		
						
				$O.='<div id="audioCmd">';
					$O.='<a href="#" id="generateAudio">'.L_generate.'</a> <span>'.L_OR.'</span>';
					$O.='<a href="#" id="upLoadAudio" class="audioLoadFake tip" data-d="au'.($p+1).'" id="auimg'.($p+1).'" data-titlebis="'.L_delete_the_current_audiofile_and_upload_a_new_one.'" title="'.L_upload_an_audio_file.'">'.L_upload.'</a> ';
				$O.='</div>';
				
				$O.='<span id="audioControls">';
					$O.='<img data-file="" class="audioPlay tip" data-d="au'.($p+1).'" id="auimgplay'.($p+1).'" src="/img/ico/audioPlay14on.png" alt="" title="'.L_play.'" />';
					$O.='<img class="audioPause tip" data-d="au'.($p+1).'" id="auimgpause'.($p+1).'" src="/img/ico/audioPause14on.png" alt="" title="'.L_pause.'" />';
					$O.='<img class="audioDelete tip" id="audioDelete"  src="/img/ico/cross16.png" alt="" title="'.L_remove.'" />';
					$O.='</span>';
				$O.='<input id="au'.($p+1).'" type="file" class="audioLoad" name="a'.PAGE_RANDOM.'" accept="audio/*"/>';
				
				
//				$O.='<div class="fileUpload">';
					//$O.='<img class="audioLoadFake tip" data-d="au'.($p+1).'" id="auimg'.($p+1).'" src="/img/ico/audio16off.png?asd" alt="" data-titlebis="'.L_delete_the_current_audiofile_and_upload_a_new_one.'" title="'.L_upload_an_audio_file.'" />';
//				$O.='</div>';

			$O.='<span id="generateGroup">';
			 $O.='<select class="select230" id="voice">';
//				$O.='<option value="'.$languages_lcode[$D["language"]][0].',female"'.$selected.'>'.$languages_names[$D["language"]].' ('.strtoupper($languages_lcode[$D["language"]][0]).') '.L_feminine.'</option>';
//				$O.='<option value="'.$languages_lcode[$D["language"]][0].',male"'.$selected.'>'.$languages_names[$D["language"]].' ('.strtoupper($languages_lcode[$D["language"]][0]).') '. L_masculine.'</option>';

				$O.='<option value="f"'.$selected.'>'.L_feminine.'</option>';
				$O.='<option value="m"'.$selected.'>'. L_masculine.'</option>';


			 $O.='</select>';
			$O.='<a href="#" id="generateGo">'.L_generate.'</a>';
			$O.='</span>';


					$O.='<audio id="player" controls="controls" >'; //
							//$O.='<source src="/data/audio/TEST.mp3" type="audio/mpeg">';//pds
					$O.='</audio>';
	
	

			$O.='</div>'; //audioline
			

			
		break;
	}
	
	
 }

$O.='<div id="noFinalBlock">';

	$O.='<div id="players_answers_title" class="subtitle">'.L_players_answers.':<div class="subtitleR1">'.L_goto.':</div><div class="subtitleR">'.L_score.':</div></div>';
	// "answer_1", "ascore_1",
	for ($answ = 1; $answ<= 4; $answ++) {
		if ($answ > 2) {
			$O.='<div id="ascore_v_'.$answ .'">';
		}
		// textarea_answTight
        $O.='<div class="prevEditGroup">';
            $O.='<div id="fx_answ_'.$answ.'" class="fx"></div>';
            $O.='<textarea maxlength="255" rows="2" id="answer_'.$answ.'" class="textarea_answ textarea textarea_answTight" cols="50" style="height: 33px;"></textarea>';
            $O.='<div title="click to edit" id="answer_prev_'.$answ.'" class="answer_prev">... '.$answ.'</div>';
        $O.='</div>';


		$O.='<select class="select ascore" id="ascore_'.$answ.'">';
			$O.='<option value="na">?</option>';
			for ($v = 0; $v<= 10; $v++) {	$O.='<option value="'.$v.'">'.$v.'</option>';	}
            
		$O.='</select>';

		$O.='<select class="select goto" id="goto'.$answ.'">';
			
			$O.='<option id="goto_'.$answ.'_A" value="A">2A-</option>';
			$O.='<option id="goto_'.$answ.'_B" value="B">2B-</option>'; 
			$O.='<option id="goto_'.$answ.'_C" value="C">2C-</option>'; 
			$O.='<option id="goto_'.$answ.'_D" value="D">2D-</option>'; 
		
		//data-a="A" selected="selected"
		$O.='</select>';
        $O.='<div class="clear"></div>';
        /////////////
       $O.='<div class="fbArea" id="fbArea_'.$answ.'">';
       
            $O.='<img src="/img/ico/cross16.png" class="removeFeedback" title="'.L_remove_feedback.'" id="removeFeedback_'.$answ.'" alt="" />';
            $O.='<div class="title_fb">'.L_feedback_after_answer_N.' '.$answ.':</div>';
            $O.='<textarea maxlength="255" rows="2" id="answerFeedback_'.$answ.'" class="textarea_fb textarea" cols="50" style="height: 33px;"></textarea>';
            $O.='<textarea maxlength="255" rows="2" id="answerFeedbackSavedAudio_'.$answ.'" data-avatar="0" class="textarea_fbAudio textarea" cols="50" style="height: 33px;"></textarea>';
        $O.='</div>';
        /////////////////
        
		//$O.='<div class="clear"></div>';
		if ($answ == 3 ) $O.='<a class="addAnswer" id="addAnswer_'.($answ+1).'" data-ref="" href="#">+ '.L_add_an_answer.'</a>';
		if ($answ == 4 ) $O.='<a class="removeAnswer" id="removeAnswer_'.($answ).'" data-ref="" href="#">- '.L_remove_last_answer.'</a>';
        
        $O.='<a class="addFeedback" id="addFeedback_'.($answ).'" data-ref="" href="#">+ '.L_add_feedback.'</a>';//remove_feedback
        
		$O.='<div class="clear"></div>';
        
        
		if ($answ > 2) $O.='</div>';
	}
	
	
	$O.='<div class="subtitle">'.L_attachments.':</div>';

		$O.='<div id="attachmentLine">';
			$O.='<a id="file" class="attLnk" href="#">'.L_file.'</a> <span class="or">'.L_OR.'</span> '; 
			$O.='<input id="url" value="" name="url'.PAGE_RANDOM.'" type="text">';
			$O.='<a id="link" class="attLnk" href="#">'.L_add_url.'</a>';
			$O.='<input id="attachmentInput" type="file" class="attachmentInputC" name="ATT'.PAGE_RANDOM.'" >'; //accept="audio/*"/
		$O.='</div>';
		
	

		$O.='<div id="attachments">';
		for ($att = 1; $att<= 5; $att++) {
			$attType="attach";
			if ($att == 3 || $att === 5) $attType="link";
			$O.='<div id="attachments_L_'.$att.'" class="attachments_L">';
			//$O.=$att;
				$O.='<a id="href_att_'.$att.'" href="#" target="_BLANK"><img class="attImg" src="/img/ico/'.$attType.'60.png" width="32" height="32" alt="" /></a>';
				$O.='<input class="attTitle" title="'.L_edit_title.'" data-ida="0" id="attTitle_'.$att.'" value="" name="attTitle'.PAGE_RANDOM.'" type="text">';
				$O.='<img class="attDelete" id="attDelete_'.$att.'" data-ida="0" src="/img/ico/cross16.png" alt="" title="'.L_remove.'" />';
				$O.='<div class="clear"></div>';
			$O.='</div>';
		}
		$O.='</div>';

		$O.='<div id="compulsoryAttachmentsBox" data-compulsoryAttachments="0">';
			$O.='<div id="compulsoryAttachmentsMsg">';	
			$O.=L_COMPULSORY_ATTACHMENTS_NO."";
			$O.='</div>';
			$O.='<div id="compulsoryAttachmentsChange">';	
			$O.=L_change."";
			$O.='</div>';
		$O.='</div>';

$O.='</div>';	//id="noFinalBlock">';



	
	
	$O.='</div>';	 ///////////////////////////////////////////////////////cont





$O.='</div>';	//upContainer end



$O.='<div class="clear"></div>';
$O.='<div class="downContainer" id="qualitativeBox" data-available="0">';
	$O.='<div class="downContainerIN">';
	
	$O.='<div class="subtitlePar">'.L_score.' '.L_AND.' '.L_qualitative_comments.':</div>'; 
	$O.='<div id="fgraphNotAvailable">'.L_not_available_yet.'&gt; <span>...<span></div>';
	
	$O.='<div id="fgraph">';	
		///data/scenarios/6_640.jpg
		$O.='<div id="loosing" data-step="'.($D["steps"]+2).'">';
			$O.='<div class="lwArea">'.L_loosing_area.' &lt;</div>';
		
			$scen="editMenu_640x360.png";$addClassS="";if ($D["s"][	$D["steps"]+2	]["scenario_id"]) {$scen=$D["s"][	$D["steps"]+2	]["scenario_id"]."_640.jpg";$addClassS="isScenario";}
			$O.='<img class="'.$addClassS.'" id="boxScenarioLose" src="/data/scenarios/'.$scen.'" alt="" />';
		$O.='</div>';
		
		
		$O.='<div id="winning" data-step="'.($D["steps"]+1).'">';
			$O.='<div class="lwArea">&gt; '.L_winning_area.'</div>';
			$scen="editMenu_640x360.png";$addClassS="";if ($D["s"][	$D["steps"]+1	]["scenario_id"]) {$scen=$D["s"][	$D["steps"]+1	]["scenario_id"]."_640.jpg";$addClassS="isScenario";}
			$O.='<img class="'.$addClassS.'" id="boxScenarioWin" src="/data/scenarios/'.$scen.'" alt="" />';

		$O.='</div>';

		$O.='<div class="gLegend" id="gLegend0">0%<div class="subGlegend">Score:<span>0</span></div></div>';
		$O.='<div class="gSeparator" id="gSeparator0"></div>';


		$O.='<div class="gLegend" id="gLegend50">50%<div class="subGlegend">Score:<span>70</span></div></div>';
		$O.='<div class="gSeparator" id="gSeparator50"></div>';

		$O.='<div class="gLegend" id="gLegend100">100%<div class="subGlegend">Score:<span>140</span></div></div>';
		$O.='<div class="gSeparator" id="gSeparator100"></div>';


	$O.='<div class="boxQuarterL" title="'.L_insert_comment.'" id="L1">L1';
		$O.='<div title="'.L_insert_comment.'" class="cmt" id="cmt_L1"></div>'; $p="L1";
		$O.='<div data-delta="x,y" class="cmtareac" id="cmtareac_fc_'.$p.'"><div  id="faketxt_fc_'.$p.'" class="faketxt">'.L_comment_result_for_this_range.'</div><div class="pointer_up"></div><textarea  name="cmtarea_fc_'.$p.''.PAGE_RANDOM.'" id="cmtarea_fc_'.$p.'" />'.$cmtvalue.'</textarea><div id="cmtsave_fc_'.$p.'" class="cmtsave">'.L_ok.'</div></div>';		
	$O.='</div>';
	$O.='<div class="boxQuarterL" title="'.L_insert_comment.'" id="L2">L2';
		$O.='<div title="'.L_insert_comment.'" class="cmt" id="cmt_L2"></div>';$p="L2";
		$O.='<div data-delta="x,y" class="cmtareac" id="cmtareac_fc_'.$p.'"><div  id="faketxt_fc_'.$p.'" class="faketxt">'.L_comment_result_for_this_range.'</div><div class="pointer_up"></div><textarea  name="cmtarea_fc_'.$p.''.PAGE_RANDOM.'" id="cmtarea_fc_'.$p.'" />'.$cmtvalue.'</textarea><div id="cmtsave_fc_'.$p.'" class="cmtsave">'.L_ok.'</div></div>';		
	$O.='</div>';
	
	$O.='<div class="boxQuarterL" title="'.L_insert_comment.'" id="L3">L3';
		$O.='<div title="'.L_insert_comment.'" class="cmt" id="cmt_L3"></div>';$p="L3";
		$O.='<div data-delta="x,y" class="cmtareac" id="cmtareac_fc_'.$p.'"><div  id="faketxt_fc_'.$p.'" class="faketxt">'.L_comment_result_for_this_range.'</div><div class="pointer_up"></div><textarea  name="cmtarea_fc_'.$p.''.PAGE_RANDOM.'" id="cmtarea_fc_'.$p.'" />'.$cmtvalue.'</textarea><div id="cmtsave_fc_'.$p.'" class="cmtsave">'.L_ok.'</div></div>';		
	$O.='</div>';

	
	$O.='<div class="boxQuarterL" title="'.L_insert_comment.'" id="L4">L4';
		$O.='<div title="'.L_insert_comment.'" class="cmt" id="cmt_L4"></div>';$p="L4";
		$O.='<div data-delta="x,y" class="cmtareac" id="cmtareac_fc_'.$p.'"><div  id="faketxt_fc_'.$p.'" class="faketxt">'.L_comment_result_for_this_range.'</div><div class="pointer_up"></div><textarea  name="cmtarea_fc_'.$p.''.PAGE_RANDOM.'" id="cmtarea_fc_'.$p.'" />'.$cmtvalue.'</textarea><div id="cmtsave_fc_'.$p.'" class="cmtsave">'.L_ok.'</div></div>';		
	$O.='</div>';
	
	$O.='<div title="'.L_insert_comment.'" class="boxQuarterW"  id="W1">W1';
		$O.='<div title="'.L_insert_comment.'" class="cmt" id="cmt_W1"></div>';;$p="W1";
		$O.='<div data-delta="x,y" class="cmtareac" id="cmtareac_fc_'.$p.'"><div  id="faketxt_fc_'.$p.'" class="faketxt">'.L_comment_result_for_this_range.'</div><div class="pointer_up"></div><textarea  name="cmtarea_fc_'.$p.''.PAGE_RANDOM.'" id="cmtarea_fc_'.$p.'" />'.$cmtvalue.'</textarea><div id="cmtsave_fc_'.$p.'" class="cmtsave">'.L_ok.'</div></div>';		
	$O.='</div>';	
	
	$O.='<div title="'.L_insert_comment.'" class="boxQuarterW"  id="W2">W2';
		$O.='<div title="'.L_insert_comment.'" class="cmt" id="cmt_W2"></div>';;$p="W2";
		$O.='<div data-delta="x,y" class="cmtareac" id="cmtareac_fc_'.$p.'"><div  id="faketxt_fc_'.$p.'" class="faketxt">'.L_comment_result_for_this_range.'</div><div class="pointer_up"></div><textarea  name="cmtarea_fc_'.$p.''.PAGE_RANDOM.'" id="cmtarea_fc_'.$p.'" />'.$cmtvalue.'</textarea><div id="cmtsave_fc_'.$p.'" class="cmtsave">'.L_ok.'</div></div>';		
	$O.='</div>';	
	
	$O.='<div title="'.L_insert_comment.'" class="boxQuarterW"  id="W3">W3';
		$O.='<div title="'.L_insert_comment.'" class="cmt" id="cmt_W3"></div>';;$p="W3";
		$O.='<div data-delta="x,y" class="cmtareac" id="cmtareac_fc_'.$p.'"><div  id="faketxt_fc_'.$p.'" class="faketxt">'.L_comment_result_for_this_range.'</div><div class="pointer_up"></div><textarea  name="cmtarea_fc_'.$p.''.PAGE_RANDOM.'" id="cmtarea_fc_'.$p.'" />'.$cmtvalue.'</textarea><div id="cmtsave_fc_'.$p.'" class="cmtsave">'.L_ok.'</div></div>';		
	$O.='</div>';	
	$O.='<div title="'.L_insert_comment.'" class="boxQuarterW"  id="W4">W4';
		$O.='<div title="'.L_insert_comment.'" class="cmt" id="cmt_W4"></div>';$p="W4";
		$O.='<div data-delta="x,y" class="cmtareac" id="cmtareac_fc_'.$p.'"><div  id="faketxt_fc_'.$p.'" class="faketxt">'.L_comment_result_for_this_range.'</div><div class="pointer_up"></div><textarea  name="cmtarea_fc_'.$p.''.PAGE_RANDOM.'" id="cmtarea_fc_'.$p.'" />'.$cmtvalue.'</textarea><div id="cmtsave_fc_'.$p.'" class="cmtsave">'.L_ok.'</div></div>';		
	$O.='</div>';	



	$O.='</div>';//downContainerIN
	$O.='</div>';

//////////////////////////////////////////////////



$O.='<div class="downContainer" id="downContainerStatus">';
$O.='<div class="downContainerIN">';
	$O.='<a href="/?editor/'.$gameId.'/0/" href="" class="editButt backbtn noselect"><img class="editButtArrowR" src="/img/arrowBigLeft999.png" alt="" /><span class="l1">'.L_back.'</span><span class="l2">'.L_to_the_first_step.'</span></a>';

	$O.='<div id="centrend">';
		$O.='<span id="missingmsg">'.L_EDITOR_CHECK_TEXT.'<br /><a id="checkmissing" href="#">'.L_check_missing_values.'</a></span>';
		$O.='<span id="missingList"></span>';
		$O.='<span id="okmsg" class="noselect">';
			$O.=L_save_the_game_as_playable;
				$O.='<span>';
				$O.=L_SAVE_PLAYABLE_ADVICE; 
				$O.='</span>';
		$O.='</span>';
	$O.='</div>';

	$O.='<a href="/?/desktopplayer/'.$D["gameId"].'/simulate" target="_blank"  id="playerSimLilnk" class="editButt rightbtn noselect"><img class="editButtArrow" src="/img/arrowBigRight999.png" alt="" /><span class="l3">'.L_playing_simulation.'</span></a>';
	$O.='<a href="/?debrief/1/1/" target="_blank"  id="debriefSimLilnk" class="editButt rightbtn noselect simLink"><img class="editButtArrow" src="/img/arrowBigRight999.png" alt="" /><span class="l3">'.L_debriefing_simulation.'</span></a>';


$O.='</div>';//"downContainerIN">';
$O.='</div>';




$O.='<div class="clear"></div>';

/*
require_once($_SERVER['DOCUMENT_ROOT'].'/_lib/voicerss_tts.php');

$tts = new VoiceRSS;
$voice = $tts->speech([
    'key' => '358d3dc248d64a3cad3d1ffb75acf67b',
//    'hl' => 'en-us','src' => 'I love you,  Grace!',
	    'hl' => 'it-it',
	'src' => 'mannaggia alla peppa! ... peppa pig!',
    'r' => '0',
    'c' => 'mp3',
    'f' => '44khz_16bit_stereo',
    'ssml' => 'false',
    'b64' => 'true'
]);


$O.= '<audio src="' . $voice['response'] . '" controls="controls" ></audio>'; //autoplay="autoplay"
*/





if ($_COOKIE["debug"]){
	$O.= "<pre><br />";
    $O.=print_r($DIRA,true);
	//$O.=print_r(gameIntervalCalc($gameId) ,true);
	$O.=print_r($D,true);
	//print_r($voice);
	//$O.=$gameId;
	//	$O.="comm";
	//$O.=print_r(	aDim(0,550)			,true);
	//$O.=print_r(	aDim(250,0)			,true);
	//	$O.=print_r($F1t,true);
	//	$O.=print_r($F1,true);
	//	$O.=print_r($sentences,true);
	
	//	$O.=print_r($D,true);
	//	$O.="</pre>";
}
$O.="</div>";// core




?>