<?php
$F1=array(
"idg",
"name",
"description_it",
"gymsCSV",
"usersCSV",
"insightesrCSV"
);

$F1t=array(
'',
L_group_name,
L_description,
L_games,
L_users,
L_insighters,
);

$F1Show=array(
false,
true,
true,
false,
false,
false,
);


$F1f=array(
"input",
"input",
"area",
"input",
"input",
"input",
);

$HEAD_ADD.='<script type="text/javascript">var F1='.json_encode($F1).';var F1t='.json_encode($F1t).';var F1f='.json_encode($F1f).'</script>';

//////////// LANG FOR JS
/*$jsLang = array
  (
  array("L_nothing_yet",L_nothing_yet),
  array("L_new_group",L_new_group),
  array("L_edit_group",L_edit_group),
  );*/
  
$jsLang = array(
"L_nothing_yet"=>L_nothing_yet,
"L_new_group"=>L_new_group,
"L_edit_group"=>L_edit_group,
"L_saved"=>L_saved,
  );  
  
$HEAD_ADD.='<script type="text/javascript">';
foreach( $jsLang as $key => $value ) {
	$HEAD_ADD.="var $key=".json_encode($value).";";
}
$HEAD_ADD.='</script>';


?>