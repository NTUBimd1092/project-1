// JavaScript Document
$(document).ready(function(){
	var i=0;
	$(".favorite").click(function(){
		// Change src attribute of image
		if(i==0){
			$(this).attr("src", "images/selectedFav.png");
			i+=1;
		}else{
			$(this).attr("src", "images/favorite.png");
			i-=1;		
		}
	});  
	
});