<?php



function ago($timestamp, $always_hours_minutes=true, $month_brief=false, $debug=false){
	return trim(ago_simplified($timestamp, $always_hours_minutes, $month_brief, $debug));
}

function ago_simplified($timestamp, $always_hours_minutes=true, $month_brief=false, $debug=false){
	if (!$timestamp) return false;
	
	/*if($always_hours_minutes){
		return "SI always_hours_minutes";
	}else{
			return "no always_hours_minutes";
	}
	*/
					$daysoftheweek[0]=Lsunday;
					$daysoftheweek[1]=L_monday;
					$daysoftheweek[2]=L_tuesday;
					$daysoftheweek[3]=L_wednesday;
					$daysoftheweek[4]=L_thursday;
					$daysoftheweek[5]=L_friday;
					$daysoftheweek[6]=L_saturday;	
					if (!$month_brief) {		
						$month[1]=L_month_january;
						$month[2]=L_month_february;
						$month[3]=L_month_march;
						$month[4]=L_month_april;
						$month[5]=L_month_may;
						$month[6]=L_month_june;
						$month[7]=L_month_july;
						$month[8]=L_month_august;
						$month[9]=L_month_september;
						$month[10]=L_month_october;
						$month[11]=L_month_november;
						$month[12]=L_month_december;
					}else{
						$month[1]=L_month_january;
						$month[2]=L_month_february;
						$month[3]=L_month_march;
						$month[4]=L_month_april;
						$month[5]=L_month_may;
						$month[6]=L_month_june;
						$month[7]=L_month_july;
						$month[8]=L_month_august;
						$month[9]=L_month_september;
						$month[10]=L_month_october;
						$month[11]=L_month_november;
						$month[12]=L_month_december;
					}

	$toTime=C_TIME;
	$showLessThanAMinute = true;
	$distanceInSeconds_alg = round(($toTime - $timestamp));
    $distanceInSeconds = abs($distanceInSeconds_alg);//abs
	$future=false;
	if ($distanceInSeconds_alg<0) {
		$future=true;
	}
    $distanceInMinutes = round($distanceInSeconds / 60);
	$distanceInhours = round($distanceInMinutes / 60);
	$distanceInDays = round($distanceInhours / 24);
	$distanceInMonths= round($distanceInDays / 30);
	$distanceInYears= round($distanceInMonths / 12);
	
	$date_visibile_simple=date("d/m/y",$timestamp);
	$date_visibile_simple_today=date("d/m/y");

	$add.="";

	if ($always_hours_minutes) $hours_minutes=" ".date("H:i",$timestamp);

	$future=false;
	if ($distanceInSeconds_alg<0) $future=true;
	if ($debug){
		$add.=" * ".$date_visibile_simple;	
		$add.=" * days".$distanceInDays;
		$add.=" * H".$distanceInhours;
		$add.=" * M".$distanceInMinutes;
		
		
		$add.=" fut $future ";
	}
	// minutes
	/*if 	(!$future && 	$distanceInMinutes<=15	 	)		return C_a_short_time_ago.$hours_minutes;//." *".(C_TIME-$timestamp)."* ".$add;
	if 	($future && 	$distanceInMinutes<=15 	)		{
		return L_TIME_in." ".$distanceInMinutes." ".L_minutes.$add;
	}
	*/
	if 	(!$future && 	$distanceInSeconds<=1	 	)  return L_now;
	if 	(!$future && 	$distanceInSeconds<=59	 	)		return $distanceInSeconds." ".L_seconds." ".L_TIME_ago_post; //return L_now;//." *".(C_TIME-$timestamp)."* ".$add;
	if 	($future && 	$distanceInSeconds<=59 	)		{
		return L_TIME_in." ".$distanceInSeconds." ".L_seconds.$add;
	}			
	
	if 	(!$future && 	$distanceInMinutes==1 	)		{
		return L_a_minute_ago.$add;
	}	

	if 	($future && 	$distanceInMinutes==1	 	)		return L_in_a_minute;//." *".(C_TIME-$timestamp)."* ".$add;	
	if 	(!$future && 	$distanceInMinutes<=59	 	)		return $distanceInMinutes." ".L_minutes." ".L_TIME_ago_post;//." *".(C_TIME-$timestamp)."* ".$add;
	if 	($future && 	$distanceInMinutes<=59 	)		{
		return L_TIME_in." ".$distanceInMinutes." ".L_minutes.$add;
	}	
	
	// hours
//	if ($future && $distanceInhours==1) return L_TIME_in." ".$distanceInhours." ".L_hour.$add;
	if ($future && $distanceInhours==1) return L_TIME_in." ".$distanceInMinutes." ".L_minutes.$add;
	if (!$future && $distanceInhours<=1) return L_TIME_ago_pre." ".$distanceInMinutes." ".L_minutes." ".L_TIME_ago_post.$add;	
	//if (!$future && $distanceInhours<=1) return L_TIME_ago_pre." ".$distanceInhours." ".L_hour." ".L_TIME_ago_post.$add;
		
	if ($future && $distanceInhours<=24) return L_TIME_in." ".$distanceInhours." ".L_hours.$add;
	if (!$future && $distanceInhours<=24) return L_TIME_ago_pre." ".$distanceInhours." ".L_hours." ".L_TIME_ago_post.$add;
	// days
	
	if (!$future && $distanceInDays<=1 ) {
		$ret=L_yesterday;
		if($always_hours_minutes)  $ret.=" ".L_TIME_at." ".date("H:i",$timestamp)." ".$add; //today
		return $ret;
		
	}
	if ($future && $distanceInDays<=1 ) {
		$ret=L_tomorrow;
		if($always_hours_minutes)  $ret.=" ".L_TIME_at." ".date("H:i",$timestamp)." ".$add; //today
		return $ret;		
	}
	
	if (!$future && $distanceInDays==7) return L_about_a_week_ago.$add;
		
	if ($future && $distanceInDays<=40) return L_TIME_in." ".$distanceInDays." ".L_days.$add;
	if (!$future && $distanceInDays<=40) return L_TIME_ago_pre." ".$distanceInDays." ".L_days." ".L_TIME_ago_post.$add;	
	
	// months
	if (!$future && $distanceInMonths<=1) return L_a_months_ago.$add;
	if ($future && $distanceInMonths<=1) return L_in_a_months.$add;
	
	if ($future && $distanceInMonths<=11) return L_TIME_in." ".$distanceInMonths." ".L_months.$add;
	if (!$future && $distanceInMonths<=11) return L_TIME_ago_pre." ".$distanceInMonths." ".L_months." ".L_TIME_ago_post.$add;	

	if (!$future && $distanceInYears==1) return L_a_year_ago;
	if ($future && $distanceInYears==1) return L_in_a_year;


    if ($future && $distanceInYears) return L_TIME_in." ".$distanceInYears." ".L_years.$add;
	if (!$future && $distanceInYears) return L_TIME_ago_pre." ".$distanceInYears." ".L_years." ".L_TIME_ago_post.$add;


	
/*
	
	if 	(	C_TIME-$timestamp<15*60*1	 && 	$distanceInDays<1)						
	return C_a_short_time_ago.$hours_minutes." *".(C_TIME-$timestamp)."* ".$add;
	
	if ($date_visibile_simple==$date_visibile_simple_today) 		{
		if (!$always_hours_minutes) return C_today.$hours_minutes;
		else return C_today_at.$hours_minutes.$add;
	}
	
	if ($distanceInhours<25) return L_TIME_in." ".$distanceInhours." ".L_hours.$add;
	
	if ($distanceInDays<21) return L_TIME_in." ".$distanceInDays." ".L_days.$add;
	
	
	
	if (
	//$distanceInDays<1 &&
	( $distanceInMinutes < 1440 )&&		(date ("w", $timestamp)!=date ("w", $timestamp+$distanceInSeconds)	) 
	)
		return C_yesterday.$hours_minutes.$add;
	*/
	if (	date("y",$timestamp)==date("y"))	
		return date("j",$timestamp)." ".$month[date("n",$timestamp)].$hours_minutes.$add;
	
	
	$last= date("j",$timestamp)." ".$month[date("n",$timestamp)];
	if (	date("Y",C_TIME)==date("Y",$timestamp)		)	{
		$last.=" "; //scorso
	}else{
		$last.=" ".	date("Y",$timestamp);
	}

	
	return $last.$add;
}

/*$day=60*60*24;


$time=C_TIME;
echo ago_simplified($time);

echo "<br>";
$time=C_TIME-(1*5*60*60);
echo ago_simplified($time);

echo "<br>";
$time=C_TIME-(1*18*60*60);
echo ago_simplified($time);

echo "<br>";
$time=C_TIME-(1*$day);
echo ago_simplified($time);

echo "<br>";
$time=C_TIME-(2*$day);
echo ago_simplified($time);

echo "<br>";
$time=C_TIME-(40*$day);
echo ago_simplified($time);

echo "<br>";
$time=C_TIME-(260*$day);
echo ago_simplified($time);
*/
?>