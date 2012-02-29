<?php
/*
 * Plugin Name: Feedburner Circulation
 * Plugin URI: http://wordpress.org/extend/plugins/feedburner-circulation/
 * Description: Returns your Feedburner Circulation Count. Reduces the Feedburner API calls by updating hourly and serving a database cached result in between.
 * Version: 1.2
 * Author: Derek Herman
 * Author URI: http://valendesigns.com
 */

/*
 * Wordpress Hooks
 */
register_activation_hook(__FILE__, 'feedburner_circulation_install');

/**
 * Install Feedburner Circulation & clean up old DB table
 *
 * @uses $wpdb
 * @uses query
 *
 * @access public
 * @since 1.0
 *
 * @return void
 */
function feedburner_circulation_install() 
{
  global $wpdb;
  $table = $wpdb->prefix . 'feedburner';
  $wpdb->query("DROP TABLE IF EXISTS $table");
}

/**
 * Return Feedburner Circulation
 *
 * @uses get_option
 * @uses get_transient
 * @uses isset
 * @uses simplexml_load_file
 * @uses is_array
 * @uses set_transient
 *
 * @access public
 * @since 1.2
 *
 * @param string $id your Feedburner Feed ID
 * @param int $default your fallback circulation count during a zero result: default 0
 *
 * @return int
 */
function get_circulation_count( $id = '', $default = 0 ) 
{
  // no $id return false
  if ( !$id )
    return false;
    
  // just to keep the code below cleaner
  $cache_key = "circulation_count_{$id}";
  $transient = "_transient_{$cache_key}";
  $transient_timeout = "_transient_timeout_{$cache_key}";
  
  // set original circulation count before we destroy it.
  if ( get_option( $transient_timeout ) < time() )
    $old_circulation_count = get_option( $transient );
    
  // next we look for a cached result
  if ( false !== $circulation_count = get_transient( $cache_key ) )
    return $circulation_count;
  
  // okay, no cache, so let's fetch it
  // set api url
  $api_url = ( ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ) == 'on' ? 'https://' : 'http://' ).'feedburner.google.com/api/awareness/1.0/GetFeedData?uri=';
  
  // parse the xml
  $result = simplexml_load_file( $api_url.$id );

  // has circulation count, cache the result for an hour
  if ( 0 !== $count = (int) $result->feed->entry['circulation'] )
  {
    $circulation_count = (int) $count;
    set_transient( $cache_key , $circulation_count, 3600 );
  }
  // cache the old result for 5 minutes, if old data doesn't exist set to zero.
  else
  {
    $circulation_count = ( $old_circulation_count ) ? (int) $old_circulation_count : $default;
    set_transient( $cache_key, $circulation_count, 300 );
  }
  
  return $circulation_count;
}

/**
 * Display Circulation Count
 *
 * @uses is_array
 * @uses get_circulation_count
 * @uses number_format
 *
 * @access public
 * @since 1.2
 *
 * @param array $ids an array of Feedburner Feed IDs
 * @param int $default your fallback circulation count during a zero result: default 0
 * @param bool $echo return or echo: default true (echo)
 * @param bool $format return as plain integer or number formatted: default true (number format)
 *
 * @echo mixed
 */
function circulation_count( $ids = array(), $default = 0, $echo = true, $format = true ) 
{
  $circulation_count = '';
  
  // get circulation count
  if ( is_array( $ids ) )
    foreach( $ids as $id )
      $circulation_count += get_circulation_count( $id, $default );
  else
    $circulation_count = get_circulation_count( $ids, $default );
  
  // format the count
  if ( $format )
    $circulation_count = number_format( $circulation_count );
  
  // echo the count
  if ( $echo )
    echo $circulation_count;
  
  return $circulation_count;
}

/**
 * DEPRECATED
 * Return Feedburner Circulation number
 *
 * @access public
 * @since 1.1
 *
 * @param string $feed_id Your Feedburner Feed ID
 *
 * @return int
 */
function get_feedburner_circulation_text( $id = '' ) 
{
  return get_circulation_count( $id );
}

/**
 * DEPRECATED 
 * Echo Feedburner Circulation number
 *
 * @access public
 * @since 1.0
 *
 * @param string $id Your Feedburner Feed ID
 *
 * @echo int
 */
function feedburner_circulation_text( $id ) 
{
  echo number_format( get_circulation_count( $id ) );
}