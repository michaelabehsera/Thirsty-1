<?php
/*
Plugin Name: ReplyMe
Plugin URI: http://photozero.net/wp-plugins/replyme/
Description: Send a email to author automatically while someone reply his comment.
Version: 1.0.5
Author: Neekey
Author URI: http://photozero.net/
*/

add_action('comment_post', 'replyme');
add_action('admin_menu', 'replyme_admin_init');
register_activation_hook( __FILE__ , 'replyme_install');


function replyme_install(){
	$replyme_path = ABSPATH . 'wp-content/plugins/replyme/';
	if(!defined('WPLANG')){$lang = 'en';}else{$lang = WPLANG;}
	
	if(file_exists($replyme_path.'subject.'.$lang)){
		$subject = file_get_contents($replyme_path.'subject.'.$lang);
	}else{
		$subject = file_get_contents($replyme_path.'subject.en');
	}
	
	if(file_exists($replyme_path.'message.'.$lang)){
		$message = file_get_contents($replyme_path.'message.'.$lang);
	}else{
		$message = file_get_contents($replyme_path.'message.en');
	}
	
	add_option('replyme_subject',$subject);
	add_option('replyme_message',$message);
}

function replyme_admin_init(){
	add_options_page('ReplyMe', 'ReplyMe', 8, basename(__FILE__), 'replyme_admin');
}

function replyme_admin(){
?>
<div class="wrap">
<h2>ReplyMe Settings</h2>
<p>You may use the following tags both in 'subject' and 'message' field below:</p>
<ul>
	<li>[blogname] blog title like <b><?php echo get_option('blogname');?></b></li>
	<li>[blogurl] blog url like <b><?php echo get_option('siteurl');?></b></li>
	<li>[posttitle] the title of this post</li>
	<li>[posturl] the url of this post</li>
	<li>[posttime] the post time of this post</li>
	<li>[commenter] the author name of parent comment</li>
	<li>[commentmsg] the content of parent comment</li>
	<li>[commenttime] the post time of parent comment</li>
	<li>[newcommenter] the author who should be send a message</li>
	<li>[newcommenterurl] the url of author</li>
	<li>[newcommentmsg] the content of comment</li>
	<li>[newcommenttime] the post time of comment</li>
	<li>[newcommenturl] the url of new comment with '#comment-xxx' tag like http://example.com/post/123/#comment-321 </li>
</ul>
<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>
<table class="form-table">
<tr valign="top">
<th scope="row"><label for="replyme_subject">Email Subject</label></th>
<td><input type="text" class="regular-text" id="replyme_subject" name="replyme_subject" value="<?php echo get_option('replyme_subject'); ?>" /></td>
</tr>
<tr valign="top">
<th scope="row"><label for="replyme_message">Email Content</label>(HTML enable)</th>
<td><textarea name="replyme_message" rows="10" cols="50" id="replyme_message" class="large-text"><?php echo get_option('replyme_message'); ?></textarea></td>
</tr>
</table>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="replyme_subject,replyme_message" />
<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
</p>
</form>
</div>
<?php
}

function replyme($comment){
	$commentdata = get_comment($comment);
		
	if($commentdata->comment_approved == '1' && $commentdata->comment_parent){
		$parent = get_comment($commentdata->comment_parent);
		if($parent->comment_author_email){
			$thepost = get_post($parent->comment_post_ID);
			
			if($parent->comment_author_email == $commentdata->comment_author_email){//the same author
				return $commentdata;
			}
			
			$search = array(
				'[blogname]',
				'[blogurl]',
				'[posttitle]',
				'[posturl]',
				'[posttime]',
				'[commenter]',
				'[commentmsg]',
				'[commenttime]',
				'[newcommenter]',
				'[newcommenterurl]',
				'[newcommentmsg]',
				'[newcommenttime]',
				'[newcommenturl]',

			);
			
			$replaceto = array(
				get_option('blogname'),
				get_option('siteurl'),
				$thepost->post_title,
				$thepost->guid,
				$thepost->post_date,
				wp_specialchars($parent->comment_author),
				nl2br(wp_specialchars($parent->comment_content)),
				$parent->comment_date,
				wp_specialchars($commentdata->comment_author),
				$commentdata->comment_author_url,
				nl2br(wp_specialchars($commentdata->comment_content)),
				$commentdata->comment_date,
				get_comment_link($commentdata->comment_ID),
			);
			
			$mailsubject = str_replace($search,$replaceto,get_option('replyme_subject'));			
			$mailmessage = str_replace($search,$replaceto,get_option('replyme_message'));
			
			wp_mail(
				$parent->comment_author_email,
				$mailsubject,
				$mailmessage,
				'From: '.get_option('blogname').' <'.get_option('admin_email').'>'."\r\n".
				'Content-Type: text/html; charset="UTF-8"'
			);
		}
	}
	
	return $commentdata;
}

?>