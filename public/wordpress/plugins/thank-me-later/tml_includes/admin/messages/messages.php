<?php

global $tml, $user_level, $tml_admin_messages, $tml_admin;

###		Standard authorization check		###
if( !is_object($tml) || !current_user_can("edit_plugins") ) {
	echo __("Sorry: you can not configure Thank Me Later with your account.", "thankmelater");
	exit;
}

class TML_admin_messages extends TML_admin_pages {	
}

$pages = array( 
		"overview"    => array( "display" => __("Messages Overview", "thankmelater")),
		"new_message" => array( "display" =>  __("Add New Message",   "thankmelater"), "defaultly_hidden" => false ),
		"edit_message" => array( "display" => __("Edit Message",   "thankmelater"), "defaultly_hidden" => true ),
		"delete_message" => array( "display" => __("Delete Message", "thankmelater"), "defaultly_hidden" => true )
	);

$tml_admin_messages = new TML_admin_messages( $pages, "overview" );

?>

<?php $tml_admin_messages->nav(); ?>

<?php $tml_admin_messages->content(); ?>