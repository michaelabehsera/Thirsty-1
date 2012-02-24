<?php
function shadows_settings_init(){
	register_setting( 'shadows_settings', 'shadows_theme_settings' );
}

//menu
function shadows_add_settings_page() {
add_theme_page( __( 'Theme Settings' ), __( 'Theme Settings' ), 'manage_options', 'shadows-settings', 'shadows_theme_settings_page');
}

add_action( 'admin_init', 'shadows_settings_init' );
add_action( 'admin_menu', 'shadows_add_settings_page' );

//options
$categories = get_categories('hide_empty=0&orderby=name');
$wp_cats = array();
foreach ($categories as $category_list ) {
$wp_cats[$category_list->cat_ID] = $category_list->cat_name;
}
array_unshift($wp_cats, "Choose a category"); 
function shadows_theme_settings_page() {

global $wp_cats, $color_schemes;
if ( ! isset( $_REQUEST['updated'] ) )
$_REQUEST['updated'] = false;
?>

<div class="wrap">
<div id="icon-options-general" class="icon32"></div><h2>Shadow Settings</h2>

<?php if ( false !== $_REQUEST['updated'] ) : ?>
<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
<?php endif; ?>
<form method="post" action="options.php">

<?php settings_fields( 'shadows_settings' ); ?>
<?php $options = get_option( 'shadows_theme_settings' ); ?>

<table class="form-table">  

<tr valign="top">
<th scope="row"><?php _e( 'Favicon' ); ?></th>
<td>
<input id="shadows_theme_settings[upload_favicon]" class="regular-text upload_field" type="text" size="36" name="shadows_theme_settings[upload_favicon]" value="<?php esc_attr_e( $options['upload_favicon'] ); ?>" />
<label class="description abouttxtdescription" for="shadows_theme_settings[upload_favicon]"><?php _e( 'Upload or type in the URL for the site favicon.' ); ?></label>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e( 'Logo' ); ?></th>
<td>
<input id="shadows_theme_settings[logo]" class="regular-text" type="text" size="36" name="shadows_theme_settings[logo]" value="<?php esc_attr_e( $options['logo'] ); ?>" />
<label class="description abouttxtdescription" for="shadows_theme_settings[logo]"><?php _e( 'Upload or type in the URL for the site favicon.' ); ?></label>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e( 'Disable Tweet and Facebook Buttons' ); ?></th>
<td>
<input id="shadows_theme_settings[disable_single_social]" name="shadows_theme_settings[disable_single_social]" type="checkbox" value="1" <?php checked( '1', $options['disable_single_social'] ); ?> />
<label class="description" for="shadows_theme_settings[disable_single_social]"><?php _e( 'Check this box if you would like to disable the tweet this and like this button on single posts' ); ?></label>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e( 'Disable Featured Images On Single Posts' ); ?></th>
<td>
<input id="shadows_theme_settings[disable_single_image]" name="shadows_theme_settings[disable_single_image]" type="checkbox" value="1" <?php checked( '1', $options['disable_single_image'] ); ?> />
<label class="description" for="shadows_theme_settings[disable_single_image]"><?php _e( 'Check this box if you would like to disable the thumbnail images on single posts' ); ?></label>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e( 'Disable Author Sections' ); ?></th>
<td>
<input id="shadows_theme_settings[disable_author]" name="shadows_theme_settings[disable_author]" type="checkbox" value="1" <?php checked( '1', $options['disable_author'] ); ?> />
<label class="description" for="shadows_theme_settings[disable_author]"><?php _e( 'Check this box if you would like to disable the author sections on single posts' ); ?></label>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e( 'Disable Related Posts' ); ?></th>
<td>
<input id="shadows_theme_settings[disable_related_posts]" name="shadows_theme_settings[disable_related_posts]" type="checkbox" value="1" <?php checked( '1', $options['disable_related_posts'] ); ?> />
<label class="description" for="shadows_theme_settings[disable_related_posts]"><?php _e( 'Check this box if you would like to disable the related posts section' ); ?></label>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e( 'Disable Extended Footer' ); ?></th>
<td>
<input id="shadows_theme_settings[disable_extended_footer]" name="shadows_theme_settings[disable_extended_footer]" type="checkbox" value="1" <?php checked( '1', $options['disable_extended_footer'] ); ?> />
<label class="description" for="shadows_theme_settings[disable_extended_footer]"><?php _e( 'Check this box if you would like to disable the extended footer section' ); ?></label>
</td>
</tr>
           
<tr valign="top">
<th scope="row"><?php _e( 'Analytics Code' ); ?></th>
<td>
<label class="description" for="shadows_theme_settings[analytics]"><?php _e( 'Enter your analytics tracking code' ); ?></label>
<br />
<textarea id="shadows_theme_settings[analytics]" class="regular-text" name="shadows_theme_settings[analytics]" rows="5" cols="36"><?php esc_attr_e( $options['analytics'] ); ?></textarea>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e( 'Header Ad Code' ); ?></th>
<td>
<label class="description abouttxtdescription" for="shadows_theme_settings[header_ad]"><?php _e( 'Insert your code for the header ad ~ 468px by 60 - insert full HTMl or adsense code, not just the image.' ); ?></label>
<br />
<textarea id="shadows_theme_settings[header_ad]" class="regular-text" name="shadows_theme_settings[header_ad]" rows="5" cols="36"><?php esc_attr_e( $options['header_ad'] ); ?></textarea>
</td>
</tr>

</table>
<p class="submit-changes">
<input type="submit" class="button-primary" value="<?php _e( 'Save Options' ); ?>" />
</p>
</form>
</div><!-- END wrap -->

<?php
}
//sanitize and validate
function shadows_options_validate( $input ) {
	global $select_options, $radio_options;
	if ( ! isset( $input['option1'] ) )
		$input['option1'] = null;
	$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );
	$input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );
	if ( ! isset( $input['radioinput'] ) )
		$input['radioinput'] = null;
	if ( ! array_key_exists( $input['radioinput'], $radio_options ) )
		$input['radioinput'] = null;
	$input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );

	return $input;
}
?>