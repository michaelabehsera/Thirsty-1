<?php
/*
Plugin Name: Thank Me Later
Plugin URI: http://blog.pipvertise.co.uk/wordpress-plugin-thank-me-later/
Description: Automatically send a 'thank you' e-mail to those who comment on your blog. This plugin engages the visitor by reminding them to check back for responses or new blog posts. The plugin is highly configurable with multiple messages, variable delay and restrictions.
Author: Brendon Boshell
Version: 2.1
Author URI: http://www.pipvertise.co.uk/
Text Domain: thankmelater
*/

/*  Copyright 2010  Brendon Boshell  (email : brendon@22talk.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

global $tml;

define("TML_VERSION", "2.1");

// relative locations to TML's resources; with trailing forward-slash.
define("TML_INCLUDES_DIR", "tml_includes/");
define("TML_LANGUAGE_DIR", "tml_langs/");

// deprecated (redundant?)
$_tml_includes = TML_INCLUDES_DIR;
$_tml_langs    = TML_LANGUAGE_DIR;

// TML_Common class
require_once TML_INCLUDES_DIR . "common.php"; 

class TML extends TML_Common {

	var $version         = TML_VERSION; 
	var $includes_dir    = TML_INCLUDES_DIR;
	var $language_dir    = TML_LANGUAGE_DIR; 
	var $plugin__FILE__  = __FILE__; // this file's (absolute) location
	var $abspath         = ""; // value filled by __construct() 
	
	var $tml_table_prefix = "tml_";
	var $tables           = array("queue"   => "queue", 
	                              "history" => "history", 
	                              "emails"  => "emails" );
	
	// takes the default table name and converts it one mapped by $this->tables if that exists
	// Prefixes TML prefix; then WP prefix
	// example input: queue
	// example output: wp_tml_queue
	function table_name($name) {
		global $wpdb;
		return $wpdb->prefix // wp_
		     . $this->tml_table_prefix  // tml_
		     . (isset($this->tables[$name]) 
		         ? $this->tables[$name] // map name, if mapped, or
		         : $name); // use name provided: $name
	}
	
	function TML() {
		$this->__construct();
	}

	// register actions with WP; initialise values
	function __construct() {
		$this->abspath      = dirname($this->plugin__FILE__);
		$plugin_basename    = plugin_basename(__FILE__);
		
		define( "TML_PLUGIN_DIR", str_replace( basename($this->plugin__FILE__) , "" , $plugin_basename) ); // relative to the plugins folder
		define( "TML_DIR", $this->abspath ); // absolute
		
		$this->load_default_options();
	
		// add WordPress API actions / triggers
		add_action( "init",                         array(&$this, "after_init")                   );
		//add_action( "activate_{$plugin_basename}",  array(&$this, "activate_plugin")              );
		add_action( "admin_menu",                   array(&$this, "add_admin_menu_option"), 20    );
		add_action( "admin_head",                   array(&$this, "admin_head")                   );
		add_action( "comment_post",                 array(&$this, "comment_post")         , 10, 2 );
		//add_action( "edit_comment",                 array(&$this, "edit_comment")         , 10, 2 );
		add_action( "wp_set_comment_status",        array(&$this, "comment_post")         , 10, 2 );
		add_action( "delete_comment",               array(&$this, "delete_comment")               );
		if ($this->get_option('promote')) {
			//add_action(  "comment_form",            array(&$this, "comment_form_support_link")    );
			add_action(  "wp_footer",            array(&$this, "footer_support_link")    );
		}
		if ($this->get_option("show_opt_out") && $this->get_option("allow_opt_out")) {
			add_action( "comment_form",             array(&$this, "comment_form_opt_out")         );
		}
		add_action( "_tml_pQSched",                 array(&$this, "wpcron_tick")                  );
		add_action( "_tml_singleUpdate",            array(&$this, "wpcron_tick")                  );
		
		register_activation_hook( __FILE__,         array(&$this, "activate_plugin")              );
	}
	
	// once WP is loaded, continue loading stuff...
	// hooked to init
	function after_init() {			
		// add codepress to TML admin pages (unless disabled)
		// note: may give Javascript errors; should add required variables to admin_head action to surpress.
		if (is_admin() && isset($_GET["page"], $_GET["tml_p1"]) && preg_match("#thankmelater\.php$#i", $_GET["page"]) && in_array($_GET["tml_p1"], array("edit_message", "new_message")) && $this->get_option("syntax_highlighting"))
			wp_enqueue_script( "codepress" );
		
		// language:
		load_plugin_textdomain( "thankmelater", "wp-content/plugins/" . TML_PLUGIN_DIR . $this->language_dir , TML_PLUGIN_DIR . $this->language_dir );
	
		// need to install?
		if($this->get_option('installed_version') != $this->version) {
			$this->install();
		}
		
		// special page?
		// let me know if there is a better way.
		if( isset($_GET["tmloptout"]) )
			$this->opt_out_page();
			
		$last_cron = $this->get_option("last_wpcron_tick");
	
		if ($last_cron < time() - 3600*1.2 && $this->get_option("last_pseudo_tick") < time() - 600) { // WP-Cron not updating; use 'Legacy Mode'
			$this->wpcron_tick(-1, -1, false, true); // create an entry tick
		}
	}
	
	// load the opt out page, using themes
	// if avaialble (see the file).
	function opt_out_page() {
		require_once $this->includes_dir . "opt_out.php";
		exit;
	}
	
	// plugin is just activated...
	function activate_plugin() {
		$this->install(); // force "install" (it will check if it is required first)
	
		//if(function_exists("_TML_options_panel"))			
	
		###		WP-Cron will need to let us update every so often		###
		# Note: on some runs of WP, WP-Cron will not work as expected,
		# either due to running locally (fixed, yet?) or because of
		# environmental issues. TML will automatically fall back to 'Legacy
		# Mode' to remove reliance on WP-Cron
		wp_clear_scheduled_hook("_tml_pQSched"); // using the _tml_pQSched hook for backwards 'compatibility'/convention.
		
		# We will only update once per hour with WP-Cron. 
		# $tml_comment->comment_post() will schedule out
		# of this time to update when it is needed.
		# The following schedule is the 'passive' part
		# to mainly ensure than WP-Cron is working, and 
		# let 'Legacy Mode' activate if it is required.	
		$time = time() + 10;
		wp_schedule_event($time, "hourly", "_tml_pQSched"); // 0 mins
	}
	
	// process a message/the general queue
	// if from WP-Cron, $real_tick = true,
	// if 'from' TML, $real_tick = false
	function wpcron_tick($id = -1, $timestamp = -1, $real_tick = true, $entry_tick = true) {
		global $tml_send, $wpdb;
		
		if ($real_tick)
			$this->update_option( "last_wpcron_tick", time() );
			
		if ($entry_tick) { // infinite loop without this.
		
			if (!$real_tick) { // this is "pseudo" cron
				$this->update_option("last_pseudo_tick", time());
			}
		
			// process all pending e-mails
			$results = $wpdb->get_results( $wpdb->prepare("SELECT ID, send_time FROM " . $this->table_name("queue") . " WHERE send_time < %d", time()) );
			
			foreach ($results as $row) {
				if($id != $row->ID)
					$this->wpcron_tick($row->ID, $row->send_time, false, false);
			}
			
		}
		
		if (-1 === $id) { // this tick doesn't do anything *specifically*; it just makes sure everything is working
		                  // or invokes itself to process individual e-mails (see below) => quit:
			return;
		}
		
		// remove the WP schedule (in case we have 'overriden' that in 'Legacy Mode'
		wp_unschedule_event($timestamp, "_tml_singleUpdate", array($queue_id, $timestamp));
		
		$this->send_mail($id);
	}
	
	function send_mail($id) {
		global $tml_send;
		
		// load once:
		if (!is_object($tml_send))
			require_once $this->includes_dir . "mail_send.php";
			
		// send the message
		$tml_send->send_for($id);
	}
	
	function comment_post($id, $status) {
		global $tml_comment;
		
		if( !is_object($tml_comment))
			require_once $this->includes_dir . "comment.php";
		
		$tml_comment->comment_post($id, $status);
	}
	
	function delete_comment() { 
		
	}
	
	function comment_form_opt_out() {
		?>
		
		<p><div><?php printf( __("%sOpt out of 'Thank You' e-mails.%s", "thankmelater"), '<a href="'. attribute_escape(get_bloginfo("url")."/?tmloptout") .'" target="_blank">', '</a>' ); ?>.</div></p>
		
		<?php
	}
	
	function comment_form_support_link() {
		return;
		?>
		
		<p><div><?php printf( __("We use %sThank Me Later%s", "thankmelater"), '<a href="http://blog.pipvertise.co.uk/wordpress-plugin-thank-me-later/" title="' . __("Powered by Wordpress plugin, Thank Me Later", "thankmelater") . '" rel="nofollow">', '</a>' ); ?>.</div></p>
		
		<?php
	}
	
	function footer_support_link() {
		return;
		if (!is_front_page()) {
			return;
		}
		
		?>
		
		<p><div style="clear: both;"><?php printf( __("We are using %sThank Me Later%s", "thankmelater"), '<a href="http://blog.pipvertise.co.uk/wordpress-plugin-thank-me-later/" title="' . __("Powered by Wordpress plugin, Thank Me Later", "thankmelater") . '" rel="nofollow">', '</a>' ); ?>.</div></p>
		
		<?php
	}
	
	function admin_screen() {
		require_once $this->includes_dir . "admin/admin.php";
	}
	
	function admin_screen_messages() {
		$this->admin_screen();
	}
	
	function admin_screen_msgdefaults() {
		$_GET["tml_p0"] = "additional_options";
		$_GET["tml_p1"] = "message_defaults";
		$this->admin_screen();
	}
	
	function admin_screen_settings() {
		$_GET["tml_p0"] = "additional_options";
		$_GET["tml_p1"] = "global";
		$this->admin_screen();
	}
	
	function admin_screen_installation() {
		$_GET["tml_p0"] = "help";
		$this->admin_screen();
	}
	
	function add_admin_menu_option() {
		if (function_exists('add_options_page')) {
			add_menu_page(__("Thank Me Later", "thankmelater"), __("Thank Me Later", "thankmelater"), 'administrator', 'tml', array( $this, "admin_screen"));
			add_submenu_page( 'tml', __("Messages", "thankmelater"), __("Messages", "thankmelater"), 'administrator', 'tml', array( $this, "admin_screen_messages") );
			add_submenu_page( 'tml', __("Message Defaults", "thankmelater"), __("Message Defaults", "thankmelater"), 'administrator', 'tml-msgdefaults', array( $this, "admin_screen_msgdefaults") );
			add_submenu_page( 'tml', __("Settings", "thankmelater"), __("Settings", "thankmelater"), 'administrator', 'tml-settings', array( $this, "admin_screen_settings") );
			add_submenu_page( 'tml', __("Installation", "thankmelater"), __("Installation", "thankmelater"), 'administrator', 'tml-installation', array( $this, "admin_screen_installation") );
		}
	}
	
	// install Thank Me Later. Create tables, etc.
	function install() {
		global $tml_install;
		require_once $this->includes_dir . "install.php";
		$tml_install->install();
	}
	
	// add styles, scripts, etc required by TML
	function admin_head() {
		require_once $this->includes_dir . "admin/admin_head.php";
	}	
}

//$dir = dirname(__FILE__);

$tml = new tml(); // Let's get started!

function _TML_processQueue() {
	// a stub to force PHP to throw fatal error
	// if TML < 1.5.3.1 running
}
	
?>