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
//if ($_GET) $D=$_GET;
//$D=array_map("trim",$D);

$D["response"]=true;
$D["reason"]="";



if ($D["cmd"]!="wait" && $D["cmd"]!="talk" && $D["cmd"]!="saveAll"	){
    $D["response"]=false;
    $D["reason"]="Azione indefinita";
    echo json_encode($D);
    return;
}
if (!$D["code"]){
    $D["response"]=false;
    $D["reason"]="Parametri mancanti :-(";
    echo json_encode($D);
    return;
}

if ($D["cmd"]=="saveAll"	){ //////////////////////////////////////////////////
    if (!$D["avatarName"]){
        $D["response"]=false;
        $D["reason"]="Parametri mancanti :-(";
        echo json_encode($D);
        return;
    }
    $D["search"]=sql_queryt("select id from avatars where name like '".db_string($D["avatarName"])."' ");
    if ($D["search"]["id"]){
        $D["response"]=false;
        $D["reason"]="name";
        echo json_encode($D);
        return;
    }
    
    // files Check
    $D["f1"]='/data/attachmentsTMP/'.$_SESSION["uid"].'_avrt_wait_'.$D["code"].'.png';
    $D["f2"]='/data/attachmentsTMP/'.$_SESSION["uid"].'_avrt_talk_'.$D["code"].'.png';


    if (
    !file_exists($_SERVER['DOCUMENT_ROOT'].$D["f1"])
    || !file_exists($_SERVER['DOCUMENT_ROOT'].$D["f2"])

    ){
         $D["response"]=false;
        $reason=L_sorry.", can't find animations :-(";
        $D["reason"]=$reason;
        echo json_encode($D);
        return;        
    }
        
    //////////////////
    $D["Qinsert"]="INSERT INTO `avatars` (`name`, `sex`,  `propertyUid`, `creatorUid`) 
    VALUES ('".db_string($D["avatarName"])."', '".db_string($D["sex"])."',  NULL, '".$_SESSION["uid"]."')";
    
    // propertyUid NULL= utilizzabile da tutti else '".$_SESSION["uid"]."' solo da chi ha caricato 
    sql_query($D["Qinsert"]);
    $D["newId"]=sql_id();
    
    /////////////
    $D["f1f"]='/data/avatar_prev/1/'.$D["newId"].'_10Kx1098_wait.png';
    $D["f2f"]='/data/avatar_prev/1/'.$D["newId"].'_10Kx1098_talk.png';   

    // move	
    rename($_SERVER['DOCUMENT_ROOT'].$D["f1"], $_SERVER['DOCUMENT_ROOT'].$D["f1f"]);
    rename($_SERVER['DOCUMENT_ROOT'].$D["f2"], $_SERVER['DOCUMENT_ROOT'].$D["f2f"]);
    
    
    ############create thumbs
    $img_r = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].$D["f1f"]);
    
    // 1 frame
    $dst_r = ImageCreateTrueColor( 500, 1098 );
    imagealphablending( $dst_r, false );imagesavealpha( $dst_r, true );
    imagecopyresampled($dst_r, $img_r, 0, 0, 0, 0, 500, 1098, 500, 1098);
    $D["thumb1098"]=imagepng($dst_r,  $_SERVER['DOCUMENT_ROOT'].'/data/avatar_prev/1/'.$D["newId"].'_500x1098.png');
    imagedestroy($dst_r);

    //thumb 50%
    $dst_r = ImageCreateTrueColor( 250, 549  );
    imagealphablending( $dst_r, false );imagesavealpha( $dst_r, true );
    imagecopyresampled($dst_r, $img_r, 0, 0, 0, 0, 
    250, 549, 
    500, 1098);
    $D["thumb250"]=imagepng($dst_r,  $_SERVER['DOCUMENT_ROOT'].'/data/avatar_prev/1/'.$D["newId"].'_250x549.png');
    imagedestroy($dst_r);

    //thumb 50% square

    $dst_r = ImageCreateTrueColor( 250, 250  );
    imagealphablending( $dst_r, false );imagesavealpha( $dst_r, true );
    imagecopyresampled($dst_r, $img_r, 0, 0, 0, 0, 
    250, 250, 
    500, 500);
    $D["thumbsquare"]=imagepng($dst_r,  $_SERVER['DOCUMENT_ROOT'].'/data/avatar_prev/1/'.$D["newId"].'_250x250.png');
    imagedestroy($dst_r);
    
    
    ########################## end thumb
    include_once($_SERVER['DOCUMENT_ROOT']."/config/php.function.tts.php");
    assign_voices_to_avatar($D["sex"], "it") ; 
    assign_voices_to_avatar($D["sex"], "en") ; 
}/// end save

if ($D["cmd"]=="wait" || $D["cmd"]=="talk"	){#######################################################

    $D["F"]=$_FILES;

    #checks
    if ( 0 < $_FILES['file']['error'] ) {
        $D["response"]=false;
        $D["reason"]="C'è stato un errore nel caricamento del file ".$_FILES['file']['error'];
        echo json_encode($D);
        return;
    }
   
    if(strtolower($_FILES['file']['type'])!=="image/png") {
        $D["response"]=false;
        $D["reason"]=L_sorry.", ".L_this_type_of_file_is_not_acceptable.": ".$_FILES['file']['type'];
        echo json_encode($D);
        return;
    }
    $_FILES['file']['Kb']=intval( $_FILES['file']['size'] /1024);
    
    if (($_FILES['file']['Kb']  > 750  )) {
        $D["response"]=false;
        $D["reason"]="Il file è troppo pesante";
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


    $D["fileName"]=make_urlable(
        $_SESSION["uid"]."_avrt_".$D["cmd"]."_".$D["code"]
        ).
        ".".$D["ext"];

    $filepath=$_SERVER['DOCUMENT_ROOT']."/data/attachmentsTMP/";
    $D["fileNamePath"]=$filepath. $D["fileName"];
    $D["fileNamePathR"]="/data/attachmentsTMP/". $D["fileName"];
    unset ($D["fileName"]);
    
    list($width, $height) = getimagesize($_FILES["file"]["tmp_name"]); 
    $D["width"]=$width;$D["height"]=$height;
    
    

    
    #check II
    
    if ($D["width"]!=10000 || $D["height"]!=1098) {
        $D["response"]=false;
        $reason=L_sorry.", le misure della PNG devono essere esattamente 1098 (altezza) x 10000 (larghezza)<br />(".L_uploaded_image_size.": ".$width."x".$height.")";
        $D["reason"]=$reason;
        $D["unlink"]=@unlink(		$_FILES["file"]["tmp_name"]		);
        echo json_encode($D);
        return;   
    }
    
    // check 
    if ($D["cmd"]=="talk") {
        $D["fileNamePathWAIT"]=str_replace("_talk_", '_wait_', $D["fileNamePath"]);
        if (!file_exists($D["fileNamePathWAIT"])){
             $D["response"]=false;
            $reason=L_sorry.", il file wait non esiste :-(";
            $D["reason"]=$reason;
            $D["unlink"]=@unlink(		$_FILES["file"]["tmp_name"]		);
            echo json_encode($D);
            return;        
        }
        
    }
    
    // move	
    move_uploaded_file($_FILES['file']['tmp_name'], $D["fileNamePath"]);
       
    
} // cmd firstLoad


// final
echo json_encode($D);return;



?>