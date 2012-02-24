<div class="clearfix">&nbsp;</div>
</div><!-- END Container -->

<footer class="footer">
  <div class="footer-inner-top"></div>
  <div class="footer-inner">
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : endif; ?>
  <div class="clearfix">&nbsp;</div>
  </div><!-- END Footer Inner -->
  <div class="clearfix">&nbsp;</div>
  <div class="footer-inner-bottom"></div>
</footer><!-- END Footer -->

<p class="footer-copy">
  &copy; <?php _e('Copyrighted'); ?> <a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a>. <?php _e('PhotoClick theme by'); ?> <a href="http://www.simplywp.net"><img src="<?php bloginfo('template_url'); ?>/images/simplywp_logo.png" alt="Photoclick Theme by simplyWP" /></a>. Powered by <a href="http://www.wordpress.org"><img src="<?php bloginfo('template_url'); ?>/images/wordpress_logo.png" alt="Powered by WordPress" /></a>
</p>

<?php wp_footer(); ?>
</body>
</html>