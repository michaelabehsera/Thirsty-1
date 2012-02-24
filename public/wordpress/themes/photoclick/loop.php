  <section class="section">
    <div class="post-text">
      <div class="post-date"><?php the_time(__('jS M')) ?><br /><?php the_time(__('Y')) ?></div>
      <h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
      <div class="post-category">Filed in <?php the_category(', ') ?></div>
      <div class="post-comment"><?php comments_popup_link(__('0'), __('1'), __('%')); ?></div>
      <div class="clearfix">&nbsp;</div>
    </div>
    
    <?php the_content(); ?>
    
    <footer class="post-footer">
      <ul class="post-info-meta">
        <li>SHARE THIS POST</li>
        <li><a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink() ?>" data-count="none" data-via="<?php if (get_option("zhng_twitter")) { echo get_option("zhng_twitter"); } else { echo "simplywp"; } ?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></li>
        <li><iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;layout=button_count&amp;show_faces=true&amp;width=50&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:50px; height:20px;" allowTransparency="true"></iframe></li>
        <li><script src="http://www.stumbleupon.com/hostedbadge.php?s=1&r=<?php the_permalink(); ?>"></script></li>
        <li><a class="DiggThisButton DiggMedium" href="<?php the_permalink(); ?>"><img src="http://about.digg.com/files/badge/icons/100x20-digg-button.gif?1259101410" width="100" height="20" alt="Digg!" /></a></li>
        <li></li>
      </ul>
    </footer><!-- END POST FOOTER -->
    
  </section><!-- END Section -->