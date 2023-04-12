$(function() {

	var debug=$("#debug")	
	/*var $desktopWidth=1000
	var $desktopWidthMin=340
	var $playerBackImgRatio=(9/16) 	
    */
    
    $("#dialog").dialog({
      autoOpen: false,
      modal: true,draggable: false,resizable: false,
		height: 142
		//title: "Dialog Title"
    });
	$(".ui-dialog-titlebar").hide()
    //$( ".ui-dialog" ).dialog({ minHeight: 50 });
	var adaptTex2Balloon=function (t)	{
		if (!t) return;
		t=t.trim()
		t=t.replace(/\n/g,"<br />");//nl2br
		
		return t
	}

    var startMatchMovie=function(){
        $("#playmask").show();
        $("#playerTitles").hide()
        $("#mask,#player").show()
        playTrig(null, null, "firtissima");
    }
	$(".playMovie").on("click", function(e) {e.preventDefault()
        var actualsexsession =$("#player").attr("data-sexsession")

        
		if (actualsexsession!="M" && actualsexsession!="F"){
			$("#dialog").dialog({            
			open: function () {
				$(this).html(L_CHOICE_VOICE_TEXT);
			},

			  buttons: [{
				text: L_feminine,
				 class: 'buttoActionBackground',
				//icons: {primary: "ui-icon-check"},
				click: function() {
                    $("#player").attr("data-sexsession", "F")
				    $(this).dialog("close");
                    startMatchMovie()
							//sceneHandler(idgo)	//deleteScene_2_A
				}},{
				text: L_masculine,
				click: function() {
                    $("#player").attr("data-sexsession", "M")
				    $(this).dialog("close");
                    startMatchMovie()
				}
			  }]
			}).dialog("open");											   
		}else{
            startMatchMovie()
        
        }
        
		//$("#player").addClass("movie")
		//$("body").prepend($("#player"))
       //playSeq(0)
	
		
	})	

	$("#closeP").on("click", function(e) {e.preventDefault()
		//$(this).before($("#player")).hide() ??
        /*if ( $("#player").attr("data-playing")=="1"    ) {        
            $("#player").attr("data-close","1");
        }else{
            $("#player, #mask").hide()
        }
        */
        $("#player").attr("data-close","1");
        $("#playmask").show();
		//css_adaptP()

	})

    
    var playTrig=function(sn=null, statusBack=null) {
        // status=null, answer, feedback
        
        if (sn===null && statusBack===null ) {
            
            $("#playmask").fadeIn()
            $('#fx1').trigger("play")            
                window.setTimeout(function() {  loadSeq(0, null, "first");	}, 1600	)            
            
            return;
        }
         if (sn>=S.length) return;
        
        if (sn>=0) {
            if (statusBack===null){
                 loadSeq(sn, 'answer', "A");
                 return;
            }
            
            if (statusBack==='answer' 
                && S[sn]["feedback"]!="" 
                && S[sn]["feedbackAudio"]!=""
             ){
                 loadSeq(sn, 'feedback', "F");
                 return;
            }
            var sngo=sn+1
            //loadSeq(sngo,null, "avanzo1");
            $("#playmask").fadeIn()
            $('#fx1').trigger("play")            
                window.setTimeout(function() {  loadSeq(sngo,null, "avanzo1")	}, 1600	)	   
            return
        }
    }

    
    
    
	var loadSeq=function(s, status=null, info=null) {

        if (status===null) $( "#playmask" ).fadeIn()
        
        
        console.log ("loadSeq ", s,"statusBack ", status,"info ", info);
        
        var audioFile=S[s]["avatar_audio"];
        var avatar_id=S[s]["avatar_id"]
        var size=S[s]["avatar_size"]
        var avatar_pos=S[s]["avatar_pos"];
        var balloon_pos=S[s]["balloon_pos"];
        var arrowPos=S[s]["arrowPos"];
        var arrowY=S[s]["arrowY"]
        var balloon_text= S[s]["question"];

        if (status=="answer")   {
        
            audioFile=S[s]["answerAudio"];

            if (    $("#player").attr("data-sexsession")  =="F" ) {
                audioFile=S[s]["answerAudio"].replace("M.mp3","F.mp3")
            }
            
            console.log("audioFile", audioFile)
            avatar_id=1000;
            arrowY="10";
            balloon_text=S[s]["answer"];
            arrowPos="left";
            $("#balloon").addClass("answerBalloon")
        }else{
            $("#balloon").removeClass("answerBalloon")
        }
        if (status=="feedback") {
            audioFile=S[s]["feedbackAudio"];
            size="XL";
            balloon_pos="159,87" //"318,174" 
            avatar_pos="-54,0" 
            arrowPos="right";
            arrowY="22";
            balloon_text=S[s]["feedback"];
        }
                
        //console.log (avatar_pos +" "+size);              
        // commons
        $("#balloon").fadeOut();
         


        // audio 
        $("#aask").attr("src", "/data/audio/"+audioFile) // avatar

        // avatar
		     
		var currentAvatarId=$("#avatarSprite").attr("data-currentAvatar");
		$("#avatarSprite").attr("class", 		$("#avatarSprite").attr("class").replace("avatar_"+currentAvatarId, "avatar_"+avatar_id).replace("avatar_"+currentAvatarId+"_talk", "avatar_"+avatar_id)			).attr("data-currentAvatar", avatar_id);
		$("#avatarSpriteTalk").attr("class", 		$("#avatarSpriteTalk").attr("class").replace("avatar_"+currentAvatarId+"_talk", 	"avatar_"+avatar_id+"_talk")			);        

                
		// avatar size
		
		var currentSize=$("#avatarSprite").attr("data-currentSize");
		var currentClass=$("#avatarSprite").attr("class");
		var currentClassTalk=$("#avatarSpriteTalk").attr("class");		
		$("#avatarSprite").attr("class", 		currentClass.replace("wait_"+currentSize, "wait_"+size)			)
		$("#avatarSpriteTalk").attr("class", 		currentClassTalk.replace("wait_"+currentSize, "wait_"+size)			)		
		$("#avatarSprite").attr("data-currentSize", size);	
        
        // avatar position
        var avatarC=avatar_pos.split(",")
        var $factorResize=2;
		$("#avatarSprite,#avatarSpriteTalk").attr("style", "left: "+avatarC[0]*$factorResize+"px;top: "+avatarC[1]*$factorResize+"px;" ) 
		
		// ballon 
         var balloonC=balloon_pos.split(",")
		$("#balloon").attr("style", "left: "+balloonC[0]*$factorResize+"px;top: "+balloonC[1]*$factorResize+"px;" )
		$("#balloon span").html(adaptTex2Balloon(balloon_text));		
		
		arrowY=arrowY*$factorResize;
		$("#leftArrow").attr("data-top", arrowY ).attr("style", "right: -17px;top: "+arrowY+"px;" ) 
		$("#rightArrow").attr("data-top", arrowY ).attr("style", "left: -17px;top: "+arrowY+"px;" ) 
        
		
		if (arrowPos=="right") {$("#rightArrow").show();$("#leftArrow").hide();}
		else	{$("#rightArrow").hide();$("#leftArrow").show();}
		
		if (avatar_id==1000) $("#rightArrow,#leftArrow").hide();
		if (status=="answer") $("#leftArrow").show();
        
        // common
        
        
		var scenario="/data/scenarios/"+S[s]["scenario_id"]+"_1024.jpg";
        /*$('#scenario').load(function() {
           
        }).attr('src',scenario).show()  
        */
        if (status===null) {
            $("#scenario").attr("src",scenario).show();
            $("#playmask").fadeOut(2500).promise().done(function(  ) {
                playSeq(s, status, info)                
            })
        }else{
            window.setTimeout(function() {  playSeq(s, status, info)	}, 1000	)	
        }


	} 
    var gomovie;
    var playSeq=function(s, status=null, info=null) {
        console.log ("playSeq", s,"statusBack ", status,"info ", info, "data-close", $("#player").attr("data-close"));
        var isFinal=false;if (s>=S.length-1) isFinal=true;    
        var avatar_id=S[s]["avatar_id"]
       /* if (status!==null)  $("#avatarSprite").fadeOut();
        else $("#avatarSprite").fadeIn();
        */
         $("#avatarSpriteTalk").show(0, function(){
            $("#avatarSprite").hide();
        });
        
        $("#balloon").fadeIn("fast");
        $("#player").attr("data-playing", "1")
        
        
        $('#aask').trigger("play").on('ended',function(){			
            $('#aask').hide().unbind('ended')			
            $("#avatarSpriteTalk").hide()
            $("#avatarSprite").show()
            
            if ( $("#player").attr("data-close")=="1"    ) { // closing has been booked
                $("#player,#mask").hide();
                $("#player").attr("data-close", "0")
            }else{
                var gomovie=setTimeout(function(){

                    if (!isFinal ) {
                        playTrig(s, status)
                    }else{

                        $("#playerTitles").fadeIn("500").css('display','table');
                        $("#player").attr("data-playing", "0")
                        
                    }			
                }, 500);
            }



            return;
        })        


    }

/*
    playtrig=>
    loadSeq (pre) =>playSeq  =>playTrg or final


*/


	function css_adaptP() {

		var H=$(window).height(); var W=$(window).width();
		$("#mask").css({'width':W+'px'});$("#mask").css({'height':H+100+'px'})
		
		/*if (W<$desktopWidth) {

		}else{
			if (W<$desktopWidthMin) W=$desktopWidthMin //limit			
		}
        */
        var playerW=1000; // fixed
        $("#player").css({'left':((W-playerW)/2)+'px'})
        //}
        $("#player").css({'width':(playerW)+'px'}).css({'height':(playerW/16*9)+'px'})
		
		//balloonFontAdapt()
	}/// CSS ENDS

//////////////////////////////////////////////////////////////////////////////////////// RUN	
	
	css_adaptP();
/*
        $("#playerTitles").hide()
        $("#mask,#player").show()
        playTrig(null, null, "firtissima");
*/


//	$(window).load(function(){		})
	$(window).bind('orientationchange',function(){css_adaptP()}) 
	$(window).bind('resize',function(){css_adaptP()})
	$(window).load(function () {	

		css_adaptP(); 
       


	})/////////////////////////////////////////////////////////////////////////////////////// RUN

	
	
})	
    
    