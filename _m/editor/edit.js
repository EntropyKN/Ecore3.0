$(function() {
var $states=$("#core").attr("data-states")
var $groups=$("#core").attr("data-groups")
var $parallels=$("#core").attr("data-parallels")
var $grandMax=0;
var $grandMin=0;
	/*
	//https://jqueryui.com/slider/#steps
	$( "#slider" ).slider({
	  value:0,
	  min: -100,
	  max: 100,
	  step: 10,
	  slide: function( event, ui ) {
		$( "#amount" ).val( "$" + ui.value );
	  }
	});
	$( "#amount" ).val( "$" + $( "#slider" ).slider( "value" ) );
	*/
	// http://lokku.github.io/jquery-nstslider/
	/*
    $('.nstSlider').nstSlider({
    "rounding": {
        "10": "10"
    },		
		
        "left_grip_selector": ".leftGrip",
        "value_bar_selector": ".bar",
        "value_changed_callback": function(cause, leftValue, rightValue) {
            var $container = $(this).parent(),
                g = 255 - 100 + leftValue,
                r = 255 - g,
                b = 0;
				$id=$(this).attr("id")
				$( "#debug").html($id);
            //$container.find('.leftLabel').text(leftValue);
			 $container.find('#L_'+$id).text(leftValue);
            $(this).find('.bar').css('background', 'rgb(' + [r, g, b].join(',') + ')');
			
			$debugLog="";var vals = [];
			$idA=$id.replace("s","").split("_");
			$state=$idA[0]
			for (i = 0; i < $groups; i++) {
				$idCurr=$state+"_"+i
				$val=parseInt( $("#L_s"+$idCurr).text())
				$debugLog=$debugLog+""+$idCurr+" "+$val+"<br>";
				vals[i]=$val;
				//$("#say_"+i).text(D[$STATE]['U'][i][0])
			}

			$max=Math.max.apply(Math,vals);
			$min=Math.min.apply(Math,vals);

			$("#min_"+$state).text($min)
			$("#max_"+$state).text($max)

			
			$debugLog=$debugLog+" max"+$max+" min "+$min+"<br>";
			// grand
			$grandMin=0;
			$grandMax=0;
			for (s = 0; s < $states; s++) {
				$grandMax=$grandMax+parseInt($("#max_"+s).text())
				$grandMin=$grandMin+parseInt($("#min_"+s).text())	
			}
			$mediaMax="";//$grandMax/$states;
			$mediaMin="";//$grandMin/$states;
			$debugLog=$debugLog+ ("<strong>check</strong><br>"+$grandMin+ "("+$mediaMin+") "+$grandMax+" ("+$mediaMax+")")			
			
//			$botIndex=diffs.indexOf(	Math.min.apply(Math,diffs)	)
			$("#debug").html($debugLog)
			
			// graph
			$maxPossible=$states*100;$minPossible=$states*100*-1;
			//$maxPossible:400=$max:x
			//400:$maxpossible=x:$max
			$LBASEpx=800/2
			//$max=$maxPossible;
			$positiveL=($LBASEpx/$maxPossible)*$grandMax
			$negativeL=($LBASEpx/$minPossible)*$grandMin
			$("#positive").css({'width':$positiveL+'px'})
			$("#negative").css({'width':$negativeL+'px'})
			$("#positiveLab").text("")
			if ($grandMax) $("#positiveLab").text($grandMax)
			$("#negativeLab").text("")
			if ($grandMin) $("#negativeLab").text($grandMin)

        }
    });	
*/	
	/*$('#check').on('click',function(e){e.preventDefault()
		$grandMin=0;
		$grandMax=0;
		for (s = 0; s < $states; s++) {
			$grandMax=$grandMax+parseInt($("#max_"+s).text())
			$grandMin=$grandMin+parseInt($("#min_"+s).text())	
		}
		$mediaMax="";//$grandMax/$states;
		$mediaMin="";//$grandMin/$states;
		$("#debug").html ("check "+$grandMin+ "("+$mediaMin+") "+$grandMax+" ("+$mediaMax+")")
		//updateState()
	})*/
	$('.QAshow').on('click',function(e){e.preventDefault()
		$idA=this.id.split("_")
		$id=this.id.replace("U", "C").replace("B", "C")
		if ($idA[0]=="B") $("#singledit").addClass("bot")
		if ($idA[0]=="U") $("#singledit").removeClass("bot")
		$("#singleditC").insertAfter($("#"+$id) ).show();
		$("#singleditCC").html("single edit #"+this.id+"<br>loading...<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>yeah<br>")
		
	})
	$('#singledit').on('click','.close', function(e){e.preventDefault()
		$("#singleditC").hide();
	})
	
	
})