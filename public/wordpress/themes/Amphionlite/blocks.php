<?php $option =  get_option('amp_options'); ?>
<div id="blocks">
<div class="block_frst">
        <!--BLOCK 1-->
        <div class="block_odd">  
            <?php $sliders = new WP_Query(); 
			$ampid = get_cat_ID(  $option['amp_block1']  );
            $sliders->query('ignore_sticky_posts=1&cat='. $ampid .'&showposts=1');
            while ($sliders->have_posts()) : $sliders->the_post(); ?>        
            
            <?php $category_id = get_cat_ID(  $option['amp_block1']  );
    $category_link = get_category_link( $category_id );?>
            <div class="block_top"><div class="block_cat"><a href="<?php echo $category_link; ?>" title="<?php echo $option['amp_block1'] ?>"><?php echo $option['amp_block1'] ?></a></div></div>
                    
				<div class="block_mid">
                <!--CALL TO POST IMAGE-->
                <?php $cti = amphion_lite_catch_that_image();?>
            	<?php if ( has_post_thumbnail() ) : ?>
                <div class="imgwrap"><div class="block_comm"><?php if (!empty($post->post_password)) { ?>
        	<?php } else { ?><div class="comments"><?php comments_popup_link('0', '1', '%', '', __('Off')); ?></div><?php } ?></div><?php the_post_thumbnail('medium'); ?></div>
                
				<?php elseif(isset($cti)): ?>

            	<div class="imgwrap"><div class="block_comm"><?php if (!empty($post->post_password)) { ?>
        	<?php } else { ?><div class="comments"><?php comments_popup_link('0', '1', '%', '', __('Off')); ?></div><?php } ?></div>
			<img src="<?php bloginfo('url'); ?><?php echo $cti; ?>" alt="Link to <?php the_title(); ?>" class="thumbnail"/></div>
            
                <?php else : ?>
                
                <div class="imgwrap"><div class="block_comm"><?php if (!empty($post->post_password)) { ?>
        	<?php } else { ?><div class="comments"><?php comments_popup_link('0', '1', '%', '', __('Off')); ?></div><?php } ?></div><img src="<?php bloginfo('template_url'); ?>/images/blank_img.png" alt="<?php the_title_attribute(); ?>" class="thumbnail"/></div>   
                         
            	<?php endif; ?> 
                
                
                 
                <div class="post_content">
                    <h2 class="postitle"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                    <?php amphion_lite_wpe_excerpt('wpe_excerptlength_index', 'wpe_excerptmore'); ?>
                </div>
                </div>
                <div class="block_bottom"></div>
                 <?php endwhile ?>


</div>

        <!--BLOCK 2-->
        <div class="block_even">    
            <?php $sliders = new WP_Query(); 
			$ampid = get_cat_ID(  $option['amp_block2']  );
            $sliders->query('ignore_sticky_posts=1&cat='. $ampid .'&showposts=1');
            while ($sliders->have_posts()) : $sliders->the_post(); ?>      
            
            <?php $category_id = get_cat_ID(  $option['amp_block2']  );
    $category_link = get_category_link( $category_id );?>
            <div class="block_top"><div class="block_cat"><a href="<?php echo $category_link; ?>" title="<?php echo $option['amp_block2'] ?>"><?php echo $option['amp_block2'] ?></a></div></div>
                    
				<div class="block_mid">
                <!--CALL TO POST IMAGE-->
                <?php $cti = amphion_lite_catch_that_image();?>
            	<?php if ( has_post_thumbnail() ) : ?>
                <div class="imgwrap"><div class="block_comm"><?php if (!empty($post->post_password)) { ?>
        	<?php } else { ?><div class="comments"><?php comments_popup_link('0', '1', '%', '', __('Off')); ?></div><?php } ?></div><?php the_post_thumbnail('medium'); ?></div>
                
				<?php elseif(isset($cti)): ?>

            	<div class="imgwrap"><div class="block_comm"><?php if (!empty($post->post_password)) { ?>
        	<?php } else { ?><div class="comments"><?php comments_popup_link('0', '1', '%', '', __('Off')); ?></div><?php } ?></div>
			<img src="<?php bloginfo('url'); ?><?php echo $cti; ?>" alt="Link to <?php the_title(); ?>" class="thumbnail"/></div>
            
                <?php else : ?>
                
                <div class="imgwrap"><div class="block_comm"><?php if (!empty($post->post_password)) { ?>
        	<?php } else { ?><div class="comments"><?php comments_popup_link('0', '1', '%', '', __('Off')); ?></div><?php } ?></div><img src="<?php bloginfo('template_url'); ?>/images/blank_img.png" alt="<?php the_title_attribute(); ?>" class="thumbnail"/></div>   
                         
            	<?php endif; ?>  
                 
                <div class="post_content">
                    <h2 class="postitle"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                    <?php amphion_lite_wpe_excerpt('wpe_excerptlength_index', 'wpe_excerptmore'); ?>
                </div>
                </div>
                <div class="block_bottom"></div>
                 <?php endwhile ?>

</div>
</div>
        <!--BLOCK 3-->
<div class="blocks_sec">
        <div class="sec_block_odd">   
            <?php $sliders = new WP_Query(); 
			$ampid = get_cat_ID(  $option['amp_block3']  );
            $sliders->query('ignore_sticky_posts=1&cat='. $ampid .'&showposts=1');
            while ($sliders->have_posts()) : $sliders->the_post(); ?>      
            
            <?php $category_id = get_cat_ID(  $option['amp_block3']  );
    $category_link = get_category_link( $category_id );?>
            <div class="block_top"><div class="block_cat"><a href="<?php echo $category_link; ?>" title="<?php echo $option['amp_block3'] ?>"><?php echo $option['amp_block3'] ?></a></div></div>
                    
				<div class="block_mid">
                <!--CALL TO POST IMAGE-->
                <?php $cti = amphion_lite_catch_that_image();?>
            	<?php if ( has_post_thumbnail() ) : ?>
                <div class="imgwrap"><div class="block_comm"><?php if (!empty($post->post_password)) { ?>
        	<?php } else { ?><div class="comments"><?php comments_popup_link('0', '1', '%', '', __('Off')); ?></div><?php } ?></div><?php the_post_thumbnail('medium'); ?></div>
                
				<?php elseif(isset($cti)): ?>

            	<div class="imgwrap"><div class="block_comm"><?php if (!empty($post->post_password)) { ?>
        	<?php } else { ?><div class="comments"><?php comments_popup_link('0', '1', '%', '', __('Off')); ?></div><?php } ?></div>
			<img src="<?php bloginfo('url'); ?><?php echo $cti; ?>" alt="Link to <?php the_title(); ?>" class="thumbnail"/></div>
            
                <?php else : ?>
                
                <div class="imgwrap"><div class="block_comm"><?php if (!empty($post->post_password)) { ?>
        	<?php } else { ?><div class="comments"><?php comments_popup_link('0', '1', '%', '', __('Off')); ?></div><?php } ?></div><img src="<?php bloginfo('template_url'); ?>/images/blank_img.png" alt="<?php the_title_attribute(); ?>" class="thumbnail"/></div>   
                         
            	<?php endif; ?> 
                 
                <div class="post_content">
                    <h2 class="postitle"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                    <?php amphion_lite_wpe_excerpt('wpe_excerptlength_index', 'wpe_excerptmore'); ?>
                </div>
                </div>
                <div class="block_bottom"></div>
				 <?php endwhile ?>

</div>

        <!--BLOCK 4-->
        <div class="sec_block_even">    
            <?php $sliders = new WP_Query(); 
			$ampid = get_cat_ID(  $option['amp_block4']  );
            $sliders->query('ignore_sticky_posts=1&cat='. $ampid .'&showposts=1');
            while ($sliders->have_posts()) : $sliders->the_post(); ?>      
            
            <?php $category_id = get_cat_ID(  $option['amp_block4']  );
    $category_link = get_category_link( $category_id );?>
            <div class="block_top"><div class="block_cat"><a href="<?php echo $category_link; ?>" title="<?php echo $option['amp_block4'] ?>"><?php echo $option['amp_block4'] ?></a></div></div>
            
				<div class="block_mid">
                <!--CALL TO POST IMAGE-->
                <?php $cti = amphion_lite_catch_that_image();?>
            	<?php if ( has_post_thumbnail() ) : ?>
                <div class="imgwrap"><div class="block_comm"><?php if (!empty($post->post_password)) { ?>
        	<?php } else { ?><div class="comments"><?php comments_popup_link('0', '1', '%', '', __('Off')); ?></div><?php } ?></div><?php the_post_thumbnail('medium'); ?></div>
                
				<?php elseif(isset($cti)): ?>

            	<div class="imgwrap"><div class="block_comm"><?php if (!empty($post->post_password)) { ?>
        	<?php } else { ?><div class="comments"><?php comments_popup_link('0', '1', '%', '', __('Off')); ?></div><?php } ?></div>
			<img src="<?php bloginfo('url'); ?><?php echo $cti; ?>" alt="Link to <?php the_title(); ?>" class="thumbnail"/></div>
            
                <?php else : ?>
                
                <div class="imgwrap"><div class="block_comm"><?php if (!empty($post->post_password)) { ?>
        	<?php } else { ?><div class="comments"><?php comments_popup_link('0', '1', '%', '', __('Off')); ?></div><?php } ?></div><img src="<?php bloginfo('template_url'); ?>/images/blank_img.png" alt="<?php the_title_attribute(); ?>" class="thumbnail"/></div>   
                         
            	<?php endif; ?>  
                 
                <div class="post_content">
                    <h2 class="postitle"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                    <?php amphion_lite_wpe_excerpt('wpe_excerptlength_index', 'wpe_excerptmore'); ?>
                </div>
                </div>
                <div class="block_bottom"></div>
                 <?php endwhile ?>

</div>
</div>
        </div>