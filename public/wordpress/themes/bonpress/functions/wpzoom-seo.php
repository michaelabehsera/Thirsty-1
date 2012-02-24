<?php 
/*-----------------------------------------------------------------------------------*/
/* SEO Functions																	 */
/*-----------------------------------------------------------------------------------*/
 
 
/*----------------------------------*/
/* Title							*/
/*----------------------------------*/

function wpzoom_titles() {
	global $shortname;

	#if the title is being displayed on the homepage
	if (is_home()) {

			if (get_option('wpzoom_seo_home_title') == 'Site Title - Site Description') echo get_bloginfo('name').get_option('wpzoom_title_separator').get_bloginfo('description');
			if ( get_option('wpzoom_seo_home_title') == 'Site Description - Site Title') echo get_bloginfo('description').get_option('wpzoom_title_separator').get_bloginfo('name');
			if ( get_option('wpzoom_seo_home_title') == 'Site Title') echo get_bloginfo('name');
 	}
	#if the title is being displayed on single posts/pages
	if (is_single() || is_page()) {

			if (get_option('wpzoom_seo_posts_title') == 'Site Title - Page Title') echo get_bloginfo('name').get_option('wpzoom_title_separator').wp_title('',false,'');
			if ( get_option('wpzoom_seo_posts_title') == 'Page Title - Site Title') echo wp_title('',false,'').get_option('wpzoom_title_separator').get_bloginfo('name');
			if ( get_option('wpzoom_seo_posts_title') == 'Page Title') echo wp_title('',false,'');

	}
	#if the title is being displayed on index pages (categories/archives/search results)
	if (is_category() || is_archive() || is_search()) {
		if (get_option('wpzoom_seo_pages_title') == 'Site Title - Page Title') echo get_bloginfo('name').get_option('wpzoom_title_separator').wp_title('',false,'');
		if ( get_option('wpzoom_seo_pages_title') == 'Page Title - Site Title') echo wp_title('',false,'').get_option('wpzoom_title_separator').get_bloginfo('name');
		if ( get_option('wpzoom_seo_pages_title') == 'Page Title') echo wp_title('',false,'');
		 }
}



/*----------------------------------*/
/* Indexing Settings				*/
/*----------------------------------*/

function wpzoom_index(){
		global $post;
		global $wpdb;
		if(!empty($post)){
			$post_id = $post->ID;
		}

		/* Robots */
		$index = 'index';
		$follow = 'follow';

		if ( is_tag() && get_option('wpzoom_index_tag') != 'index') { $index = 'noindex'; }
		elseif ( is_search() && get_option('wpzoom_index_search') != 'index' ) { $index = 'noindex'; }
		elseif ( is_author() && get_option('wpzoom_index_author') != 'index') { $index = 'noindex'; }
		elseif ( is_date() && get_option('wpzoom_index_date') != 'index') { $index = 'noindex'; }
		elseif ( is_category() && get_option('wpzoom_index_category') != 'index' ) { $index = 'noindex'; }
		echo '<meta name="robots" content="'. $index .', '. $follow .'" />' . "\n";

	}


/*----------------------------------*/
/* Keywords							*/
/*----------------------------------*/

function meta_post_keywords() {
	$posttags = get_the_tags();
	foreach((array)$posttags as $tag) {
		$meta_post_keywords .= $tag->name . ',';
	}
	echo '<meta name="keywords" content="'.$meta_post_keywords.'" />';
}

function meta_home_keywords() {
 global $wpzoom_meta_key;

 if (strlen($wpzoom_meta_key) > 1 ) {

 echo '<meta name="keywords" content="'.get_option('wpzoom_meta_key').'" />';

 }
}
 

/*----------------------------------*/
/* Canonical URLS					*/
/*----------------------------------*/

function wpzoom_canonical() {

 	if(get_option('wpzoom_canonical') == 'Yes' ) {

	#homepage urls
	if (is_home() )echo '<link rel="canonical" href="'.get_bloginfo('url').'" />';

	#single page urls
	global $wp_query;
	$postid = $wp_query->post->ID;

	if (is_single() || is_page()) echo '<link rel="canonical" href="'.get_permalink().'" />';


	#index page urls

		if (is_archive() || is_category() || is_search()) echo '<link rel="canonical" href="'.get_permalink().'" />';
	}
}

?>