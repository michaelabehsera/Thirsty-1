<?php
global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
}
$dateformat = get_option('date_format');
$timeformat = get_option('time_format');
?>

<?php get_header(); ?>
 
<div id="content">
 	
	<?php wp_reset_query(); if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<span class="post_icon"><a href="<?php the_permalink() ?>" class="fade" title="<?php the_title(); ?>"><?php the_title(); ?></a></span>
		
		<div class="post_top">
			<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
			<div class="meta clearfix">
				<?php if ($wpzoom_singlepost_date == 'Show') { ?><span class="date"><?php the_time("$dateformat $timeformat"); ?></span><?php } ?>
				<?php if ($wpzoom_singlepost_comm == 'Show') { ?><span class="comments"> <?php comments_popup_link( __('0 comments', 'wpzoom'), __('1 comment', 'wpzoom'), __('% comments', 'wpzoom'), '', __('Comments are Disabled', 'wpzoom')); ?></span>  <?php } ?>
				<?php edit_post_link( __('Edit', 'wpzoom'), '<span>', '</span>'); ?>
				
			</div>
		</div>
	
		<div class="entry">

			<?php the_content(); ?>
			<div class="clear"></div>
			<?php wp_link_pages(array('before' => '<p class="pages"><strong>'.__('Pages', 'wpzoom').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			
		</div><!-- / .entry -->
		
		<?php if ($wpzoom_singlepost_tags == 'Show') { the_tags('<div class="meta clearfix"><p class="tags"><span class="fade">', '</span><span class="fade"> ', '</span></p></div>'); } ?> 
		
	</div>
	
	<div id="comments">
		<?php comments_template(); ?>  
	</div>
	
	<?php endwhile; else: ?>
	<p><?php _e('Sorry, no posts matched your criteria', 'wpzoom');?>.</p>
	<?php endif; ?>

</div>
 
<?php get_footer(); ?>