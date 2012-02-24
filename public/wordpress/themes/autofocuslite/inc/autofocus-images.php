<?php
/**
 *	AutoFocus Image Functions
 *
 *	Build the functions, galleries, and sliders for images. 
 *
*/

/**
 * Create the AutoFocus entry image loop
 */
function af_entry_image( $af_size = 'medium' ) {
	global $post;

	if ( has_post_thumbnail() ) : ?>

		<span class="entry-image">
			<a class="entry-image-post-link dragthis" title="<?php printf( esc_attr__( '%s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( $af_size ); ?></a>
		</span><!-- .entry-image -->
		<?php af_image_credit(); ?>	

	<?php else : 

		$linkedimgtag = get_post_meta($post->ID, 'image_tag', true);
		$args = array(
			'order'          => 'ASC',
			'post_type'      => 'attachment',
			'post_parent'    => get_the_ID(),
			'post_mime_type' => 'image',
			'post_status'    => null,
			'numberposts'    => 1,
		);

		$attachments = get_posts($args);
		
		if ($attachments) {
			foreach ($attachments as $attachment) { ?>
			
				<span class="entry-image">
					<a class="entry-image-post-link dragthis" title="<?php printf( esc_attr__( '%s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" href="<?php the_permalink(); ?>">
						<?php echo wp_get_attachment_image($attachment->ID, $af_size); ?>
					</a>
				</span><!-- .entry-image -->
				<?php af_image_credit(); ?>	

			<?php }

		} elseif ( $linkedimgtag != '' ) { ?>
				<span class="entry-image">
					<a class="entry-image-post-link dragthis" title="<?php printf( esc_attr__( '%s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" href="<?php the_permalink(); ?>">
						<?php echo $linkedimgtag; ?>
					</a>
				</span><!-- .entry-image -->
				<?php af_image_credit(); ?>	

		<?php } else { 
			echo "<!-- This post doesn’t have an image attachment! -->";
		}
		
		endif;

}

/**
 *	Setup Images for posts without attachments
 */
function af_entry_image_setup($postid) {
	global $post;
	$post = get_post($postid);

	//	get url
	if ( !preg_match('/<img ([^>]*)src=(\"|\')(.+?)(\2)([^>\/]*)\/*>/', $post->post_content, $matches) ) {
		return false;
	}

	//	url setup /**/
	$post->image_url = $matches[3];
	if ( !$post->image_url = preg_replace('/\?w\=[0-9]+/','', $post->image_url) )
		return false;

	$post->image_url = esc_url( $post->image_url, 'raw' );
	
	delete_post_meta($post->ID, 'image_url');
	delete_post_meta($post->ID, 'image_tag');

	add_post_meta($post->ID, 'image_url', $post->image_url);
	add_post_meta($post->ID, 'image_tag', '<img src="'.$post->image_url.'" />');
}
add_action('publish_post', 'af_entry_image_setup');
add_action('publish_page', 'af_entry_image_setup');


/**
 * Create the AutoFocus image slider
 */
function af_single_entry_image( $af_size = 'full-post-thumbnail', $af_slider_count = '10' ) {
	global $post;

		if ( get_post_meta($post->ID, 'videoembed_value', true) ) {  ?>

			<div class="entry-video-container">
				<?php 
					$af_video_url = get_post_meta($post->ID, 'videoembed_value', true);
					$oembed_url = wp_oembed_get($af_video_url, array( 'width' => 800 )); 
					echo $oembed_url; 
				?>
			</div><!-- .entry-video-container -->

		<?php 
		} else { ?>
	
			<div class="entry-image-container">
				<?php af_entry_image($af_size); ?>
			</div><!-- .entry-image-container -->
		<?php } 
}

/**
 *	Image Author/Credit Display
 */
function af_image_credit() { 
	global $post;
		
	if ( get_post_meta($post->ID, 'copyright_value', true) ) {  ?>
		<span class="photo-credit"><?php echo get_post_meta($post->ID, 'copyright_value', true); ?></span>
	<?php } elseif ( get_the_author_meta('user_url') == '' ) { ?>
		<span class="photo-credit">&copy; <?php the_time('Y'); ?> <?php the_author_meta('display_name'); ?>. <?php _e('All rights reserved.', 'autofocus'); ?></span>
	<?php } else { ?>
		<span class="photo-credit">&copy; <?php the_time('Y'); ?> <a href="<?php the_author_meta('user_url'); ?>" target="_blank" rel="author"><?php the_author_meta('display_name'); ?></a>. <?php _e('All rights reserved.', 'autofocus'); ?></span>
	<?php } ?>

<?php } 

/** 
 *	Grab EXIF Data from Attachments
 *	http://www.bloggingtips.com/2008/07/20/wordpress-gallery-and-exif/
 */
function af_display_exif_data() {
	global $id, $post;

	$imgmeta = wp_get_attachment_metadata($id);

	$shutterspeed_meta = $imgmeta['image_meta']['shutter_speed'];
	if ( $shutterspeed_meta > 0 ) {
		$display_shutterspeed_meta = "1/" . 1 / $shutterspeed_meta;
	} else {
		$display_shutterspeed_meta = 0;
	}

	//	Start to display EXIF and IPTC data of digital photograph
	echo '<h3 id="exif-data">' . __('Exif Data', 'autofocus') . '</h3>';
	echo '<ul>';
	echo '<li><span class="exif-title">' . __('Date Taken:', 'autofocus') . '</span> ' . date("d-M-Y H:i:s", $imgmeta['image_meta']['created_timestamp']) . '</li>';
	echo '<li><span class="exif-title">' . __('Copyright:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['copyright'] . '</li>';
	echo '<li><span class="exif-title">' . __('Credit:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['credit'] . '</li>';
	echo '<li><span class="exif-title">' . __('Title:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['title'] . '</li>';
	echo '<li><span class="exif-title">' . __('Caption:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['caption'] . '</li>';
	echo '<li><span class="exif-title">' . __('Camera:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['camera'] . '</li>';
	echo '<li><span class="exif-title">' . __('Focal Length:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['focal_length'] . 'mm</li>';
	echo '<li><span class="exif-title">' . __('Aperture:', 'autofocus') . '</span> f/' . $imgmeta['image_meta']['aperture'] . '</li>';
	echo '<li><span class="exif-title">' . __('ISO:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['iso'] . '</li>';
	echo '<li><span class="exif-title">' . __('Shutter Speed:', 'autofocus') . '</span> ' . $display_shutterspeed_meta . '</li>';
	echo '</ul>';
}

/**
 *	Get the Post Thumbnail URL for the EXIF link
 */
function af_exif_link( $post_id = NULL, $size = 'full-post-thumbnail', $attr = '' ) {
	global $id;
	$post_id = ( NULL === $post_id ) ? $id : $post_id;
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	$size = apply_filters( 'full-post-thumbnail', $size );
	if ( $post_thumbnail_id ) {
		$thumburl = get_attachment_link( $post_thumbnail_id, $size, false, $attr );
	} else {
		$thumburl = '';
	}
	return $thumburl;
}

/**
 *	Add Images/Video/Embeds to feeds
 *
 *	- Based on the Custom Fields for Feeds Plugin by Justin Tadlock: 
 *	- http://justintadlock.com/archives/2008/01/27/custom-fields-for-feeds-wordpress-plugin
 */
function af_feed_content( $content ) {
	global $post, $id;
	
	$blog_key = substr( md5( get_bloginfo('url') ), 0, 16 );
	
	if ( !is_feed() ) return $content;
 
//	Is there a Video attached?
	if ( get_post_meta($post->ID, 'videoembed_value', true) ) {
		$af_video_url = get_post_meta($post->ID, 'videoembed_value', true);
		$mediafeed = '[embed width="600" height="400"]' . $af_video_url . '[/embed]';
	}

//	If there’s no video is there an image thumbnail?
	if ( has_post_thumbnail() ) {
		$mediafeed = the_post_thumbnail('medium');
	}

//	If there's a video or an image, display the media with the content
	if ($mediafeed !== '') {
		$content = '<p>' . $mediafeed . '</p><br />' . $content;
		return $content;
 
//	If there's no media, just display the content
	} else {
		$content = $content;
		return $content;
	}
}
add_filter('the_content', 'af_feed_content');

?>