<?php
/*
Plugin Name: Сбор подписчиков
Description: Плагин предоставляет виджет, позволяющий собирать подписчиков
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

include dirname(__FILE__) . '/wfm_widget_class.php';

register_activation_hook( __FILE__, 'wfm_create_table' );
add_action( 'widgets_init', 'wfm_widget_subscriber' );

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
