$(function() {
    ///update 2023-05-23
	var $pconsol=$("#playerConsoleCont");
	var debug=$("#debug")

	var S=G["ss"];
	//Slert (G["s"][0]["scene"])
	var $desktopWidth=1000
	var $desktopWidthMin=340
	var $playerBackImgRatio=(9/16) 	
	// 9/21 
	var adaptTex2Balloon=function (t)	{
		if (!t) return;
		t=t.trim()
		t=t.replace(/\n/g,"<br />");//nl2br
		
		return t
	}
	
	var loadAttach=function(s, scene) {
		if (!scene) scene="A";
		//G["ss"][scene]
		//alert (scene)
		//alert("s="+s+" "+S[scene][s]["A"].length)
		if (!S[scene][s]["A"].length) return false;
		window.setTimeout(function() {	
				$("#attachShowImg a,.attachTxt,.view").hide();

			//slert (S[s]["compulsoryAttachments"])
				if (S[scene][s]["compulsoryAttachments"]=="1")  			$("#compulsoyAtt").show()
				else 	$("#compulsoyNotAt").show()	
                var i; var I;
				for (i = 0; i < S[scene][s]["A"].length; i++) {
					//alert (i+ " "+S[scene][s]["A"][i]["path"])
					I=i+1
					$("#att_"+I).show()
						.attr("href", 		S[scene][s]["A"][i]["path"]	).attr("data-u", 		S[scene][s]["A"][i]["path"]	).attr("data-t", 		S[scene][s]["A"][i]["type"]	).attr("data-open", 		S[scene][s]["A"][i]["open"]	)
							.attr("data-info", 		S[scene][s]["A"][i]["info"]	).attr("data-majordim", 		S[scene][s]["A"][i]["majordim"]	)
							.attr("data-W1", 		S[scene][s]["A"][i]["W1"]	).attr("data-H1", 		S[scene][s]["A"][i]["H1"]	)
							.attr("data-ytid", 		S[scene][s]["A"][i]["ytid"]	)
						
					$("#att_"+I +" .attImg").attr("src", "/img/ico/"+S[scene][s]["A"][i]["type"]+"60.png")
						.attr("title", 		S[scene][s]["A"][i]["title"]	)
				}
				$('#fx2').trigger("play")
				$("#attachShow").fadeIn("300", function () {
					if (S[scene][s]["compulsoryAttachments"]!="1") $("#playerConsoleCont").fadeIn("600")
				});
	
		}, 1000	)
		
		return true;
	}
	$(".atta").on('click',function(e){

		var id=this.id
        $("#"+id).attr("data-read", "1").find(".view").fadeIn(500);
		//window.setTimeout(function() {}, 1000) 


		if ($(this).attr("data-open")!="out") { // open IN
			e.preventDefault()

            var somethingWrong=0;
            switch ($(this).attr("data-info")) {
              case "wordwall":
               var urlww=$(this).attr("href");
                $.getJSON('https://wordwall.net/api/oembed?url='+encodeURIComponent( $(this).attr("href") ) +'&amp;format=json', function(data) {
                    //alert (data["html"])
                    data["html"]=data["html"].replace('width="500"','width="1000"').replace('height="380"','height="562"')
                    $("#attachViewerIN").html(data["html"]);

                }).fail(function() { 
                   somethingWrong=1 
                    $("#attachViewerClose").click();
                    window.open(  urlww  , '_blank')
                })
              
                
                break;   
              case "pdf":
                $("#attachViewerIN").html('<iframe id="pdfview" type="application/pdf" frameBorder="0" scrolling="auto" width="1000" height="570" src="'+$(this).attr("href")+'?autoplay=1" frameborder="0"/></iframe>');
                break;
                
              case "youtube":
                $("#attachViewerIN").html('<iframe id="ytplayer" type="text/html" width="1000" height="562.50" src="https://www.youtube.com/embed/'+$(this).attr("data-ytid")+'?autoplay=1" frameborder="0"/></iframe>');
                break;
              case "mp3":case "mp4":case "webm":case "ogg":

                $("#attachViewerIN").html('<video id="embedVideoAttach" width="'+$(this).attr("data-W1")+'"  height="'+$(this).attr("data-H1")+'" controls autoplay><source src="'+$(this).attr("href")+'" type="video/mp4">Your browser does not support the video '+$(this).attr("data-info")+'</video>')
                break;

              default:
                $("#attachViewerIN").html('<img src="'+$(this).attr("href")+'"  width="'+$(this).attr("data-W1")+'"  height="'+$(this).attr("data-H1")+'" />' )
                break;

            }      
			$("#attachViewer").fadeIn();
            $("#playerConsoleCont").hide();
		}else{ // open OUT
            
			var sceneGet=$("#currentscene").val();
			var st=$pconsol.attr("data-step")
            var $attNotOpen=0;// totale non aperti
            if (S[sceneGet][st]["compulsoryAttachments"]=="1"	) {	
                var iX
				for (iX = 1; iX <= S[sceneGet][st]["A"].length; iX++) {
                    if ( $("#att_"+iX).attr("data-read")=="0") {
                        $attNotOpen=$attNotOpen+1;
                    }   
				}     
			}
            if ($attNotOpen==0) $("#playerConsoleCont").fadeIn("slow")
        }
	})	
	
	
	
	$("#attachViewerClose").on('click',function(e){
            e.preventDefault()			
            $("#attachViewer").fadeOut();
			$("#attachViewerIN").html("")
			var sceneGet=$("#currentscene").val();
			var st=$pconsol.attr("data-step")
            var $showConsole=1;
            if (S[sceneGet][st]["compulsoryAttachments"]=="1"	) {	
                var iX
				for (iX = 1; iX <= S[sceneGet][st]["A"].length; iX++) {
					if ($("#att_"+iX).attr("data-read")=="0") $showConsole=0;
				}     
			}
            if ($showConsole!=0) $("#playerConsoleCont,#playerConsole").show() 
           
	})	
	
    var showFeedback=function(stepDone, answerN) {
    
        var sceneGetF=$("#currentscene").val();
        if (sceneGetF!="A" && sceneGetF!="B" && sceneGetF!="C" && sceneGetF!="D" ) sceneGetF="A"
        var $sayFeedback=S[sceneGetF][stepDone][    "feedback_"+answerN ];
        var goto=S[sceneGetF][stepDone][    "goto"+answerN ];
        $("#attachShow").fadeOut();
        
        //$("#playmask").fadeIn(100);//.promise().done(function(  ) {                            })
        
        var stepNext=stepDone+1
        /*
        left: -54px; top: 44px; display: block;
        XL

        ballon left: 318px; top: 174px; display: none;
        left: -54px; top: 44px; display: block;
        
        */
		var sizeF="XL";var leftF=-54;var topF=44;topF=0;
        var ballonLeft=318;var ballonTop=174;
        var arrowYf=22
        
        var currentAvatarId=$("#avatarSprite").attr("data-currentAvatar");        
        
        var currentSize=$("#avatarSprite").attr("data-currentSize");
		var currentClass=$("#avatarSprite").attr("class");
		var currentClassTalk=$("#avatarSpriteTalk").attr("class");	
        
		$("#avatarSprite").attr("class", 		currentClass.replace("wait_"+currentSize, "wait_"+sizeF)			)
		$("#avatarSpriteTalk").attr("class", 		currentClassTalk.replace("wait_"+currentSize, "wait_"+sizeF)			)
        
		$("#avatarSprite").attr("data-currentSize", sizeF);	
		$("#avatarSprite,#avatarSpriteTalk").attr("style", "left: "+leftF+"px;top: "+topF+"px;" )         
		$("#balloon").attr("style", "left: "+ballonLeft+"px;top: "+ballonTop+"px;" )
		$("#balloon span").html(adaptTex2Balloon($sayFeedback));
        //$("#balloon").show();
		$("#leftArrow").attr("data-top", arrowYf ).attr("style", "right: -17px;top: "+arrowYf+"px;" ) 
		$("#rightArrow").attr("data-top", arrowYf ).attr("style", "left: -17px;top: "+arrowYf+"px;" ) 
        $("#rightArrow").show();$("#leftArrow").hide();
        if (currentAvatarId==1000) {
            $("#avatarSprite").hide();
            $("#rightArrow,#leftArrow").hide();
        }

        $("#aansw").attr("src", "/data/audio/"+S[sceneGetF][stepDone][    "feedback_"+answerN+"_audio" ]+"?"+Math.random()			)	// audio
		$( "#mask" ).fadeOut('fast')
		$pconsol.hide();


        //alert(stepDone+" "+answerN+" "+$sayFeedback);
        //////////////////////////////// play feedback
		$pconsol.attr("data-playing", "1")
		//Slert (scene)
		$("#balloon").fadeIn("fast");
		
		
		$pconsol.fadeOut("fast")
        if (S[sceneGetF][stepDone][    "feedback_"+answerN+"_scenario"]){
         //   alert (S["A"][stepDone][    "feedback_"+answerN+"_scenario"] )
            $("#scenario").attr("src",S[sceneGetF][stepDone][    "feedback_"+answerN+"_scenario"]).fadeIn();
        }        
        
        
		if (currentAvatarId==1000) $("#rightArrow,#leftArrow").hide();
		
		$("#avatarSpriteTalk").show(0, function(){
            $("#avatarSprite").hide();
		});

	
		$('#aansw').trigger("play").on('ended',function(){
			
			$('#aansw').hide().unbind('ended')
			
			currentAvatarId=$("#avatarSprite").attr("data-currentAvatar");		
//			$("#avatarSprite").attr("class", 		$("#avatarSprite").attr("class").replace("avatar_"+currentAvatarId+"_talk", "avatar_"+currentAvatarId)			)
			$("#avatarSpriteTalk").hide()
			$("#avatarSprite").show()
			//alert (scene);
			
            $("#balloon").fadeOut("slow");
				

			$pconsol.attr("data-playing", "0")
            //alert ("feedback finito goto: "+goto)
            ////////////////////////
            if (stepNext>$("#playerConsoleCont").attr("data-steps")-1	){
                $pconsol.hide()
                // FINAL CALC
                window.setTimeout(function() { 
                        transmit({cmd:"finalCalc",gameId:G["gameId"],idm:G["idm"]})
                    }, 1000) 						


            }else {
                showChoiceOpt(false)

                    // NEXT STEP
                    //slert (data["goto"]+" "+stepNext);											

                    $("#playmask").fadeIn(100).promise().done(function(  ) {
                        loadStep(stepNext, goto);
                    })

            }//if (stepNext            
            
            
            //////////////////////////

		})	



        ///////////////////////////////////////
    } // showFeedback
	
	var loadStep=function(s, scene, isFinal) {

		$("#attachShow").fadeOut();
		$("#attachShow a").attr("data-read", 0)
		if (!scene) scene="A"; 
		if (!isFinal) isFinal=false; else isFinal=true;		
		if (isFinal) scene="A";	
		$("#currentscene").val(scene)
		//alert (scene+" "+s)
		
		

		var S=G["ss"][scene];
		
		$( "#mask" ).fadeIn('fast'); $("#balloon").hide();
		$pconsol.attr("data-step", 		s		).attr("data-steps", G["steps"]); //s  
		
		//Slert (G["steps"])
		$("#scenario").attr("src",S[s]["scenario"]).fadeIn();
		//$("#avatar_id").val(avatar_id);
		var avatar_id=S[s]["avatar_id"]
        
		var currentAvatarId=$("#avatarSprite").attr("data-currentAvatar");

		$("#avatarSprite").attr("class", 		$("#avatarSprite").attr("class").replace("avatar_"+currentAvatarId, "avatar_"+avatar_id).replace("avatar_"+currentAvatarId+"_talk", "avatar_"+avatar_id)			).attr("data-currentAvatar", avatar_id);
		$("#avatarSpriteTalk").attr("class", 		$("#avatarSpriteTalk").attr("class").replace("avatar_"+currentAvatarId+"_talk", 	"avatar_"+avatar_id+"_talk")			);
        
        //$("#avatarSpriteTalk").attr("class", "avatar_"+avatar_id+" avatar_"+avatar_id+"_talk")
		if (avatar_id==1000) $("#avatarSprite").hide();
		
		var size=S[s]["avatar_size"]
		var currentSize=$("#avatarSprite").attr("data-currentSize");
		var currentClass=$("#avatarSprite").attr("class");
		var currentClassTalk=$("#avatarSpriteTalk").attr("class");		
		$("#avatarSprite").attr("class", 		currentClass.replace("wait_"+currentSize, "wait_"+size)			)
		$("#avatarSpriteTalk").attr("class", 		currentClassTalk.replace("wait_"+currentSize, "wait_"+size)			)
		
		$("#avatarSprite").attr("data-currentSize", size);	
		$("#avatarSprite,#avatarSpriteTalk").attr("style", "left: "+S[s]["avatar_posA"][0]+"px;top: "+S[s]["avatar_posA"][1]+"px;" ) 
		
		//

		$("#balloon").attr("style", "left: "+S[s]["balloon_posA"][0]+"px;top: "+S[s]["balloon_posA"][1]+"px;" )
		//if (avatar_id!=1000) $("#balloon").show();
		//.attr("data-pos", posB[0] +","+ posB[1] ).
		$("#balloon span").html(adaptTex2Balloon(S[s]["avatar_sentence"]));
		
		
		var arrowY=S[s]["arrowY"];
		//Slert (arrowY);
		$("#leftArrow").attr("data-top", arrowY ).attr("style", "right: -17px;top: "+arrowY+"px;" ) 
		$("#rightArrow").attr("data-top", arrowY ).attr("style", "left: -17px;top: "+arrowY+"px;" ) 
		/*if (avatar_id==1000){
			if (S[s]["arrowPos"]=="right") {$("#rightArrow").show();$("#leftArrow").hide();}
			else	{$("#rightArrow").hide();$("#leftArrow").show();}
		}
		*/
		$("#aansw").attr("src", S[s]["avatar_audio"]+"?"+Math.random()			)	// audio
		if (!isFinal) {
			$("#playerConsoleCont").attr("data-answern",S[s]["answerN"])
			$(".choiceOpt").hide()
            var i
			for (i = 1; i <= S[s]["answerN"]; i++) {
	
				$("#say_"+i ).text(S[s]["answer_"+i  ]			).attr("data-scene", S[s]["goto"+i  ]) //i+" "+
				$("#opt_"+i ).show();			
				//Slert ("answer_"+i  +" "+S[s]["answer_"+i  ])
				//$("#sayimg_"+i).attr("src", "/data/imgavtr/faceEmotions/"+usr_avatar_id+"/"+D[$STATE][i]['USR']['emo']+".jpg")
			}
			var RRR=Math.floor(Math.random() * S[s]["answerN"]);RRR=RRR+1
			$("#say").attr("data-sayord",RRR)
			$("#say").text(S[s]["answer_"+RRR  ])
			$("#say").attr("data-scene", S[s]["goto"+RRR  ])

		}
		$( "#mask" ).fadeOut('fast')
		$pconsol.hide();
		/*$("#scenario").fadeOut(300).promise().done(function(  ) {
				//if(document.createElement('svg').getAttributeNS)	document.getElementById('audioBell').play()
				//$("#t2").fadeIn(1200)
			});
		*/
//		



		if(s>0) { //firstOne triggered by close info button
			$('#fx1').trigger("play")
			$("#playmask").fadeOut(2500).promise().done(function(  ) {
				window.setTimeout(function() {playStep(s,scene, isFinal)	}, 1600	)	
		})				

		}else{
			$("#playmask").fadeOut(200);
		}
		$("#core #send_no").attr("id", "send")
        MathJax.typeset()
		
	}

	// stepLoad=>play=>animazione=>
	//CURRENTSCENE="A";
	var transmit=function(data) {
		//Slert ("gameId:"+ data["gameId"]);
		
		$("#saving").show()

		$.ajax({
			type: "POST", url: "/_m/player04/ajax.player.php"
			,data: {data:data} 
			,cache: false,dataType: 'html',
			success: function(php_answer){
				var R=php_answer.split("|-|")
				console.log (php_answer)
				$("#debug").html(php_answer)
				$("#saving").hide()
					
				if (data["cmd"]=="stepon") {///////////////////////////////////////////
					//Slert ("stepon") 
					//stepNext=data["stepIndex"]+1;
                    var sceneGetF=$("#currentscene").val();
                    
                    var stepDone=parseInt($pconsol.attr("data-step"));
					var stepNext=stepDone+1
                    var $sayFeedback=S[sceneGetF][stepDone][    "feedback_"+data["answer"]  ];

                    if ($sayFeedback) {
                        // FEEDBACK
                        //
                        showFeedback (stepDone, data["answer"])
                    }else{

                        if (stepNext>$("#playerConsoleCont").attr("data-steps")-1	){
                            $pconsol.hide()
                            // FINAL CALC
                            window.setTimeout(function() { 
                                    transmit({cmd:"finalCalc",gameId:G["gameId"],idm:G["idm"]})
                                }, 1000) 						


                        }else {
                            showChoiceOpt(false)

                                // NEXT STEP
                                //slert (data["goto"]+" "+stepNext);											

                                $("#playmask").fadeIn(100).promise().done(function(  ) {
                                    loadStep(stepNext, data["goto"]);
                                })

                        }//if (stepNext
                    }// if ($sayFeedback) {
				}				
				

				/////////////////////////////////////////////////////////
				if (data["cmd"]=="finalCalc") {
					var FINALSTEPDATA=$.parseJSON(R[1])
					
					loadStep((FINALSTEPDATA["step"]-1),"A",true)
				}
				//////////////////////////////////////////////////////////
				if (data["cmd"]=="getExchanges") {
					$("#logC").html(R[1])
					MathJax.typeset()
				}
				
				
			},

		})
			
	}


	$('#fcalc').on('click',function(e){e.preventDefault()
		transmit({cmd:"finalCalc",gameId:G["gameId"],idm:G["idm"]})
	})	
	$('#send,.sendOpt').on('click',function(e){e.preventDefault()
		var $STEP=parseInt($pconsol.attr("data-step"));
		if (this.id=="send") {
			var $sayN=$("#say").attr("data-sayord")
			var sceneGo=$("#say").attr("data-scene")
			$(this).attr("id", "send_no")
		}else {
			$sayN=this.id.replace("send_","")
			sceneGo=$("#say_"+$sayN).attr("data-scene")
		}
		
		
		//slert (sceneGo+$STEP)
		var sceneGet=$("#currentscene").val();
		//alert (sceneGet)
		transmit({cmd:"stepon",gameId:G["gameId"], stepIndex:$STEP,  scene:sceneGet	, answer: $sayN, idm:G["idm"], score: G["ss"][sceneGet][($STEP)]["ascore_"+$sayN], steps:G["steps"], goto:sceneGo})	
	})	

	var playStep=function(s,scene, isFinal) {
		if (!isFinal) isFinal=false; else isFinal=true;
		if (!scene) scene="A";
		$pconsol.attr("data-playing", "1")
		//Slert (scene)
		$("#balloon").fadeIn("fast");
		if (S[scene][s]["arrowPos"]=="right") {$("#rightArrow").show();$("#leftArrow").hide();}
		else	{$("#rightArrow").hide();$("#leftArrow").show();}
		$pconsol.fadeOut("fast")
		if (S[scene][s]["avatar_id"]==1000) $("#rightArrow,#leftArrow").hide();
		
		var currentAvatarId=$("#avatarSprite").attr("data-currentavatar")
		//$("#avatarSprite").attr("class", 		$("#avatarSprite").attr("class").replace("avatar_"+currentAvatarId, "avatar_"+avatar_id+"_talk")	)
		$("#avatarSpriteTalk").show(0, function(){
    		$("#avatarSprite").hide();
		});

	
		$('#aansw').trigger("play").on('ended',function(){
			
			$('#aansw').hide().unbind('ended')
			
			currentAvatarId=$("#avatarSprite").attr("data-currentAvatar");		
//			$("#avatarSprite").attr("class", 		$("#avatarSprite").attr("class").replace("avatar_"+currentAvatarId+"_talk", "avatar_"+currentAvatarId)			)
			$("#avatarSpriteTalk").hide()
			$("#avatarSprite").show()
			//alert (scene);
			if (!isFinal) var $loadA=loadAttach(s,scene);
			else $loadA=false;
			
			if (!isFinal		&&  S[scene][s]["compulsoryAttachments"]!="1" && !$loadA	) $pconsol.fadeIn("slow")
			if (!isFinal) {
				$("#balloon").fadeOut("slow");
				
			}
			$pconsol.attr("data-playing", "0")
			if (isFinal) {
                $("#debriefsplash").attr("data-visible",1)
                $(".showLastExc").hide()
                $("#balloon").remove() // 2023-05-23
				window.setTimeout(function() { 
					$("#mask, #explain").hide()
                    
               $("#debriefsplash").fadeIn(300, function(){ 
                    if (G["endCredits"]) $('<link>').appendTo('head').attr({
                            type: 'text/css', 
                            rel: 'stylesheet',
                            href: "/_m/player04/endCredits.css?"+Math.floor((Math.random() * 100) + 1)
                        });
               });
					}, 2000) 
				}

		})		
		
		
	}


	// CHOICE
	$('.closeChoice').on('click',function(e){e.preventDefault();
		showChoiceOpt(false)
		//$( "#playerConsole" ).show();		
	});
	$('#up,#say').on('click',function(e){e.preventDefault();
		showChoiceOpt(true)
		//$( "#playerConsole" ).hide();
	})	
	$('#next,#prev').on('click',function(e){e.preventDefault()
		
		var answern=$("#playerConsoleCont").attr("data-answern");
		//Slert (answern) 
		
		var $actualSayO=parseInt($("#say").attr("data-sayord"))
		if (this.id=="next") var $sayNowO=$actualSayO+1
		if (this.id=="prev") $sayNowO=$actualSayO-1
		if ($sayNowO>answern) 	$sayNowO=1;
		if ($sayNowO<=0) 			$sayNowO=answern;
		
		//Slert ($sayNowO+"#say_"+$sayNowO);
		$("#say").text(	$("#say_"+$sayNowO).text()			).attr("data-sayord",$sayNowO)
		
	})


	
	
	$('.showLastExc, #start').on('click',function(e){e.preventDefault()
		$("#attachShow").hide();
		var $STEP=parseInt($pconsol.attr("data-step"));
		playStep($STEP)
	})

	function css_adaptP(cmd) {
		//return;
		//Slert ("css")
		var H=$(window).height(); var W=$(window).width();
		$("#mask").css({'width':W+'px'});$("#mask").css({'height':H+100+'px'})
		
		if (W<$desktopWidth) {
			var H_16_9 =W*$playerBackImgRatio
			//$("#player,#QUITE,#QUITED,#vask,#vansw,#debriefsplash,#listenU,#listenB").css({'width':W+'px'}) //,.vid
			//					.css({'height':H_16_9+'px'})
		}else{
			if (W<$desktopWidthMin) W=$desktopWidthMin //limit			
			var H_16_9 =$desktopWidth*$playerBackImgRatio
			//$("#player,#QUITE,#QUITED,#vask,#vansw,#debriefsplash,#listenU,#listenB").css({'width':$desktopWidth+'px'}) //,.vid    ,#vask,#vansw,#QUITE  #playerBackImg,
			//					.css({'height':H_16_9+'px'})
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
		

		$(".pop").css("left", $popL-20 + "px")//.hide()
		$(".pop").css("max-height", $popH+50+ "px")
		$("#contentH").css("max-height",$popH-170 + "px")	
				
		if (H<H_16_9+70-10) { //
			debug.html("playerConsoleTight")
			$pconsol.addClass("playerConsoleTight").removeClass("playerConsoleTall")
			$popT=10;
			$popH=H-47;
		}else{
			debug.html("playerConsoleTall")
			$pconsol.addClass("playerConsoleTall").removeClass("playerConsoleTight")
			$popT=(H- $(".pop").height() ) / 2;
			$popH=H-62;
		}
		//## pop 2/2
		$(".pop").css("top", $popT + "px")
		$(".pop").css("max-height", $popH+ "px")
		$("#contentH").css("max-height",$popH-170 + "px")
		//$(".pop").show()
		//## choice		

		$choiceH=$pconsol.offset().top+70-20
		$("#choiceCont").css("max-height", $choiceH+ "px")
		$("#choiceC").css("max-height", ($choiceH-$("#choiceH").height())+ "px")
		
		//balloonFontAdapt()
	}/// CSS ENDS



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

	//// SHOINFO
	var showInfo=function(p){
		
		if (p) {
			if ($pconsol.attr("data-playing")	=="1") { return;}
			$pconsol.fadeOut();
			$( "#mask,#explain" ).css("z-index", "105").fadeIn('fast')
			.promise().done(function(  ) {
				if (	!$("#logC .tmptxt").length) $("#logshow").click()
				css_adaptP() 
			})
			return
		}
		if (!$("#explainClose").hasClass("ftime")) $pconsol.fadeIn();
		$( "#mask,#explain" ).css("z-index", "100").fadeOut('fast')
	}
	
	$('.showInfo').on('click',function(e){e.preventDefault(); showInfo(true)})
	$('#explainClose').on('click',function(e){e.preventDefault();
		showInfo(false);
        if ($(this).hasClass("ftime")) {
			window.setTimeout(function() { 
						playStep(0)
					}, 1200) 
			$(this).removeClass("ftime");
		}else{     
            if( $("#debriefsplash").attr("data-visible")!="1" ) {
                var sceneGet=$("#currentscene").val();
                var st=$pconsol.attr("data-step")
                var $attNotOpen=0;// totale non aperti
                if (S[sceneGet][st]["compulsoryAttachments"]=="1"	) {	
                    var iX
                    for (iX = 1; iX <= S[sceneGet][st]["A"].length; iX++) {
                        if ( $("#att_"+iX).attr("data-read")=="0") {
                            $attNotOpen=$attNotOpen+1;
                        }   
                    }
                }

                if ($attNotOpen==0) $("#playerConsoleCont").show();
                else $("#playerConsoleCont").hide();
            }else{
                $("#playerConsoleCont").hide();
            }
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
			
			if (!$("#explainClose").hasClass("ftime")){
				transmit({cmd:"getExchanges",idm:G["idm"],gameId:G["gameId"]})
			}
			
		});
	})	
	

	
	
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
	//////////////////////////////////////////////////////////////////////////////////////// RUN	
	
	css_adaptP()
	
//	$(window).load(function(){		})
	$(window).bind('orientationchange',function(event){css_adaptP()}) 
	$(window).bind('resize',function(event){css_adaptP()})
	$(window).load(function () {	

		css_adaptP();

        if (G["videoIntro"]) {
        
            
            $("#attachViewerIN").html('<video id="embedVideoAttach" width="1000" height="562.5"><source src="/data/videoIntro/'+G["videoIntro"]+'?change" type="video/mp4">Putroppo il tuo browser non supporta il video :-(<br/>Your browser does not support the video</video>')
            $("#playerConsoleCont, #attachViewerClose").hide();
            showInfo(false)
            $("#attachViewer").fadeIn().prepend('<div id="skipIntro">Skip intro</div>');
            $("#skipIntro").click(function () {
                $("#attachViewerIN").html("")
                showInfo(true); $("#attachViewer").fadeOut();$("#attachViewerClose").show();loadStep(0); 
                $(this).remove();
            })
            $('#embedVideoAttach').trigger("play").on('ended',function(){
                if ( $( "#skipIntro" ).length>0 ){
                    $("#attachViewerIN").html("")
                    $("#attachViewer").fadeOut();loadStep(0);
                    showInfo(true);
                    $("#attachViewerClose").show();
                }
            })
            
            
        }else{
            loadStep(0)
            showInfo(true)  
        }
        

                
        //$("#explainClose").click();// debug
		//$("body:after").hide();

	})/////////////////////////////////////////////////////////////////////////////////////// RUN

	
	
})	