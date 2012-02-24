<?php get_header(' '); ?>
<div id="post-wrap">
	<div id="post-content">
<?php if ($options['disable_feat_posts'] != true) { ?>
<?php $featcat = $options['feat_posts']; ?>

<div id="feat-posts-wrap">
<div id="feat-posts" class="clearfix">   
 <?php query_posts(array(
 	'category_name' => ' '. $featcat .' ',
	'posts_per_page' => 4
	)); 
?>               
     <?php while (have_posts()) : the_post(); ?>   
      <?php if ( has_post_thumbnail() ) { ?>
     	<li>
     	<a href="<?php the_permalink(' ') ?>" title="<?php the_title(); ?>" class="opacity"><?php the_post_thumbnail('shadows-featured-image'); ?> 
        <h2><?php the_title(); ?></h2>
        </a>
   	   </li>
       <?php } ?>
       <?php endwhile; ?>
	</ul>
</div>
<!-- END feat-posts -->
</div>
<!-- END feat-posts-wrap -->
<?php } wp_reset_query(); ?>
            <?php query_posts( array( 'paged'=>$paged ) ); ?>
            <?php if (have_posts()) : ?>                
            <?php get_template_part( 'post' , 'entry') ?>                	
			<?php endif; ?>   
            
            <?php if (function_exists("pagination")) { pagination($additional_loop->max_num_pages); } ?>
            </div>
			<!-- END post-content -->

<?php get_sidebar(' '); ?>      
			
            <div class="clear"></div>		
        	</div>
        	<!-- END post-wrap -->        
 <?php get_footer(' '); ?>