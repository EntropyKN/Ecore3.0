<?php
ini_set("display_errors", "1");
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");

if (!loggedIn()) die("false|-|you are not logged");
if ($_SESSION["ulevel"]<1) die("false|-|you don't have the right permissions");

$G=array_map("trim",$_GET);
$voice=explode(",",$G["voice"]);
$D["gender"]=$voice[1];
$D["tl"]=$voice[0];
$G["text"]=strip_tags($G["text"]);

if ($D["tl"]=="en") $D["tl"]="en-GB";

$externalAudioKey="kvfbSITh"; ####!!!

$D["url"]="https://code.responsivevoice.org/getvoice.php?text=".urlencode($G["text"])."&lang=".$D["tl"]."&engine=g3&name=&pitch=0.5&rate=0.5&volume=1&key=$externalAudioKey&gender=".$D["gender"];

/*
uu8DEkxz
0POmS5Y2
maschio
https://code.responsivevoice.org/getvoice.php?text=ciao&lang=it&engine=g3&name=&pitch=0.5&rate=0.5&volume=1&key=uu8DEkxz&gender=male
femm
https://code.responsivevoice.org/getvoice.php?text=ciao&lang=it&engine=g1&name=&pitch=0.5&rate=0.5&volume=1&key=uu8DEkxz&gender=female
*/


$D["fileName"]=$G["gameId"]."_".$G["step"]."_".$G["scene"].".mp3";

file_put_contents($_SERVER['DOCUMENT_ROOT']. '/data/audio/'.$D["fileName"], fopen(	$D["url"]		, 'r'));


$D["post"]=$G;
echo "true|-|";
echo "/data/audio/".$D["fileName"];
echo "|-|";
echo "<pre>";
print_r($D);
?>