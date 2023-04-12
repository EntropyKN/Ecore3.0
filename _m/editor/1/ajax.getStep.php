<?php
ini_set("display_errors", "1");
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");

if (!loggedIn()) die("false|-|you are not logged");
if ($_SESSION["ulevel"]<1) die("false|-|you don't have the right permissions");

$post=array_map("trim",$_POST);

$strG="SELECT gm.* , s.name as scenarioName FROM games_steps gm 
LEFT join scenarios s on s.id=gm.scenario_id
WHERE gm.gameId =".$post["gameId"]." AND gm.step =".$post["step"]." AND gm.scene ='".$post["scene"]."' ";
$D["data"]=sql_queryt($strG);

if (sql_error()) die ("false|-|".sql_error().$strG);
$D["data"][	"attachmentQ"	]="SELECT 
idAttachment, title, path, type FROM games_steps_attachments WHERE gameId =".$post["gameId"]." AND step =".$post["step"]." AND scene ='".$post["scene"]."' ORDER BY idAttachment ASC";  
$SQ=sql_query($D["data"][	"attachmentQ"	]); unset ($D["data"][	"attachmentQ"	]);
$D["data"][	"attachment"	]=array(); 
while (	$S=sql_assoc($SQ)	){
	$D["data"][	"attachment"	][]=$S;
}



$D["data"][	"game"	]=sql_queryt("SELECT L1_comment, L2_comment,L3_comment,L4_comment, 	W1_comment ,W2_comment,W3_comment,W4_comment 
 FROM `games` WHERE gameId =".$post["gameId"]."");
$D["data"][	"gameE"	]=sql_error();
$D["data"]["linkRefC"]=("add|".$post["gameId"]."|".$post["step"]."|".$post["scene"]."");
$D["data"]["linkRef"]=rawurlencode(crypta($D["data"]["linkRefC"])); //unset ($D["data"]["linkRefC"]);
$D["post"]=$post;
$D["Q1"]=$strG;
echo "true|-|";
echo json_encode($D["data"]);

echo "|-|";print_r($D);

?>