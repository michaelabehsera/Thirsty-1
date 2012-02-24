<?php get_header(); ?>

<div id="heading">
	<?php if ( have_posts() ) 	the_post(); ?>
	<h1><?php _e('Error 404 - Nothing Found', 'wpzoom'); ?></h1>
</div>
<div class="clear"></div>

<div id="content">

	<div class="post">
 		<h2><?php _e('The page you are looking for could not be found.', 'wpzoom');?> </h2>
 	</div><!-- / .post_content -->

</div><!-- / #content -->
 
<?php get_footer(); ?>