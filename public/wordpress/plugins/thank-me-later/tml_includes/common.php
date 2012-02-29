<?php

class TML_Common extends TML_Options {
}

class TML_Options {
	// If you change any of this, you may lose all of your configuration settings.
	// There is no real reason to change these values (so don't).
	var $option_prefix = "_tml2.0_";
	//var $options_name = "options";
	
	// structure of allowed options (options to be stored in DB)
	var $allowed_options = array(
		"installed_version"           => true,
		"last_wpcron_tick"            => true,
		"last_pseudo_tick"            => true,
		
		// global option
		"max_messages"                => true,
		"unique_messages_only"        => true,
		"unique_unless_all_sent"      => true,
		"comment_gap"                 => true,
		"send_gap"                    => true,
		"allow_opt_out"               => true,
		"show_opt_out"                => true,
		"restrict_by_users"           => true,
		"restrict_by_users_type"      => true,
		
		// hold the messages
		"messages"                    => true,
		
		// message DEFAULTS
		"from_name"                   => true,
		"from_email"                  => true,
		"message_subject"             => true,
		"use_html"                    => true,
		"nl2br"                       => true,
		"message_body"                => true,  
		"send_after"                  => true,		
		"send_after_plus_minus"       => true,
		
		"restrict_by_tags_type"       => true,
		"restrict_by_tags_slugs"      => true,
		"restrict_by_cats_type"       => true,
		"restrict_by_cats_slugs"      => true,
		
		// misc (panel)
		"syntax_highlighting"         => true,
		"promote"                     => true,
		
		"uniq_id_cur"                 => 0
	);
	
	// default options
	// use non-zero for true; zero for false (NEVER USE FALSE)
	var $default_options = NULL;	
	
	// autoload options; only need to include "yes" variables
	var $options_autoloads = array(
		"installed_version" => "yes",
		"last_wpcron_tick"  => "yes",
		"promote"           => "yes",
		"allow_opt_out"     => "yes",
		"show_opt_out"      => "yes"
	);
	
	// set the default options (requires some evaluation)
	function load_default_options() {
	
		$blogname = get_option("blogname");
	
		$this->default_options = array(
		
			// global option
			"max_messages"                => 0,
			"unique_messages_only"        => 1,
			"unique_unless_all_sent"      => 1,
			"comment_gap"                 => 0,
			"send_gap"                    => 0,
			"allow_opt_out"               => 1,
			"show_opt_out"                => 0,
			//"restrict_by_users"           => 0,
			//"restrict_by_users_type"      => "logged-in",
			
			// hold the messages
			"messages"                    => array(),
			
			// message defaults
			"from_name"                   => $blogname,
			"from_email"                  => get_bloginfo('admin_email'),
			"message_subject"             => sprintf( __("Thank you for your comment at %1\$s", "thankmelater"), $blogname ),
			"use_html"                    => "false",
			"nl2br"                       => 1,
			"message_body"                => sprintf( __("Hi <\$AUTHOR>\n\nThank you for your comment at %1\$s (%2\$s). Be sure to come back soon. \n\nThank you,\n%1\$s\n\nYou posted the following comment:\n---------------------------------\n<\$CONTENT>", "thankmelater"), $blogname, get_option("home") ),
			"send_after"                  => 1800,
			"send_after_plus_minus"       => 0,
			"restrict_by_tags_type"       => 0,
			"restrict_by_tags_slugs"      => array("no-tml"),
			"restrict_by_cats_type"       => 0,
			"restrict_by_cats_slugs"      => array("no-tml"),
			"restrict_by_users"           => 0,
			"restrict_by_users_type"      => "logged-in",
			
			"syntax_highlighting"         => 0,
			"promote"                     => 0,
			
			"uniq_id_cur"                 => 1
		);
		
		// add the default message:
		$this->default_options["messages"][0] =
			array(
				"from_name"                   => $this->default_options["from_name"],
				"from_email"                  => $this->default_options["from_email"],
				"message_subject"             => $this->default_options["message_subject"],
				"use_html"                    => 0,
				"nl2br"                       => 1,
				"message_body"                => $this->default_options["message_body"],
				"send_after_use_default"      => 1,
				"send_after"                  => $this->default_options["send_after"],
				"send_after_plus_minus"       => $this->default_options["send_after_plus_minus"],
				"restrict_by_tags_use_default"=> 1,
				"restrict_by_tags_type"       => $this->default_options["restrict_by_tags_type"],
				"restrict_by_tags_slugs"      => $this->default_options["restrict_by_tags_slugs"],
				"restrict_by_cats_use_default"=> 1,
				"restrict_by_cats_type"       => $this->default_options["restrict_by_cats_type"],
				"restrict_by_cats_slugs"      => $this->default_options["restrict_by_cats_slugs"],
				"restrict_by_users_use_default"=> 1,
				"restrict_by_users"           => $this->default_options["restrict_by_users"],
				"restrict_by_users_type"      => $this->default_options["restrict_by_users_type"],
				"prob"                        => 1,
				"uid"                         => 0
			);
	}
	
	// return a unique id
	function get_unique_id() {
		$id = $this->get_option("uniq_id_cur");
		$this->update_option("uniq_id_cur", $id + 1);
		return $id;
	}
	
	// get a single option
	function get_option($name) {
		$opt = get_option( $this->option_prefix . $name );
		
		if($opt === false) {
			$opt = isset( $this->default_options[$name] ) ? $this->default_options[$name] : false;
			if($opt !== false) {
				$this->update_option( $name, $opt ); // ensure the option exists in the database
			}
			// default options are not serialized; so serialize them:
			if( is_array($opt) )
				$opt = serialize( $opt );
		}
		
		if (is_array($opt)) {
			$opt = serialize($opt); // wordpress now seems to unserialize for us!
		}

		return $opt;
	}
	
	// load the options we store (in $this->options)
	//function get_all_options() {
	//	$opts = get_option( $this->option_prefix . $this->options_name );
	//
	//	if($opts !== false) {
	//		if( ! is_array($opts) )
	//			$opts = unserialize( $opts );
	//		
	//		$this->options = array_merge( $this->options, $opts);
	//	}
	//}
	
	// update a single option
	function update_option( $name, $val, $autoload = "default" ) {	
		if(   !isset( $this->allowed_options[$name] )   ) 
			return false;
			
		if($autoload == "default") { // different options have different autoload requirements; save accordingly
			if( isset($this->options_autoloads[$name]) )
				$autoload = $this->options_autoloads[$name];
			else
				$autoload = "no";
		}
	
		$opt_name = $this->option_prefix . $name;
		$opt_val = (  is_object($val) || is_array($val)  )  ? serialize($val) : $val;

		return ( get_option($opt_name) !== false ) ? // option exists?
			update_option($opt_name, $opt_val )  // then, update
			: 
			add_option($opt_name, $opt_val, "", $autoload); // or, add it.
	}
	
	// delete option
	function delete_option($name) {
		if(   !isset( $this->allowed_options[$name] )   )
			return false;
			
		$name = $this->option_prefix . $name; // add prefix
			
		delete_option($name);
	}
	
	// update the DB's version of options (called at shutdown)
	/*function update_all_options() {
		$new_opts = array();
		
		// use the whilelist ($this->allowed_options) to remove
		// options not intended for the database
		foreach($this->options as $k => $v) {
			if($this->allowed_options[$k])
				$new_opts[$k] = $v;
		}
		$this->options = $new_opts;
		
		// for each option, update the DB's storage value; or add a value
		foreach( $this->options as $opt => $val) {
		
			$opt_name = $this->option_prefix . $opt;
			$opt_val = (is_object($val) || is_array($val)) ? serialize($val) : $val;
		
			if( get_option($opt_name) !== false ) // option already exists?
				update_option($opt_name, $opt_val ); 
			else
				add_option($opt_name, $opt_val, "", "no");
		}
		
		//update_option( $this->option_prefix . $this->options_name, serialize($this->options) );
	}*/
}

?>