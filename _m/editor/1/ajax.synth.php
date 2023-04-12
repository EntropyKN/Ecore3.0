<?php
/* 

avatarId
: 
"3"
feedback
: 
"1"
gameId
: 
"226"
lang
: 
"it"
scene
: 
"C"
step
: 
"3"
text
: 
"dopo la risposta 1x"
voice
: 
"f"
voiceSex
: 
"m"

https://to.sgameup.com/_m/editor/1/ajax.synth.php?text=dopo+la+risposta+1x&gameId=226
&step=3&scene=C
&voice=f
&lang=it
&avatarId=3
&voiceSex=f
&feedback=1
&_=1667808701807

*/
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
header('Content-Type: application/json; charset=utf-8');


if ($_SESSION["ulevel"]<1) {
	$G["response"]=false;
	$G["reason"]="mm sounds like you're not logged at the moment";
	echo json_encode($G);
	return;
}
$G=array_map("trim",$_GET);


// checks
if ($G["lang"]!="it" && $G["lang"]!="en"){
    $G["lang"]="en";// default
}
if ($G["avatarId"]==0) $G["avatarId"]=1000;
if (!$G["avatarId"] || !is_numeric($G["avatarId"])){
	$G[]["response"]=false;
	$G["reason"]="";
	echo json_encode($G);
	return;
}
$G["text"]=strip_tags($G["text"]);

if (!$G["text"]){
	$G[]["response"]=false;
	$G["reason"]="Missing Text";
	echo json_encode($G);
	return;
}

$G["response"]=true;

// create
include_once($_SERVER['DOCUMENT_ROOT']."/config/php.function.tts.php");
$G["voiceIdDB"]="A.voiceId_".$G["lang"];
// solo con 1000=no avatar è possibile scegliere il genere della voce
if ($G["avatarId"]==1000 && strtolower($G["voiceSex"])=="f" ) $G["voiceIdDB"]="A.voiceId_".$G["lang"]."_f"; 

$G["Qa"]="SELECT ".$G["voiceIdDB"].", V.langCode, V.voiceName FROM avatars A
RIGHT join TTSvoices V on V.id=".$G["voiceIdDB"]."
WHERE A.id=".db_string($G["avatarId"])."";


$G["ttsD"]=sql_queryt($G["Qa"]);//unset($G["Qa"]);
if (sql_error()) $G["ttsDe"]=sql_error();

$G["fileName"]=$G["gameId"]."_".$G["step"]."_".$G["scene"].".mp3";
if ($G["feedback"]) $G["fileName"]=$G["gameId"]."_".$G["step"]."_".$G["scene"]."_feedback_".$G["feedback"].".mp3";

$audioFile=getSound($G["text"], $G["ttsD"]["langCode"], $G["ttsD"]["voiceName"]);

// if ($audioFile) {}
if (!$audioFile){
	$G["response"]=false;
	$G["reason"]="there has been a problem generating the audio file";
	echo json_encode($G);
	return;
}

file_put_contents($_SERVER['DOCUMENT_ROOT']. '/data/audio/'.$G["fileName"], $audioFile       );
//$G["link"]='<a target="_BLANK" href="/data/audio/'.$G["fileName"].'">'.$G["fileName"].'</a>';


echo json_encode($G);
return;
?>