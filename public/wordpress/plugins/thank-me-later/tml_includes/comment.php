<?php

global $tml, $tml_comment;

if( !is_object($tml) )
	exit;
	
class TML_comment {
	var $email_id = 0;
	function comment_post($id, $status) {
		global $wpdb, $tml;
		
		$comment = get_comment( $id, OBJECT ); // comment object
		$post_id = $comment->comment_post_ID;
		$post    = get_posts( "p=" . $post_id ); // the corresponding post (WP 2.6+)
		$tags    = $this->tax_obj_to_slug_array( get_the_tags( $post_id )     ); // and the tags, as slug arrays
		$cats    = $this->tax_obj_to_slug_array( get_the_category( $post_id ) ); // and the categories, as slug arrays
		
		$email   = $comment->comment_author_email;
		$email_id= $this->email_id( $email );
		$this->email_id = $email_id;
		
		// the time that the last TML message was sent.
		$last_send = $wpdb->get_var( 
			$wpdb->prepare("SELECT send_time FROM " . $tml->table_name("history") . " WHERE email_ID = %d ORDER BY send_time DESC LIMIT 0, 1",
				$email_id
			)
		);
		if ($last_send === NULL)
			$last_send = 0;
			
		if ($comment->comment_type != "") // is it /really/ a comment?
			return;
			
		//if (!$comment->comment_approved) // wait until message publsihed
		//	return;
		
		// if the status changes to hold, spam or delete, delete the
		// message from TML's table until it becomes approved.
		if (in_array($status, array("hold", "spam", "delete"))) {
			$this->remove_comment($id);
			return;
		}		
		
		// ~23 Sep 09 19:52 BST~
		// Replaced above with the fikkiwubgm becayse the DB information is out of date already!
		if (!$status || $status == "spam") // wait until publsihed...
			return;
			
		if( !$this->check_processed($id) )
			return;
			
		if( !$this->check_subscribed($email_id) )
			return;
			
		//if( !$this->check_user_restriction($email_id, $comment->user_id) )
		//	return;
		
		if( !$this->check_comment_gap($email_id) )
			return;
		
		if( !$this->check_message_limit($email_id) )
			return;
		
		$message = $this->get_message( $tags, $cats );
		
		if( !$message )
			return; // no message to send to the user: so don't
			
		// calculate the send time; with random plus-minus consideration
		$send_time = (int)(time() + $message["send_after"] - $message["send_after_plus_minus"] + mt_rand(0, $message["send_after_plus_minus"]*2));
		$uid = $message["uid"];
			
		// everything is OK at this stage: queue the message
		$wpdb->insert( 
			$tml->table_name("queue"), 
			array(
				"email_ID"    => $email_id,
				"comment_ID"  => $id,
				"send_time"   => $send_time,
				"message_uid" => $uid
			),
			array("%d", "%d", "%d", "%d") 
		);
		
		$queue_id = $wpdb->insert_id;
		
		// ... and insert row into history
		$wpdb->insert( 
			$tml->table_name("history"), 
			array(
				"comment_ID"  => $id,
				"email_ID"    => $email_id,
				"time"        => time(),
				"send_time"   => $send_time,
				"message_uid" => $uid,
				"use_as_unique"=> true,
			),
			array("%d", "%d", "%d", "%d", "%d", "%b") 
		);
		
		###		Create a CRON event to update around this time		###
		$need_at = $send_time;		
		wp_schedule_single_event($need_at, "_tml_singleUpdate", array($queue_id, $need_at)); 		
	}
	
	// remove a comment from TML's Tables
	function remove_comment( $comment_id ) {
		global $wpdb, $tml;
		$wpdb->query(
			$wpdb->prepare("DELETE FROM " . $tml->table_name("history") . " WHERE comment_ID = %d",
				$comment_id
			)
		);
		$wpdb->query(
			$wpdb->prepare("DELETE FROM " . $tml->table_name("queue") . " WHERE comment_ID = %d",
				$comment_id
			)
		);
		return true;
	}
	
	// get an email ID or create one
	// if a row doesn't yet exist
	function email_id( $email ) {
		global $tml, $wpdb;
		$email_id= $wpdb->get_var( $wpdb->prepare("SELECT ID FROM " . $tml->table_name("emails") . " WHERE email = %s", $email) );
		
		if($email_id === NULL) { // no row was found in the table: insert one; get an ID
			$wpdb->insert( $tml->table_name("emails"), array("email" => $email, "subscribed" => true), array("%s", "%b") );
			$email_id = $wpdb->insert_id;	
		}
		
		return $email_id;
	}
	
	// check whether a message has already been processed
	// returns true if a message HASN'T been processed
	function check_processed( $comment_id ) {
		global $wpdb, $tml;
		
		$has_comment = $wpdb->get_var(
			$wpdb->prepare("SELECT COUNT(*) FROM " . $tml->table_name("history") . " WHERE comment_ID = %d",
				$comment_id
			)
		);
		
		return $has_comment ? false : true; // true for ok
	}
	
	// check whether a user has opted out of TML
	// true if they haven't
	function check_subscribed( $email_id ) {
		global $tml, $wpdb;
		
		// users can't opt out, so they are always subscribed
		if(!$tml->get_option("allow_opt_out"))
			return true;
		
		$opt = $wpdb->get_var(
			$wpdb->prepare("SELECT subscribed FROM " . $tml->table_name("emails") . " WHERE ID = %d",
				$email_id
			)
		);
		return $opt ? true : false; // true for ok
	}
	
	// check the 'restrict_by_users' option and,
	// restrict by logged (in|out) users
	// true if there is no restriction (ie continue)
	//function check_user_restriction($email_id, $logged_in = false) {
	//	global $tml, $wpdb;
	//	
	//	if(!$tml->get_option("restrict_by_users"))
	//		return true; // ok
	//		
	//	$type = $tml->get_option("restrict_by_users_type");
	//	//$logged_in = is_user_logged_in();
	//	
	//	if ("logged-in" == $type && $logged_in)
	//		return true;
			
	//	if ("logged-out" == $type && !$logged_in)
	//		return true;
	//		
	//	return false; // not OK
	//}
	
	// check whether the last comment made was made
	// before the 'comment_gap' time gap 
	function check_comment_gap( $email_id ) {
		global $tml, $wpdb;
		$comment_gap = $tml->get_option("comment_gap");
		$has_comments = $wpdb->get_var(
			$wpdb->prepare("SELECT COUNT(*) FROM " . $tml->table_name("history") . " WHERE email_ID = %d AND time > %d",
				$email_id,
				time() - (int)$comment_gap
			)
		);
		return $has_comments ? false : true; // true for ok
	}
	
	// check that the number of messages sent is less than the limit
	function check_message_limit( $email_id ) {
		global $tml, $wpdb;
		$limit = $tml->get_option("max_messages");
		
		if(!$limit) 
			return true; // no limit
		
		$num = $wpdb->get_var(
			$wpdb->prepare("SELECT COUNT(*) FROM " . $tml->table_name("history") . " WHERE email_ID = %d LIMIT 0, " . $limit,
				$email_id
			)
		);
		return ($num >= $limit) ? false : true; // true for ok
	}
	
	// get the time a message was last send to a user
	function get_last_send_time( $email_id ) {
		global $tml, $wpdb;
		
		// get the latest send time
		$time = $wpdb->get_var(
			$wpdb->prepare("SELECT send_time FROM " . $tml->table_name("history") . " WHERE email_ID = %d ORDER BY send_time DESC LIMIT 0, 1",
				$email_id
			)
		);
		
		return $time;
	}
	
	// see get_messages(). This function retrieves the
	// actual message a user will recieve, based on 
	// randomness and the chosen probability distribution.
	// (get_messages() does most of the hard work).
	function get_message( $tags = array(), $cats = array() ) {
		global $tml;
		
		$messages = $this->get_messages( $tags, $cats );
		//print_r($messages);
		if( !$messages ) // no messages
			return NULL;
			
		###		Select a random message		###			
		$prob_sum = 0;
		foreach($messages as $m)
			$prob_sum += $m["prob"]; // each individual probability	(total p should be 1; but just in case)	
			
		$mt_randmax = mt_getrandmax();
			
		// note: the following has been tested and produces
		// the correct probability distributions
		foreach( $messages as $m ) {
			$m_prob = $m["prob"]; // message probability
			if( mt_rand(0, $mt_randmax) / $mt_randmax * $prob_sum   <=   $m_prob )
				return $m; // if chance allows, return the message
			$prob_sum -= $m["prob"]; // reduce the total probability sum.
		}
		
	}
	
	// retrieve the messages that the user
	// is able to recieve, limited by the
	// tag and category restrictions, and
	// previously recieved constraints.   <!---------- NEED TO IMPLEMENT THIS! [DONE]
	// $tags: the ACTUAL tags
	// $cats: the ACTUAL categories
	function get_messages( $tags = array(), $cats = array(), $override_unique = FALSE ) {	
		global $tml, $wpdb;
		$opt_messages = $tml->get_option("messages");
		if (!is_array($opt_messages)) {
			$opt_messages = unserialize( $opt_messages );
		}

		if( ! is_array($opt_messages) )
			return array(); // no messages
			
		$messages = array();
		
		if($override_unique) {
			// set the 'use_as_unique' parameter to false
			$wpdb->query(
					$wpdb->prepare(
						"UPDATE " . $tml->table_name("history") . " SET use_as_unique = false WHERE email_ID = %d",
						$this->email_id
					)			
				);
		}
		
		$results = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT message_uid, COUNT(message_uid) FROM " . $tml->table_name("history") . " WHERE email_ID = %d AND use_as_unique = true GROUP BY message_uid",
					$this->email_id
				)			
			);
			
		$last_send = $this->get_last_send_time($this->email_id); // the last time a message was send (used for 'send after' adjustment, satisfying send_gap constraint
		$send_gap = $tml->get_option("send_gap");
		$time = time();
			
		$used = array(); // the messages already sent to the email
		foreach($results as $r) {
			$used[ $r->message_uid ] = 1;
		}
			
		foreach($opt_messages as $i => $m) {
			###		MESSAGE RESTRICTION SETTINGS		###
			$restrict_tags_type  = $m["restrict_by_tags_type"] ? 1 : 0; // 1 for inclusive; 0 for exclusive restriction
			$restrict_cats_type  = $m["restrict_by_cats_type"] ? 1 : 0;
			$restrict_tags_slugs = $m["restrict_by_tags_slugs"];
			$restrict_cats_slugs = $m["restrict_by_cats_slugs"];
			
			$restrict_users      = $m["restrict_by_users"];
			$restrict_users_type = $m["restrict_by_users_type"];
			
			###		GLOBAL DEFAULTS MAY OVERRIDE		###
			if( $m["restrict_by_tags_use_default"] ) { // load defaults for tags
				$restrict_tags_type  = $tml->get_option("restrict_by_tags_type");
				$restrict_tags_slugs = unserialize($tml->get_option("restrict_by_tags_slugs"));
			}			
			if( $m["restrict_by_cats_use_default"] ) { // load defaults for cats
				$restrict_cats_type = $tml->get_option("restrict_by_cats_type");
				$restrict_cats_slugs = unserialize($tml->get_option("restrict_by_cats_slugs"));
			}
			if( $m["restrict_by_users_use_default"] ) { // load defaults for user restrictions
				$restrict_users      = $tml->get_option("restrict_by_users");
				$restrict_users_type = $tml->get_option("restrict_by_users_type");
			}
			if( $m["send_after_use_default"] ) { // send after default
				$m["send_after"]            = $tml->get_option("send_after");
				$m["send_after_plus_minus"] = $tml->get_option("send_after_plus_minus");
			}
			
			###		Send Unique messages only		###
			if($tml->get_option("unique_messages_only")) {
				if( isset($used[$m["uid"]]) ) {
					continue; // do not use this message
				}
			}
			
			###		Restrict by users		###
			if ($restrict_users) {
				$logged_in = is_user_logged_in(); // is the user logged in?
				
				if ("logged-in"  == $restrict_users_type && !$logged_in)
					continue; // not logged in; should be
				if ("logged-out" == $restrict_users_type && $logged_in)
					continue; // logged in; shouldn't be.
			}
			
			###		Adjust the send after+-uncertainy to accord to the 'send_gap' constraint		###
			if ($send_gap) { // 0 denotes no effect
				$min_time = $time + $m["send_after"] - $m["send_after_plus_minus"];
				$max_time = $time + $m["send_after"] + $m["send_after_plus_minus"];
				$min_time = max($min_time, $last_send+$send_gap); 
				
				if ($max_time < ($last_send+$send_gap) || $min_time > $max_time ) {
					continue; // we can not meet the constraint => discard
				}
				
				// new values:
				$m["send_after_plus_minus"] = ($max_time - $min_time)/2; // half 'length'
				$m["send_after"]            = $min_time - $time + $m["send_after_plus_minus"]; // midpoint
				
			}
			
			###		ENSURE ARRAYS ARE ARRAYS		###
			if( !is_array($restrict_tags_slugs) )
				$restrict_tags_slugs = array();				
			if( !is_array($restrict_cats_slugs) )
				$restrict_cats_slugs = array();
			
			if(    $this->check_restriction( $restrict_tags_type, $tags, $restrict_tags_slugs ) // tag restrictions
			    && $this->check_restriction( $restrict_cats_type, $cats, $restrict_cats_slugs ) // cat restrictions
				&& $m["prob"] > 0 // probability=0 => message never displayed
				) { // restrictions are satisfied?
				$messages[] = $m; // add message
			}
		}
		
		if( $tml->get_option("unique_messages_only") && $tml->get_option("unique_unless_all_sent") && !count($messages) && !$override_unique ) {
			$messages = $this->get_messages($tags, $cats, TRUE); // get messages again but reset the 'unique messages only' flags
		}
			
		return $messages;
	}
	
	// check a tag/category restriction and return true
	// if there is no restriction; false otherwise.
	// $type: 0 for exlusive; 1 for inclusive
	// $actual_slugs: array 1; the ACTUAL slugs
	// $restricted_slugs: array 2; the RESTRICTED slugs
	function check_restriction( $type, $actual_slugs, $restricted_slugs ) {
	
		if( !is_array($actual_slugs) || !is_array($restricted_slugs) || !$restricted_slugs )
			return true;
			
		switch( $type ) {
			case 0: // exlusive
				foreach( $actual_slugs as $s )
					if( in_array($s, $restricted_slugs) )
						return false; // slug not allowed
			break; 
			case 1: // inclusive
				$ok = false; // has a common slug
				foreach( $actual_slugs as $s ) 
					if( in_array($s, $restricted_slugs) )
						$ok = true; // matching slug found
				return $ok;
			break;
			default:
				return false;
		}
		return true;
	}
	
	// convert a "taxonomical object" (returned by get_the_tags() and get_the_category())
	// into arrays made up of their slugs
	function tax_obj_to_slug_array( $arr ) {
		if( !is_array($arr) )
			$arr = array();
			
		$ret = array();
		
		foreach($arr as $el) { // for each tag/cat
			$ret[] = $el->slug; // add slug
		}	
		
		return $ret;
	}
}

$tml_comment = new TML_comment();

?>