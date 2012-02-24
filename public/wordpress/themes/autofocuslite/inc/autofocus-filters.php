<?php
/**
 * AutoFocus Filters 
 *
 * Filters some of the defualt WordPress functions.
 *
*/

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 */
function autofocus_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'autofocus_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 */
function autofocus_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'autofocus_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 */
function autofocus_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'autofocus' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and autofocus_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 */
function autofocus_auto_excerpt_more( $more ) {
	return ' &hellip;' . autofocus_continue_reading_link();
}
add_filter( 'excerpt_more', 'autofocus_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 */
function autofocus_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= autofocus_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'autofocus_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in AutoFocus’s style.css.
 *
 */
function autofocus_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'autofocus_remove_gallery_css' );

/**
 * Customise the AutoFocus Two comments fields with HTML5 form elements
 *
 *	Adds support for 	placeholder
 *						required
 *						type="email"
 *						type="url"
 *
 */
function autofocus_comments() {
	global $commenter, $aria_req;
	
	$req = get_option('require_name_email');

	$fields =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . '</label>' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' placeholder = "First and/or last name"' . ( $req ? ' required' : '' ) . '/></p>',
		            
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . '</label>' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' placeholder="xxxxx@xxxxxxxxx.com"' . ( $req ? ' required' : '' ) . ' /></p>',
		            
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label>' .
		            '<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="http://www.xxxxxxx.com" /></p>'

	);
	return $fields;
}


function autofocus_commentfield() {	

	$commentArea = '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required placeholder="What\'s on your mind?"	></textarea></p>';
	
	return $commentArea;

}
add_filter('comment_form_default_fields', 'autofocus_comments');
add_filter('comment_form_field_comment', 'autofocus_commentfield');

/**
 *	Adds post count and sticky classes to post_class
 */
function af_post_classes($classes) {
	global $post, $af_post_alt;

	if ( is_sticky($post->ID) && is_single($post->ID) )
		$classes[] = 'sticky';

	$af_post_alt++;

	// Adds a post number (p1, p2, etc) to the .hentry DIVs
	$classes[] = 'p' . $af_post_alt;
	return $classes;
}
add_filter('post_class', 'af_post_classes');

// Define the num val for 'alt' classes (in post DIV and comment LI)
$af_post_alt = 0;

?>