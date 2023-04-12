<?php
// https://to.sgameup.com/_m/scenarios/getItems.ajax.php?mode=all
error_reporting(E_ALL ^ E_NOTICE);ini_set("display_errors",1);
header('Content-Type: application/json; charset=utf-8');

include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
if ($_SESSION["ulevel"]<1) {
	$D["response"]=false;
	$D["reason"]="mm sounds like you're not logged at the moment";
	echo json_encode($D);
	return;		
}
$lang_trigger="edt";
require_once(C_ROOT."/config/lang.inc.php");

$D=$_POST;$D=array_map("trim",$D);

$D["response"]=true;
$D["reason"]="";




$D=$_POST;
if ($_GET) $D=$_GET;
$D=array_map("trim",$D);
$D["response"]=true;

##checks
if ($D["mode"]!="all"&&$D["mode"]!="mine"&&$D["mode"]!="recent"&&$D["mode"]!="publicWannabe"){
	$D["response"]=false;
	$D["reason"]="a little error occurred: mode incorrect";	
	echo json_encode($D);
	return;	
}
if ($_SESSION["ulevel"]<3 &&$D["mode"]=="publicWannabe" ){
	$D["response"]=false;
	$D["reason"]="Sorry, you don't have the righ permissions";	
	echo json_encode($D);
	return;	
}

if ($D["Q"]=="false") $D["Q"]=false;
$lang_trigger="usr";require(C_ROOT."/config/php.humantime.2.0.inc.php");


if (!$D["page"]) $D["page"]=1;
$D["nextPage"]="1";
$records=15;
//const subsetData= {"t1": "all", "t2": "mine", "t3": "recent"};

if ($D["mode"] =="all"){ ############################ ALL
    $D["strlines"]="select S.id, S.name, CONCAT(U.user_real_name,' ', U.user_real_surname) creatorName, S.creationDate   , 
    S.propertyUid, S.creatorUid, S.publicWannabe as waitS
    from scenarios S 
    LEFT JOIN users U ON U.users_id=S.creatorUid
    WHERE S.invisble=0 AND (S.propertyUid=0 OR S.propertyUid=".$_SESSION["uid"].")
    order by S.name asc limit ".($records*($D["page"]-1)).",$records ";    

    if ($D["Q"]) 	{
        $Qs=trim(db_string($D["Q"]));
        $D["strlines"]="select S.id, S.name, CONCAT(U.user_real_name,' ', U.user_real_surname) creatorName, 
        S.creationDate   , S.propertyUid, S.creatorUid,
        (CASE
        WHEN (S.name LIKE '" . $Qs . "'  	) THEN 1  
        WHEN (S.name LIKE '" . $Qs . "%'  	) THEN 2
        WHEN (S.name LIKE '%" . $Qs . "%'  	) THEN 3
        END)
        as relevance  , S.publicWannabe as waitS   
        from scenarios S 
        LEFT JOIN users U ON U.users_id=S.creatorUid
        WHERE S.name LIKE '%" . $Qs . "%' AND
        S.invisble=0 AND (S.propertyUid=0 OR S.propertyUid=".$_SESSION["uid"].")
        ORDER BY `relevance` ASC limit ".($records*($D["page"]-1)).",$records "; 

    }
}

if ($D["mode"] =="mine"){ ############################ mine
    $D["strlines"]="select S.id, S.name, CONCAT(U.user_real_name,' ', U.user_real_surname) creatorName, S.creationDate   , 
    S.propertyUid, S.creatorUid, S.publicWannabe as waitS
    from scenarios S 
    LEFT JOIN users U ON U.users_id=S.creatorUid
    WHERE S.creatorUid=".$_SESSION["uid"]." AND 
    S.invisble=0 order by S.name asc limit ".($records*($D["page"]-1)).",$records ";    

    if ($D["Q"]) 	{
        $Qs=trim(db_string($D["Q"]));
        $D["strlines"]="select S.id, S.name, CONCAT(U.user_real_name,' ', U.user_real_surname) creatorName, 
        S.creationDate   , S.propertyUid, S.creatorUid,
        (CASE
        WHEN (S.name LIKE '" . $Qs . "'  	) THEN 1  
        WHEN (S.name LIKE '" . $Qs . "%'  	) THEN 2
        WHEN (S.name LIKE '%" . $Qs . "%'  	) THEN 3
        END)
        as relevance , S.publicWannabe as waitS
        from scenarios S 
        LEFT JOIN users U ON U.users_id=S.creatorUid
        WHERE 
        S.creatorUid=".$_SESSION["uid"]." AND 
        S.name LIKE '%" . $Qs . "%' AND
        S.invisble=0 ORDER BY `relevance` ASC limit ".($records*($D["page"]-1)).",$records "; 

    }
}

if ($D["mode"] =="recent"){ ############################ RECENT

/*    $D["strlines"]="select S.id, S.name, CONCAT(U.user_real_name,' ', U.user_real_surname) creatorName, S.creationDate  , 
    S.propertyUid, S.creatorUid, Y.lastUsed
    from scenarios S 
    LEFT JOIN users U ON U.users_id=S.creatorUid
RIGHT JOIN 
(
	SELECT X.scenario_id , MAX(X.used) lastUsed FROM 
	(
	SELECT GM.scenario_id,
	G.gameId, FROM_UNIXTIME((G.editTs)) used 
	FROM `games` G 
	RIGHT JOIN  games_steps GM ON G.gameId =GM.gameId
	WHERE G.uid_creator=".$_SESSION["uid"]."  AND GM.scenario_id IS NOT NULL  
	    ) X
	GROUP BY X.scenario_id  
) Y ON S.id=Y.scenario_id  
WHERE S.invisble=0
ORDER BY `Y`.`lastUsed` DESC, S.name ASC
 limit ".($records*($D["page"]-1)).",$records ";    
*/

$D["strlines"]="select S.id, S.name, CONCAT(U.user_real_name,' ', U.user_real_surname) creatorName, S.creationDate,
    S.propertyUid, S.creatorUid, US.date_up, S.publicWannabe as waitS
    from scenarios S 
    LEFT JOIN users U ON U.users_id=S.creatorUid
    RIGHT JOIN scenarios_used US ON S.id=US.scenario_id
    WHERE S.invisble=0 AND US.uid=".$_SESSION["uid"]."  
ORDER BY `US`.`date_up`  DESC 
limit ".($records*($D["page"]-1)).",$records ";

    if ($D["Q"]) 	{
        $Qs=trim(db_string($D["Q"]));
 
 $D["strlines"]="select S.id, S.name, CONCAT(U.user_real_name,' ', U.user_real_surname) creatorName, S.creationDate,
    S.propertyUid, S.creatorUid, US.date_up
,
        (CASE
        WHEN (S.name LIKE '" . $Qs . "'  	) THEN 1  
        WHEN (S.name LIKE '" . $Qs . "%'  	) THEN 2
        WHEN (S.name LIKE '%" . $Qs . "%'  	) THEN 3
        END)
        as relevance  , S.publicWannabe as waitS
    from scenarios S 
    LEFT JOIN users U ON U.users_id=S.creatorUid
    RIGHT JOIN scenarios_used US ON S.id=US.scenario_id
    WHERE S.name LIKE '%" . $Qs . "%' AND 
    S.invisble=0 AND (S.propertyUid=0 OR S.propertyUid=".$_SESSION["uid"].")
    AND US.uid=".$_SESSION["uid"]."  
ORDER BY `relevance`, `US`.`date_up`  DESC 
limit ".($records*($D["page"]-1)).",$records ";
    }
}
if ($D["mode"] =="publicWannabe"){ ############################ ALL
    $D["strlines"]="select S.id, S.name, CONCAT(U.user_real_name,' ', U.user_real_surname) creatorName, S.creationDate   , S.propertyUid, S.creatorUid
    from scenarios S 
    LEFT JOIN users U ON U.users_id=S.creatorUid
    WHERE S.invisble=0 AND S.propertyUid>0 AND S.publicWannabe=1
    order by S.name asc limit ".($records*($D["page"]-1)).",$records ";    

    if ($D["Q"]) 	{
        $Qs=trim(db_string($D["Q"]));
        $D["strlines"]="select S.id, S.name, CONCAT(U.user_real_name,' ', U.user_real_surname) creatorName, 
        S.creationDate   , S.propertyUid, S.creatorUid,
        (CASE
        WHEN (S.name LIKE '" . $Qs . "'  	) THEN 1  
        WHEN (S.name LIKE '" . $Qs . "%'  	) THEN 2
        WHEN (S.name LIKE '%" . $Qs . "%'  	) THEN 3
        END)
        as relevance  , S.publicWannabe as waitS
        from scenarios S 
        LEFT JOIN users U ON U.users_id=S.creatorUid
        WHERE S.name LIKE '%" . $Qs . "%' AND
        S.invisble=0 AND S.propertyUid>0 AND S.publicWannabe=1
        ORDER BY `relevance` ASC limit ".($records*($D["page"]-1)).",$records "; 

    }
}

$D["recordsFound"]=0;

$qL=sql_query($D["strlines"]);
if (sql_error()) $D["strSentE"]=sql_error();

$D["strlines"]=str_replace("\n", " ", $D["strlines"]);
$D["strlines"]=str_replace("\t", "", $D["strlines"]);
while ($L=sql_fetch_assoc($qL)){
    $L["creationAgo"]=ago(strtotime($L["creationDate"]));     unset ($L["creationDate"])   ;
    if (   $D["mode"]=="recent" && $L["date_up"]) {
        $L["creationAgo"]=ago(strtotime($L["date_up"]));  
    }
    
    $used=sql_queryt("SELECT COUNT(DISTINCT(GS.gameId)) used FROM games_steps GS where scenario_id= ".$L["id"]);
    $L["used"]=$used["used"];
    if (!$L["creatorName"]) unset ($L["creatorName"]);
    if ($L["creatorUid"]==$_SESSION["uid"]) $L["creatorName"]=L_te;
    $L["del"]=0;
    if ($L["used"]==0){
        if ($L["creatorUid"]==$_SESSION["uid"] || $_SESSION["ulevel"]==3 ) $L["del"]=1;
    }
    
   // unset ($L["creatorUid"]);

 
    $D["recordsFound"]++;
    $D["data"][]=$L;
}
if ($D["recordsFound"]<$records) $D["nextPage"]="0";
    
unset ($D["strlines"]);
echo json_encode($D);
return;	


?>