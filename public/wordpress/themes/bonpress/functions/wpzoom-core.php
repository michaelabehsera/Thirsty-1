<?php 

/*-----------------------------------------------------------------------------------*/
/* WPZOOM Admin Panel & Theme Features												 */
/*-----------------------------------------------------------------------------------*/
 
 
/*----------------------------------*/
/* Localization						*/
/*----------------------------------*/

load_theme_textdomain( 'wpzoom', TEMPLATEPATH.'/languages' );

$locale = get_locale();
$locale_file = TEMPLATEPATH."/languages/$locale.php";
if ( is_readable($locale_file) )
	require_once($locale_file);


/*----------------------------------*/
/* Custom Menus						*/
/*----------------------------------*/

if (function_exists('register_nav_menus')) {
register_nav_menus( array(
		'primary' => __( 'Main Menu', 'wpzoom' ),
	) );
}


/*----------------------------------*/
/* Featured Image					*/
/*----------------------------------*/

if (function_exists('add_theme_support')) {
	add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 9999, 9999, true ); // Normal post thumbnails, set to maximum size, then will be cropped with TimThumb script
}
	
/*----------------------------------*/
/* Custom Background				*/
/*----------------------------------*/

if ( function_exists( 'add_custom_background'  ) ) { 
// This theme allows users to set a custom background. Added in 3.0
add_custom_background();
}

 
/*----------------------------------*/
/* WPZOOM RSS						*/
/*----------------------------------*/

function wpzoom_rss()
{	 global $wpzoom_misc_feedburner;
    if (strlen($wpzoom_misc_feedburner) < 1) {
        bloginfo('rss2_url');
    } else {
        echo $wpzoom_misc_feedburner;
    }
}

/*----------------------------------*/
/* WPZOOM js						*/
/*----------------------------------*/

function wpzoom_js()
{
    $args = func_get_args();
    foreach ($args as $arg) {
        echo '<script type="text/javascript" src="' . get_bloginfo('template_directory') . '/js/' . $arg . '.js"></script>' . "\n";
    }
}


/*--------------------------------------*/
/* Initializing WPZOOM Theme Options 	*/
/*--------------------------------------*/

 if (is_admin() && $_GET['activated'] == 'true') {
header("Location: admin.php?page=wpzoom_options");
}


if (is_admin() && $_GET['page'] == 'wpzoom_options') {
	add_action('admin_head', 'wpzoom_admin_css');
	// wp_enqueue_script('jquery');
	wp_enqueue_script('tabs', get_bloginfo('template_directory').'/wpzoom_admin/simpletabs.js');
}

function wpzoom_admin_css() {
	echo '
	<link rel="stylesheet" type="text/css" media="screen" href="'.get_bloginfo('template_directory').'/wpzoom_admin/options.css" />
	';
}
 
$functions_path = TEMPLATEPATH . '/wpzoom_admin/';
require_once ($functions_path . 'admin_functions.php');
$homepath = get_bloginfo('template_directory');

add_action('admin_menu', 'wpzoom_add_admin');

?>