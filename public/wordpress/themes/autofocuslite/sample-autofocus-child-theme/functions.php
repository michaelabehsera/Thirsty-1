<?php
/**
 * Sample High Art Child Theme functions and definitions
 *
 *
 *
 * ...Start editing below... */ 

/* 
 *	Change the Post Meta so it only shows The Author and the Category
 */

function af_post_meta() {

	printf( __( '<span class="%1$s">Written by: %2$s</span>', 'autofocus' ),
		'entry-author',
		sprintf( '<a class="author vcard url fn n" href="%1$s" title="%2$s">%3$s</a>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'autofocus' ), get_the_author() ),
			get_the_author()
		)
	);

	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( '<span class="entry-cats">Filed under %1$s.</span>', 'autofocus' );
	} 

	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);

}

?>