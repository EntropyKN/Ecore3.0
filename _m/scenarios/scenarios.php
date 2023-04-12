<?php

$JSA[]=''.C_DIR.'/js/plugins/jcrop/jquery.Jcrop.min.js';
$JSA[]=''.C_DIR.'/_m/scenarios/scenarios.js?'.PAGE_RANDOM;
$CSSA[]=''.C_DIR.'/_m/scenarios/scenarios.css';
$CSSA[]=''.C_DIR.'/_m/scenarios/search.css';
$CSSA[]=''.C_DIR.'/js/plugins/jcrop/jquery.Jcrop.min.css';
$HEAD_ADD.='<script type="text/javascript">var L_no_results ="'.L_no_results.'";var L_are_you_sure_to_delete_this ="'.L_are_you_sure_to_delete_this.'";</script>';

/*  
go to scenarios from editor 
https://to.sgameup.com/?/scenarios/jBAm3KDRWdSVTNnTYFKr4g== 
jBAm3KDRWdSVTNnTYFKr4g== stands for add|95|2|C cyrpta

go to editor from scenarios


*/
##################### game referral data
$D=array();
$backUrl=false;
if ($DIRA[2]) $urlParDecrypted=rawurldecode(decrypta($DIRA[2]));
if ($urlParDecrypted) $D["udata"]=explode("|", $urlParDecrypted);
//echo "urlParDecrypted $urlParDecrypted ";print_r($DIRA);print_r($D["udata"]);die();

if ($D["udata"][0]=="add" && $D["udata"][1] && is_numeric($D["udata"][1]) && $D["udata"][2] && $D["udata"][3]) {
    $D["game"]=sql_queryt("select title from games where gameId=".db_string($D["udata"][1])." AND uid_creator=".$_SESSION["uid"]);
    
    $scenarioQ=sql_queryt("SELECT scenario_id FROM `games_steps` WHERE gameId='".db_string($D["udata"][1])."' and step='".db_string($D["udata"][2])."' and scene='".db_string($D["udata"][3])."'");
    $D["game"]["current_scenario_id"]=$scenarioQ["scenario_id"];
    $backUrl="/?/editor/".$D["udata"][1]."/1/".$D["udata"][2]."/".$D["udata"][3];
}
$currentScenario=0;
if ($D["game"]["current_scenario_id"]) $currentScenario=$D["game"]["current_scenario_id"];
$O.='<div id="dataH" data-currentScenario="'.$currentScenario.'" data-subset="all"></div>'; //   data-subset: all mine recent

##############
$page["titlePre"]=L_scenarios." ";

$O.='<div id="mask" class="opacity50"></div>';
$O.='<div id="core" data-idtrans="'.$idtrans.'" data-tsaved="'.$tsaved.'">'; 
	require_once(C_ROOT."/_m/header/header.inc.php");
	$O.='<div id="coreIn">';
    
    
$O.='<div id="cmdBar" class="">';
//$O.='';
//$backUrl
    if ($backUrl) $O.='<a href="'.$backUrl.'" title="'.L_back_to_editor.'" class="tTabRIGHT"><img alt="" src="/img/ico/arrowLeft8.png" /></a>';
    $O.='<div id="t1" class="tTab tTabActive">'.L_all.'</div>';
    $O.='<div id="t2" class="tTab">'.L_my_scenarios.'</div>';
    $O.='<div id="t3" class="tTab">'.L_recently_used_PLURAL.'</div>';
    if ($_SESSION["ulevel"]=="3") {
        $O.='<div id="t4" class="tTab">Public wannabe</div>';
        $O.='<div id="t5" class="tTab">'.L_add.'</div>';
    }else{
        $O.='<div id="t5" class="tTab tabQ">'.L_add.'</div>';//<img alt="" src="/img/ico/plus12.png" />
    
    }
    
    $O.='<div class="tabLine"></div>';
    
$O.='</div>'; // bar end
$O.='<div class="clear"></div>';

$O.='<div id="upContainerLL">';
    $O.='<div id="upContainerL1">';
        // search
        $O.='<div id="hd_searchCont" class="opacity70">';
            $O.='<input type="text" id="Q" name="Q'.$PAGE_RANDOM.'" />';
            $O.='<div id="QFake">'.L_search."</div>";//just editor
        $O.='</div>';
    $O.='</div>';

    $O.='<div class="clear"></div>';

    $O.='<div id="upContainerL" data-page="0" data-nextPage="1">';
    $O.='</div>';
$O.='</div>';//LL

$O.='<div id="upContainerR" class="">';

        $O.='<div id="fakePlayer">'; //pointer_left.png
            $O.='<img id="scenarioImg" src="/data/scenarios/blackPixel.png" class="sceneimg" alt="" />';
        $O.='</div>';	


///////////////////////////////////////////////////////cont
    $O.='<div class="clear"></div>';
    $O.='<div id="sContent">';
        $O.='<div id="sName" class="subtitleS">';
        $O.='';
        $O.='</div>';
        $O.='<div id="sAttribs" class="sAttribC">'; //
            $O.='<span id="sPublic">'.L_public.'</span><span id="sPrivate">'.L_private.'</span><span id="sWaiting">('.L_waiting_to_go_public.')</span><span>-</span><span id="SusedN">?</span> <span id="Sused">games</span>';
            $O.=' <span>-</span> <span id="createBy">'.L_created_by.'</span> <span id="createByC">n/a</span>';
            $O.='<span id="Sago"></span>';
            $O.='<span id="dashDelete"> - </span><span title="'.L_are_you_sure.'" id="sDelete" data-ids="0">'.strtolower(L_delete).'</span>';
            
        $O.='</div>';


        
        if ($D["udata"][0]=="add" && $D["udata"][1] && is_numeric($D["udata"][1]) && $D["udata"][2] && $D["udata"][2]) {
           //$DGame=sql_queryt("select title from games where gameId=".db_string($urlData[1])." AND uid_creator=".$_SESSION["uid"]);
            //$DGame=sql_queryt("select title from games ORDER BY RAND() LIMIT 1");

            $O.='<div id="saveInGame" class="buttonS">'.L_use_this_scenario_in.'<div class="bsTitle"><i>"'.text_cut($D["game"]["title"],26).'"</i> - Step '.$D["udata"][2].''.$D["udata"][3].'</div></div>';
            $O.='<div id="alreadyUsed"><img alt="" src="/img/ico/ok16.png" />'.L_currently_used_in_the_game.': '; //L_currently_used_in_the_game
                $O.='<a href="'.$backUrl.'" class="bsTitle">"'.text_cut($D["game"]["title"],26).'" - Step '.$D["udata"][2].''.$D["udata"][3].'</a>';
                $O.='<a href="'.$backUrl.'" class="littleBut"><img alt="" src="/img/ico/arrowLeft8.png" />'.L_back_to_editor.'</a>';
            $O.='</div>';
            
            $O.='<div class="clear"></div>';

        }
        if ($_SESSION["ulevel"]==3) {
            $O.='<div id="switch2public" class="buttonS">'.L_make_it_public.'</div>';
            $O.='<div id="done"><img alt="" src="/img/ico/ok16.png" />'.L_done.'</div>';
        }
        
//            $O.="<pre>".print_r($DIRA, true).' '.print_r($DGame, true).' urlData '.print_r($urlData, true)."</pre>";
//            $O.="<pre>".print_r($D, true)."</pre>";          
    
    $O.='</div>';
$O.='</div>';	//upContainer end

/////////////////////////
$O.='<div id="cropArea">';
    $O.='<input id="attachmentInput" type="file" accept="image/png, image/gif, image/jpeg" class="attachmentInputC" name="ATT'.PAGE_RANDOM.'" >';
    $O.='<div id="cropNsave" class="buttonS">'.L_save.'</div>';
    $O.='<div id="cropDone"><img alt="" src="/img/ico/ok16.png" />'.L_done.'</div>';
    $O.='<div class="subtitle">'.L_scenarios_name.':</div>';
    //$O.='<div class="clear"></div>';
    $O.='<input id="scenariosTitle" value="" maxlength="64" type="text">';
    $O.='<div class="clear"></div>';
    $O.='<label class="CBcontainer">'.L_it_can_be_used_by_all_editors.' ('.L_public.')<input type="checkbox" id="askPublic" checked="checked"><span class="checkmark"></span></label>';
    
    $O.='<div class="clear"></div>';
    $O.='<div id="cropLegend">'.L_drag_and_resize_the_highlighted_area.':</div>';
    $O.='<div class="clear"></div>';
    $O.='<img width="760" src="/data/scenarios/blackPixel.png" id="cropbox" />';
    //$O.='<img src="/data/scenarios/blackPixel.png" id="cropped_img"" />';
    
    $O.='<div class="clear"></div>';
    
$O.='</div>';
/////////////////////////////
$O.="</div>";//coreIN
$O.="</div>";//core