<?php
/**
 * AutoFocus 2.0 Lite functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, autofocus_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 */

/**
 * Define Constants
 */

// Get Theme and Child Theme Data
// Credits: Joern Kretzschmar & Thematic http://themeshaper.com/thematic
$themeData = get_theme_data(TEMPLATEPATH . '/style.css');
$version = trim($themeData['Version']);
if(!$version)
    $version = "unknown";

$childeThemeData = get_theme_data(STYLESHEETPATH . '/style.css');
$templateversion = trim($childeThemeData['Version']);
if(!$templateversion)
    $templateversion = "unknown";


// Set theme constants
define('THEMENAME', $themeData['Title']);
define('THEMEAUTHOR', $themeData['Author']);
define('THEMEURI', $themeData['URI']);
define('VERSION', $version);

// Set child theme constants
define('TEMPLATENAME', $childeThemeData['Title']);
define('TEMPLATEAUTHOR', $childeThemeData['Author']);
define('TEMPLATEURI', $childeThemeData['URI']);
define('TEMPLATEVERSION', $templateversion);

// Path constants
define('TEMPLATE_DIR', get_bloginfo('template_directory'));
define('STYLESHEET_DIR', get_bloginfo('stylesheet_directory'));
define('STYLEURL', get_bloginfo('stylesheet_url'));

/**
 * Load Options Framework: http://wptheming.com/2010/12/options-framework/
 */

if ( !function_exists( 'optionsframework_init' ) ) {

	/* Set the file path based on whether the Options Framework Theme is a parent theme or child theme */
	if ( STYLESHEETPATH == TEMPLATEPATH ) { 
		define('OPTIONS_FRAMEWORK_PATH', STYLESHEETPATH . '/inc/options/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('stylesheet_directory') . '/inc/options/');
	} else {
		define('OPTIONS_FRAMEWORK_PATH', TEMPLATEPATH . '/inc/options/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('template_directory') . '/inc/options/');
	}
	
	require_once (OPTIONS_FRAMEWORK_PATH . 'options-framework.php');
	require_once (OPTIONS_FRAMEWORK_PATH . 'options-functions.php');

}

//	Load AutoFocus Image Functions
require_once(TEMPLATEPATH . '/inc/autofocus-images.php');

//	Load AutoFocus WP Filters
require_once(TEMPLATEPATH . '/inc/autofocus-filters.php');

//	Load AutoFocus Settings
require_once(TEMPLATEPATH . '/inc/autofocus-shortcodes.php');

//	Load AutoFocus Post Meta Options
require_once(TEMPLATEPATH . '/inc/autofocus-post-meta.php');


/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 494;

/** Tell WordPress to run autofocus_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'autofocus_setup' );

if ( ! function_exists( 'autofocus_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * To override autofocus_setup() in a child theme, add your own autofocus_setup to your child theme's
 * functions.php file.
 */
function autofocus_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add new Full Gallery & Archive Thumb image sizes for Front Page slider and Archives
	set_post_thumbnail_size( 88, 88, true ); // Default thumbnail size
	add_image_size( 'archive-thumbnail', 188, 188, true ); // Archives thumbnail size
	add_image_size( 'fixed-post-thumbnail', 800, 600 ); // Fixed Single Posts thumbnail size
	add_image_size( 'full-post-thumbnail', 800, 9999 ); // Full Single Posts thumbnail size
	add_image_size( 'front-page-thumbnail', 800, 300, true ); // Front Page thumbnail size
	
	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'autofocus', TEMPLATEPATH . '/languages' );

	// Set Up localization
	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'autofocus' ),
	) );
}
endif;


/**
 * Template for comments and pingbacks.
 */
if ( ! function_exists( 'autofocus_comment' ) ) :
function autofocus_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'comment' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 50 ); ?>
			<?php printf( __( '%s', 'autofocus' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'autofocus' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'autofocus' ), get_comment_date(),  get_comment_time() ); ?></a>
				<?php edit_comment_link( __( 'Edit', 'autofocus' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'By', 'autofocus' ); ?> <?php comment_author_link(); ?>
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'autofocus' ), get_comment_date(),  get_comment_time() ); ?>
				<?php edit_comment_link( __('Edit', 'autofocus'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 */
function autofocus_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'autofocus_remove_recent_comments_style' );

/**
 * Prints HTML with meta information for the current post—date/time and author.
 */ 
if ( ! function_exists( 'af_posted_on' ) ) :
function af_posted_on() {
	printf( '<a class="%1$s" href="%2$s" title="%3$s" rel="bookmark"><time datetime="%4$s" pubdate>%5$s</time></a>',
		'entry-date',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date('Y-m-d\TH:i') ),
		esc_attr( get_the_date() )
	);
}
endif;

/**
 * Prints HTML with meta information for the current post (date, author, category, tags and permalink).
 */
if ( ! function_exists( 'af_post_meta' ) ) :
function af_post_meta() { 
	printf( __( '<span class="%1$s">By: %2$s</span>', 'autofocus' ),
		'entry-author',
		sprintf( '<a class="author vcard url fn n" href="%1$s" title="%2$s">%3$s</a>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'autofocus' ), get_the_author() ),
			esc_html( get_the_author() )
		)
	);

	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', __( ', ', 'autofocus' ) );
	if ( $tag_list ) {
		$posted_in = __( '<span class="entry-cats">Filed under %1$s.</span> <span class="entry-tags">Tagged %2$s.</span> <span class="entry-permalink">Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.</span>', 'autofocus' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( '<span class="entry-cats">Filed under %1$s.</span> <span class="entry-permalink">Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.</span>', 'autofocus' );
	} else {
		$posted_in = __( '<span class="entry-permalink">Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.</span>', 'autofocus' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( __( ', ', 'autofocus' ) ),
		$tag_list,
		esc_url( get_permalink() ),
		the_title_attribute( 'echo=0' )
	);
}
endif;


/**
 * Display Author Avatar
 */
function af_author_info_avatar() {
    global $wp_query; 
    $curauth = $wp_query->get_queried_object();
	
	$email = $curauth->user_email;
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar("$email") );
	echo $avatar;
}

/**
 *	Previous / Next Excerpts
 *	- Thanks very much to Thin & Light (http://thinlight.org/) for this custom function!
 */
function af_excerpt($text, $excerpt_length = 25) {
	$text = str_replace(']]>', ']]&gt;', $text);
	$text = strip_tags($text);
	$text = preg_replace("/\[.*?]/", "", $text);
	$words = explode(' ', $text, $excerpt_length + 1);
	if (count($words) > $excerpt_length) {
		array_pop($words);
		array_push($words, '...');
		$text = implode(' ', $words);
	}	
	return apply_filters('the_excerpt', $text);
}

//	Setup AF Post Excerpt
function af_post_excerpt($post) {
	$excerpt = ($post->post_excerpt == '') ? (af_excerpt($post->post_content))
			: (apply_filters('the_excerpt', $post->post_excerpt));
	return $excerpt;
}

//	Setup Previous Post Excerpt
function previous_post_excerpt($in_same_cat = 1, $excluded_categories = '') {
	if ( is_attachment() )
		$post = &get_post($GLOBALS['post']->post_parent);
	else
		$post = get_previous_post($in_same_cat, $excluded_categories);

	if ( !$post )
		return;
	$post = &get_post($post->ID);
	echo af_post_excerpt($post);
}

//	Setup Next Post Excerpt
function next_post_excerpt($in_same_cat = 1, $excluded_categories = '') {
	if ( is_attachment() )
		$post = &get_post($GLOBALS['post']->post_parent);
	else
		$post = get_next_post($in_same_cat, $excluded_categories);

	if ( !$post )
		return;
	$post = &get_post($post->ID);
	echo af_post_excerpt($post);
}

/**
 *	AutoFocus Navigation Above
 */
function autofocus_nav_above() {
	global $post, $excluded_categories, $in_same_cat, $shortname;

	// Grab The Blog Category
	$af_blog_catid = of_get_option($shortname . '_blog_cat');

	if ( in_category($af_blog_catid)) : ?>
				<nav id="nav-above" class="navigation">
					<div class="nav-previous"><?php previous_post_link('%link', __('<span class="meta-nav">&larr;</span>', 'autofocus'), TRUE) ?></div>
					<div class="nav-next"><?php next_post_link('%link', __('<span class="meta-nav">&rarr;</span>', 'autofocus'), TRUE) ?></div>
				</nav><!-- #nav-above -->
	<?php else : ?>
				<nav id="nav-above" class="navigation">
					<div class="nav-previous"><?php previous_post_link('%link', __('<span class="meta-nav">&larr;</span>', 'autofocus'), 0, $af_blog_catid) ?></div>
					<div class="nav-next"><?php next_post_link('%link', __('<span class="meta-nav">&rarr;</span>', 'autofocus'), 0, $af_blog_catid) ?></div>
				</nav><!-- #nav-above -->
	<?php endif; 
}

/**
 *	AutoFocus Navigation Below
 */
function autofocus_nav_below() {
	global $post, $excluded_categories, $in_same_cat, $shortname;
	
	// Grab The Blog Category
	$af_blog_catid = of_get_option($shortname . '_blog_cat');

	if ( in_category($af_blog_catid) ) : ?>
			<nav id="nav-below" class="navigation">
				<h3><?php _e('Browse', 'autofocus') ?></h3>
			<?php 
				$previouspost = get_previous_post(TRUE);
				if ($previouspost != null) {
					echo '<div class="nav-previous">';
					previous_post_link('<span class="meta-nav">&larr;</span> Older: %link', '%title', TRUE);
					echo '<div class="nav-excerpt">';
					previous_post_excerpt(TRUE);
					echo '</div></div>';
				 } ?>
	
			<?php 
				$nextpost = get_next_post(TRUE);
				if ($nextpost != null) {
					echo '<div class="nav-next">';
					next_post_link('Newer: %link <span class="meta-nav">&rarr;</span>', '%title', TRUE);
					echo '<div class="nav-excerpt">';
					next_post_excerpt(TRUE);
					echo '</div></div>';
				 } ?>

			</nav><!-- #nav-below -->

	<?php else : ?>

			<nav id="nav-below" class="navigation">
				<h3><?php _e('Browse', 'autofocus') ?></h3>
			<?php 
				$previouspost = get_previous_post(FALSE, $af_blog_catid);
				if ($previouspost != null) { 
					echo '<div class="nav-previous">';
					previous_post_link('<span class="meta-nav">&larr;</span> Older: %link', '%title', FALSE, $af_blog_catid);
					echo '<div class="nav-excerpt">';
					previous_post_excerpt(FALSE, $af_blog_catid);
					echo '</div></div>';
				 } ?>
	
			<?php 
				$nextpost = get_next_post(FALSE, $af_blog_catid);
				if ($nextpost != null) {
					echo '<div class="nav-next">';
					next_post_link('Newer: %link <span class="meta-nav">&rarr;</span>', '%title', FALSE, $af_blog_catid);
					echo '<div class="nav-excerpt">';
					next_post_excerpt(FALSE, $af_blog_catid);
					echo '</div></div>';
				 } ?>

			</nav><!-- #nav-below -->

	<?php endif;
}

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override autofocus_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 */
function autofocus_widgets_init() {
	// Area 1, located to the right of the content area.
	register_sidebar( array(
		'name' => __( 'Singlular Widget Area', 'autofocus' ),
		'id' => 'singlular-widget-area',
		'description' => __( 'The singlar post/page widget area', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'autofocus' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'autofocus' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'autofocus' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'autofocus' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
/** Register sidebars by running autofocus_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'autofocus_widgets_init' );

//	Custom image size settings initiated at activation
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
	update_option('thumbnail_size_h', '188');
	update_option('thumbnail_size_w', '188');
	update_option('thumbnail_crop', '1');

	update_option('medium_size_h', '288');
	update_option('medium_size_w', '288');
	update_option('medium_crop', '0');

	update_option('large_size_h', '494');
	update_option('large_size_w', '494');
	update_option('large_crop', '0');

	update_option('thread_comments', '1');
	update_option('thread_comments_depth', '2');
	
	update_option('embed_size_h', '200');
	update_option('embed_size_w', '494');

	update_option( 'posts_per_page', '12');
	update_option( 'date_format', __('j M ’y') );
}


/**
 * Adds a 'singular' class to the array of body classes.
 */
function af_body_classes( $classes ) {
	if ( is_singular() && ! is_home() && ! is_page_template( 'blog-page.php' ) )
		$classes[] = 'singular';
	if ( is_search() )
		$classes[] = 'archive';
	return $classes;
}
add_filter( 'body_class', 'af_body_classes' );

/**
 *	Adds the 'autofocus' class to the BODY for AF animation and displays
 *	Uses these classes to display the Grid and Staggered layouts
 */
function af_layout_class($class = '') {
	global $posts;

	// Create classes array
	$af_classes = array();
	
	// Which layout is being used?
	if ( is_archive() || is_search() )
		$af_classes[] = 'normal-layout';
	
	if ( is_home() )
		$af_classes[] = 'af-default';

	// Output classes
	$class_str = implode( ' ', $af_classes );
	echo $class_str;

}

/**
 *	Add custom JS & jQuery scripts on NON-admin pages.
 */
function af_enqueue_scripts() {
	global $post, $shortname; 

	if ( !is_admin() ) { // Is this necessary?
		wp_enqueue_script('modernizer', TEMPLATE_DIR . '/js/modernizr-1.6.min.js', array('jquery'), '1.6' );
		wp_enqueue_script('easing', TEMPLATE_DIR . '/js/jquery.easing-1.3.pack.js', array('jquery'), '1.3' );
		wp_enqueue_script('hoverintent', TEMPLATE_DIR . '/js/hoverIntent.js', array('jquery') );
		wp_enqueue_script('superfish', TEMPLATE_DIR . '/js/superfish.js', array('jquery', 'easing') );
		wp_enqueue_script('supersubs', TEMPLATE_DIR . '/js/supersubs.js', array('jquery') );

		//	Add Hashgrid for logged in users only
		if ( is_user_logged_in() )
			wp_enqueue_script('hashgrid', TEMPLATE_DIR . '/js/hashgrid.js', array('jquery'), '6.0' );

		//	Add Img center script
		if ( is_home() )
			wp_enqueue_script('imgcenter', TEMPLATE_DIR . '/js/jquery.imgCenter.minified.js', array('jquery'), '6.0' );

		wp_enqueue_script('autofocusjs', TEMPLATE_DIR . '/js/js.autofocus.js', array('jquery'), '2.0' );
	}
}
add_action('wp_print_scripts', 'af_enqueue_scripts');


/**
 *	Counts Database queries and speed
 */
function af_query_count() { ?>
	<?php echo get_num_queries(); ?> queries.
	<?php timer_stop(1); ?> seconds.
<?php }
// add_action('wp_footer', 'af_query_count');

/**
 *	Adds Commented Credit
 */
function af_author_credit() { ?>
<!-- Site design based on AutoFocus+ Pro by Allan Cole for http://fthrwght.com/autofocus -->
<?php }
add_action('wp_footer', 'af_author_credit');

?>