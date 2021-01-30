<?php

class WFM_Widget_Subscriber extends WP_Widget{

	function __construct(){
		$args = array(
			'name' => 'Виджет подписки',
			'description' => 'Виджет выводит форму для ввода имени и email подписчика',
			'classname' => 'wfm-subscriber'
		);
		parent::__construct('wfm_subscriber', '', $args);
	}

	function widget($args, $instance){
            echo "Виджет подписки";
	}

	function form($instance){

	}

}