jQuery(document).ready(function($){
	$('#btn').click(function(){
		var text = $.trim( $('#wfm_text').val() );
		if( text == '' ){
			alert('Введите текст рассылки!');
			return;
		}
		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				data: text,
				action: 'wfm_subscriber_admin'
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
	});
});