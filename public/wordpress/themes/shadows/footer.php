<?php $options = get_option( 'shadows_theme_settings' );  ?>

</div>
<!-- END main -->
    
<div id="footer-wrap">
<div id="footer">
<?php if ($options['disable_extended_footer'] != true) { ?>
	
	<div id="footer-widgets">
    		
	<div class="footer-widget">
       	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('First Footer Area') ) : ?><?php endif; ?>
	</div>
    <!-- END footer-widget -->
    
    <div class="footer-widget">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Second Footer Area') ) : ?><?php endif; ?>
	</div>
    <!-- END footer-widget -->
        
	<div class="footer-widget">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Third Footer Area') ) : ?><?php endif; ?>
	</div>
    <!-- END footer-widget -->
        
	<div class="footer-widget">   
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Fourth Footer Area') ) : ?><?php endif; ?>
	</div>
    <!-- END footer-widget -->
    	
        <div class="clear"></div>
        </div>
		<!-- END footer-widgets -->
<?php } ?>
</div>
<!-- END footer-wrap -->
    
<div id="footer-bottom-wrap">
<div id="footer-bottom">
            
<div id="copyright">
&copy; <?php echo date('Y'); ?>  <?php bloginfo( 'name' ) ?> ~ Design by <a href="http://www.wpexplorer.com/" title="Premium WordPress Themes">Premium WordPress Themes</a>
</div>
<!-- END copyright -->
    	
<div class="clear"></div>
</div>
<!-- END footer-bottom -->

</div>
<!-- END footer-bottom-wrap -->

</div>
<!-- END footer -->

<!-- WP Footer -->
<?php wp_footer(); ?>
</body>
</html>