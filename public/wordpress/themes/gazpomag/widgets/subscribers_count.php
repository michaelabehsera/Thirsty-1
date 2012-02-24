<?php
/*
 * Plugin Name: RSS and Twitter Counter
 * Plugin URI: http://www.gazpo.com
 * Description: A widget to show Feedburner subscribers and twitter followers.
 * Version: 1.0
 * Author: Sami Ch.
 * Author URI: http://gazpo.com
 */

add_action( 'widgets_init', 'gazpo_subscribers_count_widgets' );

function gazpo_subscribers_count_widgets() {
	register_widget( 'gazpo_subscribers_count_widget' );
}

class gazpo_subscribers_count_widget extends WP_Widget {

function gazpo_subscribers_count_widget() {
	
		/* Widget settings */
		$widget_ops = array( 'classname' => 'widget_subscribers', 'description' => __('A widget to show Feedburner subscribers and twitter followers.') );

		/* Create the widget */
		$this->WP_Widget( 'gazpo_subscribers_count_widget', __('RSS and Twitter Counter'), $widget_ops );
	}
	
function widget( $args, $instance ) {
		extract( $args );
		
		$username = $instance['username'];
		$refresh_text = "1000+";
		$twitter = $instance['twitter'];

		echo $before_widget;
		
		//RSS Code
		$theurl = file_get_contents('https://feedburner.google.com/api/awareness/1.0/GetFeedData?uri='. $username);
		$begin = 'circulation="'; $end = '"';
		$page = $theurl;
		$parts = explode($begin,$page);
		$page = $parts[1];
		$parts = explode($end,$page);
		$fbcount = $parts[0];
		if($fbcount == '0' || $fbcount == '' ) { $fbcount = $refresh_text; }
		
		//Twitter code
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://www.twitter.com/$twitter");
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PORT, 80);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_REFERER, $referer);
		$document = curl_exec($ch);
		curl_close($ch);
		preg_match_all('#<span id="follower_count" class="stats_count numeric">(.*?)</span>#is', $document, $urlmatches);	 
		$twitter_count = $urlmatches[1][0];		
	?>
		
		<div class="counts">
			
			<div class="fb">
			<img src="<?php bloginfo('template_directory'); ?>/images/feedburner32.png" alt="rss" />
			<span class="count">
				<a href="http://feeds.feedburner.com/<?php echo $username; ?>"><?php echo $fbcount; ?></a>
			</span>
			</div>

			<div class="twitter">
			<img src="<?php bloginfo('template_directory'); ?>/images/twitter32.png" alt="twitter" />
			<span class="count"><a href="http://www.twitter.com/<?php echo $twitter; ?>"><?php echo $twitter_count; ?></a></span>
			</div>
		</div>
		
        <?php

		echo $after_widget;
	}
	
function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['username'] = $new_instance['username'];
		$instance['twitter'] = $new_instance['twitter'];
		return $instance;
	}

	function form( $instance ) {
	
		$defaults = array(
		'username' => "gazpo",
		'twitter' => 'gazpodotcom'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Ad image url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('RSS Acount:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />
		</p>
        
       	<!-- Ad twitter url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e('Twitter Acount:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo $instance['twitter']; ?>" />
		</p>		
	<?php
	}
}
?>