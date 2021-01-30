jQuery(document).ready(function($){

	$('#submit').attr('disabled', true);
	$('#wfm_theme_options_body').blur(function(){
		if( $(this).val() != '' ){
			$('#submit').attr('disabled', false);
		}else{
			$('#submit').attr('disabled', true);
		}
	});

	$('#wfm-form').submit(function(){
		$.ajax({
			type: "POST",
			data: {
				formData: $('#wfm_theme_options_body').val(),
				security: wfmajax,
				action: 'wfm_action'
			},
			url: ajaxurl,
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
				alert('Error!');
			}
		});
		return false;
	});

});