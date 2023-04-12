<?php
error_reporting(E_ALL ^ E_NOTICE);ini_set("display_errors",1);
//https://to.sgameup.com/_m/avatarUpload/test.php?Aaaaaaaasssssssssss
$D["img"]=$_SERVER['DOCUMENT_ROOT'].'/data/avatar_prev/1/6_10Kx1098_wait.png';
$D["newId"]=6;
if ($_GET["newId"])  {
    $D["newId"]=$_GET["newId"];
    $D["img"]=$_SERVER['DOCUMENT_ROOT'].'/data/avatar_prev/1/'.$D["newId"].'_10Kx1098_wait.png';
}
if (!file_exists($D["img"])) die($D["img"]);

$img_r = imagecreatefrompng($D["img"]);

// 1 frame
$dst_r = ImageCreateTrueColor( 500, 1098 );
imagealphablending( $dst_r, false );
imagesavealpha( $dst_r, true );
imagecopyresampled($dst_r, $img_r, 0, 0, 0, 0, 500, 1098, 500, 1098);

$D["1098"]=imagepng($dst_r,  $_SERVER['DOCUMENT_ROOT'].'/data/avatar_prev/1/'.$D["newId"].'_500x1098.png');
imagedestroy($dst_r);

//thumb 50%
$dst_r = ImageCreateTrueColor( 250, 549  );
imagealphablending( $dst_r, false );
imagesavealpha( $dst_r, true );
imagecopyresampled($dst_r, $img_r, 0, 0, 0, 0, 
250, 549, 
500, 1098);
$D["250"]=imagepng($dst_r,  $_SERVER['DOCUMENT_ROOT'].'/data/avatar_prev/1/'.$D["newId"].'_250x549.png');
imagedestroy($dst_r);

//thumb 50% square

$dst_r = ImageCreateTrueColor( 250, 250  );
imagealphablending( $dst_r, false );
imagesavealpha( $dst_r, true );
imagecopyresampled($dst_r, $img_r, 0, 0, 0, 0, 
250, 250, 
500, 500);
$D["square"]=imagepng($dst_r,  $_SERVER['DOCUMENT_ROOT'].'/data/avatar_prev/1/'.$D["newId"].'_250x250.png');
imagedestroy($dst_r);
echo "<pre>";
print_r($D);

//header ('Content-Type: image/png');imagepng($dst_r); //, $D["destination"]
/////////////////////imagealphablending( $dst_r, false );imagesavealpha( $dst_r, true );
//$D["destinatonPath"]=$_SERVER['DOCUMENT_ROOT']."/data/scenarios/" . $D["newID"]."_1024.jpg";
//header ('Content-Type: image/png');imagepng($dst_r);

?>