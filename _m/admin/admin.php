<?php
if ($DIRA[2]){
	$dataF=sql_queryt("SELECT * from family where family='".db_string($DIRA[2])."'");
	if ($dataF["secret"]) {
		$_SESSION['family'] =$dataF["family"];
		$_SESSION['familytitle'] =$dataF["title"];
		header("location:/?admin");
	}
}


$CSSA[]=''.C_DIR.'/_m/admin/admin.css';
$O.='<div id="core">';
require_once(C_ROOT."/_m/header/header.inc.php");
//require_once(C_ROOT."/config/php.function.games.php");
$page["titlePre"]=L_admin." ";
$q=sql_query("SELECT * from family ORDER BY id ASC");



while (	$d=sql_fetch_assoc($q)) {
	$O.="<div class=\"boxa\">";
		 $O.="<strong>";
		 $O.="<a title=\"login as ".$d["title"]."'s Family \" class=\"f\" href=\"?/admin/".$d["family"]."\">";
		if ($_SESSION["family"]==$d["family"]) $O.="&radic; ";
		else $O.="- ";
		$O.="".$d["title"]."</a><br />";
		 $O.="</strong>";
		$O.="<div class=\"boxb\">";
			$O.="ID: ".$d["family"]."";
		$O.="</div>";
		$O.="<div class=\"boxb\">";
			$O.="Moodle ISS: ";
            if ($d["iss"]) $O.='<a target="_BLANK" href="'.$d["iss"].'">'.$d["iss"].'</a>';
		$O.="</div>";
        
		$O.="<div class=\"boxb\">";		
			//$O.="public key: ".$d["public"]."";
            $O.="Moodle LTI 1.3 public key:<br />";
            $O.='<textarea disabled="disabled" style="padding:10px; font-size:12px" name="public" rows="8" cols="80">';
            $O.=$d["public"];
            $O.='</textarea>';
		$O.="</div>";
	//$O.=print_r($d, true);	
	$O.="</div>";
}




//$O.="<pre>****".$_SERVER['HTTP_USER_AGENT'];	
		if ($_COOKIE["debug"])				{
			$O.='<br />
<br />
<br />
<br />
<br />
<br />
<br />
<div class="clear"></div>';
			$O.="<pre>";	
			$O.=print_r($dataF,true);
			$O.=print_r($DIRA,true);
			$O.=print_r($_SESSION,true);
			$O.=print_r($d,true);
			$O.="</pre>";
		}
$O.="</div>";//core
	$O.='<div class="clear"></div>';
	$O.="<br /><br /><br />";
?>
