<?php
/*
Plugin Name: Сбор подписчиков 2
Description: Плагин предоставляет виджет, позволяющий собирать подписчиков, а также позволяет осуществлять рассылку подписчикам
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

register_activation_hook( __FILE__, 'wfm_subscriber_create_table' );
register_deactivation_hook( __FILE__, 'wfm_subscriber_deactivate' );
add_action( 'admin_menu', 'wfm_subscriber_admin_menu' );
add_action( 'admin_init', 'wfm_subscriber_admin_settings' );

function wfm_subscriber_create_table(){
	global $wpdb;
	$query = "CREATE TABLE IF NOT EXISTS `wfm_subscriber` (
		`subscriber_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`subscriber_name` varchar(50) NOT NULL,
		`subscriber_email` varchar(50) NOT NULL,
		`text` text,
		`send` enum('0','1','2') NOT NULL DEFAULT '0',
		PRIMARY KEY (`subscriber_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$wpdb->query($query);
}

function wfm_subscriber_deactivate(){

}

function wfm_subscriber_admin_menu(){
	// $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position
	add_menu_page( 'Настройки плагина', 'Подписчики', 'manage_options', 'wfm-subscriber-options', 'wfm_subscriber_options_menu', 'dashicons-groups' );

	// $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function
	add_submenu_page( 'wfm-subscriber-options', 'Подписчики + Рассылка', 'Рассылка', 'manage_options', 'wfm-subscriber-subpage', 'wfm_subscriber_subpage' );
}

function wfm_subscriber_admin_settings(){
	// $option_group, $option_name, $sanitize_callback
	register_setting( 'wfm_group', 'wfm_subscriber_options', 'wfm_subscriber_sanitize' );

	// $id, $title, $callback, $page
	add_settings_section( 'wfm_subscriber_section_id', 'Настройки плагина подписки', '', 'wfm-subscriber-options' );

	// $id, $title, $callback, $page, $section, $args
	add_settings_field( 'wfm_setting_perpage_id', 'Кол-во подписчиков на страницу', 'wfm_subscriber_perpage_cb', 'wfm-subscriber-options', 'wfm_subscriber_section_id', array( 'label_for' => 'wfm_setting_perpage_id' ) );
}

function wfm_subscriber_sanitize(){

}

function wfm_subscriber_perpage_cb(){
	$options = get_option( 'wfm_subscriber_options' );
//	echo '<pre>';
//	print_r($options);
//	echo '</pre>';
//	exit();
	?>
<p>
	<input type="text" name="wfm_subscriber_options[perpage]" id="wfm_setting_perpage_id" value="<?php echo $options['perpage'] ?>" class="regular-text">
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

function wfm_subscriber_subpage(){

}