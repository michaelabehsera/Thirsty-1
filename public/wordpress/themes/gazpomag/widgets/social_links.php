<?php
/*
 * Plugin Name: Social Communities URLs Widget
 * Plugin URI: http://gazpo.com/
 * Description: A widget to display the social links in footer or sidebar.
 * Version: 1.0
 * Author: Sami Ch.
 * Author URI: http://gazpo.com/
 */

add_action( 'widgets_init', 'gazpo_social_widgets' );

function gazpo_social_widgets() {
	register_widget( 'gazpo_social_widget' );
}

class gazpo_social_widget extends WP_Widget {

function gazpo_social_widget() {
	
		/* Widget settings */
		$widget_ops = array( 'classname' => 'widget_social', 'description' => __('A widget to display the social links in footer or sidebar.') );

		/* Create the widget */
		$this->WP_Widget( 'gazpo_social_widget', __('Social Communities URLs'), $widget_ops );
	}
	
function widget( $args, $instance ) {
		extract( $args );
		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$twitter_url = $instance['twitter_url'];
		$facebook_url = $instance['facebook_url'];
		$gplus_url = $instance['gplus_url'];
		$rss_url = $instance['rss_url'];
		$contact = $instance['contact'];
		
		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;		
			?>
           <ul>
		   <? if(!empty($twitter_url)){	?>
				<li class="twitter">
				<a href="<?php echo $twitter_url; ?>" target="_blank" title="Follow on Twitter">Follow on Twitter</a>
				</li>
			<? 
			} 
			if(!empty($facebook_url)){	?>
				<li class="facebook">
				<a href="<?php echo $facebook_url; ?>" target="_blank" title="Join on Facebook">Join on Facebook</a>
				</li>
			<? }
			if(!empty($gplus_url)){	?>
				<li class="gplus">
				<a href="<?php echo $gplus_url; ?>" target="_blank" title="Join on Google Plus">Join on Google+</a>
				</li>
			<? }
			if(!empty($rss_url)){	?>
				<li class="rss">
				<a href="<?php echo $rss_url; ?>" target="_blank" title="Subscribe to RSS Feeds">Subscribe to RSS</a>
				</li>
			<? }
			if(!empty($contact)){	?>
				<li class="contact">
				<a href="<?php echo $contact; ?>" target="_blank" title="Contact us">Contact us</a>
				</li>
			<? } ?>
			
		   </ul>
        <?php
		echo $after_widget;
	}
	
function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['twitter_url'] = $new_instance['twitter_url'];
		$instance['facebook_url'] = $new_instance['facebook_url'];
		$instance['gplus_url'] = $new_instance['gplus_url'];
		$instance['rss_url'] = $new_instance['rss_url'];
		$instance['contact'] = $new_instance['contact'];
		return $instance;
	}

	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'title' => 'Interact',
		'twitter_url' => 'http://twitter.com/gazpodotcom',
		'facebook_url' => 'http://www.facebook.com/pages/Gazpocom/182192741803165',
		'gplus_url' => 'https://plus.google.com/112871708280864003956/',
		'rss_url' => 'http://feeds.feedburner.com/gazpo',
		'contact' => 'http://gazpo.com/contact-us/',
		
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<!-- Ad image url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_url' ); ?>"><?php _e('Twitter URL:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_url' ); ?>" name="<?php echo $this->get_field_name( 'twitter_url' ); ?>" value="<?php echo $instance['twitter_url']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'facebook_url' ); ?>"><?php _e('Facebook URL:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook_url' ); ?>" name="<?php echo $this->get_field_name( 'facebook_url' ); ?>" value="<?php echo $instance['facebook_url']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'gplus_url' ); ?>"><?php _e('Google Plus URL:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'gplus_url' ); ?>" name="<?php echo $this->get_field_name( 'gplus_url' ); ?>" value="<?php echo $instance['gplus_url']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'rss_url' ); ?>"><?php _e('RSS URL:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'rss_url' ); ?>" name="<?php echo $this->get_field_name( 'rss_url' ); ?>" value="<?php echo $instance['rss_url']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'contact' ); ?>"><?php _e('Contact Page URL:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'contact' ); ?>" name="<?php echo $this->get_field_name( 'contact' ); ?>" value="<?php echo $instance['contact']; ?>" />
		</p>
		
	<?php
	}
}

?>