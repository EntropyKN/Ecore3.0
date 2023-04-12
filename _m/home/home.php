<?php
$JSA[]=''.C_DIR.'/_m/home/home.js?'.PAGE_RANDOM;
$JSA[]=''.C_DIR.'/_m/gameBrowse.js?'.PAGE_RANDOM;

$CSSA[]=''.C_DIR.'/_m/home/home.css';
$O.='<div id="core">';
require_once(C_ROOT."/_m/header/header.inc.php");
require_once(C_ROOT."/config/php.function.games.php");
$playerVersion=playerVersion();

$page["titlePost"]=" - ".L_dashboard."";

///// _msg

if ($DIRA[1]=="_msg" && is_numeric($DIRA[3]) ){
	$strADV="SELECT title FROM games WHERE gameId=".$DIRA[3];
	$advData=sql_queryt($strADV);
	
	if ($advData["title"]) {
		$O.='<div class="boxadvice">'; $O.='<div class="boxadviceIn">';
			$O.="<span>".$advData["title"]."</span>";
			if ($DIRA[2]=="savedPlayable") 	$O.=L_ALERT_GAME_SAVED_AS_PLAYABLE;
			if ($DIRA[2]=="copied") 				$O.=L_ALERT_GAME_COPIED;
			if ($DIRA[2]=="settedoff") 			$O.=L_ALERT_GAME_SETTED_OFF;
			$O.='<div class="dismiss">';
			$O.=L_ok;
			$O.="</div>";
			//$O.=print_r($DIRA,true);
		$O.="</div>";$O.="</div>";
	}
}


$O.='<div class="boxresp">';
	$O.='<div class="box">';
		$O.='<div class="title">';
			$O.=str_replace(" ", "&nbsp;", L_the_games);
			//$O.=mysql_error();
			//$O.=" (".deviceType()." - ".$playerVersion."".")";	//.$_SERVER['HTTP_USER_AGENT']
		$O.="</div>";
		$O.='<div class="content">';	
			$d=getGames();	
			$O.=$d["htm"];
			
			if ($_COOKIE["debug"]){
				unset ($d["htm"]);
				$O.='<div class="clear"></div>';
				$O.="<pre>";	
				$O.=print_r($_SESSION,true);
				$O.=print_r($d,true);
				$O.="</pre>";
			}			
			
			$O.='<div class="clear"></div>';
		$O.="</div>";// content
	$O.="</div>";
$O.="</div>";

######################################## L_the_games




######################################## L_drafts
if ($_SESSION["ulevel"]>0) {
	$O.='<div class="boxresp">';
		$O.='<div class="box">';
			$O.='<div class="title">';
				$O.=str_replace(" ", "&nbsp;", L_drafts);
			$O.="</div>";
			$O.='<div class="content">';	
				$d=getGames(1,"drafts");
				//$O.="<pre>";	$O.=print_r($d["s"],true);$O.="</pre>";				
				if ($d["s"]["results"]){
					$O.=$d["htm"];
				}else{
					$O.='<div class="nores">'.L_NO_RESULTS_DRAFTS.'</div>';
					$O.='<div class="clear"></div>';
					$O.='<a class="rightLink rightLinkalone" href="?/editor/0/0">';
						$O.=L_create_a_new_game;
					$O.="</a>";
				}			
				$O.='<div class="clear"></div>';
			$O.="</div>";// content
		$O.="</div>";
	$O.="</div>";
/*
	$O.='<div class="clear"></div>';
	*/
			/*	if ($_COOKIE["debugX"])				{
					$O.="<pre>";	
					$O.=print_r($_SESSION,true);
					$O.=print_r($d["s"],true);
					$O.="</pre>";
				}	*/

	/*
	$d=getGames(1,"offline");
	if ($d["s"]["results"]){
	$O.='<div class="boxresp">';
		$O.='<div class="box">';
			$O.='<div class="title">';
				$O.=str_replace(" ", "&nbsp;", L_offline);
			$O.="</div>";
			$O.='<div class="content">';
				//$O.="<pre>";	$O.=print_r($d["s"],true);$O.="</pre>";		
					$O.=$d["htm"];
				$O.='<div class="clear"></div>';
			$O.="</div>";// content
		$O.="</div>";
	$O.="</div>";

	}*/
	
}	//if ($_SESSION["ulevel"]>0) {

if ($_SESSION["ulevel"]==0) {
	
	
	
}

######################################## L_matches
	$O.='<div class="boxresp">';
		$O.='<div class="box">';
			$O.='<div class="title">';
				$O.=str_replace(" ", "&nbsp;", L_my_matches);
			$O.="</div>";
			$O.='<div class="content">';	
				$d=getGames(1,"matches");
				//if ($_COOKIE["debugX"])  {$O.="<pre>";	$O.=print_r($d["s"],true);$O.="</pre>";}
				if ($d["s"]["results"]){
					$O.=$d["htm"];
				}else{
					$O.='<div class="nores">'.L_NO_RESULTS_MATCHES.'</div>';
				}
			if ($_COOKIE["debugX"]){
				unset ($d["htm"]);
				$O.='<div class="clear"></div>';
				$O.="<pre>";	
				//$O.=print_r($_SESSION,true);
				$O.=print_r($d,true);
				$O.="</pre>";
			}			
							
				
				
				$O.='<div class="clear"></div>';
			$O.="</div>";// content
		$O.="</div>";
	$O.="</div>";





//$O.="<pre>****".$_SERVER['HTTP_USER_AGENT'];	
		if ($_COOKIE["debugX"])				{
			$O.='<div class="clear"></div>';
			$O.="<pre>****".$_SERVER['HTTP_USER_AGENT'];	
			$O.=print_r($_SESSION,true);
			$O.=print_r($d,true);
			$O.="</pre>";
		}
$O.="</div>";//core
	$O.='<div class="clear"></div>';
	$O.="<br /><br /><br />";
?>
