<!DOCTYPE html>
<!--[if IE 6]><html id="ie6" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html id="ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html id="ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<!--
      _            _     __      _____ 
  ___(_)_ __  _ __| |_  _\ \    / / _ \
 (_-<| | '  \| '_ \ | || |\ \/\/ /|  _/
 /__/|_|_|_|_| .__/_|\_, | \_/\_/ |_|  
             |_|     |__/
-->
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title(''); ?><?php if(wp_title(' ', false)) { echo ' &ndash; '; } ?> <?php bloginfo('name'); ?> &ndash; <?php bloginfo('description'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.gif"/>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" media="screen" href="<?php bloginfo('template_url'); ?>/styles/common.css" />
<link rel="stylesheet" media="screen" href="<?php bloginfo('template_url'); ?>/js/uniform.css" />
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Dancing+Script:700|Raleway:100" type="text/css" />
<?php if (is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); wp_head(); ?>
<?php wp_enqueue_script("jquery"); ?>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/uniform/uniform.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqueryslidemenu.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/corner.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/tooltip.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/swfobject.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/scripts.js"></script>
<!--[if lt IE 7]><script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script><![endif]-->
<!--[if lt IE 8]><script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script><![endif]-->
<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>

<header class="header">
<div class="header-inner">

  <form method="get" class="header-form" action="<?php bloginfo('siteurl'); ?>">
    <fieldset>
      <input type="text" name="s" class="header-text uniform" size="15" title="<?php _e('Search'); ?>" />
      <input type="submit" class="uniform" value="<?php _e('Go'); ?>" />
    </fieldset>
  </form>

  <img src="<?php bloginfo('template_url'); ?>/images/logo.png" title="<?php bloginfo('name'); ?>" alt="<?php bloginfo('name'); ?>" class="header-logo" />

  <h1><a href="<?php echo get_option('home'); ?>" class="header-title"><?php bloginfo('name'); ?></a></h1>

  <nav class="nav">
    <?php if (function_exists('wp_nav_menu') ) { wp_nav_menu('theme_location=top_menu&container_class=menu&show_home=1'); } else {?>
    <ul>
      <?php wp_list_pages('title_li='); ?>
    </ul>
    <?php } ?>
  </nav>

</div>
</header>

<div class="container">