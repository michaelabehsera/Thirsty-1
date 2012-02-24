<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

<?php $option =  get_option('amp_options'); ?>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	
	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
    <?php wp_enqueue_style('othercss',get_bloginfo('template_directory').'/other.css'); ?>
    <?php wp_enqueue_style('fancybox',get_bloginfo('template_directory').'/skins/fancybox.css'); ?>
  <!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/ie.css" />
    <![endif]--> 
    <?php wp_enqueue_script('jquery'); ?>
    <?php wp_enqueue_script('amphion',get_bloginfo('template_directory').'/js/amphion.js', 'jQuery'); ?>
    <?php wp_enqueue_script('other',get_bloginfo('template_directory').'/js/other.js', 'jQuery', 'jQuery'); ?>
	<?php wp_enqueue_script('easyslider',get_bloginfo('template_directory').'/js/easyslider.js', 'jQuery'); ?>

<?php if($option['amp_style']== "Water") { ?>
    <?php wp_enqueue_style('water',get_bloginfo('template_directory').'/skins/water.css'); ?>
<?php }?>
<?php if($option['amp_style']== "No Style") { ?>
	<?php wp_enqueue_style('no-style',get_bloginfo('template_directory').'/skins/nostyle.css'); ?>
<?php }?>
<!--SWITCH FONTS-->
<?php if($option['amp_fonts']== "Lobster") { ?>
    <?php wp_enqueue_style('lobster',get_bloginfo('template_directory').'/fonts/lobster.css'); ?>
<?php }?>
<?php if ($option['amp_fonts'] == "Arial") { ?>
<?php wp_enqueue_style('arial',get_bloginfo('template_directory').'/fonts/arial.css'); ?>
<?php } ?>
    
    <?php wp_get_archives('type=monthly&format=link'); ?>
	<?php //comments_popup_script(); // off by default ?>
    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
    
<?php if($option["amp_fix_blocks"] == "1"){ ?>
<?php } else { ?>    
<script type="text/javascript">  
/* <![CDATA[ */  
    	//Default Blocks BUG FIX
	jQuery('.block_frst .block_odd .block_top:eq(1), .block_frst .block_odd .block_mid:eq(1), .block_frst .block_odd .block_bottom:eq(1) ').css({"display":"none"});
	jQuery('.block_frst .block_even .block_top:eq(1), .block_frst .block_even .block_mid:eq(1), .block_frst .block_even .block_bottom:eq(1) ').css({"display":"none"});
	jQuery('.blocks_sec .sec_block_odd .block_top:eq(1), .blocks_sec .sec_block_odd .block_mid:eq(1), .blocks_sec .sec_block_odd .block_bottom:eq(1) ').css({"display":"none"});	
	jQuery('.blocks_sec .sec_block_even .block_top:eq(1), .blocks_sec .sec_block_even .block_mid:eq(1), .blocks_sec .sec_block_even .block_bottom:eq(1) ').css({"display":"none"});  
/* ]]> */	
</script> 
 <?php } ?>  
 
  

</head>
<body <?php body_class(); ?>>
    <!--[if lte IE 6]><script src="<?php bloginfo('template_directory'); ?>/ie6/warning.js"></script><script>window.onload=function(){e("<?php bloginfo('template_directory'); ?>/ie6/")}</script><![endif]-->

<!--Social-->

<?php if($option["amp_hide_social"] == "1"){ ?>
<?php } else { ?>
<div class="social">
    <ul>
    <?php if($option["amp_hide_tw"] == "1"){ ?>
    <?php } else { ?>
    <li class="tw"><a title="Twitter" class="ang_tw" href="<?php echo $option['amp_tw_url'] ?>">Twitter</a></li>
    <?php } ?>
    <?php if($option["amp_hide_fb"] == "1"){ ?>
    <?php } else { ?>    
    <li class="fb_fix"><a title="Facebook" class="ang_fb" href="<?php echo $option['amp_fb_url'] ?>">Facebook</a></li>
    <?php } ?>
    <?php if($option["amp_hide_ms"] == "1"){ ?>
    <?php } else { ?> 
    <li class="ms"><a title="Myspace" class="ang_ms" href="<?php echo $option['amp_ms_url'] ?>">Myspace</a></li>
    <?php } ?>
    <?php if($option["amp_hide_rss"] == "1"){ ?>
    <?php } else { ?>     
    <li class="rss"><a title="Rss Feed" class="ang_rss" href="<?php echo $option['amp_rss_url'] ?>">RSS</a></li>
    <?php } ?>
    </ul>
<div class="social_bottom"></div>
</div>
<?php } ?>

<div id="wrapper">
<!--Header-->
<div id="header">
<div id="logo">
<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
<?php if($option["amp_description"] == "1"){ ?><div class="desc"><?php bloginfo('description')?></div><?php } else { ?><?php } ?></div>
</div>

<!--MENU-->
<div id="topmenu"><?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?></div>

