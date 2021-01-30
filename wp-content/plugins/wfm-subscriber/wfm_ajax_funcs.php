<?php

function wfm_ajax_subscriber(){
	if( !wp_verify_nonce( $_POST['security'], 'wfmajax' ) ){
		die('Ошибка безопасности!');
	}

	parse_str($_POST['formData'], $wfm_array);

//	echo '<pre>';
//	print_r($wfm_array);
//	echo '</pre>';
//	exit();

	if( empty($wfm_array['wfm_name']) || empty($wfm_array['wfm_email']) ){
		exit('Заполните поля!');
	}

	if( !is_email( $wfm_array['wfm_email'] ) ){
		exit('Email не соответствует формату');
	}

	die;
}