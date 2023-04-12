<?php
		$O.='<div id="explain" class="pop">'; //loadingInfo
		
			$O.='<div id="explainH">';
				$O.='<div id="ac">';
					//$O.='<a href="#">More</a>';
					$O.='<a id="logshow" href="#">'.L_dialogue.'</a>';
					//$O.='<a id="infoChars" href="#">'.L_charaters.'</a>';
					$O.='<a id="infoMain" class="onA" href="#">'.L_INFO_main.'</a>';					
				$O.="</div>";				
				$O.='<div class="sep"></div>';
				
			$O.="</div>";
			$O.='<div id="contentH">';	
				##############################
				$O.='<span id="infoMainC">';
					/*$O.="<div class=\"infoImageT\">";
						$O.='<img src="'.$G['coverPath'].'" alt="" />';//ong701_   //long385_
					$O.="</div>";*/
					$O.='<div class="clear"></div>';
					$O.="<div class=\"title\">".$G['title']."</div>";
                    if ($G["credits"]) $O.=$G["credits"];
					$O.="".nl2br($G['Description']);
					
					if ($G['Goal_1']){
					$O.="<div class=\"title\">".L_goals."</div>";
						$O.=nl2br( $G['Goal_1']);
						if ($G['Goal_2']) $O.="<br />".nl2br( $G['Goal_2']);
						if ($G['Goal_3']) $O.="<br />".nl2br( $G['Goal_3']);
						if ($G['Goal_4']) $O.="<br />".nl2br( $G['Goal_4']);
						if ($G['Goal_5']) $O.="<br />".nl2br( $G['Goal_5']);
					}
				$O.="</span>";
				
				/*$O.='<span id="infoCharsC">';
					$O.="<div class=\"col1\">";
						$O.="<div class=\"infoImage\">";
							$O.='<img src="/data/imgavtr/info_360x202_'.$G["usr_avatar_id"].'.jpg" alt="" />';
							$O.="<span id=\"username\">".$G['usr_name']." (".L_you.")</span>";
						$O.="</div>";
						$O.='<div class="clear"></div>';
						// user
						if ($G['usr_description']) $O.=$G['usr_description']; 
						//	usr_goal1
						if ($G['usr_goal1']){
							$O.="<div class=\"title\">".L_goals.":</div>";
							$O.=$G['usr_goal1'];
							if ($G['usr_goal2']) $O.="<br />".$G['usr_goal2'];
							if ($G['usr_goal3']) $O.="<br />".$G['usr_goal3'];
						}
					$O.="</div>";
						
					$O.="<div class=\"col2\">";
						$O.="<div class=\"infoImage\">";
							$O.='<img src="/data/imgavtr/info_360x202_'.$G["bot_avatar_id"].'.jpg" alt="" />';
							$O.="<span id=\"botname\">".$G['bot_name']."</span>";
						$O.="</div>";
						$O.='<div class="clear"></div>';
						// bot
						if ($G['bot_description']) $O.=$G['bot_description']; 
						//	usr_goal1
						if ($G['bot_goal1']){
							$O.="<div class=\"title\">".L_goals.":</div>";
							$O.=$G['bot_goal1'];
							if ($G['bot_goal2']) $O.="<br />".$G['bot_goal2'];
							if ($G['bot_goal3']) $O.="<br />".$G['bot_goal3'];
						}
					$O.="</div>";
				$O.="</span>";
				*/
				$O.='<span id="logC">';
					$O.="<span class=\"tmptxt\">";
						/*$tmptext=str_replace("#user#", $G['usr_name']." (".L_you.") ", L_DIALOGUE_BOX_LOG_INTRO);
						$tmptext=str_replace("#bot#", $G['bot_name'], $tmptext);					
						$O.=$tmptext;
						*/
					$O.=L_DIALOGUES_BOX_LOG_INTRO."</span>";
					/*$O.="<span class=\"usr\">";
						$O.="<span>Pinuccio</span>: ";
						$O.='ecco un testo qualunque ma in fondo davvero consono, non trovate? beh, io si . A dirla tutta mi viene facileecco a in fondo davvero consono, non trovate? beh, io si . A dirla tutta mi viene facilenon trovate? beh, io si . A dirla tutta mi viene facile ecco un testo qualunque ma in fondo davvero consono, non trovate? beh, io si . A dirla tutta mi viene facile12 sdaasda dsad asda sda sdasd asdasd asdas dasd asda sdasd asdasd asd das das das asdasd asd asd  asasasdasasdasd ';
					$O.="</span>";			
					$O.="<span class=\"bot\">";
						$O.="<span>Giorgetto</span>: ";
						$O.='a domanda rispondo';
					$O.="</span>";*/
				$O.="</span>";
				
				//$O.="<br /><br />";
//				for ($x = 0; $x <= $num[$RNDnum]; $x++) {$O.="text ".$x." ".$say[$x]."<br />";}
				################################

			$O.="</div>";	
			$O.='<div id="explainF">';
					$O.='<div id="explainClose" class="blueButt showInfo ftime">'.L_ok.'</div>';
					//$O.='<div id="loadingGym">'.L_loading.'</div>';
					$O.=$PL;
			$O.="</div>";
			$O.='<div class="clear"></div>';
		$O.="</div>";
        ?>