<div id="slider"><?php
$option =  get_option('amp_options');
?>
                    <ul>
                    <?php $sliders = new WP_Query(); 
					$ampid = get_cat_ID(  $option['amp_cat']  );
                    $sliders->query('cat= '. $ampid .'&showposts='. $option['amp_num'] .'');
                    while ($sliders->have_posts()) : $sliders->the_post(); ?>
                    <li>
                    <div class="content"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><p><?php amphion_lite_get_custom_field_value('summary', true); ?></p></div>
                    <?php if ( has_post_thumbnail() ) {?>

                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>

                    <?php } else { ?>
					<div class="slider_frm"></div>
                   <?php } ?>
                     
                    </li>
                    <?php endwhile; ?><?php wp_reset_query(); ?>
                </ul>
                    </div>