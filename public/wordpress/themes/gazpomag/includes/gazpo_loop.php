<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>

		<div class="post" id="post-<?php the_ID(); ?>">

			<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			
			<div class="postmeta">
				<span class="by"> Posted by <?php the_author_posts_link();?> on <?php the_time('F jS, Y') ?> in</span>
				<span class="category"><?php the_category(', '); ?></span>				
				<span class="comments"><?php comments_popup_link('No comments','1 comment','% comments'); ?></span>
			</div>
			<?php if(($gazpo_post_thumbs_show == 'Yes') and (has_post_thumbnail())) { ?>
			<?php the_post_thumbnail(array( 200,200 ), array( 'class' => 'alignleft' )); ?>
			
				<?php if ($gazpo_home_twitter_btn == 'Yes') { ?>			
					<div class="thumb-twitter-entry">
						<?php the_excerpt(); ?>
					</div>
			
					<div class="post-twitter">			
						<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink();?>" data-text="<?php the_title(); ?>" data-count="vertical">Tweet</a>						
					</div>
			
			<?php } else { ?>
				
				<div class="thumb-entry">
					<?php the_excerpt(); ?>
				</div>
			
			<?php } ?>
			
			<?php } else { ?>
			
			<?php if ($gazpo_home_twitter_btn == 'Yes') { ?>			
					<div class="twitter-entry">
						<?php the_excerpt(); ?>
					</div>
			
					<div class="post-twitter">			
						<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink();?>" data-text="<?php the_title(); ?>" data-count="vertical">Tweet</a>	
					</div>
			
			<?php } else { ?>
				
				<div class="entry">
					<?php the_excerpt(); ?>
				</div>
			
			<?php } ?>
			
			<?php } ?>
			
		</div>

	<?php endwhile; ?>

		<div class="navigation">
			<?php if (function_exists("pagination")) {
				pagination($additional_loop->max_num_pages);
		} ?>
		</div>
		
	<?php endif; ?>