<?php
$page["titlePre"]="Editor - ";


//print_r($DIRA);die;
/* Array ( 
	[1] => editor
	[2] gameId  // 0 new
	[3] => 1 edit step 0 1 2
	
	Array ( 
	[1] => editor 
	[2] => 1 
	[3] => 2 ) 
) 
/2/1
*/
//print_r($DIRA);

$editorstep=0;if ($DIRA[3]==1) $editorstep=1;
$gameId=0; if ($DIRA[2] && is_numeric($DIRA[2]) ) $gameId=$DIRA[2];

require_once(C_ROOT."/_m/editor/$editorstep/editor_$editorstep.inc.php");




?>
