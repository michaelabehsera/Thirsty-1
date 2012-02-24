<?php
function my_init() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');		
		wp_register_script('gazpo', get_bloginfo('template_directory').'/js/gazpo_custom.js');
		wp_enqueue_script('gazpo');	
		wp_register_style('slider', get_bloginfo('template_directory').'/includes/gazpo_slider.css');
		wp_enqueue_style('slider');
		
	if (is_admin()) {
		wp_register_script('tabs', get_bloginfo('template_directory').'/gazpo_admin/gazpo_admin_tabs.js');
		wp_enqueue_script('tabs');
		wp_register_style('options', get_bloginfo('template_directory').'/gazpo_admin/options.css');
		wp_enqueue_style('options');
	}
}
add_action('init', 'my_init');

function gazpo_cat_list(){
		$categories = get_categories('hide_empty=0'); 
		foreach ($categories as $cat) {
			if($cat->category_count == '0') {
				$posts_title = 'No posts!';
			} elseif($cat->category_count == '1') {
				$posts_title = '1 post';
			} else {
				$posts_title = $cat->category_count . ' posts';
		}
		$categories_array[] = array('value'=> $cat->cat_ID, 'title'=> $cat->cat_name . ' ( ' . $posts_title . ' )');
	  }
	return $categories_array;
}

$themename = "GazpoMag";
$shortname = "gazpo";

$options = array (

	array(  "name" => "Gazpo Theme Settings",
			"type" => "title"),     

	array(  "type" => "open"),
	array(  "type" => "menu-open"),

	array(  "type" => "menu-item",
			"id" => "1",
			"name" => "Homepage"),
			
	array(  "type" => "menu-item",
			"id" => "2",
			"name" => "Menus"),
			
	array(  "type" => "menu-item",
			"id" => "3",
			"name" => "Miscellaneous"),
		            
	array(  "type" => "menu-close"),
	
	array(  "type" => "tab-open",
			"id" => "1",
			"name" => "Homepage Settings"),
	
	array(  "type" => "preheader",
			"name" => "Homepage Settings"),
          
	array(  "name" => "Logo Image URL",
			"desc" => "Logo image URL. Image should be maximum 415x100px . Leave this blank if you want to use blog title. ",
			"id" => $shortname."_logo_url",
			"std" => get_bloginfo('template_directory')."/images/logo.png",
			"type" => "text"),
	
	array(  "name" => "Favicon URL",
			"desc" => "Leave this blank if you dont want to use favicon.",
			"id" => $shortname."_favicon_url",
			"std" => "",
			"type" => "text"),
	
	array(  "name" => "RSS URL",
			"desc" => "RSS Feeds url (eg. Feedburner). Leave ths blank if you want to use default.",
			"id" => $shortname."_rss_url",
			"std" => "",
			"type" => "text"), 
	
	array(  "type" => "preheader",
			"name" => "Homepage Slider"),
			
	array(  "name" => "Show slider?",
			"desc" => "Do you want to show slider on homepage?",
			"id" => $shortname."_slider_show",
			"options" => array('Yes', 'No'),
			"std" => "Yes",
			"type" => "select"),
		
	array(	"name" => "Slider Category", 
			"desc" => "Remember to add Featured image to the category posts. You can see the option in the right column in the New Post page.",
			 "id" => $shortname."_slider_category",
			"options" => gazpo_cat_list(),
			"std" => "0",
			"type" => "select-cat"),
	
	array(  "type" => "preheader",
			"name" => "Featured Categories"),
	
	array(  "name" => "Show Featured Categories",
			"desc" => "Do you want to show the featured categories block on homepage?",
			"id" => $shortname."_feat_cat_show",
			"options" => array('Yes', 'No'),
			"std" => "Yes",
			"type" => "select"),
		
	array(  "name" => "Featured Category 1",
			"desc" => "Select the category which should appear as #1.",
			"id" => $shortname."_feat_cat_1",
			"options" => gazpo_cat_list(),
			"std" => "0",
			"type" => "select-cat"),
		
	array(  "name" => "Featured Category 2",
			"desc" => "Select the category which should appear as #2.",
			"id" => $shortname."_feat_cat_2",
			"options" => gazpo_cat_list(),
			"std" => "0",
			"type" => "select-cat"),
	
	array(  "name" => "Featured Category 3",
			"desc" => "Select the category which should appear as #3.",
			"id" => $shortname."_feat_cat_3",
			"options" => gazpo_cat_list(),
			"std" => "0",
			"type" => "select-cat"),
	
	array(  "type" => "preheader",
			"name" => "Homepage Posts Preview"),
	
	array(  "name" => "Show post image",
			"desc" => "Do you want to show  image in post preview on homepage? <br />Remember to add Featured image to the posts ",
			"id" => $shortname."_post_thumbs_show",
			"options" => array('Yes', 'No'),
			"std" => "Yes",
			"type" => "select"),
	
	array(  "name" => "Show Twitter button",
			"desc" => "Do you want to show twitter button on homepage posts?",
			"id" => $shortname."_home_twitter_btn",
			"options" => array('Yes', 'No'),
			"std" => "Yes",
			"type" => "select"),
			
	array(  "type" => "preheader",
			"name" => "Twitter status"),

	array(  "name" => "Twitter Username",
			"desc" => "Enter your twitter username. <br />Leave this field blank if don't want to display latest tweet.",
			"id" => $shortname."_twitter_username",
			"std" => "",
			"type" => "text"),
			
	array(  "type" => "tab-close"),

	array(  "type" => "tab-open",
			"id" => "2",
			"name" => "Menu Settings"),
         
	array(  "type" => "preheader",
			"name" => "Header Menu"),

	array(  "name" => "Header menu choice",
			"desc" => "Do you want to show categories or pages in the header menu?",
			"id" => $shortname."_header_menu_choice",
			"options" => array("Pages", "Categories", "Show none, disable the menu"),
			"std" => "Pages",
			"type" => "select"),
			
	
	array(  "name" => "Show specific",
			"desc" => "If you want to show specific pages or categories, enter each of the page or category ID separated by comma. For example 2,4,7. <br />Leave this field blank if you want to show default.",
			"id" => $shortname."_header_menu_ids",
			"std" => "",
			"type" => "text"),
			
	array(  "type" => "preheader",
			"name" => "Main Menu"),
	
	array(  "name" => "Main menu choice",
			"desc" => "Do you want to show categories or pages in the main menu?",
			"id" => $shortname."_main_menu_choice",
			"options" => array('Categories', 'Pages'),
			"std" => "Categories",
			"type" => "select"),
	
	array(  "name" => "Show specific",
			"desc" => "If you want to show specific pages or categories, enter each of the page or category ID separated by comma. For example 2,4,7. <br />Leave this field blank if blank if you want to show default.",
			"id" => $shortname."_main_menu_ids",
			"std" => "",
			"type" => "text"),
		
	array(  "type" => "tab-close"),
	
	array(  "type" => "tab-open",
			"id" => "3",
			"name" => "Miscellaneous"),
	
	array(  "type" => "preheader",
			"name" => "Social Sharing Buttons"),
	
	array(  "name" => "Show in Posts",
			"desc" => "Do you want to show social sharing buttons in posts?",
			"id" => $shortname."_s_social_posts_show",
			"options" => array('Yes', 'No'),
			"std" => "Yes",
			"type" => "select"),
			
	array(  "name" => "Show in Pages",
			"desc" => "Do you want to show social sharing buttons in pages?",
			"id" => $shortname."_s_social_pages_show",
			"options" => array('Yes', 'No'),
			"std" => "Yes",
			"type" => "select"),
				
	array(  "name" => "Button 1",
			"desc" => "Select Button 1",
			"id" => $shortname."_s_socialbar_btn1",
			"options" => array('Google+', 'Facebook', 'Twitter', 'Stumble upon', 'Linked In', 'Digg', 'AddThis'),
			"std" => "Google+",
			"type" => "select"),
	
	array(  "name" => "Button 2",
			"desc" => "Select Button 2",
			"id" => $shortname."_s_socialbar_btn2",
			"options" => array('Facebook', 'Google+', 'Twitter', 'Stumble upon', 'Linked In', 'Digg', 'AddThis'),
			"std" => "Facebook",
			"type" => "select"),
			
	array(  "name" => "Button 3",
			"desc" => "Select Button 3",
			"id" => $shortname."_s_socialbar_btn3",
			"options" => array('None', 'Facebook', 'Google+', 'Twitter', 'Stumble upon', 'Linked In', 'Digg', 'AddThis'),
			"std" => "None",
			"type" => "select"),
			
	array(  "name" => "Button 4",
			"desc" => "Select Button 4 (Optional)",
			"id" => $shortname."_s_socialbar_btn4",
			"options" => array('None', 'Facebook', 'Google+', 'Twitter', 'Stumble upon', 'Linked In', 'Digg', 'AddThis'),
			"std" => "None",
			"type" => "select"),
	
	array(  "name" => "Button 5",
			"desc" => "Select Button 5 (Optional)",
			"id" => $shortname."_s_socialbar_btn5",
			"options" => array('None', 'Facebook', 'Google+', 'Twitter', 'Stumble upon', 'Linked In', 'Digg', 'AddThis'),
			"std" => "None",
			"type" => "select"),
	
	array(  "type" => "preheader",
			"name" => "Tracking Code "),
			
	array(	"name" => __("Stats tracking Code"),
			"desc" => __("Enter your tracking code (eg. Google analytics or any other) code. It will be inserted before the closing body tag."),
			"id" => $shortname."_tracking_code",
			"std" => "",
			"type" => "textarea"),
		
	array(  "type" => "tab-close"),
	array(  "type" => "close")

);

	function mytheme_add_admin() {
    global $themename, $shortname, $options;
    if ( isset($_GET['page'] ) && ($_GET['page'] == basename(__FILE__) ) ) {    
        if ( isset($_REQUEST['action']) && ( 'save' == $_REQUEST['action'] )  ) {
                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
                header("Location: themes.php?page=gazpo_options.php&saved=true");
                die;
		} else if( isset($_REQUEST['action']) && ( 'reset' == $_REQUEST['action'] ) ) {
			foreach ($options as $value) {
                delete_option( $value['id'] ); }
            header("Location: themes.php?page=gazpo_options.php&reset=true");
            die;
        }
    }
    add_theme_page($themename." Options", "".$themename." Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
	}

	function mytheme_admin() {

    global $themename, $shortname, $options;
 ?>

<div id="gazpo-admin">
	<div class="header">	
		<div class="gazpo-logo">
			<a href="http://gazpo.com" target="_blank"><img src="<?php echo bloginfo('template_directory'); ?>/gazpo_admin/images/logo.png" alt="" /></a>
		</div>		
		<div class="theme-info">		
				<h3><?php echo $themename; ?></h3>			
				<ul>
					<li class="docs"><a href="http://gazpo.com/2011/09/magazine-style-wordpress-theme" target="_blank">Theme Support</a></li>
					<li class="support"><a href="http://gazpo.com/contact/" target="_blank">Contact</a></li>
				</ul>			
		</div>
	</div>
  
	<?php 
	foreach ($options as $value) 
	{
		switch ( $value['type'] ) 
		{
			case "open":
			break;
			
			case "close":
			break;
			
			
			case "menu-open":
			?>
				<div class="menu">
					<ul class="tabs">
			<?php
			break;
			case "menu-item":
			?>
					<li>
						<a href="#tab<?php echo $value['id']; ?>"><?php echo $value['name']; ?></a>
					</li>
			<?php
			break;
			case"menu-close":
			?>
					</ul>
					
				</div>
  
				<div class="tab_container">
				<form method="post" action="">
			<?php 
			break;
			case "tab-open":
			?>
				<div id="tab<?php echo $value['id']; ?>" class="tab_content">
				
					<div class="options-form">
					<h3><?php echo $value['name']; ?></h3>
					<?php if( isset($_REQUEST['saved']) ) echo '<div class="updated fade"><p><strong>Options saved</strong></p></div>'; ?>
					<?php if( isset($_REQUEST['reset']) ) echo '<div class="updated fade"><p><strong>Options reset</strong></p></div>'; ?>
									
			<?php
			break;
			case "tab-close":
			?>			
					</div><!-- /options-forms -->
				</div><!-- /tab -->

			<?php
			
			break;
			case "preheader":
			?>
			
				<h4><?php echo $value['name']; ?></h4>
		
       		<?php 
			break;
			case 'text':
			?>
				<div class="field">
					<label><?php echo $value['name']; ?></label>
					<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" class="input" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option($value['id'] )); } else { echo $value['std']; } ?>" />
					<p><?php echo $value['desc']; ?></p>
				</div>
			
			<?php
			break;
			case 'textarea':
			?>
			<div class="field">
				<label><?php echo $value['name']; ?></label>
				<textarea class="textarea" name="<?php echo $value['id']; ?>"><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'] )); } else { echo $value['std']; } ?></textarea>
				<p><?php echo $value['desc']; ?></p>			
			</div>
			
			<?php
			break;
			case 'select':
			?>
			<div class="field">
				<label><?php echo $value['name']; ?></label>
				<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_option( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select>
				<p><?php echo $value['desc']; ?></p>
			</div>
			
			<?php
			break;
			case 'select-cat':
			?>
			<div class="field">
				<label><?php echo $value['name']; ?></label>
				<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
					<?php 
						foreach ($value['options'] as $option) { ?>
						<option value="<?php echo $option['value']; ?>" <?php if ( get_option( $value['id'] ) == $option['value']) { echo ' selected="selected"'; } ?>><?php echo $option['title']; ?></option>
						<?php } ?>
				</select>
				<p><?php echo $value['desc']; ?></p>
			</div>
			
			<?php
			break;
			case 'select-category-multi':
			
				$activeoptions = get_option( $value['id'] );
					if (!$activeoptions){
						$activeoptions = array();
					}
			?>
			<div class="field">
				<label><?php echo $value['name']; ?></label>
				<select multiple="true" name="<?php echo $value['id']; ?>[]" style="height: 150px;">
				<?php foreach ($value['categoryids'] as $key => $val) { ?><option value="<?php echo"$val";?>"<?php if ( in_array($val,$activeoptions)) { echo ' selected="selected"'; } ?>><?php echo $value['categorynames'][$key]; ?></option><?php } ?></select>
				<p><?php echo $value['desc']; ?></p>			
			</div>
			
			<?php
			break;
			case "checkbox":
			?>
			<div class="field">
				<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
				<input type="checkbox" class="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php if($value['std']) echo "checked='checked'"; ?> />
				<p><?php echo $value['desc']; ?></p>
			</div>
			
			<?php
			break;
		}
	}
?>

		<p class="submit">
			<input name="save" class="button-primary" type="submit" value="Save all" />
			<input type="hidden" name="action" value="save" />
		</p>
	</form>
	
	<form method="post" action="">
			<p class="submit">
				<input name="reset" type="submit" value="Reset" />
				<input type="hidden" name="action" value="reset" />
			</p>
		</form>

		
	</div>
	
	</div>

	<?php
	}
	add_action('admin_menu', 'mytheme_add_admin');
	?>