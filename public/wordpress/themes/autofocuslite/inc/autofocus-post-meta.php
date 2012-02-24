<?php

/**	
 *	Post Options and Instructions
 *	Create Post Meta Options and Shortcode Instructions
 */


/**	
 *	Post Meta Options 
 * 	New Array For Video Embed Codes, Copyright info, , and Image Position Gallery Display Option
 */
$af_option_meta_boxes = array(
"video" => array(
	"name" => "videoembed_value",
	"title" => __("Embed URL","autofocus"),
	"type" => "text",
	"std" => "",
	"description" => __("Paste your oEmbed URL here. (Examples: http://vimeo.com/7757262 or http://www.youtube.com/watch?v=xwnJ5Bl4kLI)","autofocus")),

"copyright" => array(
	"name" => "copyright_value",
	"title" => __("Photo Credit","autofocus"),
	"type" => "text",
	"std" => "",
	"description" => __("Text entered here will replace the default Photo credit. (Example: &copy; 2011 Photographer Name. All rights reserved.)","autofocus")),
); 


/**	
 *	AutoFocus Options Meta Boxes 
 */
function af_option_meta_boxes() {
  global $post, $af_option_meta_boxes; ?>

	<div class="form-wrap">

		<?php 
		foreach($af_option_meta_boxes as $meta_box) {
			$meta_box_value = get_post_meta($post->ID, $meta_box['name'], true);

			if($meta_box_value == "")
				$meta_box_value = $meta_box['std'];

			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			switch ( $meta_box['type'] ) {
				case 'text':
					echo '<div class="form-field form-required">';
					echo '<label for="'.$meta_box['name'].'">'.$meta_box['title'].'</label>';
					echo '<input type="text" name="'.$meta_box['name'].'" value="'.$meta_box_value.'" />';
					echo '<p id="'.$meta_box['name'].'">'.$meta_box['description'].'</p></div>';
				break;

				case 'checkbox':
					echo '<div class="form-field form-required">';
					echo '<label for="'.$meta_box['name'].'" class="selectit">'.$meta_box['title'];
					echo '<input type="checkbox" style="text-align:left;width:50px;" name="'.$meta_box['name'].'"  value="true"';
					checked('true', $meta_box_value);
					echo ' /></label>';
					echo '<p id="'.$meta_box['name'].'">'.$meta_box['description'].'</p></div>';
				break;
			}
		} ?> 
	</div>
<?php }

//	Add Action Hooks
add_action( 'admin_menu', 'create_af_meta_boxes' );
add_action( 'save_post', 'save_af_meta_data' );

/**	
 *	Create Form Data 
 */
function create_af_meta_boxes() {
	global $theme_name;
	if ( function_exists('add_meta_box') ) {
		add_meta_box( 'af_option_meta_boxes', __('AutoFocus Post Options', 'autofocus'), 'af_option_meta_boxes', 'post', 'normal', 'high' );
	}
}

/**	
 *	Save Form Data
 */
function save_af_meta_data( $post_id ) {
	global $post, $af_option_meta_boxes, $af_flickr_meta_boxes;

	foreach($af_option_meta_boxes as $meta_box) {
		// Verify
		if ( isset( $_POST[$meta_box['name'].'_noncename'] ) && !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {
			return $post_id;
		}
	
		if ( isset( $_POST['post_type'] ) && ('page' == $_POST['post_type'] ) ) {
			if ( !current_user_can( 'edit_page', $post_id ))
				return $post_id;
		} else {
			if ( !current_user_can( 'edit_post', $post_id ))
				return $post_id;
		}
	
		if ( isset( $_POST[$meta_box['name']] ) ) {
			$data = $_POST[$meta_box['name']];
		}
	
		if ( get_post_meta($post_id, $meta_box['name']) == "" )
			add_post_meta($post_id, $meta_box['name'], $data, true);
	
		elseif ( isset( $data ) && ($data != get_post_meta($post_id, $meta_box['name'], true)) )
			update_post_meta($post_id, $meta_box['name'], $data);
	
		elseif ( isset( $data ) && $data == "")
		delete_post_meta($post_id, $meta_box['name'], get_post_meta($post_id, $meta_box['name'], true));
	}
}

?>