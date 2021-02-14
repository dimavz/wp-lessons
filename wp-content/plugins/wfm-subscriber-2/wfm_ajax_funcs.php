<?php

function wfm_ajax_subscriber_admin(){
	if( empty($_POST['data']) ){
		echo 'Заполните текст рассылки';
	}

	$time = wp_next_scheduled( 'wfm_cron_action' );
	wp_unschedule_event( $time, 'wfm_cron_action' );

	if( !wp_next_scheduled( 'wfm_cron_action' ) ){
		$options = get_option( 'wfm_subscriber_options' );
		$schedule = $options['schedule'];
		$limit = $options['limit'];
		$schedules = wp_get_schedules();
//		echo '<pre>';
//		print_r($schedules);
//		echo '</pre>';
//		exit();
        $schedule_interval = 3600;
		foreach($schedules as $k => $v){
			if( $v['interval'] == $schedule ){
				$schedule_interval = $k;
				break;
			}
		}
//		echo $schedule_interval;
//		exit;
		wp_schedule_event( time(), $schedule_interval, 'wfm_cron_action' );
	}

	/*$subscribers = get_subscribers(true);
	$i = 0;
	foreach($subscribers as $subscriber){
		$data = nl2br( str_replace('%name%', $subscriber['subscriber_name'], $_POST['data']) );
		if( wp_mail( $subscriber['subscriber_email'], 'Рассылка с сайта', $data ) ) $i++;
	}*/
	die("Работает!");
}

function wfm_ajax_subscriber(){
	if( !wp_verify_nonce( $_POST['security'], 'wfmajax' ) ){
		die('Ошибка безопасности!');
	}

	parse_str($_POST['formData'], $wfm_array);

	if( empty($wfm_array['wfm_name']) || empty($wfm_array['wfm_email']) ){
		exit('Заполните поля!');
	}

	if( !is_email( $wfm_array['wfm_email'] ) ){
		exit('Email не соответствует формату');
	}

	global $wpdb;
	if($wpdb->get_var($wpdb->prepare(
		"SELECT subscriber_id FROM wfm_subscriber WHERE subscriber_email = %s", $wfm_array['wfm_email']
	))){
		echo 'Вы уже подписаны';
	}else{
		if($wpdb->query($wpdb->prepare(
			"INSERT INTO wfm_subscriber (subscriber_name, subscriber_email, text) VALUES (%s, %s, '')", $wfm_array['wfm_name'], $wfm_array['wfm_email']
		))){
			echo 'Подписка оформлена';
		}else{
			echo 'Ошибка записи!';
		}
	}

	die;
}