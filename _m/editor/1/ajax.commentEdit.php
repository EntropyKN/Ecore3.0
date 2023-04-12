<?php
include_once("../../../php.config.inc.php");
if (!loggedIn()) die("false|-|you are not logged");
if ($_SESSION["ulevel"]<1) die("false|-|you don't have the right permissions");
$D=$_POST;//["D"]
$D=array_map("trim",$D);
$D["ida"]=explode("_", $D["id"]);	//9_3  $D["state"]_$D["idsentence"]
$D["state"]=$D["ida"][0]+1;
$D["idsentence"]=$D["ida"][1]+1;
//unset($D["ida"],$D["id"]);
if (	
!is_numeric($D["idg"]) 
|| !is_numeric($D["state"]) || $D["state"]=="0"	
|| !is_numeric($D["idsentence"]) || $D["idsentence"]=="0" 
) 
die("false|-|data errors...");

//exist?
conn();


if ($D["ida"][0]!="fc") {
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
	$WHERE =" WHERE idgym =".$D["idg"]." AND state=".$D["state"]." AND idsentence=".$D["idsentence"];
	$strS="SELECT ids FROM palma_sentences $WHERE ";
	$D["strS"]=$strS;
	$C=mysql_fetch_assoc(mysql_query($strS));
	if (mysql_error()) $D["e"]=mysql_error();
	$D["update"]=false;if ($C["ids"]) $D["update"]=true;
	
	$Ddb=array_map("db_string",$D);
	if (!$D["update"]) {
		$fields.="idgym,";$values.="'".$Ddb["idg"]."',";
		$fields.="state,";$values.="'".$Ddb["state"]."',";
		$fields.="idsentence,";$values.="'".$Ddb["idsentence"]."',";		
		$fields.="comment,";$values.="'".$Ddb["v"]."' ";
		$D["Q"]="INSERT INTO palma_sentences (".trim($fields, ",").") VALUES (".trim($values, ",").") ";
	}else{
		$D["Q"]="UPDATE palma_sentences SET ";
		//$D["Q"].="idgym='".$Ddb["idg"]."',";
		//$D["Q"].="state='".$Ddb["state"]."',";
		$D["Q"].="comment='".$Ddb["v"]."' $WHERE";
	}
	
	mysql_query($D["Q"]);

	
	$D["Qe"]=mysql_error();
	if ($D["Qe"]) echo "false|-|db error: ".$D["Qe"];
}else{ //if ($D["ida"][]!="fc") {
///////////////////////////////////////////////////////////////////////// FINAL COMMENTS
	$Ddb=array_map("db_string",$D);
	$D["Q"]="UPDATE palma_gym SET ";
	$D["Q"].="fc".$D["ida"][1]."='".$Ddb["v"]."' WHERE idgym =".$D["idg"];
	mysql_query($D["Q"]);
	$D["Qe"]=mysql_error();
	if ($D["Qe"]) echo "false|-|db error: ".$D["Qe"];

}

	$D["QupX"]="UPDATE palma_gym SET editTs=".C_TIME.", uid_editor=".$_SESSION["uid"]." WHERE idgym =".$D["idg"]."" ;
	mysql_query(  $D["QupX"]   );
	
echo "true|-|";
print_r($D);
/*

 INSERT INTO palma_sentences (idgym,state,idsentence,comment) VALUES ('1','1','4','asdasdasd' ) WHERE idgym =1 AND state=1 AND idsentence=4

*/

?>