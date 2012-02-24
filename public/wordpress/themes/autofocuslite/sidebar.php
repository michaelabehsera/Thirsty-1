<?php
/**
 * The Sidebar containing the Singlular Sidebar widget areas.
 */
?>

<?php if ( is_active_sidebar( 'singlular-widget-area' ) ) : ?>
	
		<aside id="singlular-sidebar" class="widget-area" role="complementary">
			<ul class="xoxo">

<?php

	if ( ! dynamic_sidebar( 'singlular-widget-area' ) ) : ?>

		<?php dynamic_sidebar( 'singlular-widget-area' ); ?>

<?php endif; // end Singlular Widget Area ?>

			</ul>
		</aside><!-- #singlular-sidebar .widget-area -->

<?php endif; // end singlular sidebar check ?>
