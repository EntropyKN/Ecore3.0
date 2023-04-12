<?php

//print_r($DIRA);die; 
//https://else.entropylearningplatform.it/?/game/27

if (!$DIRA[2] || !is_numeric($DIRA[2])  ||  $_SESSION["ulevel"]==0 ){
	header("location:/?/".$DIRA[2]."__NOT_FOUND");exit();
}




$G=sql_queryt("SELECT  G.*  FROM games  G 
		 where G.gameId='".db_string(trim($DIRA[2]))."'");
 
if ( !$G['gameId']	) {

	die ("NOT FOUND");
//	header("location:/?/".$DIRA[2]."__NOT_FOUND");exit();
}



$JSA[]=''.C_DIR.'/_m/game/game.js?'.PAGE_RANDOM;
$CSSA[]=''.C_DIR.'/_m/game/game.css?'.PAGE_RANDOM;
$O.='<div id="mask" class="opacity50"></div>';
$O.='<div id="core" data-gameId="'.$G['gameId'].'">';
	
	require_once(C_ROOT."/_m/header/header.inc.php");
	require_once(C_ROOT."/config/php.function.games.php");
	$playerVersion=playerVersion();

    $G["credits"]=creditsFromDescription($G["Description"]);
    $G["Description"]=delete_all_between("<credits>", "</credits>",$G["Description"] );
    $G["Description"]=strip_tags($G["Description"]);


	$page["titlePre"]=L_game." ".L_details." - ";
	$O.='<div id="coreIn">';
	
	

	/////////////////////////////
	//$O.='<img class="cover" src="/data/covers/'.$G["cover"].'.jpg">';
	//$O.='<div class="titleG">'.$G["title"].'</div>';

	$O.='<div class="cov">';
		$O.='<img class="tosize" src="/data/covers/covermask1024x219black.png?">';
		$O.='<img class="back" src="/data/covers/covermask1024x219black.png?">';
		//$O.='<img class="cover" src="/data/covers/'.$G["coverPath"].'">';
        $O.='<img class="cover" src="/data/gameCover/'.str_replace("_640.jpg","_1024.jpg", $G["cover"]).'">';
		$O.='<span id="timg">'.$G["title"].'</span>	';
	$O.='</div>';
	$O.='<div class="descr">';
		$O.=$G["Description"];
	$O.='</div>';
    if ($G["credits"]) $O.=$G["credits"];
////////////////////
	$O.='<div class="titleG">';
		$O.="Game's ID".": <span>".$G["gameId"]."</span>";
	$O.='</div>';

	$O.='<div class="titleG">';
		$O.=L_status.": <span>".$G["status"]."</span>";
	$O.='</div>';
	$O.='<div class="mindescr">';
		$O.=L_STATUS_LEGENDA_HTML;
	$O.='</div>';
	
	//////////////////////////////// change Status   if ($D["cmd"]!="setPlayable" && $D["cmd"]!="copy" && $D["cmd"]!="setoff" && $D["cmd"]!="delete") 
	$O.='<div class="titleG">';
		$O.=L_options.":";
	$O.='</div>';	
	$O.='<div class="con">';
	if ($_SESSION["ulevel"]>=2) {
		$O.='<select id="status">';
		$O.="<option value=\"0\">".L_change_status."</option>";
			if ($G["status"]!="playable" && $G["status"]!="draft" ) 	$O.="<option value=\"Playable\">Playable</option>";
			if ($G["status"]!="offline") 		$O.="<option value=\"Offline\">Offline</option>";
			if ($G["status"]!="deleted") 		$O.="<option value=\"Deleted\">Deleted</option>";
		$O.='</select>';
	}
		$linkPlay='?/'.$playerVersion.'/'.$G["gameId"];	
		if ($G["status"]!="draft" ){
			$O.='<a class="option play" href="'.$linkPlay.'">Play</a>';
			$O.='<div class="clear"></div>';
			$O.='<a class="option copy" id="createcopy" href="#">'.L_create_a_copy_in_drafts.'</a>';
			
		}else{
			$O.='<a class="option edit" id="edit" href="/?/editor/'.$G["gameId"].'/0">'.L_edit.'</a>';
		}
		$O.='<div class="clear"></div>';
	$O.='</div>';	
	
	
	$O.='<div class="clear"></div>';	
	
	//////////////////////////////// history

	
	
	//////////////////////////////// data
	$G["editors"]=array(
		$G["uid_creator"],
		$G["uid_editor"],
		0
	);
	$G["editorUids"]=array();
	$G["history"]=array();
	
	///////////////////////////////////////////
	$G["trackQ"]="SELECT idu, timestamp, action, actionSecondary, data FROM user_tracking WHERE gameId=".$G['gameId']." AND action='gameEdit' ORDER BY timestamp DESC ";
	$tU=@sql_query($G["trackQ"]);	
	while ($t=sql_fetch_assoc($tU) ){

		$G["history"][]=array(
			"uid"=>$t["idu"],
			"timestamp"=>$t["timestamp"],
			"action"=>$t["actionSecondary"],
			"data"=>$t["data"],
		);	
		$G["editors"][]=$t["idu"];
	}	
	//$O.=print_r($D["history"],true);
	
	//// 
	$G["editors"]=array_unique($G["editors"]);
	$G["editors"]=array_filter ($G["editors"]);
	$G["editorsQ"]="SELECT users_id as uid, Concat(user_real_name ,' ',user_real_surname ) as name FROM users U WHERE users_id IN (".implode(",",$G["editors"]).")";

	$qU=@sql_query($G["editorsQ"]);	
	while ($d=sql_fetch_assoc($qU) ){
		$G["editorUids"][	$d["uid"]	]=$d["name"];
	}
	
	////////////////////////////// PRINT HISTORY
	
	if ($G["createdTs"]	 && $G["uid_creator"]		) 
		
		$G["history"][]=array(
			"uid"=>$G["uid_creator"],
			"timestamp"=>$G["createdTs"],
			"action"=>"created",
		);		
		
		/*$O.='<div class="Hline">';
		$O.=$G["editorUids"][	$G["uid_creator"] ]."  ha creato the game";
		$O.=" &bull; <span>".timestamp2red($G["createdTs"], $mode="long",$_SESSION["lang"])."<span>";
		$O.='</div>';*/
	
	if ($G["editTs"]	 && $G["uid_editor"]		)
		
		$G["history"][]=array(
			"uid"=>$G["uid_editor"],
			"timestamp"=>$G["editTs"],
			"action"=>"edit",
		);
		

	//$D["history"]=sortBySubValue($G["history"], "timestamp");
$D["history"]=$G["history"];
	//////////////////////////////////////////////////
if ($D["history"])  {
	$O.='<div class="titleG">';
		$O.=L_history.":";
	$O.='</div>';
}
	if ($D["history"]) foreach( $D["history"] as $k => $v ) {
		$O.='<div class="Hline">';
		$O.="<strong>".$G["editorUids"][	$v["uid"] ]." </strong> ";
		/*if ($_SESSION["uid"]!=$v["uid"])  {
			$O.="<strong>".$G["editorUids"][	$v["uid"] ]."";
			//if ($_SESSION["uid"]==$v["uid"])  $O.=" (".L_you.")";
			$O.="</strong> ";
			//$O.=$v["action"];
		}
		*/

				switch ($v["action"]) {
					case "edit":
						$O.= "has edited the game";
						break;
					case "created":
						$O.= "created the game";
						break;
					case "offline":
						$O.= "setted the status on <strong>Offiline</strong>";
						break;
					case "playable":
						$O.= "setted the status on <strong>Playable</strong>";
						break;
					case "deleted":
						$O.= "setted the status on <strong>Deleted</strong>";
						break;
					case "copy":
						$O.= "created <a target=\"_blank\" href=\"/?/game/".$v["data"]."/\">a copy</a> of the game";
						break;
			}
		/*	if ($_SESSION["uid"]!=$v["uid"])  {

				
			}else{
				switch ($v["action"]) {
					case "edit":
						$O.= "Hai modificato the game";
						break;
					case "created":
						$O.= "Hai <strong>creato</strong> the game";
						break;
					case "offline":
						$O.= "Hai modificato lo stato in <strong>Offiline</strong>";
						break;
					case "playable":
						$O.= "Hai modificato lo stato in <strong>Playable</strong>";
						break;
					case "deleted":
						$O.= "Hai modificato lo stato in <strong>Deleted</strong>";
						break;
					case "copy":
						$O.= "Hai fatto <a target=\"_blank\" href=\"/?/gym/".$v["data"]."/\">una copia</a> delthe game";
						break;
				}				
				
			}
			*/
			$O.=" &bull; <span>".timestamp2red($v["timestamp"], $mode="long",$_SESSION["lang"])."<span>";			
		$O.='</div>';
	}

	
//////////////////
//$O.="<pre>****".$_SERVER['HTTP_USER_AGENT'];	
		if ($_COOKIE["debugX"])				{
//			$O.="<pre>****".$_SERVER['HTTP_USER_AGENT'];	
//			$O.=print_r($_SESSION,true);
			$O.="<pre>";
			
			$O.=print_r($D["history"],true);
			$O.=print_r($G,true);
			$O.="</pre>";
		}
	$O.="</div>";//coreIn
$O.="</div>";//core
	$O.='<div class="clear"></div>';
	$O.="<br /><br /><br />";
	
	
	
/*
    [gameId] => 58
    [status] => playable
    [title] => Una donna sportiva
    [Description] => La sig.ra Settimi torna in concessionaria per riconsegnare la classe B executive next dopo il periodo di prova. La signora è già una cliente Mercedes avendo acquistato 4 anni fa una classe A 20 giorni prima era entrata in concessionaria e aveva parlato con un consulente alla vendita per richiedere un preventivo sulla classe B next. Il consulente alla vendita le aveva quindi presentato la classe B executive con cambio automatico, proponendole un periodo di prova per apprezzare al meglio le caratteristiche del modello scelto. Al rientro, la sig.ra Settimi incontra il sig. Moroni, product expert, che desidera saper come è andata e come si è trovata con la macchina per poi riaccompagnarla dal collega per concludere la vendita. La cliente in effetti mostra alcune perplessità che la stanno dissuadendo all’acquisto.
    [Goal_1] => Conoscere le aspettative della cliente e le difficoltà incontrate durante il periodo di prova perché la cliente concluda l’acquisto
    [Goal_2] => 
    [Goal_3] => 
    [Goal_4] => 
    [Goal_5] => 
    [states] => 13
    [sgroups] => 5
    [sparallel] => 1
    [bot_name] => Laura Settimi
    [bot_avatar_id] => 4
    [bot_description] => Capo area per un’azienda che si occupa di fashion retail, desidera acquistare una nuova macchina che utilizzerà anche negli spostamenti previsti dal suo lavoro.
    [bot_goal1] => Deve cambiare macchina ma ora vuole rinunciare all’acquisto della classe B e cambiare marchio
    [bot_goal2] => 
    [bot_goal3] => 
    [usr_name] => Dario Moroni
    [usr_avatar_id] => 1
    [usr_description] => Product expert con esperienza di 3 anni
    [usr_goal1] => Comprendere le esigenze della cliente e far in modo che concluda l’acquisto con il consulente alla vendita
    [usr_goal2] => 
    [usr_goal3] => 
    [background_id] => 3
    [bot_initial_escalation] => 5
    [audio] => 0
    [v0] => -185
    [v1] => -5
    [v2] => 5
    [v3] => 260
    [fc1] => a
    [fc2] => a
    [fc3] => 
    [fc4] => a
    [fc5] => 
    [fc6] => 
    [fc7] => 
    [fc8] => a
    [uid_creator] => 80
    [createdTs] => 1524420448
    [uid_editor] => 80
    [editTs] => 1524812659
    [cover] => 1_4_1
    [lang] => it
    [estimated_duration] => 
    [competence_target] => 
    [difficulty_level] => 
*/	
?>
