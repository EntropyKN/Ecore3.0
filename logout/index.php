<?php
ob_start();
session_start();
$debug=false;
/*define("C_DIR", "_WEB02");
define("C_ROOT", $_SERVER['DOCUMENT_ROOT']."/".C_DIR."/");
require_once(C_ROOT."/config/php.config.inc.php");
*/

//user_track_update($_SESSION["idu"], "logout");


setcookie("PHPSESSID","1",time()-3600,"/");
setcookie("_gat","1",time()-3600,"/");

setcookie('remeberMe', '', time() - 3600,"/");
//unset($_COOKIE['remeberMe']);

setcookie('iduLogin', '', time() - 3600,"/");
//unset($_COOKIE['iduLogin']);

setcookie('dvmarkUser', '0', time() - 3600,"/");
//unset($_COOKIE['dvmarkUser']);

/*$_SESSION["PHPSESSID"]=false;
foreach ($_SESSION as $k => $v) {
	$_SESSION[$k]=0;
}*/
$_SESSION["userLogged"]=0;

$_SESSION = array();

if (ini_get('session.use_cookies')){
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 31536000, "/");
}


session_destroy();
session_unset();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);




if ($debug) {
	echo "<pre>";
	print_r($_COOKIE);
	print_r($_SESSION);
	echo "</pre>";
}else{
	//header("location: ".$_SERVER['HTTP_REFERER']);
	header("location: /?logout");
}
?>