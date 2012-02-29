<?php

global $tml, $user_level, $tml_admin_messages, $tml_admin, $msgid, $checksum, $restrict_by_tags_use_default, $restrict_by_tags_type, $restrict_by_tags_slugs, $restrict_by_cats_use_default, $restrict_by_cats_type, $restrict_by_cats_slugs, $tml_form_errors, $wpdb;

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

###		Populate fields with the default values		###
$values = array(
		"from_name"                   => $tml->get_option("from_name"),
		"from_email"                  => $tml->get_option("from_email"),
		"message_subject"             => $tml->get_option("message_subject"),
		"use_html"                    => false,
		"nl2br"                       => true,
		"message_body"                => $tml->get_option("message_body"),
		"send_after_use_default"      => true,
		"send_after"                  => $tml->get_option("send_after"),
		"send_after_plus_minus"       => $tml->get_option("send_after_plus_minus"),
		"restrict_by_tags_use_default"=> true,
		"restrict_by_tags_type"       => $tml->get_option("restrict_by_tags_type"),
		"restrict_by_tags_slugs"      => $tml->get_option("restrict_by_tags_slugs"),
		"restrict_by_cats_use_default"=> true,
		"restrict_by_cats_type"       => $tml->get_option("restrict_by_cats_type"),
		"restrict_by_cats_slugs"      => $tml->get_option("restrict_by_cats_slugs"),
		"restrict_by_users_use_default"=> true,
		"restrict_by_users"           => $tml->get_option("restrict_by_users"),
		"restrict_by_users_type"      => $tml->get_option("restrict_by_users_type"),
		"prob"                        => 0,
		"uid"                         => -1 // will be set on save
	);
	
###		Unserialize		###
$values["restrict_by_tags_slugs"] = @unserialize($values["restrict_by_tags_slugs"]);
if( !is_array($values["restrict_by_tags_slugs"]) )
	$values["restrict_by_tags_slugs"] = array();
	
$values["restrict_by_cats_slugs"] = @unserialize($values["restrict_by_cats_slugs"]);
if( !is_array($values["restrict_by_cats_slugs"]) )
	$values["restrict_by_cats_slugs"] = array();


if( $_POST ) {
	// to hack our way in with syntax highlighting.
	$_POST["message_body"] = $_POST["newcontent"];
	
	// time adjustments (put into seconds)
	
	if(!$_POST["send_after_base"])
		$_POST["send_after_base"] = 1;
	$_POST["send_after"] *= $_POST["send_after_base"];
	
	if(!$_POST["send_after_plus_minus_base"])
		$_POST["send_after_plus_minus_base"] = 1;
	$_POST["send_after_plus_minus"] *= $_POST["send_after_plus_minus_base"];
}
	
$values = TML_form::merge_post_data($values); // overwrite values with the posted ones

// used on the form
extract($values);

if( $_POST ):

	// safety:
	check_admin_referer("thank-me-later-admin-messages-new-message");
	
	###		Turn text lists into array types		###
	if( !is_array($values["restrict_by_tags_slugs"]) )
		$values["restrict_by_tags_slugs"] = TML_form::list_to_array($values["restrict_by_tags_slugs"]);
		
	if( !is_array($values["restrict_by_cats_slugs"]) )
		$values["restrict_by_cats_slugs"] = TML_form::list_to_array($values["restrict_by_cats_slugs"]);
	
	// keep track of errors
	//$tml_form_errors = new TML_form_errors();
	
	//// get the current messages array
	//$opt_messages = $tml->get_option("messages");	
	//$opt_messages = unserialize( $opt_messages );	
	//if( ! is_array($opt_messages) )
	//	$opt_messages = array();
	
	// the number of messages there CURRENTLY are; before new message added
	//$numMessages = count($opt_messages);
	$numMessages = 0;
	foreach ($opt_messages as $m) {
		if ($m["prob"])
			$numMessages++;
	}
		
	// the message should have this probability:
	// (the "fair" case in which the probabilities are shared equally)
	if (isset($_POST["draft"]))
		$prob = 0;
	else{
		$prob = 1 / ( $numMessages + 1 );
		$values["prob"] = $prob;
		
		// reduce the current probabilities
		if($numMessages) {
			$prob_sum = 1 / $numMessages; // current "fair" probability plus...
			foreach($opt_messages as $m)
				$prob_sum += $m["prob"]; // each individual probability	(total p should be 1; but just in case)	
			foreach($opt_messages as $i => $m)
				$opt_messages[ $i ]["prob"] = $m["prob"] / $prob_sum; // reduce each value to make room for the new "fair" probability
		}
	}
	
	// generate a unique identifying number
	$values["uid"] = $tml->get_unique_id();
	
	// append the new message
	$opt_messages[] = $values;

	if($send_after < 0)
		$tml_form_errors->add_error( "send_after", __("Message Delay time must not be negative.", "thankmelater") );
		
	if($send_after_plus_minus < 0)
		$tml_form_errors->add_error( "send_after_plus_minus", __("Message Delay plus-minus time must not be negative.", "thankmelater") );	
	
	if( !$tml_form_errors->has_errors ) { // no errors
	
		// update the option
		$tml->update_option( "messages", $opt_messages );
	
		// show friendly success message
		$message = __("Your message has been added. %sGo to messages overview &raquo;%s", 'thankmelater');
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
					"message_uid" => $opt_messages[ count($opt_messages)-1 ]["uid"]
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

	}else{
		
		// show error message
		?>
		<p><div id="message" class="error"><p><strong>
			<?php 
				$tml_form_errors->list_errors();
			?>
		</strong></p></div></p>
		<?php
		
		// include the form to fix errors
		require_once TML_DIR . "/" . TML_INCLUDES_DIR . "admin/messages/edit_message/message_form.php";
	}
	
else: // no POST
	// include the form
	require_once TML_DIR . "/" . TML_INCLUDES_DIR . "admin/messages/edit_message/message_form.php";
endif;