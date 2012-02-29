<?php

global $tml, $user_level, $tml_admin, $tml_admin_help;
	
###		Standard authorization check		###
if( !is_object($tml) || !current_user_can("edit_plugins") ) {
	echo __("Sorry: you can not configure Thank Me Later with your account.", "thankmelater");
	exit;
}

class TML_admin_help extends TML_admin_pages {	
}

$tml_admin_help = new TML_admin_help(array( 
					"test_status"        => array( "display" =>  __("Test and Status", "thankmelater") ),
					//"getting_started"    => array( "display" =>  __("Getting Started", "thankmelater") ),
					"install"            => array( "display" =>  __("Re-install", "thankmelater") )
				), "test_status");

?>

<?php $tml_admin_help->nav(); ?>

<?php $tml_admin_help->content(); ?>