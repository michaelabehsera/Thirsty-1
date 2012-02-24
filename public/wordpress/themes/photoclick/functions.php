<?php
function zhng_theme_check()
{
  if ( !function_exists('zhng_social') )
  {
    add_action('admin_print_styles-themes.php', 'zhng_theme_notice');
  }
}
function zhng_theme_notice()
{
?>
  <div class="updated fade">
    <p>It appears that you are using our free version of <strong>PhotoClick</strong> theme. Consider <a href="http://www.simplywp.net/photoclick-theme.html">purchasing our premium version</a> of this theme to get more features at $4.99 only.</p>
  </div>
<?php
}
zhng_theme_check();

// =================================
// Remove auto format
// =================================
function my_formatter($content) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;
}
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
add_filter('the_content', 'my_formatter', 99);

// =================================
// Visual editor stylesheet
// =================================
add_editor_style('styles/editor.css');

// =================================
// Menu location
// =================================
register_nav_menu('top_menu', 'Top Menu');

// =================================
// Add "Home" in menu
// =================================
function home_page_menu( $args ) {
  $args['show_home'] = true;
  return $args;
}
add_filter( 'wp_page_menu_args', 'home_page_menu' );

// =================================
// Change admin panel footer
// =================================
function my_footer_text() {
  echo "<a href=\"http://www.simplywp.net\">Website Design by simplyWP</a>";
} 
add_filter('admin_footer_text', 'my_footer_text');

// =================================
// Change login/logout logo
// =================================
function my_login_head() {
  echo '<style type="text/css">h1 a { background-image: url('.get_bloginfo('template_directory').'/images/custom_logo.gif) !important; }</style>';
}
add_action('login_head', 'my_login_head');

// =================================
// Comment spam, prevention
// =================================
function check_referrer() {
  if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == "") {
    wp_die( __('Please enable referrers in your browser.') );
  }
}
add_action('check_comment_flood', 'check_referrer');

// =================================
// Custom comment style
// =================================
function comment_style($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?>>
  <div class="comment-content" id="comment-<?php comment_ID(); ?>">
    <div class="comment-meta">
    <?php echo get_avatar( $comment, $size = '40' ); ?>
    <?php printf(__('<p><strong>%s</strong>'), get_comment_author_link()) ?><br />
    <small><?php printf( __('%1$s at %2$s'), get_comment_date(), get_comment_time()) ?></small>
    </div>
  <?php if ($comment->comment_approved == '0') : ?><em><?php _e('Your comment is awaiting moderation.') ?></em><br /><?php endif; ?>
  <?php comment_text() ?>
  <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
  </div>
<?php }

// =================================
// Add internal lightbox
// =================================
function add_themescript(){
if(!is_admin()){
  wp_enqueue_script('jquery');
  wp_enqueue_script('thickbox',null,array('jquery'));
  wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, '1.0');
  }
}

function wp_thickbox_script() {
$url = get_bloginfo('template_directory');
?>
<script type="text/javascript">
if ( typeof tb_pathToImage != 'string' )
{
  var tb_pathToImage = "<?php echo get_bloginfo('url').'/wp-includes/js/thickbox'; ?>/loadingAnimation.gif";
}
if ( typeof tb_closeImage != 'string' )
{
  var tb_closeImage = "<?php echo get_bloginfo('url').'/wp-includes/js/thickbox'; ?>/tb-close.png";
}
</script>
<?php }


add_action('init','add_themescript');
add_action('wp_footer', 'wp_thickbox_script');

// =================================
// Add slimbox
// =================================
define("IMAGE_FILETYPE", "(bmp|gif|jpeg|jpg|png)", true);

function lightbox_init() {
$url = get_bloginfo('template_directory');
?>
<link rel="stylesheet" href="<?php echo $url; ?>/js/lightbox/css/slimbox2.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $url; ?>/js/lightbox/lightbox.js"></script>
<?php }

function lightbox_replace($string) {
$pattern = '/(<a(.*?)href="([^"]*.)'.IMAGE_FILETYPE.'"(.*?)><img)/ie';
$replacement = 'stripslashes(strstr("\2\5","rel=") ? "\1" : "<a\2href=\"\3\4\"\5 rel=\"lightbox\"><img")';
return preg_replace($pattern, $replacement, $string);
}

function add_lighbox_rel( $attachment_link ) {
$attachment_link = str_replace( 'a href' , 'a rel="lightbox-cats" href' , $attachment_link );
return $attachment_link;
}

add_action('wp_head', 'lightbox_init');
add_filter('the_content', 'lightbox_replace');
add_filter( 'wp_get_attachment_link' , 'add_lighbox_rel' );

// =================================
// Pagination
// =================================
function get_pagination($args = null) {
$defaults = array(
  'page' => null,
  'pages' => null, 
  'range' => 2,
  'gap' => 2,
  'anchor' => 1,
  'before' => '<ul class="pagination"><li class="pages">Pages</li>',
  'after' => '</ul>',
  'nextpage' => __('Next'),
  'previouspage' => __('Back'),
  'echo' => 1
);
$r = wp_parse_args($args, $defaults); extract($r, EXTR_SKIP);
if (!$page && !$pages) {
  global $wp_query;
  $page = get_query_var('paged');
  $page = !empty($page) ? intval($page) : 1;
  $posts_per_page = intval(get_query_var('posts_per_page'));
  $pages = intval(ceil($wp_query->found_posts / $posts_per_page));
}
$output = "";
if ($pages > 1) {	
  $output .= "$before";
  $ellipsis = "<li><span class=\"current-page\">...</span></li>";
if ($page > 1 && !empty($previouspage)) {
  $output .= "<li><a href='" . get_pagenum_link($page - 1) . "'>$previouspage</a></li>";
}
$min_links = $range * 2 + 1;
$block_min = min($page - $range, $pages - $min_links);
$block_high = max($page + $range, $min_links);
$left_gap = (($block_min - $anchor - $gap) > 0) ? true : false;
$right_gap = (($block_high + $anchor + $gap) < $pages) ? true : false;
if ($left_gap && !$right_gap) {
  $output .= sprintf('%s%s%s', 
  pagination(1, $anchor), 
  $ellipsis, 
  pagination($block_min, $pages, $page)
  );
}
else if ($left_gap && $right_gap) {
  $output .= sprintf('%s%s%s%s%s', 
  pagination(1, $anchor), 
  $ellipsis, 
  pagination($block_min, $block_high, $page), 
  $ellipsis, 
  pagination(($pages - $anchor + 1), $pages)
  );
}
else if ($right_gap && !$left_gap) {
  $output .= sprintf('%s%s%s', 
  pagination(1, $block_high, $page),
  $ellipsis,
  pagination(($pages - $anchor + 1), $pages)
  );
}
else {
  $output .= pagination(1, $pages, $page);
}
if ($page < $pages && !empty($nextpage)) {
  $output .= "<li><a href='" . get_pagenum_link($page + 1) . "'>$nextpage</a></li>";
}
$output .= $after;
}
if ($echo) {
  echo $output;
}
return $output;
}

function pagination($start, $max, $page = 0) {
$output = "";
for ($i = $start; $i <= $max; $i++) {
  $output .= ($page === intval($i)) 
  ? "<li><span class=\"current-page\">$i</span></li>" 
  : "<li><a href='" . get_pagenum_link($i) . "'>$i</a></li>";
}
return $output;
}


register_sidebar(array(
  'name' => 'Footer',
  'description' => 'Footer widget area. Preferable to be 3 widgets only',
  'before_widget' => '<div class="footer-block"><div class="footer-block-tag">&nbsp;</div>',
  'after_widget' => '</div>',
  'before_title' => '<h4>',
  'after_title' => '</h4>',
));

?>