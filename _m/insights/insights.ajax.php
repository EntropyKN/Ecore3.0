<?php
ini_set("display_errors", "1");
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
if (!loggedIn()) die("false|-|you are not logged");
$finalS=array("L1", "L2", "L3", "L4", "W1", "W2", "W3", "W4");

define("L_L1", "0-12.5%");
define("L_L2", "25%");
define("L_L3", "37.5%");
define("L_L4", "50%");



define("L_W1", "62.5%");
define("L_W2", "75%");	
define("L_W3", "87.5%");	
define("L_W4", "100%");	

require_once("insights.elaborate.php");

// html
$O="";
/*$O.='<div class="title">Report:';
if (		sizeof(	$D["r"])) {
	$O.='<a class="excel" href="/export/insights.php?
cfrom='.$D["cfrom"].'
&cto='.$D["cto"].'
&ids_group='.$D["ids_group"].'
&ids_user='.$D["ids_user"].'
&ids_gym='.$D["ids_gym"].'" target="_blank">Download</a>';
}
$O.='</div>';
*/
if (!		sizeof(	$D["r"])) {
	
	$O.='<div class="insightBoxStright">';
	$O.=L_no_results."";
	$O.='</div>';
	
	die ("false|-|$O|-|0|-|0|-|0|-|NO_RES<br />".IDGROUPGHOST."--- ".print_r($D,true)); // IMPORTANT!
}




$O.='<div class="insightBoxStright">';
	$O.="<span>".L_matches.":</span> ".sizeof($D["r"]);
$O.='</div>';

$O.='<div class="insightBox">';
	$O.='<div class="insightBoxT">';
		$O.="<span>".L_unique_players.":</span> ".sizeof($D["uids"]);
	$O.='</div>';
	$O.='<div class="insightBoxC">';
		$O.='<table>';
			$O.='<tr class="H">';

			$O.='<td>';
			$O.="";
			$O.='</td>';
			$O.='<td>';
			$O.=L_matches;
			$O.='</td>';
			$O.='<td>';
			$O.=L_games;
			$O.='</td>';
			
			$O.='<td>';
			$O.='Win %';
			$O.='</td>';
			
			
			$O.='<td>';
			$O.="Played time";
			$O.='</td>';
			$O.='<td>';
			$O.="Match average";
			$O.='</td>';

			$O.='</tr>';		
		$x=0;
		if ($D["userReport"]) foreach( $D["userReport"] as $k => $v ) {
			$x++; if ($x>500) break;
			$O.='<tr>';

			$O.='<td class="n">';
				if (!$D["singleUser"]) $O.='<a href="#" class="callusr" id="uc_'.$k.'">';
				$O.=$v["name"];
				if (!$D["singleUser"]) $O.='</a>';
			$O.='</td>';
			$O.='<td>';
			$O.=sizeof($v["matches"]);
			$O.='</td>';
			$O.='<td>';
			$O.=sizeof(($v["gyms"]));
			$O.='</td>';
			$O.='<td title="'.$v["assertiveP"].'">';
				$O.=ceil($v["assertiveP"]*100)."%"; // per eccesso
			$O.='</td>';			
			
			$O.='<td>';
			$O.=getElapsedTimeStringSmart(($v["secs"]));
			$O.='</td>';
			$O.='<td>';
			$O.=getElapsedTimeStringSmart($v["secs"]/sizeof($v["matches"]));
			$O.='</td>';
			


			$O.='</tr>';
		}
		$O.='</table>';

	$O.='</div>';
$O.='</div>';
///////////////////////////////////////////////////////////////////// Gyms
$O.='<div class="insightBox">';
	$O.='<div class="insightBoxT">';
			$O.="<span>".L_games.":</span> ".sizeof($D["idgyms"]);
	$O.='</div>';
	$O.='<div class="insightBoxC">';

		$O.='<table>';
			$O.='<tr class="H">';

			$O.='<td>';
			$O.="";
			$O.='</td>';
			$O.='<td>';
			$O.=L_players;

			$O.='</td>';
			$O.='<td>';
			$O.=L_matches;
			$O.='</td>';
			
			$O.='<td>';
			$O.='Win %';
			$O.='</td>';		
			
			$O.='<td>';
			$O.="Played time";
			$O.='</td>';
			$O.='<td>';
			$O.="Match average";
			$O.='</td>';
			$O.='</tr>';		
		$x=0;
		if ($D["gymReport"]) foreach( $D["gymReport"] as $k => $v ) {
			$x++; if ($x>500) break;
			$O.='<tr>';

			$O.='<td class="n">';
			$O.=$v["name"];
			$O.='</td>';
			$O.='<td>';
			$O.=sizeof($v["users"]);
			$O.='</td>';
			$O.='<td>';
			$O.=sizeof(($v["matches"]));
			$O.='</td>';
			$O.='<td title="'.$v["assertiveP"].'">';
				$O.=ceil($v["assertiveP"]*100)."%"; // per eccesso
			$O.='</td>';			
			
			
			$O.='<td>';
			if ($_COOKIE["debugc"]) {
				
				$O.=$v["secs"];
				$O.=" *** ";
			}			
			
			
			$O.=getElapsedTimeStringSmart($v["secs"]);
			$O.='</td>';
			$O.='<td>';
			if ($_COOKIE["debugc"]) {
				
				$O.=$v["secs"];
				$O.="/".sizeof($v["matches"]);
				$O.="=".$v["secs"]/sizeof($v["matches"]);
				$O.=" *** ";
			}
			
			$O.=getElapsedTimeStringSmart($v["secs"]/sizeof($v["matches"]));
			$O.='</td>';
			$O.='</tr>';
		}
		$O.='</table>';

	$O.='</div>';
$O.='</div>';


################################ CHARTS 1
$chart1data=array(
/*	array("Palestra", "Utenti attivi", "vediamo"),
	array("Una idea innovativa", 5,18),
	array("Una trasferta difficile", 10,21),
	array("Altra traversa", 15,33),
	array("Una trasferta difficile", 10,21),
	array("Una trasferta difficile", 10,21),
	array("Una trasferta difficile", 10,21),
	array("Una trasferta difficile", 10,21),
	array("Una trasferta difficile", 10,21),
	array("Una trasferta difficile", 10,21),
	array("Una trasferta difficile", 10,21),
	array("Una trasferta difficile", 10,21),
	array("Una trasferta difficile", 10,21),	
	*/
);

$chart2data=array();
$chart3data=array();

if ($D["gymReport"]	&& sizeof(	$D["r"]) ) {
	//// 1
	if (!$D["singleUser"]) 	$chart1data[0]=array(L_games, L_unique_players, L_matches);
	else  							$chart1data[0]=array(L_games,  L_matches);
	
	foreach( $D["gymReport"] as $k => $v ) {
		if (!$v["assertive"]) $v["assertive"]=0;if (!$v["submissive"]) $v["submissive"]=0;if (!$v["aggressive"]) $v["aggressive"]=0;
		if (!$D["singleUser"]) 	
			$chart1data[]=array(
				$v["name"],
				$v["Nusers"],
				$v["Nmatches"],	
			);
		else
			$chart1data[]=array(
				$v["name"],
				$v["Nmatches"],	
			);

	}
	
	//// 2

	$chart2data[0]=array(L_games, L_L1, L_L2, L_L3, L_L4, L_W1, L_W2, L_W3, L_W4); // , "{role: 'annotation'}"

	foreach( $D["gymReport"] as $k => $v ) {
		//if (!$v["assertive"]) $v["assertive"]=0;if (!$v["submissive"]) $v["submissive"]=0;if (!$v["aggressive"]) $v["aggressive"]=0;
		foreach( $finalS as $FK => $FF ){
			if (!$v[$FF."P"])	
				$v[$FF."P"]=0;
		}		
		
		$chart2data[]=array(
			$v["name"],
			$v["L1P"],	
			$v["L2P"],	
			$v["L3P"],	
			$v["L4P"],	
			$v["W1P"],	
			$v["W2P"],	
			$v["W3P"],	
			$v["W4P"],	
		);
	}
	if (!$D["singleUser"]) 
		$chart3data[0]=array(L_games, "Total Time Played", "Average Time Per Match", "Average Time Per Player" ); // , "{role: 'annotation'}"
	else
		$chart3data[0]=array(L_games, "Total Time Played", "Average Time Per Match" ); // , "{role: 'annotation'}"
		
	foreach( $D["gymReport"] as $k => $v ) {
		if (!$D["singleUser"]) 
			$chart3data[]=array(
				$v["name"],
				round($v["secs"]/60),
				round($v["secs"]/$v["Nmatches"]/60),
				round($v["secs"]/$v["Nusers"]/60),
			);
		else
			$chart3data[]=array(
				$v["name"],
				round($v["secs"]/60),
				round($v["secs"]/$v["Nmatches"]/60),
			);
	}	
	
}

$D["chart1data"]=$chart1data;
$D["chart2data"]=$chart2data;
$D["chart3data"]=$chart3data;




##################### OUTPUT


echo "true|-|$O|-|"
//.sizeof($D["r"])."|-|" // n matches
//.sizeof($D["uids"])."|-|" // n unique users
//.sizeof($D["idgyms"])."|-|"; // n unique gym
;

//echo '[["A","B"],["palestra A",10],["palestra C",20],["palestra A",30],["palestra A",40],["palestra A",10],["palestra A",50]]|-|';
//// 1
if (!empty($chart1data)) 
	echo json_encode($chart1data);
else
	echo '0';
	
echo "|-|";

///// 2
if (!empty($chart2data)) 
	echo json_encode($chart2data);
else
	echo '0';
	
echo "|-|";
///// 3
if (!empty($chart3data)) 
	echo json_encode($chart3data);
else
	echo '0';
echo "|-|";

//unset ($D["r"]);
echo "<pre>";
print_r($D);
echo "</pre>";

/// period:$("period").val(), cfrom: $("#period").attr("data-cfrom"),cto: $("#period").attr("data-cto")


?>