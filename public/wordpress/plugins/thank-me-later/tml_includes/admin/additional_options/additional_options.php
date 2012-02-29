<?php

global $tml, $user_level, $tml_admin_additional_options, $tml_admin;

###		Standard authorization check		###
if( !is_object($tml) || !current_user_can("edit_plugins") ) {
	echo __("Sorry: you can not configure Thank Me Later with your account.", "thankmelater");
	exit;
}

class TML_admin_additional_options extends TML_admin_pages {	
}

$tml_admin_additional_options = new TML_admin_additional_options(array( 
					"global"              => array( "display" =>  __("Global Options", "thankmelater") ),
					"message_defaults"    => array( "display" =>  __("Message Defaults", "thankmelater") ),
					"misc"                => array( "display" =>  __("Miscellaneous", "thankmelater") )
				), "global");

?>

<?php //$tml_admin_additional_options->nav(); ?>

<?php $tml_admin_additional_options->content(); ?>