<?php
/*
 * Plugin Name: Twitter Widget for Footer
 * Plugin URI: http://gazpo.com/
 * Description: A widget to display latest tweets in the footer of the gazpoMag theme.
 * Version: 1.0
 * Author: Sami Ch.
 * Author URI: http://gazpo.com
 */

add_action( 'widgets_init', 'gazpo_twitter_widgets' );

function gazpo_twitter_widgets() {
	register_widget( 'gazpo_twitter_widget' );
}

class gazpo_twitter_widget extends WP_Widget {

function gazpo_twitter_widget() {
	
		/* Widget settings */
		$widget_ops = array( 'classname' => 'widget_tweets', 'description' => __('A widget to display latest tweets in the footer of the gazpoMag theme.') );

		/* Create the widget */
		$this->WP_Widget( 'gazpo_twitter_widget', __('Twitter Widget for Footer'), $widget_ops );
	}
	
function widget( $args, $instance ) {
		extract( $args );
		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$username = $instance['username'];
		
		echo $before_widget;

		if ( $title ){ ?>
			<h4 class="title"><?php echo $title; ?></h4>
		<?php	}	?>
		
	<script type="text/javascript" src="http://widgets.twimg.com/j/2/widget.js"></script>
<script type="text/javascript">
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: 10,
  interval: 6000,
  width: 'auto',
  height: 150,
  theme: {
    shell: {
      background: 'none',
      color: '#CCCCCC',
	  links: '#DAE5EC'
    },
    tweets: {
      background: 'none',
      color: '#CCCCCC',
      links: '#DAE5EC'
    }
  },
  features: {
    scrollbar: false,
    loop: true,
    live: true,
    hashtags: false,
    timestamp: false,
    avatars: true,
    behavior: 'default'
  }
}).render().setUser('<?php echo $instance['username']; ?>').start();
</script>            
        <?php
		echo $after_widget;
	}
	
function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = $new_instance['username'];		
		return $instance;
	}

	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'title' => 'Latest Tweets',
		'username' => "gazpodotcom"		
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<!-- Ad image url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Twitter username:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />
		</p>
		
	<?php
	}
}

?>