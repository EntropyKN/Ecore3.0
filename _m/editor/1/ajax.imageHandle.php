<?php
ini_set("display_errors", "1");
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
if ($_SESSION["ulevel"]<1) die("false|-|you don't have the right permissions");

$D=$_POST;
$D=array_map("trim",$D);



 //   if ($_FILES['file']['tmp_name'])    $D["unlink"]=@unlink(			$_FILES['file']['tmp_name']				);
/*	echo "true|-|";
	echo $id."|-|"; // id
	echo "".$_FILES["file"]['nameC']."|-|"; // name
	echo "/data/attachments/".$D["fileName"]."|-|"; // url
    
	echo "attach|-|"; // type
	
	print_r($D);
	echo "<br>-----<br>";
	print_r($_FILES);
*/

if ($D["cmd"]=="delete"	){
/*	if ($D["step"] && is_numeric($D["step"])	&& $D["path"]	){	

		$D["unlink"]=@unlink(			$_SERVER['DOCUMENT_ROOT'].$D["path"]				);
		$D["Q"]="DELETE FROM `games_steps_attachments` WHERE gameId = ".$D["gameId"]." AND step = ".$D["step"]." AND idAttachment = ".$D["idAttachment"]."";
		sql_query($D["Q"]);
		if (sql_error()) $D["e"]=sql_error();
		//$D["utrackingGameEditor"]=utrackingGameEditor($D["gameId"], $D["step"], "games_steps_attachment_delete_id", $D["path"]) ;		
		
		echo "true|-|";
		print_r($D);
	}*/
}else{
   /* ini_set("post_max_size", "30M");
    ini_set("upload_max_filesize", "30M");
    ini_set("memory_limit", "20000M"); */
	require_once(C_ROOT."/config/lang.inc.php");
    $acceptable_mime = array(
		'image/jpeg',
        'image/pjpeg',
		'image/jpg',
		'image/png',

    );

	
	if ( 0 < $_FILES['file']['error'] ) die("false|-|fileError:".$_FILES['file']['error']);
	//2.097.152*2=4.194.304
    if (($_FILES['file']['size']  > 4194304)) die("false|-|File too large. File must be less than 4 megabytes.");
	if(!in_array($_FILES['file']['type'], $acceptable_mime))  
        die("false|-|".L_sorry.", ".L_this_type_of_file_is_not_acceptable.": ".$_FILES['file']['type'].""); 
    // check file pixel dims TO DO
    
    
	
	$D["ext"]=substr($_FILES["file"]['name'], strrpos($_FILES["file"]['name'], '.')+1);
	
	$_FILES["file"]['nameC']=str_replace(	".".$D["ext"], 	"", $_FILES["file"]['name']);
	
	$D["fileName"]=make_urlable($_FILES["file"]['nameC'])."_".$D["gameId"]."_".$D["step"]."_".$D["scene"]."_".$D["answer"].".".$D["ext"];
	$filepath=$_SERVER['DOCUMENT_ROOT']."/data/attachments/";

	
	// move	
	move_uploaded_file($_FILES['file']['tmp_name'], $filepath. $D["fileName"]);
    $D["Q"]="UPDATE `games_steps` SET `img_".$D["answer"]."` = '/data/attachments/".db_string($D["fileName"])."' 
    WHERE gameId=".$D["gameId"]." AND step=".$D["step"]." AND scene='".$D["scene"]."' ";
	sql_query($D["Q"]);
    if (sql_error()) $D["e"]=sql_error();
	
	echo "true|-|";
    echo $D["answer"]."|-|";
	echo "/data/attachments/".$D["fileName"]."|-|"; // url
	
	
	print_r($D);
	//echo "<br>-----<br>";print_r($_FILES);
	//print_r (pathinfo($_FILES['file']['tmp_name'])); 
} //cmd

?>