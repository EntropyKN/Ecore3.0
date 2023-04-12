<?php
include_once("../config/config.inc.php");
$lang_trigger="edt";require_once(C_ROOT."/config/lang.inc.php");

if (!loggedIn()) die("false|-|you are not logged");
if ($_SESSION["ulevel"]<1) die("false|-|you don't have the right permissions");
$D=$_POST;//["D"]
$D=array_map("trim",$D);

if (	!is_numeric($D["idg"]) ) 
die("false|-|data errors...".print_r($D,true));

if ($D["cmd"]!="setPlayable" && $D["cmd"]!="copy" && $D["cmd"]!="setoff" && $D["cmd"]!="delete") 
	die("false|-|no_cmd".print_r($D,true));


if ($D["cmd"]=="delete" ){#############################################
	$D["Q"]="UPDATE games SET status = 'deleted' WHERE gameId =".$D["idg"];
	sql_query($D["Q"]);
	$D["Qe"]=sql_error();
	echo "true|-|";
	echo $D["idg"]."|-|";
	//
	
	$D["track"]=utracking(array(
		"action"=>"gameEdit",
		"actionSecondary"=>"deleted", 
		"gameId"=>$D["idg"]
	)) ;
	print_r($D);
	die;
}

if ($D["cmd"]=="setPlayable" ){#############################################
    $gameIdA=$D["idg"];
    //
    
	$D["Q"]="UPDATE games SET status = 'playable' WHERE gameId =".$D["idg"];
	sql_query($D["Q"]);
	$D["Qe"]=sql_error();
		
	echo "true|-|";
	echo $D["idg"]."|-|";
	
	
	$D["track"]=utracking(array(
		"action"=>"gameEdit",
		"actionSecondary"=>"playable",
		 "gameId"=>$D["idg"]
	)) ;
	print_r($D);
    echo "|-|";
    include_once($_SERVER['DOCUMENT_ROOT']."/_m/ajax.generatePlayerAudio.php");
	die;
}

if ($D["cmd"]=="setoff" ){#############################################
	$D["Q"]="UPDATE games SET status = 'offline' WHERE gameId =".$D["idg"];
	sql_query($D["Q"]);
		$D["Qe"]=sql_error();
	echo "true|-|";
	echo $D["idg"]."|-|";
	
	$D["track"]=utracking(array(
		"action"=>"gameEdit",
		"actionSecondary"=>"offline", "gameId"=>$D["idg"]
	)) ;
	print_r($D);
	die;
}


if ($D["cmd"]=="copy" ){#############################################

	$strSS="select title from games WHERE gameId  =".$D["idg"];
	$DD=sql_fetch_assoc(sql_query($strSS));
	
	$D["newTitle"]=L_copy_of_SOMETHING." ".$DD["title"];

	////////////////////////////////////////////////////  games
	$D["Qg"][0]="CREATE  TABLE tmptable_1 SELECT * FROM games WHERE gameId =".$D["idg"]; ///*TEMPORARY
	sql_query($D["Qg"][0]);
	$D["Qge"][0]=sql_error();
	
    sql_query("ALTER TABLE `tmptable_1` CHANGE `gameId` `gameId` INT(11) NULL DEFAULT NULL"); //****
    
    
	$D["Qg"][1]="UPDATE tmptable_1 SET gameId = NULL, status='draft', title='".db_string($D["newTitle"])."', createdTs='".C_TIME."', uid_editor=0, editTs=0, uid_creator='".$_SESSION["uid"]."' WHERE gameId  =".$D["idg"];
	sql_query($D["Qg"][1]);
	$D["Qge"][1]=sql_error();

	$D["Qg"][2]="INSERT INTO games SELECT * FROM tmptable_1 ";
	sql_query($D["Qg"][2]);
	$D["Qge"][2]=sql_error();
	$D["idgNew"]=sql_id();
		
	$D["Qg"][3]="DROP TABLE IF EXISTS tmptable_1"; ///*TEMPORARY
	sql_query($D["Qg"][3]);
	$D["Qge"][3]=sql_error();


		////////////////////////////////////////////////////  games_steps
	$D["strlines"]="select idStep from games_steps WHERE gameId  =".$D["idg"];
	$D["strSentE"]=sql_error();
	
	$qL=sql_query($D["strlines"]);
	while ($L=sql_fetch_assoc($qL)){
		$D["line"][]=$L["idStep"];
	}
	
	$D["Qg"]["Lcreate"]="CREATE TABLE tmptable_2 SELECT * FROM games_steps WHERE idStep IN (".implode(",",$D["line"]).")"; ///*TEMPORARY
	sql_query($D["Qg"]["Lcreate"]);
	$D["Qge"]["LcreateE"]=sql_error();
	
    sql_query("ALTER TABLE `tmptable_2` CHANGE `idStep` `idStep` INT(11) NULL DEFAULT NULL"); //****
    
    
	$D["Qg"]["Lupdate"]="UPDATE tmptable_2 SET gameId = ".$D["idgNew"].", idStep=NULL";
	sql_query($D["Qg"]["Lupdate"]);
	$D["Qge"]["LupdateE"]=sql_error();

	$D["Qg"]["Linsert"]="INSERT INTO games_steps SELECT * FROM tmptable_2 ";
	sql_query($D["Qg"]["Linsert"]);
	$D["Qge"]["LinsertE"]=sql_error();

	$D["Qg"]["Ldrop"]="DROP TABLE IF EXISTS tmptable_2"; ///*TEMPORARY
	sql_query($D["Qg"]["Ldrop"]);
	$D["Qge"]["Ldrop"]=sql_error();



		////////////////////////////////////////////////////  games_steps_attachments
	$D["strlines"]="select idAttachment from games_steps_attachments WHERE gameId  =".$D["idg"];
	$D["strSentE"]=sql_error();
	
	$qL=sql_query($D["strlines"]);
	while ($L=sql_fetch_assoc($qL)){
		$D["idAttachment"][]=$L["idAttachment"];
	}
	
	$D["Qg"]["Lcreate"]="CREATE  TABLE tmptable_3 SELECT * FROM games_steps_attachments WHERE idAttachment IN (".implode(",",$D["idAttachment"]).")"; ///*TEMPORARY
	sql_query($D["Qg"]["Lcreate"]);
	$D["Qge"]["LcreateE"]=sql_error();
	
    sql_query("ALTER TABLE `tmptable_3` CHANGE `idAttachment` `idAttachment` INT(11) NULL DEFAULT NULL"); //****
    
	$D["Qg"]["Lupdate"]="UPDATE tmptable_3 SET gameId = ".$D["idgNew"].", idAttachment=NULL";
	sql_query($D["Qg"]["Lupdate"]);
	$D["Qge"]["LupdateE"]=sql_error();

	$D["Qg"]["Linsert"]="INSERT INTO games_steps_attachments SELECT * FROM tmptable_3 ";
	sql_query($D["Qg"]["Linsert"]);
	$D["Qge"]["LinsertE"]=sql_error();

	$D["Qg"]["Ldrop"]="DROP TABLE IF EXISTS tmptable_3"; ///*TEMPORARY
	sql_query($D["Qg"]["Ldrop"]);
	$D["Qge"]["Ldrop"]=sql_error();


		////////////////////////////////////////////////////  games_spread

	$D["strlines"]="select idSpread from games_spread WHERE gameId  =".$D["idg"];
	$D["strSentE"]=sql_error();
	$D["idSpread"]=array();
	$qL=sql_query($D["strlines"]);
	while ($L=sql_fetch_assoc($qL)){
		$D["idSpread"][]=$L["idSpread"];
	}
	if (!empty($D["idSpread"])) {
		$D["Qg"]["Lcreate"]="CREATE  TABLE tmptable_4 SELECT * FROM games_spread WHERE idSpread  IN (".implode(",",$D["idSpread"]).")   "; ///*TEMPORARY
		sql_query($D["Qg"]["Lcreate"]);
		$D["Qge"]["LcreateEE"]=sql_error();
		
        sql_query("ALTER TABLE `tmptable_4` CHANGE `idSpread` `idSpread` INT(11) NULL DEFAULT NULL"); //****
        
        
		$D["Qg"]["Lupdate"]="UPDATE tmptable_4 SET gameId = ".$D["idgNew"].", idSpread=NULL";//
		sql_query($D["Qg"]["Lupdate"]);
		$D["Qge"]["LupdateEE"]=sql_error();
	
		$D["Qg"]["Linsert"]="INSERT INTO games_spread SELECT * FROM tmptable_4 ";
		sql_query($D["Qg"]["Linsert"]);
		$D["Qge"]["LinsertEE"]=sql_error();
	
		$D["Qg"]["Ldrop"]="DROP TABLE IF EXISTS tmptable_4"; ///*TEMPORARY
		sql_query($D["Qg"]["Ldrop"]);
		$D["Qge"]["LdropEE"]=sql_error();
	}
	
	echo "true|-|";
	echo $D["idgNew"]."|-|";
	print_r($D);
	
	utracking(array(
		"action"=>"gameEdit",
		"actionSecondary"=>"copy", "gameId"=>$D["idg"],  "data"=>$D["idgNew"]
	)) ;	
	
	die;
}
/*
delete from palma_sentences WHERE gameId  =7

*/



?>