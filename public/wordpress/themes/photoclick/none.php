  <section class="section">
    <div class="post-text"><h2 class="post-title"><?php _e('Not Found'); ?></h2></div>
    <p><?php _e('You have come to a page that is either not existing or already been removed.'); ?></p>
    <?php get_search_form();?>
    <div class="left">
      <h3><?php _e('Archives by month:'); ?></h3>
      <ul>
        <?php wp_get_archives('type=monthly'); ?>
      </ul>
    </div>
    <div class="right">
      <h3><?php _e('Archives by category:'); ?></h3>
      <ul>
        <?php wp_list_cats('sort_column=name'); ?>
      </ul>
    </div>
    <div class="clearfix">&nbsp;</div>
  </section><!-- END Section -->