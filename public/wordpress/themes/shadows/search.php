<?php get_header(' '); ?>
	<div id="post-wrap">  
    	<div id="post-content"> 
		<?php if (have_posts()) : ?>
        	<div id="post-header">
				<h1 id="archive-title">Search Results For:</h1>
                <p>"<?php the_search_query(); ?>"</p>
            </div>
            <!-- END post-header -->

		<?php get_template_part( 'post' , 'entry') ?>
        
        <?php if (function_exists("pagination")) { pagination($additional_loop->max_num_pages); } ?>
        
		<?php else : ?>
        <div id="post-header">
			<h1 id="archive-title">Search Results For "<?php the_search_query(); ?>"</h1>
			<p>Sorry, nothing found for that search</p>
        </div>
        <!-- END post-header -->
		<?php endif; ?>
        </div>
		<!-- END post-content -->

<?php get_sidebar(' '); ?>      
			
            <div class="clear"></div>		
        	</div>
        	<!-- END post-wrap -->        
 <?php get_footer(' '); ?>