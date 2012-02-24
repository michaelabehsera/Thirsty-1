<?php 
/*-----------------------------------------------------------------------------------*/
/* Initializing Widgetized Areas (Sidebars)																			 */
/*-----------------------------------------------------------------------------------*/
 
/*----------------------------------*/
/* Sidebar							*/
/*----------------------------------*/
 
 register_sidebar(array(
'name'=>'Sidebar',
'id' => 'sidebar',
'before_widget' => '<div class="widget %1$s" id="%2$s">',
'after_widget' => '</div><div class="clear">&nbsp;</div></div>',
'before_title' => '<h3>',
'after_title' => '</h3><div class="w_content">',
));

/*----------------------------------*/
/* Footer widgetized areas		*/
/*----------------------------------*/

register_sidebar(array('name'=>'Footer (wide)',
'before_widget' => '<div class="widget %1$s" id="%2$s">',
'after_widget' => '</div>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));

register_sidebar(array('name'=>'Footer: Column 1',
'before_widget' => '<div class="widget %1$s" id="%2$s">',
'after_widget' => '</div>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));

register_sidebar(array('name'=>'Footer: Column 2',
'before_widget' => '<div class="widget %1$s" id="%2$s">',
'after_widget' => '</div>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));

?>