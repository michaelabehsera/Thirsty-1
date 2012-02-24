<?php
global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
}
$dateformat = get_option('date_format');
$timeformat = get_option('time_format');
 ?>
<?php get_header(); ?>

<?php if ($wpzoom_intro == 'Yes') { ?>
 	<div id="welcome">
 	<?php  
		if (check_email_address($wpzoom_intro_avatar) && $wpzoom_intro_avatar != '') { 
			echo get_avatar( $wpzoom_intro_avatar, $size = '95', $default = '<path_to_url>' );
			}
		else  {
 			$wpzoom_intro_avatar = wpzoom_wpmu($wpzoom_intro_avatar) ?><img src="<?php bloginfo('template_directory'); ?>/scripts/timthumb.php?src=<?php echo $wpzoom_intro_avatar; ?>&amp;w=95&amp;h=95&amp;zc=1" /><?php }  ?>
 		<h2><?php echo $wpzoom_intro_title; ?></h2>
		<?php echo stripslashes($wpzoom_intro_content); ?> 
		<div class="clear"></div>
	</div>
<?php }  ?>
 
<div id="content">
 	
	<?php $z = count($wpzoom_exclude_cats_home);if ($z > 0) { 
		$x = 0; $que = ""; while ($x < $z) {
		$que .= "-".$wpzoom_exclude_cats_home[$x]; $x++;
		if ($x < $z) {$que .= ",";} } }		 
		query_posts($query_string . "&cat=$que");if (have_posts()) : 
 
		while ($wp_query->have_posts()) : $wp_query->the_post();
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
<div class="clear"></div>
	
<?php get_footer(); ?>