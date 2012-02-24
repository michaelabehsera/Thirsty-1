<?php get_header(); ?>
 
<div id="content">
 	
	<?php wp_reset_query(); if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div class="post">
		
		<div class="post_top">
			<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
			<div class="meta clearfix">
				<?php edit_post_link( __('Edit', 'wpzoom'), '<span>', '</span>'); ?>
			</div>
		</div>
	
		<div class="entry">

			<?php the_content(); ?>
			<div class="clear"></div>
			<?php wp_link_pages(array('before' => '<p class="pages"><strong>'.__('Pages', 'wpzoom').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			
		</div><!-- / .entry -->
		
	</div>

	<?php endwhile; else: ?>
	<p><?php _e('Sorry, no posts matched your criteria', 'wpzoom');?>.</p>
	<?php endif; ?>

</div>

<?php get_footer(); ?>