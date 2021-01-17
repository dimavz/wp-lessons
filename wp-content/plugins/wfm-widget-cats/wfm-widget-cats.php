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

	function form($instance){
		extract($instance);
		$title = !empty($title) ? esc_attr($title) : '';
		$eventType = isset($eventType) ? $eventType : 'hover';
		$hoverDelay = isset($hoverDelay) ? $hoverDelay : 100;
		$speed = isset($speed) ? $speed : 400;
		$exclude = isset($exclude) ? $exclude : '';

		?>
		
<p>
	<label for="<?php echo $this->get_field_id('title') ?>">Заголовок:</label>
	<input type="text" name="<?php echo $this->get_field_name('title') ?>" id="<?php echo $this->get_field_id('title') ?>" value="<?php echo $title; ?>" class="widefat">
</p>

<p>
	<label for="<?php echo $this->get_field_id('eventType') ?>">Способ раскрытия:</label>
	<select class="widefat" name="<?php echo $this->get_field_name('eventType') ?>" id="<?php echo $this->get_field_id('eventType') ?>">
		<option value="click" <?php selected( 'click', $eventType, true ); ?>>По клику</option>
		<option value="hover" <?php selected( 'hover', $eventType, true ); ?>>При наведении</option>
	</select>
</p>

<p>
	<label for="<?php echo $this->get_field_id('hoverDelay') ?>">Пауза перед раскрытием (в мс):</label>
	<input type="text" name="<?php echo $this->get_field_name('hoverDelay') ?>" id="<?php echo $this->get_field_id('hoverDelay') ?>" value="<?php echo $hoverDelay; ?>" class="widefat">
</p>

<p>
	<label for="<?php echo $this->get_field_id('speed') ?>">Скорость анимации (в мс):</label>
	<input type="text" name="<?php echo $this->get_field_name('speed') ?>" id="<?php echo $this->get_field_id('speed') ?>" value="<?php echo $speed; ?>" class="widefat">
</p>

<p>
	<label for="<?php echo $this->get_field_id('exclude') ?>">Исключить категории (ID категорий через запятую):</label>
	<input type="text" name="<?php echo $this->get_field_name('exclude') ?>" id="<?php echo $this->get_field_id('exclude') ?>" value="<?php echo $exclude; ?>" class="widefat">
</p>

		<?php
	}

	function widget($args, $instance){
		extract($args);
		extract($instance);

		add_action( 'wp_footer', array( $this, 'wfm_styles_scripts' ) );

		$title = apply_filters( 'widget_title', $title );

		// add_filter( 'wp_list_categories', array( $this, 'wfm_remove_title' ) );

		$cats = wp_list_categories(
			array(
				'title_li' => '',
				'echo' => false,
				// 'exclude' => $exclude
			)
		);

		$cats = preg_replace('#title="[^"]+"#', '', $cats);

		$html = $before_widget;
		$html .= $before_title . $title . $after_title;
		$html .= '<ul class="accordion">';
		$html .= $cats;
		$html .= '</ul>';
		$html .= $after_widget;
		echo $html;
	}

	function wfm_styles_scripts(){
		wp_register_script( 'wfm-cookie', plugins_url( 'js/jquery.cookie.js', __FILE__ ), array('jquery') );
		wp_register_script( 'wfm-hoverIntent', plugins_url( 'js/jquery.hoverIntent.minified.js', __FILE__ ), array('wfm-cookie') );
		wp_register_script( 'wfm-accordion', plugins_url( 'js/jquery.accordion.js', __FILE__ ), array('wfm-hoverIntent') );
		wp_register_script( 'wfm-main-scripts', plugins_url( 'js/wfm-main-scripts.js', __FILE__ ), array('wfm-accordion') );

		wp_enqueue_script( 'wfm-main-scripts' );
	}

	/*function wfm_remove_title($str){
		$str = preg_replace('#title="[^"]+"#', '', $str);
		return $str;
	}*/

}