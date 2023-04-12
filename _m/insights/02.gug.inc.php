<?php
//gug=groups/users/gyms
require_once(C_ROOT."/_m/insights/global.inc.php");



if ($_SESSION["ulevel"]==0	)	{
	$D=getGamesUserFromGroups($_SESSION["insights"]["groups"]);
}else{
	$D=getGamesUserFromGroups("ALL");	
//	die("ALL");
}
$D["idsusers"]=array();
$D["idsgroups"]=array();
$D["idsidgyms"]=array();

$HEAD_ADD.='<script type="text/javascript">

var group_gym='.json_encode($D["group_gym"]).';


var group_user='.json_encode($D["group_user"]).';</script>';


$O.='<div class="clear"></div>';
$O.='<div id="gug">'; 

	$O.='<div id="groupss">'; 
		$O.='<div class="stit">'.L_groups .'	<span id="group_sel">'.sizeof(	$D["groups"]			).'</span>/<span id="group_tot">'.sizeof(	$D["groups"]			).'</span><a class="latChoice" id="allgroups" href="#">'.L_all.'</a> <a class="latChoice" id="nogroups" href="#">'.L_none.'</a></div>';
		
		$O.='<div class="cont" id="cont_group">';
		if ($D["groups"]) foreach( $D["groups"] as $k => $v ) {
			$D["idsgroups"][]=$v["idgroup"];
			$O.='<div class="r on" id="group_'.$v["idgroup"].'">';
			$O.=$v["name"];
			$O.="</div>";
		}
		$O.="<div id=\"ids_group\">".implode(",",$D["idsgroups"])."</div>";
		$O.="</div>";
		
	$O.="</div>";
	
	$O.='<div id="userss">'; 
	$O.='<div class="stit">'.L_users .'	<span id="user_sel">'.sizeof(	$D["users"]			).'</span>/<span id="user_tot">'.sizeof(	$D["users"]			).'</span></div>';
	$O.='<div class="cont" id="cont_user">';
	if ($D["users"]) foreach( $D["users"] as $k => $v ) {
		$D["idsusers"][]=$v["uid"];
		$O.='<div class="r on" id="user_'.$v["uid"].'">'; 
		$O.=$v["name"];
		$O.="</div>";
	}	
		$O.="<div id=\"ids_user\">".implode(",",$D["idsusers"])."</div>";
		$O.="</div>";
	$O.="</div>";
	
	$O.='<div id="gymss">'; 
	$O.='<div class="stit">'.L_games .'	<span id="gym_sel">'.sizeof(	$D["gyms"]			).'</span>/<span id="gym_tot">'.sizeof(	$D["gyms"]			).'</span></div>';
	$O.='<div class="cont" id="cont_gym">';
	if ($D["gyms"]) foreach( $D["gyms"] as $k => $v ) {
		$classStatus="";if ($v["status"]=="offline") $classStatus=" offline";
		
		$D["idsidgyms"][]=$v["gameId"];
		$O.='<div title="'.$v["status"].'" class="r on'.$classStatus.'" id="gym_'.$v["gameId"].'">'; 
		$O.=$v["title"];
		//$O.=" - ".$v["status"];
		$O.="</div>";
	}
		$O.="<div id=\"ids_gym\">".@implode(",",$D["idsidgyms"])."</div>";
		$O.="</div>";		
	$O.="</div>";


$O.="</div>";


?>