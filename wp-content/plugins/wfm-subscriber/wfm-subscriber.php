<?php
/*
Plugin Name: Сбор подписчиков
Description: Плагин предоставляет виджет, позволяющий собирать подписчиков
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

include dirname(__FILE__) . '/wfm_widget_class.php';
include dirname(__FILE__) . '/wfm_ajax_funcs.php';
include dirname(__FILE__) . '/wfm_helpers.php';

register_activation_hook( __FILE__, 'wfm_create_table' );
add_action( 'widgets_init', 'wfm_widget_subscriber' );
add_action( 'wp_ajax_wfm_subscriber', 'wfm_ajax_subscriber' );
add_action( 'wp_ajax_nopriv_wfm_subscriber', 'wfm_ajax_subscriber' );
add_action( 'admin_menu', 'wfm_admin_menu' );

function wfm_create_table(){
	global $wpdb;
	$query = "CREATE TABLE IF NOT EXISTS `wfm_subscriber` (
		`subscriber_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`subscriber_name` varchar(50) NOT NULL,
		`subscriber_email` varchar(50) NOT NULL,
		PRIMARY KEY (`subscriber_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$wpdb->query($query);
}

function wfm_widget_subscriber(){
	register_widget( 'WFM_Widget_Subscriber' );
}

function wfm_subscriber_scripts(){
	wp_register_script( 'wfm-subscriber', plugins_url( 'js/wfm-subscriber.js', __FILE__ ), array('jquery') );
	wp_enqueue_script( 'wfm-subscriber' );
	wp_localize_script( 'wfm-subscriber', 'wfmajax', array( 'url' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'wfmajax' ) ) );
}

function wfm_admin_menu(){
	add_options_page( 'Подписчики', 'Подписчики', 'manage_options', 'wfm-subscriber', 'wfm_subscriber_page' );
	add_action( 'admin_enqueue_scripts', 'wfm_admin_scripts' );
}

function wfm_admin_scripts($hook){
	if( $hook != 'settings_page_wfm-subscriber' ) return;
	wp_enqueue_style( 'wfm-style', plugins_url( 'css/wfm-subscriber.css', __FILE__ ) );
	wp_enqueue_script( 'wfm-admin-scripts', plugins_url( 'js/wfm-subscriber-admin.js', __FILE__ ), array('jquery') );	
}

function wfm_subscriber_page(){
	?>
<div class="wrap">
	<h2>Подписчики</h2>
	<?php $subscribers = get_subscribers(); ?>

	<?php if(!empty($subscribers)): ?>
		<p><b>Кол-во подписчиков: <?php echo count($subscribers)?></b></p>

<table class="wp-list-table widefat fixed posts" id="wfm-table">
	<thead>
		<tr>
			<td>ID</td>
			<td>Имя</td>
			<td>Email</td>
		</tr>
	</thead>
	<tbody>
	<?php foreach($subscribers as $subscriber): ?>
		<tr>
			<td><?php echo $subscriber['subscriber_id']; ?></td>
			<td><?php echo $subscriber['subscriber_name']; ?></td>
			<td><?php echo $subscriber['subscriber_email']; ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<p>
	<label for="wfm_text">Текст рассылки (для имени используйте шаблон %name%)</label> <br>
	<textarea name="wfm_text" id="wfm_text" cols="30" rows="10" class="widefat wfm-text"></textarea>
</p>

<button class="btn" id="btn">Сделать рассылку</button>
<span id="loader" style="display: none;"><img src="<?php echo plugins_url( 'img/loader.gif', __FILE__ ); ?>" alt=""></span>
<div id="res"></div>

	<?php else: ?>
		<p>Список подписчиков пуст</p>
	<?php endif; ?>
</div>
	<?php
}