<?php
/*
Plugin Name: My-Website Statistics
Plugin URI: http://holiday2nepal.com/demo
Description: Statistics for your WordPress site.
Version: 1.0
Author: Bishnu Gopali
Author URI: http://holiday2nepal.com/
License: GPL2
*/



register_activation_hook( __FILE__, 'my_site_statistics' );
function my_site_statistics() {
	
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'my_analysis';

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		userIP varchar(255) NOT NULL,
		page_views_count int(11) NOT NULL,
		used_browser varchar(255) NOT NULL,
		language varchar(255) NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );


}


function my_site_statistics() {

	global $wpdb;
  	$version = get_option( 'my_plugin_version', '1.0' );
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'my_analysis';

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		userIP varchar(255) NOT NULL,
		page_views_count int(11) NOT NULL,
		used_browser varchar(255) NOT NULL,
		language varchar(255) NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	
	if ( version_compare( $version, '2.0' ) < 0 ) {
		$sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		userIP varchar(255) NOT NULL,
		page_views_count int(11) NOT NULL,
		used_browser varchar(255) NOT NULL,
		language varchar(255) NOT NULL,
		UNIQUE KEY id (id)
		) $charset_collate;";
		dbDelta( $sql );
	
	  	update_option( 'my_plugin_version', '2.0' );
		
	}

	
}


function insert_my_site_statistics{

	$userIP='192.168.0.1';
	$page_views_count=the_views();
	$used_browser=browser_body_class();
	$language='$_SERVER['HTTP_ACCEPT_LANGUAGE']';

	$table_name=$wpdb->prefix . 'my_analysis';

	$wpdb->insert(
		$table_name,
		array(	
			'userIP'=>get_the_user_ip(),
			'page_views_count'=>$page_views_count,
			'used_browser'=>$used_browser,
			'language'=>$language	
	)
);
}


function get_the_user_ip() {
	if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		//check ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		//to check ip is pass from proxy
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		$ip = $_SERVER['REMOTE_ADDR'];
		}
		return ($ip);
		}

function browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}

?>