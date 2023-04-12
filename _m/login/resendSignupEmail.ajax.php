<?php
include_once("../../php.config.inc.php");
$D=$_POST;//["D"]
$D=array_map("trim",$D);

///it works with email only
//if (!$D["email"]) die("false|-|no email");


require_once(C_ROOT."/config/php.functs.email.php");

//function emailValidation($action="sendmail",$email=false,  $code=false, $uid=0, $ismemo=false, $datasession=false){
//function emailValidation($action="sendmail",$email=false,  $code=false, $uid=0, $ismemo=false, $datasession=true){
	
//emailValidation($action="sendmail",$email=false,  $code=false, $uid=0, $ismemo=false){

// SESSIONS DATA ONLY
if (!$_SESSION["email"])  die("false|-|no email");

$D["sendmail"]=emailValidation("sendmail",$_SESSION["email"], false, $_SESSION["uid"]);

//$D["sendmail"]=sendEmail2loggedUser($D["email"], $D["shown_name"], 0);

//sendEmailValidationMsg($email, $code, $name=false, $sex=false, $ismemo=false){
echo "true|-|0-|".print_r($D,true).print_r($_SESSION,true);
?>


