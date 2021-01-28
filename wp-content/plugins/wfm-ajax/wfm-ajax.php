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
//	echo '<pre>';
//	print_r($hook_suffix);
//	echo '</pre>';
//	exit();
	add_action( 'admin_print_scripts-' . $hook_suffix, 'wfm_admin_scripts' ); // Подключение скрипта только к странице плагина в админке
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
	<form action="options.php" method="post">
		<?php settings_fields( 'wfm_theme_options_group' ); ?>
		<?php do_settings_sections( 'wfm-theme-options' ); ?>
		<?php submit_button(); ?>
	</form>
</div>
	<?php
}