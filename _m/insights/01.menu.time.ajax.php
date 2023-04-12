<?php
ini_set("display_errors", "1");
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
if (!loggedIn()) die("false|-|you are not logged");
$D=$_POST; // debug
require_once($_SERVER['DOCUMENT_ROOT']."/_m/insights/global.inc.php");
$lang_trigger="usr";require_once($_SERVER['DOCUMENT_ROOT']."/config/lang.inc.php");

$timePar=explode("_",$D["period"]);
$O="";
if (!in_array($timePar[0],$timeParPresets)) {
	$timePar[0]="year";$timePar[1]="0";
}
if ($timePar[0]!="custom") {
	if ($timePar[0]=="week") {
		$days=getWeekDays($timePar[1]);
		$tsFirst=$days[0]["ts"];
		$tsLast=$days[6]["ts"];
		//$O.='<div id="dateShow">';
			$O.=L_from." ".L_monday." ".timestamp2red($tsFirst,'brief',LANG)." ".L_to." ".L_sunday." ".timestamp2red($tsLast,'brief',LANG);
		//$O.="</div>";
	}
	if ($timePar[0]=="month") {
		$days=getMonthDays($timePar[1]);
		$tsFirst=$days[0]["ts"];
		$tsLast=$days[$days["days"]-1	]["ts"];
		unset ($days["days"]);
		//$O.='<div id="dateShow">';
			$O.=L_from_DATE." ".timestamp2red($tsFirst,'brief',LANG)." ".L_to_DATE." ".timestamp2red($tsLast,'brief',LANG);
		//$O.="</div>";
	}
		if ($timePar[0]=="year") {
			$tsFirst=strtotime('first day of January '.(date('Y')-$timePar[1]) );
			$tsLast=strtotime('last day of december '.(date('Y')-$timePar[1]) );
			$tsLast+=(24*60*60)-1;
			$O.="".L_from_DATE." ".timestamp2red($tsFirst,'brief',LANG)." ".L_to_DATE." ".timestamp2red($tsLast,'brief',LANG);

		}
}else{
	//
}
if (LANG=="it") {
	if ($tsFirst) $tsIT=timestamp2it($tsFirst, 'longNoTime');
	if ($tsLast) $tsLastIT=timestamp2it($tsLast, 'longNoTime');
}else{
	if ($tsFirst) $tsIT=timestamp2it($tsFirst, 'longNoTime');
	if ($tsLast) $tsLastIT=timestamp2it($tsLast, 'longNoTime');	
}
echo "true|-|$O|-|$tsFirst|-|$tsLast|-|$tsIT|-|$tsLastIT|-|"
.print_r($D, true)
. "|-|".print_r($timePar, true);

?>