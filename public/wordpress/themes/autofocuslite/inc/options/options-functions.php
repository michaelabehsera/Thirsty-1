<?php

/* These are functions specific to these options settings and this theme */

/*-----------------------------------------------------------------------------------*/
/* Theme Header Output - wp_head() */
/*-----------------------------------------------------------------------------------*/

// This sets up the layouts and styles selected from the options panel

if (!function_exists('optionsframework_wp_head')) {
	function optionsframework_wp_head() { 

		// This prints out the custom css and specific styling options
		of_options_output_css();
	}
}
add_action('wp_head', 'optionsframework_wp_head');

/*-----------------------------------------------------------------------------------*/
/* Theme Footer Output - wp_footer() */
/*-----------------------------------------------------------------------------------*/

// This sets up the JS options selected from the options panel

if (!function_exists('optionsframework_wp_footer')) {
	function optionsframework_wp_footer() { 

		// This prints out the custom JS settings and options
		of_options_output_js();
	}
}
add_action('wp_footer', 'optionsframework_wp_footer');

/*-----------------------------------------------------------------------------------*/
/* Output CSS from standarized options */
/*-----------------------------------------------------------------------------------*/
function of_options_output_css() { 
	global $post, $shortname; 

	$text_color = of_get_option($shortname . '_text_color');
	$link_color = of_get_option($shortname . '_link_color');
	$bg_color = of_get_option($shortname . '_bg_color');
	$photo_color = of_get_option($shortname . '_photo_color');
	$title_date = of_get_option($shortname . '_title_date');
	$single_image_display = of_get_option($shortname . '_image_display');
	
	?>
<style type="text/css">
/* <![CDATA[ */
	
<?php 
	// Pull Styles from Dynamic StylesSheet (Look in /css/ )
	$af_css_options_output = TEMPLATEPATH . '/css/style.options.php'; 
	if( is_file( $af_css_options_output ) ) 
		require $af_css_options_output;
	
	// Echo Optional Styles
	echo $output;
?>
	
/* ]]> */
</style>
<?php }

/*-----------------------------------------------------------------------------------*/
/* Output JS from options */
/*-----------------------------------------------------------------------------------*/
function of_options_output_js() {
	global $post, $shortname; 

	$output = '';

	$text_color = of_get_option($shortname . '_text_color');
	$link_color = of_get_option($shortname . '_link_color');
	$bg_color = of_get_option($shortname . '_bg_color');
	$photo_color = of_get_option($shortname . '_photo_color');
	$title_date = of_get_option($shortname . '_title_date');
	$single_image_display = of_get_option($shortname . '_image_display');

?>
<script type="text/javascript">
/* <![CDATA[ */
<?php 
$af_js_options_output = TEMPLATEPATH . '/js/js.options.php'; 
if( is_file( $af_js_options_output ) ) 
	require $af_js_options_output; 
?>

/* ]]> */
</script>
<?php }

/** 
 * Footer text 
 */
function af_display_footer_text() {
	global $shortname;
	$text = of_get_option($shortname . '_footer_text');
	$showtext = stripslashes($text);
	echo $showtext;
}

?>