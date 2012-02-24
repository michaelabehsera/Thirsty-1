<?php
// theme admin
include('functions/theme-admin.php');

// get scripts
add_action('wp_enqueue_scripts','my_theme_scripts_function');

function my_theme_scripts_function() {
	
   wp_deregister_script('jquery'); 
   wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"), false, '1.4.2'); 
   wp_enqueue_script('jquery');
   
	wp_enqueue_script('superfish', get_stylesheet_directory_uri() . '/js/superfish.js');
	wp_enqueue_script('sliding effect', get_stylesheet_directory_uri() . '/js/sliding_effect.js');
}

//Remove WordPress Version For Security Reasons
remove_action('wp_head', 'wp_generator');

//Add Pagination Support
include('functions/pagination.php');

// Limit Post Word Count
function new_excerpt_length($length) {
	return 20;
}
add_filter('excerpt_length', 'new_excerpt_length');

//Replace Excerpt Link
function new_excerpt_more($more) {
       global $post;
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

//Activate post-image functionality (WP 2.9+)
if ( function_exists( 'add_theme_support' ) )
add_theme_support( 'post-thumbnails' );

// featured image sizes
if ( function_exists( 'add_image_size' ) ) {
add_image_size( 'shadows-full-size',  9999, 9999, false );
add_image_size( 'shadows-post-image',  140, 140, true );
add_image_size( 'shadows-single-image',  140, 140, true );
add_image_size( 'shadows-related-image',  190, 130, true );
add_image_size( 'shadows-featured-image',  230, 120, true );
}

// Enable Custom Background
add_custom_background();

// Register Navigation Menus
register_nav_menus(
	array(
	'primary'=>__('Menu'),
	)
);
/// add home link to menu
function home_page_menu_args( $args ) {
$args['show_home'] = true;
return $args;
}
add_filter( 'wp_page_menu_args', 'home_page_menu_args' );

// menu fallback
function default_menu() {
	require_once (TEMPLATEPATH . '/includes/default-menu.php');
}

//Register Sidebars
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'Sidebar',
'description' => 'Widgets in this area will be shown in the sidebar.',
'before_widget' => '<div class="sidebar-box">',
'after_widget' => '</div>',
'before_title' => '<h4>',
'after_title' => '</h4>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'First Footer Area',
'description' => 'Widgets in this area will be shown in the footer - left side.',
'before_widget' => '<div class="footer-box">',
'after_widget' => '</div>',
'before_title' => '<h4>',
'after_title' => '</h4>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'Second Footer Area',
'description' => 'Widgets in this area will be shown in the footer - middle left.',
'before_widget' => '<div class="footer-box">',
'after_widget' => '</div>',
'before_title' => '<h4>',
'after_title' => '</h4>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'Third Footer Area',
'description' => 'Widgets in this area will be shown in the footer - middle right.',
'before_widget' => '<div class="footer-box">',
'after_widget' => '</div>',
'before_title' => '<h4>',
'after_title' => '</h4>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'Fourth Footer Area',
'description' => 'Widgets in this area will be shown in the footer - right side.',
'before_widget' => '<div class="footer-box">',
'after_widget' => '</div>',
'before_title' => '<h4>',
'after_title' => '</h4>',
));
?>