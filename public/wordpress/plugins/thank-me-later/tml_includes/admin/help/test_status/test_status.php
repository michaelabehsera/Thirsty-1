<?php

global $tml, $user_level, $tml_admin, $tml_admin_help, $tml_form_errors, $tml_install;
	
if( !is_object($tml) || !current_user_can("edit_plugins") ) {
	echo __("Sorry: you can not configure Thank Me Later with your account.", "thankmelater");
	exit;
}

require_once $tml->abspath . "/" . $tml->includes_dir . "install.php";

$parameters = array();

// default with all the database tables
foreach( $tml_install->tables as $table ) {

	// get proper name
	$table_name = $tml->table_name( $table["name"] );
	
	// repair this table?
	if( isset($_GET["repair_table"]) && $_GET["repair_table"] == $table_name ) { 
	
		$tml_install->update_table( $table_name, $table["structure"], "CREATE TABLE `$table_name` " . $table["sql"] );
		
		?>
		<p><div id="message" class="updated"><p><strong><?php printf( __("Table '%s' has been repaired.", 'thankmelater'), $table_name ); ?></strong></p></div></p>
		<?php
		
	}
	
	// does table need update? (checks table structure, existance)	
	$needs_update = $tml_install->needs_update( $table_name, $table["structure"] );
	
	$error = false;
	$status = '<span class="ok">' . __("OK", "thankmelater") . '</span>';
	
	if($needs_update) {
		$error = true;
		// table needs update; give link to fix table
		$status = '<span class="not_ok">' . sprintf( __("Error: %sRepair Table%s.", "thankmelater"), '<a href="?' . attribute_escape( TML_admin_pages_hierarchy::build_query()) .'&repair_table=' . attribute_escape( urlencode($table_name) ).'">', '</a>') . '</span>';
	}

	// add row
	$parameters[] = array(
			"error" => $error,
			"param_name" => sprintf( __("Table '%s'", "thankmelater"), $table_name ),
			"status" => $status
		);
}

TML_form::show_message( sprintf(__("Need help? %sVisit the support forum%s.", 'thankmelater'), '<a href="http://blog.pipvertise.co.uk/wordpress-plugin-thank-me-later/" target="_blank">', '</a>'),  TML_form::MESSAGE_INFO );

?>

<h3><?php _e("Environment Status", "thankmelater"); ?></h3>

<p><?php _e("The following parameters have been tested. Any parameter which may cause a problem with TML's operation will be labelled 'Error'.", "thankmelater"); ?></p>

<table class="tml-table widefat">

	<thead>
		<tr>
			<th scope="col"><?php _e('Parameter', 'thankmelater'); ?></th>
			<th scope="col" width="60%"><?php _e('Status', 'thankmelater'); ?></th>
		</tr>
	</thead>
	
	<tbody>
	
		<?php
		foreach($parameters as $p) {
		?>
		<tr class="<?php echo $p["error"] ? "row_not_ok" : "row_ok"; ?>">
			<td><?php echo $p["param_name"]; ?></td>
			<td><?php echo $p["status"]; ?></td>
		</tr>
		<?php } ?>
	
	</tbody>
	
</table>