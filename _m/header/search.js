$(function() {

	////////////////////////////////////////// search start
	var xhr;
	function headSearch (q){
		//return
//		if (goSearch) goSearch.abort()
//		else alert ("nogoSearch")
//		alert (xhr)
	   if(xhr && xhr.readystate != 4){
			xhr.abort();
		}
		
		$("#hd_searchCont").prepend('<div class="loading_simple" id="searchHeadLoading"></div> ')
		xhr  = $.ajax({
			type: "GET", url: C_DIR+"/_m/groups/ajax.tags.php",data: {q:q, action:'searchall'}, cache: false,dataType: 'html',
			success: function (php_answer) {
				$("#core #searchHeadLoading").remove();
				r=php_answer.split("|-|")
				$("#debug").html(php_answer)
				//alert(php_answer)
				if (r[0]=="true"){
					var $res=parseInt(r[2]);
					//alert($res)
					$heightRes=$res*46;if ($res==1||$res==0 ) $heightRes=52;if ($heightRes>400) $heightRes=400; // redim container
					if ($res=="0") $heightRes=52;					
					$("#hd_searchRes_box_cont").css("height", $heightRes+"px");
					
					$("#hd_searchRes_box_cont").html(r[1]) 
					///// keys ctrl
					if ($res>0) {
						$("#core #SaTag_1").addClass("autoSelectHover") //.addClass("red")				
						var $ind=1
						$(document).off('keydown')					
						$(document).on('keydown',function(e){
							
							$("#hd_searchRes_box_cont .hd_notification_linelink").mouseout();
							if ($("#Q").is(":focus")	) {
								
							//if( $('#hd_searchRes_box_cont').is(':visible') ) {
								if (e.keyCode == 40) {
									//if ($ind==1) $("#SaTag_1").removeClass("autoSelectHover")
									//alert("down")
									//$(".hd_notification_linelink").removeClass("autoSelectHover")
									$("#core #SaTag_"+$ind).removeClass("autoSelectHover")
									$ind=$ind+1;if ($ind>$res)  $ind=$res;
									$("#core #SaTag_"+$ind).addClass("autoSelectHover")
									$("#debug").html(e.keyCode+" "+$ind)									
									
								}
								if (e.keyCode == 38) {
									$("#core #SaTag_"+$ind).removeClass("autoSelectHover")
									$ind=$ind-1;if ($ind==0)  $ind=1;
									$("#core #SaTag_"+$ind).addClass("autoSelectHover")
								}
								if (e.keyCode == 13) {	
									if ($ind==0) $ind==1
									$href=$("#SaTag_"+$ind).attr("href");
									if ($href!="#") $(location).attr('href',$href);
									
									$("#core #hd_searchRes_box_cont #SaTag_"+$ind).click();
									
									}
								if (e.keyCode == 27) $("body").click()

//								alert (e.keyCode)
							}
						})
						
					}
					
					//////////////////////////////////////
					
					
					//$("#hd_searchRes_box_cont").children(":first").focus().hover();
				}else{
					$("#hd_searchRes_box_cont").html('<div class="noResults">mmm ci deve essere un errore...</div>').css("height", "32px");
				}
				
				//debugWrite (r[0]+"<br>"+r[2]+"<br>"+r[3]+"<br>")
			}
			//,error: function(php_answer){alert ("err")}
			
		})
	}
	
	$("#hd_searchRes_box_cont").on('mouseenter',".hd_notification_linelink", function(e){
		$(".hd_notification_linelink").removeClass("autoSelectHover");
	})
	
	/*$("#headSearchI").on('mouseenter',function(e){
		//*$("#Q").show().animate({width:'320px'}).focus();
		$("#headSearchI").css('background', 'transparent url("/cpimg/ico/searchHeadOn.png?") no-repeat scroll center center');
		var actual_term=$.trim(		$("#Q").val().toLowerCase()		);actual_term = actual_term.replace(/ +/g," ");
		//debugWrite(actual_term)
		if (typeof actual_term !== 'undefined' && actual_term!="") {
			$("#QFake,headSearchI").hide();$("#hd_searchRes_box_cont").show();$("#core #searchHeadLoading").remove();
		}else{
			$("#QFake").show(200);//$("#hd_searchRes_box_cont").hide()
		}
		$("#headSearchI").hide();
		
	});*/
	$("#QFake,#headSearchI").on('click',function(e){ e.preventDefault();$("#Q").focus(); });
	
	$('html').on('click', function(e){
		idExp=null; if (typeof e.target.id !== 'undefined') idExp=e.target.id.split("_")//		alert (e.target.id+" --> "+idExp[0])
		if (
		(e.target.id!="Q") 
		&& (e.target.id!="QFake")  
		&&(e.target.id!="headSearchI")
		&& (idExp[0]!="SaTag")
		
		){
			$("#hd_searchRes_box_cont").hide() //#QFake,
			/*$('#Q').animate({width:'0px'},{//easing: 'swing',duration: 5000,
				 complete: function(){$(this).hide();	$("#headSearchI").show();}
			});
			$("#searchHeadLoading").remove();
			$("#headSearchI").css('background', 'transparent url("/cpimg/ico/searchHeadOff.png?") no-repeat scroll center center');//off
			*/
		}
	});	
	//var searchtimeout
	$("#Q").on('input',function(e){
		var actual_term=$.trim(		$(this).val().toLowerCase()		);actual_term = actual_term.replace(/ +/g," ");
		
		//$("#debug").html(actual_term)
		if (typeof actual_term !== 'undefined' && actual_term!="") {
			$("#QFake").hide();$("#hd_searchRes_box_cont").show()
			/*clearTimeout(searchtimeout);
			var searchtimeout = setTimeout(function(){
				(actual_term)
			}, 2000);*/
			headSearch(actual_term)
			
		}else{
			$("#QFake").show(200);$("#hd_searchRes_box_cont").hide();$("#core #searchHeadLoading").remove();
		}
	})
	.on('focus',function(e){
		var actual_term=$.trim(		$(this).val().toLowerCase()		);actual_term = actual_term.replace(/ +/g," ");
		$("#hd_searchCont").removeClass("opacity70")
		//$("#debug").html(actual_term)
		if (typeof actual_term !== 'undefined' && actual_term!="") {
			$("#QFake").hide();$("#hd_searchRes_box_cont").show()
			//headSearch(actual_term)
		}else{
			$("#QFake").show(200);$("#hd_searchRes_box_cont").hide();$("#core #searchHeadLoading").remove();
		}
	})
	.on('blur',function(e){
		$("#hd_searchCont").addClass("opacity70")
	})
	
		// tag search
	$("#hd_searchRes_box_cont").on('click','.tagSearch', function(e){e.preventDefault();
		$tag=$(this).attr("data-tag");	
//		alert ( $tag)
		$("#Q").val("tag: "+$tag)
		headSearch("tag: "+$tag)
	});
	// arrow navigate
	
	/*$("#hd_searchRes_box_cont").on('keydown', function(e){e.preventDefault();
	
	});*/
	////////////////////////////////////////// search End
	$("#core").on('click','.hd_notification_linelink', function(e){e.preventDefault();
		url=""
		idar=this.id.split("_")

		switch (idar[0]) {
		case "taggyms":
//			url="/?/editor/"+idar[1]+"/0";
			url="/?/gym/"+idar[1]+"";
		break;
		case "tagusrs":
			url="/?/users/"+idar[1];
		break;
		case "taggroups":
			url="/?/groups/"+idar[1];
		break;
		
		}
		if (url) window.location.href =url;
	});
	
	
})