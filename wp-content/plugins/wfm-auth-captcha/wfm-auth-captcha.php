<?php
/*
Plugin Name: Простая капча для формы авторизации
Description: Плагин добавляет простую проверку на человечность к форме авторизации
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

/***************** LINKS *****************/
// http://wordpress.stackexchange.com/questions/25099/change-login-error-messages
// http://codex.wordpress.org/Plugin_API/Action_Reference/login_form
// http://wp-kama.ru/function/wp_authenticate
// http://codex.wordpress.org/Plugin_API/Filter_Reference/authenticate
// https://wpmag.ru/2014/wp_error/
// http://codex.wordpress.org/Class_Reference/WP_Error
/***************** LINKS *****************/


/*add_filter( 'login_errors', 'my_login_errors' );

function my_login_errors(){
	return 'Ошибка авторизации';
}*/

/*add_action( 'login_form', 'wfm_captcha_login' );
add_action( 'wp_authenticate', 'wfm_authenticate', 10, 2 );

function wfm_authenticate($username, $password){
	if( isset( $_POST['check'] ) && $_POST['check'] == 'check' ){
		// wp_die( '<b>Ошибка</b>: вы не прошли проверку на человечность' );
		add_filter( 'login_errors', 'my_login_errors' );
		$username = null;
	}
}

function my_login_errors(){
	return 'Вы не прошли проверку на человечность';
}

function wfm_captcha_login(){
	echo '<p><label for="check"><input type="checkbox" name="check" id="check" value="check" checked> Снимите галочку</label></p>';
}*/

add_action('login_form', 'wfm_captcha_login');
add_filter('authenticate', 'wp_auth_signon', 30, 3);

function wp_auth_signon($user, $username, $password)
{
//    echo '<pre>';
//    print_r($user);
//    echo '</pre>';

    if (isset($_POST['check']) && $_POST['check'] == 'check') {
        $user = new WP_Error('broke', '<b>Ошибка</b>: вы бот?');
    }

    if (isset($user->errors['invalid_username']) || isset($user->errors['incorrect_password'])) {
        $user = new WP_Error('broke', '<b>Ошибка</b>: неверный логин/пароль');
    }
    return $user;
}

function wfm_captcha_login()
{
    echo '<p><label for="check"><input type="checkbox" name="check" id="check" value="check" checked> Снимите галочку</label></p>';
}