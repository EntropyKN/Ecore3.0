<?php
// launch
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
require_once 'config.php';

$id_token = $_POST['id_token'];
if (!$id_token) die ("Questo file deve essere chiamato da moodle");

// token data
$decodedData=decodeToken($id_token);
$dataToken=getDataToken($id_token);
if (!$dataToken["iss"]) die ( "Mi spiace: il JWT decodificato è vuoto o contiene informazioni non intellegibili");
if (!$dataToken["gameId"]) die ( "Non trovo l'id del game.<br />Nel form del tool su moodle al campo \"Parametri personalizzati\"<br /> Inserisci id=seguito dall'id del game. Ad esempio: id=222");

$dataFamily=sql_queryt("SELECT family,secret,title as familytitle from family where iss='".db_string(strtolower($dataToken["iss"]))."'");
if (!$dataFamily["family"]) die ( "Mi spiace, non trovo la 'family' con ISS ".$dataToken["iss"]."<br />E' stata inserita nel DB?") ;
$dataToken["family"]=$dataFamily["family"];


if (!LTI_TEST_ONLY) {
    //session_destroy();
/*
    [lineitem] => https://entropylearninghub.it/mod/lti/services.php/30/lineitems/133/lineitem/scores?type_id=1
    [iss] => https://entropylearninghub.it
    [kid] => c1ba3a8fdcdd5d4788a4
    [context_id] => 30
    [resource_link_id] => 11
    [type_id] => 1
    [userid] => 3
    [given_name] => Arnaldo
    [family_name] => Guido
    [email] => arnaldoguido@gmail.com
    [role] => Learner
    [gameId] => 222
    
    DB NO:
    ALTER TABLE `users` ADD `moodle_iss` VARCHAR(128) NULL DEFAULT NULL AFTER `family`, ADD INDEX `moodle_iss` (`moodle_iss`(128));
    ALTER TABLE `users` DROP INDEX `emailFamily`;
    ALTER TABLE `users` CHANGE `family` `family` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'entropy';
    
    DB:
    ALTER TABLE `family` DROP INDEX `secret`;
    ALTER TABLE `family` CHANGE `secret` `secret` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL;
    ALTER TABLE `family` ADD `public` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL AFTER `family`;
    ALTER TABLE `family` ADD `iss` VARCHAR(128) NOT NULL AFTER `family`;
    ALTER TABLE `family` CHANGE `family` `family` VARCHAR(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL;
    ALTER TABLE `family` ADD INDEX(`iss`);
    ALTER TABLE `users` DROP INDEX `emailFamily`;
    ALTER TABLE `psgameur_ecore`.`users` DROP INDEX `muser_family`, ADD UNIQUE `muser_family` (`muser_id`, `family`) USING BTREE;
    
*/
    $d=$dataToken;
    $D=array("d"=>$dataToken);
	$D["existQ"]=("SELECT users_id, muser_id, family,  user_real_name, user_real_surname, user_email, role0, user_level from users WHERE family='".$d["family"]."' AND muser_id =".$d["userid"]);
	$D["user"]=sql_queryt($D["existQ"]);//unset ($D["existQ"]);
/*
            [users_id] => 57
            [muser_id] => 2
            [family] => entropylearning
            [user_real_name] => Cosimo
            [user_real_surname] => Mandorino
            [user_email] => cosimo.mandorino@entropykn.net
            [role0] => Instructor
            [user_level] => 0          
*/
    if (!$D["user"]["users_id"]) {
        $D["insertQ"]=("INSERT INTO `users` (`muser_id`, `family`,user_real_name, `user_real_surname`, `user_email`,  `created`, `updated`,role0) 
        VALUES (".$d["userid"].",'".$d["family"]."',  '".db_string($d["given_name"])."', 
        '".db_string($d["family_name"])."',
        '".db_string($d["email"])."', ".C_TIME.",".C_TIME." ,  '".db_string($d["role"])."'  )");
        sql_query($D["insertQ"]);
		$D["user"]=array(
			"users_id"=>sql_id(),
			"muser_id"=>$d["userid"],
			"family"=>$d["family"],
			"user_email"=>$d["email"],
			"user_real_name"=>$d["given_name"],
			"user_real_surname"=>$d["family_name"],
			"user_email"=>$d["email"],
			"role0"=>$d["role"],
			"user_level"=>0, // cambiare in funzione dei ruoli moodle? attuamente fisso
			"new"=>true,
		);        
        
    }
    
    // set session:
	if ($D["user"]["users_id"]	) { 
		//unset ($_SESSION);
        
		$_SESSION['uid'] =$D["user"]["users_id"];
		$_SESSION['muser_id'] =$D["user"]["muser_id"];
		$_SESSION['family'] =$D["user"]["family"];
		$_SESSION['email'] = $D["user"]["user_email"];
		/*$_SESSION['emailvalidate'] = $T["emailvalidate"];
		if (!$_SESSION['emailvalidate']) $_SESSION['emailvalidate']=0;
		if (strlen($_SESSION['email'])<2) $_SESSION['emailvalidate']=666; //old users
		*/
		$_SESSION['shown_name'] = $D["user"]["user_real_name"]." ".$D["user"]["user_real_surname"];
		$_SESSION['ulevel'] = $D["user"]["user_level"];
		$_SESSION['name'] = $D["user"]["user_real_name"];
		$_SESSION['surname'] = $D["user"]["user_real_surname"];
		$_SESSION['sex'] = $D["user"]["sex"];		
		$_SESSION['role0'] = $D["user"]["role0"];
		
		$_SESSION["lang"] = $d['lang'];
		$_SESSION["familytitle"]=$dataFamily["familytitle"];
		$_SESSION['moodleData']=$d;
        $D["URL"]=C_DIR."?/desktopplayer/".$d["gameId"];
        
        /*
		if (!$DEBUG && $P["custom_game"] && is_numeric($P["custom_game"]) ) {
			$URL=C_DIR."?/desktopplayer/".$P["custom_game"];
			//die("$URL eccoci");exit();
		}
	
    
//			header("location:/".$D["URL"]."");exit();	
		}*/
	}    
    
    $DEBUG=false;
    
    if ($DEBUG) {
    echo '<pre>';
    echo $D["URL"];
    echo '
    getTokenSendGradesToMoodle
    ';
    ///////////////////////////// invio grades con dati di sessione
    $gradesData = array(
        'timestamp' => DateTime::createFromFormat('U.u', microtime(true))->format('Y-m-d\TH:i:s.uP'),
        'userId' => $dataToken["userid"], // ID dell'utente nel sistema Moodle
        'scoreGiven' => 66.6, // Voto dato all'utente
        'scoreMaximum' => 100, // Voto massimo possibile
        'activityProgress' => 'Completed', // Stato dell'attività
        'gradingProgress' => 'FullyGraded', // Stato della valutazione
    );    
    print_r(getTokenSendGradesToMoodle($gradesData, $_SESSION));

    /////////////////////////////
    
        echo '
        SESSION:
        ';
        print_r($_SESSION);
        echo "Data:
        ";
                
        print_r($D);
    }else{
        header("location:/".$D["URL"]."");exit();
    }

} else {
######################################################################## TEST ZONE

    echo '<pre>';
    echo "<strong>TEST LTI</strong>:
---------DATI UTILI ESTRATTI DAL Json Web Token:---------
";
    print_r ($dataToken);




//die("   stop qui");

     echo '
---------RICHIESTA TOKEN per invio Grades:---------
nuovo token:';
// renewToken($existingToken, $iss, $kid=false, $client_id,$secret, $returnData=false)
    $access_token=renewToken($id_token , $dataToken["iss"],$dataToken["kid"],$dataToken["aud"],$dataFamily["secret"], false);
    print_r ($access_token);

    $microtime = microtime(true); // Ottiene il timestamp con i millisecondi
    $microseconds = sprintf("%06d", ($microtime - floor($microtime)) * 1000000); // Estrae i millisecondi
    $datetime = new DateTime(date('Y-m-d H:i:s.'.$microseconds, $microtime)); // Crea un oggetto DateTime con millisecondi

    $gradesData = 
        array(
        'timestamp'=>$datetime->format('Y-m-d\TH:i:s.uP'),
        'userId' => $dataToken["userid"], // ID dell'utente nel sistema Moodle
        'scoreGiven' => 66.6, // Voto dato all'utente
        'scoreMaximum' => 100, // Voto massimo possibile
        'activityProgress' => 'Completed', // Stato dell'attività
        'gradingProgress' => 'FullyGraded', // Stato della valutazione
    //      'userId'=>2

    );

    echo "
---------TEST INVIO GRADES A MOODLE:---------
";
    $testInvio=sendGradesToMoodle($access_token, $gradesData, $dataToken["lineitem"]);
    echo "risposta invio: ".$testInvio;
    if ($testInvio!=200) {
        echo "
<div style='color:red'><strong>Ci sono problemi nell'invio del grades a moodle";

if (strtolower($dataToken["role"])!="learner") echo "
Attenzione: spesso il docente che ha creato il corso non dispone delle autorizzazioni per inviare grades. 
Effettuare il test come Learner, non come Instructor";

echo "</strong></div>";
    }else{
echo "
<div style='color:green'><strong>Grades inviati con successo</strong></div>";
    }

    echo "
ARRAY DATI GRADES:
";
    print_r( $gradesData);


    /////////////////////// 
    echo "

---------JWT DECODED DATA:---------
    ";

    print_r($decodedData);

    //////////////
    echo '</pre>';
}
?>

