<?php

global $wpdb, $tml, $wp_query, $email, $opt;

// essentially, we are going to pretend to be a 'page'
// (TML_opt_out_page) and fool Wordpress into displaying it.
// Again, there is probably a better, less hackery way: tell me, please.

// get the email id
function tml_email_id( $email ) {
	global $tml, $wpdb;
	$email_id= $wpdb->get_var( $wpdb->prepare("SELECT ID FROM " . $tml->table_name("emails") . " WHERE email = %s", $email) );
	
	if($email_id === NULL) { // no row was found in the table: insert one; get an ID
		$wpdb->insert( $tml->table_name("emails"), array("email" => $email, "subscribed" => true), array("%s", "%b") );
		$email_id = $wpdb->insert_id;	
	}
	
	return $email_id;
}

$email = isset($_GET["email"]) ? $_GET["email"] : "";

if($email && is_email($email)) {
	// when subscribed, $opt = 1
	// when opted out, $opt = 0
	$email_id = tml_email_id($email);

	$opt = $wpdb->get_var($wpdb->prepare("SELECT subscribed FROM " . $tml->table_name("emails") . " WHERE email = %s", $email));
	$opt = ($opt === NULL) ? 1 : $opt;
	
	if(isset($_GET["opt"])) {
		$opt = $_GET["opt"] ? 1 : 0;
		$wpdb->query($wpdb->prepare("UPDATE " . $tml->table_name("emails") . " SET subscribed = %b", $opt));
	}
}else
	$email = "";

class TML_opt_out_page {
	var $ID = 0;
	var $post_author = "";
	var $post_date = 0;
	var $post_date_gmt = 0;
	var $post_content = "";
	var $post_title = "";
	var $post_category = 0;
	var $post_excerpt = "";
	var $post_status = "publish";
	var $comment_status = "closed";
	var $ping_status = "closed";
	var $post_password = "";
	var $post_name = "tml";
	var $to_ping = "";
	var $pinged = "";
	var $post_modified = 0;
	var $post_modified_gmt = 0;
	var $post_content_filtered = "";
	var $post_parent = "";
	var $guid = "";
	var $menu_order = 0;
	var $post_type = "page";
	var $post_mime_type = "";
	var $comment_count = 0;
	
	function TML_opt_out_page() {
		$this->__construct();
	}
	
	function __construct() {
		global $email, $opt, $tml;
	
		$this->post_author   = __("Thank Me Later", "thankmelater");	
		$this->post_date     = date("Y-m-d H:i:s");
		$this->guid          = get_bloginfo('url') . "?tmloptout";
		$this->post_title    = __("E-mail Preferences", "thankmelater");
		$this->post_content  = '<form method="get" action="' . htmlspecialchars(get_bloginfo('url')) . '">';
		$this->post_content .= '<input type="hidden" name="tmloptout" value="" />';
		$this->post_content .= '<p>' . sprintf(__("This page allows you to opt-out or subscribe to 'Thank Me Later' e-mails. These are e-mails sent when you leave a comment at %s.", "thankmelater"), wp_specialchars(get_bloginfo("name"))) . '</p>';
		
		if($email) {
			$this->post_content .= '<input type="hidden" name="email" value="'. attribute_escape($email) .'" />';
			$this->post_content .= '<p>'. sprintf(__("Your e-mail address: <strong>%s</strong>", "thankmelater"), wp_specialchars($email)) .'</p>';
			
			if($opt) {
				$this->post_content .= '<p>'. __("You are currently <strong>subscribed</strong> to receive e-mails. Click 'Opt Out' if you wish to opt-out of these e-mails:", "thankmelater") .'</p>';
				$this->post_content .= '<input type="hidden" name="opt" value="0" />';
				$this->post_content .= '<p><input type="submit" value="'. __("Opt Out", "thankmelater") .'" name="submit" style="font-weight: bold;" /></p>';
			}else{
				$this->post_content .= '<p>'. __("You are <strong>not subscribed</strong> to receive e-mails. Click 'Opt In' if you wish to receive e-mails again:", "thankmelater") .'</p>';
				$this->post_content .= '<input type="hidden" name="opt" value="1" />';
				$this->post_content .= '<p><input type="submit" value="'. __("Opt In", "thankmelater") .'" name="submit" style="font-weight: bold;" /></p>';
			}
			
		}else{
			$this->post_content .= '<p>'. sprintf(__("Your e-mail address: <strong>%s</strong>", "thankmelater"), '<input type="text" name="email" value="" />') .'</p>';
			$this->post_content .= '<p><input type="submit" value="'. __("Get Preferences &raquo;", "thankmelater") .'" name="submit" style="font-weight: bold;" /></p>';
		}
		
		// don't allow opt outs
		if(!$tml->get_option("allow_opt_out"))
			$this->post_content = "<p>". __("Sorry, this feature is disabled.", "thankmelater") ."</p>";
	}
}

$wp_query->posts = array();
$page = new TML_opt_out_page();
$wp_query->posts[] = $page;
$wp_query->post_count = 1;

$templates = array();
$templates[] = "page-tmloptout.php";
$templates[] = "page.php";
$templates[] = "single.php";
$templates[] = "index.php";

if( "" == locate_template($templates, true) ): // show the page with no templating/themes
		
?>

<html>
<head>
<title><?php _e("E-mail Preferences", "thankmelater"); ?></title>
</head>

<body>

<h2><?php _e("E-mail Preferences", "thankmelater"); ?></h2>

<?php echo $page->post_content; ?>

</body>
</html>

<?php endif; ?>