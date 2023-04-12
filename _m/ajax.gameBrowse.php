<?php
ini_set("display_errors", "1");
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");

$lang_trigger="usr";require(C_ROOT."/config/lang.inc.php");
if (!loggedIn()) die("false|-|you are not logged");
//if ($_SESSION["ulevel"]<1) die("false|-|you don't have the right permissions");
require_once(C_ROOT."/config/php.function.games.php");
$D=$_POST;//["D"]
$D=array_map("trim",$D);
$R=getGames($D["page"],$D["scope"]);
	
echo "true|-|".$R["htm"];
//echo "|-|".L_more_matches;print_r($R["s"]);




?>