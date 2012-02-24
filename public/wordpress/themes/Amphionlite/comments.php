<?php
 
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly. Thanks!');
 
if ( post_password_required() ) { ?>
<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'amphion_lite'); ?></p>
<?php
return;
}
?>
 
<!-- You can start editing here. -->
 
<?php if ( have_comments() ) : ?>
<?php if ( ! empty($comments_by_type['comment']) ) : ?>

<h3 id="comments"><?php comments_number(__( 'No Responses', 'amphion_lite'), __('One Response', 'amphion_lite'), __('% Responses', 'amphion_lite'));?> to &#8220;<?php the_title(); ?>&#8221;</h3>
 
 
<ul class="commentlist">	

<?php wp_list_comments('type=comment&callback=amphion_lite_comment');?>
</ul>
 
<?php endif; ?>
<?php if ( ! empty($comments_by_type['pings']) ) : ?>
<h3 id="comments_ping"><?php _e('Trackbacks &amp; Pings', 'amphion_lite'); ?></h3>
 
<ul class="commentlist" id="ping">
<?php wp_list_comments('type=pings&callback=amphion_lite_ping'); ?>
</ul>
<?php endif; ?>
 
<div class="navigation">
<div class="alignleft"><?php previous_comments_link() ?></div>
<div class="alignright"><?php next_comments_link() ?></div>
</div>


<?php else : // this is displayed if there are no comments so far ?>
 
<?php if ('open' == $post->comment_status) : ?>
<!-- If comments are open, but there are no comments. -->
 
<?php else : // comments are closed ?>
<!-- If comments are closed. -->
<p class="nocomments"><?php _e('Comments are closed.', 'amphion_lite'); ?></p>
 
<?php endif; ?>
<?php endif; ?>
 
<?php comment_form(); ?>