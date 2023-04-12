$(function() {
	var deb=$("#debug")
	$('#optionsGroupShow').click(function(e){e.preventDefault()
		$('.optionsGroup').slideDown();
		$(this).hide()
//		$("#valid_until").focus()
	})
	$('#title').keyup(function() {
		if ($("#title").val().trim()) {
			$("#nowEditing").text($("#title").val().trim())
		}else{
			$("#nowEditing").html("<strong>...</strong>")
		}
	})	
	$('input, textarea').keypress(function() {
		$(this).removeClass("notCorrect"); $("#errorList").fadeOut()
	})		
	$('.addGymGoal').on('click',function(e){e.preventDefault()
		$idA=this.id.split("_") 
		$id="L_Goal_"+(parseInt($idA[2])+1)
		$("#debug").html($id)
		$("#"+$id).show();$(this).hide()
	})
	$('.addUsrGoal').on('click',function(e){e.preventDefault()
		$ida=this.id.replace("addgu_usr_goal","") //addgu_usr_goal1 -> L_usr_goal2
		$id="L_usr_goal"+(parseInt($ida)+1)
		$("#debug").html($id)
		$("#"+$id).show();$(this).hide()
	})	
	$('.addBotGoal').on('click',function(e){e.preventDefault()
		$ida=this.id.replace("addgb_bot_goal","") //addgu_usr_goal1 -> L_usr_goal2
		$id="L_bot_goal"+(parseInt($ida)+1)
		$("#debug").html($id)
		$("#"+$id).show();$(this).hide()
	})	
	$('#balloonFont').on('change',function(){
        var changeDemoClass=$('option:selected', this).attr('data-c') ;
        $("#balloon").removeClass()
        if (changeDemoClass!="default")  $("#balloon").addClass(changeDemoClass)

	})
	
	/*$('#steps').on('change',function(e){
		if ($(this).val()<$("#stepsBefore").val() ) {
//			alert ("Diminuendo il numero di step (da "+$("#stepsBefore").val()+" a "+$(this).val()+") potresti perdere parte del tuo lavoro");
			alert ("Reducing the steps' number (from "+$("#stepsBefore").val()+" to "+$(this).val()+") \nyou could lose part of your job");
		}
		structureView($("#structure").val())
	})	
	$('#structure').on('change',function(e){
		structureView ($(this).val())
		if ($("#stepsBefore").val() ) {
//			alert ("Diminuendo il numero di step (da "+$("#stepsBefore").val()+" a "+$(this).val()+") potresti perdere parte del tuo lavoro");
			alert ("Changing struture model\nyou could lose part of your job");
		}
				
	})	
	
	$('#usr_female_avatar_id,#usr_male_avatar_id').on('change',function(e){
	
		if (this.id=="usr_female_avatar_id") $target=$("#avatarcanvasF");
		if (this.id=="usr_male_avatar_id") $target=$("#avatarcanvasM");
	
		var avatar_id_send=$(this).val(); //
		var currentClass=$target.attr("class");
		var currentAvatarId=$target.attr("data-currentAvatar");
		
		$target
			.attr("class", 		currentClass.replace("avatar_"+currentAvatarId, "avatar_"+avatar_id_send)			)
			.attr("data-currentAvatar", avatar_id_send);		
		
	})	
	
	$('#valid_forever').on('click',function(e){e.preventDefault()
		$("#valid_until").val("");		$('#valid_forever').fadeOut();
	})

	$("#core").on('click','#valid_until', function(e){
		$('#valid_forever').fadeIn();
	})	.on('blur','#valid_until', function(e){
		if (!$("#valid_until").val())		$('#valid_forever').fadeOut();
		else $('#valid_forever').fadeIn();
	})		
	*/
	

	
	var checkFields=function (){
		$("#errorList").fadeOut()
		var debugP="";
		var data = {}; data["gameId"] = $("#core").attr("data-gameId")
		var $checkAll=true;var $noFieldsHtm="";
		for (var Q = 0; Q < F1.length; Q++) {
			var $field=$("#"+F1[Q])
            console.log(F1[Q])
			var $v=$field.val().trim();
            var $add=true;
			if (F1f[Q]=="input" || F1f[Q]=="area" ){
				if (!$v) $add=false;
			}else{
				if (!$v || $v=="0") $add=false
			}
			// free
			if (  F1[Q]=="Goal_2" ||F1[Q]=="Goal_3" ||F1[Q]=="Goal_4" ||F1[Q]=="Goal_5" || F1[Q]=="usr_goal2" || 
			F1[Q]=="usr_goal3" || F1[Q]=="bot_goal2" || F1[Q]=="bot_goal3"	
			|| F1[Q]=="stepsBefore" || F1[Q]=="structureBefore"
            || F1[Q]=="dontShowDebriefScore"
			|| F1[Q]=="valid_until" || F1[Q]=="estimated_duration" || F1[Q]=="competence_target"|| F1[Q]=="difficulty_level"
            ) $add=true;
			 
                //if (  F1[Q]=="valid_until") alert ($v)
			 
			if (  F1[Q]=="audio" ) $add=true;
			if (  F1[Q]=="bot_avatar_id" && $add) {
				if ($v==$("#usr_avatar_id").val().trim() ) $add=false
			}
			if (!$add) {
				var $checkAll=false;
				$noFieldsHtm=$noFieldsHtm+'<li>'+F1t[Q]+"</li>" //id="le_'+F1f[Q]+'"
				$field.addClass("notCorrect")
			}else{
				data[F1[Q]]=$v
			}
			debugP=debugP+" "+F1[Q]+" "+F1f[Q]+" "+$add+" "+$v+"<br>";
            
		}
		if (!$checkAll) {
			$("#errorList span").html($noFieldsHtm)
			$("#errorList").fadeIn()
		}
		
		debugP=debugP+"<br><br>checkAll "+$checkAll;
		//*******************************$("#debug").html(debugP+" "+Math.random())//"+$noFieldsHtm+"
		/*$.each(data, function (index, value) {
			//alert( index + ' : ' + value );
		});
		*/
		if (!$checkAll) return $checkAll
		return data
	}
	
	$('#S1').on('click',function(e){e.preventDefault()
		//$("#mask").show()
		var $c=checkFields()
		if (!$c) $("#mask").hide()
		if ($c) {
			
			$.ajax({
				type: "POST", url: "/_m/editor/0/ajax0.php"
				,data: {D:$c} //
				,cache: false,dataType: 'html',
				success: function(php_answer){
					//alert (php_answer);
					var resp=php_answer.split("|-|")
					$("#debug").html(php_answer)
					if (resp[0]=="true"){
						window.location.href = "/?editor/"+resp[1]+"/1";
					}else{
						alert ("Sorry, the game has not be saved.\nreason: "+resp[1])
						$("#mask").hide()
					}
					//$("#mask").hide()

				}
			})	
			
			
		//}else{//if ($c) alert ("missing C")
		}
	})
	
	

	
	

})