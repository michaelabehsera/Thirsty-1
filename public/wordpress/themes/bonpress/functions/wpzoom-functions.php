<?php 

/*--------------------------------------------*/
/* Remove [caption] in-line styling					
/*--------------------------------------------*/


add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
add_shortcode('caption', 'fixed_img_caption_shortcode');
function fixed_img_caption_shortcode($attr, $content = null) {
	// Allow plugins/themes to override the default caption template.
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ( $output != '' ) return $output;
	extract(shortcode_atts(array(
		'id'=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''), $attr));
	if ( 1 > (int) $width || empty($caption) )
	return $content;
	if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
	return '<div ' . $id . 'class="wp-caption ' . esc_attr($align)
	. '">'
	. do_shortcode( $content ) . '<p class="wp-caption-text">'
	. $caption . '</p></div>';
}


/*--------------------------------------------*/
/* Email validating	function for avatar					
/*--------------------------------------------*/

function check_email_address($email) {
  // First, we check that there's one @ symbol, and that the lengths are right
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
     if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
      return false;
    }
  }  
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}

/*--------------------------------------------*/
/* Add Support For Post Formats						
/*--------------------------------------------*/

add_theme_support( 'post-formats', array( 'audio', 'image', 'video', 'link', 'quote' ) );


/*--------------------------------------------*/
/* Comments Custom Template						
/*--------------------------------------------*/


function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="commbody">
	<div class="commleft">
		  <div class="comment-author vcard">
			 <?php echo get_avatar($comment,$size='60' ); ?>

			 <?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
		  </div>
 
		  <div class="comment-meta commentmetadata">
			<?php _e('on', 'wpzoom'); ?> <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s <br/> '), get_comment_date('M d, Y'),  get_comment_time()) ?></a>
			<?php _e('at', 'wpzoom'); ?> <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%2$s'), get_comment_date(),  get_comment_time()) ?></a>
			
			
			<?php edit_comment_link(__('{Edit}'),'  ','') ?></div>
      </div>

      <?php comment_text() ?>
		 <?php if ($comment->comment_approved == '0') : ?>
			 <em><?php _e('Your comment is awaiting moderation.', 'wpzoom') ?></em>
			 <br />
		  <?php endif; ?>
      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>
      <div class="clear"></div>
     </div>
<?php }


/*-----------------------------------------------------------------------------------*/
/* WPZOOM Custom Functions															 */
/*-----------------------------------------------------------------------------------*/

add_action('admin_head', 'myposttype_admin_css');

	function myposttype_admin_css() {

 		echo '<link type="text/css" rel="stylesheet" href="'.get_bloginfo( 'template_directory').'/functions/admin-style.css" media="screen" />';
 
}


function _remove_script_version( $src ){
	$parts = explode( '?', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );


/*--------------------------------------------*/
/* Reset [gallery] shortcode aditional styles						
/*--------------------------------------------*/

add_filter('gallery_style', create_function('$a', 'return "<div class=\'gallery\'>";'));


/*--------------------------------------------*/
/* Show thumbnails on attachement template						
/*--------------------------------------------*/

function show_all_thumbs() {

	global $post;
	
	$post = get_post($post);
	$images = &get_children( 'post_type=attachment&post_mime_type=image&output=ARRAY_N&orderby=menu_order&order=ASC&post_parent='.$post->post_parent);
	if($images) {
	foreach( $images as $imageID => $imagePost ){
	if($imageID==$post->ID){
	} else {
	unset($the_b_img);
	$the_b_img = wp_get_attachment_image($imageID, 'thumbnail', false);
	$thumblist .= '<a href="'.get_attachment_link($imageID).'">'.$the_b_img.'</a>';
	}
	}
	}
	return $thumblist;
}
/*------------------------------------------------*/
/* Add Support for Shortcodes in Excerpt & Widgets						
/*------------------------------------------------*/

add_filter( 'the_excerpt', 'shortcode_unautop');
add_filter( 'the_excerpt', 'do_shortcode');

add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');


/*----------------------------------*/
/* Default Excerpt Lenght 			*/
/*----------------------------------*/

function new_excerpt_length($length) {
	return (int) get_option("wpzoom_excerpt") ? (int) get_option("wpzoom_excerpt") : 50;
}
add_filter('excerpt_length', 'new_excerpt_length');

  
/*----------------------------------*/
/* Custom Posts Options				*/
/*----------------------------------*/

add_action('admin_menu', 'wpzoom_options_box');

function wpzoom_options_box() {
 	add_meta_box('wpzoom_post_template', 'Custom Post Options', 'wpzoom_post_options', 'post', 'side', 'high');
  	}
 

// Regular Posts Options
function wpzoom_post_options() {
	global $post;
	?>
	<fieldset>
		<div>
			 
			<p>
				<label for="wpzoom_post_title" ><strong>Show post title?</strong></label><br />
				<select name="wpzoom_post_title" id="wpzoom_post_title">
					<option<?php selected( get_post_meta($post->ID, 'wpzoom_post_title', true), 'Yes' ); ?>>Yes</option>
					<option<?php selected( get_post_meta($post->ID, 'wpzoom_post_title', true), 'No' ); ?>>No</option>
 				</select>
			</p>
			
			<p>
				<label for="wpzoom_post_readmore" ><strong>Show "Read More" button?</strong></label><br />
				<select name="wpzoom_post_readmore" id="wpzoom_post_readmore">
					<option<?php selected( get_post_meta($post->ID, 'wpzoom_post_readmore', true), 'Yes' ); ?>>Yes</option>
					<option<?php selected( get_post_meta($post->ID, 'wpzoom_post_readmore', true), 'No' ); ?>>No</option>
 				</select>
			</p>
			
			<p>
				<label for="wpzoom_post_url" ><strong>URL to redirect title</strong> (optional):</label><br />
				<input style="width: 255px;" type="text" name="wpzoom_post_url" id="wpzoom_post_url" value="<?php echo get_post_meta($post->ID, 'wpzoom_post_url', true); ?>"/>
 			</p>
 			
 			
  		</div>
	</fieldset>
	<?php
	}
 

add_action('save_post', 'custom_add_save');

function custom_add_save($postID){

global $meta_box;
 
	// called after a post or page is saved
	if($parent_id = wp_is_post_revision($postID))
	{
	  $postID = $parent_id;
	}

	if ($_POST['save'] || $_POST['publish']) {
 	update_custom_meta($postID, $_POST['wpzoom_post_title'], 'wpzoom_post_title');
 	update_custom_meta($postID, $_POST['wpzoom_post_readmore'], 'wpzoom_post_readmore');
 	update_custom_meta($postID, $_POST['wpzoom_post_url'], 'wpzoom_post_url');
	}
}


function update_custom_meta($postID, $newvalue, $field_name) {
// To create new meta
if(!get_post_meta($postID, $field_name)){
add_post_meta($postID, $field_name, $newvalue);
}else{
// or to update existing meta
update_post_meta($postID, $field_name, $newvalue);
}
}

 
/*----------------------------------------------------------------------------------*/
/* Function that allows to display only exact count of comments, without trackbacks
/*----------------------------------------------------------------------------------*/
 function comment_count( $count ) {
	if ( ! is_admin() ) {
		global $id;
		$get_comments = get_comments('post_id=' . $id);
		$comments_by_type = &separate_comments($get_comments);
 		return count($comments_by_type['comment']);
	} else {
		return $count;
	}
}
add_filter('get_comments_number', 'comment_count', 0);


 
/*------------------------------------------------*/
/* Fix for timthumb thumbnails in WP Multisite
/*------------------------------------------------*/

function wpzoom_wpmu ($img) {
	global $blog_id;
  $imageParts = explode('/files/', $img);
	if (isset($imageParts[1])) {
		$img = '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
	}
	return($img);
}


/*----------------------------------------------------*/
/* Custom function for displaying first image from 
/* post as thumbnail, if Featured Image is missing
/*----------------------------------------------------*/

function catch_that_image ($post_id=0, $width=60, $height=60, $img_script='') {
	global $wpdb;
	if($post_id > 0) {

		 // select the post content from the db

		 $sql = 'SELECT post_content FROM ' . $wpdb->posts . ' WHERE id = ' . $wpdb->escape($post_id);
		 $row = $wpdb->get_row($sql);
		 $the_content = $row->post_content;
		 if(strlen($the_content)) {

			  // use regex to find the src of the image

			preg_match("/<img src\=('|\")(.*)('|\") .*( |)\/>/", $the_content, $matches);
			if(!$matches) {
				preg_match("/<img class\=\".*\" src\=('|\")(.*)('|\") .*( |)\/>/U", $the_content, $matches);
			}
      if(!$matches) {
				preg_match("/<img class\=\".*\" title\=\".*\" src\=('|\")(.*)('|\") .*( |)\/>/U", $the_content, $matches);
			}

			$the_image = '';
			$the_image_src = $matches[2];
			$frags = preg_split("/(\"|')/", $the_image_src);
			if(count($frags)) {
				$the_image_src = $frags[0];
			}

      // if an image isn't found yet
      if(!strlen($the_image_src))
      {
          $attachments = get_children( array( 'post_parent' => $post_id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) );

          if (count($attachments) > 0)
          {
            $q = 0;
          	foreach ( $attachments as $id => $attachment ) {
          	$q++;
          		if ($q == 1) {
          			$thumbURL = wp_get_attachment_image_src( $id, $args['size'] );
          			$the_image_src = $thumbURL[0];
          			break;
          		} // if first image
          	} // foreach
          } // if there are attachments
      } // if no image found yet

		  // if src found, then create a new img tag

			  if(strlen($the_image_src)) {
				   if(strlen($img_script)) {

					    // if the src starts with http/https, then strip out server name

					    if(preg_match("/^(http(|s):\/\/)/", $the_image_src)) {
						     $the_image_src = preg_replace("/^(http(|s):\/\/)/", '', $the_image_src);
						     $frags = split("\/", $the_image_src);
						     array_shift($frags);
						     $the_image_src = '/' . join("/", $frags);
					    }
					    $the_image = '<img alt="" src="' . $img_script . $the_image_src . '" />';
				   }
				   else {
					    $the_image = '<img alt="" src="' . $the_image_src . '" width="' . $width . '" height="' . $height . '" />';
				   }
			  }
			  return $the_image_src;
		 }
	}
}


 
/*----------------------------------*/
/* Get Categories					*/
/*----------------------------------*/

function getCategories($parent) {

	global $wpdb, $table_prefix;

	$tb1 = "$table_prefix"."terms";
	$tb2 = "$table_prefix"."term_taxonomy";

	if ($parent == '1')
	{
	 $qqq = "AND $tb2".".parent = 0";
  }
  else
  {
    $qqq = "";
  }

	$q = "SELECT $tb1.term_id,$tb1.name,$tb1.slug FROM $tb1,$tb2 WHERE $tb1.term_id = $tb2.term_id AND $tb2.taxonomy = 'category' $qqq ORDER BY $tb1.name ASC";
	$q = $wpdb->get_results($q);

  foreach ($q as $cat) {
    	$categories[$cat->term_id] = $cat->name;
    } // foreach
  return($categories);
} // end func




/*----------------------------------*/
/* Get Pages						*/
/*----------------------------------*/

function getPages() {

	global $wpdb, $table_prefix;

	$tb1 = "$table_prefix"."posts";

	$q = "SELECT $tb1.ID,$tb1.post_title FROM $tb1 WHERE $tb1.post_type = 'page' AND $tb1.post_status = 'publish' ORDER BY $tb1.post_title ASC";
	$q = $wpdb->get_results($q);

  foreach ($q as $pag) {
    	$pages[$pag->ID] = $pag->post_title;
    } // foreach
  return($pages);
} // end func




/*---------------------------------------------------------------*/
/*  Limit Posts						
/*									
/*  Plugin URI: http://labitacora.net/comunBlog/limit-post.phps
/*	Usage: the_content_limit($max_charaters, $more_link)
/*
/*---------------------------------------------------------------*/
 
function the_content_limit($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

   if (strlen($_GET['p']) > 0 && $thisshouldnotapply) {
      echo $content;
   }
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
        echo $content;
        echo "...";
   }
   else {
      echo $content;
   }
}



/*----------------------------------*/
/* Breadcrumbs						*/
/*----------------------------------*/

function wpzoom_breadcrumbs() {
 
  $delimiter = '&raquo;';
  $name = 'Home'; //text for the 'Home' link
  $currentBefore = '<span class="current">';
  $currentAfter = '</span>';
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
     global $post;
    $home = get_bloginfo('url');
    echo '<a href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $currentBefore . '';
      single_cat_title();
      echo '' . $currentAfter;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('F') . $currentAfter;
 
    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;
 
    } elseif ( is_single() ) {
      $cat = get_the_category(); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_search() ) {
      echo $currentBefore . 'Search results for &#39;' . get_search_query() . '&#39;' . $currentAfter;
 
    } elseif ( is_tag() ) {
      echo $currentBefore . 'Posts tagged &#39;';
      single_tag_title();
      echo '&#39;' . $currentAfter;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . 'Articles posted by ' . $userdata->display_name . $currentAfter;
 
    } elseif ( is_404() ) {
      echo $currentBefore . 'Error 404' . $currentAfter;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
  
  }
}

 
?>