<?php 

/*-----------------------------------------------------------------------------------*/
/* WPZOOM Custom Widgets															 */
/*-----------------------------------------------------------------------------------*/
 
/*----------------------------------*/
/* WPZOOM: Social Widget			*/
/*----------------------------------*/
 
function connectWithMe($args) {

  extract($args);
	$settings = get_option( 'widget_social_connect' );
  
  echo $before_widget;
  echo "$before_title"."$settings[title]"."$after_title";
?>
		<ul class="social">
				<?php if ($settings[ 'rss' ] != '') echo"<li><a href=\"$settings[rss]\"><img src=\"". get_bloginfo('template_directory') ."/images/icons/rss.png\" alt=\"$settings[rss_name] \" />$settings[rss_name]<span>$settings[rss_sub]</span></a></li>"; ?>
				<?php if ($settings[ 'email' ] != '') echo"<li><a href=\"mailto:$settings[email]\"><img src=\"". get_bloginfo('template_directory') ."/images/icons/email.png\" alt=\"$settings[rss_email] \" />$settings[email_name]<span>$settings[email_sub]</span></a></li>"; ?>
				<?php if ($settings[ 'twitter' ] != '') echo"<li><a href=\"$settings[twitter]\"><img src=\"". get_bloginfo('template_directory') ."/images/icons/twitter.png\" alt=\"$settings[rss_twitter] \" />$settings[twitter_name]<span>$settings[twitter_sub]</span></a></li>"; ?>
				<?php if ($settings[ 'facebook' ] != '') echo"<li><a href=\"$settings[facebook]\"><img src=\"". get_bloginfo('template_directory') ."/images/icons/facebook.png\" alt=\"$settings[rss_facebook] \" />$settings[facebook_name]<span>$settings[facebook_sub]</span></a></li>"; ?>
				<?php if ($settings[ 'dribbble' ] != '') echo"<li><a href=\"$settings[dribbble]\"><img src=\"". get_bloginfo('template_directory') ."/images/icons/dribbble.png\" alt=\"$settings[rss_dribbble] \" />$settings[dribbble_name]<span>$settings[dribbble_sub]</span></a></li>"; ?>
				<?php if ($settings[ 'delicious' ] != '') echo"<li><a href=\"$settings[delicious]\"><img src=\"". get_bloginfo('template_directory') ."/images/icons/delicious.png\" alt=\"$settings[rss_delicious] \" />$settings[delicious_name]<span>$settings[delicious_sub]</span></a></li>"; ?>
				<?php if ($settings[ 'digg' ] != '') echo"<li><a href=\"$settings[digg]\"><img src=\"". get_bloginfo('template_directory') ."/images/icons/digg.png\" alt=\"$settings[rss_digg] \" />$settings[digg_name]<span>$settings[digg_sub]</span></a></li>"; ?>
  				<?php if ($settings[ 'linkedin' ] != '') echo"<li><a href=\"$settings[linkedin]\"><img src=\"". get_bloginfo('template_directory') ."/images/icons/linkedin.png\" alt=\"$settings[rss_linkedin] \" />$settings[linkedin_name]<span>$settings[linkedin_sub]</span></a></li>"; ?>
  				<?php if ($settings[ 'flickr' ] != '') echo"<li><a href=\"$settings[flickr]\"><img src=\"". get_bloginfo('template_directory') ."/images/icons/flickr.png\" alt=\"$settings[rss_flickr] \" />$settings[flickr_name]<span>$settings[flickr_sub]</span></a></li>"; ?>
				<?php if ($settings[ 'picasa' ] != '') echo"<li><a href=\"$settings[picasa]\"><img src=\"". get_bloginfo('template_directory') ."/images/icons/picasa.png\" alt=\"$settings[rss_picasa] \" />$settings[picasa_name]<span>$settings[picasa_sub]</span></a></li>"; ?>
				<?php if ($settings[ 'youtube' ] != '') echo"<li><a href=\"$settings[youtube]\"><img src=\"". get_bloginfo('template_directory') ."/images/icons/youtube.png\" alt=\"$settings[rss_youtube] \" />$settings[youtube_name]<span>$settings[youtube_sub]</span></a></li>"; ?>
 
 		</ul>
 <?php
  echo $after_widget;

}

function connectWithMe_admin() {
	$settings = get_option( 'widget_social_connect' );
	
	if( isset( $_POST[ 'update_social_connect' ] ) ) {
    $settings[ 'title' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_title' ] ) );
    
    
	$settings[ 'rss' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_rss' ] ) );
    $settings[ 'rss_name' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_rss_name' ] ) );
    $settings[ 'rss_sub' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_rss_sub' ] ) );	
    
    $settings[ 'email' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_email' ] ) );
    $settings[ 'email_name' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_email_name' ] ) );
    $settings[ 'email_sub' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_email_sub' ] ) );
    
    $settings[ 'twitter' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_twitter' ] ) );
    $settings[ 'twitter_name' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_twitter_name' ] ) );
    $settings[ 'twitter_sub' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_twitter_sub' ] ) );	
    
	$settings[ 'facebook' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_facebook' ] ) );
    $settings[ 'facebook_name' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_facebook_name' ] ) );
    $settings[ 'facebook_sub' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_facebook_sub' ] ) );	
    
    $settings[ 'dribbble' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_dribbble' ] ) );
    $settings[ 'dribbble_name' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_dribbble_name' ] ) );
    $settings[ 'dribbble_sub' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_dribbble_sub' ] ) );		
    
    $settings[ 'delicious' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_delicious' ] ) );
    $settings[ 'delicious_name' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_delicious_name' ] ) );
    $settings[ 'delicious_sub' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_delicious_sub' ] ) );
    
    $settings[ 'digg' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_digg' ] ) );
    $settings[ 'digg_name' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_digg_name' ] ) );
    $settings[ 'digg_sub' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_digg_sub' ] ) );	
     
    $settings[ 'linkedin' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_linkedin' ] ) );
    $settings[ 'linkedin_name' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_linkedin_name' ] ) );
    $settings[ 'linkedin_sub' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_linkedin_sub' ] ) );	
    
    $settings[ 'flickr' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_flickr' ] ) );
    $settings[ 'flickr_name' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_flickr_name' ] ) );
    $settings[ 'flickr_sub' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_flickr_sub' ] ) );	
    
    $settings[ 'picasa' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_picasa' ] ) );
    $settings[ 'picasa_name' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_picasa_name' ] ) );
    $settings[ 'picasa_sub' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_picasa_sub' ] ) );	
     
    $settings[ 'youtube' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_youtube' ] ) );
    $settings[ 'youtube_name' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_youtube_name' ] ) );
    $settings[ 'youtube_sub' ] = strip_tags( stripslashes( $_POST[ 'widget_social_connect_youtube_sub' ] ) );	
    
		update_option( 'widget_social_connect', $settings );
	}

?>
	<p>
		<label for="widget_social_connect_title">Widget Title</label><br />
		<input type="text" id="widget_social_connect_title" name="widget_social_connect_title" value="<?php echo $settings['title']; ?>" size="35" /><br />
		
		<p>
		<img style="float: left; margin-right: 3px;" src="<?php echo bloginfo('template_directory') ?>/images/icons/rss.png" />
		<label for="widget_social_connect_rss"><strong>RSS Feed</strong> URL</label> 
		<input type="text" id="widget_social_connect_rss" name="widget_social_connect_rss" value="<?php echo $settings['rss']; ?>" size="30" />
		</p>
		<p style="margin-left:34px;">
  		<label for="widget_social_connect_rss">Heading</label><br />
		<input type="text" id="widget_social_connect_rss_name" name="widget_social_connect_rss_name" value="<?php echo $settings['rss_name']; ?>" size="30" /><br />
 		<label for="widget_social_connect_rss">Sub-heading</label><br />
		<input type="text" id="widget_social_connect_rss_sub" name="widget_social_connect_rss_sub" value="<?php echo $settings['rss_sub']; ?>" size="30" /><br />
		</p>
		
		<p>
		<img style="float: left; margin-right: 3px;" src="<?php echo bloginfo('template_directory') ?>/images/icons/email.png" />
		<label for="widget_social_connect_email"><strong>E-mail</strong></label> <br/>
		<input type="text" id="widget_social_connect_email" name="widget_social_connect_email" value="<?php echo $settings['email']; ?>" size="30" />
		</p>
		<p style="margin-left:34px;">
  		<label for="widget_social_connect_email">Heading</label><br />
		<input type="text" id="widget_social_connect_email_name" name="widget_social_connect_email_name" value="<?php echo $settings['email_name']; ?>" size="30" /><br />
 		<label for="widget_social_connect_email">Sub-heading</label><br />
		<input type="text" id="widget_social_connect_email_sub" name="widget_social_connect_email_sub" value="<?php echo $settings['email_sub']; ?>" size="30" /><br />
		</p>
		
		<p>
		<img style="float: left; margin-right: 3px;" src="<?php echo bloginfo('template_directory') ?>/images/icons/twitter.png" />
		<label for="widget_social_connect_twitter"><strong>Twitter</strong> Full URL</label> 
		<input type="text" id="widget_social_connect_twitter" name="widget_social_connect_twitter" value="<?php echo $settings['twitter']; ?>" size="30" />
		</p>
		<p style="margin-left:34px;">
  		<label for="widget_social_connect_twitter">Heading</label><br />
		<input type="text" id="widget_social_connect_twitter_name" name="widget_social_connect_twitter_name" value="<?php echo $settings['twitter_name']; ?>" size="30" /><br />
 		<label for="widget_social_connect_twitter">Sub-heading</label><br />
		<input type="text" id="widget_social_connect_twitter_sub" name="widget_social_connect_twitter_sub" value="<?php echo $settings['twitter_sub']; ?>" size="30" /><br />
		</p>
		
				
		<p>
		<img style="float: left; margin-right: 3px;" src="<?php echo bloginfo('template_directory') ?>/images/icons/facebook.png" />
		<label for="widget_social_connect_facebook"><strong>Facebook</strong> Full URL</label> 
		<input type="text" id="widget_social_connect_facebook" name="widget_social_connect_facebook" value="<?php echo $settings['facebook']; ?>" size="30" />
		</p>
		<p style="margin-left:34px;">
  		<label for="widget_social_connect_facebook">Heading</label><br />
		<input type="text" id="widget_social_connect_facebook_name" name="widget_social_connect_facebook_name" value="<?php echo $settings['facebook_name']; ?>" size="30" /><br />
 		<label for="widget_social_connect_facebook">Sub-heading</label><br />
		<input type="text" id="widget_social_connect_facebook_sub" name="widget_social_connect_facebook_sub" value="<?php echo $settings['facebook_sub']; ?>" size="30" /><br />
		</p>
		
		<p>
		<img style="float: left; margin-right: 3px;" src="<?php echo bloginfo('template_directory') ?>/images/icons/dribbble.png" />
		<label for="widget_social_connect_dribbble"><strong>Dribbble</strong> Full URL</label> 
		<input type="text" id="widget_social_connect_dribbble" name="widget_social_connect_dribbble" value="<?php echo $settings['dribbble']; ?>" size="30" />
		</p>
		<p style="margin-left:34px;">
  		<label for="widget_social_connect_dribbble">Heading</label><br />
		<input type="text" id="widget_social_connect_dribbble_name" name="widget_social_connect_dribbble_name" value="<?php echo $settings['dribbble_name']; ?>" size="30" /><br />
 		<label for="widget_social_connect_dribbble">Sub-heading</label><br />
		<input type="text" id="widget_social_connect_dribbble_sub" name="widget_social_connect_dribbble_sub" value="<?php echo $settings['dribbble_sub']; ?>" size="30" /><br />
		</p>
		
		
		<p>
		<img style="float: left; margin-right: 3px;" src="<?php echo bloginfo('template_directory') ?>/images/icons/delicious.png" />
		<label for="widget_social_connect_delicious"><strong>Delicious</strong> Full URL</label> 
		<input type="text" id="widget_social_connect_delicious" name="widget_social_connect_delicious" value="<?php echo $settings['delicious']; ?>" size="30" />
		</p>
		<p style="margin-left:34px;">
  		<label for="widget_social_connect_delicious">Heading</label><br />
		<input type="text" id="widget_social_connect_delicious_name" name="widget_social_connect_delicious_name" value="<?php echo $settings['delicious_name']; ?>" size="30" /><br />
 		<label for="widget_social_connect_delicious">Sub-heading</label><br />
		<input type="text" id="widget_social_connect_delicious_sub" name="widget_social_connect_delicious_sub" value="<?php echo $settings['delicious_sub']; ?>" size="30" /><br />
		</p>
		
		
		<p>
		<img style="float: left; margin-right: 3px;" src="<?php echo bloginfo('template_directory') ?>/images/icons/digg.png" />
		<label for="widget_social_connect_digg"><strong>Digg</strong> Full URL</label><br/> 
		<input type="text" id="widget_social_connect_digg" name="widget_social_connect_digg" value="<?php echo $settings['digg']; ?>" size="30" />
		</p>
		<p style="margin-left:34px;">
  		<label for="widget_social_connect_digg">Heading</label><br />
		<input type="text" id="widget_social_connect_digg_name" name="widget_social_connect_digg_name" value="<?php echo $settings['digg_name']; ?>" size="30" /><br />
 		<label for="widget_social_connect_digg">Sub-heading</label><br />
		<input type="text" id="widget_social_connect_digg_sub" name="widget_social_connect_digg_sub" value="<?php echo $settings['digg_sub']; ?>" size="30" /><br />
		</p>
		
		
		<p>
		<img style="float: left; margin-right: 3px;" src="<?php echo bloginfo('template_directory') ?>/images/icons/linkedin.png" />
		<label for="widget_social_connect_linkedin"><strong>Linkedin</strong> Full URL</label> 
		<input type="text" id="widget_social_connect_linkedin" name="widget_social_connect_linkedin" value="<?php echo $settings['linkedin']; ?>" size="30" />
		</p>
		<p style="margin-left:34px;">
  		<label for="widget_social_connect_linkedin">Heading</label><br />
		<input type="text" id="widget_social_connect_linkedin_name" name="widget_social_connect_linkedin_name" value="<?php echo $settings['linkedin_name']; ?>" size="30" /><br />
 		<label for="widget_social_connect_linkedin">Sub-heading</label><br />
		<input type="text" id="widget_social_connect_linkedin_sub" name="widget_social_connect_linkedin_sub" value="<?php echo $settings['linkedin_sub']; ?>" size="30" /><br />
		</p>
		
		
		<p>
		<img style="float: left; margin-right: 3px;" src="<?php echo bloginfo('template_directory') ?>/images/icons/flickr.png" />
		<label for="widget_social_connect_flickr"><strong>Flickr</strong> Full URL</label> 
		<input type="text" id="widget_social_connect_flickr" name="widget_social_connect_flickr" value="<?php echo $settings['flickr']; ?>" size="30" />
		</p>
		<p style="margin-left:34px;">
  		<label for="widget_social_connect_flickr">Heading</label><br />
		<input type="text" id="widget_social_connect_flickr_name" name="widget_social_connect_flickr_name" value="<?php echo $settings['flickr_name']; ?>" size="30" /><br />
 		<label for="widget_social_connect_flickr">Sub-heading</label><br />
		<input type="text" id="widget_social_connect_flickr_sub" name="widget_social_connect_flickr_sub" value="<?php echo $settings['flickr_sub']; ?>" size="30" /><br />
		</p>
		
		<p>
		<img style="float: left; margin-right: 3px;" src="<?php echo bloginfo('template_directory') ?>/images/icons/picasa.png" />
		<label for="widget_social_connect_picasa"><strong>Picasa</strong> Full URL</label> 
		<input type="text" id="widget_social_connect_picasa" name="widget_social_connect_picasa" value="<?php echo $settings['picasa']; ?>" size="30" />
		</p>
		<p style="margin-left:34px;">
  		<label for="widget_social_connect_picasa">Heading</label><br />
		<input type="text" id="widget_social_connect_picasa_name" name="widget_social_connect_picasa_name" value="<?php echo $settings['picasa_name']; ?>" size="30" /><br />
 		<label for="widget_social_connect_picasa">Sub-heading</label><br />
		<input type="text" id="widget_social_connect_picasa_sub" name="widget_social_connect_picasa_sub" value="<?php echo $settings['picasa_sub']; ?>" size="30" /><br />
		</p>
		
		<p>
		<img style="float: left; margin-right: 3px;" src="<?php echo bloginfo('template_directory') ?>/images/icons/youtube.png" />
		<label for="widget_social_connect_youtube"><strong>Youtube</strong> Full URL</label> 
		<input type="text" id="widget_social_connect_youtube" name="widget_social_connect_youtube" value="<?php echo $settings['youtube']; ?>" size="30" />
		</p>
		<p style="margin-left:34px;">
  		<label for="widget_social_connect_youtube">Heading</label><br />
		<input type="text" id="widget_social_connect_youtube_name" name="widget_social_connect_youtube_name" value="<?php echo $settings['youtube_name']; ?>" size="30" /><br />
 		<label for="widget_social_connect_youtube">Sub-heading</label><br />
		<input type="text" id="widget_social_connect_youtube_sub" name="widget_social_connect_youtube_sub" value="<?php echo $settings['youtube_sub']; ?>" size="30" /><br />
		</p>
		
 
	</p>
	<input type="hidden" id="update_social_connect" name="update_social_connect" value="1" />
<?php }
  
/*------------------------------------------*/
/* WPZOOM: Recent Posts           */
/*------------------------------------------*/
  
function recent_news($args) {
  
  extract($args);
  $settings = get_option( 'widget_recent_news' );  
  $number = $settings[ 'number' ];
  
  echo $before_widget;
  echo "$before_title"."$settings[title]"."$after_title";
  
?>
<ul class="news_widget">
  <?php
    $recent = new WP_Query( 'caller_get_posts=1&showposts=' . $number );
    while( $recent->have_posts() ) : $recent->the_post(); 
      global $post; global $wp_query;
  ?>
	<li>
		<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
		<?php unset($img); 
			if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail() ) {
			$thumbURL = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' );
				$img = $thumbURL[0]; }
				else {
					unset($img);
					if ($wpzoom_cf_use == 'Yes') { $img = get_post_meta($post->ID, $wpzoom_cf_photo, true); }
				else {
					if (!$img)  { $img = catch_that_image($post->ID); } }
				}
				if ($img) { $img = wpzoom_wpmu($img);?>
			<img src="<?php bloginfo('template_directory'); ?>/scripts/timthumb.php?src=<?php echo $img ?>&amp;w=65&amp;h=50&amp;zc=1" alt="<?php the_title(); ?>" /> 
			<?php } ?>
 		</a>
 		<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a>
		<span class="meta"><?php the_time('F j, Y \a\t G:i'); ?></span> 
 
  </li>
   
  <?php
    endwhile;
  ?>
</ul>
  
<?php
echo $after_widget;
}

function recent_news_admin() {
  
  $settings = get_option( 'widget_recent_news' );

  if( isset( $_POST[ 'update_recent_news' ] ) ) {
    $settings[ 'title' ] = strip_tags( stripslashes( $_POST[ 'widget_recent_news_title' ] ) );
    $settings[ 'number' ] = strip_tags( stripslashes( $_POST[ 'widget_recent_news_number' ] ) );
    update_option( 'widget_recent_news', $settings );
  }
?>
  <p>
    <label for="widget_recent_news_title">Title</label><br />
    <input type="text" id="widget_recent_news_title" name="widget_recent_news_title" value="<?php echo $settings['title']; ?>" size="40" /><br />
    
    
    <label for="widget_recent_news_number">How many items would you like to display?</label><br />
    <select id="widget_recent_news_number" name="widget_recent_news_number">
      <?php
        $settings = get_option( 'widget_recent_news' );  
        $number = $settings[ 'number' ];
        
        $numbers = array( "1", "2", "3", "4", "5", "6", "7", "8", "9", "10" );
        foreach ($numbers as $num ) {
          $option = '<option value="' . $num . '" ' . ( $number == $num? " selected=\"selected\"" : "") . '>';
            $option .= $num;
          $option .= '</option>';
          echo $option;
        }
      ?>
    </select>
  </p>
    <input type="hidden" id="update_recent_news" name="update_recent_news" value="1" />

<?php  }
 
/*------------------------------------------*/
/* WPZOOM: Recent Comments (with gravatar)	*/
/*------------------------------------------*/


function dp_recent_comments($no_comments = 10, $comment_len = 75) { 
    global $wpdb; 
	
	$request = "SELECT * FROM $wpdb->comments";
	$request .= " JOIN $wpdb->posts ON ID = comment_post_ID";
	$request .= " WHERE comment_approved = '1' AND post_status = 'publish' AND post_password ='' AND comment_type = ''"; 
	$request .= " ORDER BY comment_date DESC LIMIT $no_comments"; 
		
	$comments = $wpdb->get_results($request);
		
	if ($comments) { 
		foreach ($comments as $comment) { 
			ob_start();
			?>
				<li>
					 <?php echo get_avatar($comment,$size='40' ); ?> 
					<a href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID; ?>"><?php echo dp_get_author($comment); ?>:</a>
					<?php echo strip_tags(substr(apply_filters('get_comment_text', $comment->comment_content), 0, $comment_len)); ?>
 				</li>
			<?php
			ob_end_flush();
		} 
	} else { 
		echo "<li>No comments</li>";
	}
}

function dp_get_author($comment) {
	$author = "";

	if ( empty($comment->comment_author) )
		$author = __('Anonymous');
	else
		$author = $comment->comment_author;
		
	return $author;
}
 
function recent_comments($args) {

	extract($args);
	$settings = get_option( 'widget_recent_comments' );  
	$number = $settings[ 'number' ];
	
  echo $before_widget;
  echo "$before_title"."$settings[title]"."$after_title";
 
 
?>
	<ul>
	<?php dp_recent_comments($settings['number_comments']); ?>
	</ul>
	
 <?php
  echo $after_widget;
}

function recent_comments_admin() {
	
	$settings = get_option( 'widget_recent_comments' );
	 
	if( isset( $_POST[ 'update_recent_comments' ] ) ) {
			$settings[ 'title' ] = strip_tags( stripslashes( $_POST[ 'widget_recent_comments_title' ] ) );
			$settings[ 'number_comments' ] = strip_tags( stripslashes( $_POST[ 'widget_recent_comments_number_comments' ] ) );
			update_option( 'widget_recent_comments', $settings );
		}
	
	 
?>	
	<p>
		<label for="widget_recent_comments_title_comments">Title</label><br />
		<input type="text" id="widget_recent_comments_title" name="widget_recent_comments_title" value="<?php echo $settings['title']; ?>" />
	</p>
	
	<p>
		<label for="widget_recent_comments_number_comments">Number of comments</label><br />
		<input type="text" id="widget_recent_comments_number_comments" name="widget_recent_comments_number_comments" value="<?php echo $settings['number_comments']; ?>" />
	</p>
	
<input type="hidden" id="update_recent_comments" name="update_recent_comments" value="1" />
<?php }


/*----------------------------------------------------------------------------------*/
/*  WPZOOM: Flickr Widget	
/*	 			
/*  Plugin URI: http://kovshenin.com/wordpress/plugins/quick-flickr-widget/
/*  Author: Konstantin Kovshenin
/*  Modified by WPZOOM
/*
/*----------------------------------------------------------------------------------*/

$flickr_api_key = "d348e6e1216a46f2a4c9e28f93d75a48"; // You can use your own if you like

function widget_quickflickr($args) {
	extract($args);

	$options = get_option("widget_quickflickr");
	if( $options == false ) {
		$options["title"] = "Flickr Photos";
		$options["rss"] = "";
		$options["items"] = 3;
		$options["target"] = "";
		$options["username"] = "";
		$options["user_id"] = "";
		$options["error"] = "";
	}

	$title = $options["title"];
	$items = $options["items"];
	$view = "_s";
	$before_item = "<li>";
	$after_item = "</li>";
	$before_flickr_widget = "<ul class=\"gallery\">";
	$after_flickr_widget = "</ul>";
	$more_title = $options["more_title"];
	$target = $options["target"];
	$username = $options["username"];
	$user_id = $options["user_id"];
	$error = $options["error"];
	$rss = $options["rss"];
	$tester = 0;

	if (empty($error))
	{
		$target = ($target == "checked") ? "target=\"_blank\"" : "";

		$flickrformat = "php";

		if (empty($items) || $items < 1 || $items > 20) $items = 3;

		// Screen name or RSS in $username?
		if (!ereg("http://api.flickr.com/services/feeds", $username))
			$url = "http://api.flickr.com/services/feeds/photos_public.gne?id=".urlencode($user_id)."&format=".$flickrformat."&lang=en-us".$tags;
		else
			$url = $username."&format=".$flickrformat.$tags;

      eval("?>". file_get_contents($url) . "<?");
			$photos = $feed;

			if ($photos)
			{
			 $out .= $before_flickr_widget;

        foreach($photos["items"] as $key => $value)
				{
				  $tester++;

					if (--$items < 0) break;

					$photo_title = $value["title"];
					$photo_link = $value["url"];
					ereg("<img[^>]* src=\"([^\"]*)\"[^>]*>", $value["description"], $regs);
					$photo_url = $regs[1];

					//$photo_url = $value["media"]["m"];
					$photo_medium_url = str_replace("_m.jpg", ".jpg", $photo_url);
					$photo_url = str_replace("_m.jpg", "$view.jpg", $photo_url);
 
					$before_item = '<li class="fade">';
 
//					$photo_title = ($show_titles) ? "<div class=\"qflickr-title\">$photo_title</div>" : "";
					$out .= $before_item . "<a $target href=\"$photo_link\"><img class=\"flickr_photo\" alt=\"$photo_title\" title=\"$photo_title\" src=\"$photo_url\" /></a>" . $after_item;

				}
				$flickr_home = $photos["url"];
				$out .= $after_flickr_widget;
			}
			else
			{
				$out = "Something went wrong with the Flickr feed! Please check your configuration and make sure that the Flickr username or RSS feed exists";
			}

		?>
<!-- Quick Flickr start -->
	<?php echo $before_widget; ?>
		<?php if(!empty($title)) { $title = apply_filters('localization', $title); echo $before_title . $title . $after_title; } ?>
		<?php echo $out ?>
		<?php if (!empty($more_title) && !$javascript) echo "<a href=\"" . strip_tags($flickr_home) . "\">$more_title</a>"; ?>
	<?php echo $after_widget; ?>
<!-- Quick Flickr end -->
	<?php
	}
	else // error
	{
		$out = $error;
	}
}

function widget_quickflickr_control() {
	$options = $newoptions = get_option("widget_quickflickr");
	if( $options == false ) {
		$newoptions["title"] = "Flickr Gallery";
		$newoptions["error"] = "Your Quick Flickr Widget needs to be configured";
	}
	if ( $_POST["flickr-submit"] ) {
		$newoptions["title"] = strip_tags(stripslashes($_POST["flickr-title"]));
		$newoptions["items"] = strip_tags(stripslashes($_POST["rss-items"]));
		$newoptions["more_title"] = strip_tags(stripslashes($_POST["flickr-more-title"]));
		$newoptions["target"] = strip_tags(stripslashes($_POST["flickr-target"]));
		$newoptions["username"] = strip_tags(stripslashes($_POST["flickr-username"]));

		if (!empty($newoptions["username"]) && $newoptions["username"] != $options["username"])
		{
			if (!ereg("http://api.flickr.com/services/feeds", $newoptions["username"])) // Not a feed
			{
				global $flickr_api_key;
				$str = @file_get_contents("http://api.flickr.com/services/rest/?method=flickr.people.findByUsername&api_key=".$flickr_api_key."&username=".urlencode($newoptions["username"])."&format=rest");
				ereg("<rsp stat=\\\"([A-Za-z]+)\\\"", $str, $regs); $findByUsername["stat"] = $regs[1];

				if ($findByUsername["stat"] == "ok")
				{
					ereg("<username>(.+)</username>", $str, $regs);
					$findByUsername["username"] = $regs[1];

					ereg("<user id=\\\"(.+)\\\" nsid=\\\"(.+)\\\">", $str, $regs);
					$findByUsername["user"]["id"] = $regs[1];
					$findByUsername["user"]["nsid"] = $regs[2];

					$flickr_id = $findByUsername["user"]["nsid"];
					$newoptions["error"] = "";
				}
				else
				{
					$flickr_id = "";
					$newoptions["username"] = ""; // reset

					ereg("<err code=\\\"(.+)\\\" msg=\\\"(.+)\\\"", $str, $regs);
					$findByUsername["message"] = $regs[2] . "(" . $regs[1] . ")";

					$newoptions["error"] = "Flickr API call failed! (findByUsername returned: ".$findByUsername["message"].")";
				}
				$newoptions["user_id"] = $flickr_id;
			}
			else
			{
				$newoptions["error"] = "";
			}
		}
		elseif (empty($newoptions["username"]))
			$newoptions["error"] = "Flickr RSS or Screen name empty. Please reconfigure.";
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option("widget_quickflickr", $options);
	}
	$title = wp_specialchars($options["title"]);
	$items = wp_specialchars($options["items"]);
	if ( empty($items) || $items < 1 ) $items = 3;

	$more_title = wp_specialchars($options["more_title"]);

	$target = wp_specialchars($options["target"]);
	$flickr_username = wp_specialchars($options["username"]);

	?>
	<p><label for="flickr-title"><?php _e("Title:"); ?> <input class="widefat" id="flickr-title" name="flickr-title" type="text" value="<?php echo $title; ?>" /></label></p>
	<p><label for="flickr-username"><?php _e("Flickr RSS URL or Screen name:"); ?> <input class="widefat" id="flickr-username" name="flickr-username" type="text" value="<?php echo $flickr_username; ?>" /></label></p>
	<p><label for="flickr-items"><?php _e("How many items?"); ?> <select class="widefat" id="rss-items" name="rss-items"><?php for ( $i = 1; $i <= 20; ++$i ) echo "<option value=\"$i\" ".($items==$i ? "selected=\"selected\"" : "").">$i</option>"; ?></select></label></p>
	<p><label for="flickr-more-title"><?php _e("More link anchor text:"); ?> <input class="widefat" id="flickr-more-title" name="flickr-more-title" type="text" value="<?php echo $more_title; ?>" /></label></p>
	<p><label for="flickr-target"><input id="flickr-target" name="flickr-target" type="checkbox" value="checked" <?php echo $target; ?> /> <?php _e("Target: _blank"); ?></label></p>
	<input type="hidden" id="flickr-submit" name="flickr-submit" value="1" />
	<?php
}


/*----------------------------------------------------------------------------------*/
/*  WPZOOM: Twitter Widget	
/*	 			
/*  Plugin URI: http://rick.jinlabs.com/code/twitter
/*  Modified by WPZOOM
/*
/*----------------------------------------------------------------------------------*/
 
 	define('MAGPIE_CACHE_ON', 1); //2.7 Cache Bug
	define('MAGPIE_CACHE_AGE', 180);
	define('MAGPIE_INPUT_ENCODING', 'UTF-8');
	define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');
	
  	function wpzoom_twitter_messages($username = '', $num = 1, $list = false, $update = true, $linked  = '#', $hyperlinks = true, $twitter_users = true, $encode_utf8 = false) {
		include_once(ABSPATH . WPINC . '/rss.php');
		
		$messages = fetch_rss('http://twitter.com/statuses/user_timeline/'.$username.'.rss');
	
		if ($list) echo '<ul class="twitter-list">';
		
		if ($username == '') {
			if ($list) echo '<li>';
			echo 'RSS not configured';
			if ($list) echo '</li>';
		} else {
				if ( empty($messages->items) ) {
					if ($list) echo '<li>';
					echo 'No Twitter messages.';
					if ($list) echo '</li>';
				} else {
			$i = 0;
					foreach ( $messages->items as $message ) {
						$msg = " ".substr(strstr($message['description'],': '), 2, strlen($message['description']))." ";
						if($encode_utf8) $msg = utf8_encode($msg);
						$link = $message['link'];
					
						if ($list) echo '<li class="twitter-item">'; elseif ($num != 1) echo '<p class="twitter-message">';
	
			  if ($hyperlinks) { $msg = hyperlinks($msg); }
			  if ($twitter_users)  { $msg = twitter_users($msg); }
								
						if ($linked != '' || $linked != false) {
				if($linked == 'all')  { 
				  $msg = '<a href="'.$link.'" class="twitter-link">'.$msg.'</a>';  // Puts a link to the status of each tweet 
				} else if ( $linked ) {
				  $msg = $msg . '<a href="'.$link.'" class="twitter-link">'.$linked.'</a>'; // Puts a link to the status of each tweet
				  
				}
			  } 
	
			  echo $msg;
			  
			  
			if($update) {				
			  $time = strtotime($message['pubdate']);
			  
			  if ( ( abs( time() - $time) ) < 86400 )
				$h_time = sprintf( __('%s ago'), human_time_diff( $time ) );
			  else
				$h_time = date(__('Y/m/d'), $time);
	
			  echo sprintf( __('%s', 'twitter-for-wordpress'),' <em class="twitter-timestamp">' . $h_time . '</em>' );
			 }          
					  
						if ($list) echo '</li>'; elseif ($num != 1) echo '</p>';
					
						$i++;
						if ( $i >= $num ) break;
					}
				}
			}
			if ($list) echo '</ul>';
		}
	
 	function hyperlinks($text) {
		$text = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\">$1</a>", $text);
		$text = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $text);    
		$text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $text);
		$text = preg_replace('/([\.|\,|\:|\°|\ш|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $text);
		return $text;
	}
	
 	function twitter_users($text) {
		   $text = preg_replace('/([\.|\,|\:|\°|\ш|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $text);
		   return $text;
	}     
	
 	class wpzoom_Twitter extends WP_Widget {
		
 		function wpzoom_Twitter() {
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'twitter', 'description' => 'A list of latest tweets' );
	
			/* Widget control settings. */
			$control_ops = array( 'id_base' => 'wpzoom-twitter' );
	
			/* Create the widget. */
			$this->WP_Widget( 'wpzoom-twitter', 'WPZOOM: Twitter', $widget_ops, $control_ops );
		}
		
 		function widget( $args, $instance ) {
			extract( $args );
	
			/* User-selected settings. */
			$title = apply_filters('widget_title', $instance['title'] );
			$username = $instance['username'];
			$show_count = $instance['show_count'];
			$hide_timestamp = isset( $instance['hide_timestamp'] ) ? $instance['hide_timestamp'] : false;
			$linked = $instance['hide_url'] ? false : '#';
			$show_follow = isset( $instance['show_follow'] ) ? $instance['show_follow'] : false;
	
			/* Before widget (defined by themes). */
			echo $before_widget;
	
			/* Title of widget (before and after defined by themes). */
			if ( $title )
				echo $before_title . $title . $after_title;
			
			wpzoom_twitter_messages($username, $show_count, true, !$hide_timestamp, $linked);
			
			if ( $show_follow ) echo '<div class="follow-user"><a href="http://twitter.com/' . $username . '">' . $instance['follow_text'] . '</a></div>';
	
			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
 		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
	
			/* Strip tags (if needed) and update the widget settings. */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['username'] = $new_instance['username'];
			$instance['show_count'] = $new_instance['show_count'];
			$instance['hide_timestamp'] = $new_instance['hide_timestamp'];
			$instance['hide_url'] = $new_instance['hide_url'];
			$instance['show_follow'] = $new_instance['show_follow'];
			$instance['follow_text'] = $new_instance['follow_text'];
	
			return $instance;
		}
		
 		function form( $instance ) {
	
			/* Set up some default widget settings. */
			$defaults = array( 'title' => 'Latest Tweets', 'username' => '', 'show_count' => 10, 'hide_timestamp' => false, 'hide_url' => false, 'show_follow' => true , 'follow_text' => 'Follow me' );
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label><br />
				<input type="text" size="35" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" width="100%" />
			</p>
	
			<p>
				<label for="<?php echo $this->get_field_id( 'username' ); ?>">Twitter ID:</label>
				<input type="text" size="35" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" width="70%" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'show_count' ); ?>">Show:</label>
				<input  type="text" id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" value="<?php echo $instance['show_count']; ?>" size="3" /> tweets
			</p>
			
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['hide_timestamp'], 'on' ); ?> id="<?php echo $this->get_field_id( 'hide_timestamp' ); ?>" name="<?php echo $this->get_field_name( 'hide_timestamp' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'hide_timestamp' ); ?>">Hide timestamp</label>
			</p>
			
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['hide_url'], 'on' ); ?> id="<?php echo $this->get_field_id( 'hide_url' ); ?>" name="<?php echo $this->get_field_name( 'hide_url' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'hide_url' ); ?>">Hide tweet URL</label>
			</p>
			
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['show_follow'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_follow' ); ?>" name="<?php echo $this->get_field_name( 'show_follow' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'show_follow' ); ?>">Display follow me button</label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'follow_text' ); ?>">Follow me text:</label>
				<input type="text" size="35" id="<?php echo $this->get_field_id( 'follow_text' ); ?>" name="<?php echo $this->get_field_name( 'follow_text' ); ?>" value="<?php echo $instance['follow_text']; ?>" />
			</p>
				
			
			<?php
		}
	}
 

function wpzoom_register_widgets() { register_widget('wpzoom_Twitter'); }
add_action('widgets_init', wpzoom_register_widgets, 1);
	
register_sidebar_widget( 'WPZOOM: Recent News', 'recent_news' );
register_widget_control( 'WPZOOM: Recent News', 'recent_news_admin' );

register_sidebar_widget( 'WPZOOM: Recent Comments', 'recent_comments' );
register_widget_control( 'WPZOOM: Recent Comments', 'recent_comments_admin' );

register_sidebar_widget( 'WPZOOM: Social Widget', 'connectWithMe' );
register_widget_control( 'WPZOOM: Social Widget', 'connectWithMe_admin'  );

register_widget_control( 'WPZOOM: Flickr Widget', "widget_quickflickr_control");
register_sidebar_widget( 'WPZOOM: Flickr Widget', "widget_quickflickr");

?>