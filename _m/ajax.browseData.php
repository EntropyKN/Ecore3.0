<?php


//sleep(10);

include_once("../config/config.inc.php");
if (!loggedIn()) die("false|-|you are not logged");

$P=$_POST;
if (!$P["PAGE"]) die("false");

if (!$P["COMMAND"]) die("false");
$COMMANDA=explode("|", $P["COMMAND"]);

$P["CMD"]=$COMMANDA[0];





if ($P["CMD"]!="response" 
) die("false|-|no cmd");

$lang_trigger="usr";
require_once(C_ROOT."/config/lang.inc.php");




function responsesHtm($D) {
	global $typeFormsNames;
	require_once("../config/php.humantime.2.0.inc.php");
	$O="";
	for ($c = 0; $c < sizeof($D["d"]); $c++) {
		$A=$D["d"][$c];
		if (!$A["name"]) $A["name"]=L_anonymous;
		//$O.='<div class="L">';
			$O.='<a title="'.$typeFormsNames[$A["formType"]].'" class="responseLink" href="?/response/'.$A["landing_id"].'">';
				$O.='<img class="responseLinkimg" src="/img/ico/'.$A["formType"].'48.png" />';
				$O.="<span class=\"respTxt\"> ".$A["name"]."</span>";
				$O.="<span class=\"respPerc\">".$A["total_scorePercent"]."%</span>";
				$O.="<br /><span class=\"respTime\" title=\"".timestamp2red(	strtotime($A["submitted_at"])	,"verylong"	)."\">".ago(strtotime($A["submitted_at"]))."</span>";
				
			$O.='</a>';
		//$O.='</div>';
		
		$O.='<div class="clear"></div>';
	}
	if ($D["O"]["nexPageExist"]) $O.='<a class="showPage blueButt" id="showPage'.($D["s"]["page"]+1).'" data-command="response|all" href="#">'.L_msg_txt_continue.'</a>';
	
	return $O;
}




if ($P["CMD"]=="response") {
	$P["O"]="";
	$P["data"]=responsesData($P["PAGE"], $_POST["COMMAND"]) ;
	$P["O"]=responsesHtm($P["data"]);
	echo "true";
	echo "|-|";
	echo $P["O"];
	echo "|-|";	
	echo print_r($P["data"]);
	echo "|-|";	
	echo $P["page"];
	echo "|-|";	
	echo $P["COMMAND"];


	//print_r($P);
//	die();
}

?>