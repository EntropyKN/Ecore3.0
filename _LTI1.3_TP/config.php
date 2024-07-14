<?php
// config
error_reporting(E_ALL ^ E_NOTICE);
ini_set("display_errors", 1);
/*  Impostando LTI_TEST_ONLY true, la pagina di lancio mostrerà solo l'esito del test di collegamento 
    e il test di invio voti senza reindirizzare verso il game per il gioco.
    Attenzione: quando LTI_TEST_ONLY true, i grades pari a 66.6 sono effettivamente assegnati. 
*/
define('LTI_TEST_ONLY', false);
define('DEPLOYMENT_ID', '1.1'); // sotituire facoltativamente con il proprio deployment-id:
define('REDIRECT_URI', SITE_URL_LOCATION.'_LTI1.3_TP/launch.php');
require("functions.php");

/*
https://entropylearninghub.it/mod/lti/toolconfigure.php
Home
Amministrazione del sito
Plugin
Moduli attività
Tool esterno
Gestione tool


https://entropylearninghub.it/mod/lti/view.php?id=960
https://entropylearninghub.it/grade/report/grader/index.php?id=30
*/
?>
