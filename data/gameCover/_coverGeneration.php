<?
// https://to.sgameup.com/data/gameCover/_coverGeneration.php
error_reporting(E_ALL ^ E_NOTICE);ini_set("display_errors",1);
header('Content-Type: application/json; charset=utf-8');
include_once($_SERVER['DOCUMENT_ROOT']."/config/config.inc.php");
require_once(C_ROOT."/config/lang.inc.php");

echo "<pre>";
$D=array();
/*$D["q"]="select G.gameId, S.step, S.scene,
S.	scenario_id , S.avatar_id 
FROM games G right join games_steps S on S.gameId=G.gameId where S.step=1 and S.scene='A' ORDER BY G.gameId";
*/

$D["q"]="select S.gameId, 
/*S.step, S.scene,*/
S.	scenario_id , S.avatar_id 
FROM  games_steps S where S.step=1 and S.scene='A' ORDER BY S.gameId";


$q=sql_query($D["q"]);

while (	$d=sql_fetch_assoc($q)) {
    $d["createImgGameCover"]=createImgGameCover($d["gameId"], $d["avatar_id"], $d["scenario_id"]);
    $D["d"][]=$d;
}

print_r($D);
?>