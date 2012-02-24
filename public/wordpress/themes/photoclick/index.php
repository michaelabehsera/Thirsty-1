<?php get_header() ?>

<article class="article">

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php get_template_part('loop'); ?>
  <?php endwhile; ?>

  <?php get_pagination(); ?>

  <?php else : include('none.php'); endif; ?>

</article><!-- END Article -->

<?php get_footer(); ?>