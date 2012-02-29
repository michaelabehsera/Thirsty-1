<?php

global $tml, $user_level, $tml_admin_additional_options, $tml_admin, $tml_form_errors, $time_bases;

###		Standard authorization check		###
if( !is_object($tml) || !current_user_can("edit_plugins") ) {
	echo __("Sorry: you can not configure Thank Me Later with your account.", "thankmelater");
	exit;
}


// default values
$values = array(
		"syntax_highlighting"       => true,
		"promote"                   => true
	);
	
###		Load options		###

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

$values = TML_form::merge_post_data($values); // overwrite values with the posted ones
	
if(isset($_POST) && $_POST):

	check_admin_referer("thank-me-later-admin-additional-options-misc");

	foreach($values as $k => $v) {
		$tml->update_option($k, $v);
	}
	
	?>
	<p><div id="message" class="updated"><p><strong><?php _e("The options have been saved.", 'thankmelater'); ?></strong></p></div></p>
	<?php
	
endif;

extract($values);

?>

<form method="post" action="?<?php  echo attribute_escape( TML_admin_pages_hierarchy::build_query() );  ?>">

	<?php  wp_nonce_field("thank-me-later-admin-additional-options-misc");  ?>
	
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row">
					<?php _e("Syntax Highlighting", "thankmelater"); ?>
				</th>
				<td>
					<fieldset>
					
						<legend class="hidden"><?php _e("Syntax Highlighting", "thankmelater"); ?></legend>
						
						<label for="syntax_highlighting"><?php echo TML_form::input_checkbox("syntax_highlighting", 1, $syntax_highlighting, 1); ?> <?php _e("Enable syntax highlighting for editing messages.", "thankmelater"); ?></label>

					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<?php _e("Promote TML", "thankmelater"); ?>
				</th>
				<td>
					<fieldset>
					
						<legend class="hidden"><?php _e("Promote TML", "thankmelater"); ?></legend>
						
						<label for="promote"><?php echo TML_form::input_checkbox("promote", 1, TRUE, 2); ?> <?php _e("Add the 'We are using Thank Me Later' link back in the homepage footer.", "thankmelater"); ?></label>

					</fieldset>
				</td>
			</tr>
		</tbody>
	
	</table>
	
	<p class="submit">
		<input type="submit" name="Submit" value="<?php  _e("Update Options", "thankmelater");  ?>" tabindex="3" />		
	</p>
	
</form>