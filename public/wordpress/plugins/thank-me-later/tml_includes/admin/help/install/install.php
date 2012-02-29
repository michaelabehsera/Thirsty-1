<?php

global $tml, $user_level, $tml_admin, $tml_admin_help, $tml_form_errors, $tml_install, $wpdb;
	
###		Standard authorization check		###
if( !is_object($tml) || !current_user_can("edit_plugins") ) {
	echo __("Sorry: you can not configure Thank Me Later with your account.", "thankmelater");
	exit;
}

// need to access to installation functionality
require_once $tml->abspath . "/" . $tml->includes_dir . "install.php";

if( $_POST ):
	check_admin_referer("thank-me-later-admin-re-install");
	
	?>
		<p><div id="message" class="updated"><p><strong>
	<?php
	
	_e("Deleting settings... ", "thankmelater");
	
	###		Delete all options		####
	foreach($tml->allowed_options as $opt => $a) {
		$tml->delete_option($opt);
	}
	
	_e("Done", "thankmelater");
	echo "<br />";
	
	
	
	###		Delete tables		###
	foreach( $tml_install->tables as $table ) {
		
		// get proper name
		$table_name = $tml->table_name( $table["name"] );
		
		printf( __("Dropping table '%s'... ", "thankmelater"), $table_name );
		
		$sql = "DROP TABLE IF EXISTS `".$table_name."`";
		$wpdb->query( $sql );
		
		_e("Done", "thankmelater");
		echo "<br />";
		
	}
	
	###		All done		###
	echo "<br />";
	echo _e("Complete! Thank Me Later has been re-installed.", "thankmelater");
	
	?>
		</strong></p></div></p>
	<?php	
	
endif;

TML_form::show_message( sprintf(__("Need help? %sVisit the support forum%s.", 'thankmelater'), '<a href="http://blog.pipvertise.co.uk/wordpress-plugin-thank-me-later/" target="_blank">', '</a>'),  TML_form::MESSAGE_INFO );

?>

<p><strong><?php _e("<strong>Warning</strong>: Clicking 'Re-install' below will delete all saved settings and data associated with Thank Me Later. This feature is only designed <em>just in-case</em> and has no legitimate use when Thank Me Later is working correctly.", "thankmelater"); ?></strong></p>

<form method="post" action="?<?php echo attribute_escape( TML_admin_pages_hierarchy::build_query() ); ?>">
	<?php wp_nonce_field("thank-me-later-admin-re-install"); ?>
	
	<p class="submit">
		<input type="submit" name="Submit" value="<?php _e("Re-install", "thankmelater"); ?>" style="font-size: 2em !important;" tabindex="1" />
	</p>
</form>