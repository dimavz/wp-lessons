<?php
/*
Plugin Name: Google карты для сайта
Description: Для вывода карты используйте шорткод вида: [map center="город,область,страна" width="600" height="300" zoom="13"]Описание карты[/map]
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

add_shortcode( 'map', 'wfm_map' );

function wfm_map($atts, $content){
	$atts = shortcode_atts(
		array(
			'center' => 'Киев, город Киев, Украина',
			'width' => 600,
			'height' => 300,
			'zoom' => 13,
			'content' => !empty($content) ? "<h2>$content</h2>" : "<h2>Карта от Гугл</h2>"
		), $atts
	);
	$atts['size'] = $atts['width'] . 'x' . $atts['height'];
	$atts['center'] = str_replace(' ', '+', $atts['center']);
	extract($atts);

	$map = $content;
	$map .= '<img src="http://maps.googleapis.com/maps/api/staticmap?center=' . $center . '&zoom=' . $zoom . '&size=' . $size . '&sensor=false" alt="">';
	return $map;
}