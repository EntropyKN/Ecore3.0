<?php
ini_set("display_errors", "1");
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
if ($_SESSION["ulevel"]<1) die("false|-|you don't have the right permissions");

$D=$_POST;$D=array_map("trim",$D);
/*
if ($D["scene"]) {
	echo "false|-|noScene|-|";
	print_r($D);
	die();
}*/
$D["Q"]=false;
if (!$D["table"]) {
	if ($D["gameId"]  && is_numeric($D["gameId"])  && $D["step"]  && is_numeric($D["step"])  && $D["what"] )  {	
		
		if (		$D["what"]!="compulsoryAttachments" && $D["what"]!="ascore_1" && $D["what"]!="ascore_2" && $D["what"]!="ascore_3" && $D["what"]!="ascore_4") {
			
			if (!$D["val"] && $D["val"]!="0") 
                $D["Q"]="update games_steps set ".$D["what"]."=NULL WHERE gameId=".$D["gameId"]." AND step=".$D["step"]." AND scene='".$D["scene"]."' ";
			else
			 $D["Q"]="/* ".$D["step"]."-".$D["scene"]." ".$D["what"]." */ 
                update games_steps set ".$D["what"]."='".db_string($D["val"] )."' WHERE gameId=".$D["gameId"]." AND step=".$D["step"]." AND scene='".$D["scene"]."' ";
		}else{
			$D["Q"]="update games_steps set ".db_string($D["what"])."=".db_string($D["val"])." WHERE gameId=".$D["gameId"]." AND step=".$D["step"]." AND scene='".$D["scene"]."'" ;
			if ($D["val"]=="na") $D["Q"]="update games_steps set ".$D["what"]."=NULL WHERE gameId=".$D["gameId"]." AND step=".$D["step"]." AND scene='".$D["scene"]."' ";
		}
		if ($D["what"]=="avatar_id" && $D["step"]==1 && $D["scene"]=="A") { //save ("avatar_id", avatar_id_send)
            $D["dataStep2create"]=sql_queryt("SELECT scenario_id from `games_steps` WHERE gameId='".$D["gameId"]."' and step='1' and scene='A'");
            $D["createImgGameCover"]=createImgGameCover($D["gameId"], $D["val"], $D["dataStep2create"]["scenario_id"]);
        }
        
		//utrackingGameEditor($gameId, $step, $action) 
		//$D["utrackingGameEditor"]=utrackingGameEditor($D["gameId"], $D["step"], $D["what"]) ;
		
	}
}




if ($D["table"]=="attachments"		&& is_numeric(	$D["whereId"]	)) {
		$D["Q"]="update games_steps_attachments set ".$D["what"]."='".db_string($D["val"] )."' WHERE gameId=".$D["gameId"]." AND step=".$D["step"]."  AND scene='".$D["scene"]."' AND idAttachment=".$D["whereId"];
//		$D["utrackingGameEditor"]=utrackingGameEditor($D["gameId"], $D["step"], $D["table"]) ;
}

if ($D["table"]=="comments"		&& is_numeric(	$D["gameId"]	)) {
		$D["Q"]="update games set ".$D["what"]."='".db_string($D["val"] )."' WHERE gameId=".$D["gameId"]."";
//		$D["utrackingGameEditor"]=utrackingGameEditor($D["gameId"], 0, $D["table"]) ;
}



if ($D["Q"]) {
	sql_query($D["Q"]);
    $D["e"]=sql_error();
    // updates
    if ($D["gameId"]) sql_query("update games set editTs='".C_TIME."' WHERE gameId=".$D["gameId"].""); //	editTs
    // scenario_id
    if ($D["what"]=="scenario_id")  {
        $D["QupScen"]="INSERT INTO scenarios_used (uid, scenario_id)
        VALUES (".$_SESSION["uid"].", ".$D["val"].")
        ON DUPLICATE KEY UPDATE
           uid = ".$_SESSION["uid"].", 
           scenario_id = ".$D["val"]." ";
        sql_query($D["QupScen"]);
   }

}

	if ($D["Q"]) echo "true|-|";
    else echo "false|-|";
    echo "|-|".$D["Q"]."|-|";
	//print_r($D);
?>