<?php
$F1=array(
"language",
"title",
"Description",
"Goal_1",
"Goal_2",
"Goal_3",

//"cover_id",
);

$F1t=array(
L_language,
L_title,
L_description,
L_game_goal,
L_game_goal." 2",
L_game_goal." 3",

//L_cover,
);


$F1f=array(
"language", //"language",
"input",
"area",
"area",
"area",
"area",
//"cover_id"

);
$F1[]="balloonFont";
$F1t[]=L_balloon_fonts;
$F1f[]="fontSelect";

$F1[]="dontShowDebriefScore";
$F1t[]='';
$F1f[]="dontShowDebriefScore";


if ($gameId>0) { // numeric found by /_m/editor/edit.php
	$D=sql_queryt("SELECT * FROM games WHERE gameId=".db_string($gameId));
	if ($D["status"]=="playable") {
		header("location: /");
		exit();
	}


}

?>