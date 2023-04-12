$(document).ready(function() {
//	$("#total_mask").hide();
	$("#form_login_user").focus();
	
	if ($("#form_login_user").val().replace(/\s/g, "")!="")	$("#form_login_user_textover").hide();
	if ($("#form_login_password").val().replace(/\s/g, "")!="")	$("#form_login_password_textover").hide();
	
	////////////
	$("#form_login_user_textover").click(function(event){$("#form_login_user").focus();	});	
	$("#form_login_password_textover").click(function(event){$("#form_login_password").focus();	});
	$("#form_login_user").keyup(function(e){
		//if ($(this).val()!="") {
		if ($(this).val().replace(/\s/g, "")!=""){
			$("#form_login_user_textover").hide();
			$(".ERROR_MSG").fadeOut(500);
		}else{
			$("#form_login_user_textover").show();
		}
		if (e.keyCode==13) {;$("#form_login_submit").click();}
		
	}).focus(function(event){	
		$(this).val(	$(this).val().trim()		)
		$(".inputf").removeClass("redBorder").val("");
		$(".inputf_fake").show()
	
	
	}).blur(function(event){	$(this).val(	$(this).val().trim()	)
	})
	$("#form_login_password").keyup(function(e){
		if ($(this).val().replace(/\s/g, "")!=""){
			$("#form_login_password_textover").hide();
			$(".ERROR_MSG").fadeOut(500);
		}else{
			$("#form_login_password_textover").show();
		}
		if (e.keyCode==13) {;$("#form_login_submit").click();}
	});	
	//
	$("#form_login_submit").click(function(event){
		if (
		($("#form_login_user").val().trim()	) &&
		($("#form_login_password").val().trim()	)
		){
			$("#form_login").submit();
		}else{
			$("#form_login_user").focus();
		}
	});	
	
}); //$(document).ready(function() {