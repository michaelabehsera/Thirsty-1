<?php get_header(); ?>
<?php include( TEMPLATEPATH . '/includes/get_options.php' ); ?>
<div id="content">
	<?php if ($gazpo_s_social_pages_show == 'Yes') { ?>
	<div class="s_socialbar" id="s_socialbar">
	<ul>
		<?php s_socialbar_button($gazpo_s_socialbar_btn1); ?>
		<?php s_socialbar_button($gazpo_s_socialbar_btn2); ?>
		<?php s_socialbar_button($gazpo_s_socialbar_btn3); ?>
		<?php s_socialbar_button($gazpo_s_socialbar_btn4); ?>
		<?php s_socialbar_button($gazpo_s_socialbar_btn5); ?>
	</ul>
	</div>	
	<?php } ?>
	
	<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
		<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<div class="postmeta">
				<span class="by"> Posted by <?php the_author_posts_link();?> on <?php the_time('F jS, Y') ?> in</span>
				<span class="category"><?php the_category(', '); ?></span>				
				<span class="comments"><?php comments_popup_link('No comments','1 comment','% comments'); ?></span>
		</div>
		<div class="entry">
			<?php the_content(); ?>
		</div>
		<div id="comments">
			<?php comments_template('', true); ?>
		</div>
	</div>
		
<?php endwhile; ?>
	<div class="navigation">
		<?php posts_nav_link(); ?>
	</div>
<?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>