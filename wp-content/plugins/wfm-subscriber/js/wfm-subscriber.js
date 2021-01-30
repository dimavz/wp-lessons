jQuery(document).ready(function($){
	$('#wfm_form_subscriber').submit(function(){
		var data = $(this).serialize();
		$.ajax({
			type: "POST",
			url: wfmajax.url,
			data: {
				formData: data,
				security: wfmajax.nonce,
				action: 'wfm_subscriber' // Отправка динамичного названия части метода обработки AJAX запроса (Метод wp_ajax_wfm_subscriber)
			},
			beforeSend: function(){
				$('#res').empty();
				$('#loader').fadeIn();
			},
			success: function(res){
				$('#loader').fadeOut(300, function(){
					$('#res').text(res);
				});
			},
			error: function(){
				alert('Ошибка!');
			}
		});
		return false;
	});
});