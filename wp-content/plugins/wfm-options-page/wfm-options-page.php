<?php
/*
Plugin Name: Options & Settings API
Description: Изучаем API опций и настроек. Собственная страница настроек
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

/*
 * Ссылки по теме:
 * https://wp-kama.ru/function/current_user_can#bazovyj-spisok-prav  объяснение прав параметра capability
 * https://wp-kama.ru/function-cat/admin-panel - функции для добавления страниц а админ-панели
 * */

add_action( 'admin_menu', 'wfm_admin_menu' );

function wfm_admin_menu(){
	// $page_title, $menu_title, $capability, $menu_slug, $function
	add_options_page( 'Опции темы (title)', 'Опции темы', 'manage_options', 'wfm-theme-options', 'wfm_option_page' );
//	add_dashboard_page('Опции темы (title)', 'Опции темы', 'manage_options', 'wfm-theme-options', 'wfm_option_page');
//	add_theme_page('Опции темы (title)', 'Опции темы', 'manage_options', 'wfm-theme-options', 'wfm_option_page');
}

function wfm_option_page(){
//    echo "Привет,Мир!";
	if( isset($_POST['wfm_hidden']) && $_POST['wfm_hidden'] == 'wfm_hidden' ){
		print_r($_POST);
	}
	?>

<div class="wrap">
	<h2>Опции темы</h2>
	<p>Настройки темы плагина Options &amp; Settings API</p>
	<form action="" method="post">
		<input type="hidden" name="wfm_hidden" value="wfm_hidden">
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