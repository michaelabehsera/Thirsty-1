<?php get_header(); ?>

<div id="casing">
<div class="incasing">

<div class="topbar">
<div class="subhead">

		<?php if (have_posts()) : ?>

		 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
		<h1 class="pagetitle">Archive for the &#8216;<?php echo single_cat_title(); ?>&#8217; Category</h1>

 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h1 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h1>

	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h1 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h1>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h1 class="pagetitle">Archive for <?php the_time('Y'); ?></h1>

	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h1 class="pagetitle">Author Archive</h1>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h1 class="pagetitle">Blog Archives</h1>

		<?php } ?>


</div>

<?php include (TEMPLATEPATH . '/searchform.php'); ?>

</div>

<div id="content" >

<?php while (have_posts()) : the_post(); ?>
		
<div class="post" id="post-<?php the_ID(); ?>">

<div class="title">
	<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
</div>
<div class="postmeta">
	<span class="author">Posted by <?php the_author(); ?> </span> <span class="clock">  <?php the_time('M - j - Y'); ?></span> <span class="comm"><?php comments_popup_link('0 Comment', '1 Comment', '% Comments'); ?></span>
</div>

<div class="entry">

<?php
if ( has_post_thumbnail() ) { ?>
	<a href="<?php the_permalink() ?>"><img class="postimg" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&amp;h=200&amp;w=470&amp;zc=1" alt=""/></a>
<?php } else { ?>
	<a href="<?php the_permalink() ?>"><img class="postimg" src="<?php bloginfo('template_directory'); ?>/images/dummy.png" alt="" /></a>
<?php } ?>
<?php the_excerpt(); ?>
<div class="clear"></div>
</div>

<div class="singleinfo">
<span class="category">Categories: <?php the_category(', '); ?> </span>
</div>

</div>
<?php endwhile; ?>

<div class="clear"></div>
<?php getpagenavi(); ?>

<?php else : ?>

	<h1 class="title">Not Found</h1>
	<p>Sorry, but you are looking for something that isn't here.</p>

<?php endif; ?>
</div>

<?php get_sidebar(); ?>

<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
<?php get_footer(); ?>