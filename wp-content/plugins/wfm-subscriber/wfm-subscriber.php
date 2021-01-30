<?php
/*
Plugin Name: Сбор подписчиков
Description: Плагин предоставляет виджет, позволяющий собирать подписчиков
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

include dirname(__FILE__) . '/wfm_widget_class.php';
include dirname(__FILE__) . '/wfm_ajax_funcs.php';

register_activation_hook( __FILE__, 'wfm_create_table' );
add_action( 'widgets_init', 'wfm_widget_subscriber' );
add_action( 'wp_ajax_wfm_subscriber', 'wfm_ajax_subscriber' );
add_action( 'wp_ajax_nopriv_wfm_subscriber', 'wfm_ajax_subscriber' );

function wfm_create_table(){
	global $wpdb;
	$query = "CREATE TABLE IF NOT EXISTS `wfm_subscriber` (
		`subscriber_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`subscriber_name` varchar(50) NOT NULL,
		`subscriber_email` varchar(50) NOT NULL,
		PRIMARY KEY (`subscriber_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$wpdb->query($query);
}

function wfm_widget_subscriber(){
	register_widget( 'WFM_Widget_Subscriber' );
}

function wfm_subscriber_scripts(){
	wp_register_script( 'wfm-subscriber', plugins_url( 'js/wfm-subscriber.js', __FILE__ ), array('jquery') );
	wp_enqueue_script( 'wfm-subscriber' );
	wp_localize_script( 'wfm-subscriber', 'wfmajax', array( 'url' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'wfmajax' ) ) );
}