<?php if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.') ?></p>
<?php return; } ?>

	<?php if ( have_comments() ) :?>        
        <?php if ( !empty( $comments_by_type['comment'] ) ) :?>		
		<h4><?php comments_number(__('No Comments'), __('One Comment'), __('% Comments')); ?> </h4>
		
		<ol class="commentlist">
        <?php wp_list_comments('avatar_size=48&type=comment&max_depth=2'); ?>
        </ol>

        <?php endif; ?>
        <?php if ( ! empty($comments_by_type['pings']) ) : ?>		
			<h4><?php _e('Trackbacks for this post') ?></h4>		
			<ol class="pinglist">
				<?php wp_list_comments('type=pings'); ?>
			</ol>

        <?php endif; ?>
		
		<div class="navigation">
			<div class="alignleft"><?php previous_comments_link(); ?></div>
			<div class="alignright"><?php next_comments_link(); ?></div>
		</div>
		
		<?php if ('closed' == $post->comment_status ):?>
		<p class="nocomments"><?php _e('Comments are now closed for this article.') ?></p>
		<?php endif; ?>

 		<?php else :  ?>
		
        <?php if ('open' == $post->comment_status) :?>
        <!-- no comments available-->
        <?php else :?>		
		<?php if (is_single()) { ?><p class="nocomments"><?php _e('Comments are closed.') ?></p><?php } ?>
        <?php endif; ?>       
	<?php endif; ?>

	<?php if ( comments_open() ) : ?>
	
	<div id="respond">
		<h4><?php comment_form_title( __('Leave a Comment'), __('Leave a Comment to %s') ); ?></h4>	
		<div class="cancel-comment-reply">
			<?php cancel_comment_reply_link(); ?>
		</div>	
		<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<p><?php printf(__('You must be %1$slogged in%2$s to post a comment.'), '<a href="'.get_option('siteurl').'/wp-login.php?redirect_to='.urlencode(get_permalink()).'">', '</a>') ?></p>
		<?php else : ?>
	
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
	
			<?php if ( is_user_logged_in() ) : ?>
		
			<p>
				Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php">
				<?php echo $user_identity; ?></a>. 
				<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a>
			</p>
			
			<div class="message-admin">
				<p>
					<label for="comment">Message:</label>
					<textarea name="comment" id="comment" tabindex="4"></textarea>
				</p>
			</div>
		
			<?php else : ?>
		
			<div class="fields-container">
			
				<div class="info">
			
				<p>
					<label for="author">Name:</label>
					<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="40" tabindex="1" />
				</p>

				<p>
					<label for="email">Email:</label>
					<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="40" tabindex="2" />
				</p>

				<p>
					<label for="url">Website <span>(optional)</span>:</label>
					<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="40" tabindex="3" />
				</p>
		
				</div>
		
				<div class="message">
				
				<p>
					<label for="comment">Message:</label>
					<textarea name="comment" id="comment" tabindex="4"></textarea>
				</p>
				
				</div>
				
			</div>
		
			<?php endif; ?>
		
			<p>
				<input name="submit" type="submit" id="submit" class="gazpo-button" tabindex="5" value="Submit" />
				<?php comment_id_fields(); ?>
			</p>
				
			
			<?php do_action('comment_form', $post->ID); ?>
			
			
		</form>

	<?php endif; ?>
	</div>

	<?php endif; ?>
