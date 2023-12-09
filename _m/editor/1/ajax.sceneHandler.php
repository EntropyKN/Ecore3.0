<?php
error_reporting(E_ALL ^ E_NOTICE);ini_set("display_errors",1);
header('Content-Type: application/json; charset=utf-8');

include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
if ($_SESSION["ulevel"]<1) {
	$D["response"]=false;
	$D["reason"]="mm sounds like you're not logged at the moment";
	echo json_encode($D);
	return;		
}
$lang_trigger="edt";
require_once(C_ROOT."/config/lang.inc.php");


$sceneAlphabet=array("A"=>1,"B"=>2,"C"=>3,"D"=>4,"E"=>5,);
$sceneAlphabetN=array("", "A","B","C","D","E");
$writeDB=true;////////////////////////////////////////////////
$D=$_POST;$D=array_map("trim",$D);

$D["response"]=true;
$D["reason"]="";

$Dact=explode("_", $D["divid"]);	//addScene_8_B

$D["action"]=$Dact[0];
$D["step"]=$Dact[1];  // numeric
$D["scene"]=strtoupper($Dact[2]);// A, B, C, D

/// general check
if (
	
	!is_numeric($D["gameId"])  ||	
	($D["action"]!="addScene" && $D["action"]!="deleteScene" 
	 && $D["action"]!="getStructure"  
	 && $D["action"]!="addStep" 
	 && $D["action"]!="deleteStep" 
	 && $D["action"]!="addAnswer"
	 && $D["action"]!="removeAnswer"
	)
	
){
	$D["response"]=false;
	$D["reason"]="a little error occurred";	
	echo json_encode($D);
	return;	
}

// "addRemove4thAnswer"
if ($D["action"]=="addAnswer" ||$D["action"]=="removeAnswer" ) { // SEMPRE SOLO LA 4a
	if ( !$D["scene"] || !is_numeric($D["step"]  )){
		$D["response"]=false;
		$D["reason"]="a little error occurred";
		if (!$D["scene"]) $D["reason"].=" missing scene";
		if (!is_numeric($D["step"])) $D["reason"].=" missing step";
		echo json_encode($D);
		return;	
	}	
	$D["response"]=true;
	
	$D["Q"]="/*".$D["action"]." */ UPDATE `games_steps` SET `goto4` = NULL, answer_4=NULL, ascore_4= NULL, img_4=NULL, altImg_4=NULL WHERE gameId=".$D["gameId"]." AND scene='".$D["scene"]."' AND step='".$D["step"]."' ";	
	if ($D["action"]=="addAnswer") $D["Q"]="/*".$D["action"]." */ UPDATE `games_steps` SET `goto4` = 'A' WHERE gameId=".$D["gameId"]." AND scene='".$D["scene"]."' AND step='".$D["step"]."' ";
	if ($writeDB) sql_query($D["Q"]);if (sql_error())  $D["sql_error"]=sql_error();
	$D["htm"]=getStructureHTM($D["gameId"]);
	
	echo json_encode($D);
	return;		
}

//addScene

if ($D["action"]=="addScene") {////////////////////////////////////
	if ( !$D["scene"] || !is_numeric($D["step"]  )){
		$D["response"]=false;
		$D["reason"]="a little error occurred";
		if (!$D["scene"]) $D["reason"].=" missing scene";
		if (!is_numeric($D["step"])) $D["reason"].=" missing step";
		echo json_encode($D);
		return;	
	}		
	if (!in_array(		$D["scene"], array("A","B", "C"))	) {// since the maximum is C+1=D
	$D["response"]=false;
	$D["reason"]="Scene E can't be added";		
	echo json_encode($D);
	return;	
		
	}
	
	
	
	$D["response"]=true;
	$D["sceneInsert"]=		$sceneAlphabetN[			intval( $sceneAlphabet[	$D["scene"]	]+1) ];
	$D["Q"]="INSERT INTO `games_steps` (`gameId`, `step`, `scene`) VALUES (".$D["gameId"].",".$D["step"].",'".$D["sceneInsert"]."')";
	if ($writeDB) sql_query($D["Q"]);if (sql_error())  $D["sql_error"]=sql_error();
	$D["htm"]=getStructureHTM($D["gameId"]);
/*$D["htmDIV"]='<div id="stepM_'.$D["step"].'_'.$D["sceneInsert"].'" class="upContainerBox" data-go2="A">
	<img class="upContainerBoxImg boxScenario" src="/data/scenarios/editMenuCentered_640x360.png" width="100%" height="auto" alt="">
	<div id="conn_'.$D["step"].'_'.$D["sceneInsert"].'" class="upContainerBoxLegend">'.$D["step"].''.$D["sceneInsert"].'</div>
	<div class="questionDotContainer">
		<div id="Qdot_'.$D["step"].'_'.$D["sceneInsert"].'_1" class="questionDot"></div>
		<div id="Qdot_'.$D["step"].'_'.$D["sceneInsert"].'_2" class="questionDot"></div>
		<div id="Qdot_'.$D["step"].'_'.$D["sceneInsert"].'_3" class="questionDot"></div>
		<div id="Qdot_'.$D["step"].'_'.$D["sceneInsert"].'_4" class="questionDot"></div>
	</div>
	<div class="gotoGr gotoGr_A gotoGr_'.$D["sceneInsert"].'1TOA"></div>
	<div class="gotoGr gotoGr_A gotoGr_'.$D["sceneInsert"].'2TOA"></div>
	<div class="gotoGr gotoGr_A gotoGr_'.$D["sceneInsert"].'3TOA"></div>
	<div class="gotoGr gotoGr_A gotoGr_'.$D["sceneInsert"].'4TOA"></div>
</div>';
	
	*/
	
	echo json_encode($D);
	return;
	
	
}
###### DELETE SCENE
if ($D["action"]=="deleteScene") {////////////////////////////////////
	if ( !$D["scene"] || !is_numeric($D["step"]  )){
		$D["response"]=false;
		$D["reason"]="a little error occurred";
		if (!$D["scene"]) $D["reason"].=" missing scene";
		if (!is_numeric($D["step"])) $D["reason"].=" missing step";
		echo json_encode($D);
		return;	
	}
	
	
	$D["response"]=true;
	$D["sceneDelete"]=	$D["scene"]	;
	$D["sceneRemain"]=		$sceneAlphabetN[			intval( $sceneAlphabet[	$D["scene"]	]-1) ];
	
	if (!in_array(		$D["scene"], array("B","C", "D"))	) {// since the maximum is C+1=D
	$D["response"]=false;
	$D["reason"]="Scene ".$D["scene"]." can't be removed";//A
	echo json_encode($D);
	return;			
	}
	
	
	if ($D["step"]>1) {
		/*$D["QupdateUP"]="update games_steps SET goto1='A' WHERE goto1='".$D["sceneDelete"]."' AND gameId=".$D["gameId"]." AND step=".($D["step"]-1).";
		update games_steps SET goto2='A' WHERE goto2='".$D["sceneDelete"]."' AND gameId=".$D["gameId"]." AND step=".($D["step"]-1).";
		update games_steps SET goto3='A' WHERE goto3='".$D["sceneDelete"]."' AND gameId=".$D["gameId"]." AND step=".($D["step"]-1).";
		update games_steps SET goto4='A' WHERE goto4='".$D["sceneDelete"]."' AND gameId=".$D["gameId"]." AND step=".($D["step"]-1).";
		";*/
		
	  
		$D["QupdateUP"]="UPDATE
    games_steps
SET 
  goto1 = CASE WHEN goto1 = '".$D["sceneDelete"]."' THEN  'A' ELSE goto1 END,
  goto2 = CASE WHEN goto2 = '".$D["sceneDelete"]."' THEN  'A' ELSE goto2 END,
  goto3 = CASE WHEN goto3 = '".$D["sceneDelete"]."' THEN  'A' ELSE goto3 END,
  goto4 = CASE WHEN goto4 = '".$D["sceneDelete"]."' THEN  'A' ELSE goto4 END
WHERE
    gameId=".$D["gameId"]." AND step=".($D["step"]-1)."";

		if ($writeDB) sql_query($D["QupdateUP"]);if (sql_error())  $D["sql_errorQupdateUP"]=sql_error();

		
		$D["Q"]="DELETE FROM `games_steps` WHERE gameId=".$D["gameId"]." AND step=".$D["step"]." AND scene='".$D["sceneDelete"]."'";
		if ($writeDB) sql_query($D["Q"]);if (sql_error())  $D["sql_error"]=sql_error();
		
	}
	
	$D["htm"]=getStructureHTM($D["gameId"]);
	echo json_encode($D);
	return;
}

################# getStructure

if ($D["action"]=="getStructure") {////////////////////////////////////
	$D["response"]=true;
	unset ($D["scene"], $D["step"]);
	$D["htm"]=getStructureHTM($D["gameId"]);
	echo json_encode($D);
	return;	
}
############## add step
if ($D["action"]=="addStep") {////////////////////////////////////
	if (  !is_numeric($D["step"]  )){
		$D["response"]=false;
		$D["reason"]="a little error occurred";
		if (!is_numeric($D["step"])) $D["reason"].=" missing step";
		echo json_encode($D);
		return;
	}	
	$D["newStepNumbers"] =$D["step"];
	
	
	$D["Q"]=array(
		"UPDATE `games_steps` SET `step` =".($D["newStepNumbers"]+2)." WHERE gameId=".$D["gameId"]." AND type='loosing' ",
		"UPDATE `games_steps` SET `step` =".($D["newStepNumbers"]+1)." WHERE gameId=".$D["gameId"]." AND type='winning' ",		
		"UPDATE `games` SET `steps` = ".$D["newStepNumbers"]." WHERE `games`.`gameId` =".$D["gameId"]."",
		"INSERT INTO `games_steps` (`gameId`, `step`, `scene`) VALUES (".$D["gameId"].",".$D["newStepNumbers"].",'A')"
	);
	
	
	if ($writeDB) 
		foreach($D["Q"] as $K => $Q){ //SCENE
			sql_query($Q);
			if (sql_error())  {
				$D["sql_error"].=" $K) ".sql_error();	
				//break;
			}
		}
	
	
	$D["response"]=true;
	unset ($D["scene"]);
	$D["htm"]=getStructureHTM($D["gameId"]);
	echo json_encode($D);
	return;	
}


# DELETE STEP
if ($D["action"]=="deleteStep") {////////////////////////////////////
	if (  !is_numeric($D["step"]  )){
		$D["response"]=false;
		$D["reason"]="a little error occurred";
		if (!is_numeric($D["step"])) $D["reason"].=" missing step";
		echo json_encode($D);
		return;
	}	
	
	$D["newStepNumbers"] =$D["step"]-1;
	$D["Q"]=array(
		"DELETE FROM `games_steps` WHERE gameId=".$D["gameId"]." AND step=".$D["step"]."",
		"UPDATE `games_steps` SET `step` =".($D["newStepNumbers"]+1)." WHERE gameId=".$D["gameId"]." AND type='winning' ",
		"UPDATE `games_steps` SET `step` =".($D["newStepNumbers"]+2)." WHERE gameId=".$D["gameId"]." AND type='loosing' ",
		"UPDATE `games` SET `steps` = ".$D["newStepNumbers"]." WHERE `games`.`gameId` =".$D["gameId"].""
	);
	
	
	if ($writeDB) 
		foreach($D["Q"] as $K => $Q){ //SCENE
			sql_query($Q);
			if (sql_error())  {
				$D["sql_error"].=" $K) ".sql_error();	
				//break;
			}
		}
	
	$D["response"]=true;
	unset ($D["scene"]);
	$D["htm"]=getStructureHTM($D["gameId"]);
	echo json_encode($D);
	return;	
}

////
function getStructureHTM($gameid){
	$SQ=sql_query("SELECT * FROM games_steps WHERE gameId =".$gameid." ORDER BY step ASC, scene ASC");	//
	//if (sql_error() ) return sql_error()."  SELECT * FROM games_steps WHERE gameId =".$gameid." ORDER BY step ASC, scene ASC";
	$D=array();
	while (	$S=sql_assoc($SQ)	){
		if (!$S["type"]) $maxStep=$S["step"];
		$D["s"][		$S["step"]	][		$S["scene"]				]=$S;
	}
	$D["steps"]=$maxStep;
	
	for ($stepN = 1; $stepN<= $D["steps"]+2; $stepN++) { // STEP
		$step=$D["s"][$stepN];
		$basicClass="stepScene";
		if ($stepN>$D["steps"]) $basicClass="stepSceneHalf";
		
		$O.='<div id="stepS_'.$stepN.'" class="'.$basicClass.'">';
		
		//////////////////////////////////////////////////////////////////
		//if (sizeOf($step)	>1) $O.='<div class="contFork">'; 
		if ($V["type"]!="winning" && $V["type"]!="loosing"	&& $stepN < $D["steps"]) $D["goto"][$stepN]=array();
		
		
		foreach($step as $scene => $V){ //SCENE
			
			$addClass="";
			if ($V["type"]=="winning") $addClass=" winningStep";
			if ($V["type"]=="loosing") $addClass=" loosingStep";
			
			//$scenePrint="";if ($D["forkFrom"]>0		&& sizeOf($step)	>1	)  
			$scenePrint="".$V["scene"];
			if ($stepN == 1) {
				$addClass=" sceneNowEditing";$scenePrint="";
			}
			$O.='<div id="stepM_'.$V["step"].'_'.$V["scene"].'" class="upContainerBox'.$addClass.'"	data-go2="'.implode(",",	array_unique( array($V["goto1"],$V["goto2"],$V["goto3"],$V["goto4"]))			 ).'">';
			
			//if (sizeOf($step)	>1) 	$O.='<div class="linePathM"></div>'; 
			//else 							$O.='<div class="linePathFork"></div>'; 
			
			//if ($V["step"]==3) $O.='<div id="editingAdvice"><span>'.L_editing.'</span><div class="triangleEdit"></div></div>';
			//if ($V["step"]==3) $O.='<div id="editingAdvice"><div class="triangleEdit"></div></div>';
			if ($V["scenario_id"]) 
				$O.='<img class="upContainerBoxImg boxScenario" src="/data/scenarios/'.$V["scenario_id"].'_640.jpg" width="110" height="62" alt="" />';
			else 
				$O.='<img class="upContainerBoxImg" src="/data/scenarios/editMenuCentered_640x360.png?b" width="110" height="62" alt="" />';				

			if (!$V["type"]) 	{
				$O.='<div id="conn_'.$V["step"].'_'.$V["scene"].'" class="upContainerBoxLegend">'.$V["step"].$scenePrint.'</div>';//'/'.$D["steps"]

			}
			if ($V["type"]=="winning") $O.='<div class="upContainerBoxLegendExtend">'.L_winning_end.'</div>';
			if ($V["type"]=="loosing") $O.='<div class="upContainerBoxLegendExtend">'.L_loosing_end.'</div>';
	
			// question dots
			if ($V["type"]!="winning" && $V["type"]!="loosing"	&& $stepN < $D["steps"]) {
				$O.='<div class="questionDotContainer">';
				for ($QD = 1; $QD<= 4; $QD++) { 
					$O.='<div id="Qdot_'.$V["step"].'_'.$V["scene"].'_'.$QD.'" class="questionDot"></div>';		
				}
				$O.='</div>';//questionDotContainer
				// cables from Qdot
				for ($QD = 1; $QD<= 4; $QD++) { 
					if ($V["goto".$QD]) $O.='<div id="GT_'.$stepN.'_'.$V["scene"].$QD.'" class="gotoGr gotoGr_'.$V["goto".$QD].' gotoGr_'.$V["scene"].$QD.'TO'.$V["goto".$QD].'"></div>';					
				}
			
			}
			

			
			
			$O.='</div>';//stepM_'.$V["step"].'_'.$V["scene"].'"
			

			// goto step cumulative
			if ($V["type"]!="winning" && $V["type"]!="loosing"	&& $stepN < $D["steps"]) {			
				$D["s"][$stepN][$V["scene"]]["gotos"]=array($V["goto1"],$V["goto2"],$V["goto3"],$V["goto4"]);
				$D["goto"][$stepN]=array_merge($D["goto"][$stepN], 
						array($V["goto1"],$V["goto2"],$V["goto3"],$V["goto4"])
				);
			}
			
			
		} ######################### each scena (A, B ...)
		
		////// addscene e placeHolders
		$maxHorizontal=4;
		if ($V["type"]!="winning" && $V["type"]!="loosing"	&& $stepN>1	) {
			$deleteSceneAddClass="";
			$addSceneAddClass="";
			if (sizeof($step)<$maxHorizontal)	{
				$emptyRemain=$maxHorizontal-sizeof($step)-1;
				
				if (sizeof($step)==1) $deleteSceneAddClass=" hiddenLeft";
				$O.='<div id="sceneHandler_'.$V["step"].'" class="sceneHandler"><div id="addScene_'.$V["step"].'_'.$V["scene"].'" class="addScene"><span>+</span></div><div id="deleteScene_'.$V["step"].'_'.$V["scene"].'" class="deleteScene'.$deleteSceneAddClass.'"><span>-</span></div></div>';// ADD			 '.sizeof($step).' '.$emptyRemain.'
				
				for ($SS = 1; $SS<= $emptyRemain; $SS++) { 
					$O.='<div class="sceneHolder"></div>';
				}
			}else{
				$sceneHandlerAddClass=" sceneHandlerABS";
				$addSceneAddClass=" hiddenLeft";
				$O.='<div id="sceneHandler_'.$V["step"].'" class="sceneHandler'.$sceneHandlerAddClass.'"><div id="addScene_'.$V["step"].'_'.$V["scene"].'" class="addScene'.$addSceneAddClass.'"><span>+</span></div><div id="deleteScene_'.$V["step"].'_'.$V["scene"].'" class="deleteScene'.$deleteSceneAddClass.'"><span>-</span></div></div>';// ADD			 '.sizeof($step).' '.$emptyRemain.'
			}
		}
		
		// cables to step after
		
		for($LETT = 'A'; $LETT <= 'D'; $LETT++) { 
			//$O.='<div class=".cableV .L_'.$LETT.'">'.$LETT.'</div>';
			if ( in_array($LETT, $D["goto"][$stepN])) $O.='<div id="cableV_'.$stepN.''.$LETT.'" class="cableV L_'.$LETT.'">'.$LETT.'</div>';
		}
				
		
		
		
		$O.='<div class="clear"></div>';	
		$O.='</div>'; //stepS_X
		if ($stepN==$D["steps"]  ) {
			$O.='<div class="stepHandler">';
			if ($D["steps"]>3) 		$O.='<div id="deleteStep_'.$D["steps"].'" class="deleteStep"><span>-</span> '.L_remove_the_step." ".$D["steps"].'</div>';
			if ($D["steps"]<20) 	$O.='<div id="addStep_'.($D["steps"]+1).'" class="addStep"><span>+</span> '.L_add_the_step." ".($D["steps"]+1).'</div>';
			
			$O.='</div>';
		}
	} // for
	return $O;
	
}

/*




INSERT INTO `games_steps` 
(`gameId`, `step`, `scene`, `scenario_id`, `avatar_id`, `avatar_size`, `avatar_pos`, `balloon_pos`, `arrowY`, `arrowPos`, `avatar_sentence`, `avatar_audio`, `compulsoryAttachments`, `answer_1`, `ascore_1`, `goto1`, `answer_2`, `ascore_2`, `goto2`, `answer_3`, `ascore_3`, `goto3`, `answer_4`, `ascore_4`, `goto4`, `type`, `idStep`) VALUES
(226, 5, 'A', NULL, NULL, 'S', NULL, '157,31', '11', 'left', NULL, NULL, 0, NULL, NULL, 'A', NULL, NULL, 'A', NULL, NULL, 'A', NULL, NULL, 'A', NULL, 2648);


<div id="stepM_2_A" class="upContainerBox sceneNowEditing" data-go2="A,B">
	<img class="upContainerBoxImg boxScenario" src="/data/scenarios/0_640.jpg" width="100%" height="auto" alt="">
	<div id="conn_2_A" class="upContainerBoxLegend">2/12A</div>
	<div class="questionDotContainer">
		<div id="Qdot_2_A_1" class="questionDot"></div>
		<div id="Qdot_2_A_2" class="questionDot"></div>
		<div id="Qdot_2_A_3" class="questionDot"></div>
		<div id="Qdot_2_A_4" class="questionDot"></div>
	</div>
	<div class="gotoGr gotoGr_A gotoGr_A1TOA"></div>
	<div class="gotoGr gotoGr_B gotoGr_A2TOB"></div>
	<div class="gotoGr gotoGr_A gotoGr_A3TOA"></div>
	<div class="gotoGr gotoGr_A gotoGr_A4TOA"></div>
</div>

*/
?>
