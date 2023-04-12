<?php
	//if (!$G["bot_initial_escalation"]) $G["bot_initial_escalation"]="0";
	$O.='<div id="playerConsoleCont" data-time="'.time().'" data-match="0" data-gameId="'.$G["gameId"].'" data-step="0" data-steps="'.($G["steps"]-1).'" data-answerN="'.$G["s"][0]["answerN"].'" data-playing="0" data-lastB="N" data-lastBF="N" data-cscore="0" data-cscorestory="0" class="playerConsoleTall">';
	//$O.='<div id="playerConsoleCont" class="playerConsoleTall" data-cscorestory="30,0,60,-40" data-cscore="50" data-lastbf="5" data-lastb="2" data-lastu="2" data-sgroups="3" data-states="2" data-state="2">';
		$O.='<div id="choiceCont">';
			$O.='<div id="choice">';
				$O.='<div id="choiceH">';
					$O.='<a class="closeChoice" href="#">X</a>';
				$O.="</div>";
				$O.='<div id="choiceC">';
				for ($x = 1; $x <= 4; $x++) {
					
					$O.='<div class="choiceOpt" id="opt_'.$x.'">';
						$O.='<div id="say_'.$x.'" class="sayOpt" data-scene="A">';
						$O.=$G["s"][0]["answer_".$x];
						$O.="</div>";
						//$O.='<div title="'.L_preview.'" class="previewOpt">';
						//	$O.='<img id="sayimg_'.$x.'"  class="avtrt" src="/data/imgavtr/faceEmotions/1/1.jpg" alt="" />';
						//	$O.='<img class="playprev" src="/img/ico/playvideo14x14.png" alt="" />';
						//$O.="</div>";
						$O.='<div id="send_'.$x.'" class="sendOpt">';	//style="background-image: url(/img/ico/emoticonsW/'.$emo[$x].')" title="'.L_DFORM_send.'"  
							$O.="<span>";$O.=L_say_it;$O.="</span>";
							//$O.='<img src="/img/ico/emoticonsW/'.$emo[$x].'" width="20" height="20" alt="" />';
						$O.="</div>";

						
					$O.="</div>";
				//	$O.="text ".$x." ".$say[$x]."<br />"
				;}
				
				$O.="</div>";
			$O.="</div>";
		$O.="</div>";
		$O.='<div id="playerConsole">';
			$O.='<div class="opacity50 playerConsoleMask"></div>';
			//$O.='<div class="playerConsoleCont">';
				$O.='<div data-saywhat="1" data-sayord="1" id="say" data-scene="A">';
					//$O.=$say[$sayRND];
				$O.="</div>"; //playerConsoleCont

				
				$O.='<div id="playerConsRight">';
					$O.='<div id="playerTools">';
						
						$O.='<a id="next" class="" title="'.L_next.'" href="#"></a>';
						$O.='<a id="prev" class="" title="'.L_previous.'" href="#"></a>';
						$O.='<a id="up" class="" title="'.L_show_all.'" href="#"></a>';

					$O.="</div>";
					$O.='<div id="send">'.L_say_it.'</div>';  //<img src="/img/ico/emoticonsW/'.$emo[$RNDemo].'" width="20" height="20" alt="" />	 class="" title="'.L_DFORM_send.'"
				$O.="</div>";				
		$O.="</div>";//playerConsole
	$O.="</div>";
?>