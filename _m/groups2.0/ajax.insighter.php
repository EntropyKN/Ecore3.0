<?php
$D=$_GET; // debug
ini_set("display_errors", "1");
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
if(!$_SESSION["ulevel"]>0){echo "false|-|not_logged"; return;}	

	$D["q"]=strtolower(	trim($D["q"]));
	

	$D["query"]="SELECT 
		'user' as type, 
		U.users_id as id, 
		Concat(user_real_name ,' ',user_real_surname )  as title , 
		'' as status
		FROM users U 
		WHERE 1 and U.family='".$_SESSION["family"]."' AND
		(
		Concat(user_real_name ,' ',user_real_surname )  = '".db_string($D["q"])."'  OR
		Concat(user_real_name ,' ',user_real_surname )  LIKE '".db_string($D["q"])."%' OR
		 Concat(user_real_name ,' ',user_real_surname )  LIKE '%".db_string($D["q"])."%' 
		)
	ORDER BY CASE
		WHEN (title = '".db_string($D["q"])."'  ) THEN 1
		WHEN (title LIKE '".db_string($D["q"])."%'  ) THEN 2	
		WHEN title LIKE '%".db_string($D["q"])."%' THEN 3
		END
		LIMIT 0,20	
		";	



$qU=@sql_query($D["query"]);
if (sql_error() ) {echo "false|-||-|".sql_error();die;	}
$D["homany"]=0;

while ($d=sql_fetch_assoc($qU) ):
	
	$d["ClassinDb"]="";

	if (in_array(	$d["id"], 		explode(",",$D["insightesrCSV"])	)) $d["ClassinDb"]=" inDB";
	$idDiv='Etagusr_'.$d["id"];
	$typeTxt=L_user;

	$OUT.='<div class="tag '.$d["type"].$d["ClassinDb"].'" id="'.$idDiv.'">'.$d["title"].'</div>';
	
	//hd_notification_linelink
	
	
	$D["d"][]=$d;
	$D["homany"]++;
endwhile;

if (!$D["homany"]) {
	$lang_trigger="usr";
	require_once(C_ROOT."/config/lang.inc.php");	
	
	if ($D["action"]=="search")	 $OUT='<div id="noResults">'.L_no_results.'</div>';
	else $OUT='<div class="noResults">'.L_no_results.'</div>';
	echo "true|-|".$OUT."|-|".print_r($D,true);
	return;
}
echo "true|-|".$OUT."|-|".$D["homany"]."|-|";
//.print_r($D,true)."|-|".print_r($_GET,true);

die;
?>