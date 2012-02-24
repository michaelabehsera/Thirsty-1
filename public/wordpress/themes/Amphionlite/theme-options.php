<?php
/**
Plugin Name: Legion Settings
Plugin URI:
Description: Theme Options for Legion
Author: Towfiq I.
Version: 1.0
Author URI: http//towfiqi.com
*/

// Hook for adding admin menus
add_action('admin_menu', 'amphion_add_option_page');
if ( isset( $_GET['page'] ) && $_GET['page'] == 'amphion_option' ) {
	$file_dir=get_bloginfo('template_directory');
	wp_enqueue_style("functions", $file_dir."/other.css", false, "1.0", "all");
	wp_enqueue_script("amp_script", $file_dir."/js/amphion.js", false);
	wp_enqueue_script("amp_otscript", $file_dir."/js/other.js", false);	
}

function amphion_add_option_page(){

add_theme_page('AmphionLite Theme Options','Amphion Lite Options','manage_options','amphion_option','amphion_theme_option');

register_setting('amp_theme_options','amp_options','validate_options');

}

function amphion_theme_option(){

	//This will show any settings error or success message
	$error = get_settings_errors('amp_options');
	
	if(!empty($error)){
	echo '<div id="message" class="updated fade"><strong>';
	echo '<h3>The following errors are found</h3><ol>';
	foreach($error as $e){
	echo '<li>'.$e[message].'</li>';
	}
	echo '</ol></strong></div>';
	
	}else{
	echo '<div id="message" class="updated fade"><p><strong>Amphion Settings saved.</strong></p></div>';
	}

?>
<div class='wrap' style="width:700px;">
<div id="icon-themes" class="icon32"></div><h2>Legion Settings</h2>
<div id="tabs" class="options" style="width:700px;">
   <ul>
     <li><a href="#tab-1">General</a></li>
     <li><a href="#tab-2">Homepage</a></li>
     <li><a href="#tab-3">Slider</a></li>
     <li><a href="#tab-4">Social</a></li>
     <li><a href="#tab-5">Documentation</a></li>
     <li><a href="#tab-6">About</a></li>
     <li class="upgrade"><a href="#tab-7">Upgrade to Pro</a></li>
   </ul>


<form method="post" action="options.php">
			
			<!--this settings_fields function will generate the wordpress nonce security check as hidden inputs-->
            <!--this will make sure that values are send from this admin page and not from others -->
			<?php settings_fields('amp_theme_options'); ?>
			
			<?php $options = get_option('amp_options'); ?>
            <div class="amp_section" style="width:700px; float:left;">
                        
            <label><h4>Styles</h4></label>
            
            <p class="divider">
            <label>Select a style from the list</label>
            <?php
            
			$items = array("Water", "No Style");
			
			echo "<select name='amp_options[amp_style]'>";
			foreach($items as $item) {
				$selected = ($options['amp_style']==$item) ? 'selected="selected"' : '';
				echo "<option value='$item' $selected>$item</option>";
			}
			echo "</select>";
            
			?>
            </p>
            
            
            <label><h4>Fonts</h4></label>
            
            <p class="divider">
            <label>Select a font from the list</label>
            <?php
            
			$items = array("Lobster", "Arial");
			
			echo "<select name='amp_options[amp_fonts]'>";
			foreach($items as $item) {
				$selected = ($options['amp_fonts']==$item) ? 'selected="selected"' : '';
				echo "<option value='$item' $selected>$item</option>";
			}
			echo "</select>";
            
			?>
            </p>

            
            <p class="divider"><label><a>Show the full Content instead of the excerpt of the posts in index,archive and search page?</a></label>
            <input name="amp_options[amp_content]" type="checkbox" value="1" <?php if (isset($options['amp_content'])) {checked('1', $options['amp_content']);		} ?> /> </p>
            
            <p class="divider"><label><a>Display Blog Description?</a></label>
            <input name="amp_options[amp_description]" type="checkbox" value="1" <?php if (isset($options['amp_description'])) {checked('1', $options['amp_description']);		} ?> /></p>
            
            </div>
            
            <div class="amp_section" style="width:700px; float:left;">
			<p class="divider"><label><a>Hide All four Blocks?</a></label><img style=" float:right; margin-right:80px;" src="<?php bloginfo('template_directory')?>/images/admin/blocks.png" />
			<input name="amp_options[amp_hide_blocks]" type="checkbox" value="1" <?php if (isset($options['amp_hide_blocks'])) {checked('1', $options['amp_hide_blocks']);		} ?> /> </p>
            
            <p class="divider">
            <label>Select a category for the first block</label>
			<?php
			$categories=  get_categories(); 
            echo "<select name='amp_options[amp_block1]'>";
            foreach ($categories as $cat) {
                $selected = ($cat->cat_name==$options['amp_block1']) ? 'selected="selected"' : '';
                echo "<option value='$cat->cat_name' $selected>$cat->name</option>";
            }
            echo "</select>";
			?>
            </p>
            <p class="divider">
            <label>Select a category for the second block</label>
			<?php
			$categories=  get_categories(); 
            echo "<select name='amp_options[amp_block2]'>";
            foreach ($categories as $cat) {
                $selected = ($cat->cat_name==$options['amp_block2']) ? 'selected="selected"' : '';
                echo "<option value='$cat->cat_name' $selected>$cat->name</option>";
            }
            echo "</select>";
			?>
            </p>
            <p class="divider">
            <label>Select a category for the third block</label>
			<?php
			$categories=  get_categories(); 
            echo "<select name='amp_options[amp_block3]'>";
            foreach ($categories as $cat) {
                $selected = ($cat->cat_name==$options['amp_block3']) ? 'selected="selected"' : '';
                echo "<option value='$cat->cat_name' $selected>$cat->name</option>";
            }
            echo "</select>";
			?>
            </p>
            <p class="divider">
            <label>Select a category for the fourth block</label>
			<?php
			$categories=  get_categories(); 
            echo "<select name='amp_options[amp_block4]'>";
            foreach ($categories as $cat) {
                $selected = ($cat->cat_name==$options['amp_block4']) ? 'selected="selected"' : '';
                echo "<option value='$cat->cat_name' $selected>$cat->name</option>";
            }
            echo "</select>";
			?>
            </p>
            
            <p class="divider"><label>My Blocks are not working. Fix It</label>
			<input name="amp_options[amp_fix_blocks]" type="checkbox" value="1" <?php if (isset($options['amp_fix_blocks'])) {checked('1', $options['amp_fix_blocks']);		} ?> /> </p>
            
            </div>


			<div class="amp_section" style="width:700px; float:left;">
            <p class="divider">
            <label>Select a category for your slider from the list</label>
			<?php
			$categories=  get_categories(); 

            echo "<select name='amp_options[amp_cat]'>";
            foreach ($categories as $cat) {
                $selected = ($cat->cat_name==$options['amp_cat']) ? 'selected="selected"' : '';
                echo "<option value='$cat->cat_name' $selected>$cat->name</option>";
            }
            echo "</select>";

			?>
            </p>
            
            <p class="divider">
            <label>Number of Posts</label>
            <?php
            
			$items = array("1","2","3","4","5","6","7","8","9","10");
			
			echo "<select name='amp_options[amp_num]'>";
			foreach($items as $item) {
				$selected = ($options['amp_num']==$item) ? 'selected="selected"' : '';
				echo "<option value='$item' $selected>$item</option>";
			}
			echo "</select>";
            
			?>
            </p>
            <p class="divider">
            <label>Slider Speed<br /><small>Pause between each slides(in millisecond)</small></label>
            
            <input type="text" name="amp_options[amp_speed]" value="<?php 
                
                if(empty($options['amp_speed'])){
                echo '3000';
                }else{
                echo $options['amp_speed'];} 
                
                ?>" style="width:200px" />
            
            
            </p>
            
            <p class="divider"><label>Hide the "Featured" Ribbon</label>
			<input name="amp_options[amp_ribbon]" type="checkbox" value="1" <?php if (isset($options['amp_ribbon'])) {checked('1', $options['amp_ribbon']);		} ?> /></p>
            
            </div>

			<div class="amp_section" style="width:700px; float:left;">
            <p class="divider"><label>Hide all the Social Icons</label>
			<input name="amp_options[amp_hide_social]" type="checkbox" value="1" <?php if (isset($options['amp_hide_social'])) {checked('1', $options['amp_hide_social']);		} ?> /><img style=" float:right; margin-right:80px;" src="<?php bloginfo('template_directory')?>/images/admin/social_all.png" /></p>
            
            <label><h5>Twitter url
            <input type="text" name="amp_options[amp_tw_url]" value="<?php echo $options['amp_tw_url']; ?>" style="width:400px" />
            </h5>
            </label>
            <p class="divider"><small>Hide Twitter Icon</small>
			<input name="amp_options[amp_hide_tw]" type="checkbox" value="1" <?php if (isset($options['amp_hide_tw'])) {checked('1', $options['amp_hide_tw']);		} ?> /></p>
            
            
            <label><h5>Facebook url
            <input type="text" name="amp_options[amp_fb_url]" value="<?php echo $options['amp_fb_url']; ?>" style="width:400px" />
            </h5>
            </label>
            <p class="divider"><small>Hide Facebook Icon</small>
			<input name="amp_options[amp_hide_fb]" type="checkbox" value="1" <?php if (isset($options['amp_hide_fb'])) {checked('1', $options['amp_hide_fb']);		} ?> /></p>
            
            
            <label><h5>Myspace url
            <input type="text" name="amp_options[amp_ms_url]" value="<?php echo $options['amp_ms_url']; ?>" style="width:400px" />
            </h5>
            </label>
            <p class="divider"><small>Hide Myspace Icon</small>
			<input name="amp_options[amp_hide_ms]" type="checkbox" value="1" <?php if (isset($options['amp_hide_ms'])) {checked('1', $options['amp_hide_ms']);		} ?> /></p>
            
            
            <label><h5>RSS url
            <input type="text" name="amp_options[amp_rss_url]" value="<?php echo $options['amp_rss_url']; ?>" style="width:400px" />
            </h5>
            </label>
            <p class="divider"><small>Hide RSS Icon</small>
			<input name="amp_options[amp_hide_rss]" type="checkbox" value="1" <?php if (isset($options['amp_hide_rss'])) {checked('1', $options['amp_hide_rss']);		} ?> /></p><br />

			<p>Hide Social Buttons from post
			<input name="amp_options[amp_hide_share]" type="checkbox" value="1" <?php if (isset($options['amp_hide_share'])) {checked('1', $options['amp_hide_share']);		} ?> /><img style=" float:right; margin-right:80px;" src="<?php bloginfo('template_directory')?>/images/admin/social.png" /></p>
	
            
            </div>
            
       <div class="amp_section" style="width:700px; float:left;">
            <div class="amp_docum" style="width:600px; float:left; font-family:Arial, Helvetica, sans-serif;">
                <h3 style=" font-family:Arial; font-style:normal">How to setup the slider: </h3>
                <ol>
                <li>At first from admin panel go to <b>Appearance> Amphion Lite Options</b> and click on the <b>"slider"</b> tab now select the category from which you want to show the posts from in the slider. </li>
                <li>Select the number of posts you want to show in the slider.</li>
                <li>Create a post under your selected slider category that you want to display as a slide. <br />
                <li><b>To Add Image:</b>
                Notice that there is a <b>Featured Image</b> Option on the right side of the page. Attach Your slider Image(573 x 223) and click on <b>"Use as Featured Image"</b>
                <img style="float:left;  margin-bottom:10px; margin-right:10px;" src="<?php bloginfo('template_directory')?>/images/admin/featured.png" />
                <div style="clear:both"></div>
                </li>
                <li><b>To add Slider Sub-text</b>
                Notice a field called <b>"summary"</b> appeared right below the editor. Put your post summary in the <b>"summary"</b> filed.<br />
                <br />
                <img style="float:left;  margin-bottom:10px;" src="<?php bloginfo('template_directory')?>/images/admin/slide_docum.png" />
                <br />
                
                If for existing posts the <b>"summary"</b> fields dons not appear click on the post's update button and the field will appear automatically.<br />
                In wordpress 3.1 the custom field option is disabled on default. To enable the custom field feature go to Posts > Add New . In the post editor page at the very top click on the "Screen Options" button. Now make sure "Custom Field" option is checked. <a target="_blank" href="<?php bloginfo('template_directory')?>/images/admin/amphion_custom_fields.png">Check this image for better understanding</a>.<br />

                </li>
                </ol><br />
                
                <h3 style=" font-family:Arial; font-style:normal">Widgets</h3>
                <p>There are total 5 widgets that come with the theme. After activating the theme go to Appearance> Widgets and you will see 5 widgets:</p>
                <ol style="float:left">
                <li>Amphion- Popular Posts</li>
                <li>Amphion- Random Posts</li>
                </ol><img style="float:right;" src="<?php bloginfo('template_directory')?>/images/admin/widgets.jpg" /><br />
                
                
                <h3 style=" clear:both; font-family:Arial; font-style:normal">Shortcodes</h3>
                <p>There are total 2 shortcodes that come with the theme. To use shortcode you have to put the following codes(in HTML mode)while writing posts:</p>
                <img style="float:left; margin-bottom:10px;" src="<?php bloginfo('template_directory')?>/images/admin/shortcodes.jpg" />
                <p><b>FACEBOOK LIKE BUTTON</b>
                Usage: just add [fblike] anywhere in your posts (in Html Mode)</p>
                <p><b>SPECIAL BUTTON</b>
                Usage: [button link=" http://www.google.com"]Your button Text[/button]</p><br />
                
                <h3 style=" clear:both; font-family:Arial; font-style:normal">Page Types</h3>
                <p>There are 3 page types included with this theme:</p>
                <ol>
                <li>Page with left Sidebar</li>
                <li>Page with No sidebar</li>
                <li>Portfolio Page</li>
                </ol>
                <p>To Apply page type/template while creating a new page look for <b>"Page Attributes"</b> on the right. Under Template there are 3 templates in the dropdown list. Select any from the dropdown list.<br />
                To create Portfolio Page you have to create a <b>"portfolio"</b> category. 
                </p><br />
                
                <h3 style=" clear:both; font-family:Arial; font-style:normal">Lightbox</h3>
                A fancy lightbox is automatically applied to the images. To know more about the fancybox visit this <a target="_blank" href="http://fancybox.net/">link</a>.
                </div>
                
          </div>
          <div class="amp_section" style="width:700px; float:left;">
          	<div class="amp_about">
            <h3 style=" clear:both; font-family:Arial; font-style:normal">About the theme</h3>
            Amphion is a wordpress 3 theme with awesome skins,fonts &amp; options. The name Amphion derived from the son of Zeus Amphion who was one of the builder of Thebes. There are two versions of this theme:
            <ul style="margin-top:10px; margin-left:10px; list-style-type:circle;">
            <li style="float:none; background:none; border:none; padding:0; margin:0; display:list-item;"><a style=" color:#21759B;" href="http://www.towfiqi.com/amphion-lite-free-wordpress-theme.html" target="_blank">Amphion Lite(Free)</a></li>
            <li style="float:none; background:none; border:none; padding:0; margin:0; display:list-item;"><a style=" color:#21759B;" href="http://www.towfiqi.com/amphion-pro-wordpress-theme.html" target="_blank">Amphion  Pro(Commercial)</a></li>
            </ul>
            <div class="author">
            <h3 style=" clear:both; font-family:Arial; font-style:normal">About the Developer</h3>
            <div class="admin_social">
            <img style="float:left;" src="<?php bloginfo('template_directory')?>/images/admin/towfiqi.jpg" />
            <a class="admin_fb" target="_blank" href="http://www.facebook.com/pages/Towfiq-I/180981878579536">Facebook</a>
            <a class="admin_twitter" target="_blank" href="http://www.twitter.com/towfiqi">Twitter</a>
            <a class="admin_web" target="_blank" href="http://www.towfiqi.com/">Web</a></div>
            <br />
            This Theme is designed and devloped by <a href="http://www.towfiqi.com/">Towfiq I.</a><br />
            
            The theme is licensed under <a href="http://www.gnu.org/licenses/old-licenses/gpl-2.0.html">GNU General Public License v2 </a>
            </div>
</div>
          </div>
           <div class="amp_section" style="width:700px; float:left;">
               <div class="amp_upgrade">
                <h3 style=" clear:both; font-family:Arial; font-style:normal">Upgrade to PRO</h3>
                <p>You are Currently using <em>Amphion Lite</em>. Upgrade to <b>Amphion Pro</b> for more features and support.</p>
                <p><b>Why you should go for the pro:</b><br />
                Here are the features comparison between Amphion Lite and Amphion PRO</p>
                
                <table class="upgrade-table">
                <tr class="tableizer-firstrow"><th>Features</th><th>Amphion <em>Lite</em></th><th>Amphion Pro</th></tr> <tr><td>Skins</td><td><a class="no">2 skins</a></td><td><a class="yes">7 skins</a></td></tr> <tr><td>Sliders</td><td><a class="no">1 slider</a></td><td><a class="yes">3 sliders</a></td></tr> <tr><td>Fonts</td><td><a class="no">2 Fonts</a></td><td><a class="yes">10 Fonts</a></td></tr> <tr><td>Custom widgets</td><td><a class="no">2 custom widgets<br />
                -Popular Posts
                -Random Posts</a></td><td><a class="yes">5 custom widgets:<br />-Popular Posts
                -Random Posts
                -Featured posts
                -Twitter Feed
                -Advertisement Widget
                </a></td></tr> <tr><td>Shortcodes</td><td style="background:#ffd8d8;"><a class="no">2 shortcodes:<br />-Facebook Like Button
                -Special Button
                </a></td><td><a class="yes">5 shortcodes:<br />
                -Facebook Like Button
                -Special Button
                -Administrator Note
                -Show post's last attached image
                -Google adsense shortcode</a></td></tr> <tr><td>Option for image logo</td><td><a class="no">No</a></td><td><a class="yes">YES</a></td></tr> <tr><td>SEO Optimization</td><td><a class="no">No</a></td><td><a class="yes">YES</a></td></tr> <tr><td>Add Favicon</td><td><a class="no">No</a></td><td><a class="yes">YES</a></td></tr> <tr><td>Total Options</td><td>&nbsp;</td><td><a class="yes">25+ options</a></td></tr> <tr><td>Multi-level Dropdown Menu</td><td><a class="yes">YES</a></td><td><a class="yes">YES</a></td></tr> <tr><td>Custom Login Page</td><td><a class="no">No</a></td><td><a class="yes">YES</a></td></tr> <tr><td>Related Posts</td><td><a class="no">No</a></td><td><a class="yes">YES</a></td></tr> <tr><td>Numbered Page Navigation</td><td><a class="yes">YES</a></td><td><a class="yes">YES</a></td></tr> <tr><td>Threaded comments support</td><td><a class="yes">YES</a></td><td><a class="yes">YES</a></td></tr> <tr><td>Fancy lightbox</td><td><a class="yes">YES</a></td><td><a class="yes">YES</a></td></tr> <tr><td>IE6 Browser Upgrade Alert!</td><td><a class="yes">YES</a></td><td><a class="yes">YES</a></td></tr> <tr><td>Separation of Comments and Trackbacks</td><td style="background:#d8ffe7;"><a class="yes">YES</a></td><td style="background:#d8ffe7;"><a class="yes">YES</a></td></tr><tr><td>Full Email support</td><td><a class="no">No</a></td><td><a class="yes">YES</a></td></tr></table><br />
                
                <a class="sbutton" href="http://www.towfiqi.com/amphion-pro-wordpress-theme.html" target="_blank"><span>Upgrade to Pro</span></a>
                
                <h3 style=" font-family:Arial; font-style:normal">About the Homepage Blocks </h3>
                <p>The 4 blocks in homepage display the latest posts from selected category. Make sure sure each of your selected categories have atleast one post.</p>
                
                </div>
           </div>
           	
            <p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>

</form>


</div></div>
<?php

}

function validate_options($amp_options){
//start checking options

//sanitise facebook url, make sure no html tags!
$amp_options['amp_tw_url'] = wp_filter_nohtml_kses($amp_options['amp_tw_url']);
$amp_options['amp_fb_url'] = wp_filter_nohtml_kses($amp_options['amp_fb_url']);
$amp_options['amp_ms_url'] = wp_filter_nohtml_kses($amp_options['amp_ms_url']);
$amp_options['amp_rss_url'] = wp_filter_nohtml_kses($amp_options['amp_rss_url']);
$amp_options['amp_speed'] = wp_filter_nohtml_kses($amp_options['amp_speed']);
//Description Sanitizing!
if ( ! isset( $amp_options['amp_description'] ) )
$amp_options['amp_description'] = null;
$amp_options['amp_description'] = ( $amp_options['amp_description'] == 1 ? 1 : 0 );
//Ribbon Sanitizing!
if ( ! isset( $amp_options['amp_ribbon'] ) )
$amp_options['amp_ribbon'] = null;
$amp_options['amp_ribbon'] = ( $amp_options['amp_ribbon'] == 1 ? 1 : 0 );
//Hide Social Sanitizing!
if ( ! isset( $amp_options['amp_hide_social'] ) )
$amp_options['amp_hide_social'] = null;
$amp_options['amp_hide_social'] = ( $amp_options['amp_hide_social'] == 1 ? 1 : 0 );	
//Twitter Sanitizing!
if ( ! isset( $amp_options['amp_hide_tw'] ) )
$amp_options['amp_hide_tw'] = null;
$amp_options['amp_hide_tw'] = ( $amp_options['amp_hide_tw'] == 1 ? 1 : 0 );
//Facebook Sanitizing!
if ( ! isset( $amp_options['amp_hide_fb'] ) )
$amp_options['amp_hide_fb'] = null;
$amp_options['amp_hide_fb'] = ( $amp_options['amp_hide_fb'] == 1 ? 1 : 0 );
//Myspace Sanitizing!
if ( ! isset( $amp_options['amp_hide_ms'] ) )
$amp_options['amp_hide_ms'] = null;
$amp_options['amp_hide_ms'] = ( $amp_options['amp_hide_ms'] == 1 ? 1 : 0 );
//RSS Sanitizing!
if ( ! isset( $amp_options['amp_hide_rss'] ) )
$amp_options['amp_hide_rss'] = null;
$amp_options['amp_hide_rss'] = ( $amp_options['amp_hide_rss'] == 1 ? 1 : 0 );
//Content Sanitizing!
if ( ! isset( $amp_options['amp_content'] ) )
$amp_options['amp_content'] = null;
$amp_options['amp_content'] = ( $amp_options['amp_content'] == 1 ? 1 : 0 );
//Hide BLOCKS Sanitizing!
if ( ! isset( $amp_options['amp_hide_blocks'] ) )
$amp_options['amp_hide_blocks'] = null;
$amp_options['amp_hide_blocks'] = ( $amp_options['amp_hide_blocks'] == 1 ? 1 : 0 );
//FIX BLOCKS Sanitizing!
if ( ! isset( $amp_options['amp_fix_blocks'] ) )
$amp_options['amp_fix_blocks'] = null;
$amp_options['amp_fix_blocks'] = ( $amp_options['amp_fix_blocks'] == 1 ? 1 : 0 );

//do checking for all options

return $amp_options;

}
?>