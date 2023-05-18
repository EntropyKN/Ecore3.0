<?php

//https://cloud.google.com/text-to-speech/
define("IDGROUPGHOST", 2); // id gruppo contentente palestre non associate ad alcun gruppo

$timeParPresets=array('year','week','month','custom');
//$selected["year_0"]="";$selected["year_1"]="";
$selected["week_0"]="";$selected["week_1"]="";$selected["week_2"]="";$selected["week_3"]="";
$selected["month_0"]="";$selected["month_1"]="";$selected["month_2"]="";$selected["month_3"]="";
$selected["custom_0"]="";
	
	
function getGamesUserFromGroups ($idGroupsArray, $cmd=false) {
	//return false;
	 if (!loggedIn()	) return false;
	 $D["ids_group"]=array();$D["ids_gym"]=array();$D["ids_user"]=array();

	if (!$cmd ||$cmd!="all" ) $cmd=false;
	$D=array(
	"cmd"=>$cmd,
	"ids_group"=>array(),"ids_gym"=>array(),"ids_user"=>array(),
	"group_gym"=>array(), "group_user"=>array()
	);

	if ($idGroupsArray=="ALL") $D["mode"]="ALL";
	
	if (!$D["mode"])  if (empty ($idGroupsArray)	|| !is_array($idGroupsArray)	) return false;
	

	### groups
	if (!$D["mode"]) {
		$D["grupsQ"]="SELECT name, idgroup FROM usersgroups WHERE idgroup IN (".implode(", ", $idGroupsArray).") ORDER BY name ASC";
		$D["GymNoGroupQ"]=false;
	}else{ // all
		$idGroupsArray=array();
		$D["grupsQ"]="SELECT name, idgroup FROM usersgroups WHERE family='".$_SESSION["family"]."' ORDER BY name ASC";
		$D["GymNoGroupQ"]="SELECT  G.title, G.gameId, G.status FROM games G
	WHERE  G.status!='draft' AND  G.status!='deleted' AND G.gameId NOT IN  (SELECT DISTINCT GG.gameId FROM game_usersgroups GG)
	ORDER BY title ASC ";
/*AND G.gameId IN (SELECT
			distinct gu.gameId
			FROM
			game_usersgroups gu
			RIGHT JOIN 
			user_usersgroups uu ON (uu.idgroup=gu.idgroup)
			WHERE 
			uu.uid=580 )
					OR  G.uid_editor=580  OR  G.uid_creator=580	
	*/
	$D["GymNoGroupQ"]=false;
	}
	// 	enum('draft', 'playable', 'offline')
	
	$q=sql_query($D["grupsQ"]);
	if (sql_error()) $D["grupsQe"]=sql_error();
	while ($G=sql_fetch_assoc(	$q	)){
		$D["group_gym"][	$G["idgroup"]			]=array();
		$D["group_user"][	$G["idgroup"]			]=array();
		
		$G["q1"]=	"SELECT DISTINCT GG.gameId FROM game_usersgroups GG
		LEFT JOIN  games G ON G.gameId=GG.gameId
		WHERE G.status!='draft' AND  G.status!='deleted' AND GG.idgroup = ".$G["idgroup"]." ";		
		$q1=sql_query($G["q1"]);
		while ($G1=sql_fetch_assoc(	$q1	)){$D["group_gym"][	$G["idgroup"]			][]=$G1["gameId"];}
		$G["q2"]=	"SELECT DISTINCT uid FROM user_usersgroups WHERE idgroup = ".$G["idgroup"]." ";		
		$q1=sql_query($G["q2"]);
		while ($G2=sql_fetch_assoc(	$q1	)){$D["group_user"][	$G["idgroup"]			][]=$G2["uid"];}
		unset ($G["q1"], $G["q2"]);
		$D["groups"][]=$G;
		$idGroupsArray[]=$G["idgroup"];
		$D["ids_group"][]=$G["idgroup"];
	}
	//unset ($D["grupsQ"]);
	
	### Gyms
    if (!empty($idGroupsArray)) {
        $D["gymsQ"]="SELECT  G.title, G.gameId, G.status 
        FROM games G
        WHERE  G.status!='draft' AND  G.status!='deleted' AND G.gameId IN 
        (SELECT 
        DISTINCT GG.gameId
        FROM game_usersgroups GG
        WHERE GG.idgroup IN (".@implode(", ", $idGroupsArray).") 
        )
        ORDER BY title ASC ";
        $q=sql_query($D["gymsQ"]);
        if (sql_error()) $D["gymsQe"]=sql_error();
        while ($GY=sql_fetch_assoc(	$q	)){
            $D["gyms"][]=$GY;
            $D["ids_gym"][]=$GY["gameId"];
        }	
        //unset ($D["gymsQ"]);	

        ### USERS
        $D["usersQ"]="SELECT Concat (U.user_real_name, ' ', U.user_real_surname) name ,  U.users_id uid, U.sex, U.user_email as email 
        FROM users U WHERE U.users_id IN
        (SELECT 
        DISTINCT UG.uid
        FROM user_usersgroups UG
        WHERE UG.idgroup IN (".@implode(", ", $idGroupsArray).") 
        ) ORDER BY name ASC";
        $q=sql_query($D["usersQ"]);
        if (sql_error()) $D["usersQe"]=sql_error();
        while ($GY=sql_fetch_assoc(	$q	)){
            $D["users"][]=$GY;
            $D["ids_user"][]=$GY["uid"];
        }
	   //unset ($D["usersQ"]);	
	} //if (!empty(idGroupsArray)) {
	
	
	///////////////////////////////////// gyms with no groups
	
	if ($D["GymNoGroupQ"]) {
		$q=sql_query($D["GymNoGroupQ"]);
		if (sql_error()) $D["GymNoGroupQQe"]=sql_error();
		$D["GN"]=array();
		while ($GN=sql_fetch_assoc(	$q	)){
			array_unshift($D["ids_gym"], $GN["gameId"]);
			array_unshift($D["gyms"], 
			array(
			"title"=>$GN["title"],
			"gameId"=>$GN["gameId"],
			"status"=>$GN["status"],
			)
			);

			$D["GN"]["gameIds"][]=$GN["gameId"];
			$D["GN"][]=$GN;
		}// while
		if (sizeof($D["GN"])){
			$D["group_gym"][IDGROUPGHOST]=$D["GN"]["gameIds"];	
			$D["group_user"][IDGROUPGHOST]=array();
			
			array_unshift($D["groups"], 
				array(
				"name"=>L_games_without_group,
				"idgroup"=>IDGROUPGHOST,
				
				)
			);
			
			array_unshift($D["ids_group"], IDGROUPGHOST);			
			
		}
		$D["gyms"]=sortBySubValue($D["gyms"], "name");
	}
	
	////////////////////////////////////////
	return $D;
}	
	
?>