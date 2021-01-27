<?php
/*
Plugin Name: Options & Settings API
Description: Изучаем API опций и настроек. Собственная страница настроек
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

register_deactivation_hook( __FILE__, 'wfm_delete_options' );
add_action( 'wp_enqueue_scripts', 'wfm_scripts_styles' );
add_action( 'admin_menu', 'wfm_admin_menu' );
add_action( 'admin_init', 'wfm_admin_settings' );

function wfm_delete_options(){
    delete_option( 'wfm_theme_options' );
}

function wfm_scripts_styles(){
    $wfm_theme_options = get_option( 'wfm_theme_options' );
    wp_register_script( 'wfm-options-page', plugins_url('wfm-options.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'wfm-options-page' );
    wp_localize_script( 'wfm-options-page', 'wfmObj', $wfm_theme_options );
}

function wfm_admin_settings(){
	// $option_group, $option_name, $sanitize_callback
	register_setting( 'wfm_theme_options_group', 'wfm_theme_options', 'wfm_theme_options_sanitize' );

	// $id, $title, $callback, $page
	add_settings_section( 'wfm_theme_options_id', 'Секция Опции темы', '', 'wfm-theme-options' );
	// $id, $title, $callback, $page, $section, $args
	add_settings_field( 'wfm_theme_options_body', 'Цвет фона', 'wfm_page_theme_body_cb', 'wfm-theme-options', 'wfm_theme_options_id' , array('label_for' => 'wfm_theme_options_body') );
	add_settings_field( 'wfm_theme_options_header', 'Цвет header', 'wfm_page_theme_header_cb', 'wfm-theme-options', 'wfm_theme_options_id', array('label_for' => 'wfm_theme_options_header') );
}

function wfm_page_theme_body_cb(){
	$options = get_option('wfm_theme_options');
	?>

<input type="text" name="wfm_theme_options[wfm_theme_options_body]" id="wfm_theme_options_body" value="<?php echo esc_attr($options['wfm_theme_options_body']); ?>" class="regular-text">

	<?php
}

function wfm_page_theme_header_cb(){
	$options = get_option('wfm_theme_options');
	?>

<input type="text" name="wfm_theme_options[wfm_theme_options_header]" id="wfm_theme_options_header" value="<?php echo esc_attr($options['wfm_theme_options_header']); ?>" class="regular-text">

	<?php
}

function wfm_theme_options_sanitize($options){
	$clean_options = array();
	foreach($options as $k => $v){
		$clean_options[$k] = strip_tags($v);
	}
	return $clean_options;
}

function wfm_admin_menu(){
	// $page_title, $menu_title, $capability, $menu_slug, $function
	add_options_page( 'Опции темы (title)', 'Опции темы', 'manage_options', 'wfm-theme-options', 'wfm_option_page' );
}

function wfm_option_page(){
	$options = get_option( 'wfm_theme_options' );
	?>

<div class="wrap">
	<h2>Опции темы</h2>
	<p>Настройки темы плагина Options &amp; Settings API</p>
	<form action="options.php" method="post">
		<?php settings_fields( 'wfm_theme_options_group' ); ?>
		<?php do_settings_sections( 'wfm-theme-options' ); ?>
		<?php submit_button(); ?>
	</form>
</div>

	<?php
}