<?php

function wfm_ajax_subscriber_admin(){
	if( empty($_POST['data']) ){
		echo 'Заполните текст рассылки';
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