<?php
/*
Plugin Name: AJAX в WP
Description: Возможности работы с AJAX в WP
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

/*if( isset($_POST['test']) ){
	print_r($_POST);
	die;
}*/

add_action( 'admin_menu', 'wfm_admin_menu' );
add_action( 'admin_init', 'wfm_admin_settings' );
add_action( 'wp_ajax_wfm_action', 'wfm_ajax_check' ); // Хук wp_ajax_wfm_action состоит из двух частей. 1-я часть wp_ajax_ стандартная часть WordPrees
 // 2-я часть wfm_action динамичная часть WordPrees, которая указывается в скрипте при отправке данных data (параметр action)

function wfm_ajax_check(){
	if( isset($_POST['formData']) ){
		update_option( 'wfm_theme_options', $_POST['formData'] );
		echo 'OK';
	}
	die;
}

function wfm_admin_scripts(){
	wp_register_script( 'wfm-scripts', plugins_url( 'wfm-scripts.js', __FILE__ ), array('jquery') );
	wp_enqueue_script( 'wfm-scripts' );
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
	<input type="text" name="wfm_theme_options" id="wfm_theme_options_body" value="<?php echo esc_attr($options); ?>" class="regular-text">
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