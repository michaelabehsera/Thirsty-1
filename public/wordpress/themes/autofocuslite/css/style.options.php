<?php
/**
 * AutoFocus Styles 
 *
 * Sets styles based on the AutoFocus theme options
 */

	// Text Color: Background ?>
	.sf-menu ul a:hover, .sf-menu .current_page_item ul a:hover,
	.af-default #content header a,
	.af-default #content .entry-meta,
	.af-default #content .entry-meta .entry-date,
	.af-default #content .entry-content, 
	.af-default #content .entry-content a,
	#content .photo-credit, #content .photo-credit a,
	#content .entry-caption, #content .entry-caption a,
	.entry-gallery-container #nav a,
	.entry-gallery-container #counter,
	#content .entry-content .large-image figcaption,
	#fancybox-title,
	#content #sticky-area #nav a,
	.page-link a:link, .page-link a:visited {color:#<?php echo $bg_color; ?>}
<?php // Text Color: Links ?>
	a,a:link, a:visited, 
	.sf-menu .current_page_item ul a, 
	#content .photo-credit a:hover, 
	#content .entry-content blockquote.pull-quote, 
	.af-color {color:#<?php echo $link_color; ?>}
<?php // Text Color: Text ?>
	body, input, textarea,
	#content .entry-content blockquote cite,
	.ie7 #content .entry-content div.large-image p,
	a:active, a:hover, 
	.sf-menu .current_page_item a, .sf-menu .current_page_item a:hover, 
	.entry-meta a:hover, .entry-utility a:hover {color:#<?php echo $text_color; ?>}
<?php // Background Color: Background ?>
	body, #access ul ul a {background-color:#<?php echo $bg_color; ?>}
<?php // Background Color: Photo ?>
	#content .entry-image-container, 
	#content .entry-video-container, 
	#content .entry-gallery-container {background-color:#<?php echo $photo_color; ?>}
<?php // Background Color: Link ?>
	.sf-menu ul a:hover,
	.home #content .post,
	.search .af-default #content .post,
	.archive .af-default #content .post,
	.archive .post-image-container,
	.archive .post-video-container,
	.entry-gallery-container #nav a:hover, 
	.entry-gallery-container #nav a.activeSlide,
	.page-link a:link, 
	.page-link a:visited {background-color:#<?php echo $link_color; ?>}
<?php // Background Color: Text ?>
	.page-link a:hover, 
	.page-link a:active {background-color:#<?php echo $text_color; ?>}
<?php // Border Color: Text ?>
	hr,
	#access .sub-menu,
	#access .children,
	#content .page-title,
	#content .entry-content div.wp-caption,
	#content .entry-content blockquote,
	article header, .single #content header,
	article footer,
	.single #content header .entry-title, 
	.single #content header .entry-date,
	.search #content header .entry-title,
	.archive #content header .entry-title,
	.af-blog-template #content header .entry-title,
	.error404 #content .post, 
	.search-no-results #content .post, 
	#content header .archive-meta,
	#content .entry-content table, 
	#content .entry-content th, 
	#content .entry-content td,
	#content .entry-content figure,
	#content div.error404,
	#content #author-info .author-bio,
	#content #author-info #author-email,
	.single #nav-below h3,
	#respond #reply-title,
	#comments .commentlist, 
	#comments .commentlist li,
	#comments .commentlist ul li,
	#comments .pinglist, 
	#comments .pinglist li,
	.aside ul li.widgetcontainer li ul {border-color:#<?php echo $text_color; ?>}
<?php // Border Color: Link ?>
	#comments .commentlist li.bypostauthor, 
	#comments .commentlist li.bypostauthor .avatar {border-color:#<?php echo $link_color; ?>}	
<?php 
	// How should the Post Date/ Post Title be displayed?
	if ( $title_date == 'titledate' && is_home() ) { ?>
	.af-default #content .entry-date, 
	.af-default #content .entry-content {display:none}
<?php } elseif ( $title_date == 'datetitle' && is_home() ) { ?>
	.af-default #content .entry-title, 
	.af-default #content .entry-content {display:none}
<?php } elseif ( $title_date == 'title' && is_home() ) { ?>
	.af-default #content .entry-title, 
	.af-default #content .entry-date, 
	.af-default #content .entry-content {display:none}
<?php } elseif ( $title_date == 'date' && is_home() ) { ?>
	.af-default #content .entry-title, 
	.af-default #content .entry-date, 
	.af-default #content .entry-content {display:none}
<?php } 
	// Resize Slider Images to fit within the slider
	if ( is_single() && $single_image_display == 'fixed-post-thumbnail') { ?>
	.cycle .entry-image img,
	.entry-image-container .entry-image img {width:auto;max-height:532px;}
<?php } ?>
