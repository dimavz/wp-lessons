<?php
/*
Plugin Name: Количество просмотров статей
Description: Плагин считает и выводит кол-во просмотров статей
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

include dirname(__FILE__) . '/wfm-check.php';

register_activation_hook( __FILE__, 'wfm_create_field' );
add_filter( 'the_content', 'wfm_post_views' );
add_action( 'wp_head', 'wfm_add_view' );

function wfm_create_field(){
	global $wpdb;

	if( ! wfm_check_field('wfm_views') ){
		$query = "ALTER TABLE $wpdb->posts ADD wfm_views INT NOT NULL DEFAULT '0'";
		$wpdb->query($query);
	}

}

function wfm_post_views($content){
	if( is_page() ) return $content;
	global $post;
	$views = $post->wfm_views;
	if( is_single() ) $views += 1;
	return $content . "<b>Кол-во просмотров: </b>" . $views;
}

function wfm_add_view(){
	if( !is_single() ) return;
	global $post, $wpdb;
	$wfm_id = $post->ID;
	$views = $post->wfm_views + 1;
	$wpdb->update(
		$wpdb->posts,
		array( 'wfm_views' => $views ),
		array( 'ID' => $wfm_id )
	);
}