<?php

add_filter( 'cron_schedules', 'wfm_add_schedules' );
add_action( 'wfm_cron_action', 'wfm_cron_cb' );

function wfm_cron_cb(){
	global $wpdb;
	$options = get_option( 'wfm_subscriber_options' );
	$limit = $options['limit'];
	if( !$res_count = $wpdb->query("UPDATE wfm_subscriber SET send = '2' WHERE send = '1' ORDER BY subscriber_id ASC LIMIT $limit") ){
		wp_clear_scheduled_hook( 'wfm_cron_action' );
		return;
	}
	$res = $wpdb->get_results("SELECT * FROM wfm_subscriber WHERE send = '2'", ARRAY_A);
	foreach($res as $item){
		$data = nl2br( str_replace('%name%', $item['subscriber_name'], $item['text']) );
		wp_mail( $item['subscriber_email'], 'Рассылка с сайта', $data );
	}
	$wpdb->query("UPDATE wfm_subscriber SET send = '0' WHERE send = '2'");
	// если выбрана неполная партия
	if( $res_count < $limit ){
		wp_clear_scheduled_hook( 'wfm_cron_action' );
	}
}

function wfm_add_schedules($schedules){
	$schedules['minute'] = array(
		'interval' => 60,
		'display' => '1 минута'
	);
	$schedules['two-minutes'] = array(
		'interval' => 120,
		'display' => '2 минуты'
	);
	$schedules['five-minutes'] = array(
		'interval' => 300,
		'display' => '5 минут'
	);
	$schedules['fifteen-minutes'] = array(
		'interval' => 900,
		'display' => '15 минут'
	);
	$schedules['thirty-minutes'] = array(
		'interval' => 1800,
		'display' => '30 минут'
	);
	$schedules['forty-five-minutes'] = array(
		'interval' => 2700,
		'display' => '45 минут'
	);
	return $schedules;
}