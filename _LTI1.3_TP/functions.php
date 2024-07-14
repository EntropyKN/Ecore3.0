<?php
// JWT
$path = $_SERVER['DOCUMENT_ROOT'] . "/_lib/php-jwt-main/src/";

require_once($path . 'JWT.php');
require_once($path . 'Key.php');
require_once($path . 'JWTExceptionWithPayloadInterface.php'); 
require_once($path . 'ExpiredException.php');
require_once($path . 'SignatureInvalidException.php');
require_once($path . 'BeforeValidException.php');
// env
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// functions
function decodeToken($token){
    // Split the JWT into its parts (header, payload, signature)
    $parts = explode('.', $token);
    
    // Ensure we have exactly three parts
    if (count($parts) !== 3) {
        throw new InvalidArgumentException('Invalid token format');
    }
    
    // Extract the base64Url encoded payload
    $base64UrlPayload = $parts[1];
    
    // Decode the payload from base64Url format
    $payload = base64_decode(strtr($base64UrlPayload, '-_', '+/'), true);
    
    // Check if decoding was successful
    if ($payload === false) {
        throw new InvalidArgumentException('Failed to decode JWT payload');
    }
    
    // Convert JSON payload to associative array
    $decodedPayload = json_decode($payload, true);
    
    // Check if JSON decoding was successful
    if ($decodedPayload === null) {
        throw new InvalidArgumentException('Invalid JSON in JWT payload');
    }
    // lis_result_sourcedid json2array
    $decodedPayload["https://purl.imsglobal.org/spec/lti-bo/claim/basicoutcome"]["lis_result_sourcedid"] = json_decode($decodedPayload["https://purl.imsglobal.org/spec/lti-bo/claim/basicoutcome"]["lis_result_sourcedid"], true);
    return $decodedPayload;
}

function getKidFromToken($token){
    list($header, , ) = explode('.', $token);
    $decoded_header = json_decode(base64_decode(strtr($header, '-_', '+/')), true);
    return $decoded_header['kid'];
}




function findMembershipRole($roles) {
    
    foreach ($roles as $role) {
        if (strpos($role, 'membership') !== false) {
            
            $Rarr=explode("#", $role);
            return $Rarr[1];
        }
    }
    return null;
}




function getDataToken($id_token){
    $decodedData=decodeToken($id_token);
    return 
        array(
        //"lineitem"=>str_replace("?","/results?",$decodedData["https://purl.imsglobal.org/spec/lti-ags/claim/endpoint"]["lineitem"]),
        //"lineitem"=>$decodedData["https://purl.imsglobal.org/spec/lti-ags/claim/endpoint"]["lineitems"],
        "iss"=>$decodedData["iss"],
        "aud"=>$decodedData["aud"],
        "lineitem"=>str_replace("?","/scores?",$decodedData["https://purl.imsglobal.org/spec/lti-ags/claim/endpoint"]["lineitem"]),        
        "kid"=>getKidFromToken($id_token),
        "context_id"=>$decodedData["https://purl.imsglobal.org/spec/lti/claim/context"]["id"],
        "resource_link_id"=>$decodedData["https://purl.imsglobal.org/spec/lti/claim/resource_link"]["id"],
        "type_id"=>$decodedData["https://purl.imsglobal.org/spec/lti-bo/claim/basicoutcome"]["lis_result_sourcedid"]["data"]["typeid"],
        "userid"=>$decodedData["https://purl.imsglobal.org/spec/lti-bo/claim/basicoutcome"]["lis_result_sourcedid"]["data"]["userid"],
        "given_name"=>$decodedData["given_name"],
        "family_name"=>$decodedData["family_name"],
        "email"=>$decodedData["email"],
        "role"=>findMembershipRole($decodedData["https://purl.imsglobal.org/spec/lti/claim/roles"]),
        "lang"=>$decodedData["https://purl.imsglobal.org/spec/lti/claim/launch_presentation"]["locale"],
        "gameId"=>$decodedData["https://purl.imsglobal.org/spec/lti/claim/custom"]["id"]
        );
    /*http://purl.imsglobal.org/vocab/lis/v2/membership#Instructor
    http://purl.imsglobal.org/vocab/lis/v2/membership#Learner
    http://purl.imsglobal.org/vocab/lis/v2/membership#ContentDeveloper
    http://purl.imsglobal.org/vocab/lis/v2/membership#Manager
    http://purl.imsglobal.org/vocab/lis/v2/membership#Mentor
    http://purl.imsglobal.org/vocab/lis/v2/membership#Member
    http://purl.imsglobal.org/vocab/lis/v2/membership#Officer
    http://purl.imsglobal.org/vocab/lis/v2/membership#Owner
    http://purl.imsglobal.org/vocab/lis/v2/membership#Person
    http://purl.imsglobal.org/vocab/lis/v2/membership#Secretary
    http://purl.imsglobal.org/vocab/lis/v2/membership#Staff
    http://purl.imsglobal.org/vocab/lis/v2/membership#Student
    http://purl.imsglobal.org/vocab/lis/v2/membership#TeachingAssistant*/
}

function getTokenSendGradesToMoodle($grades100, $session){
    
    $msession=$session["moodleData"];
    if (!$msession["iss"] ||!$msession["kid"] ||!$msession["aud"]  ) return false;
    if (!$grades100) return false;
    
    // get secret
    $secretData=sql_queryt("SELECT secret from family where iss='".$msession["iss"]."'");
    if (!$secretData["secret"]  ) return false;
    $r=array(
    "iss"=>$msession["iss"],
    "kid"=>$msession["kid"],
    "client_id"=>$msession["aud"],
    "endpoint"=>$msession["lineitem"],
   // "secret"=>$secretData["secret"],  
   "grades100"=>$grades100
    );
    //renewToken($existingToken=false, $iss, $kid=false, $client_id,$secret, $returnData=false)
    $r["token"]=renewToken(false, $r["iss"], $r["kid"], $r["client_id"],$secretData["secret"], false);
    $r["sendingGrades"]=sendGradesToMoodle($r["token"], $grades100, $r["endpoint"]);
    $r["response"]=true;
    $r["message"]="Grades inviati con successo al moodle ".$msession["iss"];
    if ($r["sendingGrades"]!=200) {
        $r["response"]=false;
        $r["message"]="Invio del grades al moodle ".$msession["iss"]." non riuscito.";

        if (strtolower($dataToken["role"])!="learner") $r["message"].= " ATTENZIONE: spesso il docente che ha creato il corso non dispone delle autorizzazioni per inviare grades. La partita va giocata come Learner, non come Instructor";
    }
    return $r;
}


function renewToken($existingToken=false, $iss, $kid=false, $client_id,$secret, $returnData=false){
    if (!$iss) return "no iss";
    if (!$kid && $existingToken) $kid = getKidFromToken($existingToken);
    if (!$kid) return "no kid nor existingToken";
    if (!$client_id) return "no client_id";
    if (!$secret) return "no secret key";
    //    throw new Exception('Configurazione mancante.');
    
   // $tokenUrl = TOKEN_URL;
   $tokenUrl = $iss.'/mod/lti/token.php';
    
    
   // $client_id = CLIENT_ID;
    $privateKey = $secret;
    $aud = $tokenUrl;

    $scope = 'https://purl.imsglobal.org/spec/lti-ags/scope/score https://purl.imsglobal.org/spec/lti-ags/scope/lineitem https://purl.imsglobal.org/spec/lti-ags/scope/lineitem.readonly https://purl.imsglobal.org/spec/lti-ags/scope/result.readonly';
    $exp = time() + 60*60*10;

    $jwt_payload = array(
        'iss' => $iss,
        'sub' => $client_id,
        'aud' => $aud,
        'iat' => time(),
        'exp' => $exp,
        'jti' => bin2hex(random_bytes(16))
    );

    $jwt_header = array(
        'alg' => 'RS256',
        'typ' => 'JWT',
        'kid' => $kid
    );

    $jwt = JWT::encode($jwt_payload, $privateKey, 'RS256', null, $jwt_header);

    $postData = array(
        'grant_type' => 'client_credentials',
        'client_assertion_type' => 'urn:ietf:params:oauth:client-assertion-type:jwt-bearer',
        'client_assertion' => $jwt,
        'scope' => $scope
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $tokenUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($response === false) {
        throw new Exception('Errore nella richiesta per ottenere il nuovo token: ' . curl_error($ch));
    }

    /*if ($http_code !== 200) {
        throw new Exception('Errore HTTP nella richiesta per ottenere il nuovo token: codice ' . $http_code . ' - risposta ' . $response);
    }
    */
    $tokenData = json_decode($response, true);
    if (isset($tokenData['access_token'])) {
        if ($returnData) return $tokenData;

        return $tokenData['access_token'];
    } else {
        return ('Errore nel rinnovamento del token: nessun access token ricevuto. Risposta: ' . $response);
    }
}

function sendGradesToMoodle($token, $gradesData, $lineitem)
{

    try {
        // Costruire l'endpoint corretto
        $endpoint =$lineitem; 

        $postData = json_encode($gradesData);
        //return $postData;
        //'Content-Type: application/json'
        $headers = array(
            'Authorization: Bearer ' . $token,
            'Content-Type: application/vnd.ims.lis.v1.score+json'  //application/vnd.ims.lis.v2.lineitem+json
        
        );

        // Esempio di invio dei dati tramite POST
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Esegui la richiesta
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        
        //if ($response  && !empty($response) && $response!="[]" ) return $response;
        //else 
        return $http_code;

    } catch (Exception $e) {    
        return 'Errore durante l\'invio dei grades a Moodle: ' . $e->getMessage()." http_code:".$http_code;
    }
}
?>