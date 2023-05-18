<?php

ini_set("display_errors", "1");
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
if ($_SESSION["ulevel"]<1) die("false|-|you don't have the right permissions");

$D=$_POST;$D=array_map("trim",$D);
if (!$D["gameId"]  || !is_numeric($D["gameId"])  )  die("false|-|data errors...".print_r($D,true));
$gameId=$D["gameId"];


$D["response"]="false";
$D["ftext"]=false;
$lang_trigger="edt";
require_once(C_ROOT."/config/lang.inc.php");
$fieldMissNoType=array(
	"scenario_id"=>L_scenario,
	"avatar_id"=>L_avatar,
	"avatar_sentence"=>L_avatar_sentence." F",
	"avatar_audio"=>L_avatar_sentence_audio,

	"answer_1"=>L_answer." 1",
	"answer_2"=>L_answer." 2",
	"ascore_1"=>L_score." 1",
	"ascore_2"=>L_score." 2",
);

$fieldMissYesType=array(
	"scenario_id"=>L_scenario,
	"avatar_id"=>L_avatar,
	"avatar_sentence"=>L_final_sentence,
	"avatar_audio"=>L_final_sentence_audio,
);

/*$fieldMissComments=array(
	"L1_comment"=>L_scenario,
	"L2_comment"=>L_avatar,
	"L3_comment"=>L_final_sentence,
	"L4_comment"=>L_final_sentence_audio,
	
	"W1_comment"=>L_scenario,
	"W2_comment"=>L_avatar,
	"W3_comment"=>L_final_sentence,
	"W4_comment"=>L_final_sentence_audio,
);
*/

/*
$strG="SELECT * FROM games WHERE gameId =".$gameId."";
$D["g"]=sql_fetch_assoc(sql_query($strG));
 */

$SQ=sql_query("SELECT  * FROM games_steps WHERE gameId =".$gameId." ORDER BY step ASC, scene ASC");
$D["s"]=array();
$SC=0;
while (	$S=sql_assoc($SQ)	){
	$SC++;

	
	
	/*	
	step	scenario_id 	avatar_id	avatar_size	avatar_pos	balloon_pos	arrowY	arrowPos	avatar_sentence	 avatar_audio	compulsoryAttachments	answer_1	ascore_1	answer_2	ascore_2	answer_3	ascore_3	answer_4	ascore_4	
	*/
	$D["s"][		$S["step"]		]=$S;
	

		
	$fieldMiss=$fieldMissNoType;
    if ($S["type"]) $fieldMiss=$fieldMissYesType;
	

	
	foreach($fieldMiss as $field => $text){
		$response=true;
		if  (!$S[$field] && $field!="ascore_1" && $field!="ascore_2") 														$response=false;
		if (!is_numeric($S[$field]) && ($field=="ascore_1" || $field=="ascore_2")					)	 					$response=false;
        $fieldA=explode("_", $field);
        if ($fieldA[0]=="answer" && $S[$field]=="0" ) $response=true;
        
		if (!$response) {
			$D["ftext"]=L_step."  ".$S["step"]." ".$S["scene"]."";
			if ($S["type"]=="winning")  $D["ftext"]=L_winning_end;
			if ($S["type"]=="loosing")  $D["ftext"]=L_loosing_end;
			
			$D["ftext"]="<strong>".$D["ftext"]."</strong>";
			$D["ftext"].=":<br />".$text." ".L_missing;
			echo "false";
			echo "|-|".$D["ftext"];
			echo "|-|";
			print_r($D);
			break;
			die();	
			exit();
		}		
	}

	if (!$S["type"]){
		$D["s"][		$SC	]["scoresA"]=array();
		for ($p = 1; $p <=4; $p++) {
			if (is_numeric($S["ascore_".$p]) ) $D["s"][	$SC	]["scoresA"][]=$S["ascore_".$p];
		}
		$D["s"][	$SC	]["MINSCORE"]=min($D["s"][	$SC	]["scoresA"]);	
		if (	$D["s"][	$SC	]["MINSCORE"]>0)  {
			$D["ftext"]=L_step."  ".$S["step"]." ".$S["scene"].": <strong>".L_at_least_one_score_must_be_zero."</strong>";
			echo "false";
			echo "|-|".$D["ftext"];
			echo "|-|";
			print_r($D);
			break;
			die();	
			exit();			
			
			
		}
	}

	
	
	/*for ($SS = 1; $SS <=$S["steps"]; $S++) {
		$D["s"][		$SS	]["MINSCORE"]=min($D["s"][		$SS	]["scoresA"]);
	}*/
	
	/*echo "false|-|";
	//print_r($R);
	print_r($D);	
	*/
	
	if ($D["ftext"]) {
		break;
		die();
	}
	
}

/////////



$D["cmt"]=sql_queryt("SELECT  L1_comment, L2_comment, L3_comment, L4_comment, W1_comment, W2_comment, W3_comment	, W4_comment
 FROM games WHERE gameId =".$gameId."");
 $D["cmtE"]=sql_error();
  
if ($D["cmt"]) foreach($D["cmt"] as $K => $V){
	if (!trim($V)){
		$D["ftext"]="<strong>".L_qualitative_comments."</strong>:<br />".L_comment." ".str_replace("_comment", "", $K)." ".L_missing;
		echo "false";
		echo "|-|".$D["ftext"];
		echo "|-|";
		print_r($D);
		break;
		die();	
		exit();
	}
	
}
////////////




echo "true";
echo "|-|".$D["ftext"];
echo "|-|";
//print_r($R);
print_r($D);
echo "|-|";

die();
exit();





die();




?>