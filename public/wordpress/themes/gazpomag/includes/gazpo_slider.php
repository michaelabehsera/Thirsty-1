<?php global $post;	?>

<div id="featured" >
		<ul class="ui-tabs-nav ui-tabs-selected">
			<?php query_posts( 'cat='.$gazpo_slider_category.'&posts_per_page=4' ); if( have_posts() ) : while( have_posts() ) : the_post(); ?>
	        <li class="ui-tabs-nav-item" id="nav-fragment-<?php echo $post->ID; ?>">
			<a href="#fragment-<?php echo $post->ID; ?>">
				<?php the_post_thumbnail( 'thumbnail', array('class' => 'slider_thumb') ); ?>			
				<span class="title">
						<?php $short_title = substr(the_title('','',FALSE),0,40);
						echo $short_title; if (strlen($short_title) >39){ echo '...'; } ?>	
				</span>
				<br />				
				<span class="date"><?php the_time('F j, Y'); ?></span>
			</a>
			</li>	
			<?php endwhile; endif;?>
			<?php wp_reset_query();?>			
	    </ul>
		
		<?php query_posts( 'cat='.$gazpo_slider_category.'&posts_per_page=4' ); if( have_posts() ) : while( have_posts() ) : the_post(); ?>
		<div id="fragment-<?php echo $post->ID; ?>" class="ui-tabs-panel ui-tabs-hide" style="">
			<?php the_post_thumbnail( 'large', array('class' => 'slider_image') ); ?>
			 <div class="info" >
				<h2> 
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
					<?php $short_title = substr(the_title('','',FALSE),0,35);
					echo $short_title; if (strlen($short_title) >34){ echo '...'; } ?>	
					</a>
				</h2>				
				<p>
				<?php 
					$content = get_the_content();
					$content = strip_tags($content);
					echo substr($content, 0, 150). '...';
				?>				
				</p>
			 </div>
	    </div>
		
			<?php endwhile; endif;?>
			<?php wp_reset_query();?>
		
</div>