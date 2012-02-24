<?php
/*
 * Plugin Name: Sidebar 125x125 ads widget
 * Plugin URI: http://gazpo.com
 * Description: This widget allows to place upto 4 125x125 ads in sidebar.
 * Version: 1.0
 * Author: Sami Ch.
 * Author URI: http://gazpo.com
 */

//add function to widget_init to load
add_action( 'widgets_init', 'gazpo_ad125_widgets' );

//register widget
function gazpo_ad125_widgets() {
	register_widget( 'gazpo_ad125_widget' );
}

//widget class
class gazpo_ad125_widget extends WP_Widget {

	function gazpo_ad125_widget() {
	
		$widget_ops = array( 'classname' => 'widget_ad125', 'description' => __('This widget allows to place upto 4 125x125 ads in sidebar.') );
		$this->WP_Widget( 'gazpo_ad125_widget', __('Sidebar 125x125 Ads'), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		//get values from widget.
		$title = apply_filters('widget_title', $instance['title'] );
		
		$ad1 = $instance['ad1'];
		$ad2 = $instance['ad2'];
		$ad3 = $instance['ad3'];
		$ad4 = $instance['ad4'];
				
		$link1 = $instance['link1'];
		$link2 = $instance['link2'];
		$link3 = $instance['link3'];
		$link4 = $instance['link4'];
				
		$randomize = $instance['random'];

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;
			echo '<ul>';

		//ad 1
		if ( $link1 )
			echo '<li><a target="_blank" href="' . $link1 . '"><img src="' . $ad1 . '"  alt="" /></a></li>';
			
		elseif ( $ad1 )
		 	echo '<li><img src="' . $ad1 . '"  alt="" /></li>';
		
		//ad 2
		if ( $link2 )
			echo '<li><a target="_blank" href="' . $link2 . '"><img src="' . $ad2 . '"  alt="" /></a></li>';
			
		elseif ( $ad2 )
		 	echo '<li><img src="' . $ad2 . '"  alt="" /></li>';
			
		//ad 3
		if ( $link3 )
			echo '<li><a target="_blank" href="' . $link3 . '"><img src="' . $ad3 . '"  alt="" /></a></li>';
			
		elseif ( $ad3 )
		 	echo '<li><img src="' . $ad3 . '"  alt="" /></li>';
			
		//ad 4
		if ( $link4 )
			echo '<li><a target="_blank" href="' . $link4 . '"><img src="' . $ad4 . '"  alt="" /></a></li>';
			
		elseif ( $ad4 )
		 	echo '<li><img src="' . $ad4 . '" alt="" /></li>';
			
		echo '</ul>';
		
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['ad1'] = $new_instance['ad1'];
		$instance['ad2'] = $new_instance['ad2'];
		$instance['ad3'] = $new_instance['ad3'];
		$instance['ad4'] = $new_instance['ad4'];
		
		$instance['link1'] = $new_instance['link1'];
		$instance['link2'] = $new_instance['link2'];
		$instance['link3'] = $new_instance['link3'];
		$instance['link4'] = $new_instance['link4'];
				
		return $instance;
	}
	
	function form( $instance ) {
	
		$defaults = array(
		'title' => 'Sponsors',
		'ad1' => get_bloginfo('template_directory')."/images/ad125.jpg",
		'link1' => 'http://gazpo.com',
		'ad2' => get_bloginfo('template_directory')."/images/ad125.jpg",
		'link2' => 'http://gazpo.com',
		'ad3' => '',
		'link3' => '',
		'ad4' => '',
		'link4' => '',		
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- widget title -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<!-- ad1 image url input-->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad1' ); ?>"><?php _e('Ad 1 image url:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'ad1' ); ?>" name="<?php echo $this->get_field_name( 'ad1' ); ?>" value="<?php echo $instance['ad1']; ?>" />
		</p>
		
		<!-- ad1 link url input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link1' ); ?>"><?php _e('Ad 1 link url:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link1' ); ?>" name="<?php echo $this->get_field_name( 'link1' ); ?>" value="<?php echo $instance['link1']; ?>" />
		</p>
		
		<!-- ad2 image url input-->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad2' ); ?>"><?php _e('Ad 2 image url:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'ad2' ); ?>" name="<?php echo $this->get_field_name( 'ad2' ); ?>" value="<?php echo $instance['ad2']; ?>" />
		</p>
		
		<!-- ad2 link url input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link2' ); ?>"><?php _e('Ad 2 link url:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link2' ); ?>" name="<?php echo $this->get_field_name( 'link2' ); ?>" value="<?php echo $instance['link2']; ?>" />
		</p>
		
		<!-- ad3 image url input-->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad3' ); ?>"><?php _e('Ad 3 image url:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'ad3' ); ?>" name="<?php echo $this->get_field_name( 'ad3' ); ?>" value="<?php echo $instance['ad3']; ?>" />
		</p>
		
		<!-- ad3 link url input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link3' ); ?>"><?php _e('Ad 3 link url:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link3' ); ?>" name="<?php echo $this->get_field_name( 'link3' ); ?>" value="<?php echo $instance['link3']; ?>" />
		</p>
		
		<!-- ad4 image url input-->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad4' ); ?>"><?php _e('Ad 4 image url:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'ad4' ); ?>" name="<?php echo $this->get_field_name( 'ad4' ); ?>" value="<?php echo $instance['ad4']; ?>" />
		</p>
		
		<!-- ad4 link url input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link4' ); ?>"><?php _e('Ad 4 link url:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link4' ); ?>" name="<?php echo $this->get_field_name( 'link4' ); ?>" value="<?php echo $instance['link4']; ?>" />
		</p>
		
	<?php
	}
}
?>