var C_DIR=""
var spin64='<div class="spin64"></div>'
var spin16='<div class="spin16"></div>'
$(function() {
	
	var css_adapt=function() {
		var H=$(window).height(); var W=$(window).width();
		$("#mask").css({'width':W+'px'});$("#mask").css({'height':H+'px'})
	}
	
	css_adapt()
	$(window).load(function(){	css_adapt();	})
	$(window).bind('orientationchange',function(event){css_adapt()}) 
	$(window).bind('resize',function(event){css_adapt()})
	
	//$titleGo=$("#title").length()//		.val().trim();
	jQuery.fn.exists = function(){return this.length>0;}
	if ($("#title").exists()) {
		if ($("#title").val().trim()) $("#nowEditing").text($("#title").val().trim())
	}

//	if ($("#title").val().trim()) $("#nowEditing").text($("#title").val().trim())
	
})