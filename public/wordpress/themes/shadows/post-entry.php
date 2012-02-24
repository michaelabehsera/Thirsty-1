<?php while (have_posts()) : the_post(); ?>      

    <div class="post-entry clearfix">
        <?php if ( has_post_thumbnail() ) {  ?>
        
        <div class="post-entry-featured-image">
			<a href="<?php the_permalink(' ') ?>" title="<?php the_title(); ?>" class="opacity"><?php the_post_thumbnail('shadows-post-image'); ?></a>
        </div>
        <!-- END post-entry-featured-image -->
        
    <div class="post-entry-content">
        	<h2><a href="<?php the_permalink(' ') ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
       			<div class="post-entry-date">Posted on <?php the_time('F Y') ?> with <?php comments_popup_link('0 Comments', '1 Comment', '% Comments'); ?></div>
					<?php the_excerpt(); ?>
					<a href="<?php the_permalink(' ') ?>" class="post-entry-read-more" title="<?php the_title(); ?>">Read More →</a>
        </div><!-- END post-entry-content -->

      
   <?php } else{ ?>
   
   	 <h2><a href="<?php the_permalink(' ') ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<div class="post-entry-date">Posted on <?php the_time('F Y') ?></div>
			<?php the_excerpt(); ?>
			<a href="<?php the_permalink(' ') ?>" class="post-entry-read-more" title="<?php the_title(); ?>">Read More →</a>
   <?php } ?>
        
 	</div>
	<!-- END post-entry -->

<?php endwhile; ?>
