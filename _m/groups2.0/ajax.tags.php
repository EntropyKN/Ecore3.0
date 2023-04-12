<?php
ini_set("display_errors", "1");
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
if(!$_SESSION["ulevel"]>0){echo "false|-|not_logged"; return;}	
$D=$_GET;

if ($D["action"]=="search" || $D["action"]=="searchall"|| $D["action"]=="searchGroup") {
	if ($D["action"]=="searchall"){
		$lang_trigger="edt";require_once(C_ROOT."/config/lang.inc.php");
	}
	$D["q"]=strtolower(	trim($D["q"]));

	$D["query"]="
	SELECT * FROM 
	(SELECT 
		'gym' as type, 
		G.gameId as id, 
		G.title as title , 
		G.status as status
		/*,'A' as inDb*/
		FROM games G 
		WHERE 1 
		AND G.status='playable' 
		/*AND 
		(
		G.uid_creator IN (SELECT users_id FROM users WHERE family='".$_SESSION["family"]."' )
		OR G.gameId IN (SELECT gameId FROM game_family WHERE family='".$_SESSION["family"]."' )
		)
		*/
		";	 
		
		//status!='offline'
	//if ($D["idgr"]&& is_numeric($D["idgr"]) ) $D["query"].=" AND G.gameId NOT IN (SELECT gameId FROM gym_usersgroups WHERE idgroup=".$D["idgr"]." IS NOT NULL) ";		
		
	$D["query"].="	UNION
SELECT 
		'user' as type, 
		U.users_id as id, 
concat(
        COALESCE(U.user_real_name,'') ,' ',COALESCE(U.user_real_surname,'') 
        
        )   as title , 
		'' as status
		/*,GR.uid as inDb*/
		FROM users U 
		/*LEFT JOIN user_usersgroups GR on (GR.uid=U.users_id)*/
		WHERE U.family='".$_SESSION["family"]."'  
		";	
	//if ($D["idgr"]&& is_numeric($D["idgr"]) ) $D["query"].=" AND U.users_id NOT IN (SELECT uid FROM user_usersgroups WHERE idgroup=".$D["idgr"]." IS NOT NULL) ";

	if ($D["action"]=="searchall")
	$D["query"].="	UNION
SELECT 
		'group' as type, 
		G.idgroup as id, 
		G.name as title , 
		'' as status
		FROM usersgroups G 
		WHERE G.family='".$_SESSION["family"]."' 
		";	

if ($D["action"]=="searchGroup"){ //reset for group only
	$D["query"]="SELECT * FROM 
	(	SELECT 
		'group' as type, 
		G.idgroup as id, 
		G.name as title , 
		'' as status
		FROM usersgroups G 
		WHERE G.family='".$_SESSION["family"]."'  
		";		
}
	
	$D["query"].="
	
	) AS SRCTMP
		WHERE SRCTMP.title LIKE  '%".db_string($D["q"])."%'	
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
	if ($d["type"]=="user") {
		if (in_array(	$d["id"], 		explode(",",$D["usersCSV"])	)) $d["ClassinDb"]=" inDB";
		$idDiv='tagusr_'.$d["id"];
		$idDivA='tagusrs_'.$d["id"];
		$typeTxt=L_user;
	}

	if ($d["type"]=="gym") {
		if (in_array(	$d["id"], 		explode(",",$D["gymsCSV"])	)) $d["ClassinDb"]=" inDB";
		$idDiv='taggym_'.$d["id"];
		$idDivA='taggyms_'.$d["id"];
		$typeTxt=L_gym;
	}
	if ($d["type"]=="group") {
		$d["ClassinDb"]="";
		if ($D["action"]=="searchGroup") if (in_array(	$d["id"], 		explode(",",$D["groupCSV"])	)) $d["ClassinDb"]=" inDB";
		
		$typeTxt=L_group;
		$idDivA='taggroups_'.$d["id"]; //NOT taggroup!
		$idDiv='taggroup_'.$d["id"];
	}
	if ($D["action"]=="search")			$OUT.='<div class="tag '.$d["type"].$d["ClassinDb"].'" id="'.$idDiv.'">'.$d["title"].'</div>';
	if ($D["action"]=="searchall")	 	$OUT.='<div class="hd_notification_linelink" id="'.$idDivA.'"><span class="hd_notification_text">'.$d["title"].'</span><span class="hd_notification_date">'.$typeTxt.'</span></div>';	
	if ($D["action"]=="searchGroup")	$OUT.='<div class="tag '.$d["type"].$d["ClassinDb"].'" id="'.$idDiv.'">'.$d["title"].'</div>';
	
	//hd_notification_linelink
	
	
	$D["d"][]=$d;
	$D["homany"]++;
endwhile;
if (!$D["homany"]) {
	$lang_trigger="usr";
	require_once(C_ROOT."/config/lang.inc.php");	
	
	if ($D["action"]=="search")	 $OUT='<div id="noResults">'.L_no_results.'</div>';
	else $OUT='<div class="noResults">'.L_no_results.'</div>';
	echo "true|-|".$OUT;
	return;
}
echo "true|-|".$OUT."|-|".$D["homany"]."|-|";
//.print_r($D,true);

}

if (($D["action"]!="search") &&$D["action"]!="searchall" && ($D["action"]!="add")	) {echo "false|-|no_action"; return;}

//$USER_LOGGED=loggedIn();
//print_r($_SESSION);



	
############################################ SEARCH
if ($D["action"]=="search") {


	$OUT.="OUT:";
	/*;*/
	
	//echo $OUT;
	
	echo "true|-|".$OUT."|-|";//.print_r($D,true);
	

} ################################################################################ search end

?>