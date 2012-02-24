<?php rewind_posts(); ?>
<div id="content">
	<?php if (have_posts()) :  while ($wp_query->have_posts()) : $wp_query->the_post();
		$post_title = get_post_meta(get_the_ID(), 'wpzoom_post_title', true);
		$readmore = get_post_meta(get_the_ID(), 'wpzoom_post_readmore', true);
		$title_url = get_post_meta(get_the_ID(), 'wpzoom_post_url', true);
	 ?>	
	 
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<span class="post_icon"><a href="<?php the_permalink() ?>" class="fade" title="<?php the_title(); ?>"><?php the_title(); ?></a></span>
		<?php if ($post_title != 'No') { ?><h2><a href="<?php if ($title_url != '') { echo $title_url; } else { the_permalink(); } ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2><?php } ?>
		
		<div class="entry">
 			<?php if ($wpzoom_homepost_type == 'Full Content') {  the_content(''); } else { the_excerpt(); } ?>
		</div>
		
		<div class="meta clearfix">
			<?php if ($wpzoom_home_date == 'Show') { ?><span class="date"><?php the_time("$dateformat"); ?></span><?php } ?>
			<?php if ($wpzoom_home_comm == 'Show') { ?><span class="comments"> <?php comments_popup_link( __('0 comments', 'wpzoom'), __('1 comment', 'wpzoom'), __('% comments', 'wpzoom'), '', __('Comments are Disabled', 'wpzoom')); ?></span>  <?php } ?>
			<?php edit_post_link( __('Edit', 'wpzoom'), '<span>', '</span>'); ?>
			
			<?php if ($wpzoom_home_readmore == "Show") { if ($readmore != 'No') { ?><a href="<?php the_permalink() ?>" class="readmore fade"><?php _e('Read More', 'wpzoom'); ?></a><?php } } ?>
		</div>
	</div><!-- /.post -->
	
	<?php endwhile; else : ?>
	<p class="title"><?php _e('There are no posts', 'wpzoom');?></p>
 
<?php endif; wp_reset_query(); ?>
</div>
<div class="navigation">
	<?php if (function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
		<div class="floatleft"><?php next_posts_link(''); ?></div>
		<div class="floatright"><?php previous_posts_link(''); ?></div>
	<?php } ?>
</div> 
