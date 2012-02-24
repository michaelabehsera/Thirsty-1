<?php
/*
Template Name: Page with Left Sidebar
*/
?>
<?php get_header(); ?>

<!--MAIN CONTENT-->
<!--Sidebar-->
    <div id="left_sidebar"><?php get_sidebar(); ?>
<div id="content">
	<div id="posts">
        <!--Latest Posts-->
        <div id="single_posts">   
            <?php if(have_posts()): ?><?php while(have_posts()): ?><?php the_post(); ?>
            <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">            
            <div class="post_top"></div>
				<div class="post_mid">
                <div class="post_content_main">
                    <h2 class="postitle"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                    <?php the_content(); ?>
                    <?php wp_link_pages('<p class="pages"><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
                </div>
                
                </div>
    		<div class="post_bottom"><div class="edit"><?php edit_post_link(); ?></div></div>
			</div>
            <div class="comments_template"><?php comments_template('',true); ?></div>
				<?php endwhile ?>  
                <?php endif ?>

    </div>
        
    </div>
</div>

</div>

</div>
<!--Footer-->
<?php get_footer(); ?>