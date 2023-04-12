function trim(stringToTrim) {
	if (!stringToTrim) return;
		stringToTrim=stringToTrim.replace(/ +(?= )/g,'')  // repeatet spaces
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}
function ltrim(stringToTrim) {
 return stringToTrim.replace(/^\s+/,"");
}
var C_DIR=""
var spin64='<div class="spin64"></div>'
var spin16='<div class="spin16"></div>'

$(function() {
	singleMask=function (mode){
		//$('body .spin64').remove();
		$('#mask').hide()
		if (!mode) return
		//$('#m').prepend(spin64);
		$('#mask').show()
		return
	}	
	
	var NOTHING ="<span\ id=\"nothing_yet\">("+L_nothing_yet+")</span>"

	var deb=$("#debug");
	var xhr;
	$('.row').on('click', function(e){e.preventDefault()
		
		id=this.id.replace("row","");
		
		if (id=="0") return;
			$('.row').removeClass("rowFocus")
			$(this).addClass("rowFocus")
			 
			
		//alert (id);
		
	 	if(xhr && xhr.readystate != 4){xhr.abort();}					
		// aj check email
		//$("#inputSiemail .spin16").show();
		//singleMask(true)
		xhr  =$.ajax({
			//async: false,
			type: "POST", url: '/_m/groups2.0/groupGet.ajax.php'
			,data: {idg:id, action:"getGroup"} // 
			,cache: false,dataType: 'json',
			success: function(obj){
               // console.log(obj)
				$("#idg").val(obj.idgroup)
				$("#name").val(obj.name)
				$("#description_it").val(obj.description_it)
				$usersCSV=""
				$gymsCSV=""
				$insightersCSV="";
				$usersTAG="";
				$gymsTAG=""
				$insightersTAG="";		
				
				deb.html("")
				
				$.each( obj.users, function( key, value ) {
					
				 $.each( value, function( k, v ) {
					
					 if (k=="uid") {
						 $usersCSV+=v+",";
						 $usersTAG+='<div class="tag" id="tagusr_'+v+'">'
					 }else{
						 $usersTAG+=v+'<a href="#">X</a></div>'
					 }
					  deb.html(deb.html()+ key + ") K:" + k + " V:" + v +"<br>");
//					  $usersTAG='<div id="tagU'++'" class="tag"></div>'
				  });
				});
				$("#usersCSV").val($usersCSV.slice(0, -1))
				if (!$usersTAG) $usersTAG=NOTHING; $("#usersArea").html ($usersTAG);
					

				$.each( obj.gyms, function( key, value ) {
				 $.each( value, function( k, v ) {
					 if (k=="gameId") {
						 $gymsCSV+=v+",";
						// alert($gymsCSV)
						 $gymsTAG+='<div class="tag" id="taggym_'+v+'">'
					 }else{
						 $gymsTAG+=v+'<a href="#">X</a></div>'
					 }
					  deb.html(deb.html()+ key + ") K:" + k + " V:" + v +"<br>");
				  });
				});
				deb.html(deb.html()+"<br>*******<br>");
				$("#gymsCSV").val($gymsCSV.slice(0, -1))				
				if (!$gymsTAG) $gymsTAG=NOTHING; $("#gymArea").html  ($gymsTAG);

				$.each( obj.insighters, function( key, value ) {
				 $.each( value, function( k, v ) {
					 deb.html(deb.html()+ key + ") K:" + k + " V:" + v +"<br>");
					 if (k=="uid") {
						 $insightersCSV+=v+",";
						 $insightersTAG+='<div class="tag" id="Etagusr_'+v+'">'
					 }else{
						 $insightersTAG+=v+'<a href="#">X</a></div>'
					 }
				 
				  });
				 
				});
				
				$("#insightesrCSV").val($insightersCSV.slice(0, -1))				
				if (!$insightersTAG) $insightersTAG=NOTHING; $("#insightersArea").html  ($insightersTAG);



				
				$("#titleG").html(L_edit_group)
				$("#formGmenuT,#deleteGroup").show()
				$("#sureDelGroup,#core #savedAt").hide()
				$(".download_group_activity").show()
				$("#name_error").fadeOut()
				$("#saveGroup").fadeIn();
				//singleMask(false)
//				$("#debug").html("check "+php_answer)

			tag_search_reset()
			etag_search_reset()
			}
//			,error: function(D){alert("err")}
		})	 //xhr		
	})
	
	
	///////////////// tag
	//TAGS
	return_tags_ids=function (tagsTarget) {
		/// alert (tagsTarget) gymArea OR usersArea
		$tagsid="";
		$('#'+tagsTarget+' .tag').each(function() {
			$tagsid=$tagsid+","+this.id.replace('tagusr_','').replace('taggym_','').replace('E','');
		})
		$tagsid=$tagsid.substring(1,	$tagsid.length) 
		//alert ($tagsid)
		if (tagsTarget=="gymArea") 	$("#gymsCSV").val($tagsid)
		if (tagsTarget=="usersArea")  $("#usersCSV").val($tagsid)
		
		if (tagsTarget=="insightersArea")  $("#insightesrCSV").val($tagsid)
		if (!$tagsid) $('#'+tagsTarget).html(NOTHING)
	}		
	
	
	highlightON	=function (id) {$('#'+id).addClass("highlight");}
	highlightOFF=function (id) {$('#'+id).removeClass("highlight")}
	highlight	=function (id) {
		setTimeout(function() { highlightON(id) }, 200);
		setTimeout(function() { highlightOFF(id) }, 1200);
	}

	// remove Tag
	$(".tagArea").on('click','.tag a', function(e) {
		e.preventDefault();
		$("#core #savedAt").hide();
		fatherId=$(this).parent()[0].id
		fatherIdA=fatherId.split("_")
		tagsTarget="gymArea"; if (fatherIdA[0]=="tagusr") tagsTarget="usersArea"
		
		
		$("#"+fatherId).remove();
		//$("#tagIN").focus();
		return_tags_ids(tagsTarget);
	})

	// tagin
	$("#tagIN_fake").on('click', function(e) {	$("#tagIN").focus()	})
	$("#tagIN").on('focus', function(e) {
		$("#tagIN_fake").addClass("tagIN_fake_on").removeClass("tagIN_fake_off")
	}).on('blur', function(e) {
		$("#tagIN_fake").addClass("tagIN_fake_off").removeClass("tagIN_fake_on")
	})
	
	// tagin
	$("#EtagIN_fake").on('click', function(e) {	$("#EtagIN").focus()	})
	$("#EtagIN").on('focus', function(e) {
		$("#EtagIN_fake").addClass("EtagIN_fake_on").removeClass("EtagIN_fake_off")
	}).on('blur', function(e) {
		$("#EtagIN_fake").addClass("EtagIN_fake_off").removeClass("EtagIN_fake_on")
	})	
	
	///
	$('#tagInAutoSuggest').html('').hide();
	///
	tag_search_reset=function(){
		$("#tagInAutoSuggest").hide();
		$("#tagIN").val("")
		$("#tagIN_fake").show().addClass("tagIN_fake_off").removeClass("tagIN_fake_on")
		$("#closeTagIn").hide(); 
	}

	///
	etag_search_reset=function(){
		$("#EtagInAutoSuggest").hide();
		$("#EtagIN").val("")
		$("#EtagIN_fake").show().addClass("EtagIN_fake_off").removeClass("EtagIN_fake_on")
		$("#EcloseTagIn").hide(); 
	}

	var xhrSearch;
	$("#tagIN").on('keyup', function(e) {		
		
		if ((e.keyCode=="38")||(e.keyCode=="40")||(e.keyCode=="36")||(e.keyCode=="35")||(e.keyCode=="16")||(e.keyCode=="37")||(e.keyCode=="39")) return;	//(e.keyCode=="8")||		||(e.keyCode=="46")

		$T=ltrim (	$(this).val());
		$T=$T.replace(/ +(?= )/g,'') // spaces
		if ($T.substring(0,1)=="'") $T=$T.substring(1,	$T.length) ;	// bastard apice
		$T=$T.replace(/\'\'/g,'')
		
		$(this).focus().val($T)
		$T=trim($T);
		if($T) 	{
			$('#tagInAutoSuggest').html('<div class="loading"></div>').show();
			$("#tagIN_fake").hide();$("#closeTagIn").show(); 
			
			if(xhrSearch && xhrSearch.readystate != 4){xhrSearch.abort();}
			
			xhrSearch=$.ajax({
				type: "GET", url: "/_m/groups2.0/ajax.tags.php",data: "q="+$T+"&action=search&gymsCSV="+$("#gymsCSV").val()+"&usersCSV="+$("#usersCSV").val(),cache: false,dataType: 'html', //idgr="+$("#idg").val()
				success: function(php_answer){
					resp=php_answer.split("|-|");
					
					if ((resp[0])=="false"){
						//alert ("FALSE "+php_answer)
					}else{
						$('#tagInAutoSuggest').html(resp[1]);//Slert ("OK "+resp[1]);
					}
					$("#debug").html(resp[3])
				}
				//,error: function(php_answer){alert ("Little error")}
			})			

		}else{
			$("#tagIN_fake").show();
			$("#closeTagIn").hide(); 
			$('#tagInAutoSuggest').html('').hide();
		}
	});

	$("#tagInAutoSuggest").on('click', '.tag', function(e) {
		$("#core #savedAt").hide();
		id=this.id.replace("tagusr_","").replace("taggym_","")
		if ($(this).hasClass("user") ) 	{
			$area=$("#usersArea")
			$input=$("#usersCSV")
			$("#usersArea .notyet").hide();
		}
		
		if ($(this).hasClass("gym") ) 	{
			$area=$("#gymArea")
			$input=$("#gymsCSV")
			$("#gymArea .notyet").hide();
		}

		if (!$(this).hasClass("inDB") )  {
			if ($area.html()==NOTHING) $area.html("");
			$area.prepend($(this).removeClass("user").removeClass("gym").append("<a href=\"#\">X</a>") )
			highlight(this.id)
			vv=$input.val()
			if (vv) {
				$input.val(id+","+vv	);
			}else { 
				$input.val(id)
			}
			
		}
		else {$(this).remove();highlight(this.id)}
		
		
	})

	$("#closeTagIn").on('click', function(e) {
		e.preventDefault();tag_search_reset()
		$("#tagIN").focus()
	});

	// new group
	$('.new_group').on('click', function(e){e.preventDefault()
		clearTimeout($savedTimeout);
		//alert ($("#core").attr("data-idtrans"))
		// check to do
		tag_search_reset()	
		etag_search_reset()	
		$(".download_group_activity").hide()
		
		$("#formG input,#formG textarea").val("");
		$("#gymArea,#usersArea,#insightersArea").html(NOTHING)
		$("#titleG").html(L_new_group)
		$("#formGmenuT,#deleteGroup,#sureDelGroup,.ERROR_MSG,#core #savedAt").hide()
		
		
		$(".row").removeClass("rowFocus");		
		$("#name").focus();
		

	});
	// FORM
	$("#name").on('keyup', function(e) {
		$("#core #savedAt").hide()
		if ($(this).val().replace(/ /g,'').length>3 ) {
			$("#name_error").fadeOut()
			$("#saveGroup").show()
		}else {
			$("#name_error").show()
			$("#saveGroup").hide()
		}
	});
	$("#description_it").on('keyup', function(e) {$("#core #savedAt").hide();}); 
	
	
	// delete group
	$("#deleteGroup").on('click', function(e) {e.preventDefault()
		$("#core #savedAt").hide();
		$(this).hide();$("#sureDelGroup").show();
	})
	$("#noDelGroup").on('click', function(e) {e.preventDefault()
		$("#core #savedAt").hide();
		$("#sureDelGroup").hide();$("#deleteGroup").show();
	})
	var xhrDelete
	$("#yesDelGroup").on('click', function(e) {e.preventDefault()
		singleMask(true)
		id=$("#idg").val();
	 	if(xhrDelete && xhrDelete.readystate != 4){xhrDelete.abort();}					
		xhrDelete  =$.ajax({
			async: false,
			type: "POST", url: '/_m/groups2.0/groupGet.ajax.php'
			,data: {idg:id, action:"delete"} // $("#idg").val()
			,cache: false,dataType: 'html',
			success: function(phpansw){
				location.reload() 
			}
			//,error: function(D){alert("err")}
		})	 //xhr
	})// delete 
	var xhrSave
	$("#saveGroup").on('click', function(e) {e.preventDefault()
		$(this).hide();$("#core #savedAt").hide()
		// check
		if ($("#name").val().replace(/ /g,'').length>3 ) {
		}else {
			$("#name").focus()
			$("#name_error").show()
			$("#saveGroup").hide()
			return;
		}	
		singleMask(true)
		id=$("#idg").val();
	 	if(xhrSave && xhrSave.readystate != 4){xhrSave.abort();}					
		xhrSave  =$.ajax({
			//async: false,
			type: "POST", url: '/_m/groups2.0/groupGet.ajax.php'
			,data: {
				idg:id, 
				name: $("#name").val(), description_it: $("#description_it").val(), 
				insightersCSV: $("#insightesrCSV").val(),
				usersCSV: $("#usersCSV").val(),
				gymsCSV: $("#gymsCSV").val(), action:"save"
			} // $("#idg").val()
			,cache: false,dataType: 'html',
			success: function(phpansw){
				r=phpansw.split("|-|")
				//console.log(r)
				if (r[4]=="0"){
					singleMask(false)
					$("#saveGroup").after("<div class=\"green\" id=\"savedAt\">"+L_saved+" "+r[1]+ "</div>").show();
					$("#usrC_"+id).html(r[2]).attr("title", "");$("#gymC_"+id).html(r[3]).attr("title", "");$("#tit_"+id).attr("title", "")
					$("#tit_"+id).html($("#name").val())
					$(".nogroup").remove();
					
				}else{
                    
					window.location.href = "/?/groups/"+r[4]+"/"+r[5]
				}
				
				$("#debug").html(phpansw)
			}
			//,error: function(D){alert("err")}
		})	 //xhr
	})// saveGroup 	
	
	
	// activity group
	$(".download_group_activity").on('click', function(e) {e.preventDefault()
		idg=$("#idg").val();
		if (!idg) idg=0
		url="/export/?id="+idg+"&m=download_group_activity"; //&debug=1
		window.open(url, '_blank');
	})
	
	
	///////////////////

	// tagin
	$("#tagIN_fake").on('click', function(e) {	$("#tagIN").focus()	})
	$("#tagIN").on('focus', function(e) {
		$("#tagIN_fake").addClass("tagIN_fake_on").removeClass("tagIN_fake_off")
	}).on('blur', function(e) {
		$("#tagIN_fake").addClass("tagIN_fake_off").removeClass("tagIN_fake_on")
	})
	///
	$('#tagInAutoSuggest, #EtagInAutoSuggest').html('').hide();
	///
	tag_search_reset=function(){
		$("#tagInAutoSuggest").hide();
		$("#tagIN").val("")
		$("#tagIN_fake").show().addClass("tagIN_fake_off").removeClass("tagIN_fake_on")
		$("#closeTagIn").hide(); 
	}

	////////////////////// INSIDERS
	// remove Tag
	$(".EtagArea").on('click','.tag a', function(e) {
		e.preventDefault();
		$("#core #savedAt").hide();
		fatherId=$(this).parent()[0].id
		$("#"+fatherId).remove();
		return_tags_ids("insightersArea");
	})
	
	var ExhrSearch;
	$("#EtagIN").on('keyup', function(e) {		
		
		if ((e.keyCode=="38")||(e.keyCode=="40")||(e.keyCode=="36")||(e.keyCode=="35")||(e.keyCode=="16")||(e.keyCode=="37")||(e.keyCode=="39")) return;	//(e.keyCode=="8")||		||(e.keyCode=="46")

		$T=ltrim (	$(this).val());
		$T=$T.replace(/ +(?= )/g,'') // spaces
		if ($T.substring(0,1)=="'") $T=$T.substring(1,	$T.length) ;	// bastard apice
		$T=$T.replace(/\'\'/g,'')
		
		$(this).focus().val($T)
		$T=trim($T);
		if($T) 	{
			$('#EtagInAutoSuggest').html('<div class="loading"></div>').show();
			$("#EtagIN_fake").hide();$("#EcloseTagIn").show(); 
			
			if(ExhrSearch && ExhrSearch.readystate != 4){ExhrSearch.abort();}
			
			ExhrSearch=$.ajax({
				type: "GET", url: "/_m/groups2.0/ajax.insighter.php",
				data: "q="+$T+"&action=search&insightesrCSV="+$("#insightesrCSV").val(),cache: false,dataType: 'html', //idgr="+$("#idg").val()
				success: function(php_answer){
					resp=php_answer.split("|-|");
					
					if ((resp[0])=="false"){
						//alert ("FALSE "+php_answer)
					}else{
						$('#EtagInAutoSuggest').html(resp[1]);//Slert ("OK "+resp[1]);
					}
					
					$("#debug").html(resp[4]+resp[3])
				}
				//,error: function(php_answer){alert ("Little error")}
			})			

		}else{
			$("#EtagIN_fake").show();
			$("#EcloseTagIn").hide(); 
			$('#EtagInAutoSuggest').html('').hide();
		}
	});

	$("#EtagInAutoSuggest").on('click', '.tag', function(e) {
		$("#core #savedAt").hide();
		id=this.id.replace("Etagusr_","").replace("taggym_","")
		$area=$("#insightersArea")
		$input=$("#insightesrCSV")

		if (!$(this).hasClass("inDB") )  {
			if ($area.html()==NOTHING) $area.html("");
			$area.prepend($(this).removeClass("user").removeClass("gym").append("<a href=\"#\">X</a>") )
			highlight(this.id)
			vv=$input.val()
			if (vv) {
				$input.val(id+","+vv	);
			}else { 
				$input.val(id)
			}
		}else {
			$(this).remove();highlight(this.id)
		}
		$("#insightersArea .notyet").hide();
		
	})

	$("#EcloseTagIn").on('click', function(e) {
		e.preventDefault();etag_search_reset()
		$("#EtagIN").focus()
	});

	
	
	///////////////////////
	// run
	var $savedTimeout;
	$(window).load(function(){
		etag_search_reset(); tag_search_reset()
		if ($("#core").attr("data-idtrans")!="0"){
			
			$("#row"+$("#core").attr("data-idtrans")).click()
			//saved
			if ($("#core").attr("data-tsaved")!="0"){
				$savedTimeout=setTimeout(function() { 
				$("#saveGroup").after("<div class=\"green\" id=\"savedAt\">"+L_saved+" "+$("#core").attr("data-tsaved")+ "</div>").show();
				 }, 1200);
			}
			
		}
		
		//$("#row1").click()
		
		
	});	
	
})