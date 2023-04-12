$(function() {
	var $pconsol=$("#playerConsoleCont");
	var debug=$("#debug")
	var matchAct = new Array()
	var username=$("#username").text()
	var botname=$("#botname").text()
	var device=$("#core").attr("data-device")
	if (device!="computer"){
		$("#musicoff").hide()
		$(document).unbind('mouseenter').unbind('mouseleave').unbind('mousemove')
	}
	//$('#musicoff img').attr("data-s","off")
	//window.setTimeout(function() { $('#musicoff').click()}, 200)	
	
//	window.setTimeout(function() { $('#musicoff').click()}, 200)	
	
	
	//debriefsplash(true)//**********
	var animateInforImg=function (){
		$(".infoImageT img").animate({marginLeft: "-10%"}, 3000)
		window.setTimeout(function() { 
			$(".infoImageT img").animate({marginLeft: "0px"}, 3000)
			window.setTimeout(function() {animateInforImg() }, 5000)
		}, 10000) 
	}
	animateInforImg();
	//chrome://flags/#disable-accelerated-video-decode
	

	///////////////////////////////////////////

	css_adaptP()
	
	
	
	var showInfo=function(p){
		if (p) {
			
			$( "#mask,#explain" ).css("z-index", "105").fadeIn('fast')
			.promise().done(function(  ) {
			if (	!$("#logC .tmptxt").length) $("#logshow").click()
			css_adaptP() 
			})
			return
		}
		$( "#mask,#explain" ).css("z-index", "100").fadeOut('fast')
	}
	
	
	
	var showChoiceOpt=function(p){
		if (p) {
			$( "#mask" ).fadeIn('fast')
			$( "#playerConsole" ).fadeOut('fast')
			$( "#choiceCont" ).slideDown('fast')			
			.promise().done(function(  ) {
			css_adaptP() 
			})
			return
		}
		$( "#mask" ).fadeOut('fast')
		$( "#choiceCont" ).slideUp('fast')
		$( "#playerConsole" ).fadeIn('fast')
		
		
	}	


		
	//////////////////////////////////////////////////////////////////////////////////////// RUN	
	
	css_adaptP()
	
//	$(window).load(function(){		})
	$(window).bind('orientationchange',function(event){css_adaptP()}) 
	$(window).bind('resize',function(event){css_adaptP()})
	$(window).load(function () {	
		if (device=="computer") $('#auback').trigger("play")
		css_adaptP();
		showInfo(true)
//		$("#QUITE").trigger("play");
		//loadVideoFully(false,0)
	$('.vid').bind('contextmenu',function() { return false; });

		
		//showLastState()
		//showChoiceOpt(true)
	})/////////////////////////////////////////////////////////////////////////////////////// RUN
	


//######################## GAME

	var $STATE=parseInt($pconsol.attr("data-state"));var $STATEO=parseInt($pconsol.attr("data-states"));var $SGROUPS=parseInt($pconsol.attr("data-sgroups"));debug.html  ($STATE+" "+$SGROUPS+" ")

	//var debug=$("#debug")

	var updateStateOpt=function ($STATE){
		if ($STATE>$STATEO){
			return
		}
		for (i = 0; i < $SGROUPS; i++) {
			$("#say_"+i).text(D[$STATE][i]['USR']['txt']) //i+" "+
			$("#sayimg_"+i).attr("src", "/data/imgavtr/faceEmotions/"+usr_avatar_id+"/"+D[$STATE][i]['USR']['emo']+".jpg")
		}
		//$("#say").text(D[$STATE][0]['USR']['txt'])
		var dad = $("#choiceC");var answers = dad.children();//http://jsfiddle.net/C6LPY/2/
		while (answers.length) {
			RRR=Math.floor(Math.random() * answers.length)
			dad.append(answers.splice(RRR, 1)[0]);
		}
		firstQid=dad.children(":first").attr("id").replace("opt_","")
		$("#say").text(	$("#say_"+firstQid).text()		).attr("data-saywhat",firstQid)
	}




	$('.previewOpt').on('click',function(e){e.preventDefault()
		$sayN=$(this).parent().closest('div').attr("id").replace("opt_","")//say_
		var $STATE=parseInt($pconsol.attr("data-state"));
		$("#bubbleR span").html(D[$STATE][$sayN]['USR']['txt']		)
		balloonFontAdapt()
		$('#vask').attr('src', 	D[$STATE][$sayN]['USR']['anv']		).load()
		if (useaudio) 	$('#aask').attr('src', 	'/data/audio/'+D[$STATE][$sayN]['USR']['aud']		).load()
				
		setTimeout(function(){
			//changeViewStop()
			$("#menuFixed,#playerConsoleCont,#mask").fadeOut("fast")
			blinkingad(true,"preview")			
			$("#QUITE").hide()
			$("#bubbleR").fadeIn().css('display','table');
			if (!useaudio) {
				
				//if (useaudio) $('#aask').trigger("play")			
				$('#vask').show().trigger("play").on('ended',function(){
					$('#vask').hide().unbind('ended')
					$("#bubbleR").hide()
					blinkingad(false,false)
					$("#menuFixed,#playerConsoleCont,#mask").fadeIn()
					$("#QUITE").show().trigger("play")
				})
			}else{
				listen1=$("#listenB");listen2=$("#listenU")
				
				$('#vask').show().trigger("play").on('ended',function(){
					listen2.hide()
					$('#vask').hide();$("#bubbleR").hide();
					listen1.prop('loop', true).show().trigger("play")
					//$pconsol.attr("data-listening","B")
					$('#vask').unbind('ended')
				})
				$('#aask').trigger("play").on('ended',function(){
					$('#vask').hide();
					listen1.hide()
					$('#aask').unbind('ended')
					$("#bubbleR").hide()
					//$pconsol.attr("data-listening","0")
					blinkingad(false,false)
					$("#menuFixed,#playerConsoleCont,#mask").fadeIn()
					$("#QUITE").show()
				})	

				
			}
		}, 1000)	
		
	})


		
	showExchange=function($STATEN, $sayN, $update,$gofinal,$kind){
		//alert ("showExchange "+$STATEN+" lastbf:"+$pconsol.attr("data-lastbf"))
		debriefsplash(false)
		//changeViewStop()
		$pconsol.fadeOut('fast')
		$("#menuFixed").fadeOut('fast')
		if ($update) {// score update
			cscore=parseInt($pconsol.attr("data-cscore")*1+parseInt(D[$STATEN][$sayN]["score"])*1)	
			$pconsol.attr("data-cScore",parseInt(cscore))
			cscorestory=$pconsol.attr("data-cscorestory")+","+D[$STATEN][$sayN]["score"]
			$pconsol.attr("data-cscorestory",cscorestory)
//			$("#debug").text ("$sayN:"+$sayN+"thiScore:"+ D[$STATEN][$sayN]["score"]+" story:"+cscorestory );
			matchAct[$STATEN+1] = new Array()
			matchAct[$STATEN+1]["idsentence"]=parseInt($sayN)+1;
			matchAct[$STATEN+1]["parausr"]=D[$STATEN][$sayN]['USR']['para'];
			matchAct[$STATEN+1]["parabot"]=D[$STATEN][$sayN]['BOT']['para'];
			matchAct[$STATEN+1]["score"]=D[$STATEN][$sayN]["score"];
			$debuglog="";
			datamatcha=$pconsol.attr("data-matcha");
			for ($ff = 1; $ff < matchAct.length; $ff++) {
				$debuglog=$debuglog+"<br>["+$ff+"] idsentence:"+matchAct[$ff]["idsentence"]+"parausr:"+matchAct[$ff]["parausr"]+"parabot:"+matchAct[$ff]["parabot"]+" score:"+matchAct[$ff]["score"]				
			}
			$("#debug").html ($debuglog)
			// UPDATE DIALOGUE
			$("#logC .tmptxt").remove();
			$("#logC").append('<span class="usr"><span>'+username+'</span>: '+D[$STATEN][$sayN]['USR']['txt']	+'</span><span class="usr"><span>'+botname+'</span>: '+D[$STATEN][$sayN]['BOT']['txt']	+'</span>')
			
/*
$sayN:0 thiScore:40 story:30,40
[0] idsentence:1parausr:2parabot:1 score:0
[1] idsentence:2parausr:2parabot:1 score:-30
[2] idsentence:0parausr:1parabot:1 score:50

matchAct[1]["idsentence"]=1
matchAct[1]["idsentence_p"]=0
matchAct[1]["score"]=30
matchAct[$state][idsentence]
matchAct[$state][idsentence_p]

*/				
	
		} //load
		$("#bubbleR span").html(D[$STATEN][$sayN]['USR']['txt']		)
		$("#bubbleL span").html(D[$STATEN][$sayN]['BOT']['txt']		)
		balloonFontAdapt();
		$('#vask').attr('src', 	D[$STATEN][$sayN]['USR']['anv']		).load()
		$('#vansw').attr('src', 	D[$STATEN][$sayN]['BOT']['anv']		).load()
		if (useaudio) $('#aask').attr('src', 	'/data/audio/'+D[$STATEN][$sayN]['USR']['aud']		).load()
		if (useaudio)	$('#aansw').attr('src', 	'/data/audio/'+D[$STATEN][$sayN]['BOT']['aud']		).load()
		
		setTimeout(function(){
			if (!useaudio)	{
				$('#vask').show().trigger("play")
				$("#QUITE").hide()
				$("#bubbleR").fadeIn().css('display','table');
				$('#vask').on('ended',function(){
					$('#vask').hide().unbind('ended')
					$('#vansw').show().trigger("play")
					$("#bubbleR").hide()
					$("#bubbleL").fadeIn().css('display','table');
					$('#vansw').on('ended',function(){
						$('#vansw').hide().unbind('ended')
						$("#bubbleL").hide()
						$("#QUITE").show().trigger("play")
	
						if ($update) {
							updateState()
							$pconsol.attr("data-lastU",$sayN )
							$pconsol.attr("data-lastB",$sayN )
						}
						blinkingad(false,false)
						// launch last state ?
						if (parseInt($STATEN)+1>$STATEO) {
							showLastState()
						}else{
						// quite on
							$pconsol.fadeIn()
							//changeViewRun()
							$("#menuFixed").fadeIn()				
						}
	
					})
				})
			}else{
				vd1=$("#vask");vd2=$("#vansw");aud1=$("#aask");aud2= $("#aansw");
				listen1=$("#listenB");listen2=$("#listenU")
				bal1=$("#bubbleR");bal2=$("#bubbleL")
				
				$("#QUITE").hide()
				listen1.hide();listen2.hide()
				bal1.fadeIn().css('display','table');
				
				vd1.show().trigger("play").on('ended',function(){
					vd1.hide();bal1.hide()
					listen1.prop('loop', true).show().trigger("play")
					//$pconsol.attr("data-listening","B")
					vd1.unbind('ended')
				})	
				
				aud1.trigger("play").on('ended',function(){
					vd1.hide().unbind('ended');listen1.hide()
					aud1.unbind('ended')
					bal1.hide()
					bal2.fadeIn().css('display','table')
					vd2.show().trigger("play").on('ended',function(){
						vd2.hide();bal2.hide()
						listen2.prop('loop', true).show().trigger("play")
						vd2.unbind('ended')
					})
					aud2.trigger("play").on('ended',function(){
						vd2.unbind('ended').hide()
						aud2.unbind('ended');vd2.unbind('ended')
						bal2.hide()
						listen1.hide();listen2.hide()
						
						if ($update) {
							updateState()
							$pconsol.attr("data-lastU",$sayN )
							$pconsol.attr("data-lastB",$sayN )
						}
						blinkingad(false,false)
						// launch last state ?
						if (parseInt($STATEN)+1>$STATEO) {
							showLastState()
						}else{
							$("#QUITE").show().trigger("play")
							$pconsol.fadeIn()
							$("#menuFixed").fadeIn()						
						}							
					})
				})	
			}// audio
			
		}, 1000);
	} //showExchange

	var $finalstate=false
	var showLastState=function (){
		//* alert ("final")			
		var scorecsv="";	//|3,2,2|3,2,2|5,2,2
//		for ($ff = 1; $ff < matchAct.length; $ff++) {matcha=matcha+"|"+matchAct[$ff]["idsentence"]+","+matchAct[$ff]["parausr"]+","+matchAct[$ff]["parabot"];}
		for ($ff = 1; $ff < matchAct.length; $ff++) {scorecsv=scorecsv+"|"+matchAct[$ff]["score"];}
		
		//alert (scorecsv) //|-15|-20|15
		//palma.entropy4fad.it//_m/debriefing/getData.ajax.php?scorecsv=|-15|-20|15&idgym=45
		//return;
		
		$.ajax({
			type: "GET", url: '/_m/debriefing/getData.ajax.php'
			
			//data-lastbf
			,data: {scorecsv:scorecsv,idgym:$pconsol.attr("data-idgym")}
			
			,cache: false,dataType: 'html',
			success: function(php_answer){
				//* alert (php_answer) 
				$("#debug").html(php_answer); //$("#debug").html
				resp=php_answer.split("|-|")
				$pconsol.attr("data-lastBF",parseInt(resp["1"]))
						
				var $finalstate=parseInt(resp["1"])-1 ///// importante -1
				//* alert ($finalstate+" "+D[$finalstate][0]['BOT']['txt'])
				var $STATE=parseInt($pconsol.attr("data-state"));
				fscore=parseInt($pconsol.attr("data-cscore"))
						
				if ($pconsol.attr("data-lastBF")=="N" ) $("#logC").append('<span class="usr"><span>'+botname+'</span>: '+D[$finalstate][0]['BOT']['txt']	+'</span>') // DIALOGUE
				
				
				$("#debug").html (	$("#debug").html()+"<br>showLastState STATE:"+	$STATE+" finalscore:"+	fscore	+" fstate"+$finalstate)
				$("#bubbleL span").html(	D[$finalstate][0]['BOT']['txt']	)
				balloonFontAdapt();
				fanswer=D[$finalstate][0]['BOT']['an']; // videos
				if (useaudio) fanswerA=D[$finalstate][0]['BOT']['auref']; // audio
				//alert ($finalstate+" "+fanswerA)
				fanswerF=$("#"+fanswer+"").attr("src"); // videos source
				$("#QUITE").show()	
				$('#vask').attr('src', fanswerF);$('#vask').load()
				setTimeout(function(){
					$("#QUITE").hide();$("#bubbleL").fadeIn().css('display','table');
					if (!useaudio) {
						$('#vask').show().trigger("play").on('ended',function(){
							$('#vask').hide().unbind('ended')
							$("#bubbleL").hide()
							updateState()
							$("#menuFixed").fadeIn()
							debriefsplash(true)
						})
					}else{ // audio version
						listen1=$("#listenB");listen2=$("#listenU")
						$('#vask').show().trigger("play").on('ended',function(){
							listen1.hide()
							$('#vask').hide();$("#bubbleL").hide();
							listen2.prop('loop', true).show().trigger("play")
							$pconsol.attr("data-listening","B")
							$('#vask').unbind('ended')
		
						})
						$('#'+fanswerA).trigger("play").on('ended',function(){
							$('#vask').hide(); 
							listen1.hide();
							//listen2.hide()
							$('#'+fanswerA).unbind('ended')
							$("#bubbleL").hide()
							$pconsol.attr("data-listening","0")
							updateState()
							$("#menuFixed").fadeIn()
							debriefsplash(true)
						})
					}
				}, 1000)

			} // success
			//, error: function(php_answer){alert ("ajax err");}
		}) // AJAX
		
	
		

	} /////////////////////////////////////////////////////////////////////////

	function updateState(){
		var $STATE=parseInt($pconsol.attr("data-state"))
		var $STATE=parseInt($STATE)+1;
		
		if ($STATE>$STATEO){
			//alert ("FINITI DA UPDATE STATE"); 
			return;
		}
		//alert ("updateState "+parseInt($pconsol.attr("data-state"))+" -->"+$STATE)
		$pconsol.attr("data-state",$STATE)
		updateStateOpt($STATE)
	}
	$('.showLastExc').on('click',function(e){e.preventDefault()
		var $STATE=parseInt($pconsol.attr("data-state"));
		
		if ($STATE==0) return
		//alert (""+$pconsol.attr("data-lastBF")+" "+$STATE)
		if ($pconsol.attr("data-lastBF")=="N" ){
			$GOSTATE=($STATE-1)
			//alert ("case 1 "+$GOSTATE)
			//showExchange($STATE-1, $pconsol.attr("data-lastu"), false)
		}else{
			$GOSTATE=$STATE;
			//alert ("case 2 "+$GOSTATE)
			//showExchange($STATE+1, $pconsol.attr("data-lastu"), false)
		}
		blinkingad(true,"replay")
		showExchange($GOSTATE, $pconsol.attr("data-lastu"), false)
//		showExchange=function ($STATEN, $sayN, $update)
		//return;
	})	
	
	/////debriefsplash
	
	var debriefsplash=function (bool){
		$pconsol.fadeOut()
		if (bool) {
			if ($pconsol.attr("data-match")=="0") writeMatch()
			
			$("#mask, #explain").hide()
			$(".vid").fadeOut();
			$("#debriefsplash").fadeIn();
			//$("#player").prepend('<div id="debriefsplash"></div>');
		}else{
			$("#debriefsplash").fadeOut("fast")
		}
//		alert ("debriefsplash"+bool)
	}


	
	var writeMatch=function (){
		
		var matcha="";
		for ($ff = 1; $ff < matchAct.length; $ff++) {matcha=matcha+"|"+matchAct[$ff]["idsentence"]+","+matchAct[$ff]["parausr"]+","+matchAct[$ff]["parabot"];}
		$finalstate=$pconsol.attr("data-lastbf")
		$("#debevaulating").show()
		$("#debriefsplash .btn").hide()
		$.ajax({
			type: "POST", url: '/_m/player01/player.ajax.php'
			//data-lastbf
			,data: {CMD:'writeMatch',M:matcha,	stime: $pconsol.attr("data-time"), closingState: $finalstate,closingParallel:D[$finalstate-1][0]['BOT']['para'],idgym:$pconsol.attr("data-idgym")}
			,cache: false,dataType: 'html',
			success: function(php_answer){
				$("#debug").html(php_answer); //$("#debug").html
				//php_answer=unident(php_answer);
				resp=php_answer.split("|-|")
				if (resp[0]=="true") {
					$pconsol.attr("data-match",resp[1])
					// /?debrief/43/3/
					$("#debevaulating").hide()
					$("#debriefsplash .btn").attr("href","?debrief/"+resp[1]).show()
				}

			}//, error: function(php_answer){alert ("ajax err");}
		})
	}
	/*$('#debevaulating').on('click',function(e){e.preventDefault()
		writeMatch();
	})	*/
	
	$('#send').on('click',function(e){e.preventDefault()
		var $STATE=parseInt($pconsol.attr("data-state"));
		if ($STATE>$STATEO){
			//alert ("FINITI DA SEND"); 
			return;
		}
		$sayN=$("#say").attr("data-saywhat")
		//$botSay=botAnswerCalc($STATE,$usrSay)
		//loadVideoFully(false,1)
		showExchange($STATE,$sayN,true)
		//updateState()
	})
	$('.sendOpt').on('click',function(e){e.preventDefault()
		var $STATE=parseInt($pconsol.attr("data-state"));
		$sayN=this.id.replace("send_", "")
		showExchange($STATE,$sayN,true)
		showChoiceOpt(false)
	})

	$('#next,#prev').on('click',function(e){e.preventDefault()

		$actualSayO=parseInt($("#say").attr("data-sayord"))
		if (this.id=="next") $sayNowO=$actualSayO+1
		if (this.id=="prev") $sayNowO=$actualSayO-1
		if ($sayNowO>$SGROUPS-1) 	$sayNowO=0;
		if ($sayNowO<0) 					$sayNowO=$SGROUPS-1;
		
		idd=$("#choiceC").children().eq($sayNowO).attr("id").replace("opt_","")
		$("#say").attr("data-saywhat",idd).attr("data-sayord",$sayNowO).text(	$("#say_"+idd).text()	)

	})

		/*var loopFadeOut=function ($li){
			for (i = 1; i <= 10; i++) {
				$V=(10-i) /10;if ($V<$li) break;					
				 (function(){
				 var j = i;  var $VV= $V; 
				 setTimeout(function() { loop.volume($VV) }, j*500); //alert($VV);
				 })();
			}
		}*/
				
	
	//// SHOINFO
	$('.showInfo').on('click',function(e){e.preventDefault(); showInfo(true)})
	$('#explainClose').on('click',function(e){e.preventDefault(); 
		showInfo(false);$("#playerConsole").show();	
		if ($(this).hasClass("ftime")) {
			//$("#QUITE").trigger("play");
			//$('#auback').trigger("pause")
			//$('#auback').trigger("play")
			//if (device=="computer")  
			$('#auback').animate({'volume': 0.1}, 2000);
			


			//soundsLoaded()
	//		loop.stop();loop.start("sound1");
			//loopFadeOut(0.3);
			$(this).removeClass("ftime");
		}
	})	

	$('#infoChars').on('click',function(e){e.preventDefault();		
		$('#explainH a, #logshow').removeClass("onA").removeClass("onB")
		$(this).addClass("onB")
		$("#infoMainC,#logC,.infoImageT").hide();
		$("#infoCharsC").show().promise().done(function(  ) {
			$('#infoCharsC').scrollTop(0);
			css_adaptP() 
		});
	})
	$('#infoMain').on('click',function(e){e.preventDefault();
		
		$('#explainH a, #logshow').removeClass("onB").removeClass("onA")
		$(this).addClass("onA")
		$("#infoCharsC,#logC").hide()
		$("#infoMainC,.infoImageT").show().promise().done(function(  ) {
			$('#infoMainC').scrollTop(0);
			css_adaptP()
		});
		
	})
	$('#logshow').on('click',function(e){e.preventDefault();		
		$('#explainH a').removeClass("onA").removeClass("onB")
		$(this).addClass("onB")
		$("#infoMainC,#infoCharsC,.infoImageT").hide();
		$("#logC").show().promise().done(function(  ) {
			$('#log').scrollTop(0);
			css_adaptP() 
		});
	})	
	
	
	// CHOICE
	$('.closeChoice').on('click',function(e){e.preventDefault();
		showChoiceOpt(false)
		//$( "#playerConsole" ).show();		
	});
	$('#up,#say').on('click',function(e){e.preventDefault();
		showChoiceOpt(true)
		//$( "#playerConsole" ).hide();
	});
	
	$('#musicoff').on('click',function(e){e.preventDefault()
		imgc=$('#musicoff img')
		
		if (	imgc.attr("data-s")	 =="on")  {
			imgc.attr("data-s","off")
			$('#auback').trigger("pause")
			//alert (imgc.attr("data-s")+" OFF")
			//loop.stop();
			//$("#fx1").prop('muted', true);
			aon=imgc.attr("src").replace("audioon","audiooff");
			//$(this).attr("title",	$(this).attr("data-ton")			)
		}else{
			imgc.attr("data-s","on")
			$('#auback').trigger("play")
			//alert (imgc.attr("data-s")+" ON")
			//soundsLoaded()
			//loop.start("sound1");
			//$("#fx1").prop('muted', false);
			aon=imgc.attr("src").replace("audiooff","audioon");
			//$(this).attr("title", $(this).attr("data-toff"))
		}
		imgc.attr("src",aon)
	});	
	

	

	$(document).on('keyup',function(evt) {	//27 esc 38 up 37 lfet 39 right 13 return
		//debug.text(evt.keyCode)
		if ( !$("#loadingGym").length) {
			if (evt.keyCode == 27) {				
					showInfo(false);
					showChoiceOpt(false)				
			}
			if (evt.keyCode == 38) showChoiceOpt(true);
			if (evt.keyCode == 40) showChoiceOpt(false)
			if (evt.keyCode == 37) $( "#prev" ).click();
			if (evt.keyCode == 39) $( "#next" ).click();

		}

	});

	var blinker=function() {$('#blinkingad').fadeOut(250).fadeIn(250)}
	var setBlink=null
	function blinkingad(bool,img){
		if (bool){
			if (!img) img="replay"
			$("#player").prepend ('<img id="blinkingad" src="/img/player.'+img+'.png" alt="" />')
			setBlink=setInterval(blinker, 1250)
		}else{
			clearTimeout(setBlink);$("#blinkingad").remove()
		}
	}
	//blinkingad(true,"preview")
	
	// game run
	updateStateOpt($STATE)




	/////////////////// PRELOAD OLD


	////
	var $desktopWidth=1000
	var $desktopWidthMin=340
	var $playerBackImgRatio=(9/16) 	
	// 9/21 

	function css_adaptP(cmd) {
		//alert ("css")
		var H=$(window).height(); var W=$(window).width();
		$("#mask").css({'width':W+'px'});$("#mask").css({'height':H+100+'px'})
		
		if (W<$desktopWidth) {
			var H_16_9 =W*$playerBackImgRatio
			$("#player,#QUITE,#QUITED,#vask,#vansw,#debriefsplash,#listenU,#listenB").css({'width':W+'px'}) //,.vid
								.css({'height':H_16_9+'px'})
		}else{
			if (W<$desktopWidthMin) W=$desktopWidthMin //limit			
			var H_16_9 =$desktopWidth*$playerBackImgRatio
			$("#player,#QUITE,#QUITED,#vask,#vansw,#debriefsplash,#listenU,#listenB").css({'width':$desktopWidth+'px'}) //,.vid    ,#vask,#vansw,#QUITE  #playerBackImg,
								.css({'height':H_16_9+'px'})
		}
		// #playerConsole
		//## pop 1/2
		$popH=H-62;		
		$popLt=$(".pop").width() ;
		if ($popLt>800) { 
			$popLt=800
			$(".pop").css("width", $popLt+ "px")
		}
		$popL=(W- $popLt ) / 2;
		
		
		$(".pop").css("left", $popL-20 + "px")
		$(".pop").css("max-height", $popH+ "px")
		$("#contentH").css("max-height",$popH-48 + "px")	
				
		if (H<H_16_9+70-10) { //
			$pconsol.addClass("playerConsoleTight").removeClass("playerConsoleTall")
			$popT=10;
			$popH=H-47;
		}else{
			$pconsol.addClass("playerConsoleTall").removeClass("playerConsoleTight")
			$popT=(H- $(".pop").height() ) / 2;
			$popH=H-62;
		}
		//## pop 2/2
		$(".pop").css("top", $popT + "px")
		$(".pop").css("max-height", $popH+ "px")
		$("#contentH").css("max-height",$popH-70 + "px")
	
		//## choice		

		$choiceH=$pconsol.offset().top+70-20
		$("#choiceCont").css("max-height", $choiceH+ "px")
		$("#choiceC").css("max-height", ($choiceH-$("#choiceH").height())+ "px")
		balloonFontAdapt()
	}/// CSS ENDS
	

	function balloonFontAdapt() {
		var W=$(window).width();
		b1=$("#bubbleR span")
		b2=$("#bubbleL span")
		balcont1=b1.html()
		balcont2=b2.html()
		if (W<800 ){
			if (balcont1.length>90) {
				b1.css({'font-size':13+'px'}).css({'line-height':18+'px'})
			}else{
				b1.css({'font-size':22+'px'}).css({'line-height':27+'px'})
			}
			if (balcont2.length>90) {
				b2.css({'font-size':13+'px'}).css({'line-height':18+'px'})
			}else{
				b2.css({'font-size':22+'px'}).css({'line-height':27+'px'})
			}			
		}else{
			if (balcont1.length>90) {
				b1.css({'font-size':26+'px'}).css({'line-height':28+'px'})
			}else{
				b1.css({'font-size':40+'px'}).css({'line-height':36+'px'})
			}
			if (balcont2.length>90) {
				b2.css({'font-size':26+'px'}).css({'line-height':28+'px'})
			}else{
				b2.css({'font-size':40+'px'}).css({'line-height':36+'px'})
			}
		}
	}
	
	
	$(window).load(function () {	

		if ($pconsol.attr("data-idgym")=="77") {
			ss=window.location.href;
			cc=ss.search("osdfho9s8hklddvnsd8");
			if (cc!=-1)	$('#explainClose').click()	//g:osdfho9s8hklddvnsd8
			//alert (	ss.search("osdfho9s8hklddvnsd8xxxx"));
		}

	})	
	
	
})




