<?php

function get_subscribers(){
	global $wpdb;

	return $wpdb->get_results("SELECT * FROM wfm_subscriber", ARRAY_A);
}