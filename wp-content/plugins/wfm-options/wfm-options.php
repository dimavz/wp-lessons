<?php
/*
Plugin Name: Options & Settings API
Description: Изучаем API опций и настроек
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

// add_option( 'wfm_test', 111 );
// if( update_option( 'wfm_test', 222 ) ) echo 'OK';
// if( delete_option( 'wfm_test' ) ) echo 'OK';

add_action( 'admin_init', 'wfm_first_option' );

function wfm_first_option(){
	// $option_group, $option_name, $sanitize_callback
	register_setting(
		'general', // страница меню Настройки, для которой регистрируется опция
		'wfm_first_option' // название опции
	);

	// $id, $title, $callback, $page, $section, $args
	add_settings_field(
		'wfm_first_option', // ID опции (использовать для ID поля формы)
		'Первая опция', // заголовок
		'wfm_option_cb', // callback-функция, для html-кода поля формы
		'general' // траница меню Настройки, для которой регистрируется опция
	);
}

function wfm_option_cb(){
	?>

<input type="text" name="wfm_first_option" id="wfm_first_option" value="<?php echo esc_attr( get_option('wfm_first_option') ); ?>" class="regular-text">

	<?php
}