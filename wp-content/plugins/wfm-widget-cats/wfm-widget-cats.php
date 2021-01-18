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

	public $wfm_cats_array;

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

		$this->wfm_cats_array = array(
			'eventType' => $eventType,
			'hoverDelay' => $hoverDelay,
			'speed' => $speed
		);

		add_action( 'wp_footer', array( $this, 'wfm_styles_scripts' ) );

		$title = apply_filters( 'widget_title', $title );

		// add_filter( 'wp_list_categories', array( $this, 'wfm_remove_title' ) );

		$cats = wp_list_categories(
			array(
				'title_li' => '',
				'echo' => false,
				'exclude' => $exclude
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

	function update($new_instance, $old_instance){
		$new_instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
		$new_instance['eventType'] = ($new_instance['eventType'] == 'click') ? 'click' : 'hover';
		$new_instance['hoverDelay'] = ( (int)$new_instance['hoverDelay'] ) ? $new_instance['hoverDelay'] : 100;
		$new_instance['speed'] = ( (int)$new_instance['speed'] ) ? $new_instance['speed'] : 400;
		$new_instance['exclude'] = !empty($new_instance['exclude']) ? $new_instance['exclude'] : '';
		return $new_instance;
	}

	function wfm_styles_scripts(){
		wp_register_script( 'wfm-cookie', plugins_url( 'js/jquery.cookie.js', __FILE__ ), array('jquery') );
		wp_register_script( 'wfm-hoverIntent', plugins_url( 'js/jquery.hoverIntent.minified.js', __FILE__ ), array('wfm-cookie') );
		wp_register_script( 'wfm-accordion', plugins_url( 'js/jquery.accordion.js', __FILE__ ), array('wfm-hoverIntent') );
		wp_register_script( 'wfm-main-scripts', plugins_url( 'js/wfm-main-scripts.js', __FILE__ ), array('wfm-accordion') );
		wp_register_style( 'wfm-style', plugins_url( 'css/wfm-style.css', __FILE__ ) );

		wp_enqueue_script( 'wfm-main-scripts' );
		wp_localize_script( 'wfm-main-scripts', 'wfm_obj', $this->wfm_cats_array );
		wp_enqueue_style( 'wfm-style' );
	}

	/*function wfm_remove_title($str){
		$str = preg_replace('#title="[^"]+"#', '', $str);
		return $str;
	}*/

}