var C_DIR=""
	
$(function() {
	var $debug=$("#debug")
	var $pageId=$("body").data("pageid")
	$("#closedebug").on("click", function(e) {e.preventDefault()
		$(this).hide()
		$debug.hide();
	})
    
   
    
	// tootip
	/*$(document).on({
		mouseenter: function () {
			var title = $(this).attr('title');
			$(this).data('tipText', title).removeAttr('title');
			$('<p class="tooltip"></p>')
			.text(title)
			.appendTo('body')
			.fadeIn('');
	  },
		mouseleave: function () {
			$(this).attr('title', $(this).data('tipText'));
			$('.tooltip').remove();
		},
		mousemove: function (e) {
			var mousex = e.pageX + 0 //Get X coordinates
			var mousey = e.pageY + 0; //Get Y coordinates 75
			if (mousey<0) e.pageY;
			//$("#debug").text("top:"+ mousex+" left:"+mousey)
			
			$('.tooltip')
			.css({ top: mousey, left: mousex })
		}
	}, ".close,.tip");
	*/
	var $desktopWidth=1200
	var $desktopWidthMin=340	

	window.css_adapt=function () { 
		if ($pageId=="editor") {
			$("#core").css({'width':'1200px'})
			//alert ("editor")
			return;
		}
		var H=$(window).height(); var W=$(window).width();
		//console.log("W:"+W); 
		$("#mask").css({'width':W+'px'});$("#mask").css({'height':H+'px'})

		
		if (W<$desktopWidth) {
			if ($pageId!="player" || $pageId!="editor") $("#core,#footer,#menuFixed").css({'width':'100%'})
			else $("#footer").css({'width':'100%'})
			$("#bigicon").hide();
			Win=$("#core").width()
			
			if ($pageId=="response") {
			//	alert (	(w/3) )
			//$("#chartdiv").css({'width':(W/3)+'px'}).css({'height':(W/3)+'px'})
			}
			
		}else{
			if (W<$desktopWidthMin) W=$desktopWidthMin //limit			
			if ($pageId!="player" || $pageId!="editor") $("#core,#footer,#menuFixed").css({'width':$desktopWidth+'px'})	
			else $("#footer").css({'width':$desktopWidth+'px'})	
			$("#bigicon").show();
			Win=$desktopWidth
			
		}




				
		//$("#debug").text(W+" x "+H+" ") //+H_16_9

		if (W<800 ){ //|| H<591 ipad 1024 x 768
			var dt = new Date();var d =dt.getMilliseconds();d="";
			$("#switchCss").attr("href",''+C_DIR+'/css/mobile.css?'+d)
			//alert ("mobile")
		/*		41
				if (W<526  ) {
				$("#switchCss").attr("href",'/'+C_DIR+'/css/mobileSmall.css')
			}else{
				$("#switchCss").attr("href",'/'+C_DIR+'/css/mobile.css')
			}*/
		}else{
			$("#switchCss").attr("href", ''+C_DIR+'/css/mobileOFF.css')
			
		}
		
			if ($pageId=="response") {
			//alert (	Win )

				if (W>670 ) {
					Win3=Win*0.4
					Win23=(Win*0.50)-0;
					$("#containerRightP").css({'margin':'20px 0px 0px 20px'})
					//$(".areaC, .areaT").css({'height':'auto'})
				}else{
					Win3=Win*0.9
					Win23=(Win*0.88);
					$("#containerRightP").css({'margin':'20px 0px 0px 0px'})
					//$(".areaC, .areaT").css({'height':'auto'})
				}
				$("#chartdiv").css({'width':Win3+'px'}).css({'height':Win3+'px'})
				$("#containerRightP").css({'width':Win23+'px'})
				
				if (W<364 ) $(".areaT").css({'width':'100%'})
				
			}		
		
		
		
	}/// CSS ENDS
	



	
	


	// pagination
	$('#core').on('click','.showPage', function (e) {e.preventDefault();
		//clearTimeout(PageTimeOut);
		if (	$(this).attr("data-loading")=="1"		) { 
		return;
		//alert ("exist");
		}
		$(this).attr("data-loading", "1");
		$url=''+C_DIR+"/_m/ajax.browseData.php"
		PAGE=this.id.replace("showPage","")
		COMMAND=$(this).attr("data-command")

		
		$('#showPage'+PAGE).before("<div class=\"loading loading_browse\"></div>");
		$('#showPage'+PAGE).hide();
		$.ajax({
			type: "POST", url: $url
			//type: "POST", url: '/'+C_DIR+"/handler/browseProducts/browseProductsAjax.php"
			,data: {PAGE:PAGE,COMMAND:COMMAND} // 
			,cache: false,dataType: 'html',
			success: function(php_answer){
				resp=php_answer.split("|-|")
				$("#debug").html(resp[2]);
				//php_answer=unident(php_answer);
				
				if (resp[0]=="true") {
					$('#showPage'+PAGE).before(resp[1]);
					$('#showPage'+PAGE+", .loading").remove();
				}else{alert (php_answer)
				}
				
			}, error: function(php_answer){alert ("ajax err");}
		})
	})


	// RUN	
	css_adapt()
//	$(window).load(function(){	
	$(window).on('load', function(){
	css_adapt();	
	if ($pageId=="home") $("#showPage1").click();
	
	})
	$(window).bind('orientationchange',function(event){css_adapt()}) 
	$(window).bind('resize',function(event){css_adapt()})

	$('#hd_nav_settings').on('click',function(e){
		e.preventDefault();
		$( "#hd_settings_box_cont" ).fadeToggle( "fast", function() {
		
		});
		//$( "#hd_settings_box_cont" ).toggle();
	})
    
    $("#menuFixed").mouseenter(function(){
        $("#logo").animate({
            width: "100px"
        });
    }).mouseleave(function(){
        $("#logo").animate({
            width: "37px"
        });
    });     
    
	// HTML CLICK
	$('html').on('click', function(e){
		targetDepuredA=e.target.id.split("_");
		//targetDepuredParentA=$(this).parent().attr('id').split("_");
		//alert(e.target.id+" aa "+targetDepuredA[0]+" "+$(this).closest('a').attr('id')		);
		// notifications
		if (
		(e.target.id!="hd_nav_settings")  
		&&(e.target.id!="hd_nav_settings_img")
		)
			$("#hd_settings_box_cont").hide(); 
		
	})

});