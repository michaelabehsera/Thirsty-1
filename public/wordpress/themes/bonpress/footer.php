<?php
 global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
}
?>
</div>
    </div>
	 <div id="footer">
		<div class="widgets">
			<div class="widecol">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer (wide)') ) : ?> <?php endif; ?>
			</div><!-- / .column -->
			<div class="clear"></div>
			
			<div class="column">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer: Column 1') ) : ?> <?php endif; ?>
			</div><!-- / .column -->
			
			<div class="column last">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer: Column 2') ) : ?> <?php endif; ?>
			</div><!-- / .column -->
			
			<div class="clear"></div>
 		</div>
 		
		<div class="copyright">
			<div class="left"><p class="copy"><?php _e('Copyright', 'wpzoom'); ?> &copy; <?php echo date("Y",time()); ?> <?php bloginfo('name'); ?>. <?php _e('All Rights Reserved', 'wpzoom'); ?>.</p></div>
			<div class="right"><p class="wpzoom"><a href="http://www.wpzoom.com" target="_blank" title="WordPress Themes"><img src="<?php bloginfo('template_directory'); ?>/images/wpzoom.png" alt="WPZOOM" /></a>  <?php _e('Designed by', 'wpzoom'); ?></p></div>
		</div>
 	</div>
     
 
<?php if ($wpzoom_misc_analytics != '' && $wpzoom_misc_analytics_select == 'Yes')
{
  echo stripslashes($wpzoom_misc_analytics);
} ?> 
 

<?php wp_footer(); ?>
</body>
</html>