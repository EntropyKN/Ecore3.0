$(document).ready(function() {


	//resendSignupEmail
	var xhr
	$("#resendSignupEmail").click(function(event){
		
		$("#resendSignupEmail").after('<span id="sending" class="red">invio in corso...</span>')
		$("#resendSignupEmail").remove();
		if(xhr && xhr.readystate != 4){xhr.abort();}					
		// aj check email
//		$("#inputSiemail .spin16").show();
		xhr  =$.ajax({
			async: false,
			type: "POST", url: '/'+C_DIR+"_m/login/resendSignupEmail.ajax.php"
			,data: {action:"resendSignUpEmailSessionData"} // 
			,cache: false,dataType: 'html',
			success: function(php_answer){
				$("#debug").html(" "+php_answer)
				r=php_answer.split("|-|")
				//$("#inputSiemail .spin16").hide();
				$("#resendSignupEmail").hide();
				$("body #sending").html("<strong>Messaggio inviato! Corri a leggere la posta</strong>")

			}
		})	 //xhr
	})
});