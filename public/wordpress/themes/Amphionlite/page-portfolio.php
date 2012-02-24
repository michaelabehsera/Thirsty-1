<?php
/*
Template Name: Portfolio Page
*/
?>
<?php get_header(); ?>

<!--MAIN CONTENT-->
<!--Sidebar-->
<div id="portfolio">
<div id="content">
	<div id="posts">
        <!--Latest Posts-->
        <div id="single_posts"> 
        <?php query_posts('category_name=portfolio'); ?>
            <?php if(have_posts()): ?><?php while(have_posts()): ?><?php the_post(); ?>
            <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">            
            <div class="post_top"></div>
				<div class="post_mid">
                <div class="post_content_main">
                <!--CALL TO POST IMAGE-->
               
            	<?php if ( has_post_thumbnail() ) { ?>
                <div class="amp_thumb"><?php the_post_thumbnail('medium'); ?></div>
            
                <?php } else { ?> 
                
                <div class="amp_thumb"><img src="<?php bloginfo('template_url'); ?>/images/portfolioimage_blank.png" alt="<?php the_title_attribute(); ?>" class="thumbnail"/>  </div>
                         
            	<?php } ?> 
                
                    <div class="portcontent">
					<h2 class="postitle"><a><?php the_title(); ?></a></h2>
					<?php the_content(); ?>
                    </div>
                    <?php wp_link_pages('<p class="pages"><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
                </div>
                
                </div>
    		<div class="post_bottom"><div class="edit"><?php edit_post_link(); ?></div></div>
			</div>
				<?php endwhile ?>  
                <?php endif ?>

    </div>
        
    </div>
</div>

</div>

</div>
<!--Footer-->
<?php get_footer(); ?>