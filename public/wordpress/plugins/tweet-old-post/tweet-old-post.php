<?php   
#     /* 
#     Plugin Name: Tweet old post
#     Plugin URI: http://www.ajaymatharu.com/wordpress-plugin-tweet-old-posts/
#     Description: This plugin helps you to keeps your old posts alive by tweeting about them and driving more traffic to them from twitter.
#     Author: Ajay Matharu 
#     Version: 3.3.1
#     Author URI: http://www.ajaymatharu.com
#     */  
 

require_once('top-admin.php');
require_once('top-core.php');
require_once('top-excludepost.php');

define ('top_opt_1_HOUR', 60*60);
define ('top_opt_2_HOURS', 2*top_opt_1_HOUR);
define ('top_opt_4_HOURS', 4*top_opt_1_HOUR);
define ('top_opt_8_HOURS', 8*top_opt_1_HOUR);
define ('top_opt_6_HOURS', 6*top_opt_1_HOUR); 
define ('top_opt_12_HOURS', 12*top_opt_1_HOUR); 
define ('top_opt_24_HOURS', 24*top_opt_1_HOUR); 
define ('top_opt_48_HOURS', 48*top_opt_1_HOUR); 
define ('top_opt_72_HOURS', 72*top_opt_1_HOUR); 
define ('top_opt_168_HOURS', 168*top_opt_1_HOUR); 
define ('top_opt_INTERVAL', 4);
define ('top_opt_INTERVAL_SLOP', 4);
define ('top_opt_AGE_LIMIT', 30); // 120 days
define ('top_opt_MAX_AGE_LIMIT', 60); // 120 days
define ('top_opt_OMIT_CATS', "");
define('top_opt_TWEET_PREFIX',"");
define('top_opt_ADD_DATA',"false");
define('top_opt_URL_SHORTENER',"is.gd");
define('top_opt_HASHTAGS',"");

global $top_db_version;
$top_db_version = "1.0";

   function top_admin_actions() {  
        add_menu_page("Tweet Old Post", "Tweet Old Post", 1, "TweetOldPost", "top_admin");
        add_submenu_page("TweetOldPost", __('Exclude Posts','TweetOldPost'), __('Exclude Posts','TweetOldPost'), 1, __('ExcludePosts','TweetOldPost'), 'top_exclude');
		
    }  
    
  	add_action('admin_menu', 'top_admin_actions');  
	add_action('admin_head', 'top_opt_head_admin');
 	add_action('init','top_tweet_old_post');
        add_action('admin_init','top_authorize',1);
        
        function top_authorize()
        {
             
        
            if ( isset( $_REQUEST['oauth_token'] ) ) {
                $auth_url= str_replace('oauth_token', 'oauth_token1', top_currentPageURL());
                echo '<script language="javascript">window.open ("'.$auth_url.'","_self"
                    
)</script>';
                die;
            }
        
        }
        
add_filter('plugin_action_links', 'top_plugin_action_links', 10, 2);

function top_plugin_action_links($links, $file) {
    static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    if ($file == $this_plugin) {
        // The "page" query string value must be equal to the slug
        // of the Settings admin page we defined earlier, which in
        // this case equals "myplugin-settings".
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=TweetOldPost">Settings</a>';
        array_unshift($links, $settings_link);
    }

    return $links;
}

?>