<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage AutoFocus_Two
 * @since AutoFocus 2.0
 */

get_header(); ?>

		<div id="container" class="<?php af_layout_class(); ?>">
			<div id="content" role="main">
			
			<?php 
			// Start the main loop 
		    global $paged, $more;
			$more = 0;
		    
			$temp = $wp_query;
			$wp_query = null;
			$wp_query = new WP_Query();
			$wp_query->query(array(
				'showposts' => get_option('posts_per_page'),
				'paged' => $paged
			)); 

			/* 
			 * Run the loop to output the autofocus loop.
			 * If you want to overload this in a child theme then include a file
			 * called loop-autofocus.php and that will be used instead.
			 */
			get_template_part( 'content', 'autofocus' );
			?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
