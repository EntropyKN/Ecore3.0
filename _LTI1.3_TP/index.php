<?php
// login
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");

require_once 'config.php';

session_start();

// Genera un nonce e salva nella sessione
$nonce = bin2hex(random_bytes(16));
$_SESSION['nonce'] = $nonce;

// Parametri POST inviati da Moodle
$client_id = $_POST['client_id'];
$login_hint = $_POST['login_hint'];
$target_link_uri = $_POST['target_link_uri'];
$lti_message_hint = $_POST['lti_message_hint'];

// URL di ritorno per l'autenticazione
$return_url = REDIRECT_URI;

// Parametri di richiesta
$params = [
    'response_type' => 'id_token',
    'client_id' => $_POST['client_id'],
    'scope' => 'openid',
    'redirect_uri' => $return_url,
    'login_hint' => $login_hint,
    'state' => $nonce,
    'nonce' => $nonce,
    'prompt' => 'none',
     'response_mode' => 'form_post',
    'lti_message_hint' => $lti_message_hint
];

// URL di autenticazione
//$auth_url = AUTH_URL . '?' . http_build_query($params);
$auth_url = $_POST["iss"].'/mod/lti/auth.php' . '?' . http_build_query($params);
// Reindirizza all'URL di autenticazione
header('Location: ' . $auth_url);exit;
/*
echo "<pre>";
echo '<a href="'.$auth_url.'" target="_NEW">'.$auth_url.'</a>';
echo "

";
print_r($_POST);
print_r($_GET);
exit;
*/
/*
POST:
    [iss] => https://entropylearninghub.it
    [target_link_uri] => https://ecore.sgameup.com/_LTI1.3_TP/
    [login_hint] => 2
    [lti_message_hint] => 960
    [client_id] => iQrgxllo7jZ3JvD
    [lti_deployment_id] => 1
    

https://entropylearninghub.it/mod/lti/auth.php?response_type=id_token&client_id=iQrgxllo7jZ3JvD&scope=openid&redirect_uri=https%3A%2F%2Fecore.sgameup.com%2F_LTI1.3_TP%2Flaunch.php&login_hint=2&state=07435d8efdcb8366d49834fc0900f261&nonce=07435d8efdcb8366d49834fc0900f261&prompt=none<i_message_hint=973


require_once 'config.php';

$state = bin2hex(random_bytes(5));
$nonce = bin2hex(random_bytes(5));

session_start();
$_SESSION['state'] = $state;
$_SESSION['nonce'] = $nonce;

$params = [
    'response_type' => 'id_token',
    'client_id' => CLIENT_ID,
    'redirect_uri' => REDIRECT_URI,
    'scope' => 'openid',
    'state' => $state,
    'nonce' => $nonce,
    'login_hint' => $_POST['login_hint'],
    'lti_message_hint' => $_POST['lti_message_hint']
];

$auth_url = AUTH_URL . '?' . http_build_query($params); //https://entropylearninghub.it/mod/lti/auth.php

//echo "<pre>";echo $auth_url;print_r($_POST);print_r($_GET);
header('Location: ' . $auth_url);
exit;


https://entropylearninghub.it/mod/lti/auth.php?response_type=id_token&client_id=iQrgxllo7jZ3JvD&redirect_uri=https%3A%2F%2Fecore.sgameup.com%2F_LTI1.3_TP%2Flaunch.php&scope=openid&state=0f3c1f69c8&nonce=fe95b2ae45
*/
?>

