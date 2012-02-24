<?php
/**
 * Defines tha AutoFocus Theme Options
 *
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	$shortname = "af";
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 */

function optionsframework_options() {
	global $shortname;
	
	// If using image radio buttons, define a directory path
	$imagepath = TEMPLATE_DIR . '/inc/options/images/';

	// Date & Title Choices 
	$date_title_choices = array(
		'titledate' => __( 'Post Title &rarr; Post Date', 'autofocus' ),
		'datetitle' => __( 'Post Date &rarr; Post Title', 'autofocus' ),
		'title' => __( 'Post Title only', 'autofocus' ),
		'date' => __( 'Post Date only', 'autofocus' )
	);

	// Image Display Choices 
	$image_display_choices = array(
		'full-post-thumbnail' => $imagepath . 'full-img.gif',
		'fixed-post-thumbnail' => $imagepath . 'fixed-img.gif'
	);
		
	$options = array();
	
	// Display options
	$options[] = array( "name" => __('General Options', 'autofocus'),
	                    "type" => "heading");
	
	$options[] = array( "name" => "Text Color",
						"desc" => __('Change the color of text, borders and link hover states by entering a HEX color number. (ie: <span style="font-family:Monaco,Lucida Console,Courier,monospace;">#999999</span>)','autofocus'),
						"id" => $shortname."_text_color",
						"std" => "999999",
						"type" => "color");
						
	$options[] = array( "name" => __('Link Color','autofocus'),
						"desc" => __('Change the color of anchor links by entering a HEX color number. (ie: <span style="font-family:Monaco,Lucida Console,Courier,monospace;">#00CCFF</span>)','autofocus'),
						"id" => $shortname."_link_color",
						"std" => "00CCFF",
						"type" => "color");
						
	$options[] = array( "name" => __('Background Color','autofocus'),
						"desc" => __('Change the background color by entering a HEX color number. (ie: <span style="font-family:Monaco,Lucida Console,Courier,monospace;">#FFFFFF</span>)','autofocus'),
						"id" => $shortname."_bg_color",
						"std" => "FFFFFF",
						"type" => "color");   
	
	$options[] = array( "name" => __('Photo Background Color','autofocus'),
						"desc" => __('Change the background color of Portrait (narrow) images on Single Pages by entering a HEX color number. (ie: <span style="font-family:Monaco,Lucida Console,Courier,monospace;">#F0F0F0</span>)','autofocus'),
						"id" => $shortname."_photo_color",
						"std" => "F0F0F0",
						"type" => "color");
	
	$options[] = array( "name" => __('Image Display', 'autofocus'),
						"desc" => __('Choose how to display images and galleries on single posts. <strong>Full</strong> Shows images on single posts at 800 pixels wide with a flexible height. (IMPORTANT: When using the slider option, slides do not rotate automatically). <strong>Fixed</strong> Constrains images on single posts to fit in a 800px &times; 600px display area.','autofocus'),
						"id" => $shortname."_image_display",
						"std" => "full-post-thumbnail",
						"type" => "images",
						"options" => $image_display_choices);

	$options[] = array( "name" => __('Post Title & Date Display','autofocus'),
						"desc" => __('<strong>Post Title &rarr; Post Date</strong> Shows the Post Title initially. Shows the Post Date on mouse-overs.  <strong>Post Date &rarr; Title</strong> Shows the Post Date initially. Shows the Post Title on mouse-overs.  <strong>Post Title only</strong> Shows the Post Title on mouse-overs.  <strong>Post Date only</strong>Shows the Post Date on mouse-overs.  ','autofocus'),
						"id" => $shortname."_title_date",
						"std" => "titledate",
						"type" => "radio",
						"options" => $date_title_choices);
						
	$options[] = array( "name" => __('Show Exif data','autofocus'),
						"desc" => __('Add a check here to show the Exif data for your images on attachment pages (WP Gallery Images only).','autofocus'),
						"id" => $shortname."_show_exif_data",
						"std" => FALSE,
						"type" => "checkbox"); 
	
	$options[] = array(	"name" => __('Info on Author Page','autofocus'),
						"desc" => __("Display a <a href=\"http://microformats.org/wiki/hcard\" target=\"_blank\">microformatted vCard</a> with the author&rsquo;s avatar, bio and email on the author page.",'autofocus'),
						"id" => $shortname."_author_info",
						"std" => false,
						"type" => "checkbox");

	$options[] = array(	"name" => __('Text in Footer','autofocus'),
						"desc" => __('Edit the text that shows up in the footer.', 'autofocus'),
						"id" => $shortname."_footer_text",
						"std" => __('&copy;2011 <a href=\"' . home_url( '/' ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">' . get_bloginfo( 'name', 'display' ) . '</a>. All rights reserved. Proudly powered by <a href="http://wordpress.org/" title="Semantic Personal Publishing Platform" rel="generator">WordPress</a>. Built with the <a class="theme-link" href="http://fthrwght.com/autofocus/" title="AutoFocus II Pro" rel="theme">AutoFocus II Pro Theme</a>.', 'autofocus'),
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94") );

	return $options;

} ?>