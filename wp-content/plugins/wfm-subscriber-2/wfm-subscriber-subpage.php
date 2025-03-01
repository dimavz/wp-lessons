<?php

add_action( 'wp_ajax_wfm_subscriber', 'wfm_ajax_subscriber' );
add_action( 'wp_ajax_nopriv_wfm_subscriber', 'wfm_ajax_subscriber' );
add_action( 'wp_ajax_wfm_subscriber_admin', 'wfm_ajax_subscriber_admin' );

function wfm_subscriber_scripts(){
	wp_register_script( 'wfm-subscriber', plugins_url( 'js/wfm-subscriber.js', __FILE__ ), array('jquery') );
	wp_enqueue_script( 'wfm-subscriber' );
	wp_localize_script( 'wfm-subscriber', 'wfmajax', array( 'url' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'wfmajax' ) ) );
}

function wfm_admin_scripts($hook){
//	if( urldecode($hook) != 'подписчики_page_wfm-subscriber-subpage' ) return;
	if( urldecode($hook) != 'рассылка_page_wfm-subscriber-subpage' ) return;
	wp_enqueue_style( 'wfm-style', plugins_url( 'css/wfm-subscriber.css', __FILE__ ) );
	wp_enqueue_script( 'wfm-admin-scripts', plugins_url( 'js/wfm-subscriber-admin.js', __FILE__ ), array('jquery') );
}

function wfm_subscriber_subpage(){
	?>
<div class="wrap">
	<h2>Подписчики</h2>
	<?php
		$pagination_params = pagination_params();
		$subscribers = get_subscribers();
	?>

	<?php if($subscribers): ?>
		<p><b>Кол-во подписчиков: <?php echo $pagination_params['count'] ?></b></p>

<table class="wp-list-table widefat fixed posts" id="wfm-table">
	<thead>
		<tr>
			<td>ID</td>
			<td>Имя</td>
			<td>Email</td>
		</tr>
	</thead>
	<tbody>
	<?php foreach($subscribers as $subscriber): ?>
		<tr>
			<td><?php echo $subscriber['subscriber_id']; ?></td>
			<td><?php echo $subscriber['subscriber_name']; ?></td>
			<td><?php echo $subscriber['subscriber_email']; ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<!-- Пагинация -->
<?php if( $pagination_params['count_pages'] > 1 ): ?>
<div class="pagination">
	<?php echo pagination($pagination_params['page'], $pagination_params['count_pages']); ?>
</div>
<?php endif; ?>
<!-- Пагинация -->

<p>
	<label for="wfm_text">Текст рассылки (для имени используйте шаблон %name%)</label> <br>
	<textarea name="wfm_text" id="wfm_text" cols="30" rows="10" class="widefat wfm-text"></textarea>
</p>

<button class="btn" id="btn">Сделать рассылку</button>
<span id="loader" style="display: none;"><img src="<?php echo plugins_url( 'img/loader.gif', __FILE__ ); ?>" alt=""></span>
<div id="res"></div>

	<?php else: ?>
		<p>Список подписчиков пуст</p>
	<?php endif; ?>
</div>
	<?php
}