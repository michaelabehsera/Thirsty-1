(function($) {
 
$(document).ready(function() {


	$(function() {
	// OPACITY OF BUTTON SET TO 50%
	$(".fade").css("opacity","1.0");
			
	// ON MOUSE OVER
	$(".fade").hover(function () {
											  
	// SET OPACITY TO 100%
	$(this).stop().animate({
	opacity: 0.7
	}, "quick");
	},
			
	// ON MOUSE OUT
	function () {
				
	// SET OPACITY BACK TO 50%
	$(this).stop().animate({
	opacity: 1.0
	}, "quick");
	});
	});


// End of closure & jquery wraping
});
})(jQuery);
