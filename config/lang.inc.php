<?php
if (!$lang_trigger) $lang_trigger="ys";
/*
Italiano, inglese, greco, spagnolo, 
portoghese, macedone, romeno, polacco, albanese
*/
$languages_names=array(
//"fr"=>"Français",
"el"=>"ελληνικά", // greek
"en"=>"English",
"es"=>"Español",
"it"=>"Italiano",
"mk"=>"Македонски", ////Macedonian
"pl"=>"Polski",//polish
"pt"=>"Português",
"ro"=>"Română", //Romanian
"sq"=>"Shqipe", //Albanian
);


$languages_lcode=array(
//"fr"=>"Français",
"el"=>array("el"),
"en"=>array("en"),//array("uk","us"),
"es"=>array("es"),
"it"=>array("it"),
"mk"=>array("mk"),//"Македонски", ////Macedonian
"pl"=>array("ro"),//"Polski",//polish
"pt"=>array("pt"),
"ro"=>array("ro"),
"sq"=>array("sq"), //Albanian
);
 	


$supportedLangs=array("it","en"); //http://www.metamodpro.com/browser-language-codes
// http://corsoarabo.altervista.org/corso2005/punteggiatura.html

//$dlang =  substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
if ( $LANGURL) {
	$G["lang"]=$LANGURL;
}else{
	if ($_SESSION["lang"]=="en" || $_SESSION["lang"]=="it")  
		$G["lang"]=$_SESSION["lang"];
	else
		$G["lang"] =strtolower( 		substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
}
if ($G["lang"]!="en" && $G["lang"]!="it") $G["lang"]="en";

define("LANG", $G["lang"]);

$_SESSION["lang"] = $G["lang"];


//$strL="SELECT name,".LANG." FROM plang WHERE ".$lang_trigger."='1' ORDER BY id DESC";
$strL="SELECT name,".LANG." FROM plang WHERE 1 ORDER BY id DESC";


$qL=sql_query($strL);
if (sql_error()) {
    die ("DB not proprerly configured, mysql said: ".sql_error());
}
while (	$L=sql_assoc($qL)	){
	define ("L_".$L["name"],$L[LANG] );
}
//	echo "lang ".L_yes;die;

$month_january_b="gen";
$month_february_b="feb";
$month_march_b="mar";
$month_april_b="apr";
$month_may_b="mag";
$month_june_b="gi";
$month_july_b="lug";
$month_august_b="ago";
$month_september_b="sett";
$month_october_b="ott";
$month_november_b="nov";
$month_december_b="dic";
/*
define ("C_a_short_time_ago", "poco fa");
define ("C_today_at", "oggi alle");
define ("C_today", "oggi");
define ("C_yesterday", "ieri");
*/
$daysoftheweek_monday="lunedì";
$daysoftheweek_tuesday="martedì";
$daysoftheweek_wednesday="mercoledì";
$daysoftheweek_thursday="giovedì";
$daysoftheweek_friday="venerdì";
$daysoftheweek_saturday="sabato";
$daysoftheweek_sunday="domenica";

$month[1]=(L_month_january);
$month[2]=(L_month_february);
$month[3]=(L_month_march);
$month[4]=(L_month_april);
$month[5]=(L_month_may);
$month[6]=(L_month_june);
$month[7]=(L_month_july);
$month[8]=(L_month_august);
$month[9]=(L_month_september);
$month[10]=(L_month_october);
$month[11]=(L_month_november);
$month[12]=(L_month_december);
	
$month_b[1]=($month_january_b);
$month_b[2]=($month_february_b);
$month_b[3]=($month_march_b);
$month_b[4]=($month_april_b);
$month_b[5]=($month_may_b);
$month_b[6]=($month_june_b);
$month_b[7]=($month_july_b);
$month_b[8]=($month_august_b);
$month_b[9]=($month_september_b);
$month_b[10]=($month_october_b);
$month_b[11]=($month_november_b);
$month_b[12]=($month_december_b);



$daysoftheweek[0]=L_daysoftheweek_sunday;	
$daysoftheweek[1]=L_daysoftheweek_monday;
$daysoftheweek[2]=L_daysoftheweek_tuesday;
$daysoftheweek[3]=L_daysoftheweek_wednesday;
$daysoftheweek[4]=L_daysoftheweek_thursday;
$daysoftheweek[5]=L_daysoftheweek_friday;
$daysoftheweek[6]=L_daysoftheweek_saturday;

## constant
/*
define ("C_MONT_1", $monthnames[1]);
define ("C_MONT_2", $monthnames[2]);
define ("C_MONT_3", $monthnames[3]);
define ("C_MONT_4", $monthnames[4]);
define ("C_MONT_5", $monthnames[5]);
define ("C_MONT_6", $monthnames[6]);
define ("C_MONT_7", $monthnames[7]);
define ("C_MONT_8", $monthnames[8]);
define ("C_MONT_9", $monthnames[9]);
define ("C_MONT_10", $monthnames[10]);
define ("C_MONT_11", $monthnames[11]);
define ("C_MONT_12", $monthnames[12]);
*/

define ("C_MONT_1_B", $month_b[1]);
define ("C_MONT_2_B", $month_b[2]);
define ("C_MONT_3_B", $month_b[3]);
define ("C_MONT_4_B", $month_b[4]);
define ("C_MONT_5_B", $month_b[5]);
define ("C_MONT_6_B", $month_b[6]);
define ("C_MONT_7_B", $month_b[7]);
define ("C_MONT_8_B", $month_b[8]);
define ("C_MONT_9_B", $month_b[9]);
define ("C_MONT_10_B", $month_b[10]);
define ("C_MONT_11_B", $month_b[11]);
define ("C_MONT_12_B", $month_b[12]);

define ("C_WEEK_0", $daysoftheweek[0]);
define ("C_WEEK_1", $daysoftheweek[1]);
define ("C_WEEK_2", $daysoftheweek[2]);
define ("C_WEEK_3", $daysoftheweek[3]);
define ("C_WEEK_4", $daysoftheweek[4]);
define ("C_WEEK_5", $daysoftheweek[5]);
define ("C_WEEK_6", $daysoftheweek[6]);
/*
$CC=get_defined_constants(true);
echo "<!-- 
";
print_r($CC["user"]);

echo "
 -->
";
*/
?>