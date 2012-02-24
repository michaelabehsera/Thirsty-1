<?php
/**
 *	AutoFocus Shortcodes
 *
 *	Adds custom Shortcodes for displaying dynamic content within the post area.
*/

/**
 * The AutoFocus Five Caption shortcode.
 * added by Richard Shepherd to include HTML5 goodness
 *
 * The supported attributes for the shortcode are 'id', 'align', 'width', and
 * 'caption'.
 *
 */
function autofocus_img_caption_shortcode($attr, $content = null) {

	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));

	if ( 1 > (int) $width || empty($caption) )
		return $content;


if ( $id ) $idtag = 'id="' . esc_attr($id) . '" ';
$align = 'class="' . esc_attr($align) . '" ';

  return '<figure ' . $idtag . $align . 'aria-describedby="figcaption_' . $id . '" style="width: ' . $width . 'px">' 
  . do_shortcode( $content ) . '<figcaption id="figcaption_' . $id . '">' . $caption . '</figcaption></figure>';
}
add_shortcode('wp_caption', 'autofocus_img_caption_shortcode');
add_shortcode('caption', 'autofocus_img_caption_shortcode');

?>