<?php

global $tml, $user_level, $tml_admin_additional_options, $tml_admin, $tml_form_errors, $time_bases;

if( !is_object($tml) || !current_user_can("edit_plugins") ) {
	echo __("Sorry: you can not configure Thank Me Later with your account.", "thankmelater");
	exit;
}

$values = array(
		"send_after"                => 0,
		"send_after_base"           => 0,
		"send_after_plus_minus"     => 0,
		"send_after_plus_minus_base"=> 0,
		"restrict_by_tags_type"     => 0,
		"restrict_by_tags_slugs"    => array(),
		"restrict_by_cats_type"     => 0,
		"restrict_by_cats_slugs"    => array(),
		"restrict_by_users"         => true,
		"restrict_by_users_type"    => ""
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

###		Unserialize		###
$values["restrict_by_tags_slugs"] = @unserialize($values["restrict_by_tags_slugs"]);
if( !is_array($values["restrict_by_tags_slugs"]) )
	$values["restrict_by_tags_slugs"] = array();
	
$values["restrict_by_cats_slugs"] = @unserialize($values["restrict_by_cats_slugs"]);
if( !is_array($values["restrict_by_cats_slugs"]) )
	$values["restrict_by_cats_slugs"] = array();

$values = TML_form::merge_post_data($values); // overwrite values with the posted ones
	
if( $_POST ):

	check_admin_referer("thank-me-later-admin-additional-options-message-defaults");

	if( $values["send_after_base"] )
		$values["send_after"] *= $values["send_after_base"];
		
	if( $values["send_after_plus_minus_base"] )
		$values["send_after_plus_minus"] *= $values["send_after_plus_minus_base"];
	
	###		Turn text lists into array types		###
	if( !is_array($values["restrict_by_tags_slugs"]) )
		$values["restrict_by_tags_slugs"] = TML_form::list_to_array($values["restrict_by_tags_slugs"]);
		
	if( !is_array($values["restrict_by_cats_slugs"]) )
		$values["restrict_by_cats_slugs"] = TML_form::list_to_array($values["restrict_by_cats_slugs"]);
		
	if ($values["send_after"] < 0)
		$tml_form_errors->add_error( "send_after", __("'Message Delay' time must be non-negative.", "thankmelater") );
		
	$values["send_after_plus_minus"] = abs($values["send_after_plus_minus"]);

	if (!$tml_form_errors->has_errors) { // no errors

		// update options
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

	<?php  wp_nonce_field("thank-me-later-admin-additional-options-message-defaults");  ?>

	<p><?php _e("These options can be overridden on a per-message basis.", "thankmelater"); ?></p>
	
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"> 
					<label for="send_after"><?php _e("Message Delay", "thankmelater"); ?></label>
				</th>
				<td>
					<?php
					
						list($time, $base) = TML_form::get_natural_time( $send_after );
						list($time_pm, $base_pm) = TML_form::get_natural_time( $send_after_plus_minus );
					
						printf( 
							__("%1\$s%2\$s &plusmn; %3\$s%4\$s", "thankmelater"), 
							TML_form::input_small_text("send_after", $time, 1), 
							TML_form::input_select_base("send_after_base", $base, 2),
							
							TML_form::input_small_text("send_after_plus_minus", $time_pm, 3), 
							TML_form::input_select_base("send_after_plus_minus_base", $base_pm, 4)
							
						);		
					?>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row"> 
					<label for="restrict_by_tags"><?php _e("Restrict by Tags", "thankmelater"); ?></label>
				</th>
				<td>
					<?php
						
						$restrict_type = $restrict_by_tags_type; // 0 for exceptions list; 1 for white list
						$restrict_items = $restrict_by_tags_slugs; // hopefully, this is an array
						
						if( !is_array($restrict_items) ) // if not:
							$restrict_items = array(); // use an empty array
							
						// turn array into comma separated list
						$restrict_items_text = implode(", ",  $restrict_items);
					
						printf( 
							__("%1\$s%2\$s", "thankmelater"), // selection text-box
							TML_form::input_select_restriction_type("restrict_by_tags_type", $restrict_type, 5),
							TML_form::input_text("restrict_by_tags_slugs", $restrict_items_text, 6) 
						);	
					?>
					<small><?php _e('Comma separated list of tag <strong>slugs</strong> to restrict.', 'thankmelater'); ?></small>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row"> 
					<label for="restrict_by_catss"><?php _e("Restrict by Categories", "thankmelater"); ?></label>
				</th>
				<td>
					<?php
						
						$restrict_type = $restrict_by_cats_type; // 0 for exceptions list; 1 for white list
						$restrict_items = $restrict_by_cats_slugs; // hopefully, this is an array
						if( !is_array($restrict_items) ) // if not:
							$restrict_items = array(); // use an empty array
							
						// turn array into comma separated list
						$restrict_items_text = implode(", ",  $restrict_items);
					
						printf( 
							__("%1\$s%2\$s", "thankmelater"), // selection text-box
							TML_form::input_select_restriction_type("restrict_by_cats_type", $restrict_type, 7),
							TML_form::input_text("restrict_by_cats_slugs", $restrict_items_text, 8) 
						);	
					?>
					<small><?php _e('Comma separated list of category <strong>slugs</strong> to restrict.', 'thankmelater'); ?></small>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row"> 
					<?php _e("Restrict by Users", "thankmelater"); ?>
				</th>
				<td>
					<fieldset>
					
						<legend class="hidden"><?php _e("Restrict by Users", "thankmelater"); ?></legend>
						
						<?php
						
							printf( 
								__("%1\$s Only send e-mails to %2\$slogged in%3\$slogged out%4\$s users", "thankmelater") . "</label>", 
								'<label for="allow_opt_out">' . TML_form::input_checkbox("restrict_by_users", 1, $restrict_by_users, 9),
								'<select name="restrict_by_users_type" tabindex="10">'
									.'<option value="logged-in"' . ("logged-in" == $restrict_by_users_type ? ' selected="selected"' : '') .'>',
									'<option value="logged-out"' . ("logged-out" == $restrict_by_users_type ? ' selected="selected"' : '') .'>',
								'</select>'
							);
						
						?>

					</fieldset>
				</td>
			</tr>
			
		</tbody>
	
	</table>
	
	<p class="submit">
		<input type="submit" name="Submit" value="<?php  _e("Update Options", "thankmelater");  ?>" tabindex="11" />		
	</p>
	
</form>