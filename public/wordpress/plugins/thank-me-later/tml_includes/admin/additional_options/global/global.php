<?php

global $tml, $user_level, $tml_admin_additional_options, $tml_admin, $tml_form_errors, $time_bases;

if( !is_object($tml) || !current_user_can("edit_plugins") ) {
	echo __("Sorry: you can not configure Thank Me Later with your account.", "thankmelater");
	exit;
}

$values = array(
		"max_messages"              => 0,
		"unique_messages_only"      => true,
		"unique_unless_all_sent"    => true,
		"comment_gap"               => 0,
		"send_gap"                  => 0,
		"allow_opt_out"             => true,
		"show_opt_out"              => true,
		//"restrict_by_users"         => true,
		//"restrict_by_users_type"    => ""
	);

foreach($values as $k => $v) {

	$is_bool = is_bool($v);
	
	// load the option from the database; store it in $values
	if( false !== ($_val = $tml->get_option($k)) ) {
		if($is_bool)
			$values[$k] = (bool)$_val;
		else
			$values[$k] = $_val;
	}
}

if( $_POST ) {

	###		time adjustments (put into seconds)		###	
	if(!$_POST["comment_gap_base"])
		$_POST["comment_gap_base"] = 1;
	$_POST["comment_gap"] *= $_POST["comment_gap_base"];
	
	if(!$_POST["send_gap_base"])
		$_POST["send_gap_base"] = 1;
	$_POST["send_gap"] *= $_POST["send_gap_base"];
}


$values = TML_form::merge_post_data($values); // overwrite values with the posted ones
	
if(isset($_POST) && $_POST):

	check_admin_referer("thank-me-later-admin-additional-options-global");
	
	if ($values["max_messages"] < 0 || !ctype_digit($values["max_messages"]))
		$tml_form_errors->add_error( "max_messages", __("'Max messages' must be a non-negative integer.", "thankmelater") );
		
	if ($values["comment_gap"] < 0)
		$tml_form_errors->add_error( "comment_gap", __("'Comment Gap' must be non-negative.", "thankmelater") );
		
	if ($values["send_gap"] < 0)
		$tml_form_errors->add_error( "send_gap", __("'Send Gap' must be non-negative.", "thankmelater") );

	if (!$tml_form_errors->has_errors) { // no errors
	
		foreach($values as $k => $v) {
			$tml->update_option($k, $v);
		}
		
		?>
		<p><div id="message" class="updated"><p><strong><?php _e("The options have been saved.", 'thankmelater'); ?></strong></p></div></p>
		<?php
	} else {
		?><p><div id="message" class="error"><p><strong>
			<?php 
				$tml_form_errors->list_errors();
			?>
		</strong></p></div></p><?php
		
	}
	
endif;

extract($values);

?>

<form method="post" action="?<?php  echo attribute_escape( TML_admin_pages_hierarchy::build_query() );  ?>">

	<?php  wp_nonce_field("thank-me-later-admin-additional-options-global");  ?>
	
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"> 
					<label for="max_messages"><?php _e("Maximum number of messages", "thankmelater"); ?></label>
				</th>
				<td>
					<?php					
						echo TML_form::input_small_text("max_messages", $max_messages, 1);
					?>
					<span class="setting-description"><?php _e("Maximum number of e-mails to send to a single e-mail address. Use '0' for no limit.", "thankmelater"); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"> 
					<?php _e("Send unique messages only", "thankmelater"); ?>
				</th>
				<td>
					<fieldset>
					
						<legend class="hidden"><?php _e("Send unique messages only", "thankmelater"); ?></legend>
						
						<?php
						
							printf( 
								__("%1\$s Do not send the same message twice to the same address %2\$s unless all messages have been sent.", "thankmelater") . "</label>", 
								'<label for="unique_messages_only">' . TML_form::input_checkbox("unique_messages_only", 1, $unique_messages_only, 2),
								'</label><label for="unique_unless_all_sent">' . TML_form::input_checkbox("unique_unless_all_sent", 1, $unique_unless_all_sent, 3)
							);
						
						?>

					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"> 
					<label for="comment_gap"><?php _e("Comment Gap", "thankmelater"); ?></label>
				</th>
				<td>
					<?php
					
						list($time, $base) = TML_form::get_natural_time( $comment_gap );
					
						printf( 
							__("%1\$s%2\$s", "thankmelater"), 
							TML_form::input_small_text("comment_gap", $time, 4), 
							TML_form::input_select_base("comment_gap_base", $base, 5)
							
						);		
					?>
					<span class="setting-description"><?php _e("Time to ignore comments from users since their last comment.", "thankmelater"); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"> 
					<label for="send_gap"><?php _e("Send Gap", "thankmelater"); ?></label>
				</th>
				<td>
					<?php
					
						list($time, $base) = TML_form::get_natural_time( $send_gap );
					
						printf( 
							__("%1\$s%2\$s", "thankmelater"), 
							TML_form::input_small_text("send_gap", $time, 6), 
							TML_form::input_select_base("send_gap_base", $base, 7)
							
						);		
					?>
					<span class="setting-description"><?php _e("Minimum time between sending e-mails.", "thankmelater"); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"> 
					<?php _e("Opt out", "thankmelater"); ?>
				</th>
				<td>
					<fieldset>
					
						<legend class="hidden"><?php _e("Opt out", "thankmelater"); ?></legend>
						
						<?php
						
							printf( 
								__("%1\$s Allow visitors to opt-out at %2\$s", "thankmelater") . "</label>", 
								'<label for="allow_opt_out">' . TML_form::input_checkbox("allow_opt_out", 1, $allow_opt_out, 8),
								'<a href="'. attribute_escape(get_bloginfo("url")."/?tmloptout") .'" target="_blank">'. wp_specialchars(get_bloginfo("url")."/?tmloptout") .'</a>'
							);
						
						?>
						<br />
						<?php
						
							printf( 
								__("%1\$s Show the opt-out link under the comment form.", "thankmelater") . "</label>", 
								'<label for="show_opt_out">' . TML_form::input_checkbox("show_opt_out", 1, $show_opt_out, 9)
							);
						
						?>

					</fieldset>
				</td>
			</tr>
			<?php if(false): ?><tr valign="top">
				<th scope="row"> 
					<?php _e("Restrict by Users", "thankmelater"); ?>
				</th>
				<td>
					<fieldset>
					
						<legend class="hidden"><?php _e("Restrict by Users", "thankmelater"); ?></legend>
						
						<?php
						
							printf( 
								__("%1\$s Only send e-mails to %2\$slogged in%3\$slogged out%4\$s users", "thankmelater") . "</label>", 
								'<label for="allow_opt_out">' . TML_form::input_checkbox("restrict_by_users", 1, $restrict_by_users, 10),
								'<select name="restrict_by_users_type">'
									.'<option value="logged-in"' . ("logged-in" == $restrict_by_users_type ? ' selected="selected"' : '') .'>',
									'<option value="logged-out"' . ("logged-out" == $restrict_by_users_type ? ' selected="selected"' : '') .'>',
								'</select>'
							);
						
						?>

					</fieldset>
				</td>
			</tr>
			<?php endif; ?>
		</tbody>
	
	</table>
	
	<p class="submit">
		<input type="submit" name="Submit" value="<?php  _e("Update Options", "thankmelater");  ?>" tabindex="11" />		
	</p>
	
</form>