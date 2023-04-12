<?php
ini_set("display_errors", "1");
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
if (!loggedIn()) die("false|-|you are not logged");
if ($_SESSION["ulevel"]<1) die("false|-|you don't have the right permissions");


$D=$_POST;//["D"]
$D=array_map("trim",$D);


##checks

if ($D["action"] =="getGroup"){
	if (	!$D["idg"] || !is_numeric($D["idg"])  )  die("false|-|data errors...".print_r($D,true));
	require_once(C_ROOT."/config/php.function.group.php");
	$g=getGroup($D["idg"]);
	$D["g"]=$g["d"][0];
	//$D["Qe"]=sql_error();
	//echo "true|-|";
	//print_r($D);
	echo json_encode($D["g"]);
	die;
}
if ($D["action"] =="delete" && $D["idg"]){
	if (	!$D["idg"] || !is_numeric($D["idg"])  )  die("false|-|data errors...".print_r($D,true));
	$D["q"]="DELETE FROM usersgroups WHERE idgroup=".$D["idg"];
	sql_query($D["q"]);
		sql_query("delete FROM user_usersgroups WHERE idgroup=".$D["idg"]);
		sql_query("delete FROM game_usersgroups WHERE idgroup=".$D["idg"]); 	
		sql_query("delete FROM usersgroups_insighters WHERE idgroup=".$D["idg"]); 	
	
	echo "true|-|";
	print_r($D);
	die;
}
if ($D["action"] =="save"){
	$time=C_TIME;$idtrans="0";
	if (	!$D["idg"] || !is_numeric($D["idg"])  ) $D["idg"]=0;
	if (!$D["idg"]){
		
		$D["Q1"]="INSERT INTO usersgroups (name, description_it, createts, editedts, family) VALUES ('".db_string($D["name"])."', '".db_string($D["description_it"])."', ".$time.", ".$time.", '".db_string($_SESSION["family"])."');";
		sql_query($D["Q1"]);
		if (sql_error()) die (sql_error());
		$D["idg"]=sql_id();
		$idtrans=$D["idg"];
		
	}else{ // insert
		$D["Q1"]="UPDATE usersgroups SET name = '".db_string($D["name"])."', description_it = '".db_string($D["description_it"])."', 
		editedts =".C_TIME." WHERE idgroup =".$D["idg"];
		sql_query($D["Q1"]);
		 //
	}
	
	
	
	if ($D["idg"]){
		// insert relative
		sql_query("delete FROM user_usersgroups WHERE idgroup=".$D["idg"]);
		sql_query("delete FROM game_usersgroups WHERE idgroup=".$D["idg"]); 	
		sql_query("delete FROM usersgroups_insighters WHERE idgroup=".$D["idg"]); 
		
		# users 
		$D["users"]=explode(",", $D["usersCSV"]);
		if (!empty($D["users"])) {
			$D["Quser"] ="INSERT INTO user_usersgroups ( uid,	idgroup) VALUES ";
			foreach( $D["users"] as $k => $v ) {
				$D["Quser"] .="($v, ".$D["idg"]."),";
			}
			$D["Quser"]=rtrim($D["Quser"], ",");
			sql_query($D["Quser"]);
		}
	
		# gyms 
		$D["gyms"]=explode(",", $D["gymsCSV"]);
		if (!empty($D["gyms"])) {
			$D["Qgym"] ="INSERT INTO game_usersgroups ( gameId,	idgroup) VALUES ";
			foreach( $D["gyms"] as $k => $v ) {
				$D["Qgym"] .="($v, ".$D["idg"]."),";
			}
			$D["Qgym"]=rtrim($D["Qgym"], ",");
			sql_query($D["Qgym"]);
		}
		

		# insighters 
		$D["insighters"]=explode(",", $D["insightersCSV"]);
		if (!empty($D["insighters"])) {
			$D["Qinsighters"] ="INSERT INTO usersgroups_insighters ( uid,	idgroup, addedTs) VALUES ";
			foreach( $D["insighters"] as $k => $v ) {
				$D["Qinsighters"] .="($v, ".$D["idg"].", $time),";
			}
			$D["Qinsighters"]=rtrim($D["Qinsighters"], ",");
			sql_query($D["Qinsighters"]);
		}		
		
		
	}
		//true|-|15:33|-									|6|-							|1|-						|0|-|1560519227|-|
	
	echo "true|-|".date("H:i",$time)."|-|".count($D["users"])."|-|".count($D["gyms"])."|-|$idtrans|-|$time|-|";
	
	unset ($D["gyms"]);unset ($D["users"],$D["insighters"]);
	print_r($D);
	die;	
}

?>