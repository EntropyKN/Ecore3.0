<?php // ELSE->Ecore
ini_set("display_errors", "1");
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
if ($_SESSION["ulevel"]<1) {
	$D["response"]=false;
	$D["reason"]="mm sounds like you're not logged at the moment";
	echo json_encode($D);
	return;		
}
$lang_trigger="edt";
require_once(C_ROOT."/config/lang.inc.php");


$D=$_POST;
if ($_GET) {
	$D=$_GET;
}
$D=array_map("trim",$D);


if (!$D["gameId"]  || !is_numeric($D["gameId"])  )  die("false|-|data errors...".print_r($D,true));
$gameId=$D["gameId"];


///////////////////////////////////////////////////////


function gameIntervalCalc2($gameId){
	$str="SELECT answersType, step, scene,
    img_1, img_2, img_3, img_4, 
    altImg_1, altImg_2, altImg_3, altImg_4, 
	answer_1, answer_2, answer_3, answer_4, 
	ascore_1,ascore_2,ascore_3, ascore_4, goto1, goto2, goto3, goto4 FROM games_steps WHERE gameId =$gameId and type IS NULL order by step ASC";
	$Q=sql_query($str);
	$D=array(
	"LANG"=>LANG,
	"response"=>1,
	"reason"=>"",
	"max"=>0,
	"min"=>0,
	"report"=>"",
	"game"=>sql_queryt("SELECT structure, forkFrom from games where gameId=$gameId"),
	/*"maxesL"=>array(),//lineari
	"maxesA"=>array(),
	"maxesB"=>array(),
	//"MAX_L"=>0,	
	"MAX_A"=>0,	
	"MAX_B"=>0,	
	"MAX_C"=>0,
	"MAX_D"=>0,*/
	"MAX"=>0,	
	//"session"=>$_SESSION,
	);

	if (sql_error()) return sql_error();
	$Z=0;
	while (	$S=sql_assoc($Q)	){
		$S=array_map("trim", $S);
        ////////////////////
        //$D["response"]=0;$D["reason"]=$S["answersType"];return $D;
		$S["questNumb"]=3;if ($S["goto4"]) $S["questNumb"]=4;
        if ($S["answer_1"] =="0") $S["answer_1"]="zero";
        if ($S["answer_2"] =="0") $S["answer_2"]="zero";
        if ($S["answer_3"] =="0") $S["answer_3"]="zero";
        if ($S["answer_4"] =="0") $S["answer_4"]="zero";

		// TESTO DOMANDE
        if ($S["answersType"]=="txt") { 
            if ($S["questNumb"]==3) {
                if (	!$S["answer_1"] || !$S["answer_2"] || !$S["answer_3"]  ){
                    $D["response"]=0;
                    $D["reason"]=L_step." ".$S["step"]."".$S["scene"].": ".L_missing_one_or_more_answers; //L_the_first_three_answers_are_mandatory
                    return $D;
                }
                if (!$S["answer_3"]	 && $S["answer_4"]			){	// c'e' la quattro ma non la tre
                    $D["response"]=0;
                    $D["reason"]=L_step." ".$S["step"]."".$S["scene"].": ".L_you_cannot_use_question_4_without_using_question_3; // cannot use question 4 without use question 3
                    return $D;	
                }
            }else{
            // 4 possibili risposte
                if (	!$S["answer_1"] || !$S["answer_2"] || !$S["answer_3"] || !$S["answer_3"]  ){
                    $D["response"]=0;
                    $D["reason"]=L_step." ".$S["step"]."".$S["scene"].": ".L_missing_one_or_more_answers; //
                    return $D;
                }	
            } //if ($S["questNumb"]==3) {
        }
       // $D["response"]=0;$D["reason"]=$S["answersType"];return $D;
		// FINE TESTO DOMANDE
		if ($S["answersType"]=="img") { 
            if ($S["questNumb"]==3) {
                if (	!$S["img_1"] || !$S["img_2"] || !$S["img_3"]  ){
                    $D["response"]=0;
                    $D["reason"]=L_step." ".$S["step"]."".$S["scene"].": ".L_missing_one_or_more_image_answers." - A ".$S["questNumb"]; //L_the_first_three_answers_are_mandatory
                    return $D;
                }
                if (!$S["img_3"]	 && $S["img_4"]			){	// c'e' la quattro ma non la tre
                    $D["response"]=0;
                    $D["reason"]=L_step." ".$S["step"]."".$S["scene"].": ".L_you_cannot_use_question_4_without_using_question_3; // cannot use question 4 without use question 3
                    return $D;	
                }
            }else{
            // 4 possibili risposte
                if (	!$S["img_1"] || !$S["img_2"] || !$S["img_3"] || !$S["img_4"]  ){
                    $D["response"]=0;
                    $D["reason"]=L_step." ".$S["step"]."".$S["scene"].": ".L_missing_one_or_more_image_answers." - B ".$S["questNumb"];  //
                    return $D;
                }	
            } //if ($S["questNumb"]==3) {
        
        }
        
        
		
		// PUNTEGGI almeno uno zero
		$S["scoresA"]=array();
		for ($p = 1; $p <=4; $p++) {
			if (is_numeric($S["ascore_".$p]) ) $S["scoresA"][]=$S["ascore_".$p];
		}
		$S["MINSCORE"]=@min($S["scoresA"]);
		unset ($S["scoresA"]);
		if (	$S["MINSCORE"]>0  ){
			$D["response"]=0;
			$D["reason"]=L_step." ".$S["step"]."".$S["scene"].": ".L_at_least_one_score_must_be_zero; //
			return $D;
		}
		
		// PUNTEGGI non settati
		if ($S["questNumb"]==3) {
			if (	$S["ascore_1"]==NULL || $S["ascore_2"]==NULL || $S["ascore_3"]==NULL ) {
				$D["response"]=0;
				$D["reason"]=L_step." ".$S["step"]."".$S["scene"].": ".L_the_score_of_one_or_more_answers_is_missing; //
				return $D;				
				
			}
				
		}else{
			if (	$S["ascore_1"]==NULL || $S["ascore_2"]==NULL || $S["ascore_3"]==NULL|| $S["ascore_4"]==NULL ) {
				$D["response"]=0;
				$D["reason"]=L_step." ".$S["step"]."".$S["scene"].": ".L_the_score_of_one_or_more_answers_is_missing.""; //
				return $D;				
				
			}			
		}

		# nessuna precedente conduce all'attuale NON FUNZIONA PERCHE' N-1 non serve
		if ($S["step"]>1) {
			//$S["check"]="1";
			$S["someBeforeLeadToThis"]=false;
			$S["indexStepBeforeGoto"]=array();
			$S["index-1"]=$S["step"]-1 ;
			for ($i = 0; $i <= $Z; $i++) {
				//$S["tutti"][]=$i;
				if ($D["d"][($i)]["step"]==$S["step"]-1 )		{
					$S["indexStepBefore"][]=$i;
					$PRE=$D["d"][$i];
					$S["indexStepBeforeGoto"][]=$PRE["goto1"];
					$S["indexStepBeforeGoto"][]=$PRE["goto2"];
					$S["indexStepBeforeGoto"][]=$PRE["goto3"];
					$S["indexStepBeforeGoto"][]=$PRE["goto4"];
					$S["leadToThis"]=array ($PRE["goto1"],$PRE["goto2"],$PRE["goto3"],$PRE["goto4"]);
					
					if (in_array($S["scene"],  $S["leadToThis"])) {
						$S["someBeforeLeadToThis"]=true;
						break;
					} 
						//array ($PRE["goto1"],$PRE["goto2"],$PRE["goto3"],$PRE["goto4"]);
				//}else{$S["scartati"][]=$i;	
				}
				
			}
			$S["indexStepBeforeGoto"]=array_filter($S["indexStepBeforeGoto"]);
			
			if (!$S["someBeforeLeadToThis"]){
				$D["response"]=0;
				$D["reason"]=L_step." ".$S["step"]."".$S["scene"].": ".L_no_answer_leads_to_this_scene."";
				$D["d"][]=$S;
				return $D;				
			}
		
		}
		
	
		
		//$S["max"]=max($S["values"]);
		///////////////////
		
		$D["d"][]=$S;
		$Z++;
		
		//unset ($S["answer_1"],$S["answer_2"],$S["answer_3"],$S["answer_4"]);
		

		
	}
	///////////////////////////////// endwhile
	
	
	
	
	// verifica score not null  
	if ($D["response"]	&& $D["d"]) {
	 foreach($D["d"] as $K => $V){
		for ($s = 1; $s<=$V["questNumb"]; $s++) {				
			if (!is_numeric($V["ascore_".$s])) {

				$D["response"]=0;
				$D["reason"]=L_missing.": ".L_step." ".$V["step"]."  ".$V["scene"]." ".L_questions_score." ".$s;
				return $D;
			}else{
				$D["d"][$K]["values"][]=$V["ascore_".$s];
			}
		}		 
	  } //each
	  
	 }else{
		 return $D;
	 }

	// max
/*	foreach($D["d"] as $K => $V){ OLD
		if (isHomogenous($V["values"] )){
			$D["response"]=0;
			$D["reason"]=L_step." ".$V["step"]."".$V["scene"]." ".L_answers_have_the_same_score	;	//
			return $D;	
		}

		
		$D["d"][$K]["max"]=max($V["values"]);

		$stepPrintHere="";
		//$stepPrintHere.=" ".$D["d"][$K]["step"]." ".$D["d"][$K]["scene"];
		if ($D["game"]["s t r u c t u re"]=="linear") {
			$D["maxesA"][]=$D["d"][$K]["max"].$stepPrintHere;
		}else{
			if ($D["d"][$K]["step"]<=$D["game"]["forkFrom"])  {	
				$D["maxesL"][]=$D["d"][$K]["max"].$stepPrintHere;
				$D["maxesA"][]=$D["d"][$K]["max"].$stepPrintHere;
				$D["maxesB"][]=$D["d"][$K]["max"].$stepPrintHere;			
				
			}else{
				if ($D["d"][$K]["scene"]=="A") $D["maxesA"][]=$D["d"][$K]["max"].$stepPrintHere;
				if ($D["d"][$K]["scene"]=="B") $D["maxesB"][]=$D["d"][$K]["max"].$stepPrintHere;
			}
		}
		
	} //foreach
	*/
	$D["MAXarr"]=array();
	foreach($D["d"] as $K => $V){
		$D["MAXarr"]["explict"][$V["step"]][$V["scene"]]		=max($V["values"]);
	} //foreach
	
	foreach($D["MAXarr"]["explict"] as $step => $V){
		$D["MAXarr"]["step"][$step]		=max($D["MAXarr"]["explict"][$step]);
	} //foreach
	
	
	$D["min"]=0;	
	$D["MAX"]=array_sum($D["MAXarr"]["step"]);
	
/*		INTERVALLI


										50%
				losing area			 |			winning area
										 |
		|_L4_|_L3_|_L2_|_L1_||_W1_|_W2_|_W3_|_W4_|
		
		
*/	
	$pass=100/8;
	$D["Ip"]=array(
	0,1*$pass,		2*$pass,	3*$pass,		4*$pass
	,	5*$pass,	6*$pass,	7*$pass,	8*$pass	
	);

//	$D["minMaxDiff"]=$D["max"]-$D["min"];
//	$D["minMaxDiff"]=$D["max"]-$D["min"];
	
	foreach($D["Ip"] as $K => $P){
		$D["I"][$K]=euroFormatDot($D["MAX"]*$P/100);
		$D["I"][$K]=euroFormatDot($D["I"][$K]); //euroFormatDot
	}
	

	$D["s"]=array(
		"L1"=>array("spreadLP"=>	$D["Ip"][0],"spreadRP"=>$D["Ip"][1], "spreadL"=>0,"spreadR"=>$D["I"][1]	),
		"L2"=>array("spreadLP"=>	$D["Ip"][1],"spreadRP"=>$D["Ip"][2],"spreadL"=>$D["I"][1],"spreadR"=>$D["I"][2]	),		
		"L3"=>array("spreadLP"=>	$D["Ip"][2],"spreadRP"=>$D["Ip"][3],"spreadL"=>$D["I"][2],"spreadR"=>$D["I"][3]		),
		"L4"=>array("spreadLP"=>	$D["Ip"][3],"spreadRP"=>$D["Ip"][4],"spreadL"=>$D["I"][3],"spreadR"=>$D["I"][4]),
		
		"W1"=>array("spreadLP"=>	$D["Ip"][4],"spreadRP"=>$D["Ip"][5],"spreadL"=>$D["I"][4],"spreadR"=>$D["I"][5]),
		
		"W2"=>array("spreadLP"=>	$D["Ip"][5],"spreadRP"=>$D["Ip"][6],"spreadL"=>$D["I"][5],"spreadR"=>$D["I"][6]),
		"W3"=>array("spreadLP"=>	$D["Ip"][6],"spreadRP"=>$D["Ip"][7],"spreadL"=>$D["I"][6],"spreadR"=>$D["I"][7]),
		"W4"=>array("spreadLP"=>	$D["Ip"][7],"spreadRP"=>$D["Ip"][8],"spreadL"=>$D["I"][7],"spreadR"=>$D["I"][8]),
	);
// INSERT INTO `games_spread` (`gameId`, `spread`
//		, `spreadLP`, `spreadRP`, `spreadL`, `spreadR`) VALUES 
	$D["q"]=" INSERT INTO `games_spread` 
	(`gameId`, `spread`,`spreadLP`, `spreadRP`, `spreadL`, `spreadR`) VALUES 
	 ";
	foreach($D["s"] as $K => $SS){
		$D["q"].="( $gameId, '".$K."','".$SS["spreadLP"]."','".$SS["spreadRP"]."','".$SS["spreadL"]."','".$SS["spreadR"]."' ),
";
	}
	$D["q"]=trim($D["q"],",\n" );
	sql_query("DELETE FROM games_spread WHERE gameId=$gameId");
	sql_query($D["q"]);
	$D["e"]=sql_error();	
	return $D;	
}





/////////////////////////////////////////////////////////////////
$D["s"]=gameIntervalCalc2($gameId);
$R=$D["s"];

if ($R["response"]){
	echo "true|-|";
	echo json_encode($R["s"]);
}else{
	echo "false|-|".$R["reason"];
}

echo "|-|<br /> ";
	echo "<pre>";
print_r($D);
?>