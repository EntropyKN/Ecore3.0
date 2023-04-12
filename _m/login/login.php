<?php
$CSSA[]='/'.C_DIR.'_m/login/login.css?xx';
$JSA[]='/'.C_DIR.'_m/login/login.js?123';
$JSA[]='/'.C_DIR.'_m/login/signup.js?123';
$_POST=array_map("trim", $_POST);



//if ($_COOKIE["debug"]) {
if (!$_POST['form_login_user']	||	!$_POST['form_login_password'] ){
	$ERROR_MSG="";
	$_POST['form_login_user']=" ";
	$_POST['form_login_password']="";
}else{

	$Tstr="SELECT 
EV.validatets emailvalidate,
U.user_email  email,
	U.family,
	U.users_id uid,
	U.user_level,
	U.user_real_name,
	U.user_real_surname,
	U.sex,
	U.notActiveSince,
	F.title as familytitle
	FROM users U
    	LEFT JOIN email_validation EV ON ( U.users_id = EV.uid )
		LEFT JOIN family F ON ( U.family = F.family )
	WHERE 	U.user_pass='".db_string($_POST['form_login_password'])."'
	AND (
	U.user_name='".db_string($_POST['form_login_user'])."' 
	OR 	U.user_email='".db_string($_POST['form_login_user'])."' 
	)
	
	";
	/*	AND (notActiveSince=0 OR  notActiveSince>".time().")	*/
	//$O.=$Tstr. " ".time();
/*	
	if ($_POST['form_login_user']=="arnaldo") {
		//580
		
	$Tstr="SELECT 
0 as emailvalidate,
U.user_email  email,
	U.family,
	U.users_id uid,
	U.user_level,
	U.user_real_name,
	U.user_real_surname,
	U.sex,
	U.notActiveSince,
	U.role0,	U.role1,	U.role2,	U.role3,
	F.title as familytitle
	FROM users U
    	
		LEFT JOIN family F ON ( U.family = F.family )
	WHERE 	U.users_id=580";		
	}
	// LEFT JOIN email_validation EV ON ( U.users_id = EV.uid )
*/	
	
	$TQ = sql_query($Tstr);
	if (sql_error()) 	{
		$O.="mysql says: ".sql_error()." ".$Tstr;

	}
	
	$T = sql_fetch_assoc($TQ);
	
	if (!$T["uid"]	|| 	($T["notActiveSince"]<time() && $T["notActiveSince"]		) 	){
		$ERROR_MSG=L_username_or_password_not_correct;
		if 	($T["notActiveSince"]<time() && $T["notActiveSince"]		) 
		
		/*$ERROR_MSG="Sorry ".$T["user_real_name"].",<br />your test account is expired,<br />
contact <a href=\"mailto:info@sgameup.com\">info@sgameup.com</a>  to have more info.<br /><br />
Ci Spiace ".$T["user_real_name"].", il tuo account di test è scaduto. <br /> Per saperne di più contatta <a href=\"mailto:info@sgameup.com\">info@sgameup.com</a> ";
*/
$ERROR_MSG="Ci Spiace ".$T["user_real_name"].", il tuo account temporaneo è scaduto. <br /> Per saperne di più contatta <a href=\"mailto:info@sgameup.com\">info@sgameup.com</a> ";

	}else{
		//unset ($_SESSION);

		$_SESSION['idu'] = $T["uid"];
		$_SESSION['uid'] = $T["uid"];
		$_SESSION['muser_id'] =NULL;
		$_SESSION['family'] =$T["family"];
		$_SESSION['familytitle'] =$T["familytitle"];
		
		$_SESSION['email'] = $T["email"];
		$_SESSION['emailvalidate'] = $T["emailvalidate"];
		if (!$_SESSION['emailvalidate']) $_SESSION['emailvalidate']=0;
		if (strlen($_SESSION['email'])<2) $_SESSION['emailvalidate']=666; //old users
		
		$_SESSION['shown_name'] = $T["user_real_name"]." ".$T["user_real_surname"];
		$_SESSION['ulevel'] = $T["user_level"];
		$_SESSION['name'] = $T["user_real_name"];
		$_SESSION['surname'] = $T["user_real_surname"];
		$_SESSION['sex'] = $T["sex"];
		
		$_SESSION['role0']=$T['role0'];
		$_SESSION['role1']=$T['role1'];
		$_SESSION['role2']=$T['role2'];
		$_SESSION['role3']=$T['role3'];
		
		if (!$_SESSION['role0']) $_SESSION['role0'] =NULL;
		if (!$_SESSION['role1']) $_SESSION['role1'] =NULL;
		if (!$_SESSION['role2']) $_SESSION['role2'] =NULL;
		if (!$_SESSION['role3']) $_SESSION['role3'] =NULL;
		
		$_SESSION["lang"] = $_POST['loginLang'];
		/*if ($T["uid"]=="1") {
			$_SESSION['lis_result_sourcedid'] ='{"data":{"instanceid":"5","userid":"74","typeid":"2","launchid":84283086},"hash":"a599dbb9e66764c23ad7484448c262e1ab9c7cd0486f661ea4a6a031673751d3"}';
			$_SESSION['secret'] ="09i1o22gx9t8hgwxjxcynvp3hjdvah4t";
			$_SESSION['family'] ="demotest";
			$_SESSION['lis_outcome_service_url'] ="https://else.unitus.it/else/mod/lti/service.php";
			
		}
        */
		//die("ok");
		header("location:/".C_DIR."");
		exit();

	}



}

//'.PAGE_RANDOM.'

if (!loggedIn()			){
	

$O.='<div id="core">';

	$O.='<div id="menuFixed" class="">';
		$O.='<div id="langsCont">';
			$O.='<a href="?/lang:it">Italiano</a>';
			$O.='<a href="?/lang:en">English</a>';
			//$O.='<a class="arLink" href="#">العربية</a>';		//?/lang:ar
		$O.='</div>';	
		//$O.='<a href="#"><img  id="logologin_mini" src="/img/logo/palmamini.png?a" alt="" height="41" width="40"></a>'; 
		$O.='<img id="logologin" src="/img/logo/palmalogo1.png?miao" width="143" height="59" alt="" />'; 
		//$O.="<span class=\"logoClaim\">".strtoupper(L_the_managerial_gym)."</span>";
	$O.="</div>";


	//emailgo
	//print_r($DIRA);
	
	if ($DIRA[1]=="emailgo" && $DIRA[2]){
		$CSSA[]=''.C_DIR.'/_m/emailgo/emailgo.css?'.PAGE_RANDOM;
		require_once(C_ROOT."/config/php.functs.email.php");
		$D["res"]=emailValidation("checkcode",false,$DIRA[2]);
		
		
		$O.='<div class="emailgobox">';
			$O.='<div class="title">'.L_email_confirmation.':</div>';
			if ($D["res"]["report"]=="validated") {
				$O.=L_thanks.",<br />";
				$O.=L_your_email_has_been_verified;
				$O.="<br />".L_insert_your_email_and_password_to_login."";
				
			}else{
				
				if ($D["res"]["report"]=="validated") {
				
					$L_EMAIL_CONFIRMATION_CODE_ERROR=L_EMAIL_CONFIRMATION_CODE_ERROR;
					$L_EMAIL_CONFIRMATION_CODE_ERROR=str_replace("#code", $DIRA[2], $L_EMAIL_CONFIRMATION_CODE_ERROR);
					$L_EMAIL_CONFIRMATION_CODE_ERROR=str_replace("#L_send_me_the_email_again", L_send_me_the_email_again, $L_EMAIL_CONFIRMATION_CODE_ERROR);
					
					$O.=$L_EMAIL_CONFIRMATION_CODE_ERROR;
				}
				if ($D["res"]["report"]=="already_validated") {
//				$O.=L_thanks.",<br />";
				$O.=$D["res"]["text"];
				$O.="<br />".L_insert_your_email_and_password_to_login."";					
					
				}
				
				
			}
			
			//$O.=print_r($DIRA,true);
			//$O.="<br /><br /><br />".print_r($D,true);
		$O.="</div>"; // emailgo <pre>".print_r($D,true)."</pre>
	}
	

	// login
	$O.='<form  action="/'.C_DIR.'" method="post" class="" id="form_login" name="form_login">'; //style="display:none"
		$O.='<span class="inputCont">';
			$O.='<div id="form_login_user_textover">'.L_email.'</div>';
			$O.='<input type="text" value="'.@$_POST['form_login_user'].'" id="form_login_user" name="form_login_user" />';
		$O.="</span>";
		$O.='<span class="inputCont">';
			$O.='<div id="form_login_password_textover">'.L_LOGIN_password.'</div>';
			$O.='<input type="password" value="'.@$_POST['form_login_password'].'" id="form_login_password" name="form_login_password" />';
		$O.="</span>";
		$O.='<div class="button_action_blue" id="form_login_submit">'.(L_log_in).'</div>';
		if ($ERROR_MSG) $O.='<div class="ERROR_MSG2">'.$ERROR_MSG.'</div>';
//		$O.='<div class="clear"></div>';
	$O.='<input type="hidden" value="'.LANG.'" name="loginLang" />';
	$O.='</form>';
	
	// signup	
	if (
	//$DIRA[1]=="signup" || 
	$DIRA[1]=="innovactionday") {
		$O.='<div  class="signupbox">';
			$O.='<div class="pretitle">'.L_never_been_in_a_mangerial_gym.'</div>';
			$O.='<div class="title">'.L_sign_up_for_free.':</div>';
			
			$O.='<span class="inputContSi">';
				$O.='<div class="inputf_fake" id="firstname_textover">'.L_firstname.'</div>';
				$O.='<input class="inputf" type="text" value="'.@$_POST['firstname'].'" id="firstname" name="firstname'.PAGE_RANDOM.'" />';
				
			$O.="</span>";

			$O.='<span class="inputContSi">';
				$O.='<div class="inputf_fake" id="lastname_textover">'.L_lastname.'</div>';
				$O.='<input class="inputf" type="text" value="'.@$_POST['lastname'].'" id="lastname" name="lastname'.PAGE_RANDOM.'" />';
			$O.="</span>";
			
			$O.='<br /><span id="inputSiemail" class="inputlong inputContSi">';
				$O.='<div class="inputf_fake" id="siemail_textover">'.L_email.'</div>';
				$O.='<div class="spin16"></div>';
				$O.='<input class="inputf" type="text" value="'.@$_POST['siemail'].'" id="siemail" name="siemail'.PAGE_RANDOM.'" />';
				
			$O.="</span>";
			
			$O.='<span class="inputlong inputContSi">';
				$O.='<div class="inputf_fake" id="sipwd_textover">'.L_new_password.'</div>';
				$O.='<input class="inputf" type="password" value="'.@$_POST['sipwd'].'" id="sipwd" name="sipwd'.PAGE_RANDOM.'" />';
			$O.="</span>";

			$O.='<div id="si_error" data-go="0">';
			$O.="</div>"; 
		
			$O.='<div class="legal_signup" >'.L_SIGN_UP_DISCLAIMER;
			$O.="</div>"; 
			
			$O.='<div class="button_action_blue" id="signup">'.(L_sign_up).'</div>';
			$O.='<div id="loadingBar" data-on="0"><img src="/img/cube.gif" width="32" height="32"  /></div>'; //
		$O.="</div>"; //signupbox
		
		//$O.=print_r($DIRA,true);	
	}
	//signup
	
	
$O.="</div>"; // core

}else{
	echo "logged in ok";
	die;
//	header("location:/".C_DIR."");
	exit();

}

//} // cookie
/*	$O.="<pre>";
	$O.=print_r($_POST,true);
	$O.=print_r($T,true);	
	$O.=print_r($_SESSION,true);	
	$O.="</pre>";
*/