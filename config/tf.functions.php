<?php


function callAPI($url="", $since=false){
	$metod="get";
	if ($metod=="get") {
	   $curl = curl_init();
		//$url = sprintf("%s?%s", $url, http_build_query($data));
	   // OPTIONS:
	   $ptoken="C6r6HYaG5BTiGsQkMfixBktd59aXMndVB1JqCcJTzjiH";
	   //$headers[]='Authorization: Bearer '.$ptoken;
	   curl_setopt($curl, CURLOPT_URL, $url);
	  
	   
	   
		/*curl_setopt($ch, CURLOPT_HTTPHEADER, 
			array(
			 "Authorization: Bearer ".$authkey,
			)
		
		);	
	   */
	   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		  'Content-Type: application/json',
		  "Authorization: Bearer ".$ptoken,
	   ));
	   //if ($since) curl_setopt($curl, CURLOPT_HTTPHEADER, array("since",$since));
	   
	   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	
	   // EXECUTE:
	   $result = curl_exec($curl);
	   if(!$result)		return ("Connection Failure");
	   curl_close($curl);
	   ///$result["url"]=$url;
	  $obj =json_decode($result);
	  $result= object2array($obj);
	  return $result;
//	  $result= object2array($obj);
//	   return $result["response"];
	}
}

?>