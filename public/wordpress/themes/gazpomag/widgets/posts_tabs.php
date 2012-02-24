<?php
/*
 * Plugin Name: Recent and Popular Posts
 * Plugin URI: http://gazpo.com
 * Description: A widget to show recent and latest posts, as well recent comments in sidebar.
 * Version: 1.0
 * Author: Sami Ch.
 * Author URI: http://gazpo.com
 */

add_action( 'widgets_init', 'gazpo_posts_tabs_widgets' );

function gazpo_posts_tabs_widgets() {
	register_widget( 'gazpo_posts_tabs_widget' );
}

class gazpo_posts_tabs_widget extends WP_Widget {

function gazpo_posts_tabs_widget() {	
		/* Widget settings */
		$widget_ops = array( 'classname' => 'widget_posts', 'description' => __('A widget to show recent and latest posts, as well recent comments in sidebar.') );
		/* Create the widget */
		$this->WP_Widget( 'gazpo_posts_tabs_widget', __('Recent and Popular Posts'), $widget_ops );
	}
	
function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
	?>
	
	<ul class="tabs">
		<li class="recent current">Recent</li>
		<li class="popular">Popular</li>
		<li class="comments">Comments</li>
	</ul>

	<div class="post_box visible">
		<ul class="posts-list">
			<?php query_posts( 'posts_per_page=5' ); if( have_posts() ) : while( have_posts() ) : the_post(); ?>
	        <li >
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'thumbnail', array('class' => 'thumb') ); ?>
				</a>
				<div class="info">
					<div class="title">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
						<?php $s = substr(the_title('','',FALSE),0,31); ?>
						<?php echo $s; if (strlen($s) >30){ echo '...'; } ?>				
						</a>
					</div>
					<div class="meta">
						<span class="date"><?php the_time('F jS, Y') ?></span>
						<?php $commentscount = get_comments_number(); ?>
						<?php if ($commentscount > 0) { ?>
						<span class="cmts"><?php comments_popup_link( '0', '1', '%'); ?></span>
						<?php } ?>						
					</div>
				</div>
			</li>	
			<?php endwhile; endif;?>
			<?php wp_reset_query();?>			
	    </ul>
	</div>

	<div class="post_box">
		<ul class="posts-list">
			<?php query_posts( 'posts_per_page=5&orderby=comment_count' ); if( have_posts() ) : while( have_posts() ) : the_post(); ?>
	        <li >
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'thumbnail', array('class' => 'thumb') ); ?>
				</a>
				<div class="info">
					<div class="title">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
						<?php $s = substr(the_title('','',FALSE),0,31); ?>
						<?php echo $s; if (strlen($s) >30){ echo '...'; } ?>				
						</a>
					</div>
					<div class="meta">
						<span class="date"><?php the_time('F jS, Y') ?></span>
						<?php $commentscount = get_comments_number(); ?>
						<?php if ($commentscount > 0) { ?>
						<span class="cmts"><?php comments_popup_link( '0', '1', '%'); ?></span>
						<?php } ?>						
					</div>
				</div>
			</li>	
			<?php endwhile; endif;?>
			<?php wp_reset_query();?>			
	    </ul>
	</div>

	<div class="post_box">
		<ul class="posts-list">
		<?php
		$comments = get_comments('status=approve&number=4');
		if ($comments) {		

    foreach ($comments as $comment) {
        echo '<li>';
		?>		
		<?php echo get_avatar( $comment->comment_author_email, 42); ?>
		
		<div class="comment-info">
		<div class="title">
		<?php echo '<a href="'. get_permalink($comment->comment_post_ID).'#comment-'.$comment->comment_ID .'">'.$comment->comment_author.'</a>'; ?>
		</div>
		<p>
		<?php
		
		$comment_string = $comment->comment_content;
		$comment_excerpt = substr($comment_string,0,71);
		
		echo $comment_excerpt;

		if (strlen($comment_excerpt) > 70){
			echo ' ...';
		}
        echo '</p></div></li>';
    }
   
}
else{
	echo '<li>No Comments Yet</li>';
}
?>	
	</ul>
	</div>
<?php
	echo $after_widget;
	}	
}