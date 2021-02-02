<?php
/*
Plugin Name: Работа с расписанием
Description: Работа с расписанием в WP
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

// wp_clear_scheduled_hook( 'wfm_cron_action' );

add_action( 'init', 'wfm_setup_schedule' );
add_action( 'wfm_cron_action', 'wfm_cron_cb' );
add_filter( 'cron_schedules', 'wfm_add_schedules' );

// $schedules = wp_get_schedules();
// print_r($schedules);

function wfm_setup_schedule(){
	if( !wp_next_scheduled( 'wfm_cron_action' ) ){
		wp_schedule_event( time(), 'minute', 'wfm_cron_action' );
	}
}

function wfm_cron_cb(){
	error_log("Cron worked " . date("i:s", time()));
}

function wfm_add_schedules($schedules){ // Добавляем собственные интервалы в расписание
	$schedules['minute'] = array(
		'interval' => 60,
		'display' => 'Every 1 minute'
	);
	$schedules['once-two-minutes'] = array(
		'interval' => 120,
		'display' => 'Every 2 minutes'
	);
	return $schedules;
}