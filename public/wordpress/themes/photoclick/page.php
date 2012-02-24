<?php get_header(); ?>

<article class="article">

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <section class="section">
    <div class="post-text"><h2 class="post-title"><?php the_title(); ?></h2></div>
    <?php the_content(); ?>
  <div class="clearfix">&nbsp;</div>
  </section><!-- END Section -->
  <?php endwhile; endif; ?>

</article><!-- END Article -->

<?php get_footer(); ?>