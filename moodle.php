<?php
error_reporting(E_ALL ^ E_NOTICE);ini_set("display_errors",1);
include_once("config/config.inc.php");
$DEBUG=false;
if ($_GET["DEBUG"] || $_POST["DEBUG"])  $DEBUG=true;
// https://to.sgameup.com/moodle.php?DEBUG=1&TEST=1
/*function object2array($object){
   $return = NULL;
  // return $return; 
   if(is_array($object))   {
       foreach($object as $key => $value)
           $return[$key] = object2array($value);
   }else{
       $var = @get_object_vars($object);          
       if($var){
           foreach($var as $key => $value)
               $return[$key] = object2array($value);
       }
       else
           return $object; 
   }
   return $return;
}

tuscia_moodle 	39n2p6d5x9t8hgwxjxcynvp3hjdvah9e  
tuscia_progetti 	51s4d5x9t8hgwxjxcynvp3hjdvah6w1
tuscia_test 	40n2p6d5x9t8hgwxjxcynvp3hjdvah6d
*/
$key = "demotest";
$secret = "09i1o22gx9t8hgwxjxcynvp3hjdvah4t";

$P_teacher=array(
	"oauth_version"=>"1.0"
	,"oauth_nonce"=>"fc0f044f664f3ef85421c92069b6fdd2"
	,"oauth_timestamp"=>"1568295344"
	,"oauth_consumer_key"=>$key
	,"user_id"=>"4"
	,"lis_person_sourcedid"=>""
	,"roles"=>"Instructor"
	,"context_id"=>"2"
	,"context_label"=>"corso_demo"
	,"context_title"=>"corso_demo"
	,"resource_link_title"=>"prova LTI"
	,"resource_link_description"=>""
	,"resource_link_id"=>"1"
	,"context_type"=>"CourseSection"
	,"lis_course_section_sourcedid"=>""
	,"lis_result_sourcedid"=>'{"data":{"instanceid":"1","userid":"4","typeid":null,"launchid":588518499},"hash":"5f3df2e63c4a885bad89706669599b8cf139e68d074b548cdc53ddb2acc25234"}'
	,"lis_outcome_service_url"=>"https://dt.unitus.it/else/mod/lti/service.php"
	,"lis_person_name_given"=>"Teacher"
	,"lis_person_name_family"=>"ELSE"
	,"lis_person_name_full"=>"Teacher ELSE"
	,"ext_user_username"=>"else_teacher"
	,"lis_person_contact_email_primary"=>"teacher@else.eu"
	,"launch_presentation_locale"=>"en"
	,"ext_lms"=>"moodle-2"
	,"tool_consumer_info_product_family_code"=>"moodle"
	,"tool_consumer_info_version"=>"2019052002"
	,"oauth_callback"=>"about:blank"
	,"lti_version"=>"LTI-1p0"
	,"lti_message_type"=>"basic-lti-launch-request"
	,"tool_consumer_instance_guid"=>"dt.unitus.it"
	,"tool_consumer_instance_name"=>"ELSE_dev_platform"
	,"tool_consumer_instance_description"=>"ELSE_development"
	,"launch_presentation_document_target"=>"window"
	,"launch_presentation_return_url"=>"https://dt.unitus.it/else/mod/lti/return.php?course=2&launch_container=4&instanceid=1&sesskey=iJiXK5E01u"
	,"oauth_signature_method"=>"HMAC-SHA1"
	,"oauth_signature"=>"LALOTb5Vdsy6G5z7Fk4j7nIinhY="
	);
	
$P_student=array(
	"oauth_version"=>"1.0"
	,"oauth_nonce"=>"9ae3aa4c19577fc9259b48542f2a5b13"
	,"oauth_timestamp"=>"1568295286"
	,"oauth_consumer_key"=>$key
	,"user_id"=>"5"
	,"lis_person_sourcedid"=>""
	,"roles"=>"Learner"
	,"context_id"=>"2"
	,"context_label"=>"corso_demo"
	,"context_title"=>"corso_demo"
	,"resource_link_title"=>"prova LTI"
	,"resource_link_description"=>""
	,"resource_link_id"=>"1"
	,"context_type"=>"CourseSection"
	,"lis_course_section_sourcedid"=>""
	,"lis_result_sourcedid"=>'{"data":{"instanceid":"1","userid":"5","typeid":null,"launchid":1193661300},"hash":"e4eee69ba6c1ad65981b497ed09a078322cb080ae16549a156ff55ae95c72240"}'
	,"lis_outcome_service_url"=>"https://dt.unitus.it/else/mod/lti/service.php"
	,"lis_person_name_given"=>"Student"
	,"lis_person_name_family"=>"ELSE"
	,"lis_person_name_full"=>"Student ELSE"
	,"ext_user_username"=>"else_student"
	,"lis_person_contact_email_primary"=>"student@else.eu"
	,"launch_presentation_locale"=>"it"
	,"ext_lms"=>"moodle-2"
	,"tool_consumer_info_product_family_code"=>"moodle"
	,"tool_consumer_info_version"=>"2019052002"
	,"oauth_callback"=>"about:blank"
	,"lti_version"=>"LTI-1p0"
	,"lti_message_type"=>"basic-lti-launch-request"
	,"tool_consumer_instance_guid"=>"dt.unitus.it"
	,"tool_consumer_instance_name"=>"ELSE_dev_platform"
	,"tool_consumer_instance_description"=>"ELSE_development"
	,"launch_presentation_document_target"=>"window"
	,"launch_presentation_return_url"=>"https://dt.unitus.it/else/mod/lti/return.php?course=2&launch_container=4&instanceid=1&sesskey=mxBjiLDJrL"
	,"oauth_signature_method"=>"HMAC-SHA1"
	,"oauth_signature"=>"FwDnQwA5GPmegyAqKzMV90rhujs="
	);	


$P_due=array(

/*
To create the Signature Base:

   1- Get all of the parameters except "oauth signature" sent by Canvas with POST from the launch.

   2- I made a loop for each parameter, and encode only Key and Values, they look like        this: 
   encodedKey=EncodedValue. 
   I don't know which language you are using but, in c# it looks similar to this: 
   $"&{Uri.EscapeDataString(key)}={Uri.EscapeDataString(value)}

   3- Sort them alphabetically with the Key names(&Key=Value)
   4- Create a string from this list, and Encode this string one more time(the whole string).
   5- Add the string you created to "POST&{Your Launch Url}&{The string you just created}"

   After these, you will just create the signature with using this signature base which is the standard way
*/

	"oauth_version"=>"1.0"
	,"oauth_nonce"=>"f27fa5baa847897762ed470c2cfe62c7"
	,"oauth_timestamp"=>"1582925912"
	,"oauth_consumer_key"=>"tusciamoodle"
	,"user_id"=>"6"
	,"lis_person_sourcedid"=>"GLLPPL84L17B715G"
	,"roles"=>"Instructor,urn:lti:sysrole:ims/lis/Administrator,urn:lti:instrole:ims/lis/Administrator"
	,"context_id"=>"230"
	,"context_label"=>"GRAZIANO|400|7"
	,"context_title"=>"GRAZIANO - MAGISTRALE"
	,"resource_link_title"=>"Moving house"
	,"resource_link_description"=>""
	,"resource_link_id"=>"2"
	,"context_type"=>"CourseSection"
	,"lis_course_section_sourcedid"=>""
	,"lis_result_sourcedid"=>'{"data":{"instanceid":"2","userid":"6","typeid":null,"launchid":1787486304},"hash":"527966b5b890b4bafb71480d8e8690756ac8ed5451e58107a375105a75b215d3"}'
	,"lis_outcome_service_url"=>"https://moodle.unitus.it/moodle/mod/lti/service.php"
	,"lis_person_name_given"=>"Pierpaolo"
	,"lis_person_name_family"=>"Gallo"
	,"lis_person_name_full"=>"Pierpaolo Gallo"
	,"ext_user_username"=>"p.gallo"
	,"lis_person_contact_email_primary"=>"p.gallo@unitus.it"
	,"launch_presentation_locale"=>"it"
	,"ext_lms"=>"moodle-2"
	,"tool_consumer_info_product_family_code"=>"moodle"
	,"tool_consumer_info_version"=>"2018120308.04"
	,"oauth_callback"=>"about:blank"
	,"lti_version"=>"LTI-1p0"
	,"lti_message_type"=>"basic-lti-launch-request"
	,"tool_consumer_instance_guid"=>"moodle.unitus.it"
	,"tool_consumer_instance_name"=>"HOME"
	,"tool_consumer_instance_description"=>"UniTusMoodle"
	,"launch_presentation_document_target"=>"window"
	,"launch_presentation_return_url"=>"https://moodle.unitus.it/moodle/mod/lti/return.php?course=230&launch_container=4&instanceid=2&sesskey=VjRsVEbF7c"
	,"oauth_signature_method"=>"HMAC-SHA1"
	,"oauth_signature"=>"74IPTNwBcGsWkhokWIbGiyikWaI="
	);

//$P=$P_teacher;
//$P=$P_student;

if ($_GET["test"]=="1")  {
	$DEBUG=true;
	$P=$P_due;
}	

if ($_GET["test"]=="2")  {
	$DEBUG=true;
	$P=$P_teacher;
}

if ($_POST) $P=$_POST;
if ($_GET)  $P=$_GET;
/////////////////////////////////////////// get Family

$D["family"]=sql_queryt("SELECT * from family where family='".db_string($P["oauth_consumer_key"])."'");
if (sql_error()) $D["familyE"]=sql_error();
if (!$D["family"]["secret"]) {
    print_r($D);
	die ("no Family :-(")	; // redirect
    
}

///////////////////// CALCOLO SIGNATURE DAI DATI PER PROVARE CORRISPONDENZA

$launch_url = SITE_URL_LOCATION."moodle.php";
$launch_data=$P;
unset (
$launch_data["oauth_signature"]
);

$launch_data_keys = array_keys($launch_data);
sort($launch_data_keys);
$launch_params = array();
foreach ($launch_data_keys as $key) {
  array_push($launch_params, $key . "=" . rawurlencode($launch_data[$key]));
}
sort($launch_params);
//$base_string = "POST&" . urlencode($launch_url) . "&" . rawurlencode(implode("&", $launch_params));
$base_string = "POST&" . urlencode($launch_url) . "&" . rawurlencode(implode("&", $launch_params));
$secretC = urlencode(trim($D["family"]["secret"])) . "&";

//09i1o22gx9t8hgwxjxcynvp3hjdvah4t

$signature = base64_encode(hash_hmac("sha1", $base_string, $secretC, true));
//$signature = base64_encode(hash_hmac("sha1", $base_string, $secretC, true) );
$D["signatureCalculated"]=$signature;

//$P["SIGNATURE_calc"]=$signature;

/////////////////////////////
if ($signature==$P["oauth_signature"]) {
	if($DEBUG) echo "login ok ";
		
	/// esiste?
	$D["existQ"]=("SELECT users_id, muser_id, family, user_real_name, user_real_surname, user_email, role0, role1, role2, role3, user_level from users WHERE family='".db_string($P["oauth_consumer_key"])."'  AND  muser_id =".$P["user_id"]);
	$D["user"]=sql_queryt($D["existQ"]);unset ($D["existQ"]);
	$D["user"]["new"]=false;
	
	if (sql_error()) $D["existE"]=sql_error();	
	
	
	
	if (!$D["user"]["users_id"]) {
		
		$D["roles"]=explode(",",$P["roles"]);
		$addF="";$addV="";
		
		for ($i = 0; $i < 3; $i++) {
			if ($D["roles"][$i]) {
				$addF.=", role$i";
				$addV.=", '".db_string($D["roles"][$i])."'";
			}
		}
		$user_level=0;
		 if (in_array("Instructor",$D["roles"])) {
			 $addF.=", user_level";
			$addV.=", 1";
			$user_level=2;
		 }
/*

[18:02, 30/1/2020] Cosmo: Site Administrator (Moodle) = 2
[18:02, 30/1/2020] Cosmo: Manager, Course creator, Teacher, Non-editing teacher = 1
[18:02, 30/1/2020] Cosmo: Student, Guest =0
*/		
		
		$D["insertQ"]=("INSERT INTO `users` (`muser_id`, `family`,user_real_name, `user_real_surname`, `user_email`,  `created`, `updated`$addF) 
		VALUES (".$P["user_id"].",'".$P["oauth_consumer_key"]."',  '".db_string($P["lis_person_name_given"])."', '".db_string($P["lis_person_name_family"])."', '".db_string($P["lis_person_contact_email_primary"])."', ".C_TIME.",".C_TIME."  $addV  )");
		 sql_query($D["insertQ"]);

		if (sql_error()) {
			$D["insertE"]=sql_error();
			die($D["insertE"]);
		}
		$D["user"]=array(
			"users_id"=>sql_id(),
			"muser_id"=>$P["user_id"],
			"family"=>$P["oauth_consumer_key"],
			"user_email"=>$P["user_email"],
			"user_real_name"=>$P["lis_person_name_given"],
			"user_real_surname"=>$P["lis_person_name_family"],
			"user_email"=>$P["lis_person_contact_email_primary"],
			"role0"=>$D["roles"][0],
			"role1"=>$D["roles"][1],
			"role2"=>$D["roles"][2],
			"role3"=>$D["roles"][3],
			"user_level"=>$user_level,
			"new"=>true,
		);
	}	
	
	if ($D["user"]["users_id"]	) { //	&& !$DEBUG
		//unset ($_SESSION);
		$_SESSION['secret'] =$D["family"]["secret"];
		$_SESSION['lis_result_sourcedid'] =$P["lis_result_sourcedid"];
		$_SESSION['lis_outcome_service_url'] =$P["lis_outcome_service_url"];
		
		$_SESSION['uid'] =$D["user"]["users_id"];
		$_SESSION['muser_id'] =$D["user"]["muser_id"];
		$_SESSION['family'] =$D["user"]["family"];
		$_SESSION['email'] = $D["user"]["user_email"];
		$_SESSION['emailvalidate'] = $T["emailvalidate"];
		if (!$_SESSION['emailvalidate']) $_SESSION['emailvalidate']=0;
		if (strlen($_SESSION['email'])<2) $_SESSION['emailvalidate']=666; //old users
		
		$_SESSION['shown_name'] = $D["user"]["user_real_name"]." ".$D["user"]["user_real_surname"];
		$_SESSION['ulevel'] = $D["user"]["user_level"];
		$_SESSION['name'] = $D["user"]["user_real_name"];
		$_SESSION['surname'] = $D["user"]["user_real_surname"];
		$_SESSION['sex'] = $D["user"]["sex"];
		
		$_SESSION['role0'] = $D["user"]["role0"];
		$_SESSION['role1'] = $D["user"]["role1"];
		$_SESSION['role2'] = $D["user"]["role2"];
		$_SESSION['role3'] = $D["user"]["role3"];
		
		$_SESSION["lang"] = $P['launch_presentation_locale'];
		$_SESSION["familytitle"]=$D["family"]["title"];
		$URL="".C_DIR."";
		if (!$DEBUG && $P["custom_game"] && is_numeric($P["custom_game"]) ) {
			$URL=C_DIR."?/desktopplayer/".$P["custom_game"];
			//die("$URL eccoci");exit();
		}
		if(!$DEBUG) {
			header("location:/".$URL."");		
	//		header("location:/".C_DIR."");	
			exit();	
		}
	}


// IT05Q3608105138235232235237
	echo "<div style=\"font-size:23px; font-family:Verdana, Geneva, sans-serif\" class=\"\">Please, <a href=\"".$URL."\">click here ( user:".$D["user"]["users_id"].")		($signature==".$P["oauth_signature"].")</a></div>";	
}else{

	echo "Sorry,<br />your moodle's signup doesn't work.<br />";
}

if($DEBUG) {
	echo "<pre>";
	print_r($P);
	print_r($launch_params);
	
	print_r($D);
	echo "</pre>";
}

?>


