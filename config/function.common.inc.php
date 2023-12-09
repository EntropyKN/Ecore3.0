<?php
function conni($DB = ""){
	
	$Sql['Host'] = "localhost";
	$Sql['Username'] = "psgameur_storyga";
	$Sql['Password'] =  'Qf{%tKf2*Hl+';
	$Sql['DB'] = "psgameur_ecore";

	$conni=mysqli_connect($Sql["Host"],$Sql["Username"],$Sql["Password"]) or die("impossibile connettersi al database :-(");


	mysqli_select_db($conni,$Sql["DB"]);	
	mysqli_set_charset($conni, 'utf8');
	return $conni;
	//$GLOBALS["isConnect"] = true;
}
function sql_fetch_array($s){
	global $conni;
	return sql_fetch_array($conni,  $s);
};
function sql_affected_rows($s){
	global $conni;
	return mysql_affected_rows($conni,  $s);
};

function sql_query($s){
	global $conni;
	return mysqli_query($conni,  $s);
};

function sql_assoc($q){
	global $conni;
	return mysqli_fetch_assoc(	$q	);
};
function sql_fetch_assoc($q){
	global $conni;
	return sql_assoc(	$q	);
};


function sql_queryt($s){
	global $conni;
	return @mysqli_fetch_assoc(mysqli_query($conni,  $s));
};
function sql_error(){
	global $conni;
	return mysqli_error($conni);
};

function sql_id(){
	global $conni;
	return mysqli_insert_id($conni);
};

function sql_num_rows($q){
	global $conni;
	return mysqli_num_rows($q);
};


function db_string($string) {
	//$string=stripslashes($string);$string=stripslashes($string);
    $string=str_replace("\\", "\\\\",$string); // \=\\ math
	$string=str_replace("'","''",$string);
	$string=db_safe_value($string);
	return $string;
}
function db_safe_value($string) {
	$evil=array(
	'CREATE'
	,'DATABASE'
	,'CREATE' 
	,'TABLE'
	,'LOAD'
	,'ALTER'
	,'INSERT'
	,'REPLACE'
	,'UPDATE'
	,'SELECT'
	,'DELETE'
	,'UNION'
	,'FLUSH'
	,'CREATE'
	,'REVOKE'
	,'KILL'
	,'RENAME'
	,'PASSWORD'
	,'SHOW'
	,'START' 
	,'TRUNCATE'
	,'USE'
	,'%'
	,'='
	,'>'
	,'<'
	,'!='
	,'LIKE'	
	);
	return @str_ireplace($evil." ", "", $string);
}

function dbnoslash_string($string) {
	$string=stripslashes($string);
	$string=stripcslashes($string);	
	return str_replace("'","''",$string);
}
function generate_code_filesafe($length=16){
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));
    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }
    return $key;
}

function object2array($object){
   $return = NULL;
  // return $return; 
   if(is_array($object))   {
       foreach($object as $key => $value)
           $return[$key] = object2array($value);
   }else{
       $var = @get_object_vars($object);          
       if($var){
           foreach($var as $key => $value)
               $return[$key] = object2array($value);
       }
       else
           return $object; 
   }
   return $return;
}


function make_urlable($str){ 
		$str=trim($str);
		//$str=utf8_decode($str);	
		
	$table = array(
		'#'=>'','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 
		'È'=>'E', 'É'=>'E','Ê'=>'E', 'Ë'=>'E', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 
		'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i','Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I',		
		'ð'=>'o',  'ò'=>'o', 'ó'=>'o','Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O','Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 
		'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 		
		'Š'=>'S', 'š'=>'s', 'Ð'=>'D', 'd'=>'d', 'Ž'=>'Z', 'ž'=>'z', 'C'=>'C', 'c'=>'c', 'C'=>'C', 'c'=>'c',		
		'Ç'=>'C', 'ç'=>'c','Ñ'=>'N', 'ñ'=>'n','Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
		'ý'=>'y', 'ý'=>'y', 'þ'=>'b',':'=>'_',
		'ÿ'=>'y', 'R'=>'R', 'r'=>'r', 
		' '=>'_', "'"=>'_', '/'=>'_', '-'=>'_', '.'=>'_' 
	);   

	//$table_utf = array('table'=>array_map("utf8_encode",$table));
	//$table_noutf = array('table'=>array_map("utf8_decode",$table));
	$str = strtr($str, $table);
	//$str = strtr($str, $table_utf);
	//$str = strtr($str, $table_noutf);			
	// get rid of any remaining unwanted characters
	$str =  @preg_replace("[^A-Za-z0-9/-/_]", "", $str);	
	// remove repeated underscores
	$str = preg_replace('/[_]+/', '_', $str);
	$str=trim($str, "_");
	return strtolower($str);
}
function getRealIpAddr(){
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function generate_auth_code($FORMAT="4alpahanumeric") {
	if ($FORMAT=="5numeric") {
	
		$rand=rand(1, 99999);
		if ($rand<10) $rand="0000". $rand;
		if ($rand<100) $rand="000". $rand;
		if ($rand<1000) $rand="00". $rand;
		if ($rand<10000) $rand="0". $rand;
		return $rand;
	}
	
	if ($FORMAT=="4numeric") {
	
		$rand=rand(1, 9999);
		if ($rand<10) $rand="000". $rand;
		if ($rand<100) $rand="00". $rand;
		if ($rand<1000) $rand="0". $rand;
		//if ($rand<10000) $rand="0". $rand;
		return $rand;
	}	
	
	if ($FORMAT=="4numeric")	 		$length=4;
	if ($FORMAT=="4alpahanumeric") $length=4;
	if ($FORMAT=="5alpahanumeric") $length=5;
	if ($FORMAT=="6alpahanumeric") $length=6;
	if ($FORMAT=="10alpahanumeric") $length=10;	
	$key = '';
	$keys = array_merge(range(0, 9), range('a', 'z'));

	for ($i = 0; $i < $length; $i++) {
		$key .= $keys[array_rand($keys)];
	}
	$key=strtolower($key);
	return $key;

}


function userWriteUniqueCode($uid){
	if (!$uid || !is_numeric($uid)) return;
	global $conni;
	$c=sql_queryt("SELECT uid, code FROM user WHERE uid=".$uid);
//	$ret="ciao".print_r($c,true).mysql_error();
	if (!$c["uid"] || $c["code"] ) return false;

	$code=(generate_auth_code());sql_query("UPDATE user SET code = $code WHERE uid=".$uid);
	if (sql_error()){
		for ($f = 0; $f< 20; $f++) {
			$code=(generate_auth_code());sql_query("UPDATE user SET code = '$code' WHERE uid=".$uid);
			if (!sql_error()) {
				break;
//				return "**caso ".$code;
			}
		}
	}
	return "".$code.sql_error();	
}


function text_cut($text, $length = 200, $dots = true, $dotsprint="...") {
    $text = trim(preg_replace('#[\s\n\r\t]{2,}#', ' ', $text));
    $text_temp = $text;
    while (substr($text, $length, 1) != " ") { $length++; if ($length > strlen($text)) { break; } }
    $text = substr($text, 0, $length);

	$text=rtrim($text,",");$text=rtrim($text,",");$text=rtrim($text,":");$text=rtrim($text,";");$text=rtrim($text,".");
    
	
	return $text . ( ( $dots == true && $text != '' && strlen($text_temp) > $length ) ? $dotsprint : ''); 
}
function Cut_str($String, $Len, $Cut = "..."){
	if (	strlen($String) > $Len	) {
		return  trim(mb_substr($String,0,$Len, 'UTF-8'	))	.$Cut;
	}else{
		return trim($String);
	}
//	return $returnStr;
}

/*function Cut_str($String, $Len, $Cut = "..."){
	return (strlen($String) > $Len) ? trim(		trim(mb_substr($String,0,$Len))	.$Cut) : trim($String);
}
*/

function UC_first($String){
	return ucwords(strtolower($String));
}
function onlyFirstCapital($s){
	return ucfirst(strtolower($s));
}
////////

function br2newline( $input ) {
     $out = str_replace( "<br>"," \n", $input );
     $out = str_replace( "<br/>"," \n", $out );
     $out = str_replace( "<br />"," \n", $out );
     $out = str_replace( "<BR>"," \n", $out );
     $out = str_replace( "<BR/>"," \n", $out );
     $out = str_replace( "<BR />"," \n", $out );
     return $out;
}

####################################### product

function euroFormat($N) {
	return @number_format($N, 2, ',', '.'); 
}
function euroFormatDot($N) {
	return @number_format($N, 2, '.', ''); 
}
function euroFormatSmart($N) {
	//0,00
	if (!$N) return "-";
	$N=@number_format($N, 2, ',', '.'); 
	
	$N=str_replace(",00","",$N);
	return $N;
}

function format00($N) {
	return number_format((float)$N, 2, '.', '');
}
function format000($N) {
	return @number_format($N , 0, ',', '.');
}

function noNl($str){
	return @preg_replace('/\s\s+/', ' ', $str);
}


function scoreFormatPrize($score){
//	return number_format($score, 0, '', '˙');
	$ret=number_format($score, 2, ',', '˙'); 
	$ret=str_replace(",00","", $ret);
	return $ret; 
}
function scoreFormatUsr($score){
	$ret=number_format($score, 2, ',', '˙'); 
	$ret=str_replace(",00","", $ret);
	return $ret; 
	//number_format($score, 0, '', '˙');
}

/*
function ContainsNumbers($String){
    return preg_match('/\\d/', $String) > 0;
}
*/
function addressDepure($address){
	// works with google generated address only
	$address=trim( 
	trim(str_ireplace("italia","", $address))
	, ","
	);
	/*$storeArr=explode(" ", $address);
	$main=$storeArr[		sizeof($storeArr)-2					];
	
	if (!ContainsNumbers($storeArr[		sizeof($storeArr)-3					]))  {
		$main=$storeArr[		sizeof($storeArr)-3					]." ".$main;
		if (!ContainsNumbers($storeArr[		sizeof($storeArr)-4					]))  {
			$main=$storeArr[		sizeof($storeArr)-4					]." ".$main;
			if (!ContainsNumbers($storeArr[		sizeof($storeArr)-5					]))
				$main=$storeArr[		sizeof($storeArr)-5					]." ".$main; 
		}
	}
	*/
	return $address;
}


function orderArray(&$array, $subkey="id", $sort_ascending=true) {
	 if (!count($array)) return $array;
	 
    if (count($array))
        $temp_array[key($array)] = array_shift($array);

    foreach($array as $key => $val){
        $offset = 0;
        $found = false;
        foreach($temp_array as $tmp_key => $tmp_val)
        {
            if(!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey]))
            {
                $temp_array = array_merge(    (array)array_slice($temp_array,0,$offset),
                                            array($key => $val),
                                            array_slice($temp_array,$offset)
                                          );
                $found = true;
            }
            $offset++;
        }
        if(!$found) $temp_array = array_merge($temp_array, array($key => $val));
    }

    if ($sort_ascending) $array = array_reverse($temp_array);

    else $array = $temp_array;
}

function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}


function multiArrSearch($arr, $field, $value){
   foreach($arr as $key => $product){
      if ( $product[$field] === $value )
         return $key;
   }
   return false;
}


function validEmail($email){
 return (preg_match("/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/", $email) || !preg_match("/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/", $email)) ? false : true;
}

function remove_hashtags($string){
    return preg_replace('/#(?=[\w-]+)/', '', 
        preg_replace('/(?:#[\w-]+\s*)+$/', '', $string));
}
function remove_repeated_spaces($s){
	return preg_replace('/\s+/', ' ',$s);
}

function remove_html($s){
	$regex = '/<[^>]*>[^<]*<[^>]*>/';
	$SS=preg_replace($regex, '', $s);
	return remove_repeated_spaces($SS);
}

function isAllUpperCase($string) {
	if(preg_match("/[A-Z]/", $string)===0) {
		return true;
	}
	return false;
}

function timestamp2red($ts, $mode="long", $lang=LANG){
	$dwit[0]="Domenica";$dwit[1]="Lunedì";$dwit[2]="Martedì";$dwit[3]="Mercoledì";$dwit[4]="Giovedì";$dwit[5]="Venerdì";$dwit[6]="Sabato";
	$monthT2[1]="gennaio";
	$monthT2[2]="febbraio";
	$monthT2[3]="marzo";
	$monthT2[4]="aprile";
	$monthT2[5]="maggio";
	$monthT2[6]="giugno";
	$monthT2[7]="luglio";
	$monthT2[8]="agosto";
	$monthT2[9]="settembre";
	$monthT2[10]="ottobre";
	$monthT2[11]="novembre";
	$monthT2[12]="dicembre";
	if ($mode=="servicebook") 	$mode="longday";
	if ($mode=="roombook") 	$mode="notimeweekday";

	if ($lang!="en" && $lang!="it") $lang="it";
	if ($lang=="it") {
		if ($mode=="mesesteso") {
			$date=date("j",$ts)." ".$monthT2[date("n",$ts)];
			if (	date("y")!=date("y",$ts) ) $date.=" '".date("y",$ts);
			return $date;//date("y",$ts);		
		}		
		if ($mode=="brieftime") {
			if (	date("y")==@date("y",$ts) ) 	return @date("d/m",$ts)." ".@date("H:i",$ts);
			return @date("d/m/y",$ts)." ".@date("H:i",$ts);
		}		
		
		if ($mode=="long" ||$mode== "longday") 		{
			$dayw="";
			if ($mode=="longday")  $dayw="".$dwit[date('w', $ts)]." ";
			if (	date("y")==@date("y",$ts) ) {
				$returndate=$dayw.date("d/m",$ts)." alle ".@date("H:i",$ts); 
				$returndate=str_replace("alle 00:00", "a mezzanotte", $returndate);
				return $returndate;
			}
			$returndate=$dayw.date("d/m/y",$ts)." alle ".@date("H:i",$ts);
			$returndate=str_replace("alle 00:00", "a mezzanotte", $returndate);
			return $returndate; 
		}
		if ($mode=="notimeweekday")  {
			$dayw="".$dwit[@date('w', $ts)]." ";
			if (	date("y")==@date("y",$ts) ) return $dayw.date("d/m",$ts); 
			return $dayw.@date("d/m/y",$ts);			
		}
		
		if ($mode=="verylong") 	return @date("d/m/y",$ts)." alle ".@date("H:i:s",$ts); 
		
		if ($mode=="brief") {
			if (	date("y")==@date("y",$ts) ) 	return @date("d/m",$ts);
			return @date("d/m/y",$ts);		
		}
		if ($mode=="briefx"||$mode=="it") 
			return @date("d/m/Y",$ts);	
		if ($mode=="briefx"||$mode=="its") 		return @date("d/m/y",$ts);	
		
		if ($mode=="briefMonth") {
			$abbreviation="th";

			if (	date("y")==@date("y",$ts) ) {
				$date=@date("F j/",$ts);
			}else{
				$date=@date("F j/ y",$ts);
			}
			return str_replace("/", $abbreviation, $date);
			
		}
		if ($mode=="longNoTime") return @date("d/m/y",$ts);
	}
	////////////////////////////////////////////////////////////////////////////
	if ($lang=="en") {
		if ($mode=="long" || $mode=="longday") 	{
			if (	date("y")==@date("y",$ts) ) return @date("F j",$ts)." at ".@date("H:i",$ts); 
			$returndate=@date("m/d/y",$ts)." at ".@date("H:i",$ts); 
			$returndate=str_replace("at 00:00", "at midnight", $returndate);
			return $returndate;
		}
		
			

		
		if ($mode=="verylong") 	return @date("m/d/y",$ts)." at ".@date("H:i:s",$ts); 
		if ($mode=="brieftime") {
			if (	date("y")==@date("y",$ts) ) 	return @date("m/d",$ts)." ".@date("H:i",$ts);
			return @date("m/d/y",$ts)." ".@date("H:i",$ts);
		}		
		
		if ($mode=="brief") {
			if (	date("y")==@date("y",$ts) ) 	return @date("m/d",$ts);
			return @date("m/d/y",$ts);		
		}
		if ($mode=="briefx"||$mode=="it") 
			return @date("m/d/Y",$ts);	
		if ($mode=="briefx"||$mode=="its") 		return @date("m/d/y",$ts);	
		
		if ($mode=="briefMonth") {
			$abbreviation="th";
			if (	date("y")==@date("y",$ts) ) {
				$date=@date("F j/",$ts);
			}else{
				$date=@date("F j/ y",$ts);
			}
			$date=str_replace("/", $abbreviation, $date);
			$date=str_replace("at 00:00", "at midnight", $date);
			return $date;
			
		}
		if ($mode=="longNoTime") return @date("m/d/y",$ts);
		if ($mode=="notimeweekday")  {
			$dayw="".$dwit[date('w', $ts)]." ";
			if (	date("y")==@date("y",$ts) ) return $dayw.date("m/d",$ts); 
			return $dayw.date("m/d/y",$ts);			
		}		
		
		
	}


}
function timestamp2it($ts, $mode="long"){
	if ($mode=="long") 		return @date("d/m/y",$ts)." ".@date("H:i",$ts); 
	if ($mode=="verylong") 	return @date("D d/m/y",$ts)." ".@date("H:i:s",$ts); 
	if ($mode=="justdate") 	return @date("d/m/y",$ts);; 
	if ($mode=="-") 	return @date("d-m-Y",$ts); 
	
	if ($mode=="official") 	return "".@date("d/m/Y",$ts);	

	
	if ($mode=="brief") {
		if (	date("y")==@date("y",$ts) ) 	return @date("d/m",$ts);
		return @date("d/m/y",$ts);		
	}
	if ($mode=="brieftime") {
		if (	date("y")==@date("y",$ts) ) 	return @date("d/m",$ts)." ".@date("H:i",$ts);
		return @date("d/m/y",$ts)." ".@date("H:i",$ts);		
	}

	
	if ($mode=="briefx"||$mode=="it") 
		return @date("d/m/Y",$ts);	
	if ($mode=="briefx"||$mode=="its") 		return @date("d/m/y",$ts);	
	
	if ($mode=="briefMonth") {
		$abbreviation="th";
		/*if (date("j",$ts)=="1") 		$abbreviation="st";
		if (date("j",$ts)=="2") 		$abbreviation="nd";
		if (date("j",$ts)=="3") 		$abbreviation="rd";*/
		if (	date("y")==@date("y",$ts) ) {
			$date=@date("F j/",$ts);
		}else{
			$date=@date("F j/ y",$ts);
		}
		return str_replace("/", $abbreviation, $date);
		
	}
	if ($mode=="longNoTime") return @date("d/m/y",$ts);
}

function validateDate($date, $format = 'Y-m-d'){	//validateDate('2013-12-01')
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

function timestamp2db($ts, $mode=false){
	if ($mode=="long")	return date("Y-m-d H:i:s",$ts);
	return date("Y-m-d",$ts);
}
function timestamp2ukTime($ts){	
	return date("Y/m/d G:i",$ts); //g:i a
}
function dateIT2dateDb($dateIT){ // 13-02-1969
	$dateA=explode("/", $dateIT);
	$dateDB=$dateA[2]."-".$dateA[1]."-".$dateA[0];
	return $dateDB;
}

function dateDB2dateIT($dateDB){ //2015-02-13
	$dateA=explode("-", $dateDB);
	$dateIT=$dateA[2]."/".$dateA[1]."/".$dateA[0];
	return $dateIT;
}
function dateDB2timestamp($dateDB){
	return strtotime($dateDB);
}
function debugWrite($debugContent,$destinationString){
	return str_replace("<!-- debugDelimiter-->",$debugContent."<!-- debugDelimiter-->",$destinationString);
}
/*			*/


function arrayHasOnlyInts($array){
	$test = implode('',$array);
	return is_numeric($test);
}

function user_img_path($idu, $sex='male',$dim=300 ){		//user_img_path($G["user"]["firebaseUid"],$G["user"]["sex"]);
	$sex=strtolower($sex);
	if(!($idu)) return NULL;
	define ("C_IMG_USER_DIR_ROOT","/var/www/html/www/imgc/user/");
	
	define ("C_IMG_USER_DIR_URL", "https://yousho.it/imgc/user/");
	$PRE="";// normal
	//$PATH=C_IMG_USER_DIR_ROOT.$idu."_".$dim.".jpg";
	$PATH=C_IMG_USER_DIR_ROOT.$idu.".jpg";
	//$PATH=C_IMG_USER_DIR_URL.$idu.".jpg";
	if  (file_exists	($PATH)	)	{
		return C_IMG_USER_DIR_URL.$idu.".jpg";
	}else{
		return C_IMG_USER_DIR_URL."default_".$sex."_".$dim.".jpg";
	}
//	return false;
}

function user_img($dim=300,$uid=false,  $class="imgusr", $id=false, $html=true, $sexg=false){
	if (!$class) $class="imgusr";
	$sex="m"; 
	if (!$sexg) $sex="m"; 
	if ($sexg=="female") $sex="f";
	$img="/cpimg/avatars/".$sex.$dim.".png";
	/*if ($uid==0){
		if ($html) { 
			$imghtml='<img src="'.$img.'"' ;
			$imghtml.='  class="'.$class.'"' ;
			if ($id) $imghtml.='  id="'.$id.'"' ;
			$imghtml.=' />' ;
			return $imghtml;
		}		
		return $img;		
	}
	*/
	
	if (!$uid || $uid==$_SESSION["uid"] ) {
		$uid=$_SESSION["uid"];
	
		if (!$_SESSION["img_user"]){
			
			if ($_SESSION["sex"]=="female") $sex="f";
			$img="/cpimg/avatars/".$sex.$dim.".png";
		
			
			if ($_SESSION["uid"] && $_SESSION["avatar"]) {
				$img="/data/avatars/".$_SESSION["uid"]."_".$dim.".png";
			}
		}else{
			$img=str_replace("_200.jpg?", "_".$dim.".jpg?",$_SESSION["img_user"]);
		}
	}else{
		
		$root=$_SERVER['DOCUMENT_ROOT'];
		$fileR="/data/user_img/".$uid."_".$dim.".jpg";
		$img="/cpimg/avatars/".$sex.$dim.".png?--".$root.$fileR;
		if (file_exists($root.$fileR) ) {
			$img=$fileR;
		}else{// pick gender
			$img="/cpimg/avatars/".$sex.$dim.".png?";//.$sex." ".$sexg
			if (!$sexg) {
				$str="select sex FROM users U WHERE U.users_id=$uid AND U.status!='deleted'";
				//$dd=mysql_fetch_assoc(mysql_query($str));
				$sex="m"; if ($dd["sex"]=="female") $sex="f";
				$img="/cpimg/avatars/".$sex.$dim.".png?"; //-DB-.$str." sex:".$sex." sg ".$sexg
			}
			
		}
	}
	
	
	
	
	if ($html) { 
		$imghtml='<img src="'.$img.'"' ;
		$imghtml.='  class="'.$class.'"' ;
		if ($id) $imghtml.='  id="'.$id.'"' ;
		$imghtml.=' />' ;
		return $imghtml;
	}
	return $img;
	
}

function utrackingGameEditor($gameId, $step, $action, $data="") {
	if (!$uid) $uid=$_SESSION["uid"];
	if (!$data) $data="";
	
	return utracking( array(
			"action"=> "gameEditing",
			"idu"=>$uid,
			"actionSecondary"=>$action,
			"gameId"=>$gameId,
			"step"=>$step,
			"data"=>$data,
		)	
		);
	
}

function utracking($tracker) {
/*
array(
		"action"=>"login",
		"idu"=>15,
		"gameId"=>15,
		"step"=>15,
		
		"idu2"=>15,

		"actionSecondary"=>"action secondary",
		"data"=>"data v aiereiaskdjlas k",
	)	;
*/	
	/*utracking(array(
		"action"=>"login",
		"idu"=>15,
		"idu2"=>15,
		"uidAction"=>15,
		"actionSecondary"=>"action secondary",
		"data"=>"data v aiereiaskdjlas k",
	)) ;*/
	if (!isset($tracker) || empty($tracker)  ) return "EMPTY";
	 if (!$tracker["idu"]) $tracker["idu"]=$_SESSION["uid"];
	//if (!$tracker["action"]) $tracker["action"]=$tracker["method"];
	if (!$tracker["action"]) return "NOACTION";

	
	$tracker["timestamp"]=C_TIME;
	$tracker["ip"]=getRealIpAddr();
	$tracker["device_type"]=$_SERVER['HTTP_USER_AGENT'];
	
	$FIELDS.="";
	$VALUES="";
	foreach ($tracker as $key => $value) {
		$FIELDS.="$key,\n";
		$VALUES.="'".db_string($value)."',\n";
	}	
	$qstrIP="INSERT INTO user_tracking (".trim($FIELDS, ",\n").") VALUES (".trim($VALUES, ",\n").")";	

	sql_query($qstrIP);
	if (sql_error()) {
		return $qstrIP." ".sql_error();
	}else{
		return $qstrIP;
	}
}
###############
function responsesData($page=1, $command=false, $whereC=false, $how_many=100) {
//	global $conni;
	$R['s']["page"]=$page;
	$R['s']["command"]=$command;
	$R['s']["how_many"]=$how_many;
	$R['s']["query"]=false;

	$R['s']["res_from"]=$R['s']["how_many"]*($R['s']["page"]-1);	
	$R['s']["LIMIT"]= " /*L*/ LIMIT ".$R['s']["res_from"].",".$R['s']["how_many"];	
	
	$R['s']["where"]="1";
	if ($whereC) $R['s']["where"].=" AND $whereC ";
	//  Testi completi 	idabuse 	idcomment 	uid 	ts 	uidip 	status 	last_decision_ts 	uid_moderator 	deletedTs 
	$R['s']["query"]="SELECT *		FROM responses 	WHERE ".$R['s']["where"];
	
	$R['s']["query"].=" ORDER BY submitted_at DESC ";
	$R['s']["query"].=$R['s']["LIMIT"];	
//	 group by a.idabuse

	/// total results
	$q=@sql_query($R['s']["query"]);
	if (	sql_error()	) 	{$R['s']["error"]=sql_error().$str;return $R;}	
	$R['O']["totalresults"]=@sql_num_rows($q);	
	
	$q=@sql_query($R['s']["query"]);
	if (	sql_error()	) 	{$R['s']["error"]=sql_error().$str;return $R;}
	
	$R['O']["results"]=@sql_num_rows($q);
	if (!$R['O']["results"]) return $R;	// no results
	
	$R['O']["nexPageExist"]=true;
	if ($R['O']["results"]<$R['s']["how_many"]) $R['O']["nexPageExist"]=false;

	$i=0;
	while (	$d=sql_fetch_assoc($q)) {
		
/*
    $tmp["technical_intervalID"] => 5
    [creative_intervalID] => 10
    [critical_intervalID] => 16
    [collaborative_intervalID] => 21
    [motivational_intervalID] => 26
    [digital_knowledge_intervalID] => 31
    [total_intervalID] => 36
*/		
		
		
		unset ($d["meta"]);
		$d["name"]=UC_first($d["name"]);
		if (!$d["name"]) $d["name"]=L_anonymous;
		$R['d'][$i]=$d;
		$i++;
	}

	if ($command=="landing_id") {
		$tmp=$R["d"][0];
		$R["d"][0]["datac"]=array();
		$R["d"][0]["commentsQ"]="SELECT idr, area, comment, qualitativeComment	FROM area_scoreInterval  WHERE idr IN 
		(
		".$tmp["technical_intervalID"].",
		".$tmp["creative_intervalID"].",
		".$tmp["critical_intervalID"].",
		".$tmp["collaborative_intervalID"].",
		".$tmp["motivational_intervalID"].",
		".$tmp["digital_knowledge_intervalID"].",
		".$tmp["total_intervalID"]."
		)";
		$q1=sql_query($R["d"][0]["commentsQ"]);
		if (	sql_error()	) $R["d"][0]["commentsQE"]=sql_error()	;
		while (	$dd=sql_fetch_assoc($q1)) {
			//$R["d"][0]["datac"][$dd["idr"]]	=$dd;
			$R["d"][0]["datac"][$dd["area"]]	=$dd;
			unset (		$R["d"][0]["datac"][$dd["idr"]]["idr"]		);
		}
		unset (		$R["d"][0]["commentsQ"]	);
	}


	return $R;
}
function var2js($str){
	$str=str_replace("'", "\'", $str);
	return $str;
}

############################### community

function loggedIn($idu=false, $DEBUG=false) {
	if (!$_SESSION["uid"]) return false;
	return true;
}

#################################### game
function isHomogenous($arr) {
    $someValue = current($arr);
    foreach ($arr as $val) {
        if ($someValue !== $val) {
            return false;
        }
    }
    return true;
}
function gameIntervalCalc($gameId){
	$str="SELECT step, 
	answer_1, answer_2, answer_3, answer_4, 
	ascore_1,ascore_2,ascore_3, ascore_4 FROM games_steps WHERE gameId =$gameId and type IS NULL order by step ASC";
	$Q=sql_query($str);
	$D=array(
	"response"=>1,
	"reason"=>"",
	"max"=>0,
	"min"=>0,
	"report"=>"",
	);

	if (sql_error()) return sql_error();
	require_once(C_ROOT."/config/lang.inc.php");
	while (	$S=sql_assoc($Q)	){
		$S=array_map("trim", $S);
		if (	!$S["answer_1"] || !$S["answer_2"] || !$S["answer_3"]  ){
			$D["response"]=0;
			$D["reason"]=L_step." ".$S["step"].": ".L_the_first_three_answers_are_mandatory; //
			return $D;
		}
		if (!$S["answer_3"]	 && $S["answer_4"]			){	// c'e' la quattro ma non la tre
			$D["response"]=0;
			$D["reason"]=L_step." ".$S["step"].": ".L_you_cannot_use_question_4_without_using_question_3; // cannot use question 4 without use question 3
			return $D;	
		}
		$S["questNumb"]=3;
		if ($S["answer_4"]) $S["questNumb"]=4;
		unset ($S["answer_1"],$S["answer_2"],$S["answer_3"],$S["answer_4"]);
		
		/*if ($D["response"]) {
			for ($s = 1; $s<=4; $s++) {				
				if (!is_numeric($S["ascore_".$s])) {
					$D["response"]=0;
					$D["reason"]=L_missing.": ".L_step." ".$S["step"]." ".L_questions_score." ".$s;
				}
			}
		}
		*/
		$D["d"][]=$S;
	}
	// verifica score not null  
	if ($D["response"]	&& $D["d"]) {
	 foreach($D["d"] as $K => $V){
		for ($s = 1; $s<=$V["questNumb"]; $s++) {				
			if (!is_numeric($V["ascore_".$s])) {

				$D["response"]=0;
				$D["reason"]=L_missing.": ".L_step." ".$V["step"]." ".L_questions_score." ".$s;
				return $D;
			}else{
				$D["d"][$K]["values"][]=$V["ascore_".$s];
			}
		}		 
	 }}else{
		 return $D;
	 }

	// max
	foreach($D["d"] as $K => $V){
		if (isHomogenous($V["values"] )){
			$D["response"]=0;
			$D["reason"]=L_step." ".$V["step"]." ".L_answers_have_the_same_score	;	//
			return $D;	
		}
		/*if (array_unique ($V["values"]) !=$V["values"] ) {
			$D["response"]=0;
			$D["reason"]=L_step." ".$V["step"]." ".L_some_questions_have_the_same_score	;	//
			return $D;			
		}
		*/
		
		$D["d"][$K]["max"]=max($V["values"]);
		$D["max"]+=$D["d"][$K]["max"];
		$D["d"][$K]["min"]=min($V["values"]);
		$D["min"]+=$D["d"][$K]["min"];		
	}
	
/*		INTERVALLI


										50%
				losing area			 |			winning area
										 |
		|_L4_|_L3_|_L2_|_L1_||_W1_|_W2_|_W3_|_W4_|
		
		
*/	
	$pass=100/8;
	$D["Ip"]=array(
	0,1*$pass,		2*$pass,	3*$pass,		4*$pass
	,	5*$pass,	6*$pass,	7*$pass,	8*$pass	
	);

	$D["minMaxDiff"]=$D["max"]-$D["min"];
//	$D["minMaxDiff"]=$D["max"]-$D["min"];
	
	foreach($D["Ip"] as $K => $P){
		$D["I"][$K]=($D["minMaxDiff"]*$P/100)+$D["min"];
		$D["I"][$K]=euroFormatSmart($D["I"][$K]);
	}
	

	$D["s"]=array(
		"L1"=>array("spreadLP"=>	$D["Ip"][0],"spreadRP"=>$D["Ip"][1], "spreadL"=>$D["I"][0],"spreadR"=>$D["I"][1]	),
		"L2"=>array("spreadLP"=>	$D["Ip"][1],"spreadRP"=>$D["Ip"][2],"spreadL"=>$D["I"][1],"spreadR"=>$D["I"][2]	),		
		"L3"=>array("spreadLP"=>	$D["Ip"][2],"spreadRP"=>$D["Ip"][3],"spreadL"=>$D["I"][2],"spreadR"=>$D["I"][3]		),
		"L4"=>array("spreadLP"=>	$D["Ip"][3],"spreadRP"=>$D["Ip"][4],"spreadL"=>$D["I"][3],"spreadR"=>$D["I"][4]),
		
		"W1"=>array("spreadLP"=>	$D["Ip"][4],"spreadRP"=>$D["Ip"][5],"spreadL"=>$D["I"][4],"spreadR"=>$D["I"][5]),
		"W2"=>array("spreadLP"=>	$D["Ip"][5],"spreadRP"=>$D["Ip"][6],"spreadL"=>$D["I"][6],"spreadR"=>$D["I"][6]),
		"W3"=>array("spreadLP"=>	$D["Ip"][6],"spreadRP"=>$D["Ip"][7],"spreadL"=>$D["I"][6],"spreadR"=>$D["I"][7]),
		"W4"=>array("spreadLP"=>	$D["Ip"][7],"spreadRP"=>$D["Ip"][8],"spreadL"=>$D["I"][7],"spreadR"=>$D["I"][8]),
	);
// INSERT INTO `games_spread` (`gameId`, `spread`
//		, `spreadLP`, `spreadRP`, `spreadL`, `spreadR`) VALUES 
	$D["q"]=" INSERT INTO `games_spread` 
	(`gameId`, `spread`,`spreadLP`, `spreadRP`, `spreadL`, `spreadR`) VALUES 
	 ";
	foreach($D["s"] as $K => $SS){
		$D["q"].="( $gameId, '".$K."','".$SS["spreadLP"]."','".$SS["spreadRP"]."','".$SS["spreadL"]."','".$SS["spreadR"]."' ),
";
	}
	$D["q"]=trim($D["q"],",\n" );
	sql_query("DELETE FROM games_spread WHERE gameId=$gameId");
	sql_query($D["q"]);
	$D["e"]=sql_error();	
	return $D;	
}

function deviceType(){
	require_once(C_ROOT."/config/mdetect.php");
	$detect = new Mobile_Detect;
	
	$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
	//$scriptVersion = $detect->getScriptVersion();
	return $deviceType;
}

function playerVersion(){
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$pvers="mobileplayer";	 //player02
	$deviceType=deviceType();
	if (deviceType()=='computer') 		$pvers= "desktopplayer"; //player01

	//if (	strpos( $user_agent, 'Safari') !== false	&&	strpos( $user_agent, 'Chrome') === false			) $pvers= "safariplayer";	 //player02	
	if (	strpos( $user_agent, 'Safari') !== false	&&	$pvers=="desktopplayer"	&&	strpos( $user_agent, 'Chrome') === false		) $pvers= "safariplayer";	 //player02	
	if (preg_match('~MSIE|Internet Explorer~i', $user_agent) || (strpos($user_agent, 'Trident/7.0; rv:11.0') !== false)) $pvers="IEbrowser"; //internet explorer 
		
	return $pvers;	 //player02
}
############################################
function getElapsedTimeString($time,$format="seconds", $short=true, $nosecs=false) {
	$res = "";    
	if (!$time) return "zero";
	
	if ($format=="seconds") {
		$seconds = (int) ($time) % 60;
		$minutes = (int) (($time / 60) % 60);
		$hours   = (int) (($time / (60*60)) % 24);

	}
	if ($format=="minutes") {
		$timeSecs=$time*60;
		$seconds = (int) ($timeSecs) % 60;
		$minutes = (int) (($timeSecs / 60) % 60);
		$hours   = (int) (($timeSecs/ (60*60)) % 24);
	}
	$hoursSep=" Hours ";
	$minutesSep=" Minutes ";
	$secondsSep=" seconds ";

	if ($short){
		$hoursSep=" H ";
		$minutesSep="' ";
		$secondsSep="'' ";
	}
	
	if($hours) 		$res.= $hours.$hoursSep;
	if($minutes) 	$res.= $minutes.$minutesSep;
	if (!$nosecs) if($seconds) 	$res.= $seconds.$secondsSep;
	
	return $res; 
    	
}

function TimeAgo($datefrom, $dateto = -1)
{
  if ($datefrom <= 0) {
    return "A long time ago";
  }
  if ($dateto == -1) {
    $dateto = time();
  }
  $difference = $dateto - $datefrom;
  if ($difference < 60) {
    $interval = "s";
  } elseif ($difference >= 60 && $difference < 60 * 60) {
    $interval = "n";
  } elseif ($difference >= 60 * 60 && $difference < 60 * 60 * 24) {
    $interval = "h";
  } elseif ($difference >= 60 * 60 * 24 && $difference < 60 * 60 * 24 * 7) {
    $interval = "d";
  } elseif ($difference >= 60 * 60 * 24 * 7 && $difference < 60 * 60 * 24 * 30) {
    $interval = "ww";
  } elseif ($difference >= 60 * 60 * 24 * 30 && $difference < 60 * 60 * 24 * 365) {
    $interval = "m";
  } elseif ($difference >= 60 * 60 * 24 * 365) {
    $interval = "y";
  }
  switch ($interval) {
    case "m":
      $months_difference = floor($difference / 60 / 60 / 24 / 29);
      while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
        $months_difference++;
      }
      $datediff = $months_difference;
      if ($datediff == 12) {
        $datediff--;
      }
      $res = ($datediff == 1) ? "$datediff month ago" : "$datediff months ago";
      break;
    case "y":
      $datediff = floor($difference / 60 / 60 / 24 / 365);
      $res = ($datediff == 1) ? "$datediff year ago" : "$datediff years ago";
      break;
    case "d":
      $datediff = floor($difference / 60 / 60 / 24);
      $res = ($datediff == 1) ? "$datediff day ago" : "$datediff days ago";
      break;
    case "ww":
      $datediff = floor($difference / 60 / 60 / 24 / 7);
      $res = ($datediff == 1) ? "$datediff week ago" : "$datediff weeks ago";
      break;
    case "h":
      $datediff = floor($difference / 60 / 60);
      $res = ($datediff == 1) ? "$datediff hour ago" : "$datediff hours ago";
      break;
    case "n":
      $datediff = floor($difference / 60);
      $res = ($datediff == 1) ? "$datediff minute ago" : "$datediff minutes ago";
      break;
    case "s":
      $datediff = $difference;
      $res = ($datediff == 1) ? "$datediff second ago" : "$datediff seconds ago";
      break;
  }
  if ($res=="1 day ago") $res="yesterday";
  return $res;
}

////////////////

function getElapsedTimeStringSmart($time,$format="seconds", $short=true) {
	$res = "";    
	if (!$time) return "zero";
	if ($format=="seconds") {
		$seconds = (int) ($time) % 60;
		$minutes = (int) (($time / 60) % 60);
		$hours   = (int) (($time / (60*60)) % 2400);
		//$hours   = (int) ($timeSecs/ 60/60  );
	}
	if ($format=="minutes") {
		$timeSecs=$time*60;
		$seconds = (int) ($timeSecs) % 60;
		$minutes = (int) (($timeSecs / 60) % 60);
//		$hours   = (int) (($timeSecs/ (60*60)) % 24);
		$hours   = (int) (($timeSecs/ 60/60) );
	}
	$hoursSep=" Hours ";
	$minutesSep=" Minutes ";
	$secondsSep=" seconds ";

	if ($short){
		$hoursSep="<sup>h</sup>";
		$minutesSep="<sup>m</sup>";
		$secondsSep="<sup>s</sup>";
	}
	
	if($hours) 		
		$res.= $hours.$hoursSep;
	if($minutes) 	
		$res.= $minutes.$minutesSep;
	 if($seconds && !$hours	 ) 	 //
		 $res.= $seconds.$secondsSep;
	
	return $res; 
    
}


function minutesFromSeconds($seconds){
	return round($seconds/60);
}

/*function minutesRoundToQuorter($seconds){
	return round($seconds/60);
}
*/

function getWeekDays($weeksAgo=0){
	$K=$weeksAgo*7*24*60*60;
	$week=array();

	$week[0]["ts"]=strtotime('last monday 00:00:00'); // last monday
	if (date("w")==1) $week[0]["ts"]=strtotime('today 00:00:00');
	
	$week[0]["ts"]=$week[0]["ts"]-$K;
	$week[0]["show"]=date('D M j Y', $week[0]["ts"]); //D Y-m-d H:i:s
		if (date('Y', $week[0]["ts"])==date('Y')	) $week[0]["show"]=date('D M j', $week[0]["ts"]);
	$week[0]["tsEnd"]=$week[0]["ts"]+(24*60*60)-1; // last monday
	$week[0]["showEnd"]=date('D Y-m-d H:i:s', $week[0]["tsEnd"]);
	$week[0]["sessions"]=0;
	$week[0]["elapsed"]=0;
///	$week[0]["elapsedMins"]=0;
	for ($i = 1; $i <= 6; $i++) {
		
		$week[$i]["ts"]=$week[$i-1]["ts"]+(24*60*60); 
		$week[$i]["show"]=date('D Y M j', $week[$i]["ts"]); //D Y-m-d H:i:s
		if (date('Y', $week[$i]["ts"])==date('Y')	) $week[$i]["show"]=date('D M j', $week[$i]["ts"]);
		$week[$i]["tsEnd"]=$week[$i]["ts"]+(24*60*60)-1;
		$week[$i]["sessions"]=0;
		$week[$i]["elapsed"]=0;
//		$week[$i]["elapsedMins"]=0;
	//	$week[$i]["showEnd"]=date('D Y-m-d H:i:s', $week[$i]["tsEnd"]);
	}
	return $week;
}
function getDays($startDate, $endDate, $purpose=false){ // format: 13/01/2016 13/03/2016
	//$purpose=false cheks date and return days $purpose="check" only check dates
	$maxDays=90;
	$D=array();
	$startFalse="The start date is not correct";
	$endFalse="The end date is not correct";
	$D["response"]=true;
		
	$startDateA=explode("/", $startDate);
	$endDateA=explode("/", $endDate);
	if (!$startDateA[0]||!$startDateA[1]||!$startDateA[2]){
		$D["response"]=false;
		$D["responseTxt"]=$startFalse;		
	}
	if (!$endDateA[0]||!$endDateA[1]||!$endDateA[2]){
		$D["response"]=false;
		$D["responseTxt"]=$endFalse;		
	}
	if (!$D["response"]) return $D;
	
	$D["cFrom"]=$startDate;
	$D["cTo"]=$endDate;
	if (!$D["cFrom"]) {
		$D["response"]=false;
		$D["responseTxt"]=$startFalse;
	}
	if (!$D["cTo"]) {
		$D["response"]=false;
		$D["responseTxt"]=$endFalse;
	}
	if (!$D["response"]) return $D;

	$D["cFromDb"]=dateIT2dateDb($D["cFrom"])." 00:00:00";
	$D["cToDb"]=dateIT2dateDb($D["cTo"])." 00:00:00";
	
	if (!strtotime($D["cFromDb"])) {
		$D["response"]=false;
		$D["responseTxt"]=$startFalse;
	}
	if (!strtotime($D["cToDb"])) {
		$D["response"]=false;
		$D["responseTxt"]=$endFalse;
	}
	if (!$D["response"]) return $D;
	
	$D["cFromTs"]=strtotime($D["cFromDb"]);
	$D["cToTs"]=strtotime($D["cToDb"]);

	if ($D["cFromTs"] > $D["cToTs"]) {
		$D["response"]=false;
		$D["responseTxt"]="the end date can't be before the start date";	
		return $D;
	}

	$daySecs=86400;
	$D["differenceTs"]=$D["cToTs"] - $D["cFromTs"];
	$D["daysN"] = ($D["differenceTs"] / $daySecs);  //ceil(abs($D["differenceTs"])
	$D["time"]=time();
	
	if ($D["daysN"] > $maxDays) {
		$D["response"]=false;
		$D["responseTxt"]="The max days numbers is $maxDays (you're asking for ".$D["daysN"].") ";
		return $D;
	}

	if ($purpose=="check") return $D;

	for ($i = 0; $i <= $D["daysN"]; $i++) {
		$dayTs=$D["cFromTs"]+$daySecs*$i;
		$D["dayA"][$i]["ts"]=$dayTs;
		$D["dayA"][$i]["show"]=timestamp2it($dayTs, "its");// date('D d', $dayTs);
		$D["dayA"][$i]["tsEnd"]=$dayTs+(60*60*24)-1;
		$D["dayA"][$i]["tsEndH"]=timestamp2it($D["dayA"][$i]["tsEnd"]);
	}
/*

            [ts] => 1457740800
            [show] => Sat Mar 12
            [tsEnd] => 1457827199
            [sessions] => 0
            [elapsed] => 0
*/	
	return $D;
	
}

function getYearDays($monthAgo=0){
	// DA FINIRE
	$year=array();
	$year[0]["ts"]=strtotime("first day of $monthAgo years ago 00:00");
	$year["days"]=cal_days_in_year(CAL_GREGORIAN,date('n',$year[0]["ts"]),date('Y',$year[0]["ts"]));
	
	$year[0]["tsEnd"]=$month[0]["ts"]+(24*60*60)-1;
	$year[0]["show"]=date('D d', $month[0]["ts"]); //D Y-m-d H:i:s   Y M j H:i		

	$year[0]["showCheck"]=date('F Y-m-d H:i:s', $month[0]["ts"]); //D Y-m-d H:i:s   Y M j H:i
	for ($i = 1; $i <= $month["days"]-1; $i++) {
		$month[$i]["ts"]=$month[$i-1]["ts"]+(24*60*60); 
		$month[$i]["show"]=date('D d', $month[$i]["ts"]); //D Y-m-d H:i:s
//			if (date('Y', $week[$i]["ts"])==date('Y')	) $week[$i]["show"]=date('D M j', $week[$i]["ts"]);
		$month[$i]["tsEnd"]=$month[$i]["ts"]+(24*60*60)-1;
//			$month[$i]["sessions"]=0;
//			$month[$i]["elapsed"]=0;
		
	}

	return $month;
}

function getMonthDays($monthAgo=0){
	$month=array();
	$month[0]["ts"]=strtotime("first day of $monthAgo months ago 00:00");
	$month["days"]=cal_days_in_month(CAL_GREGORIAN,date('n',$month[0]["ts"]),date('Y',$month[0]["ts"]));
	
	$month[0]["tsEnd"]=$month[0]["ts"]+(24*60*60)-1;
	$month[0]["show"]=date('D d', $month[0]["ts"]); //D Y-m-d H:i:s   Y M j H:i		

	$month[0]["showCheck"]=date('F Y-m-d H:i:s', $month[0]["ts"]); //D Y-m-d H:i:s   Y M j H:i
	for ($i = 1; $i <= $month["days"]-1; $i++) {
		$month[$i]["ts"]=$month[$i-1]["ts"]+(24*60*60); 
		$month[$i]["show"]=date('D d', $month[$i]["ts"]); //D Y-m-d H:i:s
//			if (date('Y', $week[$i]["ts"])==date('Y')	) $week[$i]["show"]=date('D M j', $week[$i]["ts"]);
		$month[$i]["tsEnd"]=$month[$i]["ts"]+(24*60*60)-1;
//			$month[$i]["sessions"]=0;
//			$month[$i]["elapsed"]=0;
		
	}

	return $month;
}


	
	function date_select_html(
	$howManyY=99
	,$maxY=2017	// from this to back
	,$defaultD="day",$defaultM="month",$defaultY="year",$selectedD=0,$selectedM=0,$selectedY=0, $classD="day",$classM="month",$classY="year"
	, $yearMin=0 //2015 never lower of this
	) {
		$s="";
		$monthAbb=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sept","Oct","Nov","Dec");
		$s.='<select class="'.$classD.'">';
		if ($defaultD) $s.="<option value=\"0\">$defaultD</option>"; // &nbsp;&nbsp;&nbsp
		for ($i = 1; $i <= 31; $i++) {
			$ifill=$i;if ($i<10) $ifill="0".$i;
			$s.='<option value="'.$ifill.'"';
			if ($ifill==$selectedD) $s.=' selected="selected"';
			$s.=">$ifill</option>";
		}
		$s.='</select>';
		$s.='<span class="separator1">/</span>';

		$s.='<select class="'.$classM.'">';
		if ($defaultM) $s.="<option value=\"0\">$defaultM</option>";
		for ($i = 1; $i <= 12; $i++) {
			$ifill=$i;if ($i<10) $ifill="0".$i;
			$s.='<option value="'.$ifill.'"';
			if ($ifill==$selectedM) $s.=' selected="selected"';
			$s.=">".$monthAbb[($i-1)]."</option>";
		}
		$s.='</select>';
		$s.='<span class="separator2">/</span>';
		$s.='<select class="'.$classY.'">';	
		if ($defaultY) $s.="<option value=\"0\">$defaultY</option>";
		if ($yearMode="back") {
			$z=$maxY+1;
			for ($i = ($maxY-$howManyY); $i <= $maxY; $i++) {
				$z--;
				$ifill=$z;
				if ($ifill>=$yearMin) {
					$s.='<option value="'.$ifill.'"';
					if ($ifill==$selectedY) $s.=' selected="selected"';
					$s.=">$ifill</option>";
				}
			}
		}
		$s.='</select>';

		return $s;		
	}
function get_date_diff( $time1, $time2, $precision = 2 ) {
	// If not numeric then convert timestamps https://gist.github.com/ozh/8169202
	/*if( !is_int( $time1 ) ) {
		$time1 = strtotime( $time1 );
	}
	if( !is_int( $time2 ) ) {
		$time2 = strtotime( $time2 );
	}*/
	// If time1 > time2 then swap the 2 values
	if( $time1 > $time2 ) {
		list( $time1, $time2 ) = array( $time2, $time1 );
	}
	// Set up intervals and diffs arrays
	$intervals = array( 'year', 'month', 'day', 'hour', 'minute', 'second' );
	$diffs = array();
	foreach( $intervals as $interval ) {
		// Create temp time from time1 and interval
		$ttime = strtotime( '+1 ' . $interval, $time1 );
		// Set initial values
		$add = 1;
		$looped = 0;
		// Loop until temp time is smaller than time2
		while ( $time2 >= $ttime ) {
			// Create new temp time from time1 and interval
			$add++;
			$ttime = strtotime( "+" . $add . " " . $interval, $time1 );
			$looped++;
		}
		$time1 = strtotime( "+" . $looped . " " . $interval, $time1 );
		$diffs[ $interval ] = $looped;
	}
	$count = 0;
	$times = array();
	foreach( $diffs as $interval => $value ) {
		// Break if we have needed precission
		if( $count >= $precision ) {
			break;
		}
		// Add value and interval if value is bigger than 0
		if( $value > 0 ) {
			if( $value != 1 ){
				$interval .= "s";
			}
			// Add value and interval to times array
			$times[] = $value . " " . $interval;
			$count++;
		}
	}
	// Return string with times
	return implode( ", ", $times );
}
// getDailySessions($startDateTs, $endDateTs, $token,$uidr,$gameIdId=false, $gameMinDur=0,$uid=false
//getLastSession($_POST["TOKEN"],$_POST["uidr"],false, $_POST["command"]["game"],$gamesMinDuration[	$_POST["command"]["game"]	], $_POST["uid"]);
function getLastSession($token,$uidr,$mode=false, $gameIdId=false,$gameMinDur=0,$uid=false ){
	if (!$token||!$uidr) return false;
	conn();
	
	$Q_game="";
	if ($gameIdId && $gameIdId!="0_0") {
		$gameIdsA=explode("_", $gameIdId);
		if ($gameIdsA[0]&&$gameIdsA[1]){
			$Q_game=" AND game_id=".$gameIdsA[0];
			$Q_game.=" AND game_type=".$gameIdsA[1];
		}
	}
	$QUERY_PLAYER="(player_id =".$uidr." AND device_token='".$token."')";
	if ($uid){
		$d["playerMerged"]=getMergedPlayers($uid, $QUERY_PLAYER);
		if ($d["playerMerged"]["query"]) $QUERY_PLAYER=$d["playerMerged"]["query"];	
	}
	$durationQ="";
	
	$baseQ="SELECT created lastSessionTs, score, elapsed,game_id,game_type FROM sessions 
	WHERE $QUERY_PLAYER
	AND created>0 AND `ignore`=0 AND score >=".SESSION_MINIMUM_SCORE_GRAPH." $Q_game $durationQ
	 ORDER BY created DESC LIMIT 0,1";
	 
//	echo $gameIdId;// 
	
	//$d["q"]=$baseQ; return $d;
	$q=mysql_query($baseQ);
	if (mysql_error())	echo $baseQ;
	$d=mysql_fetch_assoc($q);
	$d["gameIdId"]=$d["game_id"]."_".$d["game_type"];
	$d["lastSessionTsShow"]=timestamp2it( $d["lastSessionTs"], "its");
	$d["q"]=$baseQ;
	
	if ($mode=="TsOnly") 	return $d["lastSessionTs"];
	return $d;
	
}
function getFirstSession($token,$uidr,$mode=false, $gameIdId=false,$gameMinDur=0,$uid=false ){
	if (!$token||!$uidr) return false;
	conn();
	
	$Q_game="";
	if ($gameIdId && $gameIdId!="0_0") {
		$gameIdsA=explode("_", $gameIdId);
		$Q_game=" AND game_id=".$gameIdsA[0];
		$Q_game.=" AND game_type=".$gameIdsA[1];
	}
	$QUERY_PLAYER="(player_id =".$uidr." AND device_token='".$token."')";
	if ($uid){
		$d["playerMerged"]=getMergedPlayers($uid, $QUERY_PLAYER);
		if ($d["playerMerged"]["query"]) $QUERY_PLAYER=$d["playerMerged"]["query"];	
	}
	
	$baseQ="SELECT created ts, score, elapsed,game_id,game_type FROM sessions 
	WHERE $QUERY_PLAYER
	AND created>0 AND `ignore`=0 AND score >=".SESSION_MINIMUM_SCORE_GRAPH." $Q_game
	 ORDER BY created ASC LIMIT 0,1";
	 
	//$d["q"]=$baseQ; return $d;
	$q=mysql_query($baseQ);
	$d=mysql_fetch_assoc($q);
	$d["gameIdId"]=$d["game_id"]."_".$d["game_type"];
	
	if ($mode=="TsOnly") 	return $d["ts"];
	return $d;
	
}

	
function monthsDifference ($startDate, $endDate=false){ //ts
	if (!$endDate) $endDate=time();
	return abs((date('Y', $endDate) - date('Y', $startDate))*12 + (date('m', $endDate) - date('m', $startDate)))+1;
}

function weeksDifference($ts, $mode="justWeekN"){
	$r=array();
	$r["data"]["max"]=48;
	$r["data"]["ts"]=$ts;
	$r["data"]["found"]=false;
	$r[0]["start"]=strtotime("last sunday midnight")+24*60*60;
	$r[0]["end"]=$r[0]["start"]+(7*60*60*24)-1;
	$r[0]["startH"]=timestamp2it($r[0]["start"], "verylong");
	$r[0]["endH"]=timestamp2it($r[0]["end"], "verylong");
	
	if ($r["data"]["ts"]<=$r[0]["end"] && $r["data"]["ts"]>=$r[0]["start"]) $r["data"]["found"]=0;
	
	if ($r["data"]["found"]===false){
		for ($i = 1; $i < 	$r["data"]["max"]; $i++) {
			$r[$i]["start"]=$r[$i-1]["start"]-7*24*60*60;
			$r[$i]["end"]=$r[$i]["start"]+(7*60*60*24)-1;		
			$r[$i]["startH"]=timestamp2it($r[$i]["start"], "verylong");
			$r[$i]["endH"]=timestamp2it($r[$i]["end"], "verylong");	
			if ($r["data"]["ts"]<=$r[$i]["end"] && $r["data"]["ts"]>=$r[$i]["start"]) {
				$r["data"]["found"]=$i;
				break;
			}
		}
	}
	if ($mode=="justWeekN") return $r["data"]["found"];
	
	return $r;
}
function daysDifference($startDateTs, $endDateTs){
	$dStart = new DateTime(timestamp2db($startDateTs));
	$dEnd  = new DateTime(timestamp2db($endDateTs));
	$dDiff = $dStart->diff($dEnd);
	// $plusOrMinus=$dDiff->format('%R'); // + or - 
	return ($dDiff->days)+1;
}

function getDailySessions($startDateTs, $endDateTs, $token,$uidr,$gameIdId=false, $gameMinDur=0,$uid=false,$outputMood=false){
	if (!$token||!$uidr||!$startDateTs || !$endDateTs) return false;
		
	$Q_game="";if ($gameIdId && $gameIdId!="0_0") {
		$gameIdsA=explode("_", $gameIdId);
		$Q_game=" AND game_id=".$gameIdsA[0];
		$Q_game.=" AND game_type=".$gameIdsA[1];
	}
	$D=array();
	$QUERY_PLAYER="(player_id =".$uidr." AND device_token='".$token."')";
	if ($uid){
		$d["playerMerged"]=getMergedPlayers($uid, $QUERY_PLAYER);
		if ($d["playerMerged"]["query"]) $QUERY_PLAYER=$d["playerMerged"]["query"];	
	}
		
	$D["baseQ"]="SELECT session_id,created, score, elapsed FROM sessions 
	WHERE $QUERY_PLAYER
	AND created>0 AND `ignore`=0 AND score >=".SESSION_MINIMUM_SCORE_GRAPH." $Q_game "; // ,game_id,game_type  AND created>0
	if ($gameMinDur) $D["baseQ"].=" AND elapsed>=".$gameMinDur;
	
	
	$D["daysT"]=daysDifference($startDateTs, $endDateTs);	
	
	$D["startDayDB"]=timestamp2db($endDateTs)." 00:00:00";
	$D["startDayTs"]=strtotime($D["startDayDB"]);

	$D["endDayDB"]=timestamp2db($startDateTs)." 00:00:00";
	$D["endDayTs"]=strtotime($D["startDayDB"]);

	
	if ($D["daysT"]>3650) $D["daysT"]=3650;//protection
	
	$z=0;$z=0;conn();
	for ($i = 0; $i < $D["daysT"]; $i++) {
		$D["data"][$i]["ts"]=$D["startDayTs"]-(60*60*24*($i));
		$D["data"][$i]["show"]=timestamp2it($D["data"][$i]["ts"], "its");//verylong
		$D["data"][$i]["tsEnd"]=$D["data"][$i]["ts"]+(60*60*24)-1;
		//$D["data"][$i]["showEnd"]=timestamp2it($D["data"][$i]["tsEnd"], "its");
			$D["data"][$i]["sessions"]=0;

			$D["data"][$i]["q"]=$D["baseQ"]." AND created >=".$D["data"][$i]["ts"]." AND created <= ".$D["data"][$i]["tsEnd"]." ORDER BY created ASC";
			$sessDataQ = mysql_query($D["data"][$i]["q"]);
			if (mysql_error()) $D["data"][$i]["e"]=mysql_error();

			$D["data"][$i]["scoreArr"]=array();

			while($sessDataR=mysql_fetch_assoc($sessDataQ)){
				$D["data"][$i]["sessions"]++;
				$D["data"][$i]["elapsed"]+=$sessDataR["elapsed"];
				$D["data"][$i]["score"]+=$sessDataR["score"];
				$D["data"][$i]["scoreArr"][	$D["data"][$i]["sessions"]-1	]=$sessDataR["score"];
				
				$D["data"][$i]["averageScore"]=round($D["data"][$i]["score"]/$D["data"][$i]["sessions"],2);
				$D["data"][$i]["maxScore"]=@max(	$D["data"][$i]["scoreArr"]);
				$D["data"][$i]["minScore"]=@min(	$D["data"][$i]["scoreArr"]);
				$D["data"][$i]["trend"]=$D["data"][$i]["score"]-$D["data"][($i-1)]["score"];
				
				if (	!isset(	$D["data"][($i-1)]["score"]	)		) {
					$D["data"][$i]["trend"]="n/a";
				}else{
					$D["data"][$i]["trend"]=round (($D["data"][$i]["trend"]/ $D["data"][($i-1)]["score"]*100),0);
					if ($D["data"][$i]["trend"]>0 )$D["data"][$i]["trend"]="+".$D["data"][$i]["trend"];
					$D["data"][$i]["trend"].="%";
				}
				
				
				
			}
			unset ($D["data"][$i]["q"]);
			unset ($D["data"][$i]["scoreArr"]);
			if ($D["data"][$i]["sessions"]){
				$D["dataF"][$z]=$D["data"][$i];$z++;				
			}
	}
//	unset ($D["data"]);
//	unset ($D["baseQ"]);
	if (!$outputMood) return $D["dataF"];
	return $D;
	
}
function getMergedPlayers($uid, $query_to_modify=false, $names=false ){
	conn();
	$D["mergedQ"]="SELECT PM.uid2, P.remote_id, P.device_token
	FROM playes_merged PM 
	LEFT JOIN players P ON (P.player_id=PM.uid2)
	WHERE PM.uid1=$uid ORDER BY PM.created DESC";
	if ($names) 
		$D["mergedQ"]="SELECT PM.uid2, P.remote_id, P.device_token, D.device_name,
	P.player_name, P.player_surname
	FROM playes_merged PM 
	LEFT JOIN players P ON (P.player_id=PM.uid2)
	LEFT JOIN devices D ON (P.device_token=D.device_token)
	WHERE PM.uid1=$uid ORDER BY PM.created DESC";

	$D["q"]="";
	$pMerged = mysql_query($D["mergedQ"]);
	$D["mergedN"]=0;
	while($playerMerged=mysql_fetch_assoc($pMerged)){
		$D["mergedN"]++;
		$D["data"]=$playerMerged;
		$D["q"].=" OR (player_id =".$playerMerged["remote_id"]." AND device_token='".$playerMerged["device_token"]."')";
	}
	if ($query_to_modify) $D["query"]="( $query_to_modify ".$D["q"].")";
	return $D; 
}

///////////////////////////// 
function gamesMinDurationOpt($moode="progressive",$output="all"){ // C_ROOT."/handler/home/home.php");
	$write=true;
	$sessTable="sessions"; //_sessionsBETA
	conn();
	$gamesMinDuration["moode"]=$moode;
	if ($moode=="progressive") {
		$str="SELECT lastSessionId FROM sessionOptimization ORDER BY id DESC LIMIT 0,1";
		$optQ=mysql_query($str);
		$opt=mysql_fetch_assoc($optQ);
		$gamesMinDuration["sessionIdStart"]=$opt["lastSessionId"];
	}
	

	if ($moode=="inizialize") {
		mysql_query("UPDATE `$sessTable` SET `ignore`='0'");
		$gamesMinDuration["sessionIdStart"]=0;
	}
	if ($moode=="inizializeStop") {
		mysql_query("UPDATE `$sessTable` SET `ignore`='0'");
		$gamesMinDuration["sessionIdStart"]=0;
		return;
	}
	if (!$gamesMinDuration["sessionIdStart"]) $gamesMinDuration["sessionIdStart"]=0;
	$gamesMinDuration["affectedT"]=0;
	// output $gamesMinDuration array
	conn();
	//if (isset($GLOBALS['gamesMinDuration'])) return;
	$strNamnes="SELECT game_id, gameType_idi, /*constant,*/ minimumDurationSecs FROM games_types WHERE minimumDurationSecs>0 ORDER BY game_id ASC, gameType_idi ASC";
	$gamesQN=mysql_query($strNamnes);
	if (mysql_error()	) {$gamesMinDuration[0]=mysql_error();return;}
	$i=0;
	while ($games=mysql_fetch_assoc($gamesQN)) {
		$gamesMinDuration["d"][$i] = $games;
		// UPDATE `moto_tiles_com`.`_sessionsBETA` SET `ignore` = '3' WHERE `_sessionsBETA`.`session_id` =1;
		$gamesMinDuration["d"][$i]["q"]="UPDATE `$sessTable` SET `ignore`='1' WHERE `session_id` > ".$gamesMinDuration["sessionIdStart"]." AND game_id=".$games["game_id"]." AND game_type=".$games["gameType_idi"]." AND elapsed < ".$games["minimumDurationSecs"]."";
		if ($write) mysql_query($gamesMinDuration["d"][$i]["q"]);
		if ($write) $gamesMinDuration["d"][$i]["affected"]=mysql_affected_rows();
		$gamesMinDuration["affectedT"]+=$gamesMinDuration["d"][$i]["affected"];
		$i++;
	}

	$str="SELECT session_id FROM $sessTable ORDER BY session_id DESC LIMIT 0,1";
	$optQ=mysql_query($str);
	$opt=mysql_fetch_assoc($optQ);
	$gamesMinDuration["lastProcessedSessionId"]=$opt["session_id"];
	if ($write) mysql_query("INSERT INTO sessionOptimization (date, lastSessionId, mode, affected,uid) VALUES ('".timestamp2db((time()+TIMESTAMP_SERVER_CORRECTION), "long")."', ".$gamesMinDuration["lastProcessedSessionId"].", '$moode', '".$gamesMinDuration["affectedT"]."',".$_SESSION["uid"].")");
	
	//if ($output=="all") 
	return $gamesMinDuration;
	
}
function sortBySubValue($array, $value, $asc = false, $preserveKeys = true)
{
    if (is_object(reset($array))) {
        $preserveKeys ? uasort($array, function ($a, $b) use ($value, $asc) {
            return $a->{$value} == $b->{$value} ? 0 : ($a->{$value} - $b->{$value}) * ($asc ? 1 : -1);
        }) : usort($array, function ($a, $b) use ($value, $asc) {
            return $a->{$value} == $b->{$value} ? 0 : ($a->{$value} - $b->{$value}) * ($asc ? 1 : -1);
        });
    } else {
        $preserveKeys ? uasort($array, function ($a, $b) use ($value, $asc) {
            return $a[$value] == $b[$value] ? 0 : ($a[$value] - $b[$value]) * ($asc ? 1 : -1);
        }) : usort($array, function ($a, $b) use ($value, $asc) {
            return $a[$value] == $b[$value] ? 0 : ($a[$value] - $b[$value]) * ($asc ? 1 : -1);
        });
    }
    return $array;
}


function turnLinksOn($string){
	$regex = '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i';
	preg_match_all($regex, $string, $matches);
	$urls = $matches[0];
	// go over all links
	foreach($urls as $url) {
//		echo $url.'<br />';
		$string=str_replace($url, "<a target=\"_BLANK\" href=\"".$url."\">".$url."</a>", $string);
	}	
	return $string;
}

define ("cryptPWD", "Verrà la morte e avrà i tuoi gnocchi");
function crypta($string){
    $response=openssl_encrypt($string,"AES-128-ECB",cryptPWD);
    $dirty = array("+", "/", "=");
    $clean = array("_pls_", "_slas_", "_QLS_");
     return str_replace($dirty, $clean, $response);
}
function decrypta($string){
    $response=openssl_encrypt($string,"AES-128-ECB",cryptPWD);
    $dirty = array("+", "/", "=");
    $clean = array("_pls_", "_slas_", "_QLS_");
    $stringDclean=str_replace($clean, $dirty, $string);
    return openssl_decrypt($stringDclean,"AES-128-ECB",cryptPWD);
}


function createImgGameCover($gameId, $avatar_id, $scenario_id){
    if (
    !$gameId || !is_numeric($gameId) 
    ) return false;

    if ($avatar_id==1000) $avatar_id=false;
    if (!$scenario_id || !is_numeric($scenario_id) )    $scenario_id=0;
    
    
    if ($avatar_id){
        $bottom_image = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].'/data/scenarios/'.$scenario_id.'_1024.jpg'); 
        $top_image = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].'/data/avatar_prev/1/'.$avatar_id.'_500x1098.png');    
        imagesavealpha($top_image, true); imagealphablending($top_image, true);
        imagecopy($bottom_image, $top_image, 
        0, //left
        20, // top // x y bottom_image
        0, 
        0, // x y crop top_image (lasciare zero)
        500, 1098);        
        imagejpeg($bottom_image,  $_SERVER['DOCUMENT_ROOT'].'/data/gameCover/'.$gameId.'_1024.jpg');  
        imagedestroy($bottom_image);imagedestroy($top_image);
        
        //640
        $img_r = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].'/data/gameCover/'.$gameId.'_1024.jpg');
        $dst_r = ImageCreateTrueColor( 640, 360 );
        imagecopyresampled($dst_r, $img_r, 0, 0, 0, 0, 
        640, 360, 
        1024, 576);        
        imagejpeg($dst_r,  $_SERVER['DOCUMENT_ROOT'].'/data/gameCover/'.$gameId.'_640.jpg');
        imagedestroy($dst_r);imagedestroy($img_r);
        
    }else{
        copy(
            $_SERVER['DOCUMENT_ROOT'].'/data/scenarios/'.$scenario_id.'_1024.jpg', 
            $_SERVER['DOCUMENT_ROOT'].'/data/gameCover/'.$gameId.'_1024.jpg'
        );
        copy(
            $_SERVER['DOCUMENT_ROOT'].'/data/scenarios/'.$scenario_id.'_640.jpg', 
            $_SERVER['DOCUMENT_ROOT'].'/data/gameCover/'.$gameId.'_640.jpg'
        );
    }
    sql_query("UPDATE `games` SET `cover` = '".$gameId."_640.jpg?".time()."' WHERE `games`.`gameId` = $gameId");
    return true;
}
function creditsFromDescription($description, $limit=false){
    preg_match_all('/<credits>(.*?)<\/credits>/i', $description, $creditsD);
    if (empty ($creditsD[0])) return "";
    //return $creditsD[0];
    $html="";
    $i=0;
    if ($creditsD[0]) foreach($creditsD[0] as $k => $C) {
        $d=explode(":",$C );
        
        $d[0]=str_replace("_", " ", $d[0]);
        $d[0]=str_replace("<credits>", "", $d[0]);$d[0]=str_replace("</credits>", "", $d[0]);
        $d[1]=str_replace("<credits>", "", $d[1]);$d[1]=str_replace("</credits>", "", $d[1]);
        $d[1]=trim($d[1]);
        $html.='<div class="credits"><span class="creditsTitle">'.$d[0].': </span><span class="creditsName">'.$d[1].'</span></div>';
        $i++;
        if ($limit && is_numeric($limit)   && $i==$limit ) break;
        
    }
    if ($html) $html="<div class=\"creditsGroup\">$html</div>";
    //$html=str_replace(">", "]", $html);$html=str_replace("<", "[", $html);
    return $html;
}
function delete_all_between($beginning, $end, $string) {
  $beginningPos = strpos($string, $beginning);
  $endPos = strpos($string, $end);
  if ($beginningPos === false || $endPos === false) {
    return $string;
  }

  $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

  return delete_all_between($beginning, $end, str_replace($textToDelete, '', $string)); // recursion to ensure all occurrences are replaced
}
?>