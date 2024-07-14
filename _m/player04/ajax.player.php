<?php
ini_set("display_errors", "1");
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
if (!loggedIn()) die("false|-|you are not logged");
$G=$_POST["data"];
if ($_GET["gameId"]) $G=$_GET;
//$G=@array_map("trim",$G);

//if ($G["uid"] || !is_numeric($G["uid"])) die("false|-|who are you?");

if (!$G["gameId"] || !is_numeric($G["gameId"] )) die("false|-|what are you playing?");
//stepon
switch ($G["cmd"]) :
	case "stepon":////////////////////
/*
  [cmd] => stepon
    [gameId] => 8
    [stepIndex] => 0
    [answer] => 2
    [idm] => 58
    [score] => 9

*/	

	if (
	(!$G["gameId"] || !is_numeric($G["gameId"] ))||
	(!$G["idm"] || !is_numeric($G["idm"] ))||
	(!$G["answer"] || !is_numeric($G["answer"] ))||
	(!is_numeric($G["stepIndex"] )) ||
	(!is_numeric($G["score"] ))	
		) die("false|-|wrong_data|-|".print_r($G,true));

	$G["Q"]="INSERT INTO `matches_step` (
	`idm`, `step`, `scene`,steps, 
	`ascore`, `answerN`, `ts`) VALUES
	 (".$G["idm"] .", ".($G["stepIndex"]+1) .", '".$G["scene"] ."',".$G["steps"] .",
	 ".$G["score"] .", ".$G["answer"] .", ".C_TIME.")";
	sql_query($G["Q"]);
	$G["Qe"]=sql_error();
		echo "true";
		echo "|-|";
		print_r($G);
		die();exit();		
	break;
	
	
	
	case "finalCalc"://////////////////// idm 124
		if (
		(!$G["gameId"] || !is_numeric($G["gameId"] ))||
		(!$G["idm"] || !is_numeric($G["idm"] ))
			) die("false|-|wrong_data|-|".print_r($G,true));
		include_once($_SERVER['DOCUMENT_ROOT']."/config/php.function.games.php");
		$G["f"]= finalCalc2($G["idm"],true); //true
		
		echo "true";
		echo "|-|";echo 		json_encode( $G["f"]["stepFinal"]);
		echo "|-|";
		print_r($G["f"]);
		die();exit();	
	
	break;
	
	case "getExchanges":////////////////////
		if (
		(!$G["idm"] || !is_numeric($G["idm"] ))
			) die("false|-|wrong_data|-|".print_r($G,true));
		include_once($_SERVER['DOCUMENT_ROOT']."/config/php.function.games.php");
		$G["f"]= matchExchanges($G["idm"]);
		
		echo "true";
		echo "|-|";
		echo 		 $G["f"]["dialogue_html"];
		echo "|-|";
		print_r($G);
		die();exit();	
	
	break;	
	
	default:
	die("false|-|no case|-|".print_r($G, true));
endswitch;
// INSERT INTO `matches` (`gameId`, `uid`, `start`, `end`, `idm`) VALUES ('1', '1', '123123', NULL, NULL);

?>