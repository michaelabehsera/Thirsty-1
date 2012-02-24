<div class="right">

	
<!-- Twitter widget -->	
<div class="featbox">
<h3 class="sidetitl">Twitter updates</h3>
<?php
$twit = get_option('shut_twitter');
include('twitter.php');?>
<?php if(function_exists('twitter_messages')) : ?>
       <?php twitter_messages("$twit") ?>
       <?php endif; ?>
</div> 	

<!-- 125px banners -->	
<?php include (TEMPLATEPATH . '/sponsors.php'); ?>	

<!-- Sidebar widgets -->
<div class="sidebar">
<ul>
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar') ) : else : ?>
	<?php endif; ?>
</ul>
</div>

</div>