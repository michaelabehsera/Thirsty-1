<?php
/**
 * The loop that displays posts.
 */

global $posts, $shortname;

?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<nav id="nav-above" class="navigation">
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span>', 'autofocus' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( '<span class="meta-nav">&rarr;</span>', 'autofocus' ) ); ?></div>
	</nav><!-- #nav-above -->
<?php endif; ?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<article id="post-0" class="post error404 not-found">
		<header>
			<h1 class="entry-title"><?php _e( 'Not Found', 'autofocus' ); ?></h1>
		</header>

		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'autofocus' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-0 -->
<?php endif; ?>

<?php /* Start the Loop. */ ?>

<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php af_entry_image('archive-thumbnail'); ?>

		<header>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php af_posted_on(); ?>
		</header>

		<footer class="entry-utility">
			<?php af_post_meta(); ?>

			<?php comments_popup_link( '<span class="comments-link">' . __( 'Leave a comment', 'autofocus' ) . '</span>', '<span class="comments-link">' . __( '1 Comment', 'autofocus' ) . '</span>', '<span class="comments-link">' . __( '% Comments', 'autofocus' ) . '</span>', '', '' ); ?>

			<?php edit_post_link( __( 'Edit', 'autofocus' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-utility -->

		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div><!-- .entry-content -->

	</article><!-- #post-## -->

<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<nav id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'autofocus' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'autofocus' ) ); ?></div>
				</nav><!-- #nav-below -->
<?php endif; ?>
