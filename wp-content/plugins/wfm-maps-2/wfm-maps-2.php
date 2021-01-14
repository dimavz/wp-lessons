<?php
/*
Plugin Name: Карты Google v.2
Description: Пример шорткода: [map cords1="50.447312" cords2="30.526511" zoom="17"]
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

add_shortcode( 'map', 'wfm_map_2' );
$wfm_maps_array = array();

function wfm_map_2($atts){
	global $wfm_maps_array;
//	print_r($atts);
	$atts = shortcode_atts(
		array(
			'cords1' => 50.447312,
			'cords2' => 30.526511,
			'zoom' => 8
		), $atts
	);

	extract($atts);
	$wfm_maps_array = array(
		'zoom' => $zoom,
		'cords1' => $cords1,
		'cords2' => $cords2
	);

	add_action( 'wp_footer', 'wfm_styles_scripts' );
	return '<div id="map-canvas" style="width: 650px; height: 400px;"></div>';
}

function wfm_styles_scripts(){
	global $wfm_maps_array;
	wp_register_script( 'wfm-maps-google', 'http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false' );
	wp_register_script( 'wfm-maps-2', plugins_url( 'wfm-maps-2.js', __FILE__ ) );

	wp_enqueue_script( 'wfm-maps-google' );
	wp_enqueue_script( 'wfm-maps-2' );

	wp_localize_script( 'wfm-maps-2', 'wfmObj', $wfm_maps_array );
}