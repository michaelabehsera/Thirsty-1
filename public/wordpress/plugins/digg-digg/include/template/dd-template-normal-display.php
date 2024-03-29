<?php 

function dd_page_for_normal_display(){
	
	global $ddNormalDisplay,$ddNormalButtons;
	
	if (isset($_POST[DD_FORM_SAVE])) {

		foreach(array_keys($ddNormalDisplay) as $key){
	    	
			foreach(array_keys($ddNormalDisplay[$key]) as $subkey){
				
				//echo '<h2>$key : ' . $key . ' - $subkey : ' . $subkey . ' - [' . $_POST[$subkey] . ']</h2>';
				if(isset($_POST[$subkey])){
					$ddNormalDisplay[$key][$subkey] = $_POST[$subkey];	
				}else{
					$ddNormalDisplay[$key][$subkey] = DD_EMPTY_VALUE;
				}
	
			}
	    }
	   	update_option(DD_NORMAL_DISPLAY_CONFIG, $ddNormalDisplay);
	   	
		foreach($ddNormalButtons[DD_NORMAL_BUTTON_DISPLAY] as $key => $value){
			
			foreach(array_keys($value->wp_options) as $option){
				
				//echo '<h2>$option : [' . $option . '] , $_POST[$option] - ['. $_POST[$option] . ']</h2>';
				
		    	if(isset($_POST[$option])){
		    		$value->wp_options[$option] = $_POST[$option];
		    	}else{
		    		$value->wp_options[$option] = DD_EMPTY_VALUE;
		    	}
		    }

			if(($value->getOptionAppendType()!=DD_SELECT_NONE)){
				$ddNormalButtons[DD_NORMAL_BUTTON_FINAL][$key] = $value;
			}
	    }
	    
		update_option(DD_NORMAL_BUTTON, $ddNormalButtons);

		echo "<div id=\"updatemessage\" class=\"updated fade\"><p>Digg Digg settings updated.</p></div>\n";
		echo "<script type=\"text/javascript\">setTimeout(function(){jQuery('#updatemessage').hide('slow');}, 3000);</script>";	
		
  	}else if(isset($_POST[DD_FORM_CLEAR])){
	
        dd_clear_form_normal_display(DD_FUNC_TYPE_RESET);
        
		echo "<div id=\"errmessage\" class=\"error fade\"><p>Digg Digg settings cleared.</p></div>\n";
		echo "<script type=\"text/javascript\">setTimeout(function(){jQuery('#errmessage').hide('slow');}, 3000);</script>";	
	
  	}

  	//get back the settings from wordpress options
  	$ddNormalButtons = get_option(DD_NORMAL_BUTTON);
	$ddNormalDisplay = get_option(DD_NORMAL_DISPLAY_CONFIG);
	
  	//sorting
	$dd_sorting_data = array();
	foreach($ddNormalButtons[DD_NORMAL_BUTTON_DISPLAY] as $obj){
		$dd_sorting_data[$obj->getOptionButtonWeight().'-'.$obj->name] = $obj;
	}	
	krsort($dd_sorting_data,SORT_NUMERIC);
	
  	// display admin screen
  	dd_print_normal_form($dd_sorting_data, $ddNormalDisplay);
}

function dd_print_normal_form($ddNormalButtons, $ddNormalDisplay){
?>

<script type="text/javascript">
jQuery(document).ready(function($) {
	$("table tr:nth-child(even)").addClass("striped");

	$("#display_option_post").click(function () {
		checkCategory();
	});

	checkCategory();
});

function checkCategory(){

	jQuery(document).ready(function($) {
	
		var isCheck = $('input:checkbox[name=display_option_post]').is(':checked');

	 	if(isCheck){
	 		$("#dd-insider-block-category").show();
	 	}else{
	 		$("#dd-insider-block-category").hide();
	 	}
		
	});
	
}

</script>

<div id=msg></div>

<div id="dd_admin_block">

	<div id="dd_head_block">
		<span id="dd_plugin_title">Digg Digg - Normal Button Configuration</span>
	</div>

<!-- start of dd_admin_left_block -->
<div id="dd_admin_left_block">
	
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="<?php echo DD_FORM; ?>">
	
	<div class="dd-block">
		<div class="dd-title">
		<h2>1. Status : 
		<?php if($ddNormalDisplay[DD_STATUS_OPTION][DD_STATUS_OPTION_DISPLAY]==DD_DISPLAY_ON){
			echo '<span class="dd-enabled">Enabled</span>';
		}else{
			echo '<span class="dd-disabled">Disabled</span>';	
		}
		?>
		</h2>
		</div>
		<div class="dd-insider">
			
			<INPUT TYPE=CHECKBOX NAME="<?php echo DD_STATUS_OPTION_DISPLAY ?>" 
			<?php echo ($ddNormalDisplay[DD_STATUS_OPTION][DD_STATUS_OPTION_DISPLAY]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
			
			<span>Enable Normal Display</span>
	
			<div class="dd-button">
					<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" 
					value="<?php echo DD_FORM_BUTTON_SAVE; ?>" type="submit" style="width:100px;" />
			</div>
			
			<div style="clear:both"></div>
			
		</div>	
	</div>
	
	<div class="dd-block">
		<div class="dd-title"><h2>2. Display Configuration</h2></div>
		<div class="dd-insider">
		
			<div class="dd-insider-block">
				<span>2.1 Buttons are display in horizontal or vertical order?</span>
				<span>
				<?php 
					$dd_lineup_select = $ddNormalDisplay[DD_LINE_UP_OPTION][DD_LINE_UP_OPTION_SELECT];
				?>
				<select name="<?php echo DD_LINE_UP_OPTION_SELECT; ?>"  style="width:120px">
					<option value="<?php echo DD_LINE_UP_OPTION_SELECT_HORIZONTAL; ?>"
						<?php echo ($dd_lineup_select==DD_LINE_UP_OPTION_SELECT_HORIZONTAL) ? DD_SELECT_SELECTED : DD_EMPTY_VALUE; ?>
					>
					<?php echo dd_GetText(DD_LINE_UP_OPTION,DD_LINE_UP_OPTION_SELECT_HORIZONTAL); ?>
					</option>
					
					<option value="<?php echo DD_LINE_UP_OPTION_SELECT_VERTICAL; ?>"
						<?php echo ($dd_lineup_select==DD_LINE_UP_OPTION_SELECT_VERTICAL) ? DD_SELECT_SELECTED : DD_EMPTY_VALUE; ?>
					>
					<?php echo dd_GetText(DD_LINE_UP_OPTION,DD_LINE_UP_OPTION_SELECT_VERTICAL); ?>
					</option>
				</select> 
				</span>
			</div>
			
			<div class="dd-insider-block">
			<p>2.2 Buttons are display in...</p>
			<p>
			<?php 
				foreach($ddNormalDisplay[DD_DISPLAY_OPTION] as $key => $value){
		    	
					echo " <INPUT TYPE=CHECKBOX NAME='" . $key . "'" ;
					
					if($value==DD_DISPLAY_ON){
						echo DD_CHECK_BOX_ON;
					}else{
						echo DD_CHECK_BOX_OFF;
					}
					
					echo " ID='" . $key . "' /> ";
					echo dd_GetText(DD_DISPLAY_OPTION,$key);
			    }
	    	?>
			</p>
			</div>
								
			<div class="dd-insider-block" id="dd-insider-block-category">
				<p>
				2.3 Display in "Post" under categories...
				</p>
				<?php 
					$dd_category_option = $ddNormalDisplay[DD_CATEORY_OPTION][DD_CATEORY_OPTION_RADIO];
					$dd_category_option_text_include = $ddNormalDisplay[DD_CATEORY_OPTION][DD_CATEORY_OPTION_TEXT_INCLUDE];
					$dd_category_option_text_exclude = $ddNormalDisplay[DD_CATEORY_OPTION][DD_CATEORY_OPTION_TEXT_EXCLUDE];
				?>
				<div id="dd-insider-block-category-include">
					<INPUT TYPE="radio" NAME="<?php echo DD_CATEORY_OPTION_RADIO ?>" VALUE="<?php echo DD_CATEORY_OPTION_RADIO_INCLUDE ?>" 
					 <?php echo ($dd_category_option==DD_CATEORY_OPTION_RADIO_INCLUDE) ? DD_RADIO_BUTTON_ON : DD_RADIO_BUTTON_OFF; ?>
					 />
					Include  : <input type="text" size="40" value="<?php echo $dd_category_option_text_include ?>" 
					name="<?php echo DD_CATEORY_OPTION_TEXT_INCLUDE;?>" /> (e.g category1, category2,...)
				</div>
				
				<div id="dd-insider-block-category-exclude">
					<INPUT TYPE="radio" NAME="<?php echo DD_CATEORY_OPTION_RADIO ?>" VALUE="<?php echo DD_CATEORY_OPTION_RADIO_EXCLUDE ?>"
					 <?php echo ($dd_category_option==DD_CATEORY_OPTION_RADIO_EXCLUDE) ? DD_RADIO_BUTTON_ON : DD_RADIO_BUTTON_OFF; ?>
					 />
					Exclude : <input type="text" size="40" value="<?php echo $dd_category_option_text_exclude; ?>" 
					name="<?php echo DD_CATEORY_OPTION_TEXT_EXCLUDE;?>" /> (e.g category1, category2,...)
				</div>
				
			</div>
			
			<div class="dd-insider-block">
			<p>
				2.4
				<INPUT TYPE=CHECKBOX NAME="<?php echo DD_EXCERP_OPTION_DISPLAY ?>" 
				<?php echo ($ddNormalDisplay[DD_EXCERP_OPTION][DD_EXCERP_OPTION_DISPLAY]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
				<span> Enable DiggDigg to modify your post excerp.</span>
				<p><i>Deselect above setting, if it caused conflict to your existing excerp plugin.</i></p>
			</p>
			</div>
			
			<div class="dd-button">
					<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" 
					value="<?php echo DD_FORM_BUTTON_SAVE; ?>" type="submit" style="width:100px;" />
			</div>
			
			<div style="clear:both"></div>
			
		</div>
		
	</div>

	<div class="dd-block">
		<div class="dd-title"><h2>3. Buttons Selection</h2></div>
		<div class="dd-insider">
			<p>Choose and customize button layout to display.</p>
	
				<table border="1" width="100%" class="dd-table">
				<tr>
				    <th width="3%"></th>
					<th width="30%" class="left">Website</th>
					<th width="10%">Integration Type</th>
					<th width="10%">Button Design</th>
					<th width="5%">Weight</th>
					<th width="15%">Lazy Loading</th>
				</tr>
				
				<?php 
					$count=1;
					foreach($ddNormalButtons as $obj){	
				?>	
						<tr>
							<td>
								<?php echo $count++; ?>.
							</td>
							<td class="left">
								<a href="<?php echo $obj->websiteURL; ?>" target="_blank"><?php echo $obj->name; ?></a>
							</td>
							<td>	
								<select name="<?php echo $obj->option_append_type; ?>" style="width:120px">
								<option value="<?php echo DD_SELECT_NONE; ?>" <?php echo ($obj->getOptionAppendType()==DD_SELECT_NONE) ? DD_SELECT_SELECTED : DD_EMPTY_VALUE; ?>><?php echo DD_SELECT_NONE; ?></option>
								<option value="<?php echo DD_SELECT_LEFT_FLOAT; ?>" <?php echo ($obj->getOptionAppendType()==DD_SELECT_LEFT_FLOAT) ? DD_SELECT_SELECTED : DD_EMPTY_VALUE; ?>><?php echo DD_SELECT_LEFT_FLOAT; ?></option>
								<option value="<?php echo DD_SELECT_RIGHT_FLOAT; ?>" <?php echo ($obj->getOptionAppendType()==DD_SELECT_RIGHT_FLOAT) ? DD_SELECT_SELECTED : DD_EMPTY_VALUE; ?>><?php echo DD_SELECT_RIGHT_FLOAT; ?></option>
								<option value="<?php echo DD_SELECT_BEFORE_CONTENT; ?>" <?php echo ($obj->getOptionAppendType()==DD_SELECT_BEFORE_CONTENT) ? DD_SELECT_SELECTED : DD_EMPTY_VALUE; ?>><?php echo DD_SELECT_BEFORE_CONTENT; ?></option>
								<option value="<?php echo DD_SELECT_AFTER_CONTENT; ?>" <?php echo ($obj->getOptionAppendType()==DD_SELECT_AFTER_CONTENT) ? DD_SELECT_SELECTED : DD_EMPTY_VALUE; ?>><?php echo DD_SELECT_AFTER_CONTENT; ?></option>
								</select>
							</td>
							<td>
								<select name="<?php echo $obj->option_button_design; ?>" style="width:120px">
								
								<?php 
									foreach(array_keys($obj->buttonLayout) as $buttonKey){
								?>
										<option value="<?php echo $buttonKey; ?>"
											<?php echo ($obj->getOptionButtonDesign()==$buttonKey) ? DD_SELECT_SELECTED : DD_EMPTY_VALUE; ?>>
											<?php echo $buttonKey; ?>
										</option>
								<?php
									}	
								?>
								
								</select>
							</td>
							<td>
								<input name=<?php echo $obj->option_button_weight; ?> type="text" value="<?php echo ($obj->getOptionButtonWeight()==DD_EMPTY_VALUE) ? 0 : $obj->getOptionButtonWeight(); ?>"  size="3" maxlength="3"/>
							</td>
							<td>
								<?php
									if($obj->islazyLoadAvailable){
								?>
								<INPUT TYPE=CHECKBOX NAME="<?php echo $obj->option_lazy_load; ?>" <?php echo ($obj->getOptionLazyLoad()==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
								<?php
									}else{
										if($obj->name == "Facebook Like (XFBML)"){
											echo "<span class='dd-not-support'>Build-in Support</span>";	
										}
										else{
											echo "<span class='dd-not-support'>Not Support</span>";	
										}
									}
								?> 
							</td>
						</tr>
				
				<?php 
					}
				?>
				</table>
			
			<div class="dd-button">
					<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" 
					value="<?php echo DD_FORM_BUTTON_SAVE; ?>" type="submit" style="width:100px;" />
			</div>
			<div style="clear:both"></div>
		</div>
	</div>

	<div class="dd-block">
		<div class="dd-title"><h2>4. Reset Normal Display Settings</h2></div>
		<div class="dd-insider">
		<p>
		Reset all "Normal Display" settings to default value.
		</p>
		
		<input class="button-primary" onclick="if (confirm('Are you sure to reset \'Normal Display\' settings to default value?'))return true;return false" 
		name="<?php echo DD_FORM_CLEAR; ?>" value="Reset Normal Display Settings" type="submit" style="width:200px;"/>
	
		</div>
	</div>
	</form>

	<!-- start of dd-footer.php -->
	<?php include("dd-footer.php"); ?>
	<!-- end of dd-footer.php -->
	
</div>
<!-- end of dd_admin_left_block -->

<!-- start of dd-sidebar.php -->
<?php include("dd-sidebar.php"); ?>
<!-- end of dd-sidebar.php -->

</div>
<?php 
}
?>