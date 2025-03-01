<?php
// Customizer
//$options = get_theme_mods(); // Получение всех опций кастомайзера
//$option = get_theme_mod('background_image'); // Получение конкретной опции кастомайзера по названию опции
//echo '<pre>';
//print_r($option);
//echo '</pre>';
//exit();

function test_customizer_init(WP_Customize_Manager $wp_customize){

    //Создаем новую панель. Обратите внимание, что если в панели нет ни одной секции, она не отобразится.

    $p_args = array(
        'title'=>__( 'Моя кастомная панель настроек темы', 'mytesttheme' ),
        'description'=>__( 'Моя тестовая панель настроек', 'mytesttheme' ),
    );

    $wp_customize->add_panel('mytheme_custom_panel',$p_args);

    // Создаём секцию и привязываем её к панели
    $wp_customize->add_section(
        'decoration',       // id секции
        array(
            'title'       => __( 'Моя секция', 'mytesttheme' ),
            'description' => __( 'Описание моей секции', 'mytesttheme' ),
            'priority'    => 10,
//            'panel'       => 'mytheme_custom_panel'  // id родительской панели Если раскоментировать строку, то секция будет выводиться в панеле
        )
    );

    $wp_customize->add_setting('mytesttheme_link_color', array(
        'default' => '#007bff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'=>'postMessage',
    ));
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'mytesttheme_link_color',
            array(
                'label' => __( 'Цвет ссылок', 'mytesttheme' ),
//                'section' => 'colors',
//                'section' => 'title_tagline',
                'section' => 'decoration',
                'setting' => 'mytesttheme_link_color',
            )
        )
    );

    // custom section
    $wp_customize->add_section('test_site_data', array(
        'title' => __( 'Информация сайта', 'mytesttheme' ),
        'priority' => 10,
    ));
    $wp_customize->add_setting('test_phone', array(
        'default' => '',
        'transport'=>'postMessage',
    ));
    $wp_customize->add_control(
        'test_phone',
        array(
            'label' => __( 'Телефон', 'mytesttheme' ),
            'section' => 'test_site_data',
            'type' => 'text',
        )
    );

    $wp_customize->add_setting('test_show_phone', array(
        'default' => true,
        'transport'=>'postMessage',
    ));
    $wp_customize->add_control(
        'test_show_phone',
        array(
            'label' => __( 'Показывать телефон', 'mytesttheme' ),
            'section' => 'test_site_data',
            'type' => 'checkbox',
        )
    );
}
add_action('customize_register', 'test_customizer_init');

function test_customize_css(){
$test_link_color = get_theme_mod('mytesttheme_link_color'); // Получение конкретной опции кастомайзера по названию опции
echo <<<HEREDOC
<style type="text/css">
a { color: $test_link_color; }
</style>
HEREDOC;

/**/?><!--
    <style type="text/css">
        a { color: <?php /*echo get_theme_mod('test_link_color'); */?>; }
    </style>
    --><?php
}
add_action('wp_head', 'test_customize_css');

function mytesttheme_customize_js(){
    $deps = array('jquery','customize-preview'); // Массив зависимых скриптов, после которых должен загружаться наш скрипт
    wp_enqueue_script('setting_link_customizer',get_template_directory_uri().'/assets/js/mytesttheme-customize.js',$deps,'',true);
}

add_action('customize_preview_init','mytesttheme_customize_js'); // Подключаем нашу функцию по хуку
