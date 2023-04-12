$(function() {
	var counter = 0;
	var counterIntval = setInterval(function () {
	  ++counter;
	}, 1000);
	
	var css_adaptCookie=function() {
		$("#cookeLawCont").css({'height':$("#cookeLawMsg").height()+'px'})
	}
	var cookieAccept=function() {
		if ($.cookie("cookieLaw")) {
			$("#debug").html("cookieLaw accept already setted")
		}else{
			$("#debug").html("cookieLaw accepted")
			$.cookie("cookieLaw", "you_accepted_PALMA_cookie_policy", { expires: 7300 },"/"); //20 years	
		}
		clearInterval(counterIntval)
		$("#cookeLawCont, #cookeLawMsg").fadeOut(2000).promise().done(function(  ) {
			$("#cookeLawCont, #cookeLawMsg").remove();
		});
		
		
	}

	$(window).scroll(function() {
		/*var height = $(window).scrollTop();$("#debug").html(height);if(height  > 80) */
		$("#debug").html(counter)
		if (counter>2) cookieAccept();

	});
	var $lang=$("body").attr("data-lang")
	
	$div='<div id="cookeLawCont">';
	$div=$div+'</div>'
		$div=$div+'<div id="cookeLawMsg">';
		$policyLink="/informativa.pdf";
		if ($lang=="it") {
			$div=$div+'<div class="c1">Questo sito e i suoi strumenti forniti da terze parti usano i cookies</div>'
			$div=$div+'<div class="c2">che sono necessari al suo funzionamento e acquisiti per gli scopi descritti nella nostra <a target="_BLANK" href="'+$policyLink+'">Cookie policy</a>: <a  target="_BLANK" href="'+$policyLink+'">Scopri di pi&ugrave;</a><br />'
			$div=$div+'se chiudi questo avviso, fai scrolling sulla pagina, fai click su un link e in generale se continui a navigare, acconsenti all\'utilizzo dei cookies</div>'
			$div=$div+'<a id="cookeLawMsgClose" href="#">ACCETTO</a>'
			
		}else{
			$div=$div+'<div class="c1">This website and its third party tools use cookies</div>'
			$div=$div+'<div class="c2">which are necessary to its functioning and required to achieve the purposes illustrated in <a target="_BLANK" href="'+$policyLink+'">the cookie policy</a>: <a  target="_BLANK" href="'+$policyLink+'">Learn More</a><br />'
			$div=$div+'By closing this banner, scrolling this page, clicking a link or continuing to browse otherwise, you agree to the use of cookies</div>'		
			$div=$div+'<a id="cookeLawMsgClose" href="#">ACCEPT</a>'
		}
		$div=$div+'</div>'

	$("body").prepend($div).promise().done(function(  ) {
		css_adaptCookie();
	});	
	$(window).bind('orientationchange',function(event){css_adaptCookie()}) 
	$(window).bind('resize',function(event){css_adaptCookie()})

	$('body').on('click','#cookeLawMsgClose',function(event){event.preventDefault()
		cookieAccept()
	});

});	
