/**
 * Prints out the inline javascript needed for the colorpicker and choosing
 * the tabs in the panel.
 */

jQuery(document).ready(function(jQuery) {
	
	// Fade out the save message
	jQuery('.fade').delay(1000).fadeOut(1000);

	// Switches option sections
	jQuery('.group').hide();
	var activetab = '';
	if (typeof(localStorage) != 'undefined' ) {
		activetab = localStorage.getItem("activetab");
	}
	if (activetab != '' && jQuery(activetab).length ) {
		jQuery(activetab).fadeIn();
	} else {
		jQuery('.group:first').fadeIn();
	}
	jQuery('.group .collapsed').each(function(){
		jQuery(this).find('input:checked').parent().parent().parent().nextAll().each( 
			function(){
				if (jQuery(this).hasClass('last')) {
					jQuery(this).removeClass('hidden');
						return false;
					}
				jQuery(this).filter('.hidden').removeClass('hidden');
			});
	});
	
	if (activetab != '' && jQuery(activetab + '-tab').length ) {
		jQuery(activetab + '-tab').addClass('nav-tab-active');
	}
	else {
		jQuery('.nav-tab-wrapper a:first').addClass('nav-tab-active');
	}
	jQuery('.nav-tab-wrapper a').click(function(evt) {
		jQuery('.nav-tab-wrapper a').removeClass('nav-tab-active');
		jQuery(this).addClass('nav-tab-active').blur();
		var clicked_group = jQuery(this).attr('href');
		if (typeof(localStorage) != 'undefined' ) {
			localStorage.setItem("activetab", jQuery(this).attr('href'));
		}
		jQuery('.group').hide();
		jQuery(clicked_group).fadeIn();
		evt.preventDefault();
	});
           					
	jQuery('.group .collapsed input:checkbox').click(unhideHidden);
				
	function unhideHidden(){
		if (jQuery(this).attr('checked')) {
			jQuery(this).parent().parent().parent().nextAll().removeClass('hidden');
		}
		else {
			jQuery(this).parent().parent().parent().nextAll().each( 
			function(){
				if (jQuery(this).filter('.last').length) {
					jQuery(this).addClass('hidden');
					return false;		
					}
				jQuery(this).addClass('hidden');
			});
           					
		}
	}
	
	// Image Options
	jQuery('.of-radio-img-img').click(function(){
		jQuery(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		jQuery(this).addClass('of-radio-img-selected');		
	});
		
	jQuery('.of-radio-img-label').hide();
	jQuery('.of-radio-img-img').show();
	jQuery('.of-radio-img-radio').hide();
		 		
});	