<?php get_header(); ?>

<article class="article">

  <?php if ( have_posts() ) : ?>

  <?php $post = $posts[0]; ?>
    <?php if (is_category()) { ?>
      <h3 class="pagetitle"><?php _e('Archive of',zhng); ?> &#8216;<?php single_cat_title(); ?>&#8217; <?php _e('category',zhng); ?></h3>
    <?php } elseif( is_tag() ) { ?>
      <h3 class="pagetitle"><?php _e('Posts Tagged',zhng); ?> &#8216;<?php single_tag_title(); ?>&#8217;</h3>
    <?php } elseif (is_day()) { ?>
      <h3 class="pagetitle"><?php the_time('F jS Y'); ?> <?php _e('archive',zhng); ?></h3>
    <?php } elseif (is_month()) { ?>
      <h3 class="pagetitle"><?php the_time('F Y'); ?> <?php _e('archive',zhng); ?></h3>
    <?php } elseif (is_year()) { ?>
      <h3 class="pagetitle"><?php the_time('Y'); ?> archive</h3>
    <?php } elseif (is_author()) { ?>
      <h3 class="pagetitle"><?php _e('Author Archive',zhng); ?></h3>
    <?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    <h3 class="pagetitle"><?php _e('Blog Archives',zhng); ?></h3>
  <?php } ?>

  <?php while (have_posts()) : the_post(); ?>
    <?php get_template_part( 'loop'); ?>
  <?php endwhile; ?>

  <?php get_pagination(); ?>

  <?php else : include('none.php'); endif; ?>

</article><!-- END Article -->

<?php get_footer(); ?>