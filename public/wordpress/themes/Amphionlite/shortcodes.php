<?php
add_filter('widget_text', 'do_shortcode');
/**AMPHION SHORTCODES **/

/**FACEBOOK LIKE BUTTON **/
/**USAGE: [fblike]**/
function amphion_lite_facelike() {
   return '<iframe src="http://www.facebook.com/plugins/like.php?href="'.urlencode(get_permalink($post->ID)).'">&layout=button_count&show_faces=false&width=80&action=like&font=lucida+grande&colorscheme=light" allowtransparency="true" style="border: medium none; overflow: hidden; width: 80px; height: 21px;" frameborder="0″ scrolling="no"></iframe>';
}
add_shortcode('fblike', 'amphion_lite_facelike');

/**SPECIAL BUTTON **/
/** USAGE: [button link="#"]Your button Text[/button] **/
function amphion_lite_sButton($atts, $content = null) {
   extract(shortcode_atts(array('link' => '#'), $atts));
   return '<a class="sbutton" href="'.esc_html($link).'" target="_blank"><span>' . do_shortcode($content) . '</span></a>';
}
add_shortcode('button', 'amphion_lite_sButton');
