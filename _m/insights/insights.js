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
	$('#cfrom').datepicker({
	//	minDate: new Date() ,
	maxDate: new Date(),
	   onSelect: function onSelect(fd, date) {
			timestamp = Date.parse(date)/1000;		   
			//alert($(this).attr("id")+" "+timestamp+" ***   ***  "+date)
			$('#period').attr("data-cfrom", timestamp);
		}
	}) 
	$('#cto').datepicker({
		maxDate: new Date(),
	   onSelect: function onSelect(fd, date) {
			timestamp = Date.parse(date)/1000;
			$('#period').attr("data-cto", timestamp);
		
			
			
		}
	}) 
	/*$('#cto').on('blur', function(e) {	
	

	})*/ 
	singleMask=function (mode){
		return /////////////////////////////////////////////////////////////////////////////////////////////// cancel
		//$('body .spin64').remove();
		$('#mask').hide()
		if (!mode) return
		//$('#m').prepend(spin64);
		$('#mask').show()
		return
	}	
	
	var NOTHING ="";//"<span\ id=\"nothing_yet\">("+L_nothing_yet+")</span>"
	var deb=$("#debug");
	// time
	var xhrTime;
	$("#period").on('change', function(e) {
		res_reset()	
		if ($(this).val()=="custom_0" ) {
			$("#custom").show(); $("#cfrom").focus()
			$('#period').attr("data-cfrom", 0).attr("data-cto", 0);
			return;
		}else{ 
			$("#custom").hide();
		}
		
		if(xhrTime && xhrTime.readystate != 4){xhrTime.abort();}
		
		xhrTime=$.ajax({
			type: "POST", url: "/_m/insights/01.menu.time.ajax.php",
			data: {period:$(this).val(), cfrom: $("#cfrom").val(),cto: $("#cto").val()},cache: false,dataType: 'html', //idgr="+$("#idg").val()
			success: function(php_answer){
				resp=php_answer.split("|-|");
				if ((resp[0])=="false"){
					//alert ("FALSE "+php_answer)
				}else{
					$('#dateShow').html(resp[1]);
					if ($("#period").val()!="custom_0" ) {
						$('#period').attr("data-cfrom", resp[2]).attr("data-cto", resp[3]);
					}else{
						$('#period').attr("data-cfrom", 0).attr("data-cto", 0);
					}
				}
				$("#debug").html(php_answer)
				suggest()
			}
			,error: function(php_answer){alert ("A Little error")}
		})			
		
		
	
	})


	
	///////////////// 
	$("#gug").on('click', ".r",  function(e) {
		res_reset()
		singleMask(true)
		ids=this.id.split("_")
		selected=parseInt( $("#"+ids[0]+"_sel").text());
		idlistC=$("#ids_"+ids[0]).text()
		idlistA=idlistC.split(',')
		if (	$(this).hasClass("on")		)  {
			// remove
			$(this).removeClass("on")
			selected=selected-1;
			idlistNC = idlistA.filter(function(elem){
				return elem != ids[1]; 
		   });		
			
		}else{ 
			// add
			$(this).addClass("on")
			selected=selected+1;
			idlistA.push(ids[1])
			idlistNC=idlistA
		}
		$("#"+ids[0]+"_sel").text(selected)		
		idlistNA=idlistNC.join(",")	.replace(/^,|,$/g,'')
		//alert(ids[0]+idlistNA )
		$("#ids_"+ids[0]).text(		 idlistNA	)
		idlistNC=idlistNA.split(',')	
		
		// groups moves users and gyms
		if (ids[0]=="group"){
			$("#cont_user div").removeClass("on")
			$("#cont_gym div").removeClass("on")
			var gymsIds = [];
			var usersIds = [];
			if (idlistNC[0]) {
				// users
				$.each(		idlistNC				, function (index, value) {
					$.each(group_user[		value		]			, function (i, v) {
						$("#user_"+v).addClass("on")
						usersIds.push(v)
						//alert (v)
					})
				})
				// gyms
				$.each(		idlistNC				, function (index, value) {
					$.each(group_gym[		value		]			, function (i, v) {
						$("#gym_"+v).addClass("on")
						gymsIds.push(v)
						
					})
				})				
				
			}
			$("#gym_sel").text(			$('#cont_gym .on').length			)
			$("#user_sel").text(			$('#cont_user .on').length			)
			$("#ids_user").text(			usersIds.join(",")	.replace(/^,|,$/g,'')			)
			$("#ids_gym").text(			gymsIds.join(",")	.replace(/^,|,$/g,'')			)
		}
		suggest()
		//$("#debug").html(ids[0]+" "+ids[1])
		singleMask(false)
	
	})
	// all none
	.on('click', "#allgroups",  function(e) {
		$('#cont_group .r').each(function(){
			if (	!$(this).hasClass("on")		)  $(this).click();
		})
	})
	.on('click', "#nogroups",  function(e) {
		$('#cont_group .r').each(function(){
			if (	$(this).hasClass("on")		)  $(this).click();
		})
	})	
	
	suggest=function (mode){
		group_sel=parseInt( $("#group_sel").text());
		group_tot=parseInt( $("#group_tot").text());
		user_sel=parseInt( $("#user_sel").text());
		gym_sel=parseInt( $("#gym_sel").text());
		
		// all none
		$("#nogroups, #allgroups").show();
		if (group_sel==0) {
			$("#nogroups").hide();
		}
		if (group_sel==group_tot) {
			$("#allgroups").hide();
		}		
		/// suggest
		if (group_sel==0 && user_sel==0 && gym_sel==0 ) {
			$("#generate").hide(); 
			$("#suggest").addClass("red").html("Please, select something")
		}else{
			$("#generate").show();
			$("#suggest").removeClass("red").html("")
			
			
			//if (group_sel>0 	&& user_sel==0 && gym_sel==0 ) 	$("#suggest").html("Tutte le game e gli utenti relativi ai "+group_sel+" gruppi selezionati")
			if (user_sel>0 && gym_sel==0 ) 	{ //group_sel==0 && 
				$("#suggest").html(""+user_sel+" users in every games they can play") //in tutti i games a loro assegnati
				if (user_sel==1 )  $("#suggest").html("<strong>"+$("#cont_user .on").text()	+"</strong>'s activity");
			}
			if (user_sel>0 && gym_sel>0 ) 	{ //group_sel==0 && 
				$("#suggest").html(""+user_sel+" users in "+gym_sel+" selected games ")
				if (user_sel==1 )  $("#suggest").html("<strong>"+$("#cont_user .on").text()	+"</strong>'s activity in the "+gym_sel+" selected games");
			}
			if (user_sel>0 && gym_sel==1 ) 	{ //group_sel==0 && 
				$("#suggest").html(""+user_sel+" users in game <strong>"+$("#cont_gym .on").text()	+"</strong>")
				if (user_sel==1 )  $("#suggest").html("<strong>"+$("#cont_user .on").text()	+"</strong>'s activity in the game <strong>"+$("#cont_gym .on").text()	+"</strong>")
			}

			if (user_sel==0 && gym_sel>0 ) 	{ //group_sel==0 && 
				$("#suggest").html("Activities of all users in "+gym_sel+" selected games ")
				if (gym_sel==1 )  $("#suggest").html("Activities for the game <strong>"+$("#cont_gym .on").text()	+"</strong>");	
			}

			if (group_sel>0 && user_sel==0 && gym_sel==0 ) 	{ 
				$("#suggest").html("Activities users and games in the "+group_sel+" selected groups") //L'attività di tutti gli utenti e dei games nei
				if (group_sel==1 )  $("#suggest").html("Activities of all users and games in the group <strong>"+$("#cont_group .on").text()	+"</strong>");	
			}



		}
		
		return
	}	
	
	res_reset=function (){
		//$("#generate").fadeIn();
		suggest();
		$("#result,.chart,.chartSub").fadeOut();
	}
	
////////////////// generate
	// time 
	var xhrGen;
	$("#generate").on('click', function(e) {
		from=parseInt ($('#period').attr("data-cfrom"))
		to=parseInt ($('#period').attr("data-cto"))
		
		if (			from			> to	) {
			alert ("the Start date is after the end date :-(");
			$('#cfrom').focus()
			return false
		}
		if (			!to			|| ! from	) {
			alert ("Sorry, i cannot understand taken dates...");
			$('#cfrom').focus()
			return false
		}
		singleMask(true); 
		
		
		if(xhrGen && xhrGen.readystate != 4){xhrGen.abort();}
		//alert ($("period").val()); //period:$("period").val(), 
		//alert ($("#ids_gym").text())
		xhrGen=$.ajax({
			type: "GET", url: "/_m/insights/insights.ajax.php",
			data: {cfrom: $("#period").attr("data-cfrom"),cto: $("#period").attr("data-cto")
			, ids_group:$("#ids_group").text() 
			, ids_user:$("#ids_user").text() 
			, ids_gym:$("#ids_gym").text() }
			,cache: false,dataType: 'html', //idgr="+$("#idg").val()
			success: function(php_answer){
				//alert (php_answer)
				r=php_answer.split("|-|");
				$("#result").html(r[1]).fadeIn();
				singleMask(false)
				//alert (php_answer);
				$("#debug").html(r[5])
				$("#generate").hide();
		////////////////////////////////////////////// charts
		//alert (r[2]+"************ "+r[3]	+"************ "+ resp[0])
		if (		(r[2]!=0 || r[3]!=0 || r[4]!=0)	&& resp[0]=="true"			) {
			google.charts.load('visualization', '1', {'packages': ['corechart', 'bar']});
			google.charts.setOnLoadCallback(drawChart  );
		
		function drawChart() {
			
			if (r[2]!=0) {
				
				$("#chart1").show();
				var D=JSON.parse(r[2])
				var data = google.visualization.arrayToDataTable(D);
				var options = {
				animation: {
					  duration: 1000,
					  easing: 'out',
					  startup: true
				  },
				  is3D: true,
				pointsVisible:true,
				colors:['#FBD842','#0039ba','#45A245'/*#859868*/,'brown'],	//#45A245 green	#FBD842 yellow #DC3912 red
				  vAxis: {minValue: 0}
				  ,isStacked: true
				  ,legend: {position: 'top', alignment: 'end', maxLines: 1}
				   ,'chartArea': {left:40,right:0,'height': '70%','width': '86%',}
				};
				var chart = new google.visualization.ColumnChart(document.getElementById('chart1'))
				chart.draw(data, options);	
			} //r[2]

			if (r[3]!=0) {
				//alert (r[3])
				$("#chart2").show();
				var D1=JSON.parse(r[3])
				var data1 = google.visualization.arrayToDataTable(D1);
				var options1 = {
				// title: 'Chess opening moves',
				animation: {
					  duration: 1000,
					  easing: 'out',
					  startup: true
				  },
				  is3D: true,
				pointsVisible:true,
				colors:['#dc3912','#eb4821','#fb5831', '#ff7a53',     '#27A727','#139313','#178A17', '#008000'],
				vAxis: {minValue: 0}
				   ,isStacked: 'percent'
				  ,legend: {position: 'top', alignment: 'end', maxLines: 1}
				   ,'chartArea': {left:40,right:0,'height': '70%','width': '86%',}
				};
				
     		 var view = new google.visualization.DataView(data1);
				var chart2 = new google.visualization.ColumnChart(document.getElementById('chart2'))
				chart2.draw(view, options1);	
			} 
			if (r[4]!=0) {
				//alert (r[4])
				$("#chart3,#chartSub3").show();
				var D2=JSON.parse(r[4])
				var data2 = google.visualization.arrayToDataTable(D2);
				var options2 = {
				animation: {
					  duration: 1000,
					  easing: 'out',
					  startup: true
				  },
				pointsVisible:true,
				colors:['#FBD842','#0039ba','#45A245'/*#859868*/,'brown'],	//#45A245 green	#FBD842 yellow #DC3912 red
				  vAxis: {minValue: 0}				  
				  ,isStacked: true
				  ,legend: {position: 'top', alignment: 'end', maxLines: 1}
				   ,'chartArea': {left:40,right:0,'height': '70%','width': '86%',}
				};
				var chart3 = new google.visualization.ColumnChart(document.getElementById('chart3'))
				chart3.draw(data2, options2);	
			}else{ //r[4]
				$("#chartSub3")	.hide();
			}//4
			
		 } // func
		
		}else{
			$(".chart,.chartSub")	.hide();
		}
			/////////////////////////////////////////charts
			} // success
			,error: function(php_answer){alert ("(B) Little error")}
		})			
		
		
	
	})
	
	/// callusr
	$("#result").on('click', ".callusr",  function(e) {
		e.preventDefault()
		singleMask(true)
		var uc=this.id.replace("uc_", "")	;
		$("#nogroups").click().promise().done(function(  ) {	
			$("#user_"+uc).click().promise().done(function(  ) {
			setTimeout(function(){
				$("#generate").click();
			}, 600);
			})
		})
		
		
		
	})
	
	
	// run

	$(window).load(function(){
		$("#period").change();
		setTimeout(function(){ $("#generate").click(); }, 1000);

	});	
	
})