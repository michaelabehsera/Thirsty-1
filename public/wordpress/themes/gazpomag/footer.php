<?php include( TEMPLATEPATH . '/includes/get_options.php' ); ?>
</div><!-- /wrapper -->
<div id="footer">
<div class="wrap">
	<div class="main">
		<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer') ) ?>
	</div>
	
	<div class="info">
		Copyright &copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?>.
		Powered by <a href="http://www.wordpress.com/" rel="nofollow">Wordpress</a>, Theme by <a href="http://gazpo.com" target="_blank">gazpo.com</a>.
	</div>
	</div>
	</div>

<?php wp_footer(); ?>

<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>

<? if($gazpo_twitter_username){ ?>
<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $gazpo_twitter_username; ?>.json?callback=twitterCallback2&amp;count=1"></script>
<? } ?>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e63289077e5ae0b"></script>

<?php if ($gazpo_tracking_code) { echo stripslashes($gazpo_tracking_code); } ?>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/gazpo_socialbar.js"></script>

</body>
</html>