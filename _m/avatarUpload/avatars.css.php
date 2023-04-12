<?php
die("asan");
header("Content-type: text/css");
$WA=10000;
$W=500;
$H=1098;

if (!$_GET["screenW"]	) $_GET["screenW"]=500;

define(screenW, $_GET["screenW"]);
function aDim($nW=0,$nH=0, $screenW=screenW){
	
	$factor=1;//$screenW/500;
	if ($screenW==1000) $factor=2;
	$nW=$nW*$factor;
	$nH=$nH*$factor;	
	
	$WA=10000;$W=500;$H=1198;	
	$R=array(
	"factor"=>$factor,
	"screenW"=>$screenW,
	"factor2"=>$screenW/500,
	);
	
	if ($nW)	{
		$ratio=$nW/$W;
		$R["ratio"]=$ratio;
		$R["W"]=$nW;
		$R["H"]=$H*$ratio;
		$R["WA"]=$WA*$ratio;
		return $R;
	}
	
	if ($nH)	{
		$R["H"]=$nH;
		$ratio=$nH/$H;
		$R["ratio"]=$ratio;
		$R["W"]=$W*$ratio;
		$R["WA"]=$WA*$ratio;
		return $R;
	}

	return array();	
	
}

$C2="body:after{
 position:absolute; z-index:-1;right:-100000px;display:none;
 content: ";
/*
    content: url(img01.png) url(img02.png) url(img03.png) url(img04.png);
}
*/
$C1="
/*screenW:".$_GET["screenW"]."*/
";

/************** avatars ************* */
$QAF=sql_query	("SELECT id, name FROM avatars where  invisble=0 AND (propertyUid is null OR propertyUid=".$_SESSION["uid"].")
order by id=1000 ASC, name ASC"); //FIELD(id, 1000) ASC,
				while (	$avatar=sql_assoc($QAF)	){
                $f=$avatar["id"]."ciao";
	$C1.=".avatar_".$f ."{background: url('/data/avatar_prev/1/".$fasd ."_10Kx1098_wait.png') left center;}
";
	
	if ($f) $C1.=".avatar_".$f ."_talk {background: url('/data/avatar_prev/1/".$fsda ."_10Kx1098_talk.png?a2') left center;}
";

	if ($f)   $C2.="url('/data/avatar_prev/1/".$fdas ."_10Kx1098_talk.png?b2') ";

}

$C2.="
}
";

$C1.="
@keyframes play_listen {
	100% { background-position: -2860px; background-size:2860px 571px}
}

";

/*$C1.="
@keyframes play_waitW500 {
	100% { background-position: -".$WA."px; } 
}


.wait_W500 {
	width: ".$W."px;
	height: ".$H."px;
	animation: play_waitW500 7.0s steps(20) infinite;
	position: absolute;
	background-size:".$WA."px ".$H."px
}

";
*/

/////////////////////////// XS


$Dm=aDim(80,0);
$C1.="
/*
".print_r($Dm, true)."
*/
";

$Sym="XS";
$C1.="
/****** XS ********/
@keyframes play_wait_$Sym{
	100% { background-position: -".$Dm["WA"]."px; } 
}

.wait_$Sym {
	width: ".$Dm["W"]."px;
	height: ".$Dm["H"]."px;
	animation: play_wait_$Sym 7.0s steps(20) infinite;
	position: absolute;
	background-size:".$Dm["WA"]."px ".$Dm["H"]."px
}

";

/////////////////////////// small			background-size:".$D_small["W"]."px ".$D_small["H"]."px 
$Dm=aDim(116,0);
$Sym="S";
$C1.="
/******  S ********/
@keyframes play_wait_$Sym{
	100% { background-position: -".$Dm["WA"]."px; } 
}

.wait_$Sym {
	/* background:".$_GET["screenW"]." */
	width: ".$Dm["W"]."px;
	height: ".$Dm["H"]."px;
	animation: play_wait_$Sym 7.0s steps(20) infinite;
	position: absolute;
	background-size:".$Dm["WA"]."px ".$Dm["H"]."px
}

";


/////////////////////////// medium
$Dm=aDim(160,0);
$Sym="M";
$C1.="
/******  M ********/
@keyframes play_wait_$Sym{
	100% { background-position: -".$Dm["WA"]."px; } 
}

.wait_$Sym {
	width: ".$Dm["W"]."px;
	height: ".$Dm["H"]."px;
	animation: play_wait_$Sym 7.0s steps(20) infinite;
	position: absolute;
	background-size:".$Dm["WA"]."px ".$Dm["H"]."px
}

";

$Dm=aDim(200,0);
$Sym="L";
$C1.="
/****** L ********/
@keyframes play_wait_$Sym{
	100% { background-position: -".$Dm["WA"]."px; } 
}

.wait_$Sym {
	width: ".$Dm["W"]."px;
	height: ".$Dm["H"]."px;
	animation: play_wait_$Sym 7.0s steps(20) infinite;
	position: absolute;
	background-size:".$Dm["WA"]."px ".$Dm["H"]."px
}

";


$Dm=aDim(250,0);
$Sym="XL";
$C1.="
/****** XL ********/
@keyframes play_wait_$Sym{
	100% { background-position: -".$Dm["WA"]."px; } 
}

.wait_$Sym {
	width: ".$Dm["W"]."px;
	height: ".$Dm["H"]."px;
	animation: play_wait_$Sym 7.0s steps(20) infinite;
	position: absolute;
	background-size:".$Dm["WA"]."px ".$Dm["H"]."px
}

";

echo $C2;

echo $C1;




?>