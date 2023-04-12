<?php
function assign_voices_to_avatar($sex="f", $lang="it"){
    // use assign_voices_to_avatar("m", "it")
    $D=array();
    
    if ($sex=="f")      $D["sex"]="FEMALE";
    if ($sex=="m")      $D["sex"]="MALE";
    
    if ($lang=="it")    $D["lang"]="it-IT";
    if ($lang=="en")    $D["lang"]="en-GB";
    
    if (!$D["lang"] || !$D["sex"]) return $D;
    // voci disponibil per lingua e sex
    $SQ=sql_query("SELECT id,langCode, voiceName, gender FROM  TTSvoices WHERE 
    type!='Standard' AND 
    gender ='".$D["sex"]."' AND (langCode='".$D["lang"]."' /*OR langCode='en-GB'*/) ORDER BY langCode ASC, id ASC");	//
     //$D["e"]=sql_error();
    $Kstep=0;
    while (	$S=sql_assoc($SQ)	){
        $Kstep++;
        $D["v"][]=$S["id"];
    }
    // last assegnato
    $D["last"]=sql_queryt("SELECT voiceId_".$lang.", id avatarID, sex FROM  avatars WHERE id!=1000 AND sex ='".$sex."' AND voiceId_".$lang." IS NOT NULL ORDER BY `avatars`.`id` DESC");	//
    //$D["e1"]=sql_error();
    //if (!$D["last"]["voiceId_it"]) $D["last"]["voiceId_it"]=0;
    
    $D["voiceAssignIncrINDEX"]=intval(  array_search($D["last"]["voiceId_".$lang], $D["v"])                       );
    // without voice
    $AQ=sql_query("SELECT id avatarID, sex FROM  avatars WHERE id!=1000 AND sex ='".$sex."' AND 
    voiceId_".$lang." IS NULL ORDER BY `avatars`.`id` ASC");	//
    //$D["e"]=sql_error();
    
    while (	$A=sql_assoc($AQ)	){
        $D["voiceAssignIncrINDEX"]++;
        if ($D["voiceAssignIncrINDEX"]>sizeof ($D["v"])-1 ) $D["voiceAssignIncrINDEX"]=0;       
        $A["voiceAssignI"]=$D["voiceAssignIncrINDEX"];
        $A["voiceAssignID"]=$D["v"] [$A["voiceAssignI"]];
        $A["Q"]="UPDATE `avatars` SET `voiceId_".$lang."` =".$A["voiceAssignID"]." WHERE `avatars`.`id` = ".$A["avatarID"];
        sql_query($A["Q"]);
        if (sql_error()) $A["err"]=sql_error();
        
        $D["avatarWithOutVoice"][]=$A;
    }

    return $D;
}
//https://cloud.google.com/text-to-speech/docs/voices?hl=en elenco voci disponibili 
// usate: SELECT *  FROM `TTSvoices` WHERE (`langCode` = 'it-IT' or langCode='en-GB') and type!='Standard'

function getSound($text, $languageCode="it-IT", $voiceName="IT-IT-Standard-D"){        
    //$speech_api_key=API_KEY_GOOGLE_TTS;
    $text = trim($text);

    if($text == '') return false;

    $params = [
        "audioConfig"=>[
            "audioEncoding"=>"OGG_OPUS",//https://cloud.google.com/speech-to-text/docs/encoding
            //'audioEncoding'=>'MP3',
            "pitch"=> "1",
            "speakingRate"=> "1",
            /*"effectsProfileId"=> [
                "medium-bluetooth-speaker-class-device"
              ]*/
        ],
        "input"=>[
            "text"=>$text
        ],
        "voice"=>[
            "languageCode"=> $languageCode, //"it-IT", //"en-US",
            "name" =>$voiceName //"IT-IT-Standard-D", //""it-IT-Wavenet-F"  //"en-US-Wavenet-F"
        ]
    ];

    $data_string = json_encode($params);

    $url = 'https://texttospeech.googleapis.com/v1/text:synthesize?fields=audioContent&key=' . API_KEY_GOOGLE_TTS;
    $handle = curl_init($url);

    curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "POST"); 
    curl_setopt($handle, CURLOPT_POSTFIELDS, $data_string);  
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_HTTPHEADER, [                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string)
        ]                                                                       
    );
    if(curl_errno($handle)){
        return 'Request Error:' . curl_error($handle);
    }

    $response = curl_exec($handle);

    //return $response ;           
    $responseDecoded = json_decode($response, true);  
    curl_close($handle);
    if($responseDecoded['audioContent']){
        return base64_decode($responseDecoded['audioContent']);                
    }

    return false;  
}


?>