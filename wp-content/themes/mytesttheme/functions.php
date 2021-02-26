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
    add_theme_support( 'post-thumbnails' );
    // Если нас не устраивают стандартные размеры картинок [thumbnail, medium, large, full], то мы можем добавить свой
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


