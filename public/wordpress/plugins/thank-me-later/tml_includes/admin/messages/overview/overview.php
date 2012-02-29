<?php

global $tml, $user_level, $tml_admin_messages, $tml_admin, $tml_form_errors;

###		Standard authorization check		###
if( !is_object($tml) || !current_user_can("edit_plugins") ) {
	echo __("Sorry: you can not configure Thank Me Later with your account.", "thankmelater");
	exit;
}

###		Get/select message		###
$opt_messages = $tml->get_option("messages");
$opt_messages = unserialize( $opt_messages );

if( ! is_array($opt_messages) )
	$opt_messages = array();

if( $_POST ):

	check_admin_referer("thank-me-later-admin-messages-update-probabilities");
	
	$opt_messages = $tml->get_option("messages");
	$opt_messages = unserialize( $opt_messages );
	if( ! is_array($opt_messages) )
		$opt_messages = array();
	
	###		 update so all probabilities equal 1		###
	$prob_sum = 0; 
	foreach($opt_messages as $i => $m) {
		if( isset( $_POST["prob_$i"] ) ) { // user may change the item probability
			$prob = $_POST["prob_$i"];
			$opt_messages[$i]["prob"] = $prob;
		}else
			$prob = $m["prob"];
			
		if ($prob < 0) {
			$tml_form_errors->add_error("prob_{$i}", __("Probability must be greater than 0, inclusive", "thankmelater") );	
		}
		
		$prob_sum += $prob;
	}
		
	// reduce all probabilities
	if($prob_sum > 0)
		foreach($opt_messages as $i => $m)
			$opt_messages[ $i ]["prob"] = $m["prob"] / $prob_sum; 
			
	if (!$tml_form_errors->has_errors) { // no errors
	
		// save settings
		$tml->update_option( "messages", $opt_messages );
		
		// user-friendly message
		TML_form::show_message( __("The message probabilities have been updated.", 'thankmelater'), TML_form::MESSAGE_UPDATED );
		
	} else {
		?><p><div id="message" class="error"><p><strong>
			<?php 
				$tml_form_errors->list_errors();
			?>
		</strong></p></div></p><?php
	}

endif;

$prob_sum = 0; // the total sum of all probabilities (this should be 1; if not, it will be corrected on update)

// calculate the $prob_sum
foreach($opt_messages as $email) {
	//$prob      = (float)round($email["prob"],3);
	$prob_sum += (float)$email["prob"];
}
	

if( ! count($opt_messages) ) { // no messages: let the user know

	$message = sprintf(__("You have not created any messages yet. %sCreate one now &raquo;%s", "thankmelater"), '<a href="?'.attribute_escape( TML_admin_pages_hierarchy::build_query( $tml_admin_messages->level_id, "new_message" ) ).'">', '</a>');	
	TML_form::show_message( $message, TML_form::MESSAGE_ERROR );
	
}elseif( !$prob_sum ) { // probabilities are 0; e-mails not being sent.

	$message = __("All probabilities are set to 0. Thank Me Later will not send any e-mails until at least one message has a non-zero, positive probability.", "thankmelater");	
	TML_form::show_message( $message, TML_form::MESSAGE_ERROR );
	
}

?>

<script type="text/javascript">
// sum the probabilities
function tml_sum_prob() {
	var sum = 0;
	
	for( var i = 0; document.getElementById("prob_" + i); i++ ) {
		var v = parseFloat( document.getElementById("prob_" + i).value );
		if(v)
			sum += v;
	}
	
	var output_el = document.getElementById("tml_total_prob");
	
	sum = Math.round( sum * 1000 ) / 1000;
	
	if(sum != 1) // do probs add to 1?
		output_el.style.color = "#FF0000";
	else // yes:
		output_el.style.color = "#009900";
	
	output_el.innerHTML = sum;
}
</script>

<form method="post" action="?<?php echo attribute_escape( TML_admin_pages_hierarchy::build_query() ); ?>">
<?php wp_nonce_field("thank-me-later-admin-messages-update-probabilities"); ?>

<table class="tml-table widefat tml-form" id="tml_overview">

	<thead>
		<tr>
			<th scope="col" width="20%"><?php _e('Subject', 'thankmelater'); ?></th>
			<th scope="col" width="55%"><?php _e('Message', 'thankmelater'); ?></th>
			<th scope="col" width="125"><?php _e('Send Probability, p', 'thankmelater'); ?></th>
			<th scope="col"><?php _e('Options', 'thankmelater'); ?></th>
		</tr>
	</thead>
	
	<tbody id="tml_overview_tbody">
		
		<?php
		
		$subject_len = 100;
		$message_len = 230;
		
		$numOfMessages = 0;
		
		foreach($opt_messages as $i => $email):
		
		$subject = $email["message_subject"];
		$message = $email["message_body"];
		$prob    = (float)round($email["prob"],3);
		
		if($email["use_html"])
			$message = strip_tags($message);
			
		$checksum = md5( serialize($email) );
		$msgid = $i;
		
		?>
		
		<tr>
			<td><?php echo wp_specialchars( preg_replace("#^((.|\r|\n){" . $subject_len . "})(.|\r|\n)*$#", "$1...", $subject) ); ?></td>
			<td>
				<?php 
					$msg_out = preg_replace("#^((.|\r|\n){" . $message_len . "})(.|\r|\n)*$#", "$1...", $message);
					if(!$prob)
						printf(__("<strong><em>[Draft]</em></strong> %s", "thankmelater"), wp_specialchars($msg_out));
					else
						echo wp_specialchars( $msg_out ); 
			?>
			</td>
			<td class="probability">
				<label for="prob_<?php echo (int)$msgid; ?>">					
					<?php echo TML_form::input_small_text("prob_{$msgid}", $prob, $numOfMessages+1, array("id" => "prob_{$numOfMessages}", "onkeyup" => "tml_sum_prob()", "onchange" => "tml_sum_prob()")); ?>
					
				</label>
			</td>
			<td>
				<a href="?<?php echo attribute_escape( TML_admin_pages_hierarchy::build_query($tml_admin_messages->level_id, "edit_message") . "&msgid=". urlencode($msgid)."&checksum=".urlencode($checksum) ); ?>"><?php _e("Edit", "thankmelater"); ?></a> 
			
				| 
			
				<a href="?<?php echo attribute_escape( TML_admin_pages_hierarchy::build_query($tml_admin_messages->level_id, "delete_message") . "&msgid=". urlencode($msgid)."&checksum=".urlencode($checksum) ); ?>"><?php _e("Delete", "thankmelater"); ?></a> 
				
			</td>
		</tr>
		
		<?php
		
		$numOfMessages++;
		
		endforeach;	
		?>
		
	</tbody>
	<tfoot>
		<tr>
			<td></td>
			<td></td>
			<td><?php printf( __('&Sigma;p = %1$s', 'thankmelater'), '<span id="tml_total_prob"> ' . $prob_sum . '</span>' ); ?></td>
			<td></td>
		</tr>
	</tfoot>
</table>

<p class="submit">
	<input type="submit" name="Submit" value="<?php _e("Update", "thankmelater"); ?>" tabindex="<?php echo $numOfMessages+1; ?>" />
</p>

</form>

<p>Thank Me Later has been sponsored by <a href="http://www.pipvertise.co.uk/" target="_blank">

<img src="data:image/gif;base64,R0lGODlhQgAQAJEAAP8AZv////+PvP8/jCH5BAAHAP8ALAAAAABCABAAAALXHI4TcbIPo5zRNUoN
2gw4DIKC133hYyjLSJ7udL1RCqXCjQvD4OCPr9v9cBoecMf7IVEA1eKgYWkatKdneoFuNthL12G7
RRsIMBmwOpvRXCgLsRiTNIEutHS3ssy8w+OMVtKR0BPA8ncFhfShhnjTVFK00yioxaWjGFUVQVnp
4Se5GJM1t5WAxLMJcebk1QS5ydhCapSW8BMHKQG4Zhu4V+c3SrJlGxWMpupoGdPh9CWInGCqAO0j
gdMQZGJ4AxGU1G2y6A1uYi7TLLPOfqLeDh+vJ08/UQAAOw==
" alt="Pipvertise" title="Pipvertise" border="0" style="vertical-align: -4px;" /></a> - <a href="http://www.pipvertise.co.uk/" target="_blank">http://www.pipvertise.co.uk/</a></p>


<?php if (false): ?>
<h2><?php _e("Support Thank Me Later", "thankmelater"); ?></h2>

<?php if (false): ?>
<?php

$donate_prog = 0.2; 

?>

<div style="width: 750px;">

	<div style="float: left; border-left: 1px solid #999; padding-left: 10px;padding-bottom: 5px;">
		$0.00
	</div>
	<div style="float: right;  border-right: 1px solid #999; padding-right: 10px;padding-bottom: 5px;">
		<?php printf(__("Target: %s", "thankmelater"),  "$325.00"); ?>
	</div>
	<div style="clear: both; width: 748px; height: 30px;border: 1px solid #000;">
		<div style="width: <?php echo min(748, round($donate_prog*748)); ?>px; height: 30px; background: #99F">
		
		</div>
	</div>
	<div style="position: relative; top: -25px; text-align: center;">
		<span style="background: #FFF;">
			<?php if ($donate_prog >= 1): ?>
				<?php _e("Target reached! Thank you to everybody who donated. Don't worry! You can still make a donation below...", "thankmelater"); ?>
			<?php else: ?>
				<?php echo round($donate_prog*100); ?>%&dagger;
			<?php endif; ?>
		</span>
	</div>

</div>

<?php endif; ?>

<p><?php _e("Countless hours have been poured into developing and supporting Thank Me Later by its author. Even at the minimum wage, the cost of this time is estimated at $325.00. Regardless, this software is released for free under an open source license and has no direct source of income for the author. We encourage you to use this software how you see fit, but would like for you to consider donating to the author if you found it useful--particularly in a commercial usage.", "thankmelater"); ?></p>

<?php if (false): ?>
<p><?php _e("If you would like to donate to the author (Brendon Boshell), you can do so using PayPal. Any amount is welcomed.", "thankmelater"); ?></p>
<?php endif; ?>
<h3><?php _e("Donate", "thankmelater"); ?></h3>

<form method="post" action="https://www.paypal.com/cgi-bin/webscr">	
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="VJARSRXSGKHTN">
<input type="hidden" name="lc" value="GB">
<input type="hidden" name="item_name" value="Thank Me Later">
<input type="hidden" name="item_number" value="tml-2.0">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHosted">

	<table class="form-table tml-form">
		<tbody>
			<tr valign="top">
				<th scope="row">
					<label for="amount"><?php _e("Donation Amount", "thankmelater"); ?></label>
				</th>
				<td style="font-size:2em;">
					$<?php echo TML_form::input_text("amount", "30.00", 1000, array("style" => 'font-size: 1.5em;vertical-align:middle;width:170px;color:#008000;')) ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
				</th>
				<td>
					<input type="submit" name="Donate &raquo;" value="<?php _e("Donate &raquo;", "thankmelater"); ?>" /> Thanks!
				</td>
			</tr>
		</tbody>
	</table>
</form>
<?php endif; ?>

<?php if (false): ?>
<p style="font-size: 0.8em; color: #999;"><?php _e("&dagger; This value may be inaccurate and is for value added purposes only. Although we attempt to keep values regarding donations accurate, we make no guarantee for their accuracy."); ?></p>
<?php endif; ?>
