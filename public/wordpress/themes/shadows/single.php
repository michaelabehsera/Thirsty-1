<?php
	// load the theme options
	$options = get_option( 'shadows_theme_settings' ); 
?>
<?php get_header(); ?>
    
<div id="post-wrap">    

	<div id="post-content">
    	<div id="single-wrap">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
        <h1><?php the_title(); ?></h1>
        
        <div class="post-entry-meta">Posted by <?php the_author(); ?> on <?php the_time('F jS, Y') ?> in <?php the_category(' , '); ?>
        <?php if ($options['disable_single_social'] != true) { ?>
                <div class="social clearfix">
        			<div class="tweet-this">
        				<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-related="WPExplorer">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
            		</div>
                    <!-- END tweet-this -->
            	<div class="facebook-like">
           			<iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink(' ') ?>&amp;send=false&amp;layout=button_count&amp;width=85&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:85px; height:21px;" allowTransparency="true"></iframe>
            	</div>
                <!-- END facebook-like -->
        </div>
        <!-- END Social -->
        <?php } ?>
        </div>
        <!-- END post-entry-meta -->
        <?php if ( has_post_thumbnail() ) { ?>
        <?php if ($options['disable_single_image'] != true) { ?>
        	<div id="single-featured-image">
        		<?php the_post_thumbnail('shadows-single-image'); ?>
            </div><!-- END single-featured-image -->
        <?php } } ?>
		<?php the_content(); ?>
		<?php endwhile; ?>
		<?php endif; ?>	
        
        <?php wp_link_pages('before=<div id="post-page-navigation">&after=</div>'); ?>
        
        
        <?php the_tags('<div id="post-tags"><span>Tagged as: </span>', '  •  ', '</div>'); ?>
        
		<?php if ($options['disable_author'] != true) { ?>
        
         <div id="post-author" class="clearfix">
            	
                <div id="author-avatar">
					<?php echo get_avatar( get_the_author_email(), '50' ); ?>
                </div><!-- END author-avatar -->
                
                <div id="author-description">
                	<h4>About The Author</h4>
					<?php the_author_description(); ?>
                </div><!-- END author-description -->
       	</div><!-- END post-author -->
        
        <?php } ?>
        
		<?php if ($options['disable_related_posts'] != true) { ?>
        
        <div id="related-posts" class="clearfix">
		<h3>Related Posts</h3>
			<ul>
				<?php
    			foreach(get_the_category() as $category){ $cat = $category->cat_ID; }
					query_posts('cat=' . $cat . '&orderby=rand&showposts=3');
					while (have_posts()) : the_post();
				?>
                <?php if ( has_post_thumbnail() ) { ?>
                <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="opacity">
				<li>
					<div class="related-posts-thumbnail">
   	     				<?php the_post_thumbnail('shadows-related-image'); ?>
           			</div><!-- /related-posts-thumbnail -->
                     <h4><?php the_title(); ?></h4>  
				</li>
                </a>
                <?php } ?>
			<?php endwhile; wp_reset_query(); ?>
		</ul>
	</div><!-- END related-posts -->
    <div class="clear"></div>
    
    <?php } ?>
                
	<?php comments_template(); ?>  
    
    </div>
	<!-- END single-wrap -->
                
	</div>
	<!-- END post-content -->
            
<?php get_sidebar(); ?>      
			
	<div class="clear"></div>		
</div>
<!-- END post-wrap -->
            
<?php get_footer(); ?>