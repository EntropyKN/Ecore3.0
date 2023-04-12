var spin64='<div id="spin64" class="spin64"></div>'

$(function() {
    jQuery.fn.shake = function(interval,distance,times){
       interval = typeof interval == "undefined" ? 100 : interval;
       distance = typeof distance == "undefined" ? 10 : distance;
       times = typeof times == "undefined" ? 3 : times;
       var jTarget = $(this);
       jTarget.css('position','relative');
       for(var iter=0;iter<(times+1);iter++){
          jTarget.animate({ left: ((iter%2==0 ? distance : distance*-1))}, interval);
       }
       return jTarget.animate({ left: 0},interval);
    }

    const subsetData= {"t1": "all", "t2": "mine", "t3": "recent", "t4": "publicWannabe"};
	var xhr;
    $("#cropArea").hide();
    var loadItems=function (mode, page, Q){		
        //data-subset: all mine recent

        if (!mode) mode=$(   $("#dataH").attr("data-subset")   );

        if (    !$.inArray (mode,subsetData)    )  mode="all"

        if (!page) page=1;
        if (!Q) Q=false;
        var dataSend={mode:mode, page:page, Q:Q, ts:new Date().getTime()}

        if(xhr && xhr.readystate != 4){
            xhr.abort();
        }
        $("#upContainerL").append(spin64)
		xhr  =$.ajax({
			//async: false,
			type: "POST", url: '/_m/scenarios/getItems.ajax.php'
			,data: dataSend ,
            cache: false,dataType: 'json',
			success: function(obj){ 
                
                if (obj.response) {
                   
                    console.log (obj)
                    var $htm=""
                    if (obj.recordsFound>0) {
                        $.each( obj.data, function( key, d ) {
                            //alert(d.id)
                            $htm=$htm
                            +'<div id="s_'+d.id+'" data-json=\''+JSON.stringify(d)+'\'  class="upContainerBox">'
                            +'<img class="upContainerBoxImg" src="/data/scenarios/'+d.id+'_640.jpg" alt="">'
                            +'<div class="upContainerBoxLegend">'+d.name+'</div>'
                            +'</div>';
                        });
                       if (page>1){
                            $("#upContainerL").append($htm)
                           $("#upContainerL").append(spin64).attr("data-page",page).attr("data-nextPage",  obj.nextPage)  
                        }else{
                            $("#upContainerL").html($htm)
                            $("#upContainerL").append(spin64).attr("data-page",page).attr("data-nextPage",  obj.nextPage)  
                        }

                        if (page==1) $('#s_'+obj.data[0].id).click()
                    }else{
                         if (page==1) {
                            $("#upContainerL").html("<div id=\"noresult\">"+L_no_results+" :-(</div>")
                            $("#Q").focus();
                        }
                    }
                }else{
                   alert("a little error occurred: "+obj.reason)
                }
                 $("#upContainerL .spin64").remove();

			}
//			,error: function(D){alert("err")}
		})	 //xhr
        
    }
    // scroll and load
     $('#upContainerL').on('scroll', function() {
        //console.log(  parseFloat($(this).scrollTop()) + parseFloat($(this).innerHeight())+" --- "+ parseFloat($(this)[0].scrollHeight) );
        
        if( parseFloat($(this).scrollTop()) + parseFloat($(this).innerHeight()) >= parseFloat($(this)[0].scrollHeight)-10) {
            //alert ("scroll")
            var nextPage= parseInt($('#upContainerL').attr("data-nextPage"));
            var page=parseInt( $('#upContainerL').attr("data-page"))+1;
            if (nextPage=="1") loadItems("all",page, false);
        }
    })  
    
    //SELECT SCENARIO
	$('#core').on('click','.upContainerBox', function (e) {e.preventDefault();
        $(".upContainerBox").removeClass("upContainerBoxActive")
        $(this).addClass("upContainerBoxActive")
        var div=this.id
        var DS = $.parseJSON($("#"+div).attr("data-json"))
        //console.log (DS)
        
        $("#scenarioImg").attr("src", "/data/scenarios/"+DS.id+"_640.jpg")
        $("#sName").text(DS.name)
        $("#sWaiting").hide()
        if (DS.propertyUid=="0") {
            $("#sPublic").show();$("#sPrivate").hide()             
        }else {

            $("#sPublic").hide();$("#sPrivate").show() 
            if (DS.waitS=="1") $("#sWaiting").show()
        }
        if (DS.creatorName) {
            $("#createByC").text(DS.creatorName)
            $("#createBy, #createByC").show();
            
        }else{
            $("#createBy, #createByC").hide();
        }
        $("#dashDelete,#sDelete").hide();
        $("#sDelete").attr("data-ids",0);
        if (DS.del=="1") {
            $("#sDelete").attr("data-ids",DS.id);
            $("#dashDelete,#sDelete").show();
        }
        $("#Sago").text(DS.creationAgo)
        
       if (DS.used=="0") $("#SusedN").text("Zero")
        else $("#SusedN").text(DS.used)
        
        $("#fakePlayer").attr("data-idS",DS.id)
        var currentScenario=$("#dataH").attr("data-currentScenario");
        $("#done").hide();
        if (    $("#dataH").attr("data-subset")=="publicWannabe"){
            $("#saveInGame").hide()
            $("#alreadyUsed").hide()
            $("#switch2public").show()
            
        }else{
            $("#switch2public").hide()
            if (currentScenario==DS.id){
                // è attualmente utilizzato
                $("#saveInGame").hide()
                $("#alreadyUsed").show()
            }else{
                $("#saveInGame").show()
                $("#alreadyUsed").hide()
            }
        }
        $("#sContent").show();
 
	}) 
    // delete
     var deleteScenario =function(ids){
        var checkstr =  confirm(L_are_you_sure_to_delete_this);
        if(checkstr == true){
 
         if(xhr && xhr.readystate != 4){
            xhr.abort();
        }
           $("#mask").show()
            xhr  =$.ajax({
                //async: false,
                type: "POST", url: '/_m/scenarios/scenarioHandle.ajax.php'
                ,data: {action:"deleteScenario",scenario_id:ids} ,cache: false,dataType: 'json',
                success: function(obj){ 
                    console.log (obj)
                    if (obj.response) {                              
                        loadItems(    $("#dataH").attr("data-subset")    )
                    }else{
                        alert(""+obj.reason) ///
                    }
                    
                    $("#mask").hide()
                }


                ,error: function(){      
                    alert("FAIL  a little error occurred... code:XmrDES")  ;
                    $("#mask").hide()   }
            })	 //xhr 
 
 
        }else{
            return false;
        }       
     }
     
     $('#sDelete').on('click', function (e) {e.preventDefault();
        var ids=$(this).attr("data-ids")
        if (!ids || ids=="0") return;
        deleteScenario(ids)   
     }) 
     

     
    // save IN GAME
    $('#saveInGame').on('click', function (e) {e.preventDefault();

        if(xhr && xhr.readystate != 4){
            xhr.abort();
        }
       $("#mask").show()
		xhr  =$.ajax({
			//async: false,
			type: "POST", url: '/_m/scenarios/scenarioHandle.ajax.php'
			,data: {action:"saveInGame",
            scenario_id:$("#fakePlayer").attr("data-idS"), url:window.location.href} ,cache: false,dataType: 'json',
			success: function(obj){ 
                
                if (obj.response) {
                    $("#dataH").attr("data-currentScenario", obj.scenario_id)
                    $("#saveInGame").hide()
                    $("#alreadyUsed").show()
                     // console.log (obj)      
                }else{
                    alert("a little error occurred: "+obj.reason)
                    //console.log (obj)  
                }
                $("#mask").hide() 

			}
            
            
			,error: function(){      
                alert("a little error occurred... code:XmrSIG")  ;
                $("#mask").hide()   }
		})	 //xhr        
        
    })
    
    ////////////////////////// SEARCH
	function headSearch (q){
        $("#hd_searchCont").prepend('<div class="loading_simple" id="searchHeadLoading"></div> ')
        loadItems($("#dataH").attr("data-subset"), 1, q)
	}    
	$("#QFake,#headSearchI").on('click',function(e){ e.preventDefault();$("#Q").focus(); });
	

	var searchtimeout
	$("#Q").on('input',function(){
		var actual_term=$.trim(		$(this).val().toLowerCase()		);actual_term = actual_term.replace(/ +/g," ");
		
		if (typeof actual_term !== 'undefined' && actual_term!="" ) {
			$("#QFake").hide();
			clearTimeout(searchtimeout);
			searchtimeout = setTimeout(function(){
				headSearch(actual_term)
			}, 800);
		}else{
			$("#QFake").show(200);
			clearTimeout(searchtimeout);
			searchtimeout = setTimeout(function(){
				loadItems($("#dataH").attr("data-subset"));
			}, 800);
            
		}
	})
	.on('focus',function(){
		var actual_term=$.trim(		$(this).val().toLowerCase()		);actual_term = actual_term.replace(/ +/g," ");
		$("#hd_searchCont").removeClass("opacity70")
		//$("#debug").html(actual_term)
		if (typeof actual_term !== 'undefined' && actual_term!="") {
			$("#QFake").hide();
            //$("#hd_searchRes_box_cont").show()
			
		}else{
			$("#QFake").show(200);
            //$("#hd_searchRes_box_cont").hide();
            $("#core #searchHeadLoading").remove();
		}
	})
	.on('blur',function(){
		$("#hd_searchCont").addClass("opacity70")
	})
	
    // TABs
    
    $(".tTab").on('click',function(){
        if (this.id=="t5"){
            cropUpload();
        }else{
            $(".tTab").removeClass("tTabActive");$(this).addClass("tTabActive");
            $("#cropArea").hide();$("#upContainerLL,#upContainerR").show();
           if ($("#dataH").attr("data-subset")!=subsetData[ this.id ]    && $.inArray (subsetData[ this.id ],subsetData)          ) {
                
                $("#dataH").attr("data-subset", subsetData[ this.id ])
                $("#Q").val("").focus(); $("#QFake").show();
                loadItems(    subsetData[ this.id ]      )

           }
       }
    });

    $("#switch2public").on('click',function(){ 
        var currentScenario=$("#fakePlayer").attr("data-idS");$("#dataH").attr("data-currentScenario");
        $("#mask").show()
        $(this).hide();

        
		xhr  =$.ajax({
			//async: false,
			type: "POST", url: '/_m/scenarios/scenarioHandle.ajax.php'
			,data: {action:"switch2public",scenario_id:currentScenario} ,cache: false,dataType: 'json',
			success: function(obj){ 
                if (obj.response) {
                    //console.log (obj)
                    $("#done").show();
                    $("#upContainerL #s_"+obj.scenario_id).remove();
                }else{
                    alert("a little error occurred: "+obj.reason)
                    console.log (obj)  
                }
                $("#mask").hide()
			}
			,error: function(){      
                alert("a little error occurred... code:XmrSIGpublic")  ;
                $("#mask").hide()   
            }
		})	 //xhr           
        
    });//2public


/// new scenario

        

    var cropUpload=function(){
       //$("#upContainerLL,#upContainerR").hide(); $("#cropArea").show();//debug
        $("#cropbox").attr("src","");
        if ($('#cropbox').data('Jcrop')) {
            $('#cropbox').data('Jcrop').destroy();
            $('#cropbox').removeAttr('style');
        }
        $("#attachmentInput,#scenariosTitle").val("").click();
        $("#cropDone").hide();  $("#cropNsave").show();
        
    }

    var size;var data2crop;var timeouturl
    $("#cropNsave").click(function(){
        var scenariosName=$.trim(		$("#scenariosTitle").val()	);scenariosName = scenariosName.replace(/ +/g," ");
        if (!scenariosName || scenariosName==scenariosName.toUpperCase()  || scenariosName.length<5      ) {
            $("#scenariosTitle").focus().shake(100,10,3);
            return;
        }
        var imgg=$("#cropbox").attr('src')
        if (typeof size !== 'undefined') 
             data2crop={cmd:'saveNcrop',x:size.x,y:size.y,w:size.w,h:size.h,img:imgg, name:scenariosName, askPublic:$("#askPublic").is(':checked')}
        else
             data2crop={cmd:'save',img:imgg,name:scenariosName,askPublic:$("#askPublic").is(':checked')}
        console.log(data2crop)

        ///
        if(xhr && xhr.readystate != 4){ xhr.abort();}
        $("#mask").show();$("#cropNsave").hide()
		xhr  =$.ajax({
			//async: false,
			type: "POST", url: '/_m/scenarios/newScenarioHandle.ajax.php'
			,data: data2crop ,cache: false,dataType: 'json',
			success: function(obj){                 
                if (obj.response) {
                    //if (obj.cmd=="save"){console.log (obj);$("#mask").hide();$("#cropNsave").show();return;} //debug
                    //console.log (obj)  
                    // restore in t3=recent
                    $("#cropNsave").hide()
                    $("#cropDone").show()
                    clearTimeout(searchtimeout);var timeouturl = setTimeout(function(){
                    $("#mask").hide();
                    loadItems("recent");
                    $(".tTab").removeClass("tTabActive");
                    $("#t3").addClass("tTabActive");$("#cropArea").hide();$("#upContainerLL,#upContainerR").show();
                    
                    
                    }, 1000);// back to last used
                      
                }else{
                    alert(""+obj.reason)
                    console.log (obj)
                     $("#mask").hide();$("#cropNsave").show()
                }
			}

			,error: function(){      
                alert("a little error occurred... code:XmrSIG")  ;
                $("#mask").hide()   }
		})	 //xhr  
        ///
        
    });   //cropNsave
	$("#attachmentInput").on("change", function() {
		$("#mask").show()
        if (typeof this.files !== 'undefined') {
            if(this.files[0].size > (18*1048576)){ //1.048.576 4194304
               alert("File must be less than 18 megabytes");
               return;
            }
        }
        
		var file_data = $(this).prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data)
        form_data.append('cmd', "firstLoad")
		//gameId:D["gameId"], state:state

        if(xhr && xhr.readystate != 4){
            xhr.abort();
        }
		xhr  =$.ajax({
                type: "POST", url: '/_m/scenarios/newScenarioHandle.ajax.php',
                dataType: 'json',  
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,

			success: function(obj){ 
                
                if (obj.response) {
                    console.log (obj)
                    $("#cropbox").attr("src", obj.fileNamePathR);
                    
                    if (!(obj.width==1024 && obj.height==576)){ 
                        $("#cropLegend").show();
                        $("#upContainerLL,#upContainerR").hide();
                        /////////////////////////////////////////           
                        var $ratioRedim=obj.width/760; // 760 è la dimensione di visualizzazione nel web                   

                        var JCopt={
                            minSize: [1024/$ratioRedim, 576/$ratioRedim],
                            //maxSize: ,
                          aspectRatio: 16/9,
                          setSelect: [0,0,1024/$ratioRedim,576/$ratioRedim],
                          onSelect: function(c){
                           size = {x:c.x*$ratioRedim,y:c.y*$ratioRedim,
                           w:c.w*$ratioRedim,h:c.h*$ratioRedim
                          // w:1024,h:576
                           }    
                           //$("#crop").css("visibility", "visible");     
                          }
                        }
                        $('#cropbox').Jcrop(JCopt);
                        
                    }else{
                        $("#cropLegend").hide();
                    } 
                    
                    
                    /////////////////////////////////////////
                    $(".tTab").removeClass("tTabActive");$("#t5").addClass("tTabActive");
                    $("#cropArea").show();
                    $("#upContainerLL,#upContainerR").hide();
                    $("#scenariosTitle").focus();

/*
if ($('#target').data('Jcrop')) {
    $('#target').data('Jcrop').destroy();
}
*/
                }else{
                    alert(""+obj.reason)
                    console.log (obj)  
                }
                $("#mask").hide()
                $("#attachmentInput").val("");
			}
            
            
			,error: function(){      
                alert("a little error occurred... code:XmrATT")  ;
                $("#mask").hide()   }
		})	 //xhr      

	});





        
	//######################## run
	loadItems("all");
    //$("#t5").click();
	
})