<?php

include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
error_reporting(E_ALL ^ E_NOTICE);ini_set("display_errors",1);
error_reporting(E_ALL);

if (!loggedIn()) die("false|-|you are not logged");
include_once($_SERVER['DOCUMENT_ROOT']."/config/php.function.games.php");
//$G=$_POST["data"];            https://to.sgameup.com/_m/player04/finalCalcF.php
echo "<pre> finalCalcTEST
";
print_r($_SESSION);

print_r(finalCalcTEST(312,false)); //129 b  



function finalCalcTEST($idMatch, $update=false){
	$d["score"]=0;

	$d["scorePercent"]="0";

	$d["spread"]=array();
	
	$d["match"]=sql_queryt("SELECT idm, gameId, start, end FROM matches WHERE idm=$idMatch");	
	$d["gameId"]=$d["match"]["gameId"]; //unset($d["game"]);
	
	$d["match"]["startH"]=timestamp2it($d["match"]["start"]);
	if ($d["match"]["end"]) $d["match"]["endH"]=timestamp2it($d["match"]["end"]);
	
	if (!$d["gameId"]) return $d;
	//if ($d["gameId"] && !$update) {
    $d["game"]=sql_queryt("SELECT G.title, G.Description,G.status, G.dontShowDebriefScore, G.cover, G.winningPercStart FROM games G WHERE G.gameId=".$d["gameId"]);
	if (!$d["game"]["winningPercStart"]) $d["game"]["winningPercStart"]=50.00;
	
	
	$d["score"]=0;
    $d["avatarsIds"]=array();
	// load questions and answers
	$d["q1"]="SELECT 
		step, scene, scenario_id, avatar_id, avatar_sentence, answer_1,answer_2, answer_3, answer_4, avatar_audio
		, ascore_1,ascore_2, ascore_3, ascore_4,
        arrowPos, arrowY,
        avatar_size ,avatar_pos ,balloon_pos, feedback_1, feedback_2,feedback_3 , feedback_1_audio,feedback_2_audio,feedback_3_audio, audioAnwers 
	 FROM games_steps WHERE gameId=".$d["gameId"]." ORDER BY step ASC, scene ASC ";
	$qS=sql_query($d["q1"]);
	if (sql_error()) 	return sql_error();
	$ii=0;
    $d["totaleNumeroDiStep"]=0;
	while (	$ST=sql_fetch_assoc($qS)	){
		/*$ST["max"]=0;$ST["min"]=NULL;
		for ($i=1; $i<=4; $i++) {
			if ($ST["answer_".$i]	&& $ST["ascore_".$i]>$ST["max"]		) 	$ST["max"]=$ST["ascore_".$i];
			
			
			if (
			($ST["answer_".$i]	 && is_numeric($ST["ascore_".$i])	 && $ST["ascore_".$i]<$ST["min"]		)
			|| is_null($ST["min"])
			) 		$ST["min"]=$ST["ascore_".$i];
		}
		
		
		$ST["delta"]=($ST["max"]-$ST["min"]);
		//unset ($ST["max"], $ST["min"]);
		*/
		$ST["maxScore"]=max(
			$ST["ascore_1"],
			$ST["ascore_2"],
			$ST["ascore_3"],
			$ST["ascore_4"]
		);
		if (!$ST["maxScore"]) $ST["maxScore"]=0;
		$d["G"][$ST["scene"].$ST["step"]		]=$ST;
		$d["maxScores"][]=$ST["maxScore"];
        $d["massimiStep"][$ST["step"]][]=$ST["maxScore"];
        
		$d["totaleNumeroDiStep"]=$ST["step"];
		$ii++;
	}
    $d["totaleNumeroDiStep"]=$d["totaleNumeroDiStep"]-2;
    
    for ($i=1; $i<=$d["totaleNumeroDiStep"]; $i++) {
        $d["massimoPerStep"][$i]=max($d["massimiStep"][$i]);
    }
    unset ($d["massimiStep"]);
    // spread ALL
    $d["spreadQA"]="SELECT * FROM games_spread WHERE gameId=".$d["gameId"]." ORDER BY spreadR DESC ";
    $QAS=sql_query($d["spreadQA"]);
    $spi=0;
    while (	$SP=sql_fetch_assoc($QAS)	){
        unset ($SP["gameId"]); 
        $d["spreadAll"][$spi]=$SP;
        $spi++;
    }

    unset (
    //$d["spreadAll"],
    $d["spreadQ"]
    );
		


	$d["maxScorePossible"]= $d["spreadAll"][0]["spreadR"];  //array_sum($d["maxScores"]) ; // SBAGLIATO
    $d["maxScorePossibleAveragePerStep"]=$d["maxScorePossible"];
    
	/// match
	$d["q"]="SELECT * FROM matches_step WHERE idm=$idMatch ORDER BY id ASC ";

	$qS=sql_query($d["q"]);
	if (sql_error()) 	return sql_error();
	$Stt=0;
	while (	$ST=sql_fetch_assoc($qS)	){
        unset ($ST["ts"]);
		$sceneStep=$ST["scene"].$ST["step"];
		//if ($Stt==2) 
		$ST["score"]=$d["G"][	$sceneStep	]["ascore_".$ST["answerN"]];
        
		
       // $ST["scorePercent"]=euroFormatDot($ST["score"]/$d["G"][$sceneStep]["maxScore"]*100);
       
      
      // $ST["scorePercent"]=euroFormatDot($ST["score"]/$d["maxScorePossible"]*100);//*$d["totaleNumeroDiStep"]
       
       $ST["scorePercent"]=euroFormatDot ($ST["score"]/$d["massimoPerStep"][$ST["step"]]*100);
       
        
		if ($ST["scorePercent"]=="-") $ST["scorePercent"]="0";
		$ST["scorePercent"]=str_replace(".00", "", $ST["scorePercent"]);
        // cambiare scala al grafico 100%/numero Step

		
		$d["score"]+=$ST["score"];

		$ST["scenario_id"]=$d["G"][$sceneStep	]["scenario_id"];
        $ST["avatar_id"]=$d["G"][$sceneStep	]["avatar_id"];	
        
		$ST["question"]=$d["G"][$sceneStep	]["avatar_sentence"];	
        $ST["avatar_audio"]=$d["G"][$sceneStep	]["avatar_audio"];	
        
        
		$ST["answer"]=$d["G"][$sceneStep	]["answer_".$ST["answerN"]];
//avatar_size ,avatar_pos ,balloon_pos, feedback_1, feedback_2,feedback_3 , feedback_1_audio,feedback_2_audio,feedback_3_audio, audioAnwers 

        $ST["answerAudio"]=$d["gameId"]."_answ_".$ST["step"].$ST["scene"]."_".$ST["answerN"]."M.mp3"; //replace female in JS //226_answ_2A_1M
        
        
        $ST["feedback"]=$d["G"][$sceneStep	]["feedback_".$ST["answerN"]];
        if (!$ST["feedback"]) $ST["feedback"]='';
        $ST["feedbackAudio"]=$d["G"][$sceneStep	]["feedback_".$ST["answerN"]."_audio"];
        if (!$ST["feedbackAudio"]) $ST["feedbackAudio"]='';
        
        $ST["avatar_size"]=$d["G"][$sceneStep	]["avatar_size"];
        $ST["avatar_pos"]=$d["G"][$sceneStep	]["avatar_pos"];
        $ST["balloon_pos"]=$d["G"][$sceneStep	]["balloon_pos"];
        
        $ST["arrowY"]=$d["G"][$sceneStep	]["arrowY"];
        $ST["arrowPos"]=$d["G"][$sceneStep	]["arrowPos"];
     
		$ST["type"]=NULL;
        if (     isset($d[$sceneStep]["avatar_id"])  &&     $d[$sceneStep]["avatar_id"]!=1000) $d["avatarsIds"][]=$d["G"][$sceneStep	]["avatar_id"];
		$Stt++;
        
        // utilizzato anche per match movie
//		$d["s"][$sceneStep	]=$ST;
		
		$d["s"][]=$ST;
	}
	
	
	
	############ numbers
	//if ($d["match"]["end"])  {
		// spread this match

		$d["spreadQ"]="SELECT * FROM games_spread WHERE gameId=".$d["gameId"]." AND (".$d["score"].">=spreadL AND ".$d["score"]."< spreadR ) 
        /* A primo tentativo*/";
		$d["spread"]=sql_queryt($d["spreadQ"]);
		// caso di punteggio massimo 

		if (!$d["spread"]["spread"]) {
			$d["spreadQ"]="SELECT * FROM games_spread WHERE gameId=".$d["gameId"]." AND (".$d["score"].">spreadL AND ".$d["score"]."<= spreadR ) 
            /* A secondo tentativo*/";
			$d["spread"]=sql_queryt($d["spreadQ"]);
		}
		unset ($d["spread"]["gameId"]);
		//$d["commentQQ"]="SELECT ".$d["spread"]["spread"]."_comment FROM games WHERE gameId=".$d["gameId"]." ";
		$d["commentQ"]=sql_queryt("SELECT ".$d["spread"]["spread"]."_comment FROM games WHERE gameId=".$d["gameId"]." ");
		$d["comment"]=$d["commentQ"][		$d["spread"]["spread"]."_comment"				]; unset ($d["commentQ"]);	
	


		
		
		/////////////////////////////////////////////////////////


		$d["scorePercent"]=euroFormatDot($d["score"]/$d["maxScorePossible"]*100);	
		if ($d["scorePercent"]=="-") $d["scorePercent"]="0";
		$d["scorePercentPrint"]=str_replace(".00", "", $d["scorePercent"]);
		$d["scorePercentDecimal"]=round($d["scorePercent"]/100,2) ;	
		

		// spread this match
		if ($d["s"]) {
			$d["spreadQ"]="SELECT * FROM games_spread WHERE gameId=".$d["gameId"]." AND (".$d["score"].">=spreadL AND ".$d["score"]."< spreadR ) /* B primo */";
			$d["spread"]=sql_queryt($d["spreadQ"]); 
			if (!$d["spread"]["spread"]) {
				$d["spreadQ"]="SELECT * FROM games_spread WHERE gameId=".$d["gameId"]." AND (".$d["score"].">spreadL AND ".$d["score"]."<= spreadR ) /* B secondo tentativo*/";
				$d["spread"]=sql_queryt($d["spreadQ"]);
			}
		}

		
		// type
        /*
		$d["LW"]=substr($d["spread"]["spread"],0,1);
		if ($d["LW"]=="W") 
			$type="winning";
		else 
			$type="loosing";
        */
        ## cambio il 4/4/23: l'intervallo vincente che prima partiva SEMPRE a 50% estremi inclusi, 
        ## ora può partire da altra percentuale ad ottavi. Campo game.winningPercStart
        
        if ($d["scorePercent"]>=$d["game"]["winningPercStart"]) $type="winning";
        else $type="loosing";
        
		// final step

		$d["stepFinal"]=sql_queryt("SELECT step, scenario_id, avatar_id,avatar_size,avatar_pos,balloon_pos, arrowY, arrowPos, avatar_sentence, avatar_audio
		FROM games_steps WHERE gameId=".$d["gameId"]." AND type='$type' ");
 
		if ($d["match"]["end"]) 
			$d["s"][]=array(
			"step"=>$d["stepFinal"]["step"],
            "scenario_id"=>$d["stepFinal"]["scenario_id"],
            "avatar_id"=>$d["stepFinal"]["avatar_id"],
			"question"=>$d["stepFinal"]["avatar_sentence"],
            "avatar_audio"=>  $d["stepFinal"]["avatar_audio"],
			//"ts"=>$d["stepFinal"]["ts"],
			"type"=>$type,
            "avatar_size"=>$d["stepFinal"]["avatar_size"],
            "avatar_pos"=>$d["stepFinal"]["avatar_pos"],
            "balloon_pos"=>$d["stepFinal"]["balloon_pos"],
            "arrowY"=>$d["stepFinal"]["arrowY"],
            "arrowPos"=>$d["stepFinal"]["arrowPos"],
            "feedback"=>'',
            "feedbackAudio"=>'',
			);
            if ($d["stepFinal"]["avatar_id"]!=1000) $d["avatarsIds"][]=$d["stepFinal"]["avatar_id"];


 
 
	$d["update"]=$update;
	if ($update) {
		$d["update"]=1;
		$us="UPDATE matches SET end =".C_TIME." ,final ='".$d["spread"]["spread"]."' WHERE idm=$idMatch";
		sql_query($us);
		//if (sql_error()) 	return sql_error()." $us";
	}

///send grades/////////////////////////////////////////////////////////////////////////////////////////////////////

	if ($update && $_SESSION['secret']	&& $_SESSION['lis_result_sourcedid'] && $_SESSION['family'] 	&& $_SESSION['lis_outcome_service_url']	
    ){
		//$d["sessionTest"]=$_SESSION;
		require_once($_SERVER['DOCUMENT_ROOT'] ."/_lib/ims-lti-master/php-simple/ims-blti/OAuthBody.php");
$method="POST";
$oauth_consumer_secret = $_SESSION['secret'];

$sourcedid = $_SESSION['lis_result_sourcedid'];
if (get_magic_quotes_gpc()) $sourcedid = stripslashes($sourcedid);
$oauth_consumer_key = $_SESSION['family'];
$endpoint = $_SESSION['lis_outcome_service_url'];
$content_type = "application/xml";

$body = '<?xml version = "1.0" encoding = "UTF-8"?>  
<imsx_POXEnvelopeRequest xmlns = "http://www.imsglobal.org/lis/oms1p0/pox">      
    <imsx_POXHeader>         
        <imsx_POXRequestHeaderInfo>            
            <imsx_version>V1.0</imsx_version>  
            <imsx_messageIdentifier>MESSAGE</imsx_messageIdentifier>         
        </imsx_POXRequestHeaderInfo>      
    </imsx_POXHeader>      
    <imsx_POXBody>         
        <OPERATION>            
            <resultRecord>
                <sourcedGUID>
                    <sourcedId>SOURCEDID</sourcedId>
                </sourcedGUID>
                <result>
                    <resultScore>
                        <language>en-us</language>
                        <textString>GRADE</textString>
                    </resultScore>
                </result>
            </resultRecord>       
        </OPERATION>      
    </imsx_POXBody>   
</imsx_POXEnvelopeRequest>';

    $operation = 'replaceResultRequest';
    $postBody = str_replace(
    array('SOURCEDID', 'GRADE', 'OPERATION','MESSAGE'), 
    array($sourcedid, $d["scorePercentDecimal"], $operation, uniqid()),
    $body);
			
			//simplexml_load_string
			//$d["moodleSendGradesAnsw"] 
            $moodleSendGradesAnsw= (sendOAuthBodyPOST($method, $endpoint, $oauth_consumer_key, $oauth_consumer_secret, $content_type, $postBody));
		
	}


////////////////////////////////////////////////////////////////////////////////////////////////////////
    $d["avatarsIds"]=array_unique($d["avatarsIds"]);
	unset ($d["q"]);
	return $d;
	
}

?>