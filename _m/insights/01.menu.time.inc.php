<?php
	require_once(C_ROOT."/_m/insights/global.inc.php");
$JSA[]=''.C_DIR.'/js/plugins/datepick/dp.js';
$JSA[]=''.C_DIR.'js/plugins/datepick/datepicker.it.js';
$CSSA[]=''.C_DIR.'js/plugins/datepick/datepicker.min.css';

	
	$timePar=explode("_",$DIRA[2]);
	if (!in_array($timePar[0],$timeParPresets)) {$timePar[0]="month";$timePar[1]="1";} //week
	
	//$O.=print_r($timePar,true);
//	$selected[$timePar[0]."_".$timePar[1]]=" selected=\"selected\" ";	
	$selected["year_0"]=" selected=\"selected\" ";
			
	$O.='<select data-cto="0" data-cfrom="0"  id="period" class="selectInsights" name="period'.PAGE_RANDOM.'">';
		//$O.='<option '.$selected["year_0"].'value="year_0">'.L_this_year.'</option>';
		$O.='<option '.$selected["week_0"].'value="week_0">'.L_this_week.'</option>';
		$O.='<option '.$selected["week_1"].'value="week_1">'.L_last_week.'</option>';
		$O.='<option '.$selected["week_2"].'value="week_2">2 '.L_NUMBER_weeks_ago.'</option>';
		$O.='<option '.$selected["week_3"].'value="week_3">3 '.L_NUMBER_weeks_ago.'</option>';		
		
		$O.='<option '.$selected["month_0"].'value="month_0">'.L_this_month.'</option>';
		$O.='<option '.$selected["month_1"].'value="month_1">'.L_last_month.'</option>';
		$O.='<option '.$selected["year_0"].'value="year_0">'.date('Y') .'</option>';
		$O.='<option '.$selected["year_1"].'value="year_1">'.(date('Y')-1) .'</option>';
		$O.='<option '.$selected["month_2"].'value="month_2">2 '.L_NUMBER_months_ago.'</option>';
		$O.='<option '.$selected["month_3"].'value="month_3">3 '.L_NUMBER_months_ago.'</option>';	
		$O.='<option '.$selected["custom_0"].'value="custom_0">'.L_custom_period.'</option>';
	$O.='</select>';

	/*
	$menuParPresets=array('views','interested','companies','ad',"notifications"); //'overview',
	if ($ULEV=="company") 	{
		$menuParPresets=array('views','interested','ad',"notifications");	
	}
	if ($existFidelity["exist"]) $menuParPresets[]="fidelity";	
	if (sizeof($PIOPROX)) $menuParPresets[]="pioprox";//$menuParPresets=array('views','interested','ad',"notifications", 'pioprox');
	
//			$menuParPresets=array('views','interested','ad',"notifications", 'pioprox');
	

	
	
	$menuParPresetsNames["overview"]=L_overview;
	$menuParPresetsNames["views"]=L_views;
	//if ($existFidelity["exist"]) 
	$menuParPresetsNames["fidelity_programs"]=L_fidelity_programs;
	$menuParPresetsNames["companies"]=L_companies;
	$menuParPresetsNames["interested"]=L_interested;
	$menuParPresetsNames["ad"]=L_single_ad;
	$menuParPresetsNames["notifications"]=L_notifications;
	$menuParPresetsNames["notifications"]=L_pioprox;
	
	$selectedS["overview"]="off";$selectedS["views"]="off";$selectedS["companies"]="off";$selectedS["pioprox"]="off";$selectedS["fidelity"]="off"; //$selectedS["month_1"]="off";$selectedS["custom_0"]="off";
	$inMenuId=$DIRA[4+1];
	if (!in_array($inMenuId,$menuParPresets)) $inMenuId="views";
	$selectedS[$inMenuId]="on";
	
	
	$idad=0;if ($inMenuId=="ad" && $DIRA[5+1] && is_numeric($DIRA[5+1])) $idad=$DIRA[5+1];

	//https://pioalert.com/cp/?/insights/0/week_0/views/0
	//https://pioalert.com/cp/?/insights/0/week_0/ad/118
	
	$O.='<div id="inMenu" data-idcomurl="'.$idcomurl.'" data-c="'.$inMenuId.'" data-idad="'.$idad.'">';
		//$O.='<a class="'.$selectedS["overview"].'" href="#" data-id="overview">'.L_overview.'</a>';
		$O.='<a class="'.$selectedS["views"].'" href="#" data-id="views">'.L_views.'</a>';
		$O.='<a class="'.$selectedS["interested"].'" href="#" data-id="interested">'.L_interested.'</a>';
		if ($ULEV!="company" && !$idcomurl) $O.='<a class="'.$selectedS["companies"].'" href="#" data-id="companies">'.L_companies.'</a>';
		$O.='<a class="'.$selectedS["notifications"].'" href="#" data-id="notifications">'.L_notifications.'</a>';
		if ($existFidelity["exist"]) $O.='<a class="'.$selectedS["fidelity"].'" href="#" data-id="fidelity">'.Fidelity.'</a>';
		if (sizeof($PIOPROX))  $O.='<a id="pioprox" class="'.$selectedS["pioprox"].'" href="#" data-id="pioprox" data-location="'.$firstPioProxLocation.'">'.L_pioprox.'</a>';		
		//$ULEV=="company" && 
	$O.="</div>";
	$O.='<div class="clear"></div>';
	*/
	### get times
	if ($timePar[0]!="custom") {
		if ($timePar[0]=="week") {
			$days=getWeekDays($timePar[1]);
			$tsFirst=$days[0]["ts"];
			$tsLast=$days[6]["ts"];
			$O.='<div id="dateShow">';
				$O.=L_from." ".L_monday." ".timestamp2red($tsFirst,'brief',LANG)." ".L_to." ".L_sunday." ".timestamp2red($tsLast,'brief',LANG);
			$O.="</div>";
		}
		if ($timePar[0]=="month") {
			$days=getMonthDays($timePar[1]);
			$tsFirst=$days[0]["ts"];
			$tsLast=$days[$days["days"]-1	]["ts"];
			unset ($days["days"]);
			$O.='<div id="dateShow">';
				$O.=L_from_DATE." ".timestamp2red($tsFirst,'brief',LANG)." ".L_to_DATE." ".timestamp2red($tsLast,'brief',LANG);
			$O.="</div>";
		}
		
		if ($timePar[0]=="year") {
			$tsFirst=strtotime('first day of January '.(date('Y')-$timePar[1]) );
			$tsLast=strtotime('last day of december '.(date('Y')-$timePar[1]) );
			$tsLast+=(24*60*60)-1;
			$O.='<div id="dateShow">';

			$O.="".L_from_DATE." ".timestamp2red($tsFirst,'brief',LANG)." ".L_to_DATE." ".timestamp2red($tsLast,'brief',LANG);
			$O.="</div>";
		}

	}else{
		//$O.=print_r($DIRA,true);
		if ($DIRA[6+1] && $DIRA[7+1]){
			$vfromG=trim($DIRA[6+1]);
			$vtoG=trim($DIRA[7+1]);
			$vfromIT=str_replace("-","/",$vfromG);$vtoIT=str_replace("-","/",$vtoG);
			
			$vfromA=explode("-", $vfromG);
			$vtoA=explode("-", $vtoG);
			
			$vfromDB=$vfromA[2]."-".$vfromA[1]."-".$vfromA[0];
			$vtoDB=$vtoA[2]."-".$vtoA[1]."-".$vtoA[0];	
			$vfromTS=dateDB2timestamp($vfromDB);
			$vtoTS=dateDB2timestamp($vtoDB);
			
			//$O.="  $vfromDB $vtoDB  $vfromTS $vtoTS ".timestamp2it($vfromTS)." ".timestamp2it($vtoTS) ." IT: $vfromIT $vtoIT";
			if ($vfromTS>$vtoTS) {
				$O.= "<div class=\"error show\">".L_the_end_data_should_be_greater_than_the_start_data."</div>";
				$vto="";$vfrom="";
			}else{
				$vto=$vtoG;$vfrom=$vfromG;
				//getDays($startDate, $endDate, $purpose=false)
				$daysRES=getDays($vfromIT, $vtoIT);
				$days=$daysRES["dayA"];	//$daysRES[daysN] => 30
				//$O.='**************<pre>'.print_r($days,true).'</pre>';		
			}
		}
	}
	

	## custom picker
//	if (!$vto)	 
	$vto=timestamp2it(time(), "-");
	//if (!$vfrom) 
	$vfrom=timestamp2it(time()-30*24*60*60, "-");
	
	$O.='<div class="clear"></div>';
	$O.='<div id="custom"'; 
	//if ($timePar[0]=="custom") $O.=' class="show"';
	//if ($timePar[0]!="custom") $O.=' class="hide"';
	$O.='>';
		$O.=L_from_DATE." ";
		//				$addClass=" class=\"datepicker-here\" data-autoClose='true' data-position=\"top left\"  data-language='it' readonly=\"readonly\" data-timepicker=\"true\" data-min-view=\"days\" data-view=\"days\" "; //air-datepicker data-min-date=\"0\"

		$O.='<input id="cfrom" name="cfrom'.PAGE_RANDOM.'" value="'.$vfrom.'" class="datepicker-here i1" data-autoClose="true" data-position="bottom left"  data-language="it" readonly="readonly" data-timepicker="false" data-min-view="days" data-view="days"  type="text" />';
		$O.=L_to_DATE;
		$O.='<input id="cto" name="cto'.PAGE_RANDOM.'" value="'.$vto.'" class="datepicker-here i1" data-autoClose="true" data-position="bottom left"  data-language="it" readonly="readonly" data-timepicker="false" data-min-view="days" data-view="days"  type="text" />';
		//$O.='<a href="#" id="customGo">'.L_ok."</a>";
	$O.="</div>";
	///////////////////////////////////////////////
//	require_once("menuCompany.inc.php");
	

	
	
?>