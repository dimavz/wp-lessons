<?php
/*
Plugin Name: Примеры работы хуков
Description: Несколько примеров работы хуков
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

// http://codex.wordpress.org/Plugin_API/Hooks_2.0.x
// http://adambrown.info/p/wp_hooks/hook


//add_filter( 'the_title', 'wfm_title' );
//
//function wfm_title($title){
//	if( is_admin() ) return $title;
////    return $title = mb_strtoupper($title);
//	return mb_convert_case($title, MB_CASE_TITLE, "UTF-8");
//}

// add_filter( 'the_title', 'ucwords' );

//add_filter( 'the_content', 'wfm_content' );
//
//function wfm_content($content){
//	if( is_user_logged_in() ) return $content;
//	if( is_page() ) return $content;
//	return '<div class="wfm-access"><a href="' . home_url() . '/wp-login.php">Авторизуйтесь для просмотра контента</a></div>';
//}

add_action( 'comment_post', 'wfm_comment_post' );

function wfm_comment_post(){
	wp_mail( get_bloginfo( 'admin_email' ), 'Новый комментарий на сайте', 'На сайте появился новый комментарий' );
}