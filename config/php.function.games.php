<?php

function getGames($page=1,$scope="playable", $how_many=8){
	//scope: gyms, drafts, matches offline

 
	//$lang_trigger="edt";require_once(C_ROOT."/config/lang.inc.php");

	$R['s']["scope"]=$scope;
	$R['s']["test"]=L_more_matches;
	$R['s']["page"]=$page;
	$R['s']["how_many"]=$how_many;
	$R['s']["query"]=false;
	
	$R['s']["res_from"]=$R['s']["how_many"]*($R['s']["page"]-1);	
	$R['s']["LIMIT"]= " LIMIT ".$R['s']["res_from"].",".$R['s']["how_many"];	
	
	//$R['s']["where"]="1 ";
	############CASES
	$playerVersion=playerVersion();
	 if ($scope=="playable"){		 


		$R['s']["query"]="SELECT  G.* FROM games  G 
		WHERE G.status='playable' 
		AND 
		(	G.gameId IN (SELECT
				distinct gu.gameId
				FROM
				game_usersgroups gu
				RIGHT JOIN 
				user_usersgroups uu ON (uu.idgroup=gu.idgroup)
				WHERE 
				uu.uid=".$_SESSION["uid"]." )
						OR  G.uid_editor=".$_SESSION["uid"]."  OR   G.uid_creator=".$_SESSION["uid"]."  
		)
		 ORDER BY gameId DESC  ".$R['s']["LIMIT"];			
		
		if ($_SESSION["ulevel"]==3) // super user
			$R['s']["query"]="SELECT  G.* FROM games  G 
			
			WHERE G.status='playable' 
			AND 
			(	G.gameId IN (SELECT
					distinct gu.gameId
					FROM
					game_usersgroups gu
					RIGHT JOIN 
					user_usersgroups uu ON (uu.idgroup=gu.idgroup)
					WHERE 
					uu.uid=".$_SESSION["uid"]." )
							OR  G.uid_editor=".$_SESSION["uid"]."  OR   G.uid_creator=".$_SESSION["uid"]."
							OR   G.uid_creator IN (select users_id from users where family='".$_SESSION["family"]."')
			)
			 ORDER BY gameId DESC  ".$R['s']["LIMIT"];			
		
		
		
		$text_more=L_more_games;
				//if ($_SESSION["family"]) $R['s']["query"].=" OR  gameId=27 "; //OTHERS
	 }	
	
	
	 if ($scope=="offline"){
		$R['s']["query"]="SELECT title,idgym,Description,cover,uid_creator, status FROM palma_gym where status='offline' AND uid_creator=".$_SESSION["uid"]."  ORDER BY title DESC  ".$R['s']["LIMIT"];	
		$text_more=L_more_offline_game;
	 }	
	

	 if ($scope=="drafts"){ //m.uid=".$_SESSION["uid"]."
		$R['s']["query"]="SELECT G.* FROM games G 
		
		WHERE G.status='draft' 	and uid_creator=".$_SESSION["uid"]."  /* OR  uid_editor=".$_SESSION["uid"]."  */ 
		ORDER BY G.title DESC ".$R['s']["LIMIT"];	 //and uid_creator!=".$_SESSION["uid"]." 
		$text_more=L_more_drafts;
	 }	
	 if ($scope=="matches"){
		/*$R['s']["query"]="SELECT 
		m.idm,m.gameId	,m.uid,m.start,m.end,m.final, COUNT(m.idm) howmany ,g.title
		FROM matches m
		 LEFT JOIN games g ON (g.gameId=m.gameId) 		 
		 WHERE m.uid=".$_SESSION["uid"]."  and m.end is not null
		 GROUP BY m.gameId 
		ORDER BY m.start DESC ".$R['s']["LIMIT"];
*/
    $R['s']["query"]="SELECT * FROM (
        SELECT  ANY_VALUE(m.idm) idm ,ANY_VALUE(m.gameId) gameId	,m.uid,ANY_VALUE(m.start) start ,ANY_VALUE(m.end) end,ANY_VALUE(m.final) final, COUNT(m.idm) howmany ,g.title, g.cover
        FROM matches m
         LEFT JOIN games g ON (g.gameId=m.gameId) 		 
         WHERE m.uid=".$_SESSION["uid"]."  and m.end is not null
         GROUP BY m.gameId 
    ) D
    ORDER BY D.start DESC ".$R['s']["LIMIT"];

		$text_more=L_more_matches;
	 }	


	 // next page
	$qS=sql_query($R['s']["query"]);

	$R["s"]["results"]=@sql_num_rows($qS);
	
	
	
	//if (!$R["s"]["results"]) return $R;	// no results
	$R["s"]["nexPageExist"]=true;
	if ($R["s"]["results"]<$R['s']["how_many"]) $R["s"]["nexPageExist"]=false;

	if (	sql_error()	) 	{$R['s']["error"]=sql_error().$R['s']["query"];return $R;}
	$i=0;$odds=1;
	while (	$G=sql_fetch_assoc($qS)	){
		$R['s'][$i]=$G;
		$R['s'][$i]["rand"]=rand(0,6);
		$R['s'][$i]["q"]=false;
		$G["coverpath"]="/data/covers/".$G["coverPath"].'';
        // credits:
        $G["credits"]=creditsFromDescription($G["Description"], 1);
        $G["Description"]=delete_all_between("<credits>", "</credits>",$G["Description"] );
        $G["Description"]=strip_tags($G["Description"]);
        
        
        
		if ($scope=="offline") 		{###########################
			if ($_SESSION["ulevel"]) $link='?/game/'.$G["gameId"];
			$linkPlay='?/'.$playerVersion.'/'.$G["gameId"];	
		}
		
		if ($scope=="playable") 	{###########################
			$link='?/'.$playerVersion.'/'.$G["gameId"];
			$linkPlay='?/'.$playerVersion.'/'.$G["gameId"];	
		}
		if ($scope=="drafts") 		{###########################
			$link='?/editor/'.$G["gameId"].'/0';	
			$linkPlay='?/'.$playerVersion.'/'.$G["gameId"];	
		}
		if ($scope=="matches") 		{##########################
			$link='?/debrief/'.$G["idm"].'';
			$linkPlay='?/'.$playerVersion.'/'.$G["gameId"];	
			if ($G["howmany"]>1) {
				$R['s'][$i]["q"]="SELECT m.idm,m.gameId	,m.uid,m.start,m.end FROM matches m 
				WHERE m.end is NOT NULL AND m.gameId=".$G["gameId"]." AND m.uid=".$_SESSION["uid"]." AND m.idm!=".$G["idm"]." ORDER BY m.start DESC ";
			}
			
		}
		$R['htm'].='<li>'; // id="page_'.$scope.'_'.$page.'_'.$i.'"
		$R['htm'].='<a class="cov" href="'.$link.'">';
			$R['htm'].='<img class="tosize" src="/img/coverSfuma640x274.png?'.$null.'" />';//1_2_1
			$R['htm'].='<img class="back" src="/img/coverSfuma640x274.png?'.$null.'" />';//1_2_1
			$R['htm'].='<img class="cover" src="/data/gameCover/'.$G["cover"].'" />';//1_2_1
			
			$R['htm'].='<span class="timg">';
				//$GD["title"]=$GD["title"].' Copia di Copia di Beatles VS Rolling Stones Copia di Beatles VS Rolling StonesCopia di Beatles VS Rolling Stones Copia di Beatles VS Rolling StonesCopia di Beatles VS Rolling StonesCopia di Beatles VS Rolling StonesCopia di Beatles VS Rolling StonesCopia di Beatles VS Rolling StonesCopia di Beatles VS Rolling StonesCopia di Beatles VS Rolling StonesCopia di Beatles VS Rolling StonesBeatles VS Rolling Stones';
				$R['htm'].=text_cut($G["title"], 72);
			$R['htm'].="</span>";			
		$R['htm'].="</a>";// cov
		
		$R['htm'].="<span class=\"tdescr\">";
			if ($scope=="matches"){######################################
				// matches results
				$R['htm'].="<span class=\"tline\">";
					$R['htm'].="<strong>".L_last_match."</strong> ";
					$R['htm'].=TimeAgo($G["end"]);
					$R['htm'].=" &bull; <a href=\"".$link."\" id=\"moremt_".$G["gameId"]."\">".L_show_report."</a>";	
				$R['htm'].="</span>";
				$R['htm'].="<span class=\"tline min\">";
					$R['htm'].=timestamp2red($G["end"], $mode="long",$_SESSION["lang"]);
				$R['htm'].="</span>";
				
				if ($G["howmany"]>1) {
					$qQ=sql_query($R['s'][$i]["q"]);
					
					$R['htm'].="<a href=\"#\" id=\"moremt_".$G["gameId"]."\" class=\"tline moremt\">";
					$R['htm'].="".L_more_matches." (".($G["howmany"]-1).")";
					$R['htm'].="</a>";
						
					$R['htm'].="<div  id=\"moremgroup_".$G["gameId"]."\" class=\"moremgroup\">";
					// loop matches for gym
					while (	$GG=sql_fetch_assoc($qQ)	){
						$link='?/debrief/'.$G["idm"].'';
						$R['htm'].="<span class=\"tline morem\">";
							$R['htm'].="<a href=\"?/debrief/".$GG["idm"]."\">"; //title=\"".timestamp2red($GG["startTime"], "long",$_SESSION["lang"])."\"
								$R['htm'].=TimeAgo($GG["end"]);
							$R['htm'].="</a>";	
							$R['htm'].=" ~ ".timestamp2red($GG["end"], "long",$_SESSION["lang"]);
						$R['htm'].="</span>";		
					}
					$R['htm'].="</div>";
				}else{
					$R['htm'].="<span class=\"tline moremt\">&nbsp;</span>";
				}
			}else{


				
				/////////////////!= MATCHES
                //if (!$G["credits"]) {
                    $R['htm'].="".text_cut(	br2newline($G["Description"])	, 160);
				//}else{
                //    $R['htm'].="".text_cut(	br2newline($G["Description"])	, 160).$G["credits"];  
                  
                //}
			}######################################
			
		$R['htm'].="</span>";

		// operations
		$R['htm'].="<span class=\"toptions\">";	
            if ($G["credits"]) $R['htm'].=$G["credits"];
        
		////////
			if ($_SESSION["ulevel"]>0 && $scope!="matches") {
				$R['htm'].='<a class="operationsLaunch" href="/?/game/'.$G["gameId"].'">';
					$R['htm'].='<img alt="" class="opacity50" src="/img/ico/option.png" title="'.L_details.'">';
				$R['htm'].="</a>";	

			}
		////////
			if ($scope=="matches") {
				$R['htm'].='<a class="" href="'.$link.'">';
					$R['htm'].='<img alt="" class="opacity35" src="/img/ico/graph.png" title="'.L_show_report.'">';
				$R['htm'].="</a>";				
			}
/*			$R['htm'].='<a class="" href="#">';
				$R['htm'].='<img alt="" class="opacity50 playlink" src="/img/ico/audioPlay14off.png" title="'.L_play_ESCLAMATIVE.'">';
			$R['htm'].="</a>";			
	*/	
				///////////////////// PLAY
				if ($G["status"]=="playable" || $G["status"]=="draft") {
					$R['htm'].='<a class="" href="'.$linkPlay.'">';
						$R['htm'].='<img alt="" class="opacity50 playlink" src="/img/ico/audioPlay14off.png" title="'.L_play_ESCLAMATIVE.'">';
					$R['htm'].="</a>";	
				}
				//////////////////////////
				
				if ($scope=="drafts"){
					$R['htm'].='<a class="" href="'.$link.'">';
						$R['htm'].='<img alt="" src="/img/ico/comment_off.png" title="'.L_edit.'">';
					$R['htm'].="</a>";
				}
	$R['htm'].="</span>";//toptions
		//////// end  operations


		$R['htm'].='<div class="clear"></div>';
		$R['htm'].="</li>";
		if ($odds==2) $R['htm'].='<div class="clear"></div>';

		///
		unset ($R['s'][$i]["q"]);
		$i++;$odds++;
		if ($odds==3) $odds=1;

	}
	/*
						$O.='<a class="rightLink rightLinkalone" href="?/editor/0/0">';
						$O.=L_create_a_new_gym;
						$O.="</a>";
	*/
	
	if ($R["s"]["nexPageExist"] || $scope=="drafts") {
		$R['htm'].='<div id="page_'.$scope.'_'.$page.'" class="pagemark">';
			if ($R["s"]["nexPageExist"]) $R['htm'].='<a class="rightLink nexpage" data-loading="0" data-scope="'.$scope.'" data-page="'.$page.'" href="#">'.$text_more.'</a><div class="spin16"></div>';
			if ($scope=="drafts") {
				$R['htm'].='<a class="rightLink" href="?/editor/0/0">';
				$R['htm'].=L_create_a_new_game;
				$R['htm'].="</a>";		
			}
		$R['htm'].='</div>';
	}
	return $R;

}

/////////////////////////////////////////////////////////////

function finalCalc2($idMatch, $update=false){ //, $playerSex="m"
    $d["moodleGrades"]=array();
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
        avatar_size ,avatar_pos ,balloon_pos, feedback_1, feedback_2,feedback_3 , feedback_1_audio,feedback_2_audio,feedback_3_audio
        , audioAnwers 
        , audioAnwersUpdate
        ,answersType,img_1,img_2,img_3,img_4
        
        
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
        
        
		$ST["answer"]=$d["G"][$sceneStep]["answer_".$ST["answerN"]];
        $ST["answerIMG"]=$d["G"][$sceneStep]["img_".$ST["answerN"]];
        $ST["answersType"]=$d["G"][$sceneStep]["answersType"];
//avatar_size ,avatar_pos ,balloon_pos, feedback_1, feedback_2,feedback_3 , feedback_1_audio,feedback_2_audio,feedback_3_audio, audioAnwers 

        $ST["answerAudio"]=$d["gameId"]."_answ_".$ST["step"].$ST["scene"]."_".$ST["answerN"]."M.mp3?".$d["G"][$sceneStep]["audioAnwersUpdate"]; //replace female in JS //226_answ_2A_1M
        
        //$ST["audioAnwersUpdate"]=$d["G"][$sceneStep]["audioAnwersUpdate"];
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
            $d["stepFinal"]["grade2moodle"]="Non richiesto";

 
 
	$d["update"]=$update;
	if ($update) {
		$d["update"]=1; //$d["scorePercentDecimal"]
		$us="UPDATE matches SET end =".C_TIME." ,final ='".$d["spread"]["spread"]."' 
        ,scorePercentDecimal='".$d["scorePercent"]."'
        ,`maxScorePossible` ='".$d["maxScorePossible"]."'
        WHERE idm=$idMatch";
		sql_query($us);
		if (sql_error()) 	$d["updateE"]=sql_error()." $us";
	}






## ##send grades to moodle by 

if ($update && $_SESSION["moodleData"]) {
    $d["moodleGrades"]["session"]=$_SESSION;
    $d["scorePercentDecimal"]=round($d["scorePercent"]/100,2) ;	
    require_once($_SERVER['DOCUMENT_ROOT'] ."/_LTI1.3_TP/config.php");
    $d["moodleGrades"]["gradesData"] = array(
        'timestamp' => DateTime::createFromFormat('U.u', microtime(true))->format('Y-m-d\TH:i:s.uP'),
        'userId' => $_SESSION["muser_id"], // ID dell'utente nel sistema Moodle
        'scoreGiven' => $d["scorePercent"], // Voto dato all'utente
        'scoreMaximum' => 100, // Voto massimo possibile
        'activityProgress' => 'Completed', // Stato dell'attività
        'gradingProgress' => 'FullyGraded', // Stato della valutazione
    );
    $d["moodleGrades"]["sendGrades"] = getTokenSendGradesToMoodle( $d["moodleGrades"]["gradesData"], $_SESSION);
    $d["stepFinal"]["grade2moodle"]=$d["moodleGrades"]["sendGrades"]["message"];
    unset( $d["moodleGrades"]["gradesData"]);
}


    $d["avatarsIds"]=array_unique($d["avatarsIds"]);
	unset ($d["q"]);
	return $d;
	
}

////////////////////////////////
function finalCalc2NoCustomOTTAVI($idMatch, $update=false){ //, $playerSex="m"
	$d["score"]=0;

	$d["scorePercent"]="0";

	$d["spread"]=array();
	
	$d["match"]=sql_queryt("SELECT idm, gameId, start, end FROM matches WHERE idm=$idMatch");	
	$d["gameId"]=$d["match"]["gameId"]; //unset($d["game"]);
	
	$d["match"]["startH"]=timestamp2it($d["match"]["start"]);
	if ($d["match"]["end"]) $d["match"]["endH"]=timestamp2it($d["match"]["end"]);
	
	
	if (!$d["gameId"]) return $d;
	if ($d["gameId"] && !$update) {
		$d["game"]=sql_queryt("SELECT G.title, G.Description,G.status, G.cover, G.dontShowDebriefScore FROM games G WHERE G.gameId=".$d["gameId"]);
	}
	
	
	$d["score"]=0;
    $d["avatarsIds"]=array();
	// load questions and answers
	$d["q1"]="SELECT 
		step, scene, scenario_id, avatar_id, avatar_sentence, answer_1,answer_2, answer_3, answer_4, avatar_audio
		, ascore_1,ascore_2, ascore_3, ascore_4,
        arrowPos, arrowY,
        avatar_size ,avatar_pos ,balloon_pos, feedback_1, feedback_2,feedback_3 , feedback_1_audio,feedback_2_audio,feedback_3_audio, 
        audioAnwers,answersType,img_1,img_2,img_3,img_4

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
        if ($d[$sceneStep]["avatar_id"]!=1000) $d["avatarsIds"][]=$d["G"][$sceneStep	]["avatar_id"];
		$Stt++;
        
        // utilizzato anche per match movie
//		$d["s"][$sceneStep	]=$ST;
		
		$d["s"][]=$ST;
	}
	
	
	
	############ numbers
	//if ($d["match"]["end"])  {
		// spread this match

		$d["spreadQ"]="SELECT * FROM games_spread WHERE gameId=".$d["gameId"]." AND (".$d["score"].">=spreadL AND ".$d["score"]."< spreadR ) /* A primo tentativo*/";
		$d["spread"]=sql_queryt($d["spreadQ"]);
		// caso di punteggio massimo 

		if (!$d["spread"]["spread"]) {
			$d["spreadQ"]="SELECT * FROM games_spread WHERE gameId=".$d["gameId"]." AND (".$d["score"].">spreadL AND ".$d["score"]."<= spreadR ) /* A secondo tentativo*/";
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
		$d["LW"]=substr($d["spread"]["spread"],0,1);
		if ($d["LW"]=="W") 
			$type="winning";
		else 
			$type="loosing";
			
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

function finalCalc($idMatch, $update=false){
	$d["score"]=0;
	$d["scoreNormalized"]=0;
	$d["scorePercent"]="0";

	$d["spread"]=array();
	
	$d["match"]=sql_queryt("SELECT idm, gameId, start, end FROM matches WHERE idm=$idMatch");	
	$d["gameId"]=$d["match"]["gameId"]; //unset($d["game"]);
	
	$d["match"]["startH"]=timestamp2it($d["match"]["start"]);
	if ($d["match"]["end"]) $d["match"]["endH"]=timestamp2it($d["match"]["end"]);
	
	
	if (!$d["gameId"]) return $d;
	if ($d["gameId"] && !$update) {
		$d["game"]=sql_queryt("SELECT G.title, G.status, /*G.description,G.language,*/ C.file coverPath FROM games G 
		LEFT JOIN covers C on G.cover_id=C.id		
		WHERE G.gameId=".$d["gameId"]);	

	}
	
	
	$d["score"]=0;
	// load questions and answers
	$d["q1"]="SELECT 
		step, scene, scenario_id, avatar_id, avatar_sentence, answer_1,answer_2, answer_3, answer_4
		, ascore_1,ascore_2, ascore_3, ascore_4
        ,answersType,img_1,img_2,img_3,img_4
	 FROM games_steps WHERE gameId=".$d["gameId"]." ORDER BY step ASC, scene ASC ";
	$qS=sql_query($d["q1"]);
	if (sql_error()) 	return sql_error();
	$ii=0;
	while (	$ST=sql_fetch_assoc($qS)	){
		$ST["max"]=0;$ST["min"]=NULL;
		for ($i=1; $i<=4; $i++) {
			if ($ST["answer_".$i]	&& $ST["ascore_".$i]>$ST["max"]		) 	$ST["max"]=$ST["ascore_".$i];
			
			
			if (
			($ST["answer_".$i]	 && is_numeric($ST["ascore_".$i])	 && $ST["ascore_".$i]<$ST["min"]		)
			|| is_null($ST["min"])
			) 		$ST["min"]=$ST["ascore_".$i];
		}
		
		
		$ST["delta"]=($ST["max"]-$ST["min"]);
		//unset ($ST["max"], $ST["min"]);
		$d["G"][$ii]=$ST;
		$ii++;
	}	
	
	
	/// match
	$d["q"]="SELECT * FROM matches_step WHERE idm=$idMatch ORDER BY id ASC ";

	$qS=sql_query($d["q"]);
	if (sql_error()) 	return sql_error();
	$Stt=0;
	while (	$ST=sql_fetch_assoc($qS)	){
		//if ($Stt==2) 
		//$ST["ascore"]=$ST["ascore"]-0.5;
		$ST["ascoreNormalized"]=$ST["ascore"]-$d["G"][$ST["step"]-1]["min"];
		
		$d["score"]+=$ST["ascore"];
		$ST["delta"]=$d["G"][$ST["step"]-1]["delta"]	;
		if (!$d["G"][$ST["step"]-1]["delta"]) 		$ST["scorePercent"]=0;
		else													$ST["scorePercent"]=$ST["ascoreNormalized"]	/			$d["G"][$ST["step"]-1]["delta"]*100;
		$ST["scorePercentShow"]=euroFormatDot($ST["scorePercent"]);
		$ST["scorePercentShow"]=str_replace(".00", "", $ST["scorePercentShow"]);
		
		//$ST["scorePercentT"]=$ST["ascore"]." /".$d["G"][$ST["step"]-1]["delta"];
		$ST["scenario_id"]=$d["G"][$ST["step"]-1]["scenario_id"];	
		$ST["question"]=$d["G"][$ST["step"]-1]["avatar_sentence"];	
		$ST["answer"]=$d["G"][$ST["step"]-1]["answer_".$ST["answerN"]];	
		$ST["type"]=NULL;	
		$Stt++;
		$d["s"][]=$ST;
	}
	
	############ numbers
	//if ($d["match"]["end"])  {
		// spread this match

		$d["spreadQ"]="SELECT * FROM games_spread WHERE gameId=".$d["gameId"]." AND (".$d["score"].">=spreadL AND ".$d["score"]."< spreadR ) /* A primo tentativo*/";
		$d["spread"]=sql_queryt($d["spreadQ"]);
		// caso di punteggio massimo 

		if (!$d["spread"]["spread"]) {
			$d["spreadQ"]="SELECT * FROM games_spread WHERE gameId=".$d["gameId"]." AND (".$d["score"].">spreadL AND ".$d["score"]."<= spreadR ) /* A secondo tentativo*/";
			$d["spread"]=sql_queryt($d["spreadQ"]);
		}
		unset ($d["spread"]["gameId"]);
		//$d["commentQQ"]="SELECT ".$d["spread"]["spread"]."_comment FROM games WHERE gameId=".$d["gameId"]." ";
		$d["commentQ"]=sql_queryt("SELECT ".$d["spread"]["spread"]."_comment FROM games WHERE gameId=".$d["gameId"]." ");
		$d["comment"]=$d["commentQ"][		$d["spread"]["spread"]."_comment"				]; unset ($d["commentQ"]);	
	

		// spread ALL
		$d["spreadQA"]="SELECT * FROM games_spread WHERE gameId=".$d["gameId"]."  ";
		$QAS=sql_query($d["spreadQA"]);
		$spi=0;
		while (	$SP=sql_fetch_assoc($QAS)	){
			unset ($SP["gameId"]); 
			$d["spreadAll"][$spi]=$SP;
			$spi++;
		}
		/// match's result
		
		$d["min"]=$d["spreadAll"][0]["spreadL"];
		$d["max"]=$d["spreadAll"][7]["spreadR"];
		unset ($d["spreadAll"]
//		,$d["spreadQ"]
		);
		/////////////////////////////////////////////////////////
		//$d["score"]=6.4	;
		$d["scoreNormalized"]=$d["score"]-$d["min"];
		
		$d["delta"]=$d["max"]-$d["min"];
		
		$d["scorePercent"]=euroFormatDot($d["scoreNormalized"]/$d["delta"]*100);
		if ($d["scorePercent"]=="-") $d["scorePercent"]="0";
		$d["scorePercentPrint"]=str_replace(".00", "", $d["scorePercent"]);
		////////////////////////////////////////////////////
		
		
		// add score percent each played step
		if ($d["s"]) foreach($d["s"] as $stepIndex => $step) {
			//$d["s"][$stepIndex]["scoreNormalized"]=$step["ascore"]-$d["min"];
			//$d["s"][$stepIndex]["scorePercent"]=euroFormatSmart($d["s"][$stepIndex]["scoreNormalized"]/$d["delta"]*100);
			
		}

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
		$d["LW"]=substr($d["spread"]["spread"],0,1);
		if ($d["LW"]=="W") 
			$type="winning";
		else 
			$type="loosing";
			
		// final step
		$d["stepFinalQ"]="SELECT step, scenario_id, avatar_id,avatar_size,avatar_pos,balloon_pos, arrowY, arrowPos, avatar_sentence, avatar_audio
		FROM games_steps WHERE gameId=".$d["gameId"]." AND type='$type' ";
		$d["stepFinal"]=sql_queryt("SELECT step, scenario_id, avatar_id,avatar_size,avatar_pos,balloon_pos, arrowY, arrowPos, avatar_sentence, avatar_audio
		FROM games_steps WHERE gameId=".$d["gameId"]." AND type='$type' ");
 
		if ($d["match"]["end"]) 
			$d["s"][]=array(
			"step"=>$d["stepFinal"]["step"],
			"question"=>$d["stepFinal"]["avatar_sentence"],
			"ts"=>$d["stepFinal"]["ts"],
			"type"=>$type,
			);
		

 
 
	$d["update"]=$update;
	if ($update) {
		$d["update"]=1;
		$us="UPDATE matches SET end =".C_TIME." ,final ='".$d["spread"]["spread"]."' WHERE idm=$idMatch";
		sql_query($us);
		//if (sql_error()) 	return sql_error()." $us";
	}



	unset ($d["q"]);
	return $d;
	
}
///////////////////////////////////////////////////////
function matchExchanges($idMatch){
	$lang_trigger="usr";require_once(C_ROOT."/config/lang.inc.php");
	
	$d["match"]=sql_queryt("SELECT gameId FROM matches WHERE idm=$idMatch");	
	$d["gameId"]=$d["match"]["gameId"]; unset($d["game"]);
	if (!$d["gameId"]) return "no_game_id";

	// load questions and answers
	$d["q1"]="SELECT step, scene, 
		avatar_sentence, answer_1,answer_2, answer_3, answer_4	
        , feedback_1,feedback_2, feedback_3, feedback_4
,answersType,img_1,img_2,img_3,img_4        
	 FROM games_steps WHERE gameId=".$d["gameId"]." ORDER BY step ASC ";
	$qS=sql_query($d["q1"]);
	if (sql_error()) 	return sql_error();
	$ii=0;
	while (	$ST=sql_fetch_assoc($qS)	){
		//$d["G"][$ii]=$ST;
        $d["G"][$ST["step"].$ST["scene"]]=$ST;
		$ii++;
	}

	
	$d["q"]="SELECT * FROM matches_step WHERE idm=$idMatch ORDER BY id ASC ";
//	$d["score"]=0;
	$qS=sql_query($d["q"]);
	if (sql_error()) 	return sql_error();
	$d["dialogue_html"]='';
	while (	$ST=sql_fetch_assoc($qS)	){
        $ST["stepScene"]=$ST["step"].$ST["scene"];
		$ST["question"]=$d["G"][     $ST["stepScene"]      ]["avatar_sentence"];	
		$ST["answer"]=$d["G"][    $ST["stepScene"]    ]["answer_".$ST["answerN"]];
        $ST["feedback"]=$d["G"][    $ST["stepScene"]    ]["feedback_".$ST["answerN"]];
        
		$d["dialogue_html"].='<span class="usr"><span>'.L_avatar.'</span>: '.$ST["question"]	.'</span><span class="usr"><span>'.L_you.'</span>: '.$ST["answer"].'</span>';				
        
        if ($ST["feedback"]) // feedback
            $d["dialogue_html"].='<span class="usr"><span>'.L_avatar.'</span>: '.$ST["feedback"]	.'</span>';
        
		$d["s"][]=$ST;
	}
    //  debug
//    $d["dialogue_html"]=str_replace("<span ", "
//<span ", $d["dialogue_html"]);

	return $d;
	
}


?>