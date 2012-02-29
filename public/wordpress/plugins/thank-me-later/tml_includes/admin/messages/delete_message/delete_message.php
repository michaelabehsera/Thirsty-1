<?php

global $tml, $user_level, $tml_admin_messages, $tml_admin, $tml_form_errors, $msgid, $checksum;
	
###		Standard authorization check		###
if( !is_object($tml) || !current_user_can("edit_plugins") ) {
	echo __("Sorry: you can not configure Thank Me Later with your account.", "thankmelater");
	exit;
}

###		Get/select message		###
$opt_messages = $tml->get_option("messages");
$opt_messages = unserialize( $opt_messages );

if( ! is_array($opt_messages) )
	$opt_messages = array();

if( !isset($_GET["msgid"], $_GET["checksum"]) ) { // probably pointless (?)
	_e("Message ID or checksum not provided.", "thankmelater");
	exit;
}

$msgid = (int)$_GET["msgid"];

if( !isset($opt_messages[ $msgid ]) ) {
	_e("Message does not exist.", "thankmelater");
	exit; // exit is too harsh, maybe.
}

$cur_message = $opt_messages[ $msgid ];
$checksum = md5( serialize($cur_message) );

if( $checksum != stripslashes($_GET["checksum"]) ) { // using checksums to prevent overwriting the wrong message (it may be updated in another screen)
	_e("The message checksum is incorrect.", "thankmelater");
	exit;
}

###		Populate fields with the message's values (only the one's displayed are included)		###
$values = array(
		"from_name"       => $cur_message["from_name"],
		"from_email"      => $cur_message["from_email"],
		"message_subject" => $cur_message["message_subject"],
		"use_html"        => $cur_message["use_html"],
		"nl2br"           => $cur_message["nl2br"],
		"message_body"    => $cur_message["message_body"]
	);
	
//// no values are changed here
//$values = TML_form::merge_post_data($values); // overwrite values with the posted ones

// used on the form
extract($values);

if(isset($_POST["delete"]) && $_POST["delete"] == "yes"):

	check_admin_referer("thank-me-later-admin-messages-delete-message");
	
	//$opt_messages = $tml->get_option("messages");
	//$opt_messages = unserialize( $opt_messages );
	
	//if( ! is_array($opt_messages) )
	//	$opt_messages = array();
	
	unset($opt_messages[ $msgid ]); // delete the message
	
	// update so all probabilities equal 1
	$prob_sum = 0; 
	foreach($opt_messages as $m)
		$prob_sum += $m["prob"];
	if($prob_sum)
		foreach($opt_messages as $i => $m)
			$opt_messages[ $i ]["prob"] = $m["prob"] / $prob_sum; 
	
	$tml->update_option( "messages", $opt_messages );
	
	// user friendly success message:
	?>
	<p><div id="message" class="updated"><p><strong><?php printf(__("Your message has been deleted. %sGo to messages overview &raquo;%s", 'thankmelater'), '<a href="?'.attribute_escape( TML_admin_pages_hierarchy::build_query( $tml_admin_messages->level_id, "overview" ) ).'">', '</a>'); ?></strong></p></div></p>
	<?php
	
else:

?>

<table class="form-table">

	<tbody>
		<tr valign="top">
			<th scope="row">
				<?php _e("From Name", "thankmelater"); ?>
			</th>
			<td>
				<?php echo wp_specialchars($from_name); ?>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<?php _e("From E-mail", "thankmelater"); ?>
			</th>
			<td>
				<?php echo wp_specialchars($from_email); ?>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<?php _e("Message Subject", "thankmelater"); ?>
			</th>
			<td>
				<?php echo wp_specialchars($message_subject); ?>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<?php _e("Message Body", "thankmelater"); ?>
			</th>
			<td>
				<div style="height: 120px; overflow: auto; border: 1px solid #CCCCCC; padding: 5px;">
<pre><?php echo wp_specialchars($message_body); ?></pre>
				</div>
			</td>
		</tr>
	</tbody>

</table>

<p><div id="message" class="error"><p><strong><?php _e("Warning! If you delete this message, thank you e-mails will not be sent for any comments associated with this message. You may set the probability of this message to 0 rather than deleting it, if you wish. Are you sure you wish to delete this message?", "thankmelater"); ?>

<form method="post" action="?<?php echo attribute_escape( TML_admin_pages_hierarchy::build_query() . "&msgid=" . urlencode($msgid) . "&checksum=" . urlencode($checksum) ); ?>">
	<?php wp_nonce_field("thank-me-later-admin-messages-delete-message"); ?>
	<input type="hidden" value="yes" name="delete" />
	<p><input type="submit" name="submit" value="<?php echo attribute_escape(__("Yes, delete this message", "thankmelater")); ?>" tabindex="2" />
</form>
</strong></p></div></p>
<p><strong><a href="?<?php echo attribute_escape( TML_admin_pages_hierarchy::build_query( $tml_admin_messages->level_id, "overview" ) ); ?>" tabindex="2"><?php _e("No, do not delete this message", "thankmelater"); ?></a></strong></p>

<?php endif; ?>