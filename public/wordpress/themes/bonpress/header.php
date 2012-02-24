<?php 
global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
} 
$activestyle = strtolower($wpzoom_theme_style);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<!--  Mobile viewport optimized: j.mp/bplateviewport -->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php if ($wpzoom_seo_enable == 'Enable') { wpzoom_titles(); } else { ?> <?php bloginfo('name'); wp_title('-'); } ?></title>
<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php if ($wpzoom_seo_enable == 'Enable') { 
if (is_single() || is_page() ) : if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<meta name="description" content="<?php echo strip_tags(get_the_excerpt()); ?>" />
<?php meta_post_keywords(); ?>
<?php endwhile; endif; elseif(is_home()) : ?>
<meta name="description" content="<?php if (strlen($wpzoom_meta_desc) < 1) { bloginfo('description');} else {echo"$wpzoom_meta_desc";}?>" />
<?php meta_home_keywords(); ?>
<?php endif; ?>
<?php wpzoom_index(); ?>
<?php wpzoom_canonical(); } ?>

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php wpzoom_rss(); ?>" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/functions/css/shortcodes.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/<?php echo"$activestyle";?>.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/custom.css" media="screen" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php if (strlen($wpzoom_misc_favicon) > 1 ) { ?><link rel="shortcut icon" href="<?php echo "$wpzoom_misc_favicon";?>" type="image/x-icon" /><?php } ?> 
<?php wp_enqueue_script('jquery');  ?>
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>  
<?php wp_head(); ?>
<?php wpzoom_js("dropdown", "custom"); ?>

</head>

<body <?php body_class($class); ?>> 

<div class="wrapper">
	<div id="aside">
		<div class="gig">
			<div id="logo">
				<a href="<?php echo home_url(); ?>"><?php if ($wpzoom_misc_logo_path) { ?><img src="<?php echo "$wpzoom_misc_logo_path";?>" alt="<?php bloginfo('name'); ?>" /><?php } else { ?><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>" /><?php } ?></a>
			</div>
			
			<div id="menu">
				<?php wp_nav_menu( array('container' => 'menu', 'container_class' => '', 'menu_class' => 'dropdown sf-vertical', 'menu_id' => 'mainmenu', 'sort_column' => 'menu_order', 'theme_location' => 'primary' ) ); ?>
			</div>
		</div>
		
		<div class="clear"></div>
		<?php get_sidebar(); ?>
	</div>
	
	<div id="main">