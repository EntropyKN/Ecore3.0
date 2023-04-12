<?php
$text["en"]="A new avatar, how can I do it?|
Each animated avatar consists of<br />
- two transparent PNG files<br />
- each containing <strong>20 frames of size 500x1,098 pixels</strong>.<br />
Therefore, each of the two PNGs measures 1,098x10,000 pixels|

When the character is waiting or listening, but obviously not completely motionless.<br />
He/she blinks, breathes, maybe touches his/her arm etc.|

When the avatar speaks to the player|

The PNG format|
The recommended format is 8bit PNG, Palette adaptive, index transparency.<br />
The weight of each animation ranges from 50 to 250 Kb according to the complexity of the images.|

Examples Zip Download:|Download a zip with PNG examples|Download a zip with PSD examples|

Upload your avatar:|
Load the first animation: 'Waiting'|
1. Quiet/listening Animation loaded|
Load the second animation: 'Talking'|
2. Talking animation loaded|

Now write the name of the new Avatar:|
Duplicates and numbers are not permitted.<br />
Choose a simple name such as Gianfilippo or a full name like 'John Smith'<br />
or short and descriptive like Thomas Plumber, Doctor Elishabeth.|
Hey ".$_SESSION["name"].",<br />thanks for creating me!|
Pleaseeee ".$_SESSION["name"].",<br />tell me i'm speaking :-) |
Nice going, your avatar is ready to be used in the  <a href=\"/?/editor/0/0\">Game editor</a> |
You rock ".$_SESSION["name"]."!<br />See you in the <a href=\"/?/editor/0/0\">Game editor</a>!|";

////////////////////
$text["it"]="Un nuovo avatar, come fare?|
Ogni avatar animato consiste in<br />
    - due file PNG trasparenti<br />
    - contenenti ognuno <strong>20 frame di dimension 500x1098 pixel</strong>.<br />
Ognuna delle due PNG misura quindi 1.098x10.000 pixel|

Quando il personaggio è in attesa o in ascolto, ma ovviamente non del tutto immobile.<br />
Sbatte le palpebre, respira, magari si tocca un braccio etc.|

Quando parla al giocatore|

Il formato|
Il formato consigliato è PNG 8bit, Palette adaptive, index transparency.<br />
Il peso di ogni animazione va dai 50 agli 250 Kb a seconda della complessità delle immagini.|

Download Esempi:|Scarica zip con esempi PNG|Scarica zip con esempi PSD|

Carica il tuo avatar:|
Carica la prima animazione: Waiting|
1. Quiet/listening Animation caricata|
Carica la seconda animazione: Talking|
2. Talking animation caricata|

Ora scrivi il nome del nuovo Avatar:|
Duplicati e numeri non sono ammessi.<br />
Scegli un nome semplice come Gianfilippo o nome e cognome<br />
oppure breve e descrittivo come Pippo Idraulico, Nina Dottoressa e simili|
Hey ".$_SESSION["name"].",<br />grazie per avermi creato!|
Ti prego ".$_SESSION["name"].",<br />dimmi che sto parlando :-)|
Complimenti, il tuo avatar è pronto per essere utilizzato nel <a href=\"/?/editor/0/0\">Game editor</a>|
Grazie ".$_SESSION["name"]."!<br />Ci vediamo nel <a href=\"/?/editor/0/0\">Game editor</a> ;-)|";
if (LANG=="it") $textData=$text["it"];
else $textData=$text["en"];

$textData=str_replace('
', '',$textData);
$t=explode("|",$textData);

/////////////////////////
$HEAD_ADD.='<script type="text/javascript">var L_the_file_size_is_too_large ="'.L_the_file_size_is_too_large.'";var L_the_file_size_is_too_large ="'.L_the_file_size_is_too_large.'";</script>';



$JSA[]=''.C_DIR.'/_m/avatarUpload/avatarUpload.js?'.PAGE_RANDOM;
$CSSA[]=''.C_DIR.'/_m/avatarUpload/avatarUpload.css';
##############
$page["titlePre"]=L_upload_your_avatar." - ";

$O.='<div id="mask" class="opacity50"></div>';
$O.='<div id="core" data-c="'.generate_code_filesafe(8).'">'; 
	require_once(C_ROOT."/_m/header/header.inc.php");
	$O.='<div id="coreIn">';
    
    $O.='<div id="explain">';
    
    $O.="<div class=\"title1\">".$t[0]."</div>";
    $O.="<div class=\"content1 marginBottom\">".$t[1]."</div>";
    
$O.="<div class=\"title2\">1. Quiet/listening Animation</div>";
$O.="<div class=\"content1 marginBottom\">".$t[2]."</div>";

$avatarId="5";

$O.='<div class="iFrameLike marginBottom">';
    $O.='<a title="Apri in nuova finestra" target="_blank" href="/data/avatar_prev/1/'.$avatarId.'_10Kx1098_wait.png"><img src="/data/avatar_prev/1/'.$avatarId.'_10Kx1098_wait.png" /></a>';
$O.="</div>";

$O.="<div class=\"title2\">2. Talking animation</div>";
    $O.="<div class=\"content1 marginBottom\">".$t[3]."</div>";

$O.='<div class="iFrameLike marginBottom">';
    $O.='<a title="Apri in nuova finestra" target="_blank" href="/data/avatar_prev/1/'.$avatarId.'_10Kx1098_talk.png"><img src="/data/avatar_prev/1/'.$avatarId.'_10Kx1098_talk.png" /></a>';
$O.="</div>";


$O.="<div class=\"title2\">".$t[4]."</div>";
    $O.="<div class=\"content1 marginBottom\">".$t[5]."</div>";

//$O.="<div class=\"downloadSet title2 marginBottom\">".$t[6]."</div>";
    $O.='<div class="content1 marginBottom"><a class="linkD" href="/data/download/avatar_example_PNG.zip">'.$t[7].'</a></div>';

$O.="</div>"; // $O.='<div id="explain">';

 $O.='<div id="done0">';
//////////////
    $O.="<div id=\"attachmentCont\">";
        $O.='<input id="attachmentInput1" type="file" accept="image/png" class="attachmentInputC" name="ATT'.PAGE_RANDOM.'" >';
        $O.='<input id="attachmentInput2" type="file" accept="image/png" class="attachmentInputC" name="ATT'.PAGE_RANDOM.'" >';
    $O.="</div>";
    //////////////
    $O.="<div class=\"title1 marginBottom\">".$t[9]."</div>";
    //<li>asdasdasdasda</li><li>asdasdasdasda</li>



    $O.="<div id=\"load1\" class=\"buttonS marginBottom\">".$t[10]."</div>";

    $O.="<div id=\"issueC\"><div id=\"issue\" class=\"content_advice marginBottom\"><span>...</span><button id=\"closeAdvice\">OK</button></div></div>";
    $O.="<div class=\"clear\"></div>";
$O.="</div>"; // $O.='<div id="done0">';


    //1
    $O.="<div id=\"done1\">";
        $O.="<div class=\"marginBottom title2\"><img alt=\"\" src=\"/img/ico/ok16.png\" />".$t[11]."</div>";
        $O.="<div class=\"clear\"></div>";

        $O.='<div id="fakePlayer1" class="fakePlayer">'; //pointer_left.png
            $O.='<div id="avatarSprite1" class="wait_M" style="background: url(\'/data/avatar_prev/1/1_10Kx1098_wait.png\') left center;background-size: 3200px 383.36px;"></div>';
            $O.='<div class="balloon"><span>'.$t[16].'</span>';
            $O.='<img src="/img/pointer_right.png" class="rightArrow" alt="" ></div>';
            
        $O.='</div>';
        $O.="<div class=\"clear\"></div>";

        //2
        $O.="<div id=\"load2\" class=\"buttonS marginBottom\">".$t[12]."</div>";
        $O.="<div class=\"clear\"></div>";
    $O.="</div>";// done1

    $O.="<div id=\"done2\">";
        $O.="<div class=\"title2 marginBottom\"><img alt=\"\" src=\"/img/ico/ok16.png\" />".$t[13]."</div>";
        $O.="<div class=\"clear\"></div>";

        $O.='<div id="fakePlayer2" class="fakePlayer">'; //pointer_left.png
            $O.='<div id="avatarSprite2" class="wait_M" style="background: url(\'/data/avatar_prev/1/1_10Kx1098_talk.png\') left center;background-size: 3200px 383.36px;"></div>';
            $O.='<div class="balloon">';
                $O.='<span id="b17">'.$t[17].'</span>';
                $O.='<span id="b19">'.$t[19].'</span>';
                $O.='<img src="/img/pointer_right.png" class="rightArrow" alt="" >';
            $O.='</div>';
        $O.='</div>';

    $O.="<div class=\"title2\">".$t[14]."</div>";
    $O.='<div class="content1 marginBottom">'.$t[15].'</div>';

        $O.='<input id="avatarName" value="" maxlength="64" type="text">';


$O.="<div class=\"options1 clear\">";
            $O.='<label class="container">'.L_male.'<input type="radio"  value="m" checked="checked" name="sex"><span class="checkmark"></span></label><label class="container">'.L_female.'<input type="radio" value="f" name="sex"><span class="checkmark"></span></label>'; 
      //<label class="container">'.L_non_binary.'<input type="radio" value="n"  name="sex"><span class="checkmark"></span></label>
    $O.="</div>";
            $O.="<div id=\"saveAll\" class=\"buttonS marginBottom\">".L_save."</div>";        
        
    $O.="</div>";// done2

    $O.="<div id=\"doneFinal\">";
        $O.="<div class=\"title2 marginBottom\"><img alt=\"\" src=\"/img/ico/ok16.png\" />".$t[18]."</div>";
        $O.="<div id=\"finalSentence\" class=\"clear\"></div>";    
    $O.="</div>";// doneFinal


//$O.='<div id="avatarSprite" class="wait_S" style="background: url(\'/data/avatar_prev/1/1_10Kx1098_wait.png\') left center;"></div>';
$O.="<div style=\"height:40px\" class=\"clear\"></div>";

//$O.='<pre>'.print_r ($t,true);
/////////////////
    $O.="</div>";//coreIN
/////////////////////////////
$O.="</div>";//coreIN
$O.="</div>";//core
