<?php
error_reporting(E_ERROR  | E_PARSE ); //| E_WARNING
//ini_set("display_errors", "1");error_reporting(E_ALL);
session_start();

define("API_KEY_GOOGLE_TTS","INSERT KEY");//<== IMPORTANT: insert here your google cloud TTS API KEY!

define("SITE_URL_LOCATION","https://ecore.sgameup.com/");// include slash at the end ex: https://sub.domain.com/

define("C_DIR", "");
define("C_ROOT", $_SERVER['DOCUMENT_ROOT']."");



define("PAGE_RANDOM",md5(time()));
require_once(C_ROOT."/config/function.common.inc.php");
$conni=conni();

define ("C_TIME",time());


define ("COVERPATH","/data/covers/");
define ("AUDIOPATH","/data/audio/");
define ("AVATARPATH","/data/avatar_prev/1/");
define ("SCENARIOPATH","/data/scenarios/");


?>
