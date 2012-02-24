<?php get_header(); ?>
<?php $option =  get_option('amp_options'); ?>
<!--MAIN CONTENT-->
<div id="content">
	<div id="posts">
    
            <!--Slider-->
		<?php
		if ( is_home() ) { ?>

			        <div id="slidewrapper"><?php if($option["amp_ribbon"] == "1"){ ?><?php } else { ?><div id="ribbon"></div><?php } ?>
                    <?php get_template_part( 'easyslider' ); ?>                 
                    </div>
        <!--Post BLocks-->
		<?php if($option["amp_hide_blocks"] == "1"){ ?><?php } else { ?><?php get_template_part( 'blocks' ); ?><?php } ?>
		<?php } else { ?>
		<?php } ?>

    
        <!--Latest Posts-->
        <?php if($option["amp_content"] == "1"){ ?><div id="latest_posts_full">   <?php } else { ?><div id="latest_posts"><?php } ?>
            <?php if(have_posts()): ?><?php while(have_posts()): ?><?php the_post(); ?>
            <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">            
            <div class="post_top"><?php if (!empty($post->post_password)) { ?>
        	<?php } else { ?><div class="comments"><?php comments_popup_link('0', '1', '%', '', __('Off')); ?></div><?php } ?></div>
				<div class="post_mid">

                <?php if($option["amp_content"] == "1"){ ?>
                 <?php } else { ?>

                    <!--CALL TO POST IMAGE-->
                    <?php $cti = amphion_lite_catch_that_image();?>
                    <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail('medium'); ?>
                    
                    <?php elseif(isset($cti)): ?>
                    <img src="<?php bloginfo('url'); ?><?php echo $cti; ?>" alt="Link to <?php the_title(); ?>" class="thumbnail"/>
                
                    <?php else : ?>
                    <div class="imgframe"></div>
                             
                    <?php endif; ?>
                     
                 <?php } ?>
                 
                <div class="post_content_main">
                    <h2 class="postitle"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                    <!--MAIN CONTENT-->
					<?php if($option["amp_content"] == "1"){ ?>
                     <?php the_content() ;?>
                    <?php } else { ?>
                    <?php amphion_lite_wpe_excerpt('wpe_excerptlength_teaser', 'wpe_excerptmore'); ?>
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