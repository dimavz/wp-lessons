<?php
// Подключение класса для кастомизации вывода меню
require __DIR__ . '/assets/helpers/walker_menu.php';
/*
 * Подключение скриптов и стилей
 */

function test_scripts(){
    wp_enqueue_style('test-bootstrapcss', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css');
    wp_enqueue_style('test-style', get_stylesheet_uri());

    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array(), false, true);
    //wp_enqueue_script( 'jquery' );
    wp_enqueue_script('test-popper', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array('jquery'), false, true);
    wp_enqueue_script('test-bootstrapjs', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array('jquery'), false, true);
}
add_action('wp_enqueue_scripts', 'test_scripts');

// Добавляем фильтр для удаления ненужных размеров при загрузке картинки
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
    // размеры которые нужно удалить
    return array_diff( $sizes, [
        'medium_large',
        'large',
        '1536x1536',
        '2048x2048',
    ] );
}

// Регистрирует поддержку новых возможностей темы в WordPress
//add_theme_support( $feature, $formats );

//Позволяет устанавливать миниатюру посту. Доступна с версии 2.9.
// Вы можете передать второй аргумент функции в виде массива, в котором указать для каких типов постов разрешить миниатюры:
//add_theme_support( 'post-thumbnails' );
//add_theme_support( 'post-thumbnails', array( 'post' ) );          // Только для post
//add_theme_support( 'post-thumbnails', array( 'page' ) );          // Только для page
//add_theme_support( 'post-thumbnails', array( 'post', 'movie' ) ); // Для post и movie типов

add_action('after_setup_theme','mytesttheme_setup');
function mytesttheme_setup(){
    //Включаем поддержку темой миниатюр картинок в записях (посты, страницы)
    add_theme_support( 'post-thumbnails' );
    // Если нас не устраивают стандартные размеры картинок [thumbnail, medium, large, full], то мы можем добавить свой размер картинки
// в functions.php мы регистрируем дополнительный размер картинки так:
    add_image_size( 'spec_thumb', 300, 200, true );
// далее в цикле WP loop выводим этот размер так: the_post_thumbnail( 'spec_thumb' );
    // Добавляем поддержку title страницы. Обязательно в header.php должна быть вызвана функция wp_head();
    add_theme_support( 'title-tag' );
    // Добавляем в тему поддержку меню
    register_nav_menus( array(
        'header_menu' => 'Выводится в шапке',
        'footer_menu' => 'Выводится в футере',
    ) );

    // Добавляем поддержку темой кастомного логотипа в кастомайзере темы;
    $l_params = array(
        'height'      => 150,
        'width'       => 150,
        'flex-width'  => false,
        'flex-height' => false,
        'header-text' => '',
        'unlink-homepage-logo' => false, // WP 5.5
    );
    add_theme_support( 'custom-logo',$l_params );

    //Добавляем поддержку темой кастомного бэграунда в кастомайзере темы. Доступна с версии 3.4.
    $bg_params = array(
        'default-color'          => 'fff',
        'default-image'          => get_template_directory_uri() . '/assets/images/white-ornamic.png',
        'wp-head-callback'       => '_custom_background_cb',
        'admin-head-callback'    => '',
        'admin-preview-callback' => ''
    );
    add_theme_support( 'custom-background', $bg_params );

    //Добавляем поддержку темой кастомного изображения для хэдэра в кастомайзере темы. Доступна с версии 3.4.
    $h_params = array(
        'default-image'          => get_template_directory_uri() . '/assets/images/white-overlay-rings.png',
        'width'                  => 1600,
        'height'                 => 1200,
    );

    add_theme_support( 'custom-header',$h_params);
}

// Меняем шаблон Pagination
add_filter('navigation_markup_template', 'my_navigation_template', 10, 2 );
function my_navigation_template( $template, $class ){
    /*
    Вид базового шаблона:
    <nav class="navigation %1$s" role="navigation" aria-label="%4$s">
		<h2 class="screen-reader-text">%2$s</h2>
		<div class="nav-links">%3$s</div>
	</nav>';
    */

    return '
	<nav class="navigation" role="navigation">
		<div class="nav-links">%3$s</div>
	</nav>    
	';
}

function mytesttheme_widgets_init(){

//    $args = array(
//        'name'          => 'Sidebar %d',
//        'id'            => "sidebar",
//        'before_widget' => '<li id="%1$s" class="widget %2$s">',
//        'after_widget'  => '</li>',
//        'before_title'  => '<h2 class="widgettitle">',
//        'after_title'   => '</h2>'
//    );
//    register_sidebars( 2, $args ); // Регистрирует несколько панелей виджетов (место в админке куда виджеты будут размещаться)

    $args1 = array(
        'name'=>'Правый сайдбар',
        'id'=>'right-sidebar', // Идентификатор панели виджетов, используется в функции dynamic_sidebar() для вывода виджетов
        'description'=>'Область для виджетов в правом сайдбаре',
        'before_widget'  => '',
        'after_widget'   => "\n",
        'class'=>'test2', // Добавляет класс в панель виджета в админке
        'before_title'   => '<h3 class="widgettitle">', // Изменяет заголовок виджета во front-end
        'after_title'    => "</h3>\n",
    );
    $args2 = array(
        'name'=>'Левый сайдбар',
        'id'=>'left-sidebar', // Идентификатор панели виджетов, используется в функции dynamic_sidebar() для вывода виджетов
        'description'=>'Область для виджетов в левом сайдбаре',
        'before_widget'  => '',
        'after_widget'   => "\n",
    );
    register_sidebar($args1); // Регистрирует панель виджетов (место в админке куда виджеты будут размещаться)
    register_sidebar($args2); // Регистрирует панель виджетов (место в админке куда виджеты будут размещаться)
}

add_action('widgets_init','mytesttheme_widgets_init');


