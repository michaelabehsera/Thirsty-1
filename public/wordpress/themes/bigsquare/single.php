<?php get_header(); ?>
	<!-- #content -->
	<div id="content">
		<!-- start of .post -->
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post">
			<h1><?php the_title(); ?></h1>
			<div class="meta">
				<span><?php _e('by'); ?></span> <strong><?php the_author(); ?></strong> <span><?php _e('posted'); ?></span> <strong><?php echo get_the_date(); ?></strong> <span><?php _e('category'); ?></span> <?php the_category(', '); ?>
			</div>
			<?php the_content(); ?>
		</div>
		<!-- end of .post -->
		<?php endwhile; ?>
		<div class="paging">
			<div class="alignright"><?php next_post_link(); ?></div>
			<div class="alignleft"><?php previous_post_link(); ?></div>
			<div class="clear"></div>
		</div>
		<?php comments_template(); ?>
		<?php endif;?>
		
		<?php get_footer(); ?>