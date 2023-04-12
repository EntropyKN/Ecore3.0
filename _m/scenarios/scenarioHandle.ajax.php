<?php

// https://to.sgameup.com/_m/scenarios/scenarioHandle.ajax.php?action=deleteScenario&scenario_id=94
error_reporting(E_ALL ^ E_NOTICE);ini_set("display_errors",1);
header('Content-Type: application/json; charset=utf-8');

include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
if ($_SESSION["ulevel"]<1) {
	$D["response"]=false;
	$D["reason"]="mm sounds like you're not logged at the moment";
	echo json_encode($D);
	return;		
}
$lang_trigger="edt";
require_once(C_ROOT."/config/lang.inc.php");

$D=$_POST;
//if ($_GET) $D=$_GET;
$D=array_map("trim",$D);
$D["response"]=true;
$D["reason"]="";


$D=$_POST;
if ($_GET) $D=$_GET;
$D=array_map("trim",$D);
$D["d"]=array();
$D["response"]=true;
if ($D["action"]!="saveInGame" && $D["action"]!="switch2public" && $D["action"]!="deleteScenario"  ){
	$D["response"]=false;
	$D["reason"]="missing some parameters";	
	echo json_encode($D);
	return;	
}

if ($D["action"]=="deleteScenario") {  #######################################
    if ( !$D["scenario_id"] || !is_numeric($D["scenario_id"]) ){
        $D["response"]=false;$D["reason"]="missing some parameters";
        echo json_encode($D);	 return;	
    }
    unset ($D["d"]);
    $D["canDelete"]=false;
    $used=sql_queryt("SELECT COUNT(DISTINCT(GS.gameId)) used FROM games_steps GS where scenario_id= ".db_string($D["scenario_id"]));
    $D["used"]=$used["used"];
    if ( $D["used"]>0){
        $D["response"]=false;$D["reason"]="Can't delete, this scenario is used in ".$D["used"]." games/draft";
        echo json_encode($D);	 return;	
    }
    //$D["lev"]=$_SESSION;
    if ($_SESSION["ulevel"]==3)     $D["canDelete"]="asSuperUser";
    
    if (!$D["canDelete"]){

        $creator=sql_queryt("select creatorUid from scenarios where id= ".db_string($D["scenario_id"]));

        $D["creatorUid"]=$creator["creatorUid"];
        if ($_SESSION["uid"]==$D["creatorUid"]) $D["canDelete"]="asCreator";
    }
    
    if (!$D["canDelete"]){
       $D["response"]=false;$D["reason"]="Sorry, you cannot delete this scenario"; echo json_encode($D);	 return;	
    }
    /// delete
    if (1){
        $D["path"]=$_SERVER['DOCUMENT_ROOT']."/data/scenarios/".$D["scenario_id"]."_1024.jpg";
        sql_query("DELETE FROM `scenarios` WHERE `scenarios`.`id` = ".db_string($D["scenario_id"]));
        sql_query("DELETE FROM `scenarios_used` WHERE `scenarios_used`.`idl` = ".db_string($D["scenario_id"]));
        unlink($D["path"]=$_SERVER["DOCUMENT_ROOT"]."/data/scenarios/".$D["scenario_id"]."_1024.jpg");
        unlink($D["path"]=$_SERVER["DOCUMENT_ROOT"]."/data/scenarios/".$D["scenario_id"]."_640.jpg");
    }
    ////
    
}


if ($D["action"]=="switch2public") { ####switch2public#############################################################
    if ( !$D["scenario_id"] || !is_numeric($D["scenario_id"]) ){
        $D["response"]=false;$D["reason"]="missing some parameters";echo json_encode($D);return;	
    }

    if ( $_SESSION["ulevel"]<3 ){
        $D["response"]=false;$D["reason"]="No Permission";echo json_encode($D);return;	
    }
    
    $D["Q"]="UPDATE `scenarios` SET propertyUid = 0 WHERE id='".$D["scenario_id"]."'";
    sql_query($D["Q"]);
    unset ($D["Q"], $D["d"]);

}//

if ($D["action"]=="saveInGame") { #####saveInGame################################################################### 
    ##checks
    if (!$D["url"] || !$D["scenario_id"] || !is_numeric($D["scenario_id"]) ){
        $D["response"]=false;
        $D["reason"]="missing some parameters to save in game";	
        echo json_encode($D);
        return;	
    }




    $D["url"]=str_replace("/?/", "/?", $D["url"]);
    $D["urlex1"]=explode("?", $D["url"]);
    $D["DIRA"]=explode("/",$D["urlex1"][1]);
    $D["datacrypt"]=$D["DIRA"][1];
    unset ($D["urlex1"],$D["DIRA"] );//


    if (!$D["datacrypt"] ){
        $D["response"]=false;
        $D["reason"]="missing some url parameters";	
        echo json_encode($D);
        return;		
    }

    $D["d1"]=explode("|", decrypta($D["datacrypt"]));
    //if ($urlData[0]=="add" && $urlData[1] && is_numeric($urlData[1]) && $urlData[2] && $urlData[2]) {

    $D["d"]=array("act"=>$D["d1"][0],"gameId"=>intval( $D["d1"][1]),"step"=>intval($D["d1"][2]),"scene"=>$D["d1"][3]);
    unset ($D["d1"]);

    if (
    $D["d"]["act"]!="add" 
    || !$D["d"]["gameId"] || !is_numeric($D["d"]["gameId"])
    || !$D["d"]["step"] || !is_numeric($D["d"]["step"])
    || strlen ( $D["d"]["scene"])>1 
    || !$D["d"]["scene"]
    ){
        $D["response"]=false;
        $D["reason"]="game's data not consistent";	
        echo json_encode($D);
        return;	
    }

    $D["d"]=array_map("db_string", $D["d"]);
    $D["Q"]="UPDATE `games_steps` SET scenario_id = '".$D["scenario_id"]."' WHERE gameId='".$D["d"]["gameId"]."' 
    and step='".$D["d"]["step"]."' and scene='".$D["d"]["scene"]."'";
    sql_query($D["Q"]);
    $D["QupScen"]="INSERT INTO scenarios_used (uid, scenario_id)
    VALUES (".$_SESSION["uid"].", ".$D["scenario_id"].")
    ON DUPLICATE KEY UPDATE
       uid = ".$_SESSION["uid"].", 
       scenario_id = ".$D["scenario_id"]." ";
    sql_query($D["QupScen"]);
    
    // update game cover
    if ($D["d"]["step"]==1 && $D["d"]["scene"]=="A")  {
        
        $D["dataStep"]=sql_queryt("SELECT avatar_id from  `games_steps` WHERE gameId='".$D["d"]["gameId"]."' and step='".$D["d"]["step"]."' and scene='".$D["d"]["scene"]."'");
        if (!$D["dataStep"]["avatar_id"]) $D["dataStep"]["avatar_id"]=false;
        $D["createImgGameCover"]=createImgGameCover($D["d"]["gameId"], $D["dataStep"]["avatar_id"], $D["scenario_id"]);
    
    }
    
    unset (
        $D["Q"], 
        $D["QupScen"],
        $D["datacrypt"]
        );
    if (sql_error()) {
        $D["response"]=false;
        $D["reason"]=" DB problem :".sql_error();	
        echo json_encode($D);
        return;	
    }
}



///  output
echo json_encode($D);
return;	












?>