<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
	
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	
	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/other.css" type="text/css" media="all" />
    <!--[if IE]>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/ie.css" />
    <![endif]--> 
    <?php wp_enqueue_script('jquery'); ?>
    <?php wp_enqueue_script('amphion',get_bloginfo('template_directory').'/js/amphion.js'); ?>
    <?php wp_enqueue_script('font',get_bloginfo('template_directory').'/js/font.js'); ?>
    <?php wp_enqueue_script('other',get_bloginfo('template_directory').'/js/other.js'); ?>
    <?php wp_get_archives('type=monthly&format=link'); ?>
	<?php //comments_popup_script(); // off by default ?>
    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>    
</head>
<body <?php body_class(); ?>>
<div id="wrapper">
<!--Header-->
<div id="header">
<div id="logo"><h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1></div>
</div>

<!--MENU-->
<div id="topmenu"><?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?></div>

<!--ERROR MESSAGE-->
<div id="error_wrap">
<div id="single_posts">
	<div class="post_top"></div>
	<div class="post_mid"><a>404</a>
        <div class="error_msg">
        <h2><?php _e('Not Found', 'amphion_lite'); ?></h2>
        <p><?php _e('Server cannot find the file you requested. File has either been moved or deleted, or you entered the wrong URL or document name. Look at the URL. If a word looks misspelled, then correct it and try it again. If that doesnt work You can try our search option to find what you are looking for.', 'amphion_lite'); ?></p>
        <?php get_search_form(); ?>
        </div>
    </div>
    <div class="post_bottom"></div>
    </div>
</div>
</div>
<!--Footer-->
<?php get_footer(); ?>