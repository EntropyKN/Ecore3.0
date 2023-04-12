$(function() {
	// pagination
	$('#core').on('click','.nexpage', function (e) {e.preventDefault();
		if (	$(this).attr("data-loading")=="1"		) return;
		$(this).attr("data-loading", "1");
		$scope=$(this).attr("data-scope");

		$page= parseInt( $(this).attr("data-page"));
		$nextpage= parseInt( $page)+1;
		$(this).hide()
		$("#page_"+$scope+"_"+$page+" .spin16").show()
		$("#page_"+$scope+"_"+$page+" .rightLink").hide()
		$.ajax({

			type: "POST", url: "/_m/ajax.gameBrowse.php"
			,data: {page:$nextpage,scope:$scope} // 
			,cache: false,dataType: 'html',
			success: function(php_answer){
				resp=php_answer.split("|-|")

				if (resp[0]=="true") {
					$("#page_"+$scope+"_"+$page).after(resp[1]);
					$("#page_"+$scope+"_"+$page).remove();
				}
			},
			error: function(php_answer){
			}
			
			
		})		

	})	
	.on('click','.moremt', function (e) {e.preventDefault();
		gid=this.id
		opid=gid.replace("moremt", "moremgroup");
		//$(this).hide()
		$("#"+opid).toggle()
		if ($(this).hasClass("moreon")){
			$(this).removeClass("moreon")
		}else{
			$(this).addClass("moreon")
		}
/*		$("#"+opid).toggle('fast', function() {
			if($("#"+opid).is(':hidden')) { 
				$("#"+gid).addClass("moreon")
				$("#debug").text('This element is hidden.');
			} else {
				$("#"+gid).removeClass("moreon ")
				$("#debug").text('This element is VISIBLE.');
			}
		});
*/

	})	
	
	
	
})