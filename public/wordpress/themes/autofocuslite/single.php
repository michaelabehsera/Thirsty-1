<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<?php 
					// AutoFocus Nav Above (See: functions.php)
					autofocus_nav_above(); 
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php 
						global $posts, $shortname;
						// Grab The Blog Category
						$af_img_display = of_get_option($shortname . '_image_display');

						// Show the AutoFocus Entry Image (See: functions.php)
						af_single_entry_image($af_img_display, '10'); 

					?>

					<header>
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<?php af_posted_on(); ?>
					</header>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'autofocus' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-utility">
						<p class="entry-meta">
							<?php af_post_meta(); ?>

							<?php comments_popup_link( '<span class="comments-link">' . __( 'Leave a comment', 'autofocus' ) . '</span>', '<span class="comments-link">' . __( '1 Comment', 'autofocus' ) . '</span>', '<span class="comments-link">' . __( '% Comments', 'autofocus' ) . '</span>', '', '' ); ?>

							<?php if ( of_get_option($shortname . '_show_exif_data') == TRUE && has_post_thumbnail() && ( get_post_meta($post->ID, 'videoembed_value', true) == '' )) { ?>
								<span class="exif-data"><a href="<?php echo af_exif_link(); ?>#exif-data" title="<?php echo esc_attr__( 'View EXIF data', 'autofocus' ) ?>"><?php _e('View EXIF Data', 'autofocus') ?></a>.</span>
							<?php } ?>

							<?php edit_post_link( __( 'Edit', 'autofocus' ), '<span class="edit-link">', '</span>' ); ?>
						</p><!-- .entry-meta -->
						<?php get_sidebar(); ?>
					</footer><!-- .entry-utility -->

				</article><!-- #post-## -->

				<?php 
					// AutoFocus Nav Below (See: functions.php)
					autofocus_nav_below(); ?>

				<?php 
					// Only show the Comments Form if the post has comments open
					if ( comments_open() || get_comments_number() != '0' ) {
						comments_template( '', true ); 
					}
				?>

<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
