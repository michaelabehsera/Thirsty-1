<?php 
	
  wp_enqueue_script('jquery');
 
		$categories = getCategories(0);
		$categoriesParents = getCategories(0);
		$pages = getPages();
		
		if (count($categories) > 0)
		{
    foreach ( $categories as $key => $value ) {

			$catids[] = $key;
			$catnames[] = $value;
		}
		}
		
		if (count($categoriesParents) > 0)
		{
    foreach ( $categoriesParents as $key => $value ) {

			$catidsp[] = $key;
			$catnamesp[] = $value;
		}
		}
		
		if (count($pages) > 0)
		{
    foreach ( $pages as $key => $value ) {

			$pagids[] = $key;
			$pagnames[] = $value;
		}
		}

		$homepath = get_bloginfo('template_directory');
		$blogtitle = get_bloginfo('name');
		
/* Settings Panel in Dashboard */
$themename = "BonPress Theme";
$shortname =  "wpzoom";

$options = array (

array(    "name" => "BonPress Theme Settings",
        "type" => "title"),
        
     

array(    "type" => "open"),
array(    "type" => "menu-open"),

array(    "type" => "menu-item",
          "image" => "icon_tools.png",
          "id" => "1",
          "name" => "General Settings"),
			
array(    "type" => "menu-item",
          "image" => "icon_home.png",
          "id" => "2",
          "name" => "Homepage Options"),
          
array(    "type" => "menu-item",
		  "image" => "icon_seo.png",
           "id" => "3",
          "name" => "SEO Options"),
          
array(    "type" => "menu-item",
		  "image" => "icon_menu.png",
          "id" => "4",
          "name" => "Navigation"),
          
array(    "type" => "menu-item",
			"image" => "icon_misc.png",
          "id" => "5",
          "name" => "Miscellaneous"),

          
array(    "type" => "menu-close"),


array(    "type" => "start-column",
          "id" => "1",
          "name" => "General Settings"),

array(    "type" => "preheader",
          "name" => "General Settings"),

array(    "name" => "Color Style",
        "desc" => "Choose the style that you would like to use.<br />",
        "id" => $shortname."_theme_style",
        "options" => array('Orange', 'Blue', 'Pink', 'Black'),
        "std" => "White",
        "type" => "select"),
        
array(    "name" => "Logo Image URL",
        "desc" => "You can upload your own logo via <a href='media-new.php' target='_blank'>Media Uploader</a><br />",
        "id" => $shortname."_misc_logo_path",
        "std" => "",
        "type" => "text"),
        
array(    "name" => "Favicon URL",
        "desc" => "You can upload your own favicon image (16x16px) via <a href='media-new.php' target='_blank'>Media Uploader</a><br />Leave this field blank if you don't want to display a favicon.",
        "id" => $shortname."_misc_favicon",
        "std" => "",
        "type" => "text"),

array(    "name" => "<img align='left' style='padding:0px 3px 0 0;' src='$homepath/wpzoom_admin/images/icons/feed.png' />RSS Feed URL",
        "desc" => "If you want to use Feedburner to track your RSS readers, insert your Feed Address here.<br />Example: <strong>http://feeds2.feedburner.com/wpzoom</strong><br />Leave it blank if you want to use the standard WordPress Feed.",
        "id" => $shortname."_misc_feedburner",
        "std" => "",
        "type" => "text"),
 
 array(    "type" => "preheader",
          "name" => "Archive Posts Options"),

array(    "name" => "Posts Content",
        "desc" => "<em><strong>REMEMBER:</strong></em> The number of articles displayed on homepage can be changed <a href='options-reading.php' target='_blank'>here</a>.",
        "id" => $shortname."_homepost_type",
        "options" => array('Full Content', 'Excerpt'),
        "std" => "Full Content",
        "type" => "select"),    
        
array(  "name" => "Date/time",
		"desc" => "<strong>Date/Time format</strong> can be changed <a href='options-general.php' target='_blank'>here</a>.",
  		"id" => $shortname."_home_date",
		"options" => array('Show', 'Hide'),
		"std" => "Show",
		"type" => "select"),  
	
array(  "name" => "Comments No.",
         "id" => $shortname."_home_comm",
		"options" => array('Show', 'Hide'),
		"std" => "Show",
		"type" => "select"), 
		
array(  "name" => "Read more button",
		"desc" => "Use this option to hide 'Read more' button from all posts. You can also hide this button from individual posts, when you edit them.",
    	"id" => $shortname."_home_readmore",
		"options" => array('Show', 'Hide'),
		"std" => "Show",
		"type" => "select"), 
 	
array(    "type" => "preheader",
          "name" => "Single Posts Options"),
		
array(  "name" => "Date/time",
		"desc" => "<strong>Date/Time format</strong> can be changed <a href='options-general.php' target='_blank'>here</a>.",
  		"id" => $shortname."_singlepost_date",
		"options" => array('Show', 'Hide'),
		"std" => "Show",
		"type" => "select"),  
	
array(  "name" => "Comments Count",
         "id" => $shortname."_singlepost_comm",
		"options" => array('Show', 'Hide'),
		"std" => "Show",
		"type" => "select"),  
 
array(  "name" => "Tags",
         "id" => $shortname."_singlepost_tags",
		"options" => array('Show', 'Hide'),
		"std" => "Show",
		"type" => "select"),
		
array(  "name" => "Trackbacks",
         "id" => $shortname."_trackbacks",
		"options" => array('Hide', 'Show'),
		"std" => "Hide",
		"type" => "select"), 
    
array(    "type" => "end-column"),


array(    "type" => "start-column",
          "id" => "2",
          "name" => "Homepage Options"),
 
        
        
array(    "type" => "preheader",
          "name" => "Welcome Message"),

array(    "name" => "Show Welcome Message on Homepage?",
         "id" => $shortname."_intro",
        "options" => array('Yes', 'No'),
        "std" => "Yes",
        "type" => "select"),
        
array(    "name" => "Message Title",
        "desc" => "For example: <em>Welcome to our website!</em>",
        "id" => $shortname."_intro_title",
        "std" => "Welcome to our website!",
        "type" => "text"),
        
array(    "name" => "Message Content",
        "desc" => "Add a short description about your website or agency. ",
        "id" => $shortname."_intro_content",
         "type" => "textarea"),
         
array(    "name" => "Profile Picture",
        "desc" => "You can upload your own picture via <a href='media-new.php' target='_blank'>Media Uploader</a> or specify your <strong>Gravatar</strong> email in this field.<br />",
        "id" => $shortname."_intro_avatar",
         "type" => "text"),

   
array(    "type" => "preheader",
          "name" => "Category Excluder"),   
        
array(    "name" => "Exclude Categories from homepage",
        "desc" => "Choose the categories which should be excluded from the main Loop on the homepage. TIP: hold CTRL key to select multiple categories.",
        "id" => $shortname."_exclude_cats_home",
        "categoryids" => $catidsp,
        "categorynames" => $catnamesp,
        "std" => "",
        "type" => "select-category-multi"),
 
 
		
array(    "type" => "end-column"),


array(    "type" => "start-column",
          "id" => "3",
          "name" => "SEO Options"),

array(    "type" => "preheader",
          "name" => "Activate WPZOOM SEO Options?"), 

array(    "name" => "WPZOOM SEO",
        "desc" => "If you want to use a 3rd party SEO Plugin, then you'll have to deactivate WPZOOM SEO Options.<br/><strong>Recomended SEO Plugins</strong>:<br/><a href=\"http://wordpress.org/extend/plugins/all-in-one-seo-pack/\">All in One SEO Pack</a><br/><a href=\"http://wordpress.org/extend/plugins/platinum-seo-pack/\">Platinum SEO Pack</a> ",
        "id" => $shortname."_seo_enable",
        "options" => array('Enable', 'Disable'),
        "std" => "Enable",
        "type" => "select"),
        
array(    "type" => "preheader",
          "name" => "Title Tag Structure <code>&lt;title&gt;</code>"),           
          
          
array(    "name" => "Homepage",
        "desc" => "Choose the format you would like to display <code>&lt;title&gt;</code> tag on homepage.",
        "id" => $shortname."_seo_home_title",
        "options" => array('Site Title - Site Description','Site Description - Site Title', 'Site Title'),
        "std" => "Site Title - Site Description",
        "type" => "select"),

array(    "name" => "Posts and Pages",
        "desc" => "Choose the format you would like to display <code>&lt;title&gt;</code> tag on Single Posts and Pages.",
        "id" => $shortname."_seo_posts_title",
        "options" => array('Page Title','Page Title - Site Title', 'Site Title - Page Title'),
        "std" => "Page Title",
        "type" => "select"),
        
array(    "name" => "Index Pages (Categories/Archives/Tags/Search Results)",
        "desc" => "Choose the format you would like to display <code>&lt;title&gt;</code> tag on index pages.",
        "id" => $shortname."_seo_pages_title",
        "options" => array('Page Title - Site Title','Site Title - Page Title', 'Page Title'),
        "std" => "Page Title - Site Title",
        "type" => "select"),
        
 array(    "name" => "Separator",
        "id" => $shortname."_title_separator",
        "std" => " &mdash; ",
        "type" => "text"),
                          
array(    "type" => "preheader",
           "name" => "Homepage META <code>&lt;meta&gt;</code>"),           
          
          
array(    "name" => "META Description for Homepage",
		"desc" => "Here you can insert META description for your <strong><em>home page</em></strong>, which will appear in search engines. If you leave it blank, the <a href='options-general.php' target='_blank'>Tagline</a> will be used instead. <br />On <strong><em>Single Posts</em></strong> by default will be used the excerpt to generate description.",
        "id" => $shortname."_meta_desc",
        "type" => "textarea"),

array(    "name" => "META Keywords for Homepage",
        "desc" => "Insert META keywords, comma separated. Generally META Keywords are ignored by Search Engines.<br />On <strong><em>Single Posts</em></strong> by default tags will be used to generate keywords.",
        "id" => $shortname."_meta_key",
        "type" => "text"),
        
        
array(    "type" => "preheader",
          "name" => "Search Engine Indexing Settings"),
          
array(  "name" => "Category Archives",
         "id" => $shortname."_index_category",
         "desc" => "The options below will help you prevent the indexing in search engines of unwanted pages that are generated automatically by WordPress that do nothing but dilute your search results by adding <code>&lt;noindex&gt;</code> tag.",
		"options" => array('index', 'noindex'),
		"std" => "index",
		"type" => "select"),
 
array(  "name" => "Tag Archives",
         "id" => $shortname."_index_tag",
		"options" => array('index', 'noindex'),
		"std" => "index",
		"type" => "select"),
        
array(  "name" => "Author Archives",
         "id" => $shortname."_index_author",
		"options" => array('index', 'noindex'),
		"std" => "index",
		"type" => "select"),
 
array(  "name" => "Date Archives",
         "id" => $shortname."_index_date",
		"options" => array('index', 'noindex'),
		"std" => "index",
		"type" => "select"),
                        
array(  "name" => "Search Results",
         "id" => $shortname."_index_search",
		"options" => array('index', 'noindex'),
		"std" => "index",
		"type" => "select"),

array(    "type" => "preheader",
           "name" => "Canonical Tag Settings"),  
           
array(    "name" => "Enable Canonical URLs",
        "desc" => "The Canonical Tag is used to inform search engines of the proper URL to index when they crawl your website.",
        "id" => $shortname."_canonical",
        "options" => array('No', 'Yes'),
         "type" => "select"),
         "std" => "No",
        
                 
array(    "type" => "end-column"),

array(    "type" => "start-column",
          "id" => "4",
          "name" => "Navigation"),

array(    "type" => "preheader",
	"name" => "You can create a Custom Menu for your theme in <a href='nav-menus.php' target='_blank'>Menus Section</a>"), 
        
                 
array(    "type" => "end-column"),
  
array(    "type" => "start-column",
          "id" => "5",
          "name" => "Miscellanneous"),

array(    "type" => "preheader",
          "name" => "Miscellaneous Settings"), 

array(    "name" => "Excerpt lenght",
        "desc" => "Default: <strong>50</strong> (words)",
        "id" => $shortname."_excerpt",
        "std" => "50",
        "type" => "text"),

array(    "type" => "preheader",
          "name" => "Tracking code: Google Analytics, etc."),

array(    "name" => "Include Tracking Script?",
        "desc" => "If you want to add some tracking script to the footer, like Google Analytics, choose Yes",
        "id" => $shortname."_misc_analytics_select",
        "options" => array('No', 'Yes'),
        "std" => "No",
        "type" => "select"),

array(    "name" => "Tracking Script Code",
        "desc" => "Insert the complete tracking script that should be included in the footer.",
        "id" => $shortname."_misc_analytics",
        "std" => "",
        "type" => "textarea"),
     
array(    "type" => "end-column"),


array(    "type" => "close")

);

function wpzoom_add_admin() {

    global $query_string; global $options; global $shortname;      

    if ( $_GET['page'] == 'wpzoom_options') {
           
        if ( 'save' == $_REQUEST['action'] ) {
    
                foreach ($options as $value) {
                
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] );
                
                }

                $send = $_GET['page'];
                header("Location: admin.php?page=$send&saved=true");                                
            
            die;

        } else if ( 'reset' == $_REQUEST['action'] ) {
            
            global $wpdb;
            $query = "DELETE FROM $wpdb->options WHERE option_name LIKE 'wpzoom_%'";
            $wpdb->query($query);
            
            $send = $_GET['page'];
            header("Location: admin.php?page=$send&reset=true");
            die;
        }

    } // $_GET['page'] == 'wpzoom_options'

// Check all the Options, then if the no options are created for a relative sub-page... it's not created.

    if(function_exists(add_object_page))
    {
        add_object_page ('WPZOOM &raquo; Theme Options', 'WPZOOM', 12, 'wpzoom_home', 'wpzoom_page_gen', get_bloginfo('template_directory') . '/images/favicon.png');
    }
    else
    {
        add_menu_page ('WPZOOM &raquo; Theme Options', 'WPZOOM', 12,'functions.php', 'wpzoom_page_gen', get_bloginfo('template_directory') . '/images/favicon.png'); 
    }
         add_submenu_page('wpzoom_home', 'Theme Options', 'Theme Options', 8, 'wpzoom_options','mytheme_admin'); 
         add_submenu_page('wpzoom_home', 'WPZOOM News', 'WPZOOM News', 8, 'wpzoom_news', 'wpzoom_more_news_page');  
         add_submenu_page('wpzoom_home', 'WPZOOM Themes', 'WPZOOM Themes', 8, 'wpzoom_themes', 'wpzoom_more_themes_page');
    }
    
    
function wpzoom_page_gen($page){
 
    $options =  get_option('wpzoom_template');      
    $themename =  get_option('wpzoom_themename');      
    $shortname =  get_option('wpzoom_shortname');
    $manualurl =  get_option('wpzoom_manual'); 
    
?>
 <?php
}  

function mytheme_admin() {

    global $themename, $shortname, $options;
 ?>
<?php global $homepath; ?>
<div id="zoomWrap">
  <div id="zoomHead">
    <div id="zoomLogo"><a href="http://www.wpzoom.com" target="_blank"><img src="<?php echo $homepath; ?>/wpzoom_admin/images/wpzoom_logo.png" alt="" /></a></div>
    <div id="zoomTheme"><h3><?php echo $themename; ?></h3></div>
	<div id="zoomInfo"><ul><li class="documentation"><a href="http://www.wpzoom.com/documentation/bonpress">Documentation</a></li><li class="support"><a href="http://www.wpzoom.com/forum" target="_blank">Support Forum</a></li></ul></div>
  </div>
<?php foreach ($options as $value) {

switch ( $value['type'] ) {

case "open":
?>

<?php break;

case "close":
?>

<?php break;

case "menu-open":
?>
  <div id="zoomNav">
    <ul class="tabs">
<?php break;

case "menu-item":
?>
<li><img src="<?php echo $homepath; ?>/wpzoom_admin/images/<?php echo $value['image']; ?>" alt="" /><a href="#tab<?php echo $value['id']; ?>"><?php echo $value['name']; ?></a></li>
<?php break;

case"menu-close":
?>
    </ul>
    <div class="cleaner">&nbsp;</div>
  </div>
  <div class="tab_container">
<form method="post">
<?php 
break;

case "start-column":
?>
<div id="tab<?php echo $value['id']; ?>" class="tab_content">
      <div class="zoomTitle">
        <h3><?php echo $value['name']; ?></h3>
      </div>
      <div class="zoomForms">
<?php break;

case "end-column":
?>
      </div><!-- end .zoomForms -->
</div>

<?php break;

case "separator":
?>
<div class="sep">&nbsp;</div>

<?php break;

case "cleaner":
?>
<div class="cleaner">&nbsp;</div>

<?php break;

case "preheader":
?>
        <h4><?php echo $value['name']; ?></h4>
       
<?php break;

case 'text':
?>

<label><?php echo $value['name']; ?></label>
<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings($value['id'] )); } else { echo $value['std']; } ?>" />
<p><?php echo $value['desc']; ?></p>
<div class="cleaner">&nbsp;</div>
<?php
break;

case 'textarea':
?>
<label><?php echo $value['name']; ?></label>
<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'] )); } else { echo $value['std']; } ?></textarea>
<p><?php echo $value['desc']; ?></p>
<div class="cleaner">&nbsp;</div>
<?php
break;

case 'select':
?>
<label><?php echo $value['name']; ?></label>
<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select>
<p><?php echo $value['desc']; ?></p>
<div class="cleaner">&nbsp;</div>
<?php
break;

case 'select-category':
?>
<label><?php echo $value['name']; ?></label>
<select name="<?php echo $value['id']; ?>"><option value="0">- not selected -</option><?php foreach ($value['categoryids'] as $key => $val) { ?><option value="<?php echo"$val";?>"<?php if ( get_settings( $value['id'] ) == $val) { echo ' selected="selected"'; } ?>><?php echo $value['categorynames'][$key]; ?></option><?php } ?></select>
<p><?php echo $value['desc']; ?></p>
<div class="cleaner">&nbsp;</div>
<?php
break;

case 'select-category-multi':

$activeoptions = get_settings( $value['id'] );

if (!$activeoptions)
{
$activeoptions = array();
}

?>
<label><?php echo $value['name']; ?></label>
<select multiple="true" name="<?php echo $value['id']; ?>[]" style="height: 150px;">
<?php foreach ($value['categoryids'] as $key => $val) { ?><option value="<?php echo"$val";?>"<?php if ( in_array($val,$activeoptions)) { echo ' selected="selected"'; } ?>><?php echo $value['categorynames'][$key]; ?></option><?php } ?></select>
<p><?php echo $value['desc']; ?></p>
<div class="cleaner">&nbsp;</div>
<?php
break;

case "checkbox":
?>
 
<input type="checkbox" class="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php if($value['std']) echo "checked='checked'"; ?> /> <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
<p><?php echo $value['desc']; ?></p>
<div class="cleaner">&nbsp;</div>
<?php         break;

}
}
?>
<p class="submit">
<input name="save" class="button-primary" type="submit" value="Save all changes" />
<input type="hidden" name="action" value="save" />

 <?php
 
    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>Options saved</strong></p></div>';
 ?>

</p>
</form>

<form method="post">
<p class="submit" style="float:right;">
<input name="reset" type="submit" value="Reset settings" />
<input type="hidden" name="action" value="reset" />
 <?php
 
     if ( $_REQUEST['reset'] ) echo '<div id="reset" class="updated fade"><p><strong>Options reset</strong></p></div>';
?>
</p>
</form>
</div><!-- end #zoomWrap -->

 
<?php
}

function wpzoom_more_news_page(){

       //global $options, $themename, $manualurl;
        
        ?>
        <style>
        ul.inline li {float: left; display: inline; padding: 0; margin: 0 10px 0 0; }
        
        ul.news {}
        ul.news li.post {background-color: #f1f1f1; border: solid 2px #ddd; padding: 15px;}
        ul.news h5 {font-size: 18px; }
        
        div.cleaner {clear: left; }
        
        div#features li {float: left; display: inline; margin: 0 20px 15px 0; }
        div#features li img {margin: 0 10px 5px 0; }        
        </style>
        <div class="wrap">
          <h2>More from WPZOOM</h2>
          <ul class="inline">
          <li><a href="http://www.wpzoom.com/themes/">More Themes</a></li><li><a href="http://www.wpzoom.com/support/">Support</a></li><li><a href="http://www.wpzoom.com/category/showcase/">Theme Showcase</a></li>
          </ul>
          <div class="cleaner">&nbsp;</div>
          
          
            <?php // Get RSS Feed(s)
            include_once(ABSPATH . WPINC . '/rss.php');
            $rss = fetch_rss('http://www.wpzoom.com/category/wpzoom/feed/');
            $maxitems = 20;
            $items = array_slice($rss->items, 0, $maxitems);
            ?>

            <ul class="news">
            <?php if (empty($items)) echo '<li>No items</li>';
            else
            foreach ( $items as $item ) : ?>

            <li class="post">
            <h2><a href="<?php echo"$item[link]"; ?>"><?php echo"$item[title]"; ?></a></h2><br />
            <?php print($item['content']['encoded']); ?>
            </li>

            <?php endforeach; ?>
            </ul>
            
            </div>
         
         <?php

};

function wpzoom_more_themes_page(){

       //global $options, $themename, $manualurl;
        
        ?>
        <style>
        ul.inline li {float: left; display: inline; padding: 0; margin: 0 10px 0 0; }
        
        ul.news {}
        ul.news li.post {background-color: #f1f1f1; border: solid 2px #ddd; padding: 15px;}
        ul.news h5 {font-size: 18px; }
        
        div.cleaner {clear: left; }
        
        div#features li {float: left; display: inline; margin: 0 20px 15px 0; }
        div#features li img {margin: 0 10px 5px 0; }        
        </style>
        <div class="wrap">
          <h2>More from WPZOOM</h2>
          <ul class="inline">
          <li><a href="http://www.wpzoom.com/themes/">More Themes</a></li><li><a href="http://www.wpzoom.com/support/">Support</a></li><li><a href="http://www.wpzoom.com/category/showcase/">Theme Showcase</a></li>
          </ul>
          <div class="cleaner">&nbsp;</div>
          
        <iframe src="http://www.wpzoom.com/frame/" width="550" height="600"></iframe>          
           
        </div><!-- end .wrap -->
         
         <?php

};

?>