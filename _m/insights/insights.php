<?php
$JSA[]=''.C_DIR.'/_m/insights/insights.js?'.PAGE_RANDOM;

$JSA[]='/js/plugins/gloader.js'; //$JSA[]='https://www.gstatic.com/charts/loader.js?';
$CSSA[]=''.C_DIR.'/_m/insights/insights.css?2023';


$page["titlePre"]=L_insights." ";

$O.='<div id="mask" class="opacity50"></div>';
$O.='<div id="core" data-idtrans="'.$idtrans.'" data-tsaved="'.$tsaved.'">';
	require_once(C_ROOT."/_m/header/header.inc.php");

	$O.='<div id="coreIn">';
	if (empty($_SESSION["insights"]["groups"] )		&& $_SESSION["ulevel"]==0				 ) {
		$O.='<div style="font-size:21px;color:#888">';
		$O.=L_sorry;
		$O.=", ";
		$O.="<br />".L_actually_you_have_no_permission_to_access_this_area;
		$O.='</div>';	
	}else{
    
        
		require_once(C_ROOT."/_m/insights/01.menu.time.inc.php");
		require_once(C_ROOT."/_m/insights/02.gug.inc.php");
		//$O.="insights ";
	}
	
$O.='<div class="clear"></div>';
$O.='<div id="generate" class="button_action_blue noselect">'.L_generate.'</div>';
$O.='<div id="suggest" class=""></div>';

$O.='<div class="clear"></div>';
$O.='<div id="result" class=""></div>';
$O.='<div class="clear"></div>';
$O.='<div class="chart" id="chart1">Graphs1</div>';
$O.='<div class="clear"></div>';
$O.='<div class="chart" id="chart2">Graphs2</div>';
$O.='<div class="clear"></div>';
$O.='<div class="chart" id="chart3">Graphs3</div>';
$O.='<div class="clear"></div>';
$O.='<div class="chartSub" id="chartSub3">'.L_durations_are_expressed_in_minutes.'</div>';

    $O.='<pre>'.print_r($_SESSION,true).'</pre>';
		$O.='<pre>
		//// data
		'.print_r($D,true).'</pre>';
        
// debug
/*if (!$_COOKIE["debug"]) { 
		$O.='<div class="clear"></div>';
		//$O.='<pre>'.print_r($_SESSION,true).'</pre>';
		//$O.='<pre>'.print_r($COM,true).'</pre>';
		//$O.= "\$days $days,inMenuId $inMenuId, idcomStats $idcomStats";
		//$O.='<pre>'.print_r($DIRA,true).'</pre>';
		$O.='<pre>'.print_r($_SESSION,true).'</pre>';
		$O.='<pre>
		//// data
		'.print_r($D,true).'</pre>';	
}*/
// core coreIn
$O.='</div>';	
$O.='</div>';	
?>