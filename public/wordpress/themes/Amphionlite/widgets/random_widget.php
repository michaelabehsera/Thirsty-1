<?php
/**
 * random Posts Widget
 */


/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'amphion_load_random_posts_widget' );


/**
 * Register our widget.
 * 'amphion_random_Posts_Widget' is the widget class used below.
 */
function amphion_load_random_posts_widget() {
	register_widget( 'amphion_Random_Posts_Widget' );
}


/**
 * amphion_random_Posts_Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 */
class amphion_random_Posts_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function amphion_random_Posts_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget-posts widget-random-posts', 'description' => 'Displays random posts on your site' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'amphion-random-posts-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'amphion-random-posts-widget', 'Amphion random Posts', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$numberposts = $instance['numberposts'];

		/* Before widget (defined by themes). */
		echo $before_widget;
?>
                <h2>Random Posts</h2>
                <div class="widget_wrap">
                <ul>
                <?php query_posts( 'orderby=rand&posts_per_page='.$numberposts ) ?>
                <?php if(have_posts()): ?><?php while(have_posts()): ?><?php the_post(); ?>
                <li>

                    <!--CALL TO POST IMAGE-->
                    <?php $cti = amphion_lite_catch_that_image();?>
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="pop_img_wrap"><?php the_post_thumbnail('thumbnail'); ?></div>
                    
                    
                    <?php elseif(isset($cti)): ?>
                    <div class="pop_img_wrap"><img src="<?php bloginfo('url'); ?><?php echo $cti; ?>" alt="Link to <?php the_title(); ?>" class="thumbnail"/></div>
                
                    <?php else : ?>
                    <div class="pop_frame"></div>
                             
                    <?php endif; ?>
                    
                    <a class="poptitle" href="<?php the_permalink();?>"><?php the_title(); ?></a>
                    <p><?php excerpt('12'); ?></p>

                    
				<?php endwhile ?>
                <?php endif ?>
                <?php wp_reset_query(); ?></li></ul>

                                

<?php
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['numberposts'] = strip_tags( $new_instance['numberposts'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'numberposts' => 3 );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
        
        
		<!-- Widget Number of Posts: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'numberposts' ); ?>">Number of posts to show:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'numberposts' ); ?>" name="<?php echo $this->get_field_name( 'numberposts' ); ?>" value="<?php esc_attr( $instance['numberposts']); ?>" size="3" />
		</p>

	<?php
	}
}
?>