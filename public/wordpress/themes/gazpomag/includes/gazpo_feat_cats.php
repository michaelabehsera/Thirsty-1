<div id ="featured-cat">
	
	<!-- gazpo featured category 1 -->
	<?php $my_query = new WP_Query('cat='. $gazpo_feat_cat_1.'&showposts=1'); ?>
	<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>	
	<div class="box margin-right">
		<h4 class="cat-title"><a title="asas" href="<?php echo get_category_link($gazpo_feat_cat_1); ?>"><? echo get_cat_name($gazpo_feat_cat_1);?></a></h4>
		<div class="thumb">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'medium', array('class' => 'thumb') ); ?>
				<span class="date"><?php the_time('F jS, Y') ?></span>
		</a>
		</div>
		<div class="details">
			<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
			<p> <? $content = get_the_content(); $content = strip_tags($content); echo substr($content, 0, 150). '...';	?></p>		
				<!--
				<div class="meta">
					<span class="comments"><?php //comments_popup_link('No Comments','One Comment','% Comments'); ?></span>
				</div>	
				-->
		</div>
	</div>
	<?php endwhile; ?>
	
	<!-- gazpo featured category 2 -->
	<?php $my_query = new WP_Query('cat='. $gazpo_feat_cat_2.'&showposts=1'); ?>
	<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>	
	<div class="box margin-right"> 
		<h4 class="cat-title"><a title="asas" href="<?php echo get_category_link($gazpo_feat_cat_2); ?>"><? echo get_cat_name($gazpo_feat_cat_2);?></a></h4>
		<div class="thumb">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'medium', array('class' => 'thumb') ); ?>
				<span class="date"><?php the_time('F jS, Y') ?></span>
		</a>
		</div>
		<div class="details">
			<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
			<p> <? $content = get_the_content(); $content = strip_tags($content); echo substr($content, 0, 150). '...';	?></p>		
				<!--<div class="meta">
					<span class="comments"><?php //comments_popup_link('No Comments','One Comment','% Comments'); ?></span>
				</div>	-->	
		</div>
	</div>
	<?php endwhile; ?>
	
	<!-- gazpo featured category 3 -->
	<?php $my_query = new WP_Query('cat='. $gazpo_feat_cat_3.'&showposts=1'); ?>
	<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>	
	<div class="box">
		<h4 class="cat-title"><a title="asas" href="<?php echo get_category_link($gazpo_feat_cat_3); ?>"><? echo get_cat_name($gazpo_feat_cat_3);?></a></h4>
		<div class="thumb">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'medium', array('class' => 'thumb') ); ?>
				<span class="date"><?php the_time('F jS, Y') ?></span>
		</a>
		</div>
		<div class="details">
			<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
			<p> <? $content = get_the_content(); $content = strip_tags($content); echo substr($content, 0, 150). '...';	?></p>		
		</div>
	</div>
	<?php endwhile; ?>


	</div>