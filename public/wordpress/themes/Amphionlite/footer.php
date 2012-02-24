<?php
$option =  get_option('amp_options');
?>
<div id="footer">
    <div id="footer_wrap">
    	<div class="footage"><ul>          
    	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?> 
    	<?php endif; ?></ul>
        </div>
        <div id="copyright"><div class="copy_content">
        <a href="<?php bloginfo('url');?>"><?php bloginfo('title');?></a> Powered by Wordpress. <?php _e('Theme by', 'amphion_lite'); ?> <a href="http://www.towfiqi.com/">Towfiq I</a>
        <div id="footmenu"><?php wp_nav_menu( array( 'container_class' => 'menu-footer', 'theme_location' => 'foot_menu' ) ); ?></div>

        </div>
        </div>
    </div>
</div>
<?php wp_footer(); ?>
</body>
</html>