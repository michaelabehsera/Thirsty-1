<?php
/**
 * The template for displaying Search Results pages.
 */

get_header(); ?>

		<div id="container" class="<?php af_layout_class(); ?>">
			<div id="content" role="main">

<?php if ( have_posts() ) : ?>
				<header>
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'autofocus' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header>
				<?php
					/* Run the loop for the search to output the results. */
					$archive_layout = of_get_option($shortname . '_archive_layout');
					get_template_part( 'content', 'index' );
				
				?>
<?php else : ?>
				<article id="post-0" class="post no-results not-found">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'autofocus' ); ?></h1>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'autofocus' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
<?php endif; ?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
