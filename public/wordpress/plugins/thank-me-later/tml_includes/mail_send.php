<?php

global $tml, $tml_comment, $tml_send;

if( !is_object($tml) )
	exit;
	
class TML_send {
	var $comment_id = 0;
	var $html = false;

	// gets a message with a given UID (looks through each message).
	function get_message($uid) {
		global $tml;
	
		$opt_messages = $tml->get_option("messages");
		
		if (!is_array($opt_messages)) {
			$opt_messages = unserialize($opt_messages);
		}
		
		if ( ! is_array($opt_messages) )
			return array(); // no message
			
		foreach ($opt_messages as $message) {
			if ($message["uid"] == $uid)
				return $message; // /the/ message
		}
		
		return array();
	}

	function send_for($id) {
		global $wpdb, $tml;
		
		// get the comment and message identifiers
		$result = $wpdb->get_row( $wpdb->prepare("SELECT message_uid, comment_ID FROM " . $tml->table_name("queue") . " WHERE ID = %d", $id) );
		
		if (!$result)
			return;
		
		$message_uid = $result->message_uid;
		$comment_id  = $result->comment_ID;
		
		// remove the message from the queue: we are done with it!
		$wpdb->query( $wpdb->prepare("DELETE FROM ". $tml->table_name("queue") ." WHERE ID = %d", $id) );
		
		$message = $this->get_message($message_uid);
		$comment = get_comment($comment_id, OBJECT); // comment object
		
		// comment/message doesn't exist?
		if (!($message && $comment))
			return;
			
		$this->comment_id = $comment->comment_ID;
		$this->html       = false;
			
		$msg     = $this->parse_dyntext($message["message_body"],    $comment);
		$name    = $this->parse_dyntext($message["from_name"],       $comment);
		$email   = $this->parse_dyntext($message["from_email"],      $comment);
		$subject = $this->parse_dyntext($message["message_subject"], $comment);	
		
		###		Is the user subscribed to recieve e-mails		###
		$send = true;		
		if ($tml->get_option("allow_opt_out")) {
			
			$opt = $wpdb->get_var(
				$wpdb->prepare("SELECT subscribed FROM " . $tml->table_name("emails") . " WHERE email = %s",
					$comment->comment_author_email
				)
			);
			
			if ($opt !== NULL) {
				$send = $opt ? true : false;
			}
		}
		
		if (!$send) // not subscribed: do not send
			false;
			
		###		Set the 'From:' header		###		
		$from_header = "From: ". get_bloginfo("admin_email");
		
		if($message["from_name"] && $message["from_email"])
			$from_header = "From: ". $name ." <". $email .">";
		elseif($message["from_name"]) // assume from_email
			$from_header = "From: ". $name ." <". $email .">";
		elseif($message["from_email"])
			$from_header = "From: ". $email;
		
		###		HTML?		###
		$content_type_header = "Content-Type: text/plain";
			
		if($message["use_html"]) { 
			$this->html = true;
			$content_type_header = "Content-Type: text/html";
			if($message["nl2br"])
				$msg = nl2br($msg);
		};
		
		$headers = array($from_header);
		if ($content_type_header) 
			$headers[] = $content_type_header;
			
		$wpdb->insert(
			$tml->table_name("log"),
			array('email' => $comment->comment_author_email, 'comment_ID' => $comment_id, 'send_time' => time(), 'subject' => $subject, 'message' => $msg),
			array( '%s', '%d','%d','%s','%s' )
		);
		
		wp_mail($comment->comment_author_email, $subject, $msg, $headers);
	}
	
	// evalute PHP code
	function eval_php($php) {
		$php = $php[1];
		$php = '$comment_ID = '.$this->comment_id.';$comment_id = '.$this->comment_id.';'.$php;
	
		ob_start();
		$ret = @eval($php);
		if(!$ret) {
			$ret = ob_get_contents();
		}
		ob_end_clean();
	
		return $ret;
	}
	
	// parse the 'dynamic' text
	function parse_dyntext($text, $comment) {
		$text = preg_replace_callback('/<\?php((.|\n|\r)*?)\?>/i', array(&$this, "eval_php"), $text);
		
		$replace = array();
		$with    = array();
		
		foreach ($comment as $k => $c) {
			$replace[] = "<$". strtoupper(preg_replace("#^comment_#i", "", $k)) .">";
			$with[]    = $c;
		}
		
		if ($this->html) 
			$with = array_map('htmlspecialchars', $with);
			
		if (function_exists("str_ireplace"))
			$text = str_ireplace($replace, $with, $text);
		else
			$text = str_replace($replace, $with, $text);
		
		return $text;
	}
}

$tml_send = new TML_send();

?>