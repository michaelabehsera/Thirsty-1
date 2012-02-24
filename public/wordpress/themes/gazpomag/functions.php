<?php
	
function s_socialbar_button($name) {
	switch($name) {
        case 'Google+':
		?>
        <li class="google">			
		    <div class="g-plusone" data-size="tall"></div>
		</li>
        <?php
		break;
        case 'Twitter':
		?>
		<li class="twitter">
			<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink();?>" data-text="<?php the_title(); ?>" data-count="vertical">Tweet</a>
		</li>
		<?php
		 break;
		case 'Stumble upon':
		?>
		<li class="su">
           <script type='text/javascript' src="http://www.stumbleupon.com/hostedbadge.php?s=5"></script>
		</li>
        <?php
		break; 
		case 'Digg':
		?>
		<li class="digg">
          <a class="DiggThisButton DiggMedium"></a>
		</li>		
		<?php
		break;
		case 'Linked In':
		?>
		<li>
          <script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
			<script type="IN/Share" data-counter="top"></script>
		</li>		
		<?php
		break;
		case 'AddThis':
		?>
		<li>
         <div class="addthis_toolbox addthis_default_style ">
			<a class="addthis_counter"></a>
		</div>
		</li>
		<?php
		break;
		case 'Facebook':
		?>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
		<div class="fb-like" data-send="false" data-layout="box_count" data-width="50" data-show-faces="false"></div>
		<?php
		break;
		case 'None':
		break;
    }
}

	
	

add_theme_support( 'post-thumbnails' );



if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Sidebar',
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'name' => 'Footer',
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
}
include ("includes/gazpo_pagination.php");
include("widgets/subscribers_count.php");
include("widgets/posts_tabs.php");
include("widgets/facebook.php");
include("widgets/twitter.php");
include("widgets/social_links.php");
include("widgets/ad125.php");
include("gazpo_admin/gazpo_options.php");
?>