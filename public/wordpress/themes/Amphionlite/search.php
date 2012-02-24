<?php get_header(); ?>
<?php $option =  get_option('amp_options'); ?>
<!--MAIN CONTENT-->
<div id="content">
	<div id="posts">
    <!--SEARCH-->
    <div id="single_posts"> 
                <div class="post_top"></div><div class="post_mid"><h2 class="postsearch"><?php printf( __( 'Search Results for: %s' ), '<span>' . esc_html( get_search_query() ) . '</span>'); ?></h2>
            <a class="search_count"><?php _e('Total posts found for', 'amphion_lite'); ?> <?php /* Search Count */ $allsearch = &new WP_Query("s=$s&showposts=-1"); $key = esc_html($s, 1); $count = $allsearch->post_count; _e(''); _e('<span class="search-terms">"'); echo $key; _e('"</span>'); _e(' — '); echo $count . ''; wp_reset_query(); ?></a>
            <a class="search_try"><?php _e('Try another search', 'amphion_lite'); ?></a><?php get_search_form(); ?></div>
            <div class="post_bottom"></div>
     </div>
            
        <!--Latest Posts-->
        <div id="latest_posts">   
            <?php if(have_posts()): ?><?php while(have_posts()): ?><?php the_post(); ?>
            <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">            
            <div class="post_top"><?php if (!empty($post->post_password)) { ?>
        	<?php } else { ?><div class="comments"><?php comments_popup_link('0', '1', '%', '', __('Off')); ?></div><?php } ?></div>
				<div class="post_mid">

                    <!--CALL TO POST IMAGE-->
                    <?php $cti = amphion_lite_catch_that_image();?>
                    <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail('medium'); ?>
                    
                    
                    <?php elseif(isset($cti)): ?>
                    <img src="<?php bloginfo('url'); ?><?php echo $cti; ?>" alt="Link to <?php the_title(); ?>" class="thumbnail"/>
                
                    <?php else : ?>
                    <img src="<?php bloginfo('template_url'); ?>/images/blank_img.png" alt="<?php the_title_attribute(); ?>" class="thumbnail"/>
                             
                    <?php endif; ?>
                 
                <div class="post_content_main">
                    <h2 class="postitle"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                    <!--MAIN CONTENT-->
					<?php if($option["amp_content"] == "1"){ ?>
                     <?php the_content() ;?>
                    <?php } else { ?>
                    <?php the_excerpt() ;?>
                    <?php } ?>
                    <?php wp_link_pages('<p class="pages"><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
                </div>
                    <div class="post_meta">
                    <div class="author"><?php the_author(); ?></div>
                    <div class="date_meta"><?php the_time( get_option('date_format') ); ?></div>
                    <div class="category_meta"><?php the_category(', '); ?></div>
                    </div>
                
                </div>
    		<div class="post_bottom"><div class="edit"><?php edit_post_link(); ?></div></div>
			</div>
				<?php endwhile ?>
				<?php if (function_exists("amphion_lite_paginate")) {
                    amphion_lite_paginate();
                } ?>  
                <?php endif ?>

    </div>
        
    </div>
    
    <!--Sidebar-->
    <?php get_sidebar(); ?>

</div>

</div>
<!--Footer-->
<?php get_footer(); ?>