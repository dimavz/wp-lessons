<?php
/*
Plugin Name: Плагин тестового шорткода
Description: Для вывода шорткода используйте: [test name="Nicolay" login="nicola"]Контент шоркода[/test]
Plugin URI: http://webformyself.com
Author: Дмитрий
Author URI: http://webformyself.com
*/

add_shortcode( 'test', 'wfm_test' );

function wfm_test($atts, $content){

//   return "Привет, {$atts['name']}! Ваш логин: {$atts['login']}";

//	$content = !empty($content) ? $content : 'Нет данных';
//	$user = isset($atts['name']) ? $atts['name'] : 'No Name';
//	$login = isset($atts['login']) ? $atts['login'] : 'No Login';
	$atts = shortcode_atts(
		array(
			'name' => 'Name',
			'login' => 'login',
			'content' => !empty($content) ? $content : 'Данные шорткода:'
		), $atts
	);
	extract($atts);
	return "<h3>{$content}</h3><p>Привет, {$name}! Ваш логин: {$login}</p>";
}