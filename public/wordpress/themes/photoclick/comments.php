<div id="comment-box">

<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
  die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) { ?>
  <p class="nocomments">This post is password protected. Enter the password to view comments.</p>
<?php return; } ?>

<!-- You can start editing here. -->
  <?php if ( have_comments() ) : ?>
  <div class="navigation">
    <div class="alignleft"><?php previous_comments_link() ?></div>
    <div class="alignright"><?php next_comments_link() ?></div>
  </div>

  <?php if (!empty($comments_by_type['comment'])) { ?>
    <h4 id="comments"><?php comments_number('0 comment', '1 comment', '% comments'); ?> on <?php the_title(); ?></h4>
    <ol class="commentlist">
      <?php wp_list_comments('type=comment&callback=comment_style'); ?>
    </ol>
  <?php } if (!empty($comments_by_type['pings'])) { ?>
    <h4 id="comments"><?php echo count($wp_query->comments_by_type['pings']); ?> Pingbacks &amp; Trackbacks on <?php the_title(); ?></h4>
    <ol class="commentlist">
      <?php wp_list_comments('type=pingback&callback=comment_style'); ?>
    </ol>
  <?php } ?>

  <?php else : // this is displayed if there are no comments so far ?>
  <?php if ('open' == $post->comment_status) : ?>
  <?php else : // comments are closed ?><p class="nocomments">Comments are closed.</p><?php endif; ?>
  <?php endif; ?>

  <?php if ('open' == $post->comment_status) : ?>

  <div id="respond">
    <h4><?php comment_form_title( 'Leave a reply', 'Leave a reply to %s' ); ?></h4>
    <?php cancel_comment_reply_link(); ?>

    <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
      <p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
    <?php else : ?>

    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
    <p><textarea name="comment" class="comment-textarea" title="Comment" cols="50" rows="10" tabindex="1"></textarea></p>
    <?php if ( $user_ID ) : ?>
      <p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
    <?php else : ?>
    <p>
      <input type="text" name="author" class="comment-text comment-author" title="Name" value="<?php echo $comment_author; ?>" size="22" tabindex="2" />
      <input type="text" name="email" class="comment-text comment-email" title="Email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="3" />
      <input type="text" name="url" class="comment-text comment-website" title="Website" value="<?php echo $comment_author_url; ?>" size="22" tabindex="4" />
    </p>
    <?php endif; ?>
    <p><input type="submit" class="button" value="Comment" tabindex="5" /><?php comment_id_fields(); ?></p>
    <?php do_action('comment_form', $post->ID); ?>
    </form>

    <?php endif; // If registration required and not logged in ?>
  </div>
    <?php endif; // if you delete this the sky will fall on your head ?>
  </div>