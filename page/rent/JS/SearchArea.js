function window_onload(){
	setTimeout(function(){
		$(window).scrollTop("0");
	},200);
}

function TopFunction() {
  $(window).scrollTop("0");
}

$(document).ready(function(){
	$(".btnquery").click(function(){
  		$("#TopForm").toggle("normal");
  	});
	
});
