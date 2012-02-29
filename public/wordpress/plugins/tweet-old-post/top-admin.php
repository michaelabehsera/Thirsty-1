<?php

require_once('tweet-old-post.php');
require_once('top-core.php');
require_once( 'Include/top-oauth.php' );
require_once('xml.php');
require_once( 'Include/top-debug.php' );
function top_admin() {
    //check permission
    if (current_user_can('manage_options')) 
        {
        $message = null;
        $message_updated = __("Tweet Old Post Options Updated.", 'TweetOldPost');
        $response = null;
        $save = true;
        $settings = top_get_settings();

        //on authorize
        if (isset($_GET['TOP_oauth'])) {
            global $top_oauth;

            $result = $top_oauth->get_access_token($settings['oauth_request_token'], $settings['oauth_request_token_secret'], $_GET['oauth_verifier']);

            if ($result) {
                $settings['oauth_access_token'] = $result['oauth_token'];
                $settings['oauth_access_token_secret'] = $result['oauth_token_secret'];
                $settings['user_id'] = $result['user_id'];

                $result = $top_oauth->get_user_info($result['user_id']);
                if ($result) {
                    $settings['profile_image_url'] = $result['user']['profile_image_url'];
                    $settings['screen_name'] = $result['user']['screen_name'];
                    if (isset($result['user']['location'])) {
                        $settings['location'] = $result['user']['location'];
                    } else {
                        $settings['location'] = false;
                    }
                }

                top_save_settings($settings);
                echo '<script language="javascript">window.open ("' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=TweetOldPost","_self")</script>';
                die;
            }
        }
        //on deauthorize
        else if (isset($_GET['top']) && $_GET['top'] == 'deauthorize') {
            $settings = top_get_settings();
            $settings['oauth_access_token'] = '';
            $settings['oauth_access_token_secret'] = '';
            $settings['user_id'] = '';
            $settings['tweet_queue'] = array();

            top_save_settings($settings);
            echo '<script language="javascript">window.open ("' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=TweetOldPost","_self")</script>';
            die;
        }
         else if (isset($_GET['top']) && $_GET['top'] == 'reset') {
              print('
			<div id="message" class="updated fade">
				<p>' . __("All settings have been reset. Kindly update the settings for Tweet Old Post to start tweeting again.", 'TweetOldPost') . '</p>
			</div>');
         }
        //check if username and key provided if bitly selected
        if (isset($_POST['top_opt_url_shortener'])) {
            if ($_POST['top_opt_url_shortener'] == "bit.ly") {

                //check bitly username
                if (!isset($_POST['top_opt_bitly_user'])) {
                    print('
			<div id="message" class="updated fade">
				<p>' . __('Please enter bit.ly username.', 'TweetOldPost') . '</p>
			</div>');
                    $save = false;
                }
                //check bitly key
                elseif (!isset($_POST['top_opt_bitly_key'])) {
                    print('
			<div id="message" class="updated fade">
				<p>' . __('Please enter bit.ly API Key.', 'TweetOldPost') . '</p>
			</div>');
                    $save = false;
                }
                //if both the good to save
                else {
                    $save = true;
                }
            }
        }

        //if submit and if bitly selected its fields are filled then save
        if (isset($_POST['submit']) && $save) {
            $message = $message_updated;

            //TOP admin URL (current url)
            if (isset($_POST['top_opt_admin_url'])) {
                update_option('top_opt_admin_url', $_POST['top_opt_admin_url']);
            }
            
            //what to tweet 
            if (isset($_POST['top_opt_tweet_type'])) {
                update_option('top_opt_tweet_type', $_POST['top_opt_tweet_type']);
            }

            //additional data
            if (isset($_POST['top_opt_add_text'])) {
                update_option('top_opt_add_text', $_POST['top_opt_add_text']);
            }

            //place of additional data
            if (isset($_POST['top_opt_add_text_at'])) {
                update_option('top_opt_add_text_at', $_POST['top_opt_add_text_at']);
            }

            //include link
            if (isset($_POST['top_opt_include_link'])) {
                update_option('top_opt_include_link', $_POST['top_opt_include_link']);
            }

            //fetch url from custom field?
            if (isset($_POST['top_opt_custom_url_option'])) {
                update_option('top_opt_custom_url_option', true);
            } else {

                update_option('top_opt_custom_url_option', false);
            }

            //custom field to fetch URL from 
            if (isset($_POST['top_opt_custom_url_field'])) {
                update_option('top_opt_custom_url_field', $_POST['top_opt_custom_url_field']);
            } else {

                update_option('top_opt_custom_url_field', '');
            }

            //use URL shortner?
            if (isset($_POST['top_opt_use_url_shortner'])) {
                update_option('top_opt_use_url_shortner', true);
            } else {

                update_option('top_opt_use_url_shortner', false);
            }

            //url shortener to use
            if (isset($_POST['top_opt_url_shortener'])) {
                update_option('top_opt_url_shortener', $_POST['top_opt_url_shortener']);
                if ($_POST['top_opt_url_shortener'] == "bit.ly") {
                    if (isset($_POST['top_opt_bitly_user'])) {
                        update_option('top_opt_bitly_user', $_POST['top_opt_bitly_user']);
                    }
                    if (isset($_POST['top_opt_bitly_key'])) {
                        update_option('top_opt_bitly_key', $_POST['top_opt_bitly_key']);
                    }
                }
            }

            //hashtags option
            if (isset($_POST['top_opt_custom_hashtag_option'])) {
                update_option('top_opt_custom_hashtag_option', $_POST['top_opt_custom_hashtag_option']);
            } else {
                update_option('top_opt_custom_hashtag_option', "nohashtag");
            }

            //use inline hashtags
            if (isset($_POST['top_opt_use_inline_hashtags'])) {
                update_option('top_opt_use_inline_hashtags', true);
            } else {
                update_option('top_opt_use_inline_hashtags', false);
            }

             //hashtag length
            if (isset($_POST['top_opt_hashtag_length'])) {
                update_option('top_opt_hashtag_length', $_POST['top_opt_hashtag_length']);
            } else {
                update_option('top_opt_hashtag_length', 0);
            }
            
            //custom field name to fetch hashtag from 
            if (isset($_POST['top_opt_custom_hashtag_field'])) {
                update_option('top_opt_custom_hashtag_field', $_POST['top_opt_custom_hashtag_field']);
            } else {
                update_option('top_opt_custom_hashtag_field', '');
            }

            //default hashtags for tweets
            if (isset($_POST['top_opt_hashtags'])) {
                update_option('top_opt_hashtags', $_POST['top_opt_hashtags']);
            } else {
                update_option('top_opt_hashtags', '');
            }

            //tweet interval 
            if (isset($_POST['top_opt_interval'])) {
                if (is_numeric($_POST['top_opt_interval']) && $_POST['top_opt_interval'] > 0) {
                    update_option('top_opt_interval', $_POST['top_opt_interval']);
                } else {
                    update_option('top_opt_interval', "4");
                }
            }

            //random interval
            if (isset($_POST['top_opt_interval_slop'])) {
                if (is_numeric($_POST['top_opt_interval_slop']) && $_POST['top_opt_interval_slop'] > 0) {
                    update_option('top_opt_interval_slop', $_POST['top_opt_interval_slop']);
                } else {
                    update_option('top_opt_interval_slop', "4");
                }
            }

            //minimum post age to tweet
            if (isset($_POST['top_opt_age_limit'])) {
                if (is_numeric($_POST['top_opt_age_limit']) && $_POST['top_opt_age_limit'] >= 0) {
                    update_option('top_opt_age_limit', $_POST['top_opt_age_limit']);
                } else {
                    update_option('top_opt_age_limit', "30");
                }
            }

            //maximum post age to tweet
            if (isset($_POST['top_opt_max_age_limit'])) {
                if (is_numeric($_POST['top_opt_max_age_limit']) && $_POST['top_opt_max_age_limit'] > 0) {
                    update_option('top_opt_max_age_limit', $_POST['top_opt_max_age_limit']);
                } else {
                    update_option('top_opt_max_age_limit', "0");
                }
            }

            //option to enable log
            if ( isset($_POST['top_enable_log'])) {
                update_option('top_enable_log', true);
		global $top_debug;
		$top_debug->enable( true );
                
            }
            else{
                update_option('top_enable_log', false);
                global $top_debug;
		$top_debug->enable( false );	
            }
        
            //categories to omit from tweet
            if (isset($_POST['post_category'])) {
                update_option('top_opt_omit_cats', implode(',', $_POST['post_category']));
            } else {
                update_option('top_opt_omit_cats', '');
            }

            //successful update message
            print('
			<div id="message" class="updated fade">
				<p>' . __('Tweet Old Post Options Updated.', 'TweetOldPost') . '</p>
			</div>');
        }
        //tweet now clicked
        elseif (isset($_POST['tweet'])) {
            $tweet_msg = top_opt_tweet_old_post();
            print('
			<div id="message" class="updated fade">
				<p>' . __($tweet_msg, 'TweetOldPost') . '</p>
			</div>');
        }
        elseif (isset($_POST['reset'])) {
           top_reset_settings();
           echo '<script language="javascript">window.open ("' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=TweetOldPost&top=reset","_self")</script>';
                die;
        }


        //set up data into fields from db
        
        //what to tweet?
        $admin_url = get_option('top_opt_admin_url');
        if (!isset($admin_url)) {
            $admin_url = "";
        }
        
        //what to tweet?
        $tweet_type = get_option('top_opt_tweet_type');
        if (!isset($tweet_type)) {
            $tweet_type = "title";
        }

        //additional text
        $additional_text = get_option('top_opt_add_text');
        if (!isset($additional_text)) {
            $additional_text = "";
        }

        //position of additional text
        $additional_text_at = get_option('top_opt_add_text_at');
        if (!isset($additional_text_at)) {
            $additional_text_at = "beginning";
        }

        //include link in tweet
        $include_link = get_option('top_opt_include_link');
        if (!isset($include_link)) {
            $include_link = "no";
        }

        //use custom field to fetch url
        $custom_url_option = get_option('top_opt_custom_url_option');
        if (!isset($custom_url_option)) {
            $custom_url_option = "";
        } elseif ($custom_url_option)
            $custom_url_option = "checked";
        else
            $custom_url_option="";

        //custom field name for url
        $custom_url_field = get_option('top_opt_custom_url_field');
        if (!isset($custom_url_field)) {
            $custom_url_field = "";
        }

        //use url shortner?
        $use_url_shortner = get_option('top_opt_use_url_shortner');
        if (!isset($use_url_shortner)) {
            $use_url_shortner = "";
        } elseif ($use_url_shortner)
            $use_url_shortner = "checked";
        else
            $use_url_shortner="";

        //url shortner
        $url_shortener = get_option('top_opt_url_shortener');
        if (!isset($url_shortener)) {
            $url_shortener = top_opt_URL_SHORTENER;
        }

        //bitly key
        $bitly_api = get_option('top_opt_bitly_key');
        if (!isset($bitly_api)) {
            $bitly_api = "";
        }

        //bitly username
        $bitly_username = get_option('top_opt_bitly_user');
        if (!isset($bitly_username)) {
            $bitly_username = "";
        }

        //hashtag option
        $custom_hashtag_option = get_option('top_opt_custom_hashtag_option');
        if (!isset($custom_hashtag_option)) {
            $custom_hashtag_option = "nohashtag";
        }

        //use inline hashtag
        $use_inline_hashtags = get_option('top_opt_use_inline_hashtags');
        if (!isset($use_inline_hashtags)) {
            $use_inline_hashtags = "";
        } elseif ($use_inline_hashtags)
            $use_inline_hashtags = "checked";
        else
            $use_inline_hashtags="";

         //hashtag length
        $hashtag_length = get_option('top_opt_hashtag_length');
        if (!isset($hashtag_length)) {
            $hashtag_length = "20";
        }
        
        //custom field 
        $custom_hashtag_field = get_option('top_opt_custom_hashtag_field');
        if (!isset($custom_hashtag_field)) {
            $custom_hashtag_field = "";
        }

        //default hashtag
        $twitter_hashtags = get_option('top_opt_hashtags');
        if (!isset($twitter_hashtags)) {
            $twitter_hashtags = top_opt_HASHTAGS;
        }

        //interval
        $interval = get_option('top_opt_interval');
        if (!(isset($interval) && is_numeric($interval))) {
            $interval = top_opt_INTERVAL;
        }

        //random interval
        $slop = get_option('top_opt_interval_slop');
        if (!(isset($slop) && is_numeric($slop))) {
            $slop = top_opt_INTERVAL_SLOP;
        }

        //min age limit
        $ageLimit = get_option('top_opt_age_limit');
        if (!(isset($ageLimit) && is_numeric($ageLimit))) {
            $ageLimit = top_opt_AGE_LIMIT;
        }

        //max age limit
        $maxAgeLimit = get_option('top_opt_max_age_limit');
        if (!(isset($maxAgeLimit) && is_numeric($maxAgeLimit))) {
            $maxAgeLimit = top_opt_MAX_AGE_LIMIT;
        }

        
        //check enable log
        $top_enable_log = get_option('top_enable_log');
        if (!isset($top_enable_log)) {
            $top_enable_log = "";
        } elseif ($top_enable_log)
            $top_enable_log = "checked";
        else
            $top_enable_log="";
        
        //set omitted categories
        $omitCats = get_option('top_opt_omit_cats');
        if (!isset($omitCats)) {
            $omitCats = top_opt_OMIT_CATS;
        }

        $x = WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__));

        print('
			<div class="wrap">
				<h2>' . __('Tweet old post by - ', 'TweetOldPost') . ' <a href="http://www.ajaymatharu.com">Ajay Matharu</a></h2>
				<form id="top_opt" name="top_TweetOldPost" action="" method="post">
					<input type="hidden" name="top_opt_action" value="top_opt_update_settings" />
					<fieldset class="options">
						<div class="option">
							<label for="top_opt_twitter_username">' . __('Account Login', 'TweetOldPost') . ':</label>

<div id="profile-box">');
        if (!$settings["oauth_access_token"]) {

            echo '<a href="' . top_get_auth_url() . '"><img src="' . $x . 'images/twitter.png" /></a>';
        } else {
            echo '<img class="avatar" src="' . $settings["profile_image_url"] . '" alt="" />
							<h4>' . $settings["screen_name"] . '</h4>';
            if ($settings["location"]) {
                echo '<h5>' . $settings["location"] . '</h5>';
            }
            echo '<p>

								Your account has  been authorized. <a href="' . $_SERVER["REQUEST_URI"] . '&top=deauthorize" onclick=\'return confirm("Are you sure you want to deauthorize your Twitter account?");\'>Click to deauthorize</a>.<br />

							</p>

							<div class="retweet-clear"></div>
					';
        }
        print('</div>
						</div>
                                                <div class="option">
							<b>&nbsp;&nbsp;&nbsp;Note: </b>If you are not able to authorize? or Wordpress logs you out on any button click,<br/>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- If current URL is not showing your current page URL, copy paste the current page URL in Current URL field and press update settings button to update the settings. Then retry to authorize.<br/>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- If current URL is showing your current page URL,  press update settings button to update the settings. Then retry to authorize. 


						</div>
                                                <div class="option">
							<label for="top_opt_admin_url">' . __('Tweet Old Post Admin URL <br/> (Current URL)', 'TweetOldPost') . ':</label>
							<input type="text" style="width:500px" id="top_opt_admin_url" value="' . $admin_url . '" name="top_opt_admin_url" /><br/><b>(Note: If this does not show your current URL in this textbox, copy paste the current URL in this textbox)</b>  
						</div>
						<div class="option">
							<label for="top_opt_tweet_type">' . __('Tweet Content', 'TweetOldPost') . ':</label>
							<select id="top_opt_tweet_type" name="top_opt_tweet_type" style="width:150px">
								<option value="title" ' . top_opt_optionselected("title", $tweet_type) . '>' . __(' Title Only ', 'TweetOldPost') . ' </option>
								<option value="body" ' . top_opt_optionselected("body", $tweet_type) . '>' . __(' Body Only ', 'TweetOldPost') . ' </option>
								<option value="titlenbody" ' . top_opt_optionselected("titlenbody", $tweet_type) . '>' . __(' Title & Body ', 'TweetOldPost') . ' </option>
							</select>
                                                        
						</div>
						
						
						<div class="option">
							<label for="top_opt_add_text">' . __('Additional Text', 'TweetOldPost') . ':</label>
							<input type="text" size="25" name="top_opt_add_text" id="top_opt_add_text" value="' . $additional_text . '" autocomplete="off" />
						</div>
						<div class="option">
							<label for="top_opt_add_text_at">' . __('Additional Text At', 'TweetOldPost') . ':</label>
							<select id="top_opt_add_text_at" name="top_opt_add_text_at" style="width:150px">
								<option value="beginning" ' . top_opt_optionselected("beginning", $additional_text_at) . '>' . __(' Beginning of tweet ', 'TweetOldPost') . '</option>
								<option value="end" ' . top_opt_optionselected("end", $additional_text_at) . '>' . __(' End of tweet ', 'TweetOldPost') . '</option>
							</select>
						</div>
						
						<div class="option">
							<label for="top_opt_include_link">' . __('Include Link', 'TweetOldPost') . ':</label>
							<select id="top_opt_include_link" name="top_opt_include_link" style="width:150px" onchange="javascript:showURLOptions()">
								<option value="false" ' . top_opt_optionselected("false", $include_link) . '>' . __(' No ', 'TweetOldPost') . '</option>
								<option value="true" ' . top_opt_optionselected("true", $include_link) . '>' . __(' Yes ', 'TweetOldPost') . '</option>
							</select>
						</div>
                                                
						<div id="urloptions" style="display:none">
						
                                                <div class="option">
							<label for="top_opt_custom_url_option">' . __('Fetch URL from custom field', 'TweetOldPost') . ':</label>
							<input onchange="return showCustomField();" type="checkbox" name="top_opt_custom_url_option" ' . $custom_url_option . ' id="top_opt_custom_url_option" />
							<b>If checked URL will be fetched from custom field.</b>
						</div>
						
						
						
						<div id="customurl" style="display:none;">
						<div class="option">
							<label for="top_opt_custom_url_field">' . __('Custom field name to fetch URL to be tweeted with post', 'TweetOldPost') . ':</label>
							<input type="text" size="25" name="top_opt_custom_url_field" id="top_opt_custom_url_field" value="' . $custom_url_field . '" autocomplete="off" />
							<b>If set this will fetch the URL from specified custom field</b>
						</div>
						
						</div>
						
						<div class="option">
							<label for="top_opt_use_url_shortner">' . __('Use URL shortner?', 'TweetOldPost') . ':</label>
							<input onchange="return showshortener()" type="checkbox" name="top_opt_use_url_shortner" id="top_opt_use_url_shortner" ' . $use_url_shortner . ' />
							
						</div>
						
						<div  id="urlshortener">
						<div class="option">
							<label for="top_opt_url_shortener">' . __('URL Shortener Service', 'TweetOldPost') . ':</label>
							<select name="top_opt_url_shortener" id="top_opt_url_shortener" onchange="javascript:showURLAPI()" style="width:100px;">
									<option value="is.gd" ' . top_opt_optionselected('is.gd', $url_shortener) . '>' . __('is.gd', 'TweetOldPost') . '</option>
									<option value="su.pr" ' . top_opt_optionselected('su.pr', $url_shortener) . '>' . __('su.pr', 'TweetOldPost') . '</option>
									<option value="bit.ly" ' . top_opt_optionselected('bit.ly', $url_shortener) . '>' . __('bit.ly', 'TweetOldPost') . '</option>
									<option value="tr.im" ' . top_opt_optionselected('tr.im', $url_shortener) . '>' . __('tr.im', 'TweetOldPost') . '</option>
									<option value="3.ly" ' . top_opt_optionselected('3.ly', $url_shortener) . '>' . __('3.ly', 'TweetOldPost') . '</option>
									<option value="u.nu" ' . top_opt_optionselected('u.nu', $url_shortener) . '>' . __('u.nu', 'TweetOldPost') . '</option>
									<option value="1click.at" ' . top_opt_optionselected('1click.at', $url_shortener) . '>' . __('1click.at', 'TweetOldPost') . '</option>
									<option value="tinyurl" ' . top_opt_optionselected('tinyurl', $url_shortener) . '>' . __('tinyurl', 'TweetOldPost') . '</option>
							</select>
						</div>
						<div id="showDetail" style="display:none">
							<div class="option">
								<label for="top_opt_bitly_user">' . __('bit.ly Username', 'TweetOldPost') . ':</label>
								<input type="text" size="25" name="top_opt_bitly_user" id="top_opt_bitly_user" value="' . $bitly_username . '" autocomplete="off" />
							</div>
							
							<div class="option">
								<label for="top_opt_bitly_key">' . __('bit.ly API Key', 'TweetOldPost') . ':</label>
								<input type="text" size="25" name="top_opt_bitly_key" id="top_opt_bitly_key" value="' . $bitly_api . '" autocomplete="off" />
							</div>
						</div>
                                                </div>
					</div>
						

                                                <div class="option">
							<label for="top_opt_custom_hashtag_option">' . __('Hashtags', 'TweetOldPost') . ':</label>
                                                        <select name="top_opt_custom_hashtag_option" id="top_opt_custom_hashtag_option" onchange="javascript:return showHashtagCustomField()" style="width:250px;">
									<option value="nohashtag" ' . top_opt_optionselected('nohashtag', $custom_hashtag_option) . '>' . __('Don`t add any hashtags', 'TweetOldPost') . '</option>
                                                                        <option value="common" ' . top_opt_optionselected('common', $custom_hashtag_option) . '>' . __('Common hashtag for all tweets', 'TweetOldPost') . '</option>    
									<option value="categories" ' . top_opt_optionselected('categories', $custom_hashtag_option) . '>' . __('Create hashtags from categories', 'TweetOldPost') . '</option>
									<option value="tags" ' . top_opt_optionselected('tags', $custom_hashtag_option) . '>' . __('Create hashtags from tags', 'TweetOldPost') . '</option>
									<option value="custom" ' . top_opt_optionselected('custom', $custom_hashtag_option) . '>' . __('Get hashtags from custom fields', 'TweetOldPost') . '</option>
									
							</select>
							
                                                        
						</div>
						<div id="inlinehashtag" style="display:none;">
						<div class="option">
							<label for="top_opt_use_inline_hashtags">' . __('Use inline hashtags: ', 'TweetOldPost') . '</label>
							<input type="checkbox" name="top_opt_use_inline_hashtags" id="top_opt_use_inline_hashtags" ' . $use_inline_hashtags . ' /> 
                                                       
						</div>
                                                
                                                <div class="option">
							<label for="top_opt_hashtag_length">' . __('Maximum Hashtag length: ', 'TweetOldPost') . '</label>
							<input type="text" size="25" name="top_opt_hashtag_length" id="top_opt_hashtag_length" value="' . $hashtag_length . '" /> 
                                                       <b>Set this to 0 to include all hashtags</b>
						</div>
						</div>
						<div id="customhashtag" style="display:none;">
						<div class="option">
							<label for="top_opt_custom_hashtag_field">' . __('Custom field name', 'TweetOldPost') . ':</label>
							<input type="text" size="25" name="top_opt_custom_hashtag_field" id="top_opt_custom_hashtag_field" value="' . $custom_hashtag_field . '" autocomplete="off" />
							<b>fetch hashtags from this custom field</b>
						</div>
						
						</div>
                                                <div id="commonhashtag" style="display:none;">
						<div class="option">
							<label for="top_opt_hashtags">' . __('Common #hashtags for your tweets', 'TweetOldPost') . ':</label>
							<input type="text" size="25" name="top_opt_hashtags" id="top_opt_hashtags" value="' . $twitter_hashtags . '" autocomplete="off" />
							<b>Include #, like #thoughts</b>
						</div>
						</div>
						<div class="option">
							<label for="top_opt_interval">' . __('Minimum interval between tweets: ', 'TweetOldPost') . '</label>
							<input type="text" id="top_opt_interval" maxlength="5" value="' . $interval . '" name="top_opt_interval" /> Hour / Hours <b>(Note: If set to 0 it will take default as 4 hours)</b>
                                                       
						</div>
						<div class="option">
							<label for="top_opt_interval_slop">' . __('Random Interval (added to minimum interval): ', 'TweetOldPost') . '</label>
							<input type="text" id="top_opt_interval_slop" maxlength="5" value="' . $slop . '" name="top_opt_interval_slop" /> Hour / Hours <b>(Note: If set to 0 it will take default as 4 hours)</b>
                                                            
						</div>
						<div class="option">
							<label for="top_opt_age_limit">' . __('Minimum age of post to be eligible for tweet: ', 'TweetOldPost') . '</label>
							<input type="text" id="top_opt_age_limit" maxlength="5" value="' . $ageLimit . '" name="top_opt_age_limit" /> Day / Days
							<b> (enter 0 for today)</b>
                                                           
						</div>
						
						<div class="option">
							<label for="top_opt_max_age_limit">' . __('Maximum age of post to be eligible for tweet: ', 'TweetOldPost') . '</label>
                                                        <input type="text" id="top_opt_max_age_limit" maxlength="5" value="' . $maxAgeLimit . '" name="top_opt_max_age_limit" /> Day / Days
                                                       <b>(If you dont want to use this option enter 0 or leave blank)</b><br/>
							<b>Post older than specified days will not be tweeted.</b>
						</div>
						

                                                
                                                    


                                                <div class="option">
							<label for="top_enable_log">' . __('Enable Log: ', 'TweetOldPost') . '</label>
							<input type="checkbox" name="top_enable_log" id="top_enable_log" ' . $top_enable_log . ' /> 
                                                        <b>saves log in log folder</b>    
                                                       
						</div>

                                        
				    	<div class="option category">
				    	<div style="float:left">
						    	<label class="catlabel">' . __('Categories to Omit from tweets: ', 'TweetOldPost') . '</label> </div>
						    	<div style="float:left">
						    		<ul id="categorychecklist" class="list:category categorychecklist form-no-clear">
								');
        wp_category_checklist(0, 0, explode(',', $omitCats));
        print('				    		</ul>
              <div style="clear:both;padding-top:20px;">
                                                          <a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=ExcludePosts">Exclude specific posts</a> from selected categories.
                                                              </div>
                                                              

								</div>
                                                               
								</div>
					</fieldset>
					
                                                

                                                <h3>Note: Please click update to then click tweet now to reflect the changes.</h3>
						<p class="submit"><input type="submit" name="submit" onclick="javascript:return validate()" value="' . __('Update Tweet Old Post Options', 'TweetOldPost') . '" />
						<input type="submit" name="tweet" value="' . __('Tweet Now', 'TweetOldPost') . '" />
                                                <input type="submit" onclick=\'return confirm("This will reset all the setting, including your account, omitted categories and excluded posts. Are you sure you want to reset all the settings?");\' name="reset" value="' . __('Reset Settings', 'TweetOldPost') . '" />
					</p>
						
				</form><script language="javascript" type="text/javascript">
function showURLAPI()
{
	var urlShortener=document.getElementById("top_opt_url_shortener").value;
	if(urlShortener=="bit.ly")
	{
		document.getElementById("showDetail").style.display="block";
		
	}
	else
	{
		document.getElementById("showDetail").style.display="none";
		
	}
	
}

function validate()
{

	if(document.getElementById("showDetail").style.display=="block" && document.getElementById("top_opt_url_shortener").value=="bit.ly")
	{
		if(trim(document.getElementById("top_opt_bitly_user").value)=="")
		{
			alert("Please enter bit.ly username.");
			document.getElementById("top_opt_bitly_user").focus();
			return false;
		}

		if(trim(document.getElementById("top_opt_bitly_key").value)=="")
		{
			alert("Please enter bit.ly API key.");
			document.getElementById("top_opt_bitly_key").focus();
			return false;
		}
	}
 if(trim(document.getElementById("top_opt_interval").value) != "" && !isNumber(trim(document.getElementById("top_opt_interval").value)))
        {
            alert("Enter only numeric in Minimum interval between tweet");
		document.getElementById("top_opt_interval").focus();
		return false;
        }
         if(trim(document.getElementById("top_opt_interval_slop").value) != "" && !isNumber(trim(document.getElementById("top_opt_interval_slop").value)))
        {
            alert("Enter only numeric in Random interval");
		document.getElementById("top_opt_interval_slop").focus();
		return false;
        }
        if(trim(document.getElementById("top_opt_age_limit").value) != "" && !isNumber(trim(document.getElementById("top_opt_age_limit").value)))
        {
            alert("Enter only numeric in Minimum age of post");
		document.getElementById("top_opt_age_limit").focus();
		return false;
        }
 if(trim(document.getElementById("top_opt_max_age_limit").value) != "" && !isNumber(trim(document.getElementById("top_opt_max_age_limit").value)))
        {
            alert("Enter only numeric in Maximum age of post");
		document.getElementById("top_opt_max_age_limit").focus();
		return false;
        }
	if(trim(document.getElementById("top_opt_max_age_limit").value) != "" && trim(document.getElementById("top_opt_max_age_limit").value) != 0)
	{
	if(eval(document.getElementById("top_opt_age_limit").value) > eval(document.getElementById("top_opt_max_age_limit").value))
	{
		alert("Post max age limit cannot be less than Post min age iimit");
		document.getElementById("top_opt_age_limit").focus();
		return false;
	}
	}
}

function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}

function showCustomField()
{
	if(document.getElementById("top_opt_custom_url_option").checked)
	{
		document.getElementById("customurl").style.display="block";
	}
	else
	{
		document.getElementById("customurl").style.display="none";
	}
}

function showHashtagCustomField()
{
	if(document.getElementById("top_opt_custom_hashtag_option").value=="custom")
	{
		document.getElementById("customhashtag").style.display="block";
                document.getElementById("commonhashtag").style.display="none";
                 document.getElementById("inlinehashtag").style.display="block";
	}
        else if(document.getElementById("top_opt_custom_hashtag_option").value=="common")
	{
		document.getElementById("customhashtag").style.display="none";
                document.getElementById("commonhashtag").style.display="block";
                document.getElementById("inlinehashtag").style.display="block";
	}
        else if(document.getElementById("top_opt_custom_hashtag_option").value=="nohashtag")
	{
		document.getElementById("customhashtag").style.display="none";
                document.getElementById("commonhashtag").style.display="none";
                document.getElementById("inlinehashtag").style.display="none";
	}
	else
	{
                document.getElementById("inlinehashtag").style.display="block";
		document.getElementById("customhashtag").style.display="none";
                document.getElementById("commonhashtag").style.display="none";
	}
}

function showURLOptions()
{
    if(document.getElementById("top_opt_include_link").value=="true")
	{
		document.getElementById("urloptions").style.display="block";
	}
	else
	{
		document.getElementById("urloptions").style.display="none";
	}
}

function isNumber(val)
{
    if(isNaN(val)){
        return false;
    }
    else{
        return true;
    }
}

function showshortener()
{
						

	if((document.getElementById("top_opt_use_url_shortner").checked))
		{
			document.getElementById("urlshortener").style.display="block";
		}
		else
		{
			document.getElementById("urlshortener").style.display="none";
		}
}
function setFormAction()
{
    if(document.getElementById("top_opt_admin_url").value == "")
    {
        document.getElementById("top_opt_admin_url").value=location.href;
        document.getElementById("top_opt").action=location.href;
    }
    else
    {
        document.getElementById("top_opt").action=document.getElementById("top_opt_admin_url").value;
    }
}

setFormAction();
showURLAPI();
showshortener();
showCustomField();
showHashtagCustomField();
showURLOptions();

</script>');
    } else {
        print('
			<div id="message" class="updated fade">
				<p>' . __('You do not have enough permission to set the option. Please contact your admin.', 'TweetOldPost') . '</p>
			</div>');
    }
}

function top_opt_optionselected($opValue, $value) {
    if ($opValue == $value) {
        return 'selected="selected"';
    }
    return '';
}

function top_opt_head_admin() {
    $home = get_settings('siteurl');
    $base = '/' . end(explode('/', str_replace(array('\\', '/top-admin.php'), array('/', ''), __FILE__)));
    $stylesheet = $home . '/wp-content/plugins' . $base . '/css/tweet-old-post.css';
    echo('<link rel="stylesheet" href="' . $stylesheet . '" type="text/css" media="screen" />');
}

?>