<?php
/**
 * The template for displaying attachments.
 */

get_header(); ?>

		<div id="container" class="single-attachment">
			<div id="content" role="main">

<?php if ( have_posts() ) ?>

<?php if ( wp_attachment_is_image() ) : ?>
			<div id="nav-above" class="navigation">
				<div class="nav-previous" style="height:170px;"><span class="meta-nav"><?php previous_image_link( false, '&larr;' ) ?></span></div>
				<div class="nav-next" style="height:170px;"><span class="meta-nav"><?php next_image_link( false, '&rarr;' ) ?></span></div>
			</div>
<?php endif; ?>

<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php if ( wp_attachment_is_image() ) : ?>

						<div class="entry-image-container">
							<div class="entry-image">

							<?php
								// Pull the attachment image at the Image Display size 
								$af_img_display = of_get_option($shortname . '_image_display');
								echo wp_get_attachment_image( $post->ID, $af_img_display ); 
							?>
	
							</div><!-- .entry-image -->
							<div class="entry-caption"><?php if ( !empty( $post->post_excerpt ) ) the_excerpt(); ?></div>
							
						</div><!-- .entry-image-container -->
<?php else : ?>
						<div class="entry-attachment">
							<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
						</div><!-- .entry-attachment -->
<?php endif; ?>
						
					<header>
						<h2 class="entry-title"><?php the_title(); ?></h2>
						<?php af_posted_on(); ?>
					</header>

					<div class="entry-content">

					<?php if ( of_get_option($shortname . '_show_exif_data') == TRUE) { ?>
						<?php af_display_exif_data(); ?>
					<?php } ?>

<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'autofocus' ) ); ?>
<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'autofocus' ), 'after' => '</div>' ) ); ?>

					</div><!-- .entry-content -->

					<footer class="entry-utility">
						<?php af_post_meta(); ?>
						<?php
							if ( wp_attachment_is_image() ) {
								$metadata = wp_get_attachment_metadata();
								printf( __( '<span class="dimensions">Full size: %s</span>', 'autofocus'),
									sprintf( '<a href="%1$s" title="%2$s">%3$spx &times; %4$spx</a>',
										wp_get_attachment_url(),
										esc_attr( __('Link to full-size image', 'autofocus') ),
										$metadata['width'],
										$metadata['height']
									)
								);
							}
						?>
						<?php edit_post_link( __( 'Edit', 'autofocus' ), ' <span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-utility -->
				</article><!-- #post-## -->

			<div id="nav-below" class="navigation">
				<h3><a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php esc_attr( printf( __( 'Return to %s', 'autofocus' ), get_the_title( $post->post_parent ) ) ); ?>" rel="gallery"><?php _e('<span class="meta-nav">&#x21A9;</span> Back to Article', 'autofocus'); ?></a></h3>
			</div><!-- #nav-below -->

				<?php 
					// Only show the Comments Form if the parent post has comments open
					if ( comments_open($post->post_parent) ) {
						comments_template();
					} ?>

<?php endwhile; ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
