<?php
$D=$_GET; 
require_once(C_ROOT."/_m/insights/global.inc.php");



/*

 [cfrom] => 1527458400 
 [cto] => 1527976800 
 [ids_group] => 3,6,1,30 
 [ids_user] => 23,24,116,21,115,88,93,91,17,94,87,19,83,22,92,114,2,16,89,25,86,4,27,26,82 
 [ids_gym] => 53,30,45,46,43
*/
$D["cfromDB"]=timestamp2db($D["cfrom"], "long");
$D["ctoDB"]=		timestamp2db($D["cto"], "brief")." 23:59:59";
$D["cto"]=strtotime($D["ctoDB"]);
$D["ctoDB"]=timestamp2db($D["cto"], "long");

$D["ids_groupGO"]=array();
$D["ids_gymGO"]=array();
$D["ids_userGO"]=array();

$D["ids_groupA"]=explode(",",$D["ids_group"]);
$D["ids_gymA"]=explode(",",$D["ids_gym"]);
$D["ids_userA"]=explode(",",$D["ids_user"]);

/// permission filter
if ($_SESSION["ulevel"]==0	)	{
	$D["CASO"]=1;
	/*$DD=getGymUserFromGroups($_SESSION["insights"]["groups"]);
	$D["ids_groupAP"]=$DD["ids_group"];
	$D["ids_groupGO"]=array_intersect($D["ids_groupA"],$D["ids_groupAP"]);	
	
	$D["ids_gymAP"]=$DD["ids_gym"];
	$D["ids_gymGO"]=array_intersect($D["ids_gymA"],$D["ids_gymAP"]);	
	
	$D["ids_userAP"]=$DD["ids_user"];
	$D["ids_userGO"]=array_intersect($D["ids_userA"],$D["ids_userAP"]);
*/
}else{
	$D["CASO"]=2;
	$D["ids_groupGO"]=$D["ids_groupA"];
	$D["ids_gymGO"]=$D["ids_gymA"];
	$D["ids_userGO"]=$D["ids_userA"];		

//	$D=getGymUserFromGroups("ALL");
}


$D["ids_groupGO"]=array_filter($D["ids_groupGO"]);
$D["ids_gymGO"]=array_filter($D["ids_gymGO"]);
$D["ids_userGO"]=array_filter($D["ids_userGO"]);		

// remove IDGROUPGHOST
foreach ($D["ids_groupGO"] as $key => $value){
    if ($value == IDGROUPGHOST) {
        unset($D["ids_groupGO"][$key]);
    }
}

 /*
unset (
$D["ids_groupAP"],
$D["ids_gymAP"],
$D["ids_userAP"],

$D["ids_groupA"],
$D["ids_gymA"],
$D["ids_userA"]
);

*/


/*
LOGICA:
funziona sempre solo con palestre e utenti

-> se non ci sono palestre 
le palestre sono prese dai gruppi

-> se non ci sono utenti
gli utenti sono presi dai gruppi



m.scoreTotal, m.scoreInterval, 
*/


$D["Q"]="SELECT  
m.idm, m.uid, m.final,

u.user_real_name as first_name, u.user_real_surname as last_name, u.user_email as email, 
Concat (u.user_real_name, ' ', u.user_real_surname) name,
m.start startTime, m.end endTime ,
g.title, g.competence_target, g.estimated_duration, m.gameId
FROM matches m 
LEFT JOIN games g on g.gameId=m.gameId 
LEFT JOIN users u on u.users_id=m.uid 
WHERE 1
and  m.final IS NOT NULL 
/* 
AND start>=".db_string($D["cfrom"])."
AND end<=".db_string($D["cto"])."
AND  g.status!='draft' AND  g.status!='deleted' */
";
//$D["ids_groupGO"]=array();$D["ids_userGO"]=array(); /// cancellami
if (!empty($D["ids_groupGO"]) && empty ($D["ids_gymGO"])					 ) {

	$D["Q"].=" /*<strong>Gym from groups</strong>*/
	AND g.gameId IN 
	(SELECT 
	DISTINCT GG.gameId
	FROM game_usersgroups GG
	WHERE GG.idgroup IN (".db_string(@implode (",",$D["ids_groupGO"])			).") 
	)";
	
}

if (!empty($D["ids_groupGO"]) && empty ($D["ids_userGO"]) ) {

	$D["Q"].=" /*<strong>user from groups</strong>*/
	AND m.uid IN 
	(SELECT 
	DISTINCT UG.uid
	FROM user_usersgroups UG
	WHERE UG.idgroup IN (".db_string(@implode (",",$D["ids_groupGO"])			).") 
	) ";
	
}

if (!empty ($D["ids_gymGO"]) ) 
	$D["Q"].=" /*<strong>Gym from Gym</strong>*/
	AND g.gameId IN (".db_string(@implode (",",$D["ids_gymGO"])			).") 
	";
	
if (!empty ($D["ids_userGO"]) ) 
	$D["Q"].=" /*<strong>user from user</strong>*/
	AND m.uid  IN (".			db_string(implode(",",$D["ids_userGO"]))				.") 
	";

$D["Q"].=" ORDER BY startTime DESC ";//LIMIT 0,1000

$q=sql_query($D["Q"]);
$D["r"]=array();
if (sql_error()) {
	echo sql_error();
	echo "<br />".$D["Q"];
	die ;
}

$D["uids"]=array();$D["gameIds"]=array();
$D["userReport"]=array();
//$D["res"]["user"]

while (	$d=sql_fetch_assoc($q)) {
	$d["from"]=timestamp2red($d["startTime"], "excel", LANG);
	$d["to"]=timestamp2red($d["endTime"], "excel", LANG);
	$d["secs"]=$d["endTime"]-$d["startTime"];
	if ($d["secs"]<0) $d["secs"]=0;
	$d["score"]="wip";
	$d["duration"]=getElapsedTimeString($d["secs"]); //unset ($d["secs"]);
//	,$format="seconds", $short=true, $nosecs=false) {
	if (!in_array($d["uid"], $D["uids"])){
		$D["uids"][]=$d["uid"];
		$D["userReport"][$d["uid"]]["name"]=$d["name"];
		//$D["userReport"][$d["uid"]]["uid"]=$d["uid"];
		//$D["userReport"][$d["uid"]]["gyms"]=array();
	}
	
	if (!in_array($d["gameId"], $D["gameIds"])){
		$D["gameIds"][]=$d["gameId"];
		$D["gymReport"][$d["gameId"]]["name"]=$d["title"];
		//$D["gymReport"][$d["gameId"]]["gameId"]=$d["gameId"];	
	}	
	$D["userReport"][$d["uid"]]["gyms"][]=$d["gameId"];
	$D["userReport"][$d["uid"]]["matches"][]=$d["idm"];
	$D["userReport"][$d["uid"]]["secs"]+=$d["secs"];
	
	$D["userReport"][$d["uid"]][		$d["scoreInterval"]			]++;
	
	
	$D["gymReport"][$d["gameId"]]["users"][]=$d["uid"];
	$D["gymReport"][$d["gameId"]]["matches"][]=$d["idm"];
	$D["gymReport"][$d["gameId"]]["secs"]+=$d["secs"];
	
	$D["gymReport"][$d["gameId"]][		$d["scoreInterval"]			]++;
	foreach( $finalS as $FK => $FF ){
		if ($d["final"]==$FF) $D["gymReport"][$d["gameId"]][$FF]++;
	}
	
	$D["r"][]=$d;
}

// uniquezer
if ($D["userReport"]) foreach( $D["userReport"] as $k => $v ) {

	$D["userReport"][$k	]["gyms"]=array_unique($D["userReport"][$k]["gyms"]);
	$D["userReport"][$k	]["Ngyms"]=sizeof($D["userReport"][$k	]["gyms"]);
	$D["userReport"][$k	]["matches"]=array_unique($D["userReport"][$k]["matches"]);
	$D["userReport"][$k	]["Nmatches"]=sizeof($D["userReport"][$k	]["matches"]);
	
}
$D["userReport"]=sortBySubValue($D["userReport"], "Nmatches");


//sortBySubValue($array, $value, $asc = false, $preserveKeys = true)
if ($D["gymReport"]) foreach( $D["gymReport"] as $k => $v ) {

	$D["gymReport"][$k	]["matches"]=array_unique($D["gymReport"][$k]["matches"]);
	$D["gymReport"][$k	]["Nmatches"]=sizeof($D["gymReport"][$k	]["matches"]);
	$D["gymReport"][$k	]["users"]=array_unique($D["gymReport"][$k]["users"]);
	$D["gymReport"][$k	]["Nusers"]=sizeof($D["gymReport"][$k	]["users"]);


	foreach( $finalS as $FK => $FF ){
		if ($D["gymReport"][$k	][$FF]) 
			$D["gymReport"][$k	][$FF."P"]=$D["gymReport"][$k	][$FF]/$D["gymReport"][$k	]["Nmatches"];	
	}
	
/*	$D["gymReport"][$k	]["assertiveP"]=0;
	if ($D["gymReport"][$k	]["assertive"]) $D["gymReport"][$k	]["assertiveP"]=$D["gymReport"][$k	]["assertive"]/$D["gymReport"][$k	]["Nmatches"];
	$D["gymReport"][$k	]["submissiveP"]=0;
	if ($D["gymReport"][$k	]["submissive"]) $D["gymReport"][$k	]["submissiveP"]=$D["gymReport"][$k	]["submissive"]/$D["gymReport"][$k	]["Nmatches"];
	$D["gymReport"][$k	]["aggressiveP"]=0;
	if ($D["gymReport"][$k	]["aggressive"]) $D["gymReport"][$k	]["aggressiveP"]=$D["gymReport"][$k	]["aggressive"]/$D["gymReport"][$k	]["Nmatches"];
*/	
	
}
$D["gymReport"]=sortBySubValue($D["gymReport"], "Nusers");

$D["singleUser"]=false;
if (sizeof($D["ids_userGO"])==1) $D["singleUser"]=true;

/*
unset (
$D["ids_groupGO"],
$D["ids_gymGO"]
,$D["ids_userGO"]
);

*/
$lang_trigger="usr";
include_once("../../config/lang.inc.php");


?>