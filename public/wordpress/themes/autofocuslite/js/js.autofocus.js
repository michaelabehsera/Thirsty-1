jQuery.noConflict();

jQuery(window).load(function(){

	// Hide & FadeIn elements on page load
	var $fadingelements = jQuery('.af-default .entry-image, #content .entry-image-container, #content .entry-video-container, #content .entry-gallery-container');
	$fadingelements.hide().fadeIn(500);
	
	jQuery(".home #content img").imgCenter({
		parentSteps: 2
	});

});

jQuery(document).ready(function(){

	// Add Superfish Drop Downs to the menu area
    jQuery("#access .menu-header .menu, #access .menu ul").superfish({ 
        delay:       400,                               // delay on mouseout 
        animation:   {opacity:'show',height:'show'},    // fade-in and slide-down animation 
        speed:       'fast',                            // faster animation speed 
		easing: 	 'easeInOutQuint',					// easing
        autoArrows:  false,                             // disable generation of arrow mark-up 
        dropShadows: false                              // disable drop shadows 
    }); 

});