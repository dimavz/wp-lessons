<?php
/*
Plugin Name: Options & Settings API
Description: Изучаем API опций и настроек. Собственная страница настроек
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

add_action('admin_menu', 'wfm_admin_menu');
add_action('admin_init', 'wfm_admin_settings');

function wfm_admin_settings()
{
    // $option_group, $option_name, $sanitize_callback
    register_setting('wfm_theme_options_group', 'wfm_theme_options', 'wfm_theme_options_sanitize');
}

function wfm_theme_options_sanitize($options)
{
    $clean_options = array();
    foreach ($options as $k => $v) {
        $clean_options[$k] = strip_tags($v);
    }
    return $clean_options;
}

function wfm_admin_menu()
{
    // $page_title, $menu_title, $capability, $menu_slug, $function
    add_options_page('Опции темы (title)', 'Опции темы', 'manage_options', 'wfm-theme-options', 'wfm_option_page');
}

function wfm_option_page()
{
    $options = get_option('wfm_theme_options');
    ?>

    <div class="wrap">
        <h2>Опции темы</h2>
        <p>Настройки темы плагина Options &amp; Settings API</p>
        <form action="options.php" method="post">
            <?php settings_fields('wfm_theme_options_group');
            // Выводит скрытые поля формы на странице настроек (option_page, _wpnonce, ...).
            //Функция используется в связке с функциями из API настроек. В её задачи входит вывод всех необходимых полей для правильной работы и защиты формы.
            ?>
            <p>
                <label for="wfm_theme_options_body">Цвет фона</label>
                <input type="text" name="wfm_theme_options[wfm_theme_options_body]" id="wfm_theme_options_body"
                       value="<?php echo esc_attr($options['wfm_theme_options_body']); ?>" class="regular-text">
            </p>
            <p>
                <label for="wfm_theme_options_header">Цвет header</label>
                <input type="text" name="wfm_theme_options[wfm_theme_options_header]" id="wfm_theme_options_header"
                       value="<?php echo esc_attr($options['wfm_theme_options_header']); ?>" class="regular-text">
            </p>
            <?php submit_button(); ?>
        </form>
    </div>

    <?php
}