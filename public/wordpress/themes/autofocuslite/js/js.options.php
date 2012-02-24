<?php 
/**
 * AutoFocus JS Scripts
 *
 * Adds scripts based on the AutoFocus theme options and conditions
 */
?>

jQuery(document).ready(function(){

<?php 

	// Add Custom Cropping Script Front Page
	if ( is_user_logged_in() ) { ?>

	// Setup HashGrid Plugin: http://hashgrid.com
	var grid = new hashgrid({
		id: 'afgrid',            // id for the grid container
		modifierKey: 'alt',      // optional 'ctrl', 'alt' or 'shift'
		showGridKey: 'g',        // key to show the grid
		holdGridKey: 'h',    // key to hold the grid in place
		foregroundKey: 'f',      // key to toggle foreground/background
		jumpGridsKey: 'd',       // key to cycle through the grid classes
		numberOfGrids: 1,        // number of grid classes used
		classPrefix: 'afgrid-',    // prefix for the grid classes
		cookiePrefix: 'autofocus-grid'   // prefix for the cookie name
	}); 

	// Edit link animation
	jQuery(".af-default .post").hover(function(){ 
		jQuery(this).find(".entry-utility").stop(true).animate({
			opacity: 1.00,
			right: '0'
		}, 200 );
	}, function(){
		jQuery(this).find(".entry-utility").stop(true).animate({
			opacity: 0,
			right: '-=100'
		}, 200 );
	});

<?php }

	// Set Up Titles for Front Page using the Default Layout
	if ( is_home() ) {

		if ( $title_date == 'titledate' ) { ?>
	
			// Hover animations for front page
			jQuery(".af-default .hentry").hover(function(){ 
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 0.25);
			}, function(){
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 1.0);
			});
		
		<?php } elseif ( $title_date == 'datetitle' ) { ?>
	
			// Hover animations for front page
			jQuery(".af-default .hentry").hover(function(){ 
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 0.25);
			}, function(){
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 1.0);
			});
	
		<?php } elseif ( $title_date == 'title' ) { ?>
	
			// Hover animations for front page
			jQuery(".af-default .hentry").hover(function(){ 
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 0.25);
			}, function(){
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 1.0);
			});
		
		<?php } elseif ( $title_date == 'date' ) { ?>
		
			// Hover animations for front page
			jQuery(".af-default .hentry").hover(function(){ 
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 0.25);
			}, function(){
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 1.0);
			});
	
		<?php } 
	}

	// Hover animations for Single Pages and Large Image Shortcodes
	if ( is_single() ) { ?>

		// Hover animations for Single Pages
		jQuery(".single .entry-image-container").hover(function(){
			jQuery(this).children(".photo-credit, .entry-caption").stop(true).fadeTo("fast", 1.0);
		}, function(){
			jQuery(this).children(".photo-credit, .entry-caption").stop(true).fadeTo("fast", 0);
		});
		
	<?php } ?>

});
