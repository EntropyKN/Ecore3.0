<?php
ini_set("display_errors", "1");
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");

if (!loggedIn()) die("false|-|you are not logged");
if ($_SESSION["ulevel"]<1) die("false|-|you don't have the right permissions");
$D=$_POST["D"];
$D=array_map("trim",$D);

//if (!$D["steps"] || !is_numeric($D["steps"])) echo "false|-|no steps";

if (!$D["valid_until"]) {
	//unset ($D["valid_until"]);
	$D["valid_until"]="NULL";
}else {
	$D["valid_until"]=(dateIT2dateDb(		$D["valid_until"]				));
}

$Ddb=array_map("db_string",$D);
$D["gameIdNew"]=0;
unset ($Ddb["stepsBefore"],$Ddb["structureBefore"] );
if (!$D["gameId"]) {
	$Ddb["steps"]=3;
	$Ddb["uid_creator"]=$_SESSION["uid"];
	$Ddb["createdTs"]=time();	
	unset ($Ddb["gameId"]);$fields="";$values="";
	foreach($Ddb as $key => $value){
		$fields.="$key,";
		$values.="'$value',";
	}
	$values=str_replace("'NULL'", "NULL", $values);
	
	$D["Q"]="INSERT INTO games (".trim($fields, ",").") VALUES (".trim($values, ",").")";
	//sql_query("TRUNCATE games");
	sql_query($D["Q"]);
	
	$D["gameIdNew"]=sql_id();
	$D["Qe"]=sql_error();

	
	for ($stepp = 1; $stepp <= $Ddb["steps"]; $stepp++) {
		sql_query("INSERT INTO `games_steps` (gameId, step) VALUES  (".$D["gameIdNew"].", $stepp			)");
		if (sql_error()) $D["addQ1"][$stepp]=sql_error();	
	}

	sql_query("INSERT INTO `games_steps` (`gameId`, `step`, type) VALUES (".$D["gameIdNew"].", ". ($Ddb["steps"]+1).",'winning'			)");
	sql_query("INSERT INTO `games_steps` (`gameId`, `step`, type) VALUES (".$D["gameIdNew"].", ". ($Ddb["steps"]+2).",'loosing'			)");
	//if (sql_error())  $D["addQ1"][$stepp]=sql_error();	
    
	if (!$D["Qe"]) echo "true|-|".$D["gameIdNew"];
	if ($D["Qe"]) echo "false|-|db error: ".$D["Qe"];	
	
}else{
	unset ($Ddb["gameId"]);
	$Ddb["uid_editor"]=$_SESSION["uid"];
	$Ddb["editTs"]=time();	

	$D["Q"]="UPDATE games SET ";
	foreach($Ddb as $key => $value){
	  $D["Q"].="$key='$value', ";
	}
	$D["Q"]=str_replace("'NULL'", "NULL", $D["Q"]);
	$D["Q"]=trim($D["Q"], ", ");
	$D["Q"].=" WHERE gameId=".$D["gameId"];

	 sql_query($D["Q"]);
	$D["Qe"]=sql_error();

	if (!$D["Qe"]) {
		$D["QupX"]="UPDATE games SET editTs=".C_TIME.", uid_editor=".$_SESSION["uid"]." WHERE gameId =".$D["gameId"]."" ;
		sql_query(  $D["QupX"]   );	
		
		
		echo "true|-|".$D["gameId"];
	}else{
		
		echo "false|-|db error: ".$D["Qe"];
	}
	//echo "false|-|update ";	

}


$D["addQ1"]=array();
$D["addQstru"]=array();

$D["gameIdStep"]=$D["gameIdNew"];
if (!$D["gameIdStep"]) $D["gameIdStep"]=$D["gameId"];


echo "|-|";
print_r($D);

//////////////


?>