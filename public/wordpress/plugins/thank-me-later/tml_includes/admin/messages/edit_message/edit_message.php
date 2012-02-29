<?php

global $tml, $user_level, $tml_admin_messages, $tml_admin, $msgid, $checksum, $restrict_by_tags_use_default, $restrict_by_tags_type, $restrict_by_tags_slugs, $restrict_by_cats_use_default, $restrict_by_cats_type, $restrict_by_cats_slugs, $tml_form_errors, $tml_send, $wpdb;
	
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

// if only one message; assume that:
if( count($opt_messages) == 1 ) {
	$keys = array_keys($opt_messages);
	$_GET["msgid"] = $keys[0];
	$_GET["checksum"] = md5( serialize($opt_messages[$keys[0]]) );
}

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

if( $checksum != stripslashes($_GET["checksum"]) ) {
	_e("The message checksum is incorrect.", "thankmelater");
	exit;
}

###		Populate fields with the message's values		###
$values = array(
		"from_name"                   => $cur_message["from_name"],
		"from_email"                  => $cur_message["from_email"],
		"message_subject"             => $cur_message["message_subject"],
		"use_html"                    => $cur_message["use_html"] ? true: false,
		"nl2br"                       => $cur_message["nl2br"] ? true : false,
		"message_body"                => $cur_message["message_body"],
		"send_after_use_default"      => $cur_message["send_after_use_default"] ? true : false,
		"send_after"                  => $cur_message["send_after"],
		//"send_after_base"             => $cur_message["send_after_base"], // no reason to store bases
		"send_after_plus_minus"       => $cur_message["send_after_plus_minus"],
		//"send_after_plus_minus_base"  => $cur_message["send_after_plus_minus_base"],  // no reason to store bases
		"restrict_by_tags_use_default"=> $cur_message["restrict_by_tags_use_default"] ? true : false,
		"restrict_by_tags_type"       => $cur_message["restrict_by_tags_type"],
		"restrict_by_tags_slugs"      => $cur_message["restrict_by_tags_slugs"],
		"restrict_by_cats_use_default"=> $cur_message["restrict_by_cats_use_default"] ? true : false,
		"restrict_by_cats_type"       => $cur_message["restrict_by_cats_type"],
		"restrict_by_cats_slugs"      => $cur_message["restrict_by_cats_slugs"],
		"restrict_by_users_use_default"=>$cur_message["restrict_by_users_use_default"] ? true : false,
		"restrict_by_users"           => $cur_message["restrict_by_users"],
		"restrict_by_users_type"      => $cur_message["restrict_by_users_type"],
		"prob"                        => $cur_message["prob"],
		"uid"                         => $cur_message["uid"]
	);

if( $_POST ) {
	// to hack our way in with syntax highlighting.
	$_POST["message_body"] = $_POST["newcontent"];
	
	###		time adjustments (put into seconds)		###	
	if(!$_POST["send_after_base"])
		$_POST["send_after_base"] = 1;
	$_POST["send_after"] *= $_POST["send_after_base"];
	
	if(!$_POST["send_after_plus_minus_base"])
		$_POST["send_after_plus_minus_base"] = 1;
	$_POST["send_after_plus_minus"] *= $_POST["send_after_plus_minus_base"];
}
	
$values = TML_form::merge_post_data($values); // overwrite values with the posted ones

###		Turn text lists into array types		###
if( !is_array($values["restrict_by_tags_slugs"]) )
	$values["restrict_by_tags_slugs"] = TML_form::list_to_array($values["restrict_by_tags_slugs"]);
	
if( !is_array($values["restrict_by_cats_slugs"]) )
	$values["restrict_by_cats_slugs"] = TML_form::list_to_array($values["restrict_by_cats_slugs"]);

###		Use default values when the 'Use default' option is true		###
if( $values["send_after_use_default"] ) {
	$values["send_after"] = $tml->get_option("send_after");
	$values["send_after_plus_minus"] = $tml->get_option("send_after_plus_minus");
}

if( $values["restrict_by_tags_use_default"] ) { 
	$values["restrict_by_tags_type"] = $tml->get_option("restrict_by_tags_type");
	$values["restrict_by_tags_slugs"] = unserialize($tml->get_option("restrict_by_tags_slugs"));
	if( !is_array($values["restrict_by_tags_slugs"]) )
		$values["restrict_by_tags_slugs"] = array();
}

if( $values["restrict_by_cats_use_default"] ) {
	$values["restrict_by_cats_type"] = $tml->get_option("restrict_by_cats_type");
	$values["restrict_by_cats_slugs"] = unserialize($tml->get_option("restrict_by_cats_slugs"));
	if( !is_array($values["restrict_by_cats_slugs"]) )
		$values["restrict_by_cats_slugs"] = array();
}

if( $values["restrict_by_users_use_default"] ) {
	$values["restrict_by_users"]      = $tml->get_option("restrict_by_users");
	$values["restrict_by_users_type"] = $tml->get_option("restrict_by_users_type");
}
	
// used on the form
extract($values);

if( $_POST ):

	check_admin_referer("thank-me-later-admin-messages-new-message");
	
	//// all this was done earlier
	//$opt_messages = $tml->get_option("messages");
	//$opt_messages = unserialize( $opt_messages );
	
	//if( ! is_array($opt_messages) )
	//	$opt_messages = array();	
		
	// replace array element
	$opt_messages[ $msgid ] = $values;
	
	if ($send_after < 0)
		$tml_form_errors->add_error( "send_after", __("Message Delay time must not be negative.", "thankmelater") );
		
	if ($send_after_plus_minus < 0)
		$tml_form_errors->add_error( "send_after_plus_minus", __("Message Delay plus-minus time must not be negative.", "thankmelater") );	
	
	if (!$tml_form_errors->has_errors) { // no errors
	
		// update:
		$tml->update_option( "messages", $opt_messages );
		
		// change the checksum values; and current message
		$cur_message = $opt_messages[ $msgid ];
		$checksum = md5( serialize($cur_message) );
		
		// user friendly success message: (it /probably/ was successful)
		$message = __("Your message has been saved. %sGo to messages overview &raquo;%s", 'thankmelater');
		$message = sprintf($message, '<a href="?'.attribute_escape( TML_admin_pages_hierarchy::build_query( $tml_admin_messages->level_id, "overview" ) ).'">', '</a>');
		TML_form::show_message($message, TML_form::MESSAGE_UPDATED);
		
		###		Send the sample e-mail		###
		if (isset($_POST["send_sample"])) {
			$send_sample = 1;
			$send_sample_email = isset($_POST["send_sample_email"]) ? $_POST["send_sample_email"] : "";
			
			$posts = get_posts("numberposts=1&orderby=date");
			$post = $posts[0];
			
			// Create a fake, temporary comment.
			$comment = array('comment_post_ID' => $post->ID, 'comment_author' => 'Name', 'comment_author_email' => $send_sample_email, 'comment_author_url' => get_option('siteurl'), 'comment_author_IP' => $_SERVER['REMOTE_ADDR'], 'comment_date' => date('Y-m-d H:i:s'), 'comment_date_gmt' => gmdate('Y-m-d H:i:s'), 'comment_content' => 'This is just a sample comment that I\'ve written', 'comment_approved' => 1, 'comment_agent' => $_SERVER['HTTP_USER_AGENT'], 'comment_type' => '', 'comment_parent' => 0, 'user_id' => 0);
			
			$comment = get_comment(wp_insert_comment($comment), OBJECT);	
			
			$email_id = $wpdb->get_var( $wpdb->prepare("SELECT ID FROM " . $tml->table_name("emails") . " WHERE email = %s", $send_sample_email) );
			
			if($email_id === NULL) { // no row was found in the table: insert one; get an ID
				$wpdb->insert( $tml->table_name("emails"), array("email" => $send_sample_email, "subscribed" => true), array("%s", "%b") );
				$email_id = $wpdb->insert_id;	
			}
			
			$wpdb->insert( 
				$tml->table_name("queue"), 
				array(
					"email_ID"    => $email_id,
					"comment_ID"  => $comment->comment_ID,
					"send_time"   => time() - 3600,
					"message_uid" => $opt_messages[ $msgid ]["uid"]
				),
				array("%d", "%d", "%d", "%d") 
			);
			
			$sched_id = $wpdb->insert_id;
			$tml->send_mail($sched_id);
			
			// delete the comment
			wp_delete_comment($comment->comment_ID);
			
			$message = sprintf(__("A sample e-mail was sent to %s", 'thankmelater'), wp_specialchars($send_sample_email));
			TML_form::show_message($message, TML_form::MESSAGE_UPDATED);
			
		}
	} else {
		?><p><div id="message" class="error"><p><strong>
			<?php 
				$tml_form_errors->list_errors();
			?>
		</strong></p></div></p><?php
		
		
	}

//else:
endif;

	// this form is shared by edit_message and new_message
	require_once TML_DIR . "/" . TML_INCLUDES_DIR . "admin/messages/edit_message/message_form.php";

//endif;

?>