<?php
/**
 * The loop that displays images in the AutoFocus format.
 */
?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<nav id="nav-above" class="navigation">
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span>', 'autofocus' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( '<span class="meta-nav">&rarr;</span>', 'autofocus' ) ); ?></div>
	</nav><!-- #nav-above -->
<?php endif; ?>

	<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

	<?php 
	
	/* How to display Blog posts and Pages */
	if ( 'page' == get_post_type() ) { ?>
	
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php af_posted_on(); ?>
			</header>

			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->

			<?php edit_post_link( __( 'Edit', 'autofocus' ), '<footer class="entry-utility"><span class="edit-link">', '</span></footer><!-- .entry-utility -->' ); ?>			

		</article><!-- #post-## -->	
	
	<?php 
	
	/* How to display any other posts */
	} else { ?>
	
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php af_posted_on(); ?>
			</header>
	
			<?php af_entry_image('front-page-thumbnail'); ?>
	
			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->
	
			<?php edit_post_link( __( 'Edit', 'autofocus' ), '<footer class="entry-utility"><span class="edit-link">', '</span></footer><!-- .entry-utility -->' ); ?>			
		</article><!-- #post-## -->

	<?php }
	
	endwhile; // end of the loop. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<nav id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'autofocus' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'autofocus' ) ); ?></div>
				</nav><!-- #nav-below -->
<?php endif; ?>
