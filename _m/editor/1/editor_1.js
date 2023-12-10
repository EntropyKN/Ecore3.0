
$(function() {

	var dialogOndeletingScene=true
	var dialogOndeletingStep=true

    Number.prototype.round = function(places) {
      return +(Math.round(this + "e+" + places)  + "e-" + places);
    }


	$("#mask").show()
	/////
    $("#dialog").dialog({
      autoOpen: false,
      modal: true,draggable: false,resizable: false,
		height: 120
		//title: "Dialog Title"
    });
	$(".ui-dialog-titlebar").hide()
	////
    
    // select/change avatar
    $("#pickAvatar").click(function(){
      $("#pickAvatarList").toggle();
    });
	$(".avtrI").click(function(){
		var avatar_id_send=this.id.replace("avtr_","");
		var currentClass=$("#avatarSprite").attr("class");
		var currentAvatarId=$("#avatarSprite").attr("data-currentAvatar");
        
        if (currentAvatarId==avatar_id_send) {
            $("#pickAvatarList").hide();
            return;
        }
		$("#avatarSprite").attr("class", 		currentClass.replace("avatar_"+currentAvatarId, "avatar_"+avatar_id_send)			)
		$("#avatarSprite").attr("data-currentAvatar", avatar_id_send);	
        
        var avtrName
		if (avatar_id_send=="1000"){
			$("#avatarSprite,#rightArrow,#leftArrow,#avatarDims").hide()
			$("#avatar_sentence_title span").text(L_sentence)
            avtrName=$(".avtrNameNOAVTR").text()
		}else{
			$("#avatarSprite,#leftArrow,#avatarDims").show()
			$("#avatar_sentence_title span").text(L_avatar_sentence)
            avtrName=$("#avtrName_"+avatar_id_send).text()  
		}
        audioDelete(); //#### note!
        $(".avtrI").removeClass("avtrSelected")
        $(this).addClass("avtrSelected");
        
        $("#pickAvatar span").text(avtrName);
        $("#pickAvatarList").hide();
        var ballpos = $("#balloon").position();
        var spritePos=$("#avatarSprite").attr("data-pos").split(",")
        if (spritePos[0]>ballpos.left) {
            $("#rightArrow").hide();$("#leftArrow").show();
        }else{
            $("#rightArrow").show();$("#leftArrow").hide();
        }        
		if (avatar_id_send=="1000") $("#avatarSprite,#rightArrow,#leftArrow,#avatarDims").hide()
            
		save ("avatar_id", avatar_id_send)	
        
        /// routine feedback audio
        for (var fbN = 1; fbN <= 4; fbN++) {
            if (    $("#answerFeedback_"+fbN).val().trim()!='' &&   $("#answerFeedbackSavedAudio_"+fbN).attr("data-avatar")!= avatar_id_send ) {
                
                console.log ( fbN,  $("#answerFeedback_"+fbN).val().trim(), $("#answerFeedbackSavedAudio_"+fbN).attr("data-avatar"), avatar_id_send  );
                generateAudioFeedback(fbN)
            }
            
        }
        
	})

    
    /////
	var loadStep=function (d)	{
    
       
        $("#core").attr("data-step",d["step"] ).attr("data-scene",d["scene"] )
		for (var i = 1; i <= 4; i++) { // answers reset
            $("#answer_"+i).text("")
			$("#answer_"+i).val("{loading}")
        }
		$( "#stepRef" ).text(d["step"]).show();
        $( "#sceneRef" ).text(d["scene"]).show();		
		$("#stepTitEnding").hide();
		$("#stepTit").show();
		/// finali
		if (d["type"]=="winning") {
			$("#stepTit").hide();
			$("#stepTitEnding").text(L_winning_end).show()
			$( "#sceneRef" ).text("A");
		}
		if (d["type"]=="loosing") {
			$("#stepTit").hide();
			$("#stepTitEnding").text(L_loosing_end).show()
			$( "#sceneRef" ).text("A");
		}
		if (d["type"]) $("#noFinalBlock").hide(); else $("#noFinalBlock").show();
        
        
        // scenario

		$("#scenarioHandlerLink").attr("href", "/?/scenarios/"+d["linkRef"]);		
		var scenario_id=d["scenario_id"];if (!scenario_id) scenario_id=0;
        $(".sceneimg").attr("src", "/data/scenarios/"+scenario_id+"_640.jpg")
        
		$("#scenario_id").val(scenario_id);
        var scenarioName=d["scenarioName"];
        
        if (scenario_id=="0") scenarioName=$("#scenarioHandlerLink").attr("data-defVal")
        $("#scenarioHandlerLink span").text (scenarioName)
        
        
        // avtr
		var avatar_id=d["avatar_id"];if (!avatar_id) avatar_id=0;
        // avrt name
        var avatarName=$("#avtrName_"+avatar_id).text()
        
        if (avatar_id=="0")         avatarName= $(".pickD").attr("data-defval")
        if (avatar_id=="1000")      avatarName=$(".avtrNameNOAVTR").text()
        $("#pickAvatar span").text (avatarName)        
		
        var currentAvatarId=$("#avatarSprite").attr("data-currentAvatar");		
		$("#avatarSprite").attr("class", 		$("#avatarSprite").attr("class").replace("avatar_"+currentAvatarId, "avatar_"+avatar_id)			).attr("data-currentAvatar", avatar_id);					
		if (d["avatar_id"]==1000){
			$("#avatarSprite,#rightArrow,#leftArrow,#avatarDims").hide()
			$("#avatar_sentence_title span").text(L_sentence)
		}else{
			$("#avatarSprite,#leftArrow,#avatarDims").show()
			$("#avatar_sentence_title span").text(L_avatar_sentence)
		}
        
        $(".avtrI").removeClass("avtrSelected")
        if (avatar_id!="0") $("#avtr_"+avatar_id).addClass("avtrSelected");		
		
		///
		var avatar_sizeC="as_S";var avatar_size="S";
		if (d["avatar_size"]) avatar_sizeC="as_"+d["avatar_size"];
		avatar_dims_change(avatar_sizeC)
		
		// default: left: 264px;top: 3px;
		var avatar_posC="264,3";if (d["avatar_pos"]) avatar_posC=d["avatar_pos"];
		var posA=avatar_posC.split(",")
		$("#avatarSprite").attr("data-pos", posA[0] +","+ posA[1] ).attr("style", "left: "+posA[0]+"px;top: "+posA[1]+"px;" )  //css({ top: posA[0], left: posA[1] });

		// balloon
		$("#avatar_sentence").val(d["avatar_sentence"])
		if (d["avatar_sentence"]) $("#balloon span").html(adaptTex2Balloon(d["avatar_sentence"]))
		else $("#balloon span").html("")
		var balloon_pos="157,31";if (d["balloon_pos"]) balloon_pos=d["balloon_pos"];
		var posB=balloon_pos.split(",")
		$("#balloon").attr("data-pos", posB[0] +","+ posB[1] ).attr("style", "left: "+posB[0]+"px;top: "+posB[1]+"px;" ) 

		// balloon
		var arrowY="11";if (d["arrowY"]) arrowY=d["arrowY"];
		$("#leftArrow").attr("data-top", arrowY ).attr("style", "right: -17px;top: "+arrowY+"px;" ) 
		$("#rightArrow").attr("data-top", arrowY ).attr("style", "left: -17px;top: "+arrowY+"px;" ) 
		if (d["avatar_id"]!=1000){
			if (d["arrowPos"]=="right") {$("#rightArrow").show();$("#leftArrow").hide();}
			else	{$("#rightArrow").hide();$("#leftArrow").show();}
		}
		
		// answers

		for (var i = 1; i <= 4; i++) {
			$("#answer_"+i).val(d["answer_"+i]+"")
            $("#answer_prev_"+i).html ( adaptTex2Balloon( d["answer_"+i]+"") )
			if (d["ascore_"+i] == null)  d["ascore_"+i]="na"
            if (d["ascore_"+i] == "null")  d["ascore_"+i]="na"
			$("#ascore_"+i).val(d["ascore_"+i]);
			
			if (i==4) {
				if (d["goto4"]==null	){
					$("#ascore_v_"+i).hide();	
					$("#addAnswer_"+i).show();
					$("#removeAnswer_"+i).hide();
				}else{
					$("#ascore_v_"+i).show();	
					$("#addAnswer_"+i).hide();
					$("#removeAnswer_"+i).show();
				}
				/*if (d["ascore_"+i]!="na"		|| d["answer_"+i]!=null)  {
					$("#ascore_v_"+i).show();	$("#addAnswer_"+i).hide();	
				}else{
					$("#ascore_v_"+i).hide();	$("#addAnswer_"+i).show();	
				}
				*/
			}
			var nextR=parseInt(d["step"])+1;

			$("#goto_"+i+"_A").text(		nextR	+"A") //attr("value",	nextR+"_A"). //"+D["steps"]+"
			if($("#stepM_"+nextR+"_B").length > 0) $("#goto_"+i+"_B").text(nextR+"B").show(); else $("#goto_"+i+"_B").hide()
			if($("#stepM_"+nextR+"_C").length > 0) $("#goto_"+i+"_C").text(nextR+"C").show(); else $("#goto_"+i+"_C").hide()
			if($("#stepM_"+nextR+"_D").length > 0) $("#goto_"+i+"_D").text(nextR+"D").show(); else $("#goto_"+i+"_D").hide()
			
			if (d["goto"+i]) $("#goto"+i).val(d["goto"+i])
			$(".addAnswer, .removeAnswer").attr("data-ref", d["step"]+"_"+d["scene"])
            // feedback
            if (d["feedback_"+i]) {
                $("#answerFeedback_"+i).val(d["feedback_"+i])
                $("#answerFeedbackSavedAudio_"+i).val(d["feedback_"+i])
                $("#addFeedback_"+i).hide();
                $("#fbArea_"+i).show();
            }else{
                $("#answerFeedback_"+i).val("")
                $("#answerFeedbackSavedAudio_"+i).val("")
                $("#addFeedback_"+i).show();
                $("#fbArea_"+i).hide();           
            }
            
            $("#answerFeedbackSavedAudio_"+i).attr("data-avatar", avatar_id)
            
            // risposte per immagine 
            changeAnswersMode (d["answersType"], false)
            $("#altImg_"+i).val(d["altImg_"+i])
            $("#prevEditGroupImg_"+i+" a").remove();
            $("#prevEditGroupImg_"+i+" .loadImage, #prevEditGroupImg_"+i+" .changeImage").remove();

            if (d["img_"+i]) {  
                $("#prevEditGroupImg_"+i).prepend('<a target="_blank" title="Open image in a new window" href="'+d["img_"+i]+'?'+Math.random()+'"><img src="'+d["img_"+i]+'" /></a><div id="changeImage_'+i+'" class="changeImage">'+L_change_image+'</div>').removeClass("prevEditGroupFirst");
            }else{
                $("#prevEditGroupImg_"+i).prepend('<div id="loadImage_'+i+'" class="loadImage">+'+L_upload_an_image+'</div>')
            }
            
            
	//	alert (d["goto"+i]);
		} // for
		

		if (parseInt(d["step"])<D["steps"]) {
			//$(".textarea_answ").addClass("textarea_answTight")
			$(".goto,.subtitleR1").show();				
		}else{
			//$(".textarea_answ").removeClass("textarea_answTight")
			$(".goto,.subtitleR1").hide();			
		}
		
		
	
		
		// audio
		$("#generateGroup,#audioControls").hide();$("#audioCmd").show()
		if (d["avatar_audio"]) {
			$("#auimgplay1").show()
			$("#auimgpause1").hide()
			$("#audioControls").show()
            var pathAvatarAudio= "/data/audio/"+d["avatar_audio"].replace('/data/audio//data/audio/', "/data/audio/");
            
			$("#auimgplay1") .attr("data-file",pathAvatarAudio)	            
			$("#player").attr("src",  pathAvatarAudio)
		}
		
		
		//attachment
		var attachNumber=0
		$(".attachments_L").hide();
		for (var atr= 0; atr < 5;atr++) { // reset			
			var atr1=atr+1;
			$("#href_att_"+atr1 ).attr("href",  "#");	
			$("#href_att_"+atr1+" .attImg" ).attr("src",  '');	
			$("#attTitle_"+atr1 ).val("").attr("data-ida","0")
			$("#attDelete_"+atr1 ).attr("data-ida",  "0")
		}		
					
		for (var at= 0; at < d["attachment"].length;at++) {
			
			attachNumber=at+1;

			var $atc=d["attachment"][at]
			$("#href_att_"+attachNumber ).attr("href",  $atc["path"]);	
			$("#href_att_"+attachNumber+" .attImg" ).attr("src",  '/img/ico/'+$atc["type"]+'60.png');	
			$("#attTitle_"+attachNumber ).val($atc["title"]).attr("data-ida",$atc["idAttachment"])
			$("#attDelete_"+attachNumber ).attr("data-ida",  $atc["idAttachment"])
			$("#attachments_L_"+attachNumber).show();
		}
		if (attachNumber) $("#compulsoryAttachmentsBox").show(); else $("#compulsoryAttachmentsBox").hide();
		if (attachNumber==5) $("#attachmentLine").hide();else $("#attachmentLine").show()

		
		if (d["compulsoryAttachments"]=="0") {			
			$("#compulsoryAttachmentsMsg").text(L_COMPULSORY_ATTACHMENTS_NO)
            $("#compulsoryAttachmentsBox").attr("data-compulsoryAttachments","0")
		}else {
			$("#compulsoryAttachmentsMsg").text(L_COMPULSORY_ATTACHMENTS_YES)
            $("#compulsoryAttachmentsBox").attr("data-compulsoryAttachments","1")
		}
		//$("#compulsoryAttachmentsBox").attr("data-compulsoryAttachments",d["ompulsoryAttachments"])

		//alert(d["game"]["L4_comment"]+" "+D["gameId"])
		var commentA = ["L1", "L2", "L3", "L4", "W1", "W2", "W3", "W4"];
		for (var cc = 0; cc < commentA.length; ++cc) {
			var curComm=d["game"][		commentA[cc] +"_comment"		] 	;
			//alert ("#cmtarea_fc_"+commentA[cc]+" "+		curComm					)
			$("#cmtarea_fc_"+commentA[cc]).val(		curComm		)
			if ( curComm) {
				$("#cmt_"+commentA[cc]).addClass("cmton")
				$("#faketxt_fc_"+commentA[cc]).hide()
			}else{
				$("#cmt_"+commentA[cc]).removeClass("cmton")
				$("#faketxt_fc_"+commentA[cc]).show()
			}
		
			$("#upContainerL").css({'height':$("#upContainerR").height()+'px'})	
			//scoreCalc();
		
		}
		
        MathJax.typeset()	 // update equation	
		urlChange(d["step"], d["scene"])

	}
    var urlChange=function (stepU, sceneU)	{
        var urlPath="/?/editor/"+D["gameId"]+"/1/"+stepU+"/"+sceneU
         //window.history.pushState({},"", urlPath) //"html":response.html,"pageTitle":response.pageTitle
         history.replaceState({}, document.title, urlPath);
    }

	var getStructure=function (clickThis, htm)	{
		$("#mask").show()


		if (typeof htm !== 'undefined' && htm !== null) {
			$("#upContainerL").html(htm)
			if (clickThis=="firstCall") {
				//$("#stepM_1_A").click()
                $("#stepM_"+D["startStep"]+"_"+D["startScene"]).click()

				scoreCalc();
				//alert(clickThis)
			}else{
				if (typeof clickThis !== 'undefined' && clickThis !== null ) {
					$(clickThis).click()
                    
					scoreCalc();
				}
			}
            
            
			$("#mask").hide()
		}else{
			$.ajax({
				type: "POST", url: "/_m/editor/1/ajax.sceneHandler.php"
				,data: {gameId:D["gameId"], divid:"getStructure" } 
				,cache: false,dataType: 'html',
				success: function(JD){				
					JD=JSON.parse(JD);
					console.log(JD)
					if (!JD["response"]) {
						alert (JD["reason"])
						return;
					}

					$("#upContainerL").html(JD["htm"])
					if (clickThis=="firstCall") {

						$("#stepM_"+D["startStep"]+"_"+D["startScene"]).click()

						scoreCalc();
						//alert(clickThis)
					}else{
						if (typeof clickThis !== 'undefined' && clickThis !== null) {
							$(clickThis).click()
							scoreCalc();
						}
					}
                    
					$("#mask").hide()

				}//$.ajax
			})	
		}
		
			
	}
	
	
	////////////// RightSide editor functions
	var sceneHandler=function (divid)	{

		if (!divid) return;
		//.console.log(divid)
//		scene= ($( "#sceneRef" ).text());
		
		$("#saving").show()
		$.ajax({
			type: "POST", url: "/_m/editor/1/ajax.sceneHandler.php"
			,data: {gameId:D["gameId"], divid:divid } 
			,cache: false,dataType: 'html',
			success: function(JD){				
				JD=JSON.parse(JD);
				console.log(JD)
				if (!JD["response"]) {
					$("#saving").hide()
					alert (JD["reason"])
					return;
				}
				//alert ("stepM_"+JD["step"]+"_"+JD["scene"])
				
				if (JD["action"]=="addScene") 		getStructure("#stepM_"+JD["step"]+"_"+JD["sceneInsert"],JD["htm"]);
				if (JD["action"]=="deleteScene") 	getStructure("#stepM_"+JD["step"]+"_A",JD["htm"]);
				if (JD["action"]=="addStep" || JD["action"]=="deleteStep" ) 	{
					$("#stepTit").html("Step <span>"+JD["newStepNumbers"]+"</span>/"+JD["newStepNumbers"]+"<span>A</span>");
					D.steps=JD["newStepNumbers"];
					getStructure("#stepM_"+JD["newStepNumbers"]+"_A",JD["htm"]);
				}
                
				$("#saving").hide()
				
			}
		})
		
	}	
	$(document).on("click",'.addScene', function(e) {
		e.preventDefault()
		sceneHandler(this.id)	//addScene_2_A
	})	
	.on("click", ".deleteScene", function(e) {e.preventDefault()
		var idgo=this.id									   
		if (dialogOndeletingScene){
			$("#dialog").dialog({
			open: function () {
				$(this).html(L_DO_YOU_REALLY_WANT_TO_DELETE_THIS_SCENE);
			},			

			  buttons: [{
				text: L_yes,
				 class: 'buttoActionBackground',
				//icons: {primary: "ui-icon-check"},
				click: function() {
							$(this).dialog("close");
							sceneHandler(idgo)	//deleteScene_2_A
				}},{
				text: L_cancel,
				click: function() {
				   $(this).dialog('close');
				}
			  }]
			}).dialog("open");	
            
            
		}else{
			sceneHandler(idgo)
		}
		
	})
	.on("click",'.addStep,.deleteStep', function(e) {

		var idgo=this.id									   
		if (dialogOndeletingStep && $(this).attr("class")=="deleteStep" ){
			$("#dialog").dialog({
			open: function () {
				$(this).html(L_DO_YOU_REALLY_WANT_TO_DELETE_THIS_STEP);
			},			

			  buttons: [{
				text: L_yes,
				 class: 'buttoActionBackground',
				//icons: {primary: "ui-icon-check"},
				click: function() {
							$(this).dialog("close");
							sceneHandler(idgo)	//deleteScene_2_A
				}},{
				text: L_cancel,
				click: function() {
				   $(this).dialog('close');
				}
			  }]
			}).dialog("open");											   
		}else{
			sceneHandler(idgo)
		}
	})	
	
	/////////////
	
	
	var save=function (what, val, table, whereId, step, scene)	{
		
		if (!what) return;
		
		if (!table) table="";
		if (!whereId) whereId="";
		if (!scene) scene= $("#core").attr("data-scene") //($( "#sceneRef" ).text());  
        if (!step) step= $("#core").attr("data-step")//($( "#stepRef" ).text());
		//alert (what)
        console.log(step, scene, whereId)
		$("#saving").show()
        var datas={gameId:D["gameId"], step:step, scene:scene,what:what, val:val, table:table,whereId:whereId }
        console.log(datas)
		$.ajax({
			type: "POST", url: "/_m/editor/1/ajax.save.php"
			,data: datas 
			,cache: false,dataType: 'html',
			success: function(php_answer){
				console.log(php_answer)
				//$("#debug").html(php_answer)
				$("#saving").hide()
				var whatA=what.split("_");
				MathJax.typeset()
				if (whatA[0]=="ascore"	|| whatA[0]=="answer" || whatA[0]=="answersType") scoreCalc();
				return true
			}
		})	
	}

	var saveNloadStructure=function (what, val, clickid)	{
		
		if (!what) return;
		var scene= ($( "#sceneRef" ).text());
		
		$("#saving").show()
		$.ajax({
			type: "POST", url: "/_m/editor/1/ajax.save.php"
			,data: {gameId:D["gameId"], step:$( "#stepRef" ).text(), scene:scene,what:what, val:val } 
			,cache: false,dataType: 'html',
			success: function(php_answer){
				getStructure(clickid)
				$("#saving").hide()
				
				return true
			}
		})	
	}	
	
	
	
	var scoreCalc=function ()	{
		$.ajax({
			type: "POST", url: "/_m/editor/1/ajax.scorecheck.php"
			,data: {gameId:D["gameId"] } 
			,cache: false,dataType: 'html',
			success: function(php_answer){
				//$("#debug").html(php_answer)
                console.log(php_answer)

				r=php_answer.split("|-|")
				if (r[0]=="false") {
					
					$("#fgraph, #missingmsg").hide();
					$("#fgraphNotAvailable span").text(r[1]);
					$("#fgraphNotAvailable").show();
				}else{
					$("#fgraph,#missingmsg").show();
					$("#fgraphNotAvailable").hide();
					// values!
//					alert (r[1])
					var SC=$.parseJSON(r[1])
					$("#gLegend100 .subGlegend span").text(SC.W4.spreadR )
					//$("#gLegend50 .subGlegend span").text(SC.L4.spreadR )
//                    $("#gLegend50 .subGlegend span").text(SC.W2.spreadR )
//                    $("#gLegend50 .subGlegend").html("75%<span>"+SC.W2.spreadR+"</span>" )
                    $("#gLegend50").html('75%<div class="subGlegend">Score:<span>'+SC.W2.spreadR+'</span></div>')
  
  
					$("#gLegend0 .subGlegend span").text(SC.L1.spreadL)
/*					$.each(SC.W4, function(i2, v) {
						(i2+" "+v);
					});*/
//					alert (SC.W4.spreadR )

				}
			}
            , error: function(resp){ alert("errore"+resp) }
		})	
	}	
	
	//avatarSprite
	$( "#avatarSprite" ).draggable({
//        containment: "#fakePlayerAVATARlimit",
        scroll: false,
        //container:"upContainerR",

       //containment:[0,0,1000,1000], // [x1, y1, x2, y2]
        drag: function() {

            var $this = $(this);
            var thisPos = $this.position();
            var parentPos = $this.parent().position();
			
			$("#avatarSprite").attr("data-pos", thisPos.left +","+ thisPos.top );		
			
			 var ballpos = $("#balloon").position();
			//$("#debug").text (thisPos.left+" "+ballpos.left)
			if (thisPos.left>ballpos.left) {
				$("#rightArrow").hide();$("#leftArrow").show();
				save ("arrowPos ","left"	)
			}else{
				$("#rightArrow").show();$("#leftArrow").hide();
				save ("arrowPos ","right"	)
			}
		

        },
        revert: function() {
            var $this = $(this);
            var thisPos = $this.position();
            var parentPos = $this.parent().position();
            //console.log(thisPos.left,thisPos.top, $this.height(), $this.width());
            
            $outX=false;$outY=false;
            var $left=thisPos.left.round(3);var $top=thisPos.top.round(3);
            
            if ($left*-1> $this.width()*0.5 )  { $left=0;$outX=true; console.log ("out left") }
            if ($left> 500-$this.width()*0.5)    { $left=0;$outX=true; console.log ("out right")}
            if ($top*-1> $this.height()*0.8)    {  $top=0;$outY=true; console.log ("out top")}
            if ($top> 281-$this.height()*0.1)    {  $top=0;$outY=true; console.log ("out down")}
            if ($outX) $this.css("left", "0");
            if ($outY) $this.css("top", "0");
            if ($outX || $outY ) {
                $("#avatarSprite").attr("data-pos", $left.round(3) +","+ $top.round(3) );
                $("#leftArrow").hide();$("#rightArrow").show();
            }
			save ("avatar_pos", $left.round(3) +","+ $top.round(3)		)				

        }

})	



	//balloon
	$( "#balloon" ).draggable({
        containment: "#fakePlayer",
        scroll: false,
        drag: function() {
            var $this = $(this);
            var thisPos = $this.position();

	//		$("#debug").text(thisPos.left + ", " + thisPos.top);
			$("#balloon").attr("data-pos", thisPos.left.round(3) +","+ thisPos.top.round(3) );		
        },
        revert: function() {
			save ("balloon_pos", $("#balloon").attr("data-pos")		)
			 var avatarSpritePos = $("#avatarSprite").position();
			  var thisPos = $(this).position();
			$("#debug").text (thisPos.left+" "+avatarSpritePos.left)
			//alert (d["scenario_id"])
			if ($("avatar_id").val()==1000){		
				if (avatarSpritePos.left>thisPos.left) {
					$("#rightArrow").hide();$("#leftArrow").show();
					save ("arrowPos ","left"	)
				}else{
					$("#rightArrow").show();$("#leftArrow").hide();
					save ("arrowPos ","right"	)
				}			
			}
			
        }

})	

	$( "#leftArrow,#rightArrow" ).draggable(
	{ axis: "y" },
	{
        containment: "#balloon",
		
        scroll: false,
        drag: function() {
            var $this = $(this);
            var thisPos = $this.position();
			$("#debug").text(thisPos.left + ", " + thisPos.top);
			$("#leftArrow,#rightArrow").attr("data-top", thisPos.top );
        },
        revert: function() {
			var $this = $(this);var thisPos = $this.position();
			if ($this.attr("id")=="rightArrow") 	{
				$("#leftArrow").attr("data-top", thisPos.top ).attr("style", "right: -17px;top: "+thisPos.top+"px;" ).hide() 
				$("#rightArrow").show()
			}
			if ($this.attr("id")=="leftArrow")		{
				$("#rightArrow").attr("data-top", thisPos.top ).attr("style", "left: -17px;top: "+thisPos.top+"px;" ).hide()	
				$("#leftArrow").show()
			}
			save ("arrowY ", thisPos.top		)
        }

})	


	$(document).on("click",'.upContainerBox', function(e) {e.preventDefault()
	//$(document).on(".upContainerBox","click", function(e) {e.preventDefault()
		//responsiveVoice.speak("Ciao Bello", "Italian Female", {});	//		https://code.responsivevoice.org/getvoice.php?t=miao%20ciao&tl=it&sv=g1&vn=&pitch=0.5&rate=0.5&vol=1&gender=female			pitch: 2	https://responsivevoice.org/text-to-speech-languages/
		step=this.id.replace("stepM_", "")
		dataA=this.id.split("_");
		step=dataA[1];
        scene=dataA[2]
		
		var id=this.id;
		$("#mask").show()
		$("#editingAdvice").hide();
		$.ajax({
			type: "POST", url: "/_m/editor/1/ajax.getStep.php"
            ,async: false
			,data: {gameId:D["gameId"], step:step, scene:scene, action:"getStep"} //
			,cache: false,dataType: 'html',
			success: function(php_answer){
                //console.log(php_answer)
				r=php_answer.split("|-|")
				//$("#debug").html(id)
				IDC=id.split("_");
				
				$("#mask").hide()
				$(".upContainerBox").removeClass("sceneNowEditing");
				$(".cableV").removeClass("greenCable");
				$("#"+id).addClass("sceneNowEditing");
				gotoA=$("#"+id).attr("data-go2").split(",")
				//console.log(id, gotoA)
				
				if (gotoA.length){
					for (let dest of gotoA) { 
					toGreenId="cableV_"+IDC[1]+dest;
					$("#"+toGreenId).addClass("greenCable")
    				//console.log(toGreenId);		//cableV_3B
					}
				}
				
				//*$("#"+id). prepend( 		$("#editingAdvice")		);
				
				//*$("#editingAdvice").show();
				//alert ($.parseJSON(r[1]));
				//var dataStep = $.parseJSON(r[1]);
				//console.log("ajax.getStep.php", $.parseJSON(r[1]));
                //console.log("ajax.getStep.php", (r[2]));                
				loadStep($.parseJSON(r[1]))
			}
		})			

	})		
	var adaptTex2Balloon=function (t)	{
		t=t.trim()
		t=t.replace(/\n/g,"<br />");//nl2br
		MathJax.typeset()
		return t
	}





	var avatar_dims_change=function (av_size)	{ // as_S
		if (!av_size) return;
		
		$("#avatarDims a").removeClass("don")
		currentSize=$("#avatarSprite").attr("data-currentSize");
		currentClass=$("#avatarSprite").attr("class");
		$("#"+av_size).addClass("don")
		size=av_size.replace("as_","")
		$("#avatarSprite").attr("class", 		currentClass.replace("wait_"+currentSize, "wait_"+size)			)
		$("#avatarSprite").attr("data-currentSize", size);		
		

	}

	
	$("#avatarDims").on("click",'a', function(e) {e.preventDefault()
		avatar_dims_change(this.id)
		$(this).blur()
		size=this.id.replace("as_","")
		save ("avatar_size", size)	
	})		
	var writeDB=null;
    
    
	$("#avatar_sentence").on("keyup", function(e) {
		if ($(this).val().length>=800) alert ("There's a limit of 800 digits for this area");
		$("#balloon span").html(adaptTex2Balloon($(this).val()))
			clearTimeout(writeDB);
			writeDB = setTimeout(function(){ 
				save ("avatar_sentence", $("#avatar_sentence").val())
			}, 1000);		
	})
    
    var generateAudioFeedTimer=null;
	$(".textarea_fb").on("keyup", function(e) {
        var thisid=this.id.replace("answerFeedback_","feedback_");
        //console.log ("change key")
		if ($(this).val().length>=800) alert ("There's a limit of 800 digits for this area");
		var vali=$(this).val();
        clearTimeout(writeDB);
        writeDB = setTimeout(function(){             
            //alert (thisid+" "+vali)
            save (thisid, vali)
        }, 1000);
        
        clearTimeout(generateAudioFeedTimer);
        
        generateAudioFeedTimer = setTimeout(function(){     
            var thisidA=thisid.replace("feedback_","");
           //   console.log ("this id A", thisidA)
            generateAudioFeedback(thisidA);
        }, 1500);        
        
	}).on("blur", function(e) {
        var thisid=this.id.replace("answerFeedback_","");
        generateAudioFeedback(thisid);
      })  
	$(".removeFeedback").on("click", function(e) {
        var thisid=this.id.replace("removeFeedback_","");
        $("#fbArea_"+thisid).hide();
        $("#answerFeedback_"+thisid).val("");
        save ("feedback_"+thisid, "")
        save ("feedback_"+thisid+"_audio", ""    )
        
	})
	
    $(".answer_prev").on("click", function(e) {
        id=this.id.replace("answer_prev_", "answer_")
        $(this).hide();
        $("#"+id).show().focus();
    })    
    
	$(".textarea_answ").on("keyup", function(e) {
			if ($(this).val().length>=255) {
                alert ("There's a limit of 255 digits for this area");
                return;
		    }
			id=this.id; v=$(this).val();
            idPrev=this.id.replace( "answer_", "answer_prev_")
            
			clearTimeout(writeDB);
			writeDB = setTimeout(function(){
               $("#"+idPrev).html(     adaptTex2Balloon(v)         )
                //alert (id+" "+v)      (what, val, table, whereId, step, scene)
				save (id, v, null, null, $("#core").attr("data-step"), $("#core").attr("data-scene"))
			
			}, 500);
	})
    .on("blur", function(e) {
        id=this.id.replace( "answer_", "answer_prev_")
        $(this).hide();
        $("#"+id).show()
        //idFx=this.id.replace( "answer_", "fx_answ_")$("#"+idFx).hide()
        
    })
	$(".addFeedback").on("click", function(e) {e.preventDefault()
        var thisId=this.id.replace("addFeedback_","")

        $("#fbArea_"+thisId).show();
        $("#answerFeedback_"+thisId).focus();
	 	$(this).hide();	
	})
	$(".removeFeedback").on("click", function(e) {e.preventDefault()
        var thisId=this.id.replace("removeFeedback_","")
        //////////
        
        $("#answerFeedback_"+thisId).val("");
        $("#fbArea_"+thisId).hide();
        $("#addFeedback_"+thisId).show();
	 			 
	})
    
    
	var addRemove4thAnswer=function(action, where){
		console.log(action, where)
		$.ajax({
			type: "POST", url: "/_m/editor/1/ajax.sceneHandler.php"
			,data: {gameId:D["gameId"], 
            divid:action+"_"+where } 
			,cache: false,dataType: 'html',
			success: function(JD){				
				JD=JSON.parse(JD);
				console.log(JD)
				if (!JD["response"]) {
					alert (JD["reason"])
					return;
				}

				$("#upContainerL").html(JD["htm"])
				//stepM_3_C
				$ ("#stepM_"+where).click();
                scoreCalc();
			}
		})	//$.ajax
		
	}

	$(".addAnswer").on("click", function(e) {e.preventDefault()
			
		$("#"+this.id.replace("addAnswer_","ascore_v_")).show();
		$(".removeAnswer").show()
	 	$(this).hide();
		addRemove4thAnswer("addAnswer", $("#"+this.id).attr("data-ref")	) 
											 
	})	

	$(".removeAnswer").on("click", function(e) {e.preventDefault()
			
		$("#"+this.id.replace("removeAnswer_","ascore_v_")).hide();
		$(".addAnswer").show()
		$(this).hide();
		addRemove4thAnswer("removeAnswer", $("#"+this.id).attr("data-ref")) 
	})	
	
	$(".ascore").on("change", function(e) {
			save (this.id, $(this).val())
			scoreCalc();
	})	
	
	$(".goto").on("change", function(e) {
		var stepThis=parseInt( $( "#stepRef" ).text())
		var sceneThis=$( "#sceneRef" ).text()
		var questionThis=this.id.replace("goto","")
		var sceneDestination=$(this).val();
		/*
		console.log("GT_"+stepThis+"_"+sceneThis+questionThis+"		gotoGr gotoGr_"+sceneDestination+" gotoGr_"+sceneThis+questionThis+"TO"+sceneDestination )
		$("#GT_"+stepThis+"_"+sceneThis+questionThis).attr("class","gotoGr gotoGr_"+sceneDestination+" gotoGr_"+sceneThis+questionThis+"TO"+sceneDestination);
		*/
//		console.log ("stepM_"+stepThis+"_"+sceneThis)
		saveNloadStructure (this.id, $(this).val(), "#stepM_"+stepThis+"_"+sceneThis		)
		
	})	
	
	
	//########### audio
    
    var generateAudioFeedback=function(feedbackN){
        if (!feedbackN) return;
        console.log("generateAudioFeedback "+feedbackN+" "+$("#answerFeedback_"+feedbackN).val()    )
        if ( 
            $("#answerFeedbackSavedAudio_"+feedbackN).val()==$("#answerFeedback_"+feedbackN).val()  
            &&
            $("#answerFeedbackSavedAudio_"+feedbackN).attr("data-avatar")== $("#avatarSprite").attr("data-currentavatar")
            
            ) {
            //console.log("gia generato "+feedbackN+" avatar "+$("#answerFeedbackSavedAudio_"+feedbackN).attr("data-avatar"));
            return;
        }
        //console.log("genero "+feedbackN);
		text=$("#answerFeedback_"+feedbackN).val().trim()
		if (!text) {
            // CASO NULL
            save ("feedback_"+feedbackN+"_audio", ""    )
            return; 
        }

        var dataA={text:text,gameId:D["gameId"], step:step, scene:scene,voice:$("#voice").val(),
            lang:D["language"], avatarId:$("#avatarSprite").attr("data-currentavatar"), voiceSex: "m",
            feedback: feedbackN
            }

		
		step=$( "#stepRef" ).text()
		scene=$( "#sceneRef" ).text()
		$.ajax({
			type: "GET", url: "/_m/editor/1/ajax.synth.php"
			,data: dataA
			,cache: false,dataType: 'json',
			success: function(obj){
                console.log(obj)
                if (obj.response) {
                    $("#answerFeedbackSavedAudio_"+feedbackN).val(      $("#answerFeedback_"+feedbackN).val()         )
                        .attr("data-avatar", obj.avatarId );
                    save ("feedback_"+feedbackN+"_audio", obj.fileName    )
                }else{
                    alert("a little error occurred: "+obj.reason)
                }
			}
		})
    }    
    
    
    var generateAudio=function(){
		$("#avatar_sentence").val($("#avatar_sentence").val().trim())	
		text=$("#avatar_sentence").val().trim()
		if (!text) {
			$("#avatar_sentence").focus();		
			$("#digit").fadeIn().fadeOut("50000");
			return;
		}
		
		step=$( "#stepRef" ).text()
		scene=$( "#sceneRef" ).text()
		$("#loadingAudio").show();
		$.ajax({
			type: "GET", url: "/_m/editor/1/ajax.synth.php"
			,data: {
            text:text,gameId:D["gameId"], step:step, scene:scene,voice:$("#voice").val(),
            lang:D["language"], avatarId:$("#avatarSprite").attr("data-currentavatar"), voiceSex: $("#voice").val()
            } //
			,cache: false,dataType: 'json',
			success: function(obj){
                console.log(obj)
                if (obj.response) {
                    $("#loadingAudio").hide();
                    $("#generateGroup").hide()
                    $("#audioCmd,#audioControls").show()		
                    $("#auimgplay1") .attr("data-file","/data/audio/"+obj.fileName)
                    save ("avatar_audio", obj.fileName    )
                }else{
                    $("#loadingAudio").hide();
                    $("#generateGroup").hide()
                    $("#audioControls").hide()
                    $("#audioCmd").show()
                    alert("a little error occurred: "+obj.reason)
                }
			}
		})	    
    }
    
	$("#generateAudio").on("click", function(e) {e.preventDefault()
		pausa("auimgplay1")
		$("#audioControls").hide()
		$("#audioCmd").hide()
        if ($("#avatarSprite").attr("data-currentavatar")=="1000") {
            $("#generateGroup").show()
        }else{
            generateAudio()
        }
	})	
	$("#generateGo").on("click", function(e) {e.preventDefault()
        generateAudio()
	})	
	
	
	
	$(".audioLoad").on("change", function() {
			pausa("auimgplay1")
		$("#loadingAudio").show();
		$imgId=this.id.replace("au","auimg")
		
		var file_data = $(this).prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data)
		//gameId:D["gameId"], state:state
		form_data.append('gameId', D["gameId"])
		form_data.append('step', step=$( "#stepRef" ).text())
		form_data.append('scene', step=$( "#sceneRef" ).text())
		form_data.append('id', $("#audioLine").attr("data-id"))                 
	    $.ajax({
                url: "/_m/editor/1/ajax.audio.php",
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(resp){
					//asdassingleMask(false)
					
					r=resp.split("|-|")
                    //$("#debug").html(resp)
					$("#loadingAudio").hide();
					$("#audioCmd, #audioControls").show()
                    
					$("#auimgplay1") .attr("data-file",r[1])	
					//alert (r[1])
                    r[1]= r[1].replace('/data/audio//data/audio/', "/data/audio/")
                    
					save ("avatar_audio", r[1].replace("/data/audio/",""))
					
					if (r[0]=="true"){
						/*
						$("#"+$imgId).attr("src", "/img/ico/audio16on.png?ss").attr("title", 		$("#"+$imgId).attr("data-titlebis")		)
						
						$("#"+$imgId.replace("auimg","auimgplay"))
							.attr("data-file",r[1])
							.show()
							$("#audioLine").attr("data-edit",1)
							
							*/
	//					var fileName = "/data/audio/besame.mp3?"+Math.random()
	//					$("#player").attr("src", fileName).trigger("play");
					}else{
						//alert (r[1])
					}
					//singleMask(false)
					$("#mask").hide()
                }
				, error: function(resp){ alert("errore"+resp) }
				
				
    	});
	});
	
    var audioDelete=function () {
        pausa("auimgplay1")

        step=$( "#stepRef" ).text()
        scene=$( "#sceneRef" ).text()
        $.ajax({
            type: "POST", url: "/_m/editor/1/ajax.audio.php"
            ,data: {gameId:D["gameId"], step:step, scene:scene,cmd:'delete'} //
            ,cache: false,dataType: 'html',
            success: function(php_answer){
                r=php_answer.split("|-|")
                //$("#debug").html(php_answer)
                $("#audioControls").hide()
                save ("avatar_audio", null)
            }
        });    
    }

		$("#audioDelete").on("click", function(e) {e.preventDefault()
            audioDelete();
		});
		
	// audio play
	var suona=function (ID){
		if (!ID) ID="auimgplay1"

		$(".audioPause").hide()
		$nowplayingid=parseInt($("#audioLine").attr("data-playing"))
		if ($nowplayingid) $("#auimgplay"+$nowplayingid).show()
		var $playId=ID
		$pauseId=$playId.replace("auimgplay","auimgpause")
		$("#audioLine").attr("data-playing",$pauseId.replace("auimgpause","") )
		
		$("#"+$playId).hide();$('#'+$pauseId).attr("data-file", $('#'+$playId).attr("data-file") ).show()
		fileName = ""+$('#'+$playId).attr("data-file")+"?"+Math.random()
		$("#player").attr("src", fileName).trigger("play")
		.on('ended',function(){
	      $('#'+$playId).show();$('#'+$pauseId).hide()
    	})		
	}
	var pausa=function (ID){
		if (!ID) ID="auimgpause1"
		
		$("#audioLine").attr("data-playing",0)
		$playId=ID.replace("auimgpause","auimgplay")
		$("#"+ID).hide();$('#'+$playId).show()
        
        if ($("#"+ID).attr("data-file")) {
            fileName = "/data/audio/"+$("#"+ID).attr("data-file")+"?"+Math.random()
            fileName= fileName.replace('/data/audio//data/audio/', "/data/audio/");
            $("#player").attr("src", fileName).trigger("pause")
        }
	}
	var audioReset=function(){
		$nowplayingid=parseInt($("#audioLine").attr("data-playing"))
		if ($nowplayingid) pausa("auimgpause"+$nowplayingid)
	}
	$(".audioPlay").on("click", function() {
		suona(this.id)
	})
	$(".audioPause").on("click", function() {
		pausa(this.id)
	})


	// upload
	$(".audioLoadFake").on("click", function(e) {e.preventDefault()
		idd=$(this).attr("data-d")
		$("#"+idd).click()
	})	


	// attachments
	
	$(".attTitle").on("keyup", function(e) {
		var $idAttachment=$(this).attr("data-ida");
		
		if (!$idAttachment) return;
			var text=$(this).val()
			clearTimeout(writeDB);
			writeDB = setTimeout(function(){ 
				save ("title", text, "attachments", $idAttachment)
				//  (what, val, table, whereId)	
			}, 1000);


	})		
	
	$("#file").on("click", function(e) {e.preventDefault()
		$("#attachmentInput").click()
	})	

	$("#attachmentInput").on("change", function() {
		$("#mask").show()
		var file_data = $(this).prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data)
		//gameId:D["gameId"], state:state
		form_data.append('gameId', D["gameId"])
		form_data.append('step', step=$( "#stepRef" ).text())
		form_data.append('scene', step=$( "#sceneRef" ).text())
              
	    $.ajax({
                url: "/_m/editor/1/ajax.attach.php",
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(resp){
					//asdassingleMask(false)
					
					r=resp.split("|-|")
                    console.log(resp)
					$("#mask").hide()
					if (r[0]=="true") {
						attachNumber=0;
						for (var an = 1; an <= 5; an++) {
							if (	$("#attDelete_"+an ).attr("data-ida")=="0" ){
								attachNumber=an
								break
							}
						}
						if (attachNumber) {				
							$("#attachments_L_"+attachNumber ).show();
							$("#href_att_"+attachNumber ).attr("href", r[3]);
							$("#href_att_"+attachNumber+" .attImg" ).attr("src",  '/img/ico/'+r[4]+'60.png');							
							$("#attTitle_"+attachNumber ).val(r[2]).attr("data-ida",  r[1]).focus()
							$("#attDelete_"+attachNumber ).attr("data-ida",  r[1])
						}
						
						if (attachNumber=="5") $("#attachmentLine").hide(); else $("#attachmentLine").show()
						if (attachNumber=="0") $("#compulsoryAttachmentsBox").hide(); else $("#compulsoryAttachmentsBox").show()
						$("#upContainerL").css({'height':$("#upContainerR").height()+'px'})
						//alert (attachNumber)
					}else{
						alert (""+r[1])
					}
                }	
    	});
	});

		$(".attDelete").on("click", function(e) {e.preventDefault()
			var $idAttachment=$(this).attr("data-ida");
			if (!$idAttachment) return;
			var attachNumber=this.id.replace("attDelete_", "")
			var path=$("#href_att_"+attachNumber).attr("href")
			$.ajax({
				type: "POST", url: "/_m/editor/1/ajax.attach.php"
				,data: {gameId:D["gameId"], step:step, cmd:'delete', idAttachment:$idAttachment, path:path} //
				,cache: false,dataType: 'html',
				success: function(resp){
					$("#attachments_L_"+attachNumber ).hide();
					$("#href_att_"+attachNumber ).attr("href", "");
										
					$("#attTitle_"+attachNumber ).val("").attr("data-ida",  "0")
					$("#attDelete_"+attachNumber ).attr("data-ida", "0")
					$("#attachmentLine").show()
					
						attachNumberC=0;
						for (var an = 1; an <= 5; an++) {
							if (	$("#attDelete_"+an ).attr("data-ida")!="0" ){
								attachNumberC=attachNumberC+1;
								break
							}
						}

						if (attachNumberC=="0") $("#compulsoryAttachmentsBox").hide(); else $("#compulsoryAttachmentsBox").show()
						$("#upContainerL").css({'height':$("#upContainerR").height()+'px'})
					
					 
				}
			});
		})	

		$("#link").on("click", function(e) {e.preventDefault()
			url=$("#url").val().trim()
			if (!url) {$("#url").focus(); return;}
			step=$( "#stepRef" ).text()
			scene=$( "#sceneRef" ).text()
			
			$("#mask,#spinLoad").show()

			
			$.ajax({
				type: "POST", url: "/_m/editor/1/ajax.attach.php"
				,data: {gameId:D["gameId"], step:step,scene:scene, url:url, cmd:'url'} //
				,cache: false,dataType: 'html',
				success: function(php_answer){
                    console.log(php_answer)
					r=php_answer.split("|-|")
					if (r[0]=="true") {
						attachNumber=0;
						for (var an = 1; an <= 5; an++) {
							if (	$("#attDelete_"+an ).attr("data-ida")=="0" ){
								attachNumber=an
								break
							}
						}
						//alert ("scusate sto aggiustando una cosa, ma potete continuare tranquillamente: "+attachNumber)
						if (attachNumber) {
							//true|-|38|-|√ Rockol - la musica online è qui - Novità Musicali|-|link|-|				
							$("#attachments_L_"+attachNumber ).show();
							$("#href_att_"+attachNumber ).attr("href", r[3]);
							$("#href_att_"+attachNumber+" .attImg" ).attr("src",  '/img/ico/'+r[4]+'60.png');							
							$("#attTitle_"+attachNumber ).val(r[2]).attr("data-ida",  r[1]).focus()
							$("#attDelete_"+attachNumber ).attr("data-ida",  r[1])
							$("#url").val("");
						}
						if (attachNumber=="5") $("#attachmentLine").hide(); else $("#attachmentLine").show()
						$("#upContainerL").css({'height':$("#upContainerR").height()+'px'})
						if (attachNumber=="0") $("#compulsoryAttachmentsBox").hide(); else $("#compulsoryAttachmentsBox").show()
						
					}else{
						//alert(r[1])
						alert (""+r[1])
					}
					$("#debug").html(php_answer)
					$("#mask,#spinLoad").hide()
				}
			})		
			/*$.ajax({
				type: "POST", url: "/_m/editor/1/ajax.attach.php"
				,data: {gameId:D["gameId"], step:step, cmd:'delete', idAttachment:$idAttachment, path:path} //
				,cache: false,dataType: 'html',
				success: function(resp){
					$("#attachments_L_"+attachNumber ).hide();
					$("#href_att_"+attachNumber ).attr("href", "");
										
					$("#attTitle_"+attachNumber ).val("").attr("data-ida",  "0")
					$("#attDelete_"+attachNumber ).attr("data-ida", "0")
					$("#attachmentLine").show()
					 
				}
			})
			*/;
		})			
		
		
	//#######################  	compulsoryAttachments
		
	$("#compulsoryAttachmentsChange").on("click", function(e) {e.preventDefault()
		var compulsoryAttachmentsCurrent=$("#compulsoryAttachmentsBox").attr("data-compulsoryAttachments");

		
		if (compulsoryAttachmentsCurrent==0) {
			compulsoryAttachments=1
			
			$("#compulsoryAttachmentsMsg").text(L_COMPULSORY_ATTACHMENTS_YES)
		}else {
			compulsoryAttachments=0
			$("#compulsoryAttachmentsMsg").text(L_COMPULSORY_ATTACHMENTS_NO)
		}
		$("#compulsoryAttachmentsBox").attr("data-compulsoryAttachments",compulsoryAttachments)
		save ("compulsoryAttachments", compulsoryAttachments)	
		
	})	



	// missing
	var restoreMissing=function(){
		$("#missingList").html("").hide()
		$("#okmsg,#playerSimLilnk").hide() //#rangeGraph,#positiveForm,#negativeForm,#rangeGraph,#rangeGraph200,#rangeGraph200T,.simLink
		
		$("#missingmsg").show()
	}
	$("#core").on("keyup change", "input, textarea, select", function(e) {restoreMissing()})
		.on("click", "a,#audioDelete,.upContainerBox", function(e) {restoreMissing()})	
	
	$("#checkmissing").on("click", function(e) {e.preventDefault()
		$("#mask").show()
		$.ajax({
			type: "POST", url: "/_m/editor/1/ajax.missing.php"
			,data: {gameId:D["gameId"]} //
			,cache: false,dataType: 'html',
			success: function(php_answer){
				resp=php_answer.split("|-|")
				$("#debug").html(php_answer)
				if (resp[0]=="false"){
					$("#missingList").html(resp[1]).show()
					$("#missingmsg").hide()
				}
				if (resp[0]=="true"){
					//alert ("Tutti i campi sono perfetti!")
					
					$("#missingmsg").hide()
					$("#okmsg,#playerSimLilnk").show()
				}
				
				$("#mask").hide()

			}
		})	
	})	


	var cmtopen=function (id){
		$("#core").attr("data-cmtedit",id);
		$("#cmtareac_"+id).show()
		$("#cmtarea_"+id).focus()		
	}
	$(".cmt").on("click", function(e) {e.preventDefault()
		$(".cmtareac").hide()
		id=this.id.replace("cmt_", "")
		$("#cmtareac_fc_"+id).show();
		$("#cmtarea_fc_"+id).focus();
		//console.log ("da .cmt "+id)
		return;

	})	
	$(".boxQuarterL,.boxQuarterW").on("click",function(e) {
		$(".cmtareac").hide()
		id=this.id
		$("#cmtareac_fc_"+id).show();
		$("#cmtarea_fc_"+id).focus();		
		//console.log("da box"+this.id)
		//$("#cmt_"+this.id).click(); PROBLEM
	})	
	
	
	$(".cmtareac").on("keyup change", "textarea",function(e) {
		var id=this.id.replace("cmtarea_", "")
		var idsave=id.replace("fc_", "")
		var v=$(this).val().trim();
		clearTimeout(writeDB);
		writeDB = setTimeout(function(){ 
			save (idsave+"_comment", v,	"comments")
				if ( v) $("#cmt_"+idsave).addClass("cmton")
				if (!v) $("#cmt_"+idsave).removeClass("cmton")			
		}, 600);		

		
		v=$(this).val().trim()
		fake=$("#cmtareac_"+id+" .faketxt")
		if (v=="") {fake.show()}else{fake.hide()}
		
	}).on("blur",'textarea', function(e) { ///  
		target=this.id.replace("cmtarea_fc_", "cmtareac_fc_");		
		$("#"+target).hide();
	})
	
	$(".faketxt").on("click",function(e) {
		target=this.id.replace("faketxt_fc_", "cmtarea_fc_");
		$("#"+target).focus();
	})

	
	
	$("#boxScenarioLose").on("click",function(e) {e.preventDefault()
		$(".loosingStep").click();$("html, body").animate({ scrollTop: 0 }, "slow");
	})
	$("#boxScenarioWin").on("click",function(e) {e.preventDefault()
		$(".winningStep").click();$("html, body").animate({ scrollTop: 0 }, "slow");
	})

	$("#upContainerR").on("click",function(e) {
		$("#upContainerL").css({'height':$("#upContainerR").height()+'px'})
	})	
	

	$("#okmsg").on("click", function(e) {e.preventDefault()
		$("#mask").show()
        $("#spinLoad").show()
		$.ajax({
			type: "POST", url: "/_m/ajax.gameHandler.php"
			,data: {idg:$("#core").attr("data-gameId"),cmd: "setPlayable"} //
			,cache: false,dataType: 'html',
			success: function(php_answer){
				resp=php_answer.split("|-|")
				$("#debug").html(php_answer)
				if (resp[0]=="true") {
					//alert (resp[1])
					window.location.href = "/?/_msg/savedPlayable/"+resp[1]+""
				}else{
					//$("#mask").hide()
				}
				$("#mask").hide()
                $("#spinLoad").hide()

			}
		})	
	})		
	
	/*.on("blur", "textarea",function(e) {
		id=this.id.replace("cmtarea_", "")
		v=$(this).val().trim()
		$(this).val(v).hide()
			
	})
*/		

	$(".cmtsave").on("click", function(e) {e.preventDefault()
		$(".cmtareac").hide()
	})		
	$(document).on("click", function(e) {
    var tclass=e.target.className
        if (tclass!="pickD" && tclass!="avtrName" &&tclass!="avtrI" && tclass!="avtrI avtrSelected"  && tclass!="pickAvatarT"  ){
            $("#pickAvatarList").hide();
		  //console.log(tclass+" nascondo")
        }
	})

    const mjxgui = new MJXGUI('#mjxgui-button', '$$', function() {
        //let tr = document.createElement('tr');
        let data='\n'+"<eq>$$ "+mjxgui.getLatex()+" $$</eq>"+'\n';
        targetA=$("#mjxgui_editor_window").attr("data-target").split ("_")
        
        //fx_answ_X
        if (targetA[0]=="fx" && targetA[1]=="answ") {
            $("#answer_"+targetA[2]).val( $("#answer_"+targetA[2]).val()+data)
            $("#answer_prev_"+targetA[2]).html($("#answer_prev_"+targetA[2]).html()+data)       
            MathJax.typeset()
            $("#answer_"+targetA[2]).keyup()
        }
        if (  $("#mjxgui_editor_window").attr("data-target")=="fx_avatar_sentence"  )  {
          $("#avatar_sentence").val( $("#avatar_sentence").val()+data).keyup()
            
        }
        

    })
        
    $(".fx").on("click", function() {
        $("#mjxgui_editor_window").show()
        $("#mjxgui_editor_window").attr("data-visible", "true").attr("data-target", this.id)
    })
    
    // L_textual or L_by_images
    $("#answersC div").on("click", function() {
        if ($(this).attr("class")=="active") return;
        idi=this.id.replace("answers_", "") // txt or img
        changeAnswersMode(idi, true)
 
})

    
    var changeAnswersMode=function (idi, write)	{
		if (!idi) return;
        $("#answersC div").removeClass("active");
        $("#answers_"+idi).addClass("active");
        if (idi=="img") {
            $(".prevEditGroup").hide();
            $(".prevEditGroupImg").show()
        }else{
            // txt
            $(".prevEditGroup").show();
            $(".prevEditGroupImg").hide()        
        } 
        if (write) {
            save ("answersType", idi)
            //scoreCalc(); // moved in save()
        }
		//console.log(idi)
    }
    
    $(document).on("click",'.loadImage, .changeImage', function(e) {
        var ref=this.id.replace("loadImage_", "").replace("changeImage_", "");
        $("#uploadInput").val("").attr("data-answer",ref ).click()

    })   


	$("#uploadInput").on("change", function() {
		$("#mask,#spinLoad").show()

		var file_data = $(this).prop('files')[0];
		var form_data = new FormData();                  
		form_data.append('file', file_data)
		form_data.append('gameId', D["gameId"])
		form_data.append('step', $( "#stepRef" ).text())
		form_data.append('scene',$( "#sceneRef" ).text())
        form_data.append('answer',  $("#uploadInput").attr("data-answer")      )
	    $.ajax({
                url: "/_m/editor/1/ajax.imageHandle.php",
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(resp){
					r=resp.split("|-|")
                    console.log(resp)
					$("#mask,#spinLoad").hide()
					if (r[0]=="true") {
                        $("#prevEditGroupImg_"+r["1"]+" img, #loadImage_"+r["1"]+"").remove();
                        $("#prevEditGroupImg_"+r["1"]).prepend('<a target="_blank" title="Open image in a new window" href="'+r[2]+'?'+Math.random()+'"><img src="'+r[2]+'" /></a><div id="changeImage_'+r[1]+'" class="changeImage">'+L_change_image+'</div>').removeClass("prevEditGroupFirst");
					   scoreCalc();
					}else{
						alert (""+r[1])
					}
                    
                }	
    	});
	});

	$(".altImg").on("keyup", function(e) {
        var idc=this.id.replace("altImg_","")
        var val=$(this).val()
		if (val.length>255) alert ("There's a limit of 800 digits for this area");
        
        clearTimeout(writeDB);
        writeDB = setTimeout(function(){ 
            console.log("altImg_"+idc, val)
            save ("altImg_"+idc, val)
        }, 1000);		
	})
	//############### run

	$(window).load(function(){
		getStructure("firstCall")
		//$("#stepM_1_A").click(); scoreCalc(); 
		//alert (		$( "#stepRef" ).text()			) 
		//alert (		$( "#sceneRef" ).text()			) 
		
		//$( "ul li:nth-child(2)" )$("#stepTit span").text(),
		
		$("#mask").hide()
	})
	//


})