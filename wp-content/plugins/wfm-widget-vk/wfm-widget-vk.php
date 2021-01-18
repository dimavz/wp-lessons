<?php
/*
Plugin Name: Записи со стены Вконтакте
Description: Плагин создает Виджет, получающий записи со стены Вконтакте
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

add_action( 'widgets_init', 'wfm_vk' );
add_action( 'wp_enqueue_scripts', 'wfm_styles' );

function wfm_styles(){
	wp_enqueue_style( 'wfm-style', plugins_url( 'wfm-style.css', __FILE__ ) );
}

function wfm_vk(){
	register_widget( 'WFM_Vk' );
}

class WFM_Vk extends WP_Widget{

	public $title, $count;

	function __construct(){
		$args = array(
			'description' => 'Виджет, получает записи со стены Вконтакте'
		);
		parent::__construct('wfm_vk', 'Записи со стены Вконтакте', $args);
	}

	function form($instance){
		extract($instance);
		$title = !empty($title) ? esc_attr($title) : '';
		$count = isset($count) ? $count : 3;

		?>

<p>
	<label for="<?php echo $this->get_field_id('title') ?>">Страница Вконтакте (ID или короткий адрес)</label>
	<input type="text" name="<?php echo $this->get_field_name('title') ?>" id="<?php echo $this->get_field_id('title') ?>" value="<?php echo $title; ?>" class="widefat">
</p>

<p>
	<label for="<?php echo $this->get_field_id('count') ?>">Кол-во записей (максимум 100)</label>
	<input type="text" name="<?php echo $this->get_field_name('count') ?>" id="<?php echo $this->get_field_id('count') ?>" value="<?php echo $count; ?>" class="widefat">
</p>

		<?php
	}

	function widget($args, $instance){
		extract($args);
		extract($instance);

		$this->title = $title;
		$this->count = $count;
		$data = $this->wfm_get_posts_vk();

		if( $data === false ){
			$data = 'Ошибка!';
		}elseif( empty($data) ){
			$data = 'Нет записей для вывода';
		}

		echo $before_widget;
		echo $before_title . "Записи со стены $title" . $after_title;
		echo $data;
		echo $after_widget;
	}

	function update($new_instance, $old_instance){
		$new_instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
		$new_instance['count'] = ( (int)$new_instance['count'] ) ? $new_instance['count'] : 5;
		return $new_instance;
	}

	private function wfm_get_posts_vk(){
		// http://api.vk.com/method/wall.get?{$id}&filter=owner&count={$count}
		if( is_numeric($this->title) ){
			$id = "owner_id={$this->title}";
			$this->title = "id{$this->title}";
		}else{
			$id = "domain={$this->title}";
		}
		if( !(int)$this->count ) $this->count = 3;
		$url = "http://api.vk.com/method/wall.get?{$id}&filter=owner&count={$this->count}";
		$vk_posts = wp_remote_get( $url );
//		echo '<pre>';
//		print_r($vk_posts);
//		echo '</pre>';
//		exit();
		$vk_posts = json_decode($vk_posts['body']);

		if( isset($vk_posts->error) ) return false;

		$html = '<div class="wfm-vk">';
		foreach($vk_posts->response as $item){
			if( !empty($item->text) ){
				$text = $this->wfm_substr($item->text);
				$html .= "<div><a href='http://vk.com/{$this->title}' target='_blank'>{$text}</a></div>";
			}elseif( !empty($item->attachment->photo->src_small) ){
				$html .= "<div><a href='http://vk.com/{$this->title}' target='_blank'><img src='{$item->attachment->photo->src_small}' alt=''></a></div>";
			}
		}
		$html .= '</div>';

		return $html;
	}

	private function wfm_substr($str){
		$str_arr = explode(' ', $str);
		$str_arr2 = array_slice($str_arr, 0, 10);
		$str = implode(' ', $str_arr2);
		if( count($str_arr) > 10 ){
			$str .= '...';
		}
		return $str;
	}

}