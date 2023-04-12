$(function() {
	$('.dismiss').on('click',function(e){e.preventDefault()
	$(".boxadvice").slideUp();
	});

	/*$('#core').on('click','.operationsLaunch', function (e) {e.preventDefault();
	//$('.operationsLaunch').on('click',function(e){e.preventDefault()
		id=$(this).attr("id").replace("operationsLaunch_","")
		$("#operations_"+id).toggle();
//		$(this).hide()
	})
	
	// copy
	.on('click','.copy', function (e) {e.preventDefault();
	//$(".copy").on("click", function(e) {e.preventDefault()
		idg=$(this).attr("id").replace("copy_","")
		$("#operations_"+id).html('<div class="spin16"></div>');
		$("#mask").show()
		$.ajax({
			type: "POST", url: "/_m/ajax.gymHandler.php"
			,data: {idg:idg,cmd: "copy"} //
			,cache: false,dataType: 'html',
			success: function(php_answer){
				resp=php_answer.split("|-|")
				//$("#debug").html(php_answer)
				if (resp[0]=="true") {
					//alert (resp[1])
					window.location.href = "/?/_msg/copied/"+resp[1]+""
				}else{
					//$("#mask").hide()
				}
				//$("#mask").hide()
			}
		})
	})	
	
//settoff
	.on('click','.setoff', function (e) {e.preventDefault();
	//$(".setoff").on("click", function(e) {e.preventDefault()
		idg=$(this).attr("id").replace("setoff_","")
		$("#operations_"+id).html('<div class="spin16"></div>');
		$("#mask").show()
		$.ajax({
			type: "POST", url: "/_m/ajax.gymHandler.php"
			,data: {idg:idg,cmd: "setoff"} //
			,cache: false,dataType: 'html',
			success: function(php_answer){
				//alert (php_answer)
				resp=php_answer.split("|-|")
//				$("#debug").html(php_answer)
				if (resp[0]=="true") {
					//alert (resp[1])
					window.location.href = "/?/_msg/settedoff/"+resp[1]+""
				}else{
					//$("#mask").hide()
				}
				//$("#mask").hide()
			}
		})
	})	
*/

	
})