<?php

global $tml, $user_level;

###		Standard authorization check		###
//if( !is_object($tml) || !current_user_can("edit_plugins") ) {
//	echo __("Sorry: you can not configure Thank Me Later with your account.", "thankmelater");
//	exit;
//}

?><!-- Styles -->
<style type="text/css">
		
	.thankmelater_tags {
		list-style: none;
		margin: 0;
		padding: 0;
		padding-left: 30px;
	}
	
	.thankmelater_tags li {
		
	}
	.thankmelater_tags .name {
		float: left; width: 140px;
	}
	.tml-table input.small-text {
		width: 50px;
		border-width: 1px;
		border-style: solid;
		border-color: #DFDFDF;
	}
	.tml-table .row_not_ok {
		font-weight: bold;
	}
	.tml-table .not_ok {
		color: #F00;
		font-weight: bold;
	}
	.tml-table .ok {
		color: #090;
	}
	.tml-form input.field_error {
		background: #FFEBE8 !important;
		border: #CC0000 1px solid;
		padding: 5px 10px;
	}
	
</style>
<script type="text/javascript">

</script>