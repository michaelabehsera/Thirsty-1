<?php	
	add_theme_support('automatic-feed-links');
	if ( ! isset( $content_width ) )
	$content_width = 560;
	
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'amphion' ),
	) );
	
	if ( function_exists( 'register_nav_menus' ) ) {	
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'amphion' ),
		'foot_menu' => __( 'Footer Navigation', 'amphionfooter' )
	) );
}
	
	if (function_exists('register_sidebar') )
	register_sidebar(array(
	'name' => 'Sidebar',
	'before_widget' => '<li id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div><div class="widget_bottom"></div>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2><div class="widget_wrap">'
	));
	
	if (function_exists('register_sidebar') )
	register_sidebar(array(
	'name' => 'Footer'
	));

if(function_exists('add_theme_support')) {
   add_theme_support( 'post-thumbnails' );
   set_post_thumbnail_size( 573, 223, true );
}
  
function amphion_lite_get_custom_field_value($szKey, $bPrint = false) {
	global $post;
	$szValue = get_post_meta($post->ID, $szKey, true);
	if ( $bPrint == false ) return $szValue; else echo $szValue;
}

add_action('publish_page', 'add_custom_field_automatically');
add_action('publish_post', 'add_custom_field_automatically');
function add_custom_field_automatically($post_ID) {
	global $wpdb;
	if(!wp_is_post_revision($post_ID)) {
		add_post_meta($post_ID, 'summary', 'put your post summary here(only for Easyslider)', true);
	}
}

	
function amphion_lite_the_thumb($size = "medium", $add = "") {
global $wpdb, $post;
$thumb = $wpdb->get_row("SELECT ID, post_title FROM {$wpdb->posts} WHERE post_parent = {$post->ID} AND post_mime_type LIKE 'image%' ORDER BY menu_order");
if(!empty($thumb)) {
$image = image_downsize($thumb->ID, $size);
print "<img class='amp_thumb' src='{$image[0]}' alt='{$thumb->post_title}' {$add} />";
}
}

function wpe_excerptlength_teaser($length) {
    return 45;
}
function wpe_excerptlength_index($length) {
    return 12;
}
function wpe_excerptmore($more) {
    return '...';
}

function amphion_lite_wpe_excerpt($length_callback='', $more_callback='') {
    global $post;
    if(function_exists($length_callback)){
        add_filter('excerpt_length', $length_callback);
    }
    if(function_exists($more_callback)){
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
}
function amphion_lite_getImage($num) {
global $more;
$more = 1;
$content = get_the_content();
$count = substr_count($content, '<img');
$start = 0;
for($i=1;$i<=$count;$i++) {
$imgBeg = strpos($content, '<img', $start);
$post = substr($content, $imgBeg);
$imgEnd = strpos($post, '>');
$postOutput = substr($post, 0, $imgEnd+1);
$image[$i] = $postOutput;
$start=$imgEnd+1;  
 
$cleanF = strpos($image[$num],'src="')+5;
$cleanB = strpos($image[$num],'"',$cleanF)-$cleanF;
$imgThumb = substr($image[$num],$cleanF,$cleanB);
 
}
if(stristr($image[$num],'<img')) { echo $imgThumb; }
$more = 0;
}

function amphion_lite_catch_that_image() { global $post, $posts; $first_img = ''; $url = get_bloginfo('url'); ob_start(); ob_end_clean(); $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches); $first_img = $matches [1] [0];   $not_broken = @fopen("$first_img","r");  if(empty($first_img) || !($not_broken)){ unset($first_img); } else { $first_img = str_replace($url, '', $first_img); } return $first_img; }

// Change what's hidden by default
add_filter('default_hidden_meta_boxes', 'be_hidden_meta_boxes', 10, 2);
function be_hidden_meta_boxes($hidden, $screen) {
	if ( 'post' == $screen->base || 'page' == $screen->base )
		$hidden = array('slugdiv', 'trackbacksdiv', 'postexcerpt', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv');
		// removed 'postcustom',
	return $hidden;
}

function amphion_lite_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
      <div class="comment-body-top"></div>
     <div id="comment-<?php comment_ID(); ?>" class="comment-body">
      <div class="comment-author vcard">
      <div class="avatar"><?php echo get_avatar($comment,$size='58',$default='<path_to_url>' ); ?></div>

         <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>

      <div class="org_comment"><?php comment_text() ?>
      	<div class="comment-meta commentmetadata">
        <a class="comm_date"><?php printf(get_comment_date()) ?></a>
        <a class="comm_time"><?php printf( get_comment_time()) ?></a>
        <div class="comm_reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
        <div class="comm_edit"><?php edit_comment_link(__('Edit'),'  ','') ?></div></div>
     </div>
     
     </div>
<?php
        }

function amphion_lite_ping($comment, $args, $depth) {
 
$GLOBALS['comment'] = $comment; ?>
	
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
   <div class="comment-body-top"></div>
     <div id="comment-<?php comment_ID(); ?>" class="comment-body">
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>

      <div class="org_ping">
      	<?php printf(__('<cite class="citeping">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	  	<?php comment_text() ?>
            <div class="comment-meta commentmetadata">
            <a class="comm_date"><?php printf(get_comment_date()) ?></a>
            <a class="comm_time"><?php printf( get_comment_time()) ?></a>
            <div class="comm_edit"><?php edit_comment_link(__('Edit'),'  ','') ?></div></div>
     </div>
     </div>
<?php }
function load_into_head() { 
		$option =  get_option('amp_options');
		?>
		<script type="text/javascript">
        /* <![CDATA[ */
        // EASY SLIDER SETTINGS
        jQuery(function(){
            jQuery("#slider").easySlider({
                auto: true,
                continuous: true,
                pause: <?php echo $option['amp_speed'] ?>,
                numeric: true 
            });
        });
        /* ]]> */
        </script> 
		<?php
	}
add_action( 'wp_head', 'load_into_head' ); 
?>
<?php 
require_once ( get_template_directory() . '/theme-options.php' );
include_once (TEMPLATEPATH . '/script/pagination.php'); 
include_once (TEMPLATEPATH . '/widgets/popular_widget.php');
include_once (TEMPLATEPATH . '/widgets/random_widget.php'); 
include_once (TEMPLATEPATH . '/shortcodes.php'); 
?>