<?php
/*
Plugin Name: AJAX в WP
Description: Возможности работы с AJAX в WP
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

add_action( 'admin_menu', 'wfm_admin_menu' );
add_action( 'admin_init', 'wfm_admin_settings' );
add_action( 'wp_ajax_wfm_action', 'wfm_ajax_check' );

function wfm_ajax_check(){
	if( !wp_verify_nonce( $_POST['security']['nonce'], 'wfmajax' ) ){
		die('NO');
	}
	if( preg_match("/(^#[a-z0-9]{3}|^#[a-z0-9]{6})$/i", $_POST['formData']) ){ //Регулярное выражение ищет либо 3 символа после знака #, либо 6 символов после знака #
        if( isset($_POST['formData']) ){
            update_option( 'wfm_theme_options', $_POST['formData'] );
            echo 'Данные обновлены';
        }
//		echo 'Подходит';
	}else{
		echo 'Не верный формат данных';
	}
	die();
}

function wfm_admin_scripts(){
	wp_register_script( 'wfm-scripts', plugins_url( 'wfm-scripts.js', __FILE__ ), array('jquery') );
	wp_enqueue_script( 'wfm-scripts' );
	wp_localize_script( 'wfm-scripts', 'wfmajax', array( 'nonce' => wp_create_nonce('wfmajax') ) );
}

function wfm_admin_settings(){
	register_setting( 'wfm_theme_options_group', 'wfm_theme_options' );

	add_settings_section( 'wfm_theme_options_id', 'Секция Опции темы', '', 'wfm-theme-options' );

	add_settings_field( 'wfm_theme_options_body', 'Цвет фона', 'wfm_theme_body_cb', 'wfm-theme-options', 'wfm_theme_options_id', array('label_for' => 'wfm_theme_options_body') );
}

function wfm_admin_menu(){
	$hook_suffix = add_options_page( 'Опции темы', 'Опции (AJAX)', 'manage_options', 'wfm-theme-options', 'wfm_options_page' );
	add_action( 'admin_print_scripts-' . $hook_suffix, 'wfm_admin_scripts' );
}

function wfm_theme_body_cb(){
	$options = get_option( 'wfm_theme_options' );
	?>
<p>
	<input type="text" name="wfm_theme_options" id="wfm_theme_options_body" value="<?php echo esc_attr($options); ?>" class="regular-text"> <span id="loader" style="display: none;"><img src="<?php echo plugins_url( 'loader.gif', __FILE__ ); ?>" alt=""></span><span id="res"></span>
</p>
	<?php
}

function wfm_options_page(){
	?>
<div class="wrap">
	<h2>Опции темы (AJAX)</h2>
	<p>Проверка опций без перезагрузки страницы.</p>
	<form action="options.php" method="post" id="wfm-form">
		<?php settings_fields( 'wfm_theme_options_group' ); ?>
		<?php do_settings_sections( 'wfm-theme-options' ); ?>
		<?php submit_button(); ?>
	</form>
</div>
	<?php
}