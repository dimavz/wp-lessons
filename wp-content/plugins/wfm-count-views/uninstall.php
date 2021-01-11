<?php

if( !defined('WP_UNINSTALL_PLUGIN') ) exit;

include dirname(__FILE__) . '/wfm-check.php';

if( wfm_check_field('wfm_views') ){
	global $wpdb;

	$query = "ALTER TABLE $wpdb->posts DROP wfm_views";
	$wpdb->query($query);
}