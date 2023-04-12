<?php
ini_set("display_errors", "1");
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
if ($_SESSION["ulevel"]<1) die("false|-|you don't have the right permissions");
/*function audioNameCreate($D){
	$name=$D["gameId"]."_".$D["step"].".mp3";
	return $name." ";
}
*/
$D=$_POST;
$D=array_map("trim",$D);


if ($D["cmd"]=="delete"){
	$D["fileName"]=$D["gameId"]."_".$D["step"]."_".$D["scene"].".mp3";
	$D["unlink"]=@unlink(			$_SERVER['DOCUMENT_ROOT']."/data/audio/".$D["fileName"]					);
	echo "true|-|";

	print_r($D);
}else{


	
	if ( 0 < $_FILES['file']['error'] ) die("false|-|fileError:".$_FILES['file']['error']);
	
	$D["ext"]=substr($_FILES["file"]['name'], strrpos($_FILES["file"]['name'], '.')+1);
	$D["fileName"]=$D["gameId"]."_".$D["step"]."_".$D["scene"].".mp3";
	$audioPath=$_SERVER['DOCUMENT_ROOT']."/data/audio/";
	  
	//[type] => audio/mpeg
	
	// move
	
	move_uploaded_file($_FILES['file']['tmp_name'], $audioPath. $D["fileName"]);
	
	
	// 
	
	//exist?
	/*
	conn();
	$WHERE =" WHERE idgym =".$D["idg"]." AND state=".$D["state"]." AND idsentence=".$D["idsentence"];
	$strS="SELECT ids FROM palma_sentences $WHERE ";
	
	$D["strS"]=$strS;
	$C=mysql_fetch_assoc(mysql_query($strS));
	$D["update"]=false;if ($C["ids"]) $D["update"]=true;
	if (!$D["update"]) {
		$fields.="idgym,";$values.="'".$D["idg"]."',";
		$fields.="state,";$values.="'".$D["state"]."',";
		$fields.="idsentence,";$values.="'".$D["idsentence"]."',";
		$fields.="A".$D["UB"].$D["idsentencePar"];$values.="'".$D["fileName"]."',";	
		
		$D["Q"]="INSERT INTO palma_sentences (".trim($fields, ",").") VALUES (".trim($values, ",").")";
		
	}else{	
		$D["Q"]="UPDATE palma_sentences SET ";
		$D["Q"].="A".$D["UB"].$D["idsentencePar"]."='".$D["fileName"]."'  $WHERE";
	}
	mysql_query($D["Q"]);
	$D["Qe"]=mysql_error();
	
	*/
	echo "true|-|";
	echo "/data/audio/".$D["fileName"]."|-|";
	print_r($D);
	echo "<br>-----<br>";
	print_r($_FILES);
	//print_r (pathinfo($_FILES['file']['tmp_name'])); 
} //cmd
?>