<?php

global $tml, $user_level, $tml_install;

if( !is_object($tml) )
	exit;
	
require_once ABSPATH . 'wp-admin/upgrade-functions.php';
	
class TML_Install {

	// hold table structure/create SQL
	var $tables = array(
			array(
				"name" => "emails",
				"structure" => array(
						"ID"               => array("Key"   => "PRI", "Extra" => "auto_increment"),
						"email"            => array("Key"   => "UNI"),
						"subscribed"       => array()
					),
				"sql" =>// automatically prefixed with CREATE TABLE <table_name>
						"(
						`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
						`email` VARCHAR(255) NOT NULL UNIQUE,
						`subscribed` BOOLEAN,
						PRIMARY KEY (`ID`)
						);"
			),
			array(
				"name" => "queue", // not the actual name; use $tml->table_name( [this name] ) to get the real name
				"structure" => array(
						"ID"         => array("Key"   => "PRI", "Extra" => "auto_increment"),
						"email_ID"   => array(),
						"comment_ID" => array("Key"   => "UNI"),
						"send_time"  => array("Key"   => "MUL"),
						"message_uid" => array()
					),
				"sql" =>// automatically prefixed with CREATE TABLE <table_name>
						"(
						`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
						`email_ID` INT UNSIGNED NOT NULL,
						`comment_ID` INT UNSIGNED NOT NULL UNIQUE,
						`send_time` INT UNSIGNED NOT NULL ,
						`message_uid` INT UNSIGNED NOT NULL,
						PRIMARY KEY ( `ID` ) ,
						INDEX ( `send_time` )
						);"
			),
			array(
				"name" => "history",
				"structure" => array(
						"comment_ID"       => array("Key"   => "PRI"),
						"email_ID"         => array("Key"   => "MUL"),
						"time"             => array(),
						"send_time"        => array(),
						"message_uid"      => array(),
						"use_as_unique"    => array()
					),
				"sql" =>// automatically prefixed with CREATE TABLE <table_name>
						"(
						`comment_ID` INT UNSIGNED NOT NULL,
						`email_ID` INT UNSIGNED NOT NULL,						
						`time` INT UNSIGNED NOT NULL ,
						`send_time` INT UNSIGNED NOT NULL,
						`message_uid` INT UNSIGNED NOT NULL,
						`use_as_unique` BOOLEAN,
						PRIMARY KEY ( `comment_ID` ),
						INDEX ( `email_ID` )
						);"
			),
			array(
				"name" => "log",
				"structure" => array(
						"ID"         => array("Key"   => "PRI", "Extra" => "auto_increment"),
						"email"   => array(),
						"comment_ID" => array(),
						"send_time"  => array(),
						"subject" => array(),
						"message" => array()
					),
				"sql" =>// automatically prefixed with CREATE TABLE <table_name>
						"(
						`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
						`email` VARCHAR(255) NOT NULL,
						`comment_ID` INT UNSIGNED NOT NULL,
						`send_time` INT UNSIGNED NOT NULL,
						`subject` TEXT NOT NULL,
						`message` TEXT NOT NULL,
						PRIMARY KEY ( `ID` ) 
						);"
			)
					
		);

	// upgrade tml from version 1.5.3.1 or below
	function upgrade_1_5_3_1() {
		global $tml;
		
		$old_opts = get_option("_tml_options");
		if( false !== $old_options && !is_array($old_opts) ) {
			$old_opts = unserialize( $old_opts );
		}elseif( !is_array($old_opts) )
			return false;
		
		###		map old options onto new		###
		
		// old tag/cat arrays stored like 'slug'=>1. Now stored like {'slug', 'slug', 'slug'}
		
		$tag_slugs = $old_opts["restrict_tagsArr"];
		if (!is_array($tag_slugs))
			$tag_slugs = array();
		$tag_slugs = array_flip($tag_slugs);
		
		$cat_slugs = $old_opts["restrict_categoriesArr"];
		if (!is_array($cat_slugs))
			$cat_slugs = array();
		$cat_slugs = array_flip($cat_slugs);
			
		$opts = array(
			"max_messages"     => $old_opts["maxSend"],
			"comment_gap"      => $old_opts["sendGap"],
			"messages"         => array(array(
					"from_name"                     => $old_opts["message_from"],
					"from_email"                    => $old_opts["message_fromemail"],
					"message_subject"               => $old_opts["message_subject"],
					"use_html"                      => ($old_opts["html"] == "true") ? 1 : 0,
					"nl2br"                         => 0,
					"message_body"                  => $old_opts["message_message"],
					"send_after_use_default"        => 0,
					"send_after"                    => $old_opts["sendafter"],
					"send_after_plus_minus"         => $old_opts["giveortake"],
					"restrict_by_tags_use_default"  => 0,
					"restrict_by_tags_type"         => $old_opts["restrict_tagsType"],
					"restrict_by_tags_slugs"        => $tag_slugs,
					"restrict_by_cats_use_default"  => 0,
					"restrict_by_cats_type"         => $old_opts["restrict_categoriesType"],
					"restrict_by_cats_slugs"        => $cat_slugs,
					"restrict_by_users_use_default" => 1,
					"restrict_by_users"             => $tml->get_option("restrict_by_users"),
					"restrict_by_users_type"        => $tml->get_option("restrict_by_users_type"),
					"prob"                          => 1,
					"uid"                           => 0					
				))
		);
		
		foreach ($opts as $name => $val) {
			$tml->update_option($name, $val);
		}
		
		// remove the 1.5.3.1 options
		delete_option( "_tml_options" );
		delete_option( "_tml_installed" );
		delete_option( "_tml_promote" );
	}
	
	// no previous versions of TML...
	function fresh_install() {
		global $tml;
		
	}
	
	// determine whether TML needs to be installed or upgraded.
	function install() {
		global $tml;	
	
		if( get_option("_tml_installed") ) { // upgrade from pre-1.5.3.1 version
			$this->upgrade_1_5_3_1();
		}elseif( $tml->get_option("installed_version") === false) {
			$this->fresh_install();
		}
		
		$this->install_database();
		
		$tml->update_option( "installed_version", $tml->version, "yes" );
		
	}
	
	// install/upgrade/check database's tables
	function install_database() {
		global $wpdb, $tml;
		
		// check and update all tables
		foreach($this->tables as $table) {
			$table_name = $tml->table_name( $table["name"] );
			$this->update_table( $table_name, $table["structure"], "CREATE TABLE `$table_name` " . $table["sql"] );
		}
		
		###		copy data from previous data if they exist (pre 1.5.3.1)		###
		// note: comments will get new send times. it 'emulates' comments being posted
		// now. there is a better solution, but this should be satisfactory.
		$queue_table  = $wpdb->prefix . "thankmelater";
		$sent_table   = $wpdb->prefix . "thankmelater_sent";
		
		if ($wpdb->get_var("SHOW TABLES LIKE '{$sent_table}'") == $sent_table) { // yes, do copy
			$i = 0;
			$rpq = 100; // resaults per query
			
			while ($results_set = $wpdb->get_results("SELECT * FROM `{$sent_table}` LIMIT {$i}, {$rpq}")) { // the emails
				foreach ($results_set as $row) { // for each e-mail
					
					###		Get/create the ID of the e-mail address		###
					$email_id = $wpdb->get_var( $wpdb->prepare("SELECT ID FROM ". $tml->table_name("emails") ." WHERE email = %s", $row->email) );
		
					if($email_id === NULL) { // no row was found in the table: insert one; get an ID
						$wpdb->insert( $tml->table_name("emails"), array("email" => $row->email, "subscribed" => true), array("%s", "%b") );
						$email_id = $wpdb->insert_id;	
					}
					
					###		Messages in the queue		###
					$queued_items = $wpdb->get_results($wpdb->prepare("SELECT * FROM `{$queue_table}` WHERE email_ID = %d", $row->id));
					
					foreach ($queued_items as $item) {
						$tml->comment_post($item->comment_ID, wp_get_comment_status($item->comment_ID));
					}
					
				}
				$i += 100;
			}
			
		}
		
		$wpdb->query("DROP TABLE IF EXISTS `".$queue_table."`");
		$wpdb->query("DROP TABLE IF EXISTS `".$sent_table."`");
		
	}
	
	// does a table need to be updated?
	function needs_update( $name, $structure ) {
		global $wpdb;
		
		$results = $wpdb->get_results("SHOW COLUMNS FROM `".$name."`", ARRAY_A);
		$needsupdate = false;
		$tf = count($structure);
		
		// foreach column...
		if(is_array($results)) foreach($results as $result) {
			// if field exists...
			if( isset(  $structure[$result['Field']]  ) ) {
				if(is_array($structure[$result['Field']])) foreach($structure[$result['Field']] as $req => $value) {
					if($result[$req] != $value) 
						$needsupdate = true; // column not correct
				}
				
				// ...count down
				$tf--;
				
			}
		}
		if($tf != 0) // some columns do not exist
			$needsupdate = true;
		
		return $needsupdate;
		
	}
	
	// update a database table
	// this will not retain any data!
	function update_table( $name, $structure, $createsql ) {
		global $wpdb;
		
		$needsupdate = $this->needs_update($name, $structure);
		
		// if table doesn't exist, or the structure is not correct, (re-)create.
		if( $wpdb->get_var("SHOW TABLES LIKE '".$name."'") != $name  ||  $needsupdate ) {
			$sql = "DROP TABLE IF EXISTS `".$name."`";
			$wpdb->query($sql);
			
			dbDelta($createsql);
		}
		
	}
}

$tml_install = new TML_Install();
	
//$tml_old_opts = _tml_options

?>