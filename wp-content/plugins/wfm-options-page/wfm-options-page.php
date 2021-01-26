<?php
/*
Plugin Name: Options & Settings API
Description: Изучаем API опций и настроек. Собственная страница настроек
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

add_action( 'admin_menu', 'wfm_admin_menu' );

function wfm_admin_menu(){
	// $page_title, $menu_title, $capability, $menu_slug, $function
	add_options_page( 'Опции темы (title)', 'Опции темы', 'manage_options', 'wfm-theme-options', 'wfm_option_page' );
}

function wfm_option_page(){
	if( !empty($_POST) && check_admin_referer('wfm-theme-options') ){
		update_option( 'wfm_theme_options', array(
				'wfm_theme_options_body' => $_POST['wfm_theme_options']['wfm_theme_options_body'],
				'wfm_theme_options_header' => $_POST['wfm_theme_options']['wfm_theme_options_header']
			)
		);
		echo '<div class="updated"><p><strong>Настройки сохранены.</strong></p></div>';
	}
	$options = get_option( 'wfm_theme_options' );
	?>

<div class="wrap">
	<h2>Опции темы</h2>
	<p>Настройки темы плагина Options &amp; Settings API</p>
	<form action="" method="post">
		<?php wp_nonce_field('wfm-theme-options');
		// Получает или выводит скрытое одноразовое поле (nonce) для формы.
		// Одноразовое поле (nonce) нужно для проверки передаваемых данных формы,
        // чтобы убедиться, что данные были отправлены с текущего сайта, а не от куда-то еще.
        // Такое поле не дает полной защиты, но защищает в большинстве случаев.
        // Использовать проверочное поле в формах обязательно!
        ?>
		<p>
			<label for="wfm_theme_options_body">Цвет фона</label>
			<input type="text" name="wfm_theme_options[wfm_theme_options_body]" id="wfm_theme_options_body" value="<?php echo esc_attr($options['wfm_theme_options_body']); ?>" class="regular-text">
		</p>
		<p>
			<label for="wfm_theme_options_header">Цвет header</label>
			<input type="text" name="wfm_theme_options[wfm_theme_options_header]" id="wfm_theme_options_header" value="<?php echo esc_attr($options['wfm_theme_options_header']); ?>" class="regular-text">
		</p>
		<?php submit_button(); ?>
	</form>
</div>

	<?php
}