<?php
/*
Plugin Name: Работа с расписанием
Description: Работа с расписанием в WP
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

//wp_clear_scheduled_hook('wfm_cron_action');

add_action('wfm_cron_action', 'wfm_cron_cb');

if (!wp_next_scheduled('wfm_cron_action')) {
    wp_schedule_event(time(), 'hourly', 'wfm_cron_action');
}

function wfm_cron_cb()
{
    error_log('Cron worked ### ' . date("i:s", time()));
}

//add_action( 'wfm_cron_action', 'wfm_cron_cb' );
//
//wp_schedule_event( time(), 'hourly', 'wfm_cron_action' );
//
//function wfm_cron_cb(){
//	error_log( 'Крон отработал ' . date("h:i:s", time()) );
//}