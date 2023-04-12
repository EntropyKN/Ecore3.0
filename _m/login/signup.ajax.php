<?php
include_once("../../php.config.inc.php");
$D=$_POST;//["D"]
$D=array_map("trim",$D);

$D["siemail"]=strtolower($D["siemail"]);
if ($D["action"]!="emailcheck" &&  $D["action"]!="signup") die("false|-|no action");
if (!$D["siemail"]) die("false|-|no email");

	
conn();
if ($D["action"]=="emailcheck") {

	
	$D["q"]="select count(user_email) C FROM users WHERE user_email='".db_string($D["siemail"])."'";
	$q=mysql_query($D["q"]);
	$D["emailExist1"]=mysql_fetch_assoc($q);
	$D["emailExist"]=$D["emailExist1"]["C"]; unset ($D["emailExist1"]);

	if (!$D["emailExist"]) 	die( "0|-|".print_r($D,true));
	else die( "1|-|".print_r($D,true));
}


if ($D["action"]=="signup") {

	
	$write=true;
	if (!$D["siemail"] || !$D["sipwd"] ||!$D["lastname"] ||!$D["firstname"] ) die("false|-|no data");
	$lang_trigger="usr";require_once(C_ROOT."/config/lang.inc.php");
	require_once(C_ROOT."/config/php.functs.email.php");
	
	$D["q"]="INSERT INTO users (user_name, user_pass, user_real_name, user_real_surname, user_email,created) 
	VALUES ('".db_string($D["siemail"])."', '".db_string($D["sipwd"])."', '".db_string($D["firstname"])."', '".db_string($D["lastname"])."', '".db_string($D["siemail"])."', ".C_TIME.");";
	
	if($write) mysql_query($D["q"]);
	if (mysql_error()) die("false|-|".mysql_error);
	$newUid=mysql_insert_id();

	if (!$newUid) $newUid=0; // debug
	if($write) mysql_query("INSERT INTO users_gym (users_id, idgym) VALUES ($newUid, 30)"); //30 gym default  sara' presto obsoleto

	
	/*
	if($write) mysql_query("INSERT INTO user_usersgroups (uid, idgroup) VALUES ($newUid, 1)"); //1 =group default
	*/
	/*
	DELETE FROM user_usersgroups WHERE uid=34;
	DELETE FROM users_gym WHERE users_id=34;
	DELETE FROM users WHERE users_id=34
	*/


	//emailValidation($action="sendmail",$email=false,  $code=false, $uid=0, $ismemo=false)
	$D["emailvalidation"]=emailValidation("sendmail",$D["siemail"],  false, $newUid, false);
	
	$SIGN_UP_OK_MESSAGE=str_replace("#user", $D["firstname"], L_SIGN_UP_OK_MESSAGE);
	$SIGN_UP_OK_MESSAGE=str_replace("#email", $D["siemail"], $SIGN_UP_OK_MESSAGE);
	
	echo "true|-|$newUid|-|$SIGN_UP_OK_MESSAGE|-|".print_r($D,true);

	die;
}





//echo "true|-|".print_r($D,true);
?>