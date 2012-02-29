<?php

global $tml, $user_level, $tml_admin_messages, $tml_admin, $msgid, $checksum, $restrict_by_tags_use_default, $restrict_by_tags_type, $restrict_by_tags_slugs, $restrict_by_cats_use_default, $restrict_by_cats_type, $restrict_by_cats_slugs;
	
###		Standard authorization check		###
if( !is_object($tml) || !current_user_can("edit_plugins") ) {
	echo __("Sorry: you can not configure Thank Me Later with your account.", "thankmelater");
	exit;
}

//if(function_exists("use_codepress") && $tml->get_option("syntax_highlighting"))
//	use_codepress();

?>

<form method="post" name="template" id="template" action="?<?php echo attribute_escape( TML_admin_pages_hierarchy::build_query() . ( isset($msgid) ? "&msgid=" . urlencode($msgid) . "&checksum=" . $checksum  :  "" ) ); ?>">
	<?php wp_nonce_field("thank-me-later-admin-messages-new-message"); ?>
	
	<table class="form-table tml-form">

		<tbody>
			<tr valign="top">
				<th scope="row">
					<label for="from_name"><?php _e("From Name", "thankmelater"); ?></label>
				</th>
				<td>
					<?php echo TML_form::input_text("from_name", $from_name, 1) ?>
					<span class="setting-description"><?php _e("Who is the e-mail from?", "thankmelater"); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="from_email"><?php _e("From E-mail", "thankmelater"); ?></label>
				</th>
				<td>
					<?php echo TML_form::input_text("from_email", $from_email, 2) ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="message_subject"><?php _e("Message Subject", "thankmelater"); ?></label>
				</th>
				<td>
					<?php echo TML_form::input_text("message_subject", $message_subject, 3) ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<?php _e("Message Settings", "thankmelater"); ?>
				</th>
				<td>
					<fieldset>
					
						<legend class="hidden"><?php _e("Message Settings", "thankmelater"); ?></legend>
						
						<label for="use_html"><?php echo TML_form::input_checkbox("use_html", 1, $use_html, 4) ?> <?php _e("Use HTML", "thankmelater"); ?></label>
						<br />
						<label for="nl2br"><?php echo TML_form::input_checkbox("nl2br", 1, $nl2br, 5) ?> <?php echo wp_specialchars(__("Turn line breaks into <br>'s (when using HTML)", "thankmelater")); ?></label>

					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="message_body"><?php _e("Message Body", "thankmelater"); ?></label>
				</th>
				<td>
					<div><textarea name="newcontent" id="newcontent" class="codepress php large-text" rows="15" cols="70" style="font-family: 'Courier New', Courier, monospace; overflow: auto; width: 810px;" tabindex="6"><?php echo wp_specialchars($message_body); ?></textarea></div>
					
					<script type="text/javascript">
						function tml_toggle_tag_reference() {
							if( document.getElementById("tml_hide_tag_reference_span").style.display == "none" ) { // show
								document.getElementById("tml_show_tag_reference_span").style.display = "none";
								document.getElementById("tml_hide_tag_reference_span").style.display = "";
								document.getElementById("tml_tag_reference").style.display = "";
							}else{ // hide
								document.getElementById("tml_show_tag_reference_span").style.display = "";
								document.getElementById("tml_hide_tag_reference_span").style.display = "none";
								document.getElementById("tml_tag_reference").style.display = "none";
							}
						}
					</script>
					
					<span class="setting-description" id="tml_show_tag_reference_span"><?php printf(__("%sShow Tag and PHP Reference%s", "thankmelater"), '<a href="javascript:void(0);" onclick="tml_toggle_tag_reference();">', "</a>"); ?></span>
					
					<span class="setting-description" id="tml_hide_tag_reference_span" style="display: none;">
						<?php printf(__("%sHide Tag and PHP Reference%s", "thankmelater"), '<a href="#" onclick="tml_toggle_tag_reference();">', "</a>"); ?>
					</span>
					
					<div id="tml_tag_reference">
					
						<h3><?php _e("Tag and PHP Reference", "thankmelater"); ?></h3>
						
						<p>
							<?php _e("In all of the above text fields, you are able to use the following tags to insert pre-formed data:", "thankmelater"); ?>
							<div style="height: 115px; border: 1px solid #CCCCCC; overflow: auto;">
								<ul class="thankmelater_tags">
									<li class="name">&lt;$ID&gt;</li>
									<li><?php _e('ID of the comment', 'thankmelater'); ?></li>
									<li class="name">&lt;$POST_ID&gt;</li>
									<li><?php _e('ID of the post', 'thankmelater'); ?></li>
									<li class="name">&lt;$AUTHOR&gt;</li>
									<li><?php _e("Author's name", 'thankmelater'); ?></li>
									<li class="name">&lt;$AUTHOR_EMAIL&gt;</li>
									<li><?php _e("Author's e-mail address", 'thankmelater'); ?></li>
									<li class="name">&lt;$AUTHOR_URL&gt;</li>
									<li><?php _e("Author's website URL", 'thankmelater'); ?></li>
									<li class="name">&lt;$AUTHOR_IP&gt;</li>
									<li><?php _e("Author's IP address", 'thankmelater'); ?></li>
									<li class="name">&lt;$DATE&gt;</li>
									<li><?php _e('Date of the comment (as YYYY-MM-DD HH:MM:SS)', 'thankmelater'); ?></li>
									<li class="name">&lt;$DATE_GMT&gt;</li>
									<li><?php _e('GMT date of the comment (as YYYY-MM-DD HH:MM:SS)', 'thankmelater'); ?></li>
									<li class="name">&lt;$CONTENT&gt;</li>
									<li><?php _e('Content of the comment', 'thankmelater'); ?></li>
									<li class="name">&lt;$AGENT&gt;</li>
									<li><?php _e("Author's agent string", 'thankmelater'); ?></li>
									<li class="name">&lt;$PARENT&gt;</li>
									<li><?php _e("Comment's parent", 'thankmelater'); ?></li>
									<li class="name">&lt;$USER_ID&gt;</li>
									<li><?php _e("Author's user ID", 'thankmelater'); ?></li>
								</ul>
							</div>
						</p>
						
						<p><?php echo wp_specialchars(__("Any text contained within <?php and ?> will be evaluated as PHP code. Advanced users can use this to make more personal messages. Use the \$comment_id variable to get the ID of the current comment.", 'thankmelater')); ?></p>
						
						<p><?php echo wp_specialchars(__("Example code to display URL of the post:", "thankmelater")); ?></p>
						
						<code>
						<?php echo wp_specialchars('<?php $comment = get_comment($comment_ID, OBJECT); echo get_permalink($comment->comment_post_ID); ?>'); ?>
						</code>
						
						<p><?php echo wp_specialchars(__("If you use PHP, send a sample e-mail. If, after saving, a blank page appears, there is a fatal error in the PHP code which needs to be corrected.", "thankmelater")); ?></p>
						
					</div>
					
					<script type="text/javascript">
						document.getElementById("tml_tag_reference").style.display = "none";
						document.getElementById("newcontent").disabled = false;
					</script>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row"> 
					<label for="send_after"><?php _e("Message Delay", "thankmelater"); ?></label>
				</th>
				<td>
					<?php echo TML_form::input_checkbox("send_after_use_default", 1, $send_after_use_default, 7, array("id" => "send_after_use_default")) ?> 
						<?php _e("Use Default", "thankmelater"); ?><br />
					<span id="send_after_values">
					<?php
					
						list($time, $base) = TML_form::get_natural_time( $send_after );
						list($time_pm, $base_pm) = TML_form::get_natural_time( $send_after_plus_minus );
					
						printf( 
							__("%1\$s%2\$s &plusmn; %3\$s%4\$s", "thankmelater"), 
							TML_form::input_small_text("send_after", $time, 8), 
							TML_form::input_select_base("send_after_base", $base, 9),
							
							TML_form::input_small_text("send_after_plus_minus", $time_pm, 10), 
							TML_form::input_select_base("send_after_plus_minus_base", $base_pm, 11)
							
						);		
					?>
					</span>
				</td>
			</tr>
			
			<tr valign="top">
			<th scope="row"> 
				<label for="restrict_by_tags"><?php _e("Restrict by Tags", "thankmelater"); ?></label>
			</th>
			<td>
				<?php echo TML_form::input_checkbox("restrict_by_tags_use_default", 1, $restrict_by_tags_use_default, 12, array("id" => "restrict_by_tags_use_default")) ?> 
					<?php _e("Use Default", "thankmelater"); ?><br />
				<span id="restrict_by_tags_values">
				<?php
					
					$restrict_type = $restrict_by_tags_type; // 0 for exceptions list; 1 for white list
					$restrict_items = $restrict_by_tags_slugs; // hopefully, this is an array
					if( !is_array($restrict_items) ) // if not:
						$restrict_items = array(); // use an empty array
						
					// turn array into comma separated list
					$restrict_items_text = implode(", ",  $restrict_items);
				
					printf( 
						__("%1\$s%2\$s", "thankmelater"), // selection text-box
						TML_form::input_select_restriction_type("restrict_by_tags_type", $restrict_type, 13),
						TML_form::input_text("restrict_by_tags_slugs", $restrict_items_text, 14) 
					);	
				?>
				<small><?php _e('Comma separated list of tag <strong>slugs</strong> to restrict.', 'thankmelater'); ?></small>
				</span>
			</td>
		</tr>
		
		<tr valign="top">
			<th scope="row"> 
				<label for="restrict_by_catss"><?php _e("Restrict by Categories", "thankmelater"); ?></label>
			</th>
			<td>
				<?php echo TML_form::input_checkbox("restrict_by_cats_use_default", 1, $restrict_by_cats_use_default, 15, array("id" => "restrict_by_cats_use_default")); ?> 
					<?php _e("Use Default", "thankmelater"); ?><br />
				<span id="restrict_by_cats_values">
				<?php
					$restrict_type = $restrict_by_cats_type; // 0 for exceptions list; 1 for white list
					$restrict_items = $restrict_by_cats_slugs; // hopefully, this is an array
					if( !is_array($restrict_items) ) // if not:
						$restrict_items = array(); // use an empty array
						
					// turn array into comma separated list
					$restrict_items_text = implode(", ",  $restrict_items);
				
					printf( 
						__("%1\$s%2\$s", "thankmelater"), // selection text-box
						TML_form::input_select_restriction_type("restrict_by_cats_type", $restrict_type, 16),
						TML_form::input_text("restrict_by_cats_slugs", $restrict_items_text, 17) 
					);	
				?>
				<small><?php _e('Comma separated list of category <strong>slugs</strong> to restrict.', 'thankmelater'); ?></small>
				</span>
			</td>
		</tr>	
		
		<tr valign="top">
			<th scope="row"> 
				<label for="restrict_by_users"><?php _e("Restrict by Users", "thankmelater"); ?></label>
			</th>
			<td>
				<?php echo TML_form::input_checkbox("restrict_by_users_use_default", 1, $restrict_by_users_use_default, 18, array("id" => "restrict_by_users_use_default")) ?> 
					<?php _e("Use Default", "thankmelater"); ?><br />
				<span id="restrict_by_users_values">
				<?php
						
					printf( 
						__("%1\$s Only send e-mails to %2\$slogged in%3\$slogged out%4\$s users", "thankmelater") . "</label>", 
						'<label for="allow_opt_out">' . TML_form::input_checkbox("restrict_by_users", 1, $restrict_by_users, 19),
						'<select name="restrict_by_users_type" tabindex="20">'
							.'<option value="logged-in"' . ("logged-in" == $restrict_by_users_type ? ' selected="selected"' : '') .'>',
							'<option value="logged-out"' . ("logged-out" == $restrict_by_users_type ? ' selected="selected"' : '') .'>',
						'</select>'
					);
				
				?>
				</span>
			</td>
		</tr>
		
		<?php
		
			if (!isset($send_sample))
				$send_sample = 0;
				
			if (!isset($send_sample_email))
				$send_sample_email = get_bloginfo("admin_email");
				
		?>
		
		<tr valign="top">
			<th scope="row"> 
				<label for="send_sample"><?php _e("Sample E-mail", "thankmelater"); ?></label>
			</th>
			<td>
				<?php
						
					printf( 
						__("%1\$s Send sample e-mail to %2\$s", "thankmelater") . "</label>", 
						'<label for="send_sample">' . TML_form::input_checkbox("send_sample", 1, $send_sample, 21),
						TML_form::input_text("send_sample_email", $send_sample_email, 22) 
					);
				
				?>
			</td>
		</tr>
			
		</tbody>

	</table>
	
<script type="text/javascript">	

function show_hide_defaults(val) {
	if (document.getElementById(val+"_use_default").checked) {
		document.getElementById(val+"_values").style.display = "none";
	} else {
		document.getElementById(val+"_values").style.display = "";
	}
}

var default_vals = ["send_after", "restrict_by_tags", "restrict_by_cats", "restrict_by_users"];

for (var i in default_vals) {
	var val = default_vals[i];
	show_hide_defaults(val);
	
	var f = new Function("show_hide_defaults('" + val + "')");
	document.getElementById(val+"_use_default").onchange = f;
	document.getElementById(val+"_use_default").onmouseup = f;
}
</script>
	
<p class="submit">
	<input type="submit" name="Submit" style="font-weight: bold;" tabindex="23" value="<?php 
		
		if(isset($msgid))
			_e("Update Message", "thankmelater"); 
		else
			_e("Save Message", "thankmelater"); 
	
	?>" />
	
	<?php if (!isset($msgid)) { ?>
		<input type="submit" name="draft" tabindex="24" value="<?php _e("Save as Draft", "thankmelater"); ?>" />
	<?php } ?>
	
	<?php 
		if(isset($msgid)) { 
	?>	
		<a class="submitdelete deletion" style="margin-left: 25px; color: #FF0000;" href="?<?php echo attribute_escape( TML_admin_pages_hierarchy::build_query($tml_admin_messages->level_id, "delete_message") . "&msgid=" . urlencode($msgid) . "&checksum=" . urlencode($checksum) ); ?>" tabindex="25"><?php _e("Delete", "thankmelater"); ?></a>
	<?php } ?>
	
</p>
	
</form>