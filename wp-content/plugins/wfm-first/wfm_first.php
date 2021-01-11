<?php
/*
Plugin Name: Первый плагин
Description: Описание первого плагина
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

include dirname(__FILE__) . '/deactivate.php';

register_activation_hook( __FILE__, 'wfm_activate' );
register_deactivation_hook( __FILE__, 'wfm_deactivate' );
// register_uninstall_hook( __FILE__, 'wfm_uninstall' );

function wfm_uninstall(){
	wp_mail( get_bloginfo( 'admin_email' ), 'Плагин удален', 'Произошло успешное удаление плагина' );
}

function wfm_activate(){
	wp_mail( get_bloginfo( 'admin_email' ), 'Плагин активирован', 'Произошла успешная активация плагина' );
}

/*register_activation_hook( __FILE__, function(){
	wp_mail( get_bloginfo( 'admin_email' ), 'Плагин активирован', 'Произошла успешная активация плагина' );
} );*/

/*register_activation_hook( __FILE__, 'wfm_activate' );

function wfm_activate(){
	if( version_compare(PHP_VERSION, '5.4.0', '<') ){
		header("Content-type: text/html; Charset=utf-8");
		exit('Для работы плагина нужна версия PHP >= 5.3.0');
	}
}*/

/*class WFMActivate{
	function __construct(){
		register_activation_hook( __FILE__, array( $this, 'wfm_activate' ) );
	}

	function wfm_activate(){
		$date = "[" . date("Y-m-d H:i:s") . "]";
		error_log($date . " Плагин активирован\r\n", 3, dirname(__FILE__) . '/wfm_errors_log.log');
	}
}

$wfm_activate = new WFMActivate;*/

/*class WFMActivate{
	static function wfm_activate(){
		$date = "[" . date("Y-m-d H:i:s") . "]";
		error_log($date . " Плагин активирован\r\n", 3, dirname(__FILE__) . '/wfm_errors_log.log');
	}
}

register_activation_hook( __FILE__, array( 'WFMActivate', 'wfm_activate' ) );*/