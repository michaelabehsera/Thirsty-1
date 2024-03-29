<?php 
/**
 * Define all global constant variables
 */
require_once 'dd-class.php';

// XXX: This is some crazy use of global constants... a bit nasty if you ask me...

define('DD_NAME','Digg Digg');
define('DD_VERSION','5.0.2');
define('DD_DISABLED', '<!-- Digg Digg Disabled -->');

define('DD_AUTHOR_SITE', '<!-- Social Buttons Generated by Digg Digg plugin v5.0.2,
    Author : Buffer, Inc
    Website : http://bufferapp.com/diggdigg -->');

define('DD_FORM_SAVE','digg_digg_save');
define('DD_FORM_CLEAR','digg_digg_clear');
define('DD_FORM_CLEAR_ALL','digg_digg_clear_all');
define('DD_FORM','digg_digg_form');
define('DD_EMPTY_VALUE','');
define('DD_ALL_VALUE','All');
define('DD_NONE_VALUE','None');
define('DD_FUNC_TYPE_RESET','reset');
define('DD_FUNC_TYPE_INITIAL','initial');
define('DD_DIGG_TITLE','Digg Digg Wordpress Plugin');
define('DD_DASH', '#');
define('DD_CHECK_BOX_ON','checked=on');
define('DD_CHECK_BOX_OFF','');
define('DD_DISPLAY_RADIO_CHECK_ON','checked');
define('DD_DISPLAY_RADIO_CHECK_OFF','');
define('DD_RADIO_BUTTON_ON','checked');
define('DD_RADIO_BUTTON_OFF','');
define('DD_DISPLAY_ON','on');
define('DD_DISPLAY_OFF','');
define('DD_SELECT_SELECTED','selected');
define('DD_SELECT_NONE','none');
define('DD_SELECT_LEFT_FLOAT','left_float');
define('DD_SELECT_RIGHT_FLOAT','right_float');
define('DD_SELECT_BEFORE_CONTENT','before_content');
define('DD_SELECT_AFTER_CONTENT','after_content');
define('DD_FORM_BUTTON_SAVE','Save Changes');

if (!defined("WP_CONTENT_URL")) define("WP_CONTENT_URL", get_option("siteurl") . "/wp-content");
if (!defined("WP_PLUGIN_URL"))  define("WP_PLUGIN_URL", WP_CONTENT_URL . "/plugins");
define('DD_PLUGIN_URL',WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)).'/');

//for delicious only
define('DD_PLUGIN_STYLE_DELICIOUS', 'dd_delicious_normal_image');
define('DD_PLUGIN_STYLE_DELICIOUS_COMPACT', 'dd_delicious_compact_image');

define('DD_NORMAL_DISPLAY_CONFIG','dd_normal_display_config');
define('DD_FLOAT_DISPLAY_CONFIG','dd_float_display_config');
define('DD_DEFAULT_TEXT','Text Not Found!');

define('DD_LINE_UP_OPTION','dd_line_up');
define('DD_LINE_UP_OPTION_SELECT','dd_line_up_select');
define('DD_LINE_UP_OPTION_SELECT_HORIZONTAL','Horizontal');
define('DD_LINE_UP_OPTION_SELECT_VERTICAL','Vertical');
define('DD_LINE_UP_OPTION_LABEL_HORIZONTAL','Horizontal');
define('DD_LINE_UP_OPTION_LABEL_VERTICAL','Vertical');

define('DD_DISPLAY_OPTION','display_option');
define('DD_DISPLAY_OPTION_HOME','display_option_home');
define('DD_DISPLAY_OPTION_POST','display_option_post');
define('DD_DISPLAY_OPTION_PAGE','display_option_page');
define('DD_DISPLAY_OPTION_CAT','display_option_cat');
define('DD_DISPLAY_OPTION_TAG','display_option_tag');
define('DD_DISPLAY_OPTION_ARCHIVE','display_option_archive');

define('DD_DISPLAY_OPTION_LABEL_HOME','Home');
define('DD_DISPLAY_OPTION_LABEL_POST','Post');
define('DD_DISPLAY_OPTION_LABEL_PAGE','Page');
define('DD_DISPLAY_OPTION_LABEL_CAT','Category');
define('DD_DISPLAY_OPTION_LABEL_TAG','Tag');
define('DD_DISPLAY_OPTION_LABEL_ARCHIVE','Archive');

define('DD_CATEORY_OPTION','category_option');
define('DD_CATEORY_OPTION_RADIO','category_option_radio');
define('DD_CATEORY_OPTION_RADIO_INCLUDE','category_option_radio_include');
define('DD_CATEORY_OPTION_RADIO_EXCLUDE','category_option_radio_exclude');
define('DD_CATEORY_OPTION_TEXT_INCLUDE','category_option_include');
define('DD_CATEORY_OPTION_TEXT_EXCLUDE','category_option_exclude');

define('DD_STATUS_OPTION','dd_status_option');
define('DD_STATUS_OPTION_DISPLAY','dd_status_option_display');

define('DD_EXCERP_OPTION','dd_excerp_option');
define('DD_EXCERP_OPTION_DISPLAY','dd_excerp_option_display');

define('DD_NORMAL_BUTTON','dd_normal_button');
define('DD_NORMAL_BUTTON_DISPLAY','dd_normal_button_display');
define('DD_NORMAL_BUTTON_FINAL','dd_normal_button_final'); //store what display only, increase performance  

define('DD_FLOAT_BUTTON','dd_float_button');
define('DD_FLOAT_BUTTON_DISPLAY','dd_float_button_display');
define('DD_FLOAT_BUTTON_FINAL','dd_float_button_final'); //store what display only, increase performance  

// XXX: NEW BUTTONS: Define a new constant here
define('DD_BUTTON_DIGG','dd_button_digg');
define('DD_BUTTON_LINKEDIN','dd_button_linkedin');
define('DD_BUTTON_REDDIT','dd_button_reddit');
define('DD_BUTTON_GBUZZ','dd_button_gbuzz');
define('DD_BUTTON_DZONE','dd_button_dzone');
define('DD_BUTTON_FBSHARE','dd_button_fbshare');
define('DD_BUTTON_DELICIOUS','dd_button_delicious');
define('DD_BUTTON_FBLIKE','dd_button_fblike');
define('DD_BUTTON_STUMBLEUPON','dd_button_stumbleupon');
define('DD_BUTTON_YBUZZ','dd_button_yahoobuzz');
define('DD_BUTTON_FBSHAREME','dd_button_fbshareme');
define('DD_BUTTON_BLOGENAGAGE','dd_button_blogenagage');
define('DD_BUTTON_THEWEBBLEND','dd_button_thewebblend');
define('DD_BUTTON_DESIGNBUMP','dd_button_designbump');
define('DD_BUTTON_TWITTER','dd_button_twitter');
define('DD_BUTTON_TWEETMEME','dd_button_tweetmeme');
define('DD_BUTTON_TOPSY','dd_button_topsy');
define('DD_BUTTON_COMMENTS','dd_button_comments');
define('DD_BUTTON_SERPD','dd_button_serpd');
define('DD_BUTTON_FBLIKE_XFBML','dd_button_fblike_xfbml');
define('DD_BUTTON_GOOGLE1','dd_button_google1');
define('DD_BUTTON_BUFFER','dd_button_buffer');
define('DD_BUTTON_PINTEREST','dd_button_pinterest');
define('DD_BUTTON_FLATTR','dd_button_flattr');

/****************************************
 * Digg Digg Global Display (Start)
 *******/
define('DD_GLOBAL_CONFIG','dd_global_config');
define('DD_GLOBAL_TWITTER_OPTION','dd_global_twitter_option');
define('DD_GLOBAL_TWITTER_OPTION_SOURCE','dd_global_twitter_option_source');

define('DD_GLOBAL_TWEETMEME_OPTION','dd_global_tweetmeme_option');
define('DD_GLOBAL_TWEETMEME_OPTION_SOURCE','dd_global_tweetmeme_option_source');
define('DD_GLOBAL_TWEETMEME_OPTION_SERVICE','dd_global_tweetmeme_option_service');
define('DD_GLOBAL_TWEETMEME_OPTION_SERVICE_API','dd_global_tweetmeme_option_service_api');

define('DD_GLOBAL_TOPSY_OPTION','dd_global_topsy_option');
define('DD_GLOBAL_TOPSY_OPTION_SOURCE','dd_global_topsy_option_source');
define('DD_GLOBAL_TOPSY_OPTION_THEME','dd_global_topsy_option_theme');
define('DD_GLOBAL_TOPSY_OPTION_THEME_DEFAULT','blue');

define('DD_GLOBAL_FACEBOOK_OPTION','dd_global_facebook_option');
define('DD_GLOBAL_FACEBOOK_OPTION_LOCALE','dd_global_facebook_option_locale');
define('DD_GLOBAL_FACEBOOK_OPTION_SEND','dd_global_facebook_option_send');
define('DD_GLOBAL_FACEBOOK_OPTION_FACE','dd_global_facebook_option_face');
define('DD_GLOBAL_FACEBOOK_OPTION_THUMB','dd_global_facebook_option_thumb');
define('DD_GLOBAL_FACEBOOK_OPTION_DEFAULT_THUMB','dd_global_facebook_option_default_thumb');

global $ddGlobalConfig; 
$ddGlobalConfig = array(
	DD_GLOBAL_TWITTER_OPTION => array(
		DD_GLOBAL_TWITTER_OPTION_SOURCE => DD_EMPTY_VALUE
	),
	DD_GLOBAL_TWEETMEME_OPTION => array(
		DD_GLOBAL_TWEETMEME_OPTION_SOURCE =>DD_EMPTY_VALUE,
		DD_GLOBAL_TWEETMEME_OPTION_SERVICE => DD_EMPTY_VALUE,
		DD_GLOBAL_TWEETMEME_OPTION_SERVICE_API =>DD_EMPTY_VALUE
	),
	DD_GLOBAL_TOPSY_OPTION => array(
		DD_GLOBAL_TOPSY_OPTION_SOURCE =>DD_EMPTY_VALUE,
		DD_GLOBAL_TOPSY_OPTION_THEME =>DD_GLOBAL_TOPSY_OPTION_THEME_DEFAULT
	),
	DD_GLOBAL_FACEBOOK_OPTION => array(
		DD_GLOBAL_FACEBOOK_OPTION_LOCALE => "en_US",
		DD_GLOBAL_FACEBOOK_OPTION_SEND => DD_CHECK_BOX_OFF,
		DD_GLOBAL_FACEBOOK_OPTION_FACE => DD_CHECK_BOX_OFF,
		DD_GLOBAL_FACEBOOK_OPTION_THUMB => DD_CHECK_BOX_ON,
		DD_GLOBAL_FACEBOOK_OPTION_DEFAULT_THUMB => DD_EMPTY_VALUE
	)
);
/*******
 * Digg Digg Global Display (End)
 ****************************************/

/****************************************
 * Digg Digg Normal Display (Start)
 *******/
global $ddNormalDisplay;
$ddNormalDisplay = array(
	DD_DISPLAY_OPTION => array(
		DD_DISPLAY_OPTION_HOME => DD_DISPLAY_OFF,
		DD_DISPLAY_OPTION_POST => DD_DISPLAY_ON,
		DD_DISPLAY_OPTION_PAGE => DD_DISPLAY_OFF,
		DD_DISPLAY_OPTION_CAT => DD_DISPLAY_OFF,
		DD_DISPLAY_OPTION_TAG => DD_DISPLAY_OFF,
		DD_DISPLAY_OPTION_ARCHIVE =>DD_DISPLAY_OFF
	),
	DD_CATEORY_OPTION => array(
		DD_CATEORY_OPTION_RADIO =>DD_CATEORY_OPTION_RADIO_INCLUDE,
		DD_CATEORY_OPTION_TEXT_INCLUDE => DD_ALL_VALUE,
		DD_CATEORY_OPTION_TEXT_EXCLUDE => DD_NONE_VALUE
	),
	DD_LINE_UP_OPTION => array(
		DD_LINE_UP_OPTION_SELECT =>DD_LINE_UP_OPTION_SELECT_HORIZONTAL
	),
	DD_STATUS_OPTION => array(
		DD_STATUS_OPTION_DISPLAY =>DD_DISPLAY_OFF
	),
	DD_EXCERP_OPTION => array(
		DD_EXCERP_OPTION_DISPLAY =>DD_DISPLAY_ON
	)
);

global $ddNormalButtons;
$ddNormalButtons = array(
	DD_NORMAL_BUTTON_DISPLAY => array(
		DD_BUTTON_DIGG => new DD_Digg(),
		DD_BUTTON_REDDIT => new DD_Reddit(),
		DD_BUTTON_GBUZZ => new DD_GBuzz(),
		DD_BUTTON_DZONE => new DD_DZone(),
		DD_BUTTON_FBSHARE => new DD_FbShare(),
		DD_BUTTON_DELICIOUS => new DD_Delicious(),
		DD_BUTTON_FBLIKE => new DD_FbLike(),
		DD_BUTTON_STUMBLEUPON => new DD_StumbleUpon(),
		DD_BUTTON_YBUZZ => new DD_YBuzz(),
		DD_BUTTON_FBSHAREME => new DD_FbShareMe(),
		DD_BUTTON_BLOGENAGAGE => new DD_BlogEngage(),
		DD_BUTTON_THEWEBBLEND => new DD_TheWebBlend(),
		DD_BUTTON_DESIGNBUMP => new DD_DesignBump(),
		DD_BUTTON_TWITTER => new DD_Twitter(),
		DD_BUTTON_TWEETMEME => new DD_TweetMeme(),
		DD_BUTTON_TOPSY => new DD_Topsy(),
		DD_BUTTON_COMMENTS => new DD_Comments(),
		DD_BUTTON_LINKEDIN => new DD_Linkedin(),
		DD_BUTTON_SERPD => new DD_Serpd(),
		DD_BUTTON_FBLIKE_XFBML => new DD_FbLike_XFBML(),
		DD_BUTTON_GOOGLE1 => new DD_Google1(),
		DD_BUTTON_BUFFER => new DD_Buffer(),
		DD_BUTTON_PINTEREST => new DD_Pinterest(),
		DD_BUTTON_FLATTR => new DD_Flattr()
	),
	DD_NORMAL_BUTTON_FINAL => array()
);

/*******
 * Digg Digg Normal Display (End)
 ****************************************/

/****************************************
 * Digg Digg Floating Display (Start)
 *******/
define('FLOAT_BUTTON_CREDIT_LINK', '<div id=\'dd_name\'><a href=\'http://bufferapp.com/diggdigg\' target=\'_blank\'>Digg Digg</a></div>');

define('DD_FLOAT_OPTION', 'dd_float_option');
define('DD_FLOAT_OPTION_CREDIT','dd_float_option_credit');
define('DD_FLOAT_OPTION_CREDIT_VALUE','');

define('DD_FLOAT_OPTION_INITIAL_POSITION','dd_float_option_initial_position');
define('DD_FLOAT_OPTION_INITIAL_POSITION_VALUE','#dd_ajax_float{
	background:none repeat scroll 0 0 #FFFFFF;
	border:1px solid #BBBBBB;
	float:left;
	margin-left:-120px;
	margin-right:10px;
	margin-top:10px;
	position:absolute;
	z-index:9999;
}');

define('DD_FLOAT_OPTION_SCROLLING_POSITION','dd_float_option_scrolling_position');
define('DD_FLOAT_OPTION_SCROLLING_POSITION_VALUE','jQuery(document).ready(function($){

	var $postShare = $(\'#dd_ajax_float\');
	
	if($(\'.dd_content_wrap\').length > 0){
	
		var descripY = parseInt($(\'.dd_content_wrap\').offset().top) - 20;
		var pullX = $postShare.css(\'margin-left\');
	
		$(window).scroll(function () { 
		  
			var scrollY = $(window).scrollTop();
			var fixedShare = $postShare.css(\'position\') == \'fixed\';
			
			if($(\'#dd_ajax_float\').length > 0){
			
				if ( scrollY > descripY && !fixedShare ) {
					$postShare.stop().css({
						position: \'fixed\',
						top: 16
					});
				} else if ( scrollY < descripY && fixedShare ) {
					$postShare.css({
						position: \'absolute\',
						top: descripY,
						marginLeft: pullX
					});
				}
				
			}
	
		});
	}
});');

define('DD_EXTRA_OPTION_EMAIL', 'dd_extra_option_email');
define('DD_EXTRA_OPTION_EMAIL_STATUS','dd_extra_option_email_status');
define('DD_EXTRA_OPTION_EMAIL_SHARETHIS_PUB_ID','dd_extra_option_email_sharethis');

define('DD_EXTRA_OPTION_PRINT', 'dd_extra_option_print');
define('DD_EXTRA_OPTION_PRINT_STATUS','dd_extra_option_print_status');
define('DD_EXTRA_OPTION', 'dd_extra_option');
define('DD_EXTRA_OPTION_SCREEN_WIDTH', 'dd_extra_option_screen_width');
define('DD_EXTRA_OPTION_SCREEN_WIDTH_DEFAULT_HIDE', '790');

global $ddFloatDisplay;
$ddFloatDisplay = array(
	DD_DISPLAY_OPTION => array(
		DD_DISPLAY_OPTION_HOME => DD_DISPLAY_OFF,
		DD_DISPLAY_OPTION_POST => DD_DISPLAY_ON,
		DD_DISPLAY_OPTION_PAGE => DD_DISPLAY_OFF,
		DD_DISPLAY_OPTION_CAT => DD_DISPLAY_OFF,
		DD_DISPLAY_OPTION_TAG => DD_DISPLAY_OFF,
		DD_DISPLAY_OPTION_ARCHIVE =>DD_DISPLAY_OFF
	),
	DD_CATEORY_OPTION => array(
		DD_CATEORY_OPTION_RADIO =>DD_CATEORY_OPTION_RADIO_INCLUDE,
		DD_CATEORY_OPTION_TEXT_INCLUDE => DD_ALL_VALUE,
		DD_CATEORY_OPTION_TEXT_EXCLUDE => DD_NONE_VALUE
	),
	DD_STATUS_OPTION => array(
		DD_STATUS_OPTION_DISPLAY =>DD_DISPLAY_ON
	),
	DD_FLOAT_OPTION => array(
		DD_FLOAT_OPTION_CREDIT => DD_FLOAT_OPTION_CREDIT_VALUE,
		DD_FLOAT_OPTION_INITIAL_POSITION => DD_FLOAT_OPTION_INITIAL_POSITION_VALUE,
		DD_FLOAT_OPTION_SCROLLING_POSITION => DD_FLOAT_OPTION_SCROLLING_POSITION_VALUE
	),
	DD_EXTRA_OPTION_EMAIL => array(
		DD_EXTRA_OPTION_EMAIL_STATUS => DD_DISPLAY_OFF,
		DD_EXTRA_OPTION_EMAIL_SHARETHIS_PUB_ID => DD_EMPTY_VALUE
	),
	DD_EXTRA_OPTION_PRINT => array(
		DD_EXTRA_OPTION_PRINT_STATUS => DD_DISPLAY_OFF
	),
	DD_EXTRA_OPTION => array(
		DD_EXTRA_OPTION_SCREEN_WIDTH => DD_EXTRA_OPTION_SCREEN_WIDTH_DEFAULT_HIDE
	)
);

global $ddFloatButtons;
$ddFloatButtons = array(
	DD_FLOAT_BUTTON_DISPLAY => array(
		DD_BUTTON_DIGG => new DD_Digg(),
		DD_BUTTON_REDDIT => new DD_Reddit(),
		DD_BUTTON_GBUZZ => new DD_GBuzz(),
		DD_BUTTON_DZONE => new DD_DZone(),
		DD_BUTTON_FBSHARE => new DD_FbShare(),
		DD_BUTTON_DELICIOUS => new DD_Delicious(),
		DD_BUTTON_FBLIKE => new DD_FbLike(),
		DD_BUTTON_STUMBLEUPON => new DD_StumbleUpon(),
		DD_BUTTON_YBUZZ => new DD_YBuzz(),
		DD_BUTTON_FBSHAREME => new DD_FbShareMe(),
		DD_BUTTON_BLOGENAGAGE => new DD_BlogEngage(),
		DD_BUTTON_THEWEBBLEND => new DD_TheWebBlend(),
		DD_BUTTON_DESIGNBUMP => new DD_DesignBump(),
		DD_BUTTON_TWITTER => new DD_Twitter(),
		DD_BUTTON_TWEETMEME => new DD_TweetMeme(),
		DD_BUTTON_TOPSY => new DD_Topsy(),
		DD_BUTTON_COMMENTS => new DD_Comments(),
		DD_BUTTON_LINKEDIN => new DD_Linkedin(),
		DD_BUTTON_SERPD => new DD_Serpd(),
		DD_BUTTON_FBLIKE_XFBML => new DD_FbLike_XFBML(),
		DD_BUTTON_GOOGLE1 => new DD_Google1(),
		DD_BUTTON_BUFFER => new DD_Buffer(),
		DD_BUTTON_PINTEREST => new DD_Pinterest(),
		DD_BUTTON_FLATTR => new DD_Flattr()		
	),
	DD_FLOAT_BUTTON_FINAL => array()
);

/*******
 * Digg Digg Floating Display (End)
 ****************************************/
?>