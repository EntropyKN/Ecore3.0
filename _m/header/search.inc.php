<?php
$CSSA[]=''.C_DIR.'/_m/header/search.css?';
$JSA[]=''.C_DIR.'/_m/header/search.js?';

$F.='<div id="hd_searchCont" class="opacity70">';
	//$F.='<div class="spin55" id="searchHeadLoading"></div>';
	$F.='<input type="text" id="Q" name="Q'.$PAGE_RANDOM.'" />';
	$F.='<div id="QFake">'.L_HEAD_SEARCH_WELCOME_EDT."</div>";//just editor
	$F.='<a href="#" id="headSearchI"></a>';
$F.='</div>';
$F.='<div id="hd_searchRes_box_cont" class="boxfb">';
	//$PAGE_HEADER_COMMON.='<span id="SEnoResults">Nessun Risultato</span>';
	//loop
$F.='</div>';		
			?>