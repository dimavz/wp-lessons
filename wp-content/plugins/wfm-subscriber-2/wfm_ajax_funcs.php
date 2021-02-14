<?php

function wfm_ajax_subscriber_admin()
{
    if (empty($_POST['data'])) {
        echo 'Заполните текст рассылки';
    }

    $time = wp_next_scheduled('wfm_cron_action');
    wp_unschedule_event($time, 'wfm_cron_action');

    $options = get_option('wfm_subscriber_options');
    $schedule = $options['schedule'];
    $limit = $options['limit'];

    if (!wp_next_scheduled('wfm_cron_action')) {

        $schedules = wp_get_schedules();
//		echo '<pre>';
//		print_r($schedules);
//		echo '</pre>';
//		exit();
        $schedule_interval = 'hourly';
        foreach ($schedules as $k => $v) {
            if ($v['interval'] == $schedule) {
                $schedule_interval = $k;
                break;
            }
        }
//		echo $schedule_interval;
//		exit;
        $res = wp_schedule_event(time(), $schedule_interval, 'wfm_cron_action');
        if (!$res) {
            die("Ошибка добавления рассылки в Cron");
        }
    }

    /*
     * Флаги которые будут устанавливаться в поле send таблицы wfm_subscriber
1. Возможные значения: 0 - не отправлялось (значение по умолчанию для нового подписчика) или уже отправлено, 1 - поставленные в очередь на рассылку, 2 - текущая партия)
2. Добавляем событие в расписание и ставим в очередь на рассылку (send = '1')
3. Устанавливаем по LIMIT значение send = '2'
4. Если ничего не изменилось по запросу, тогда удаляем событие из расписания и выходим
5. Выбираем всех send = '2' и делаем рассылку
6. Изменяем флаг send = '0' с send = '2'
7. П.3 повторяется до конца рассылки
8. Если количество клиентов в партии меньше лимита, тогда удаляем событие из расписания
*/

    global $wpdb;
    $wpdb->query($wpdb->prepare(
        "UPDATE wfm_subscriber SET send = '1', text = %s", $_POST['data']
    ));

    $count_subscribers = $wpdb->get_var("SELECT COUNT(*) FROM wfm_subscriber");
    $need_time = ceil($count_subscribers / $limit) * $schedule;
    $need_time = date("H:i:s", mktime(0, 0, $need_time));

    die("Рассылка поставлена в очередь. Ориентировочное время рассылки (ЧЧ:ММ:СС): {$need_time}");
}

function wfm_ajax_subscriber()
{
    if (!wp_verify_nonce($_POST['security'], 'wfmajax')) {
        die('Ошибка безопасности!');
    }

    parse_str($_POST['formData'], $wfm_array);

    if (empty($wfm_array['wfm_name']) || empty($wfm_array['wfm_email'])) {
        exit('Заполните поля!');
    }

    if (!is_email($wfm_array['wfm_email'])) {
        exit('Email не соответствует формату');
    }

    global $wpdb;
    if ($wpdb->get_var($wpdb->prepare(
        "SELECT subscriber_id FROM wfm_subscriber WHERE subscriber_email = %s", $wfm_array['wfm_email']
    ))) {
        echo 'Вы уже подписаны';
    } else {
        if ($wpdb->query($wpdb->prepare(
            "INSERT INTO wfm_subscriber (subscriber_name, subscriber_email, text) VALUES (%s, %s, '')", $wfm_array['wfm_name'], $wfm_array['wfm_email']
        ))) {
            echo 'Подписка оформлена';
        } else {
            echo 'Ошибка записи!';
        }
    }

    die;
}