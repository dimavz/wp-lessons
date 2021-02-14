<?php
/*
Plugin Name: Сбор подписчиков 2
Description: Плагин предоставляет виджет, позволяющий собирать подписчиков, а также позволяет осуществлять рассылку подписчикам
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

include dirname(__FILE__) . '/wfm_widget_class.php';
include dirname(__FILE__) . '/wfm_ajax_funcs.php';
include dirname(__FILE__) . '/wfm_helpers.php';
include dirname(__FILE__) . '/wfm-subscriber-subpage.php';
include dirname(__FILE__) . '/wfm-subscriber-schedule.php'; // Подключаем файл с дополнительными интервалами для расписаний крона

register_activation_hook( __FILE__, 'wfm_subscriber_create_table' );
register_deactivation_hook( __FILE__, 'wfm_subscriber_deactivate' );
add_action( 'admin_menu', 'wfm_subscriber_admin_menu' );
add_action( 'admin_init', 'wfm_subscriber_admin_settings' );
add_action( 'widgets_init', 'wfm_widget_subscriber' );

function wfm_subscriber_create_table(){
	global $wpdb;
	$query = "CREATE TABLE IF NOT EXISTS `wfm_subscriber` (
		`subscriber_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`subscriber_name` varchar(50) NOT NULL,
		`subscriber_email` varchar(50) NOT NULL,
		`text` text NOT NULL,
		`send` enum('0','1','2') NOT NULL DEFAULT '0',
		PRIMARY KEY (`subscriber_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$wpdb->query($query);
	update_option( 'wfm_subscriber_options', array(
		'perpage' => 5,
		'limit' => 50,
		'schedule' => 3600
	) );
}

function wfm_subscriber_deactivate(){

}

function wfm_widget_subscriber(){
	register_widget( 'WFM_Widget_Subscriber' );
}

function wfm_subscriber_admin_menu(){
	// $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position
	add_menu_page( 'Настройки плагина Рассылка', 'Рассылка', 'manage_options', 'wfm-subscriber-options', 'wfm_subscriber_options_menu', 'dashicons-email-alt' );

	// $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function
	add_submenu_page( 'wfm-subscriber-options', 'Параметры', 'Параметры', 'manage_options', 'wfm-subscriber-options', 'wfm_subscriber_options_menu' );
	add_submenu_page( 'wfm-subscriber-options', 'Подписчики', 'Подписчики', 'manage_options', 'wfm-subscriber-subpage', 'wfm_subscriber_subpage' );

	add_action( 'admin_enqueue_scripts', 'wfm_admin_scripts' );
}

function wfm_subscriber_admin_settings(){
	// $option_group, $option_name, $sanitize_callback
	register_setting( 'wfm_group', 'wfm_subscriber_options', 'wfm_subscriber_sanitize' );

	// $id, $title, $callback, $page
	add_settings_section( 'wfm_subscriber_section_id', 'Настройки плагина подписки', '', 'wfm-subscriber-options' );

	// $id, $title, $callback, $page, $section, $args
	add_settings_field( 'wfm_setting_perpage_id', 'Кол-во подписчиков на страницу', 'wfm_subscriber_perpage_cb', 'wfm-subscriber-options', 'wfm_subscriber_section_id', array( 'label_for' => 'wfm_setting_perpage_id' ) );

	add_settings_field( 'wfm_setting_subscriber_limit_id', 'Рассылать  кол-во писем за раз', 'wfm_subscriber_limit_cb', 'wfm-subscriber-options', 'wfm_subscriber_section_id', array( 'label_for' => 'wfm_setting_subscriber_limit_id' ) );

	add_settings_field( 'wfm_setting_schedule_id', 'Пауза между частями одной рассылки', 'wfm_subscriber_schedule_cb', 'wfm-subscriber-options', 'wfm_subscriber_section_id', array( 'label_for' => 'wfm_setting_schedule_id' ) );
}

function wfm_subscriber_sanitize($options){
	$clean_options = array();
	$schedule = array(60, 120, 300, 900, 1800, 2700, 3600);
	$clean_options['perpage'] = ( (int)$options['perpage'] > 0 ) ? (int)$options['perpage'] : 2;
	$clean_options['limit'] = ( (int)$options['limit'] > 0 ) ? (int)$options['limit'] : 50;
	if( in_array($options['schedule'], $schedule) ){
		$clean_options['schedule'] = $options['schedule'];
	}else{
		$clean_options['schedule'] = 3600;
	}
	return $clean_options;
}

function wfm_subscriber_perpage_cb(){
	$options = get_option( 'wfm_subscriber_options' );
	?>
<p>
	<input type="text" name="wfm_subscriber_options[perpage]" id="wfm_setting_perpage_id" value="<?php echo $options['perpage'] ?>" class="regular-text">
</p>
	<?php
}

function wfm_subscriber_limit_cb(){
	$options = get_option( 'wfm_subscriber_options' );
	?>
<p>
	<input type="text" name="wfm_subscriber_options[limit]" id="wfm_setting_subscriber_limit_id" value="<?php echo $options['limit'] ?>" class="regular-text">
</p>
	<?php
}

function wfm_subscriber_schedule_cb(){
	$options = get_option( 'wfm_subscriber_options' );
	?>
<p>
	<select name="wfm_subscriber_options[schedule]" id="wfm_setting_schedule_id">
		<option value="60" <?php selected( '60', $options['schedule'], true ); ?>>1 минута</option>
		<option value="120" <?php selected( '120', $options['schedule'], true ); ?>>2 минуты</option>
		<option value="300" <?php selected( '300', $options['schedule'], true ); ?>>5 минут</option>
		<option value="900" <?php selected( '900', $options['schedule'], true ); ?>>15 минут</option>
		<option value="1800" <?php selected( '1800', $options['schedule'], true ); ?>>30 минут</option>
		<option value="2700" <?php selected( '2700', $options['schedule'], true ); ?>>45 минут</option>
		<option value="3600" <?php selected( '3600', $options['schedule'], true ); ?>>1 час</option>
	</select>
</p>
	<?php
}

function wfm_subscriber_options_menu(){
	?>
<div class="wrap">
	<h2>Настройки плагина</h2>
	<form action="options.php" method="post">
		<?php settings_fields( 'wfm_group' ); ?>
		<?php do_settings_sections( 'wfm-subscriber-options' ); ?>
		<?php submit_button(); ?>
	</form>
</div>
	<?php
}