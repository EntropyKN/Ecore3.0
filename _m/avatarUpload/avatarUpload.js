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
    ////
    $("#load1").on('click',function(){$("#attachmentInput1").val("").click()});
    $("#load2").on('click',function(){$("#attachmentInput2").val("").click()});

    var showIssue=function(str){
        $("#issue span").html(str);
        $("#issue").slideDown().promise().always(function(){
            scrollDown()
        });
    }
    $("#closeAdvice").on("click", function() {
        $("#issue").slideUp();
    });
    var scrollDown=function(){
        $("html, body").animate({ scrollTop: $(document).height()-$(window).height() })
    }
    var xhr  
	$(".attachmentInputC").on("change", function() {
		$("#mask").show()
        $("#issue").hide();
        if (typeof this.files !== 'undefined') {
            var pesoKB=parseInt(this.files[0].size/1024) ;
            if(pesoKB > 750){ //1mb/5=200kb  1048576/5
               showIssue(L_the_file_size_is_too_large+": "+pesoKB+" Kb");  // 874 k  894029
               $("#mask").hide()
               return;
            }
        }
		var file_data = $(this).prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data)
        if (this.id=="attachmentInput1")    form_data.append('cmd', "wait")
        if (this.id=="attachmentInput2")    form_data.append('cmd', "talk")
        form_data.append('code', $("#core").attr("data-c") ) 
        
        if(xhr && xhr.readystate != 4){
            xhr.abort();
        }
		xhr  =$.ajax({
                type: "POST", url: '/_m/avatarUpload/avatarUpload.ajax.php',
                dataType: 'json',  
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
            success: function(obj){ 
                console.log (obj)
                if (obj.response) {
                    if (obj.cmd=="wait") {
                        //fileNamePathR
                        $("#avatarSprite1").attr("style", 'background: url(\''+obj.fileNamePathR+'\') left center;background-size: 3200px 383.36px;')
                        $("#load1").hide(); $("#done1").show();
                        $("#issueC").insertAfter( $( "#load2" ) );
                        scrollDown()
                        
                    }
                    if (obj.cmd=="talk") {
                        $("#avatarSprite2").attr("style", 'background: url(\''+obj.fileNamePathR+'\') left center;background-size: 3200px 383.36px;')
                        $("#load2").hide(); $("#done2").show();
                        $("#avatarName").focus();
                        scrollDown()
                    }
                }else{
                    showIssue(obj.reason)
                    
                }
                $("#mask").hide()
                $("#attachmentInput").val("");
			}
            
            
			,error: function(){      
                showIssue("a little error occurred... code:XmrATT")  ;
                $("#mask").hide()   }
		})	 //xhr      

	});

    ///$("#done2").show();$("#avatarName").val("grace")
    function onlyLetters(str) { // accept apex ' as well 
        str=str.replace("'","    ")
        var r=/^[A-Za-z\s]*$/.test(str);
        str=str.replace("    ","'")
      return r
    }
    
    function titleCase(str) {
       var splitStr = str.toLowerCase().split(' ');
       for (var i = 0; i < splitStr.length; i++) {
           splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
       }
       return splitStr.join(' '); 
    }

    $("#saveAll").click(function(){
        var passTest=true;
        var avatarName=$.trim(		$("#avatarName").val()	);avatarName = avatarName.replace(/ +/g," ");
        avatarName=titleCase(avatarName)
        $("#avatarName").val(avatarName);
        var sex=$('input[name=sex]:checked').val()
        var words = avatarName.split(' ');
        console.log (words.length)
        if (!avatarName  || avatarName.length<5 ||  !onlyLetters(avatarName)   || words.length>3  ) {
            passTest=false;
        }
        if (!passTest) {
          $("#avatarName").focus().shake(100,10,3);
          return;
        }
        if(xhr && xhr.readystate != 4){ xhr.abort();}
        $("#mask").show();
        $("#saveAll").hide()
        
		xhr  =$.ajax({
			//async: false,
			type: "POST", url: '/_m/avatarUpload/avatarUpload.ajax.php'
			,data: {code:$("#core").attr("data-c"), cmd:"saveAll", avatarName:avatarName,sex:sex} ,cache: false,dataType: 'json',
			success: function(obj){
                console.log (obj)
                if (obj.response) {
                    $("#explain, #done0, #done1,#done2").hide(); 
                    $("#avatarSprite2").attr("style", 'background: url(\''+obj.f2f+'\') left center;background-size: 3200px 383.36px;')
                    $("#b19").show();$("#b17").hide();
                    $("#fakePlayer2").insertAfter( $( "#finalSentence" ) );                      
                    $("#doneFinal").show();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    $("#explain, #done0, #done1,#done2").remove(); 
                }else{
                    $("#mask").hide();$("#saveAll").show()
                    if (obj.reason=="name")   {
                      $("#avatarName").focus().shake(100,10,3);
                      return;
                    }else{
                        alert (obj.reason)
                         return;
                    }
                }
                $("#mask").hide();$("#saveAll").show()
			}

			,error: function(){      
                alert("a little error occurred... code:XmrSIG")  ;
                $("#mask").hide();$("#saveAll").show()  }
		})	 //xhr  
        ///
        
    });   //x
    

                      /*
 */

	
})