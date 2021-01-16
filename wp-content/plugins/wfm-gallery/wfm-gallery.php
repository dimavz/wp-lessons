<?php
/*
Plugin Name: Галерея
Description: Используйте шорткод вида: [gallery ids="1,2,3"], где в атрибуте ids указывайте ID картинок
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

remove_shortcode( 'gallery' );
add_shortcode( 'gallery', 'wfm_gallery' );
add_action( 'wp_enqueue_scripts', 'wfm_styles_scripts_gallery' );

function wfm_styles_scripts_gallery(){
	wp_register_script( 'wfm-lightbox-js', plugins_url( 'js/lightbox.min.js', __FILE__ ), array('jquery') );
	wp_register_style( 'wfm-lightbox', plugins_url( 'css/lightbox.css', __FILE__ ) );
	wp_register_style( 'wfm-lightbox-style', plugins_url( 'css/lightbox-style.css', __FILE__ ) );

	wp_enqueue_script( 'wfm-lightbox-js' );
	wp_enqueue_style( 'wfm-lightbox' );
	wp_enqueue_style( 'wfm-lightbox-style' );
}

function wfm_gallery($atts){
	$img_id = explode(',', $atts['ids']);
	if( !$img_id[0] ) return '<div class="wfm-gallery">В галерее нет картинок</div>';
	$html = '<div class="wfm-gallery">';
	foreach($img_id as $item){
		$img_data = get_posts( array(
			'p' => $item,
			'post_type' => 'attachment'
		) );

		$img_desc = $img_data[0]->post_content;
		$img_caption = $img_data[0]->post_excerpt;
		$img_title = $img_data[0]->post_title;
		$img_thumb = wp_get_attachment_image_src( $item );
		$img_full = wp_get_attachment_image_src( $item, 'full' );

		$html .= "<a href='{$img_full[0]}' data-lightbox='gallery' data-title='{$img_caption}'><img src='{$img_thumb[0]}' width='{$img_thumb[1]}' height='{$img_thumb[2]}' alt='{$img_title}'></a>";
	}
	$html .= '</div>';
	return $html;
}