<?php get_header(); ?>
<?php $option =  get_option('amp_options'); ?>
<!--MAIN CONTENT-->
<div id="content">
	<div id="posts">
        <!--Single Post-->
        <div id="single_posts">   
            <?php if(have_posts()): ?><?php while(have_posts()): ?><?php the_post(); ?>
            <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">            
            <div class="post_top"><?php if (!empty($post->post_password)) { ?>
        	<?php } else { ?><div class="comments"><?php comments_popup_link('0', '1', '%', '', __('Off')); ?></div><?php } ?></div>
				<div class="post_mid">
                <div class="post_content_main">
                    <h2 class="postitle"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                    <div class="single_metainfo">by <?php the_author(); ?> on <?php the_date(); ?></div>
                    <?php the_content(); ?>
                    <?php wp_link_pages('<p class="pages"><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
                </div>
                    <div class="post_meta">
                    <div class="category_meta"><?php the_category(', '); ?></div>
                    <div class="tag_meta"><?php the_tags(', '); ?></div>
                    </div>
                
                </div>
    		<div class="post_bottom"><div class="edit"><?php edit_post_link(); ?></div></div>
            	<!--SOCIAL LINKS-->
				<?php if($option["amp_hide_share"] == "1"){ ?>
        		<?php } else { ?>
                <div class="social_links">
				<?php get_template_part( 'social' ); ?>
                  </div>
				<?php } ?>
			</div>
            <div class="comments_template"><?php comments_template('',true); ?></div>
				<?php endwhile ?>   
                <?php endif ?>

    </div>
 
    </div>
    
    <!--Sidebar-->
    <?php get_sidebar(); ?>

</div>
</div>
<!--Footer-->
<?php get_footer(); ?>