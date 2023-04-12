<?php
/////////////////////////////////////////// YOUTUBE FUNCTIONS

function yt_exists($videoID) {

    $theURL = "http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=$videoID&format=json";
    $headers = get_headers($theURL);
	$headers["status"]=substr($headers[0], 9, 3);
//	echo "<pre>$videoID<br />"; 
//	print_r($headers);
//	echo "<br />$status</pre>";
//	return $status;
    if (substr($headers[0], 9, 3) !== "404"	&&	substr($headers[0], 9, 3) !== "401"		) {
		return true;
    } else {
		return false;
//		$headers["exist"]=false;
    }
//	return $headers;
}

function youtube_make_url_singlevideo($id) { // // single video RSS feed from ID
	$youtube_url_singlevideo="http://gdata.youtube.com/feeds/videos/$id";
	return 	$youtube_url_singlevideo;		
}

function is_youtube_video($url) {  
	$is_yt=false;
	// yt longer url
	if    (     ( strpos(strtolower($url), strtolower("youtube.com")) ===false)  ||   ( strpos(strtolower($url), strtolower("v=")) ===false) ||  ( strpos(strtolower($url), strtolower("/watch?")) ===false)    ){ 
		$is_yt=false;
	}else {	
		$is_yt=true;	
	};
	
	if (!$is_yt) { // yt shorter url ex http://youtu.be/2IrYYzmrPac
		$url=strtolower($url);
		if ((substr($url,0, 7)!="http://") &&	(substr($url,0, 8)!="https://")) $url="http://".$url;
		$url_temparray=explode("/", $url);	
		if    ( ( $url_temparray[2]=="youtu.be") || ( $url_temparray[2]=="www.youtu.be") ) {
			if   (   ( $url_temparray[3])  && (!$url_temparray[4])  ){
				$is_yt=true;
			}
		}
	}
	
	return $is_yt;
	
}


function yt_url2id ($url) { // prende l'url e restituisce il solo id
	if    (     ( strpos(strtolower($url), strtolower("youtube.com")) ===false)  ||   ( strpos(strtolower($url), strtolower("v=")) ===false) &&  ( strpos(strtolower($url), strtolower("/watch?")) ===false)    ){ 
		$id="";
	}else {
		$idarr=explode("v=", $url); 		// esplosione in base "v="	
		$id=$idarr[1];
		$idarr=explode("&", $id);		// esplosione in base "&"			
		$id=$idarr[0];	
	}
	
	if (!$id) { // yt shorter url ex http://youtu.be/2IrYYzmrPac https://youtu.be/2IrYYzmrPac
		//$url=strtolower($url);
		if ((substr(strtolower($url),0, 7)!="http://")&& (substr(strtolower($url),0, 8)!="https://")) $url="http://".$url;
		$url_temparray=explode("/", $url);	
		if    ( ( strtolower($url_temparray[2])=="youtu.be") || ( strtolower($url_temparray[2])=="www.youtu.be") ) {
			if   (   ( $url_temparray[3])  && (!$url_temparray[4])  ){
				$id=$url_temparray[3];
			}
		}
	}
	
	return $id;
}
function youtube_get_image_from_id($id,$level="0") {
	return C_PROTOCAL."://img.youtube.com/vi/".$id."/".$level.".jpg";
	//http://img.youtube.com/vi/qeAStUlesto/maxresdefault.jpg
}
function yt_single_video_data($id,$level=1) { // OBSOLETE
	$matrice=object2array(simplexml_load_file(youtube_make_url_singlevideo($id)));
	if (is_array($matrice)) {
		 $youtube_data["id"]=$id;
		 $youtube_data["title"]=$matrice["title"];
		 $youtube_data["image"]="http://img.youtube.com/vi/".$id."/".$level.".jpg";
		 $youtube_data["authorname"]=$matrice["author"]["name"];
		 $youtube_data["content"]=$matrice["content"];
		 // time
		$temp_array=explode("Time:", strip_tags( $youtube_data["content"]));
		$youtube_data["time"]=substr(trim($temp_array[1]), 0,5); 
		// description
		$temp_array=explode("<div style=\"font-size: 12px; margin: 3px 0px;\"><span>", $youtube_data["content"]);
		$temp_array1=explode("</span>", $temp_array[1]);
		$youtube_data["description"]=strip_tags(trim($temp_array1[0]));
			 
	}
	if (isset($youtube_data)) {
		return $youtube_data;	
	}else{	
		return false; // ID VIDEO Not Valid
	}
}

function yt_single_video_datawide($id) {
	$matrice=object2array(simplexml_load_file("http://gdata.youtube.com/feeds/videos/".$id));
	return $matrice;
}

function get_youtube_in_string($string) {
	// get the FIRST youtube video id from a string
	$string=trim($string);
	if (!$string) return false;
	$resp=false;
	if (preg_match('/youtube\.com\/watch\?v=(.*)/',($string)." ", $matches) ) {
		//echo "<pre><strong>FOUND YOUTUBE</strong>";
		//print_r($matches);
		$resp=strip_tags(punctuation2space_light($matches[1]));		
		$yutu_arr=explode(" ", $resp);
		$resp=$yutu_arr[0];
		//echo "</pre>";
	}
	
	if ( (preg_match('/youtube\.be\/(.*)/', $string." ", $matches) )  && (!$resp ) ) {
		$resp=strip_tags(punctuation2space_light($matches[1]));	
		$yutu_arr=explode(" ", $resp);
		$resp=$yutu_arr[0];															   
	}
	return $resp;	
}

////
function yt_create_embed($url,$width = '640',$height = '385',$autoplay=1, $iddiv="") {
	//$url = 'http://www.youtube.com/watch?v=fHBFvlQ3JGY';
	if ((substr($url,0,4)!="http"		) && (substr($url,0,5)!="https"		)) $url=C_PROTOCAL."://www.youtube.com/watch?v=". $url;
	$id=yt_url2id($url);
	
	$code='<iframe width="'.$width.'" ';
	if ($iddiv) $code.=' id="'.$iddiv.'" ';
	if ($height) $code.=' height="'.$height.'" ';
	$code.='src="https://www.youtube.com/embed/'.$id;
	if ($autoplay) $code.='?autoplay='.$autoplay;
	
	$code.='" frameborder="0" allowfullscreen></iframe>';
	//$code= '<object width="' . $width . '" height="' . $height . '"><param name="movie" value="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="' . $width . '" height="' . $height . '"></embed></object>';
	return $code;
}


/////////////////////////////////////////// END YOUTUBE FUNCTIONS
?>