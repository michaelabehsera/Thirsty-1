<?php get_header(); ?>
<?php include( TEMPLATEPATH . '/includes/get_options.php' );?>

<div id="content">

	<?php if ($gazpo_slider_show == 'Yes' && is_home()&& $paged < 2 ) { include(TEMPLATEPATH . '/includes/gazpo_slider.php'); } ?>
	<?php if ($gazpo_feat_cat_show == 'Yes' && is_home()&& $paged < 2 ) { include(TEMPLATEPATH . '/includes/gazpo_feat_cats.php'); } ?>
	<?php include(TEMPLATEPATH . '/includes/gazpo_loop.php');  ?>	

</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

