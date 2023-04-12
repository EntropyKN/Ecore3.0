<?php
/* 
https://to.sgameup.com/_m/scenarios/newScenarioHandle.ajax.php?
askPublic=true
&cmd=saveNcrop
&h=576.5526315789473
&w=1024.9824561403507
&x=0&y=0
&img=/data/attachmentsTMP/1_laborario_provette.jpg


*/
error_reporting(E_ALL ^ E_NOTICE);ini_set("display_errors",1);
//header('Content-Type: application/json; charset=utf-8');

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
if ($_GET) $D=$_GET;
//$D=array_map("trim",$D);

$D["response"]=true;
$D["reason"]="";

if ($D["cmd"]=="firstLoad"	){

    $D["F"]=$_FILES;

    #checks
    if ( 0 < $_FILES['file']['error'] ) {
        $D["response"]=false;
        $D["reason"]="file error: ".$_FILES['file']['error'];
        echo json_encode($D);
        return;
    }
    $acceptable_mime = array(
        'image/jpeg',
    'image/pjpeg',
        'image/jpg',
    //    'image/gif',
        'image/png',);

    if(!in_array($_FILES['file']['type'], $acceptable_mime)) {
        $D["response"]=false;
        $D["reason"]=L_sorry.", ".L_this_type_of_file_is_not_acceptable.": ".$_FILES['file']['type'];
        echo json_encode($D);
        return;
    }
    if (($_FILES['file']['size']  > (18*1048576)  )) {
        $D["response"]=false;
        $D["reason"]="File too large. File must be less than 18 megabytes";
        echo json_encode($D);
        return;
    }
    $D["ext"]=strtolower(substr($_FILES["file"]['name'], strrpos($_FILES["file"]['name'], '.')+1));
    if (!$D["ext"]) {
        $D["response"]=false;
        $D["reason"]="This is file has no extension :-(";
        echo json_encode($D);
        return;
    }

    $_FILES["file"]['nameC']=str_replace(	".".$D["ext"], 	"", $_FILES["file"]['name']);


    $D["fileName"]=make_urlable($_SESSION["uid"]."_scenarios_".time()).".".$D["ext"];
    $filepath=$_SERVER['DOCUMENT_ROOT']."/data/attachmentsTMP/";
    $D["fileNamePath"]=$filepath. $D["fileName"];
    $D["fileNamePathR"]="/data/attachmentsTMP/". $D["fileName"];
    unset ($D["fileName"]);
    // move	
    move_uploaded_file($_FILES['file']['tmp_name'], $D["fileNamePath"]);
    list($width, $height) = getimagesize($D["fileNamePath"]);


    $D["width"]=$width;$D["height"]=$height;
    #check II
    if ($D["width"]<1024 || $D["height"]<576) {
        $D["response"]=false;
        $reason=L_sorry.", ".L_the_minimum_pixel_size_is." 1024x576 (".L_uploaded_image_size.": ".$width."x".$height.")";
        $D["reason"]=$reason;
        $D["unlink"]=@unlink(			$D["fileNamePath"]			);
        echo json_encode($D);
        return;   
    }
} // cmd firstLoad


if ($D["cmd"]=="saveNcrop" ||$D["cmd"]=="save"	){

    if ( !$D['name'] ) {
        $D["response"]=false;
        $D["reason"]="Missing new scenario's name";
        echo json_encode($D);
        return;
    }

    // query in
    $askPublic=0;
    if ($D["askPublic"]=="true") $askPublic=1;    
    $D["Q"]="INSERT INTO `scenarios` ( `name`, `propertyUid`, `creatorUid`,  `publicWannabe`) VALUES ('".db_string($D["name"])."',  ".$_SESSION["uid"].", ".$_SESSION["uid"].",  $askPublic)";
    sql_query($D["Q"]);
    
    $D["newID"]=sql_id();
    
    // last used query
    $D["QupScen"]="INSERT INTO scenarios_used (uid, scenario_id)
    VALUES (".$_SESSION["uid"].", ".$D["newID"].")
    ON DUPLICATE KEY UPDATE
       uid = ".$_SESSION["uid"].", 
       scenario_id = ".$D["newID"]." ";
    
    sql_query($D["QupScen"]);
    if ($D["cmd"]=="save" ){   
        $D['x']=0;$D['x']=0;
        $D['w']=1024;$D['h']=576;
    }

    $D["img"]=$_SERVER['DOCUMENT_ROOT'].$D['img'];
    $D["mime"]=mime_content_type($D["img"]);
    
    // ridimensiona e salva
        
    if ($D["mime"]=="image/jpeg")   $img_r = imagecreatefromjpeg($D["img"]);
    if ($D["mime"]=="image/png")    $img_r = imagecreatefrompng($D["img"]);

    $dst_r = ImageCreateTrueColor( 1024, 576 );
    $dst_r640 = ImageCreateTrueColor( 640, 360 );
    // 1024
    imagecopyresampled($dst_r, $img_r, 0, 0, $D['x'], $D['y'], 1024, 576, $D['w'],$D['h']);
    $D["destinatonPath"]=$_SERVER['DOCUMENT_ROOT']."/data/scenarios/" . $D["newID"]."_1024.jpg";        
    imagejpeg($dst_r,  $D["destinatonPath"]);
    //640
    imagecopyresampled($dst_r640, $img_r, 0, 0, $D['x'], $D['y'], 640, 360, $D['w'],$D['h']);
    $D["destinatonPath640"]=$_SERVER['DOCUMENT_ROOT']."/data/scenarios/" . $D["newID"]."_640.jpg";
    imagejpeg($dst_r640,  $D["destinatonPath640"]);

    imagedestroy($img_r);       imagedestroy($dst_r);
    @unlink($D["img"]);
    
    
}

// final
echo json_encode($D);return;



?>