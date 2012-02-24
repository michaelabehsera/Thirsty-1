<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

		<div id="container" class="<?php af_layout_class(); ?>">
			<div id="content" role="main">

<?php
	/* Queue the first post, that way we know
	 * what date we're dealing with (if that is the case).
	 *
	 * We reset this later so we can run the loop
	 * properly with a call to rewind_posts().
	 */
	if ( have_posts() )
		the_post();
?>
		<header>
			<h1 class="page-title">
<?php if ( is_day() ) : ?>
				<?php printf( __( 'Daily Archives: <span>%s</span>', 'autofocus' ), get_the_date() ); ?>
<?php elseif ( is_month() ) : ?>
				<?php printf( __( 'Monthly Archives: <span>%s</span>', 'autofocus' ), get_the_date('F Y') ); ?>
<?php elseif ( is_year() ) : ?>
				<?php printf( __( 'Yearly Archives: <span>%s</span>', 'autofocus' ), get_the_date('Y') ); ?>
<?php elseif ( is_category() ) : ?>
				<?php printf( __( 'Category Archives: %s', 'autofocus' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
<?php elseif ( is_tag() ) : ?>
				<?php printf( __( 'Tag Archives: %s', 'autofocus' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?>
<?php else : ?>
				<?php _e( 'Archives', 'autofocus' ); ?>
<?php endif; ?>
			</h1>

<?php if ( is_category() ) : ?>
				<?php
					$category_description = category_description();
					if ( ! empty( $category_description ) )
						echo '<div class="archive-meta">' . $category_description . '</div>';
				?>
<?php endif; ?>

		</header>

<?php
	/* Since we called the_post() above, we need to
	 * rewind the loop back to the beginning that way
	 * we can run the loop properly, in full.
	 */
	rewind_posts();

	/* Run the loop for the archives page to output the posts. */
	get_template_part( 'content', 'index' );

?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
