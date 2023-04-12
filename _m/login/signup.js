function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}

$(document).ready(function() {
	// SCROLLING
  navigator.sayswho = (function(){
		var N= navigator.appName, ua= navigator.userAgent, tem;
		var M= ua.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);
		if(M && (tem= ua.match(/version\/([\.\d]+)/i))!= null) M[2]= tem[1];
		M= M? [M[1], M[2]]: [N, navigator.appVersion,'-?'];
		return M;
	})();
 
	var headerOffset = jQuery(".main-header").height(),
		blockMenu = jQuery(".block-menu"),
		nameNavigator = navigator.sayswho[0];
 
	if (nameNavigator == "Chrome") {
		var bodyelem = jQuery("body");
	}
 
	else if (nameNavigator == "Firefox") {
		var bodyelem = jQuery("body, html");
	}
 
	else if (nameNavigator == "Safari") {
		var bodyelem = jQuery(document);
	}
 
	else if (nameNavigator == "MSIE") {
		var bodyelem = jQuery(window);
	}	
	jQuery(window).scroll(function () {
		scrollReact();
	});
	
	scrollReact=function(){
		var top = bodyelem.scrollTop()
		//$("#debug").html(top+" ")
		if (top>23 ) {
			$("#menuFixed").addClass("menuFixedMini")
		}else{
			$("#menuFixed").removeClass("menuFixedMini")
		}
	}
	
	//inputf
	var xhr;var xhrsi;
	checkSignUpForm=function(id){
		d= new Array
		d["sendable"]=true;d["error"]="";
		$err=$("#si_error")
		$div=$("#"+id)
		val=$div.val().trim()
		$div.removeClass("redBorder");
		//$status=$("#si_error").attr("data-go")
		
	
		switch (id) {
//			case "firstname":break;
			case "siemail":
				if (!isValidEmailAddress(val) ) {
					d["sendable"]=false;
					d["error"]="L'Email non è valida";
					
					$("#si_error").html(d["error"])
					//if ($err.attr("data-go")!="1") {
						$err.slideDown()
					//	$err.attr("data-go","1")
					//}
					$div.addClass("redBorder");
					return d
				}else{
				  if(xhr && xhr.readystate != 4){xhr.abort();}					
					// aj check email
					$("#inputSiemail .spin16").show();
					xhr  =$.ajax({
						async: false,
						type: "POST", url: '/'+C_DIR+"_m/login/signup.ajax.php"
						,data: {siemail:val,action:"emailcheck"} // 
						,cache: false,dataType: 'html',
						success: function(php_answer){
							$("#debug").html("check "+php_answer)
							r=php_answer.split("|-|")
							var $existEmail=r[0]
							$("#inputSiemail .spin16").hide();
							if ($existEmail=="1") {
								d["sendable"]=false;
								d["error"]="Questa email esiste già";
								
								$("#si_error").html(d["error"]).slideDown()
								$div.addClass("redBorder");
								return d
							}
						}
					})	 //xhr
				}
			break;	

			case "sipwd":
				if ($div.val()!=val.replace (" ","")  ) {
					d["sendable"]=false;
					d["error"]="La password non può contenere spazi";
					
					$("#si_error").html(d["error"]).slideDown()
					$div.addClass("redBorder");
					return d
				}	
				if (val.length <6 ) {
					d["sendable"]=false;
					d["error"]="La password è troppo breve";
					
					$("#si_error").html(d["error"]).slideDown()
					$div.addClass("redBorder");
					return d
				}
			break;			
		}// switch
		if (	val.length <2) {
			d["sendable"]=false;
			d["error"]="Troppo breve ";
				if (id=="siemail") 	d["error"]="Email "+d["error"];
				if (id=="firstname") d["error"]="Nome "+d["error"];
				if (id=="lastname") d["error"]="Cognome "+d["error"];
				
			if (	val.length ==0) {
				d["error"]="Campo mancante";
				if (id=="siemail") d["error"]="Email mancante";
				if (id=="firstname") d["error"]="Nome mancante";
				if (id=="lastname") d["error"]="Cognome mancante";
			}
			
			$("#si_error").html(d["error"]).slideDown()
			$div.addClass("redBorder");

			
			return d
		}
		if (	val.length >40) {
			d["sendable"]=false;
			d["error"]="Troppo lungo";
			if (id=="siemail") d["error"]="Email "+d["error"];
			if (id=="firstname") d["error"]="Nome "+d["error"];
			if (id=="lastname") d["error"]="Cognome "+d["error"];
			
			$("#si_error").html(d["error"]).slideDown();
			$div.addClass("redBorder");
			
			return d
		}

		//true
		$("#debug").html ("")
		if ($("#loadingBar").attr("data-on")!="1" && d["sendable"] ) {$err.slideUp();$("#debug").html ("up "+d["error"])}
		//	$err.attr("data-go","0")
		return d;
	}

	
	//////////////
	$(".inputf_fake").click(function(event){
		id=this.id.replace("_textover", "") ;
//		$("#debug").html(id)
		$("#"+id).focus();	
	});
	
	$(".inputf").keyup(function(e){
		id=this.id+"_textover" ;
		//if ($(this).val()!="") 
		checkSignUpForm (this.id)

		if ($(this).val().replace(/\s/g, "")!=""){
			$("#"+id).hide();
		}else{
			$("#"+id).show();
		}
		//if (e.keyCode==13) {;$("#form_login_submit").click();}
	}).focus(
	function(event){	
		$(this).val(	$(this).val().trim())
		if ($(this).val().trim()			) checkSignUpForm (this.id.replace("_textover", ""))
	}).blur(function(event){
		if ($("#loadingBar").attr("data-on")!="1") $("#si_error").slideUp();
		$(this).val(	$(this).val().trim())
		//checkSignUpForm (this.id.replace("_textover", ""))
	})
	
	
	
	////////////// signup 
	$("#signup").click(function(event){
		$(this).hide()
		$("#loadingBar").show().attr("data-on","1");
		$sipwdC=checkSignUpForm("sipwd")
		$siemailC=checkSignUpForm("siemail")
		$lastnameC=checkSignUpForm("lastname")
		$firstnameC=checkSignUpForm("firstname")
		
		if (!$sipwdC["sendable"] ||!$siemailC["sendable"] ||!$lastnameC["sendable"] ||!$firstnameC["sendable"] ){
			focusDone=false;
			if (!$firstnameC["sendable"] && !focusDone) {$("#firstname").focus();focusDone=true;}
			if (!$lastnameC["sendable"]&& !focusDone) {$("#lastname").focus();focusDone=true;}
			if (!$siemailC["sendable"]&& !focusDone) {$("#siemail").focus();focusDone=true;}
			if (!$sipwdC["sendable"]&& !focusDone) {$("#sipwd").focus();focusDone=true;}
			
			$("#si_error").slideDown()
			$(this).show()
			$("#loadingBar").hide().attr("data-on","0");
			return;
		}
		////////////////////////////////////////////alert ("run")
		
			datasi={
			firstname:$("#firstname").val()
			,lastname:$("#lastname").val()
			,siemail:$("#siemail").val()
			,sipwd:$("#sipwd").val()
			,action:"signup"}
			
			///aj
			 if(xhrsi && xhrsi.readystate != 4){xhrsi.abort();}
			xhrsi  =$.ajax({
				async: false,
				type: "POST", url: '/'+C_DIR+"_m/login/signup.ajax.php"
				,data: datasi // 
				,cache: false,dataType: 'html',
				success: function(php_answer){
					R=php_answer.split("|-|")
					if (R[0]=="true"){
						$(".signupbox").html("<span class=\"content\">"+R[2]+"</span>")
						$(".signupbox").addClass("emailgobox").removeClass(".signupbox")
					}else{
						//alert (R[1])
						$("#signup").show();$("#loadingBar").hide().attr("data-on","0"); //debug
					}
					
					
					//$("#signup").show();$("#loadingBar").hide().attr("data-on","0"); //debug
					$("#debug").html(php_answer)
				}
			})
			
			
	});

	// run
	$(window).load(function(){
		scrollReact()
		/*$("#firstname").val("Arnaldo")
		$("#lastname").val("Guido")
		$("#siemail").val("arnaldoguido@gmail.com")
		$("#sipwd").val("arnaldo")
		$(".inputf_fake").hide()
		*/
	});
	
}); 