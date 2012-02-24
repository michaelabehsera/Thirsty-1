<?php $options = get_option( 'shadows_theme_settings' ); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
    
<!-- Stylesheet & Favicon -->
<link rel="icon" type="image/png" href="<?php echo $options['upload_favicon']; ?>" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />

<!-- WP Head -->
<?php if ( is_single() || is_page() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

<!-- SuperFish -->
<script type="text/javascript">
jQuery(function($){
    $(document).ready(function() { 
	//superfish menu
        $('ul.sf-menu').superfish({ 
            delay: 50,
            animation: {opacity:'show',height:'show'},
			speed: 'normal',
            autoArrows:  true,
            dropShadows: false
});
	//Image opacity hover-over
	var opacity = 1, toOpacity = 0.7, duration = 300;
		$('.opacity').css('opacity',opacity).hover(
		function() {
		$(this).fadeTo(duration,toOpacity);},
		function() {
		$(this).fadeTo(duration,opacity);}
	);
	});
});
</script>


<?php 
// Get And Show Analytics Code 
echo stripslashes($options['analytics']); 
?>

</head>

<body <?php body_class($class); ?>>

<div id="header-wrap">
	<div id="header">
    
    	<div id="logo">
           <?php if($options['logo'] !='') { ?>
            <a href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><img src="<?php echo $options['logo']; ?>" alt="<?php bloginfo( 'name' ) ?>" /></a>
            <?php } else { ?>
        	<?php if (is_front_page()) { ?>
            <h1><a href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a></h1>
            <?php } else { ?>
        	<h2><a href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a></h2>
            <?php } ?>  
            <p><?php bloginfo( 'description' ) ?></p>
            <?php } ?>
        </div>
        <!-- END logo -->
        
        <?php if($options['header_ad'] != '') { ?>
        <div id="header-ad">
            <?php echo stripslashes($options['header_ad']); ?>
       </div><!-- END header-ad -->
       <?php } ?>

<div class="clear"></div>
        
    </div><!-- END header -->
    
    <div id="navigation-wrap">
    	<div id="navigation" class="clearfix">
			<?php wp_nav_menu( array(
			'theme_location' => 'primary',
			'sort_column' => 'menu_order',
			'menu_class' => 'sf-menu',
            'fallback_cb' => 'default_menu'
			)); ?>
      	</div>
        <!-- END navigation -->
    </div>
    <!-- END navigation-wrap -->
</div>
<!-- END header-wrap -->
    <div id="main">