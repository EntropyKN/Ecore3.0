<?php
function getGroup($id=0, $cmd="modified", $noFamily=false){

	//$order="modified"
	///*	LEFT JOIN players P ON (P.player_id=PM.uid2) */
	////////////////////// DATA G.description_en,G.createts,G.editedts,G.orderg
		$D["Q"]="SELECT  G.idgroup,G.name,G.description_it
	FROM usersgroups G WHERE 1 
	";
	if (!$noFamily) $D["Q"].=" AND G.family='".$_SESSION["family"]."'";
	
	if ($id && is_numeric($id)) $D["Q"].=" AND G.idgroup=$id ";
	// default order
	$D["Q"].=" ORDER BY G.editedts DESC, G.idgroup DESC limit 0,200"; //G.orderg ASC, 
	
	
	$i=0;
	$q=sql_query($D["Q"]);
//	$D["Qe"]=sql_error();return $D;
	
	while (	$d=sql_fetch_assoc($q)) {
		if ( $cmd=="csv") {$d["usersCsv"]="";$d["gymCsv"]="";$d["insightersCsv"]="";}
		
		
		# insighters
		$d["insighters"]=array();$Ucount=1;$d["insightersTitle"]="";//$d["usersCSV"]="";
		$d["Qi"]="SELECT U.users_id uid, Concat(U.user_real_name,' ', U.user_real_surname) uname  FROM usersgroups_insighters UG 
		LEFT JOIN users U ON (U.users_id=UG.uid) 
		WHERE UG.idgroup=".$d["idgroup"];
		
		$qUi=sql_query($d["Qi"]);
		while (	$dU=sql_fetch_assoc($qUi)) {
			if ( $cmd=="csv") $d["nsightersCsv"].=",".$dU["uid"];
			$d["insighters"][]=$dU;
			if ($Uicount<=5) $d["insightersTitle"].=$dU["uname"].", ";
			$Uicount++;
			//$d["usersCSV"].=$dU["uid"].",";
		}
		//$d["usersCSV"]=rtrim($d["usersCSV"],",");  
		$d["insightersTitle"]=rtrim($d["insightersTitle"],", ");  
		if (sizeof($d["insighters"])>5) 
			$d["insightersTitle"].=" +".(sizeof($d["insighters"])-5);
		unset ($d["Qi"]);
		
		//---------------------------------------------------------		
		
	
		# users
		$d["users"]=array();$Ucount=1;$d["userTitle"]="";//$d["usersCSV"]="";
		$d["Q"]="SELECT U.users_id uid, Concat(U.user_real_name,' ', U.user_real_surname) uname  FROM user_usersgroups UG 
		LEFT JOIN users U ON (U.users_id=UG.uid) 
		WHERE UG.idgroup=".$d["idgroup"];
		
		
		$qU=sql_query($d["Q"]);
		$d["userTitle"]="";
		while (	$dU=sql_fetch_assoc($qU)) {
			if ( $cmd=="csv") $d["usersCsv"].=",".$dU["uid"];
			$d["users"][]=$dU;
			if ($Ucount<=5) $d["userTitle"].=$dU["uname"].", ";
			$Ucount++;
			//$d["usersCSV"].=$dU["uid"].",";
		}
		//$d["usersCSV"]=rtrim($d["usersCSV"],",");  
		$d["userTitle"]=rtrim($d["userTitle"],", ");  
		if (sizeof($d["users"])>5) 
			$d["userTitle"].=" +".(sizeof($d["users"])-5);
		//unset ($d["Q"]);
		
		//---------------------------------------------------------
		
		# gyms  gym_usersgroups		game_usersgroups
		$d["gyms"]=array();$Gcount=1;$d["gymTitleWeb"]=""; //$d["usersCSV"]="";
		$d["Qg"]="SELECT G.gameId, G.title 
		FROM games G
		LEFT JOIN game_usersgroups GG ON (GG.gameId=G.gameId) 
		WHERE 
		/*
		G.status='playable' AND 
		*/
		GG.idgroup=".$d["idgroup"];
		$qG=sql_query($d["Qg"]);
		while (	$dG=sql_fetch_assoc($qG)) {
			if ( $cmd=="csv") $d["gymCsv"].=",".$dG["gameId"];
			$d["gyms"][]=$dG;
			if ($Gcount<=5) $d["gymTitleWeb"].=$dG["title"].", ";
			$Ucount++;
		}	
		$d["gymTitleWeb"]=rtrim($d["gymTitleWeb"],", ");  
		if (sizeof($d["gyms"])>5) 	$d["gymTitleWeb"].=" +".(sizeof($d["gyms"])-5);
		unset ($d["Qg"]);
		if ( $cmd=="csv")  {
			$d["gymCsv"]=ltrim($d["gymCsv"], ",");
			$d["usersCsv"]=trim($d["usersCsv"], ",");
			unset ($d["users"], $d["gyms"]);
		}
		//
		if ($id) unset ($d["gymTitleWeb"], $d["userTitle"], $d["insightersTitle"]);
			
		// assign
		$D["d"][$i]=$d;
		
		##dataJs
//		unset ($d["gymTitleWeb"], $d["userTitle"]);
		//$D["d"][$i]["dataJs"]=(json_encode($d)); //urlencode
		
		
		
		$i++;
	}	
	unset ($D["Q"]);
	return $D;	
}

function getUsersGroup($uid){
	$d["uid"]=$uid;$d["groupCSV"]="";$d["groupHTM"]="";
	$d["groups"]=array();
	$d["Q"]="SELECT  UG.idgroup,	G.name		
	FROM user_usersgroups UG 
	LEFT JOIN users U ON (U.users_id=UG.uid) 
	LEFT JOIN usersgroups G ON (G.idgroup=UG.idgroup) 
	WHERE U.users_id=".$d["uid"];
	$qG=sql_query($d["Q"]);
	while (	$dG=sql_fetch_assoc($qG)) {
		$d["groups"][]=$dG;
		$d["groupCSV"].=$dG["idgroup"].",";
		$d["groupHTM"].='<div class="tag" id="taggroup_'.$dG["idgroup"].'">'.$dG["name"]."<a href=\"#\">X</a></div>";
	}
	$d["groupCSV"]=trim($d["groupCSV"],",");
	return $d;	
}

?>