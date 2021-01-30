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
		add_action( 'wp_footer', 'wfm_subscriber_scripts' );
		extract($args);
		extract($instance);
		$title = apply_filters( 'widget_title', $title );

		echo $before_widget;
		echo $before_title . $title . $after_title;
		?>
<form action="" method="post" id="wfm_form_subscriber">
	<p>
		<label for="wfm_name">Имя:</label>
		<input type="text" name="wfm_name" id="wfm_name">
	</p>
	<p>
		<label for="wfm_email">Email:</label>
		<input type="text" name="wfm_email" id="wfm_email">
	</p>
	<p>
		<input type="submit" id="wfm_submit" name="wfm_submit" value="Подписаться"> <span id="loader" style="display: none;"><img src="<?php echo plugins_url( 'img/loader.gif', __FILE__ ); ?>" alt=""></span><div id="res"></div>
	</p>
</form>
		<?php
		echo $after_widget;
	}

	function form($instance){
		extract($instance);
		?>
<p>
	<label for="<?php echo $this->get_field_id('title'); ?>">Заголовок:</label>
	<input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php if( isset($title) ) echo esc_attr( $title ) ?>" class="widefat">
</p>
		<?php
	}

}