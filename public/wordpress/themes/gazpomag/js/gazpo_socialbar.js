(function() {  
  jQuery(window).bind('scroll', s_socialbar);
	var socialbar = jQuery('#s_socialbar');
	var start = jQuery(socialbar).offset().top;
		function s_socialbar() {
			var p = jQuery(window).scrollTop();
			jQuery(socialbar).css('position',((p+10)>start) ? 'fixed' : 'absolute');
			jQuery(socialbar).css('top',((p+10)>start) ? '10px' : '');
		}
})();