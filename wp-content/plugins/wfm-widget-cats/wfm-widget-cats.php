<?php
/*
Plugin Name: Виджет Рубрики: Аккордеон
Description: Виджет выводит меню категорий в виде аккордеона
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

add_action( 'widgets_init', 'wfm_cats' );

function wfm_cats(){
	register_widget( 'WFM_Cats' );
}

class WFM_Cats extends WP_Widget{

	function __construct(){
		$args = array(
			'name' => 'Рубрики: Аккордеон',
			'description' => 'Виджет выводит меню категорий в виде аккордеона'
		);
		parent::__construct('wfm_cats', '', $args);
	}

	function widget($args, $instance){
		extract($args);
		extract($instance);

		$title = apply_filters( 'widget_title', $title );

		$cats = wp_list_categories(
			array(
				'title_li' => '',
				'echo' => false,
				// 'exclude' => $exclude
			)
		);

		$html = $before_widget;
		$html .= $before_title . $title . $after_title;
		$html .= '<ul class="accordion">';
		$html .= $cats;
		$html .= '</ul>';
		$html .= $after_widget;
		echo $html;
	}

}