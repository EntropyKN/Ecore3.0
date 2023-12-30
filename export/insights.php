<?php
// export 

//error_reporting(E_ALL);ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');
if (PHP_SAPI == 'cli') die('This file should only be run from a Web Browser, questo file dovrebbe essere esguito da un web browser');

//echo $_SERVER['DOCUMENT_ROOT'];

include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");

include_once($_SERVER['DOCUMENT_ROOT']."/config/php.function.group.php");

$lang_trigger="usr";
include_once($_SERVER['DOCUMENT_ROOT']."/config/lang.inc.php");

if (!loggedIn()) die("false|-|you are not logged");


require_once($_SERVER['DOCUMENT_ROOT']."/_m/insights/insights.elaborate.php");
//echo "ciao";
//die("fin qui"); 

//$debug=true;

if (!sizeof($D["r"])) die ("Nessun risultato :-(");
$D["alfaStep"]=array();
if (!empty($D["r"])) foreach( $D["r"] as $k => $v ) {
    $D["r"][$k]["step"]=array();
    $qin="SELECT step, answerN, ascore  FROM `matches_step` WHERE `idm` =".$D["r"][$k]["idm"]." ORDER BY `matches_step`.`step` ASC";
    //$D["r"][$k]["Q"]=$qin;
	$stepsQ=sql_query($qin);
//	if (sql_error()) 	return sql_error();

	while (	$steps=sql_fetch_assoc($stepsQ)	){ 
        $D["r"][$k]["step"][]=$steps;   
    }
}

/*
$ch = "L";
for($s = 0; $s <= 19; $s++){
    ++$ch;
    $D["alfaStep"][$ch]=$D["r"][$k]["step"][$s]["answerN"];
    ++$ch;
    $D["alfaStep"][$ch]=$D["r"][$k]["step"][$s]["ascore"];
}
*/
/*foreach (range('M', 'AZ') as $c){
    $D["alfaStep"][$c]=$s;
    $s++;
}
*/

//if ($debug)  echo "<pre>";print_r($D);die;
//////////////////////////////////
require_once $_SERVER['DOCUMENT_ROOT'].'/_lib/PHPExcel/Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$S=$objPHPExcel->setActiveSheetIndex(0);
$S->setCellValue('A1',"Data/Ora");  
$S->setCellValue('B1',L_lastname);
$S->setCellValue('C1',L_firstname);
$S->setCellValue('D1',"Email");
//$S->setCellValue('D1',L_group);
$S->setCellValue('E1',L_gym);
//$S->setCellValue('F1',L_competence_target);
$S->setCellValue('F1',L_duration);
$S->setCellValue('G1',L_duration." (secs)");
$S->setCellValue('H1',"Esito");
$S->setCellValue('I1',"Score");
$S->setCellValue('J1',"ScorePercentDecimal");
$S->setCellValue('K1',"matchID");
$S->setCellValue('L1',"moodleUserId");

$ch1 = "L";

for($s = 0; $s <= 19; $s++){
    $row=1;
    ++$ch1;
    $S->setCellValue($ch1.'1',"S".($s+1)."-answerN");
    ++$ch1;
    $S->setCellValue($ch1.'1',"S".($s+1)."-score");

}


$w=20;
foreach (range('A', 'L') as $c){
	//$S->setCellValue('A'.$c,"Data/Ora"); 
	$S->getStyle($c.'1')->getFont()->setBold(true);
	$S->getStyle($c.'1')->getFont()->setName('Calibri')->setSize(11);
	$S->getColumnDimension($c)->setAutoSize(false);
	$S->getColumnDimension($c)->setWidth($w);		
}
//$S->getColumnDimension("K")->setWidth(60);	

$esitiArray=array(
"L1"=>"12,5%"
,"L2"=>"25%"
,"L3"=>"37,5%"
,"L4"=>"50%"
,"W1"=>"62.5%"
,"W2"=>"75%"
,"W3"=>"87,5%"
,"W4"=>"100%"
);



$row=2;
if (!empty($D["r"])) foreach( $D["r"] as $k => $v ) {
	$S->setCellValue('A'.$row,$v["from"]);
	$S->setCellValue('B'.$row,$v["last_name"]);
	$S->setCellValue('C'.$row,$v["first_name"]);
	$S->setCellValue('D'.$row,$v["email"]);
	$S->setCellValue('E'.$row,$v["title"]);
//	$S->setCellValue('F'.$row,$v["competence_target"]);
	$S->setCellValue('F'.$row,$v["duration"]);
	$S->setCellValue('G'.$row,$v["secs"]);
	//$S->setCellValue('H'.$row,$v["scoreInterval"]); // esito
    /*$esito="perdente";
        if ($v["final"]=="W1" || $v["final"]=="W2" || $v["final"]=="W3"|| $v["final"]=="W4") $esito="vincente";
    $S->setCellValue('H'.$row,$esito); // esito
    */
    $S->setCellValue('H'.$row,$esitiArray[     $v["final"]         ]); // esito
    
	$S->setCellValue('I'.$row,$v["final"]);	// score
    $S->setCellValue('J'.$row,$v["scorePercentDecimal"]);
	$S->setCellValue('K'.$row,SITE_URL_LOCATION."?/debrief/".$v["idm"]);	
    $S->setCellValue('L'.$row,$v["muser_id"]);
    
    $ch = "L";
    for($s = 0; $s <= 19; $s++){
        ++$ch;
        $D["alfaStep"][$ch]=$D["r"][$k]["step"][$s]["answerN"];
        $S->setCellValue($ch.$row,$D["r"][$k]["step"][$s]["answerN"]);
        ++$ch;
        $D["alfaStep"][$ch]=$D["r"][$k]["step"][$s]["ascore"];
        $S->setCellValue($ch.$row,$D["r"][$k]["step"][$s]["ascore"]);
    }
    
	$row++;
}




//////////////////////////////  Data/Ora	Cognome	Nome	Gruppo	Palestra	Obiettivo competenza	Durata	Punteggio Conseguito




/////////// out
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="group_report.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objPHPExcel->getActiveSheet()->setTitle('InsightsExport');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;





//setFormatCode
// FORMAT_DATE_DATETIME
?>