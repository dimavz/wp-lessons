<?php

add_filter( 'cron_schedules', 'wfm_add_schedules' );

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