<?php

global $tml, $user_level, $tml_admin, $tml_form_errors;

###		Standard authorization check		###
if( !is_object($tml) || !current_user_can("edit_plugins") ) {
	echo __("Sorry: you can not configure Thank Me Later with your account.", "thankmelater");
	exit;
}

require_once "admin_pages.php";
require_once "form_functions.php";

// admin pages are typically forms; $tml_form_errors will allow
// errors to be recorded/displayed/managed
$tml_form_errors = new TML_form_errors();

class TML_admin extends TML_admin_pages {
}

$pages = array( 
		/*"home"               => array( "display" => __("Home", "thankmelater") ),*/
		"messages"           => array( "display" => __("Messages", "thankmelater") ),
		"additional_options" => array( "display" => __("Additional Options", "thankmelater") ),
		"help"               => array( "display" => __("Installation and Information", "thankmelater") )
	);

$tml_admin = new TML_admin( $pages, "messages" );

$last_cron = $tml->get_option("last_wpcron_tick");

if( $last_cron < time() - 3600*1.2 ) {
	//echo date("Y-m-d H:i:s", $last_cron);
	//TML_form::show_message( __("WP-Cron doesn't seem to be working. Thank Me Later is emulating the behaviour of WP-Cron, which may slightly slow down some page loads. You may wish to seek a solution to this problem, although the impact is usually negligible.", "thankmelater"), TML_form::MESSAGE_ERROR );

}

?>
<div class="wrap">

	<h2><?php _e("Thank Me Later", "thankmelater"); ?></h2>
	
	<?php //$tml_admin->nav(); ?>
	
	<?php $tml_admin->content(); ?>

</div>