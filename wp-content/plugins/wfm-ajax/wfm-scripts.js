jQuery(document).ready(function($){

	$('#wfm-form').submit(function(){
		// var formData = $('#wfm-form').serialize()
		$.ajax({
			type: "POST",
			data: {
				formData: $('#wfm_theme_options_body').val(),
				action: 'wfm_action' // Используется для формирования хука для WordPress
			},
			url: ajaxurl,
			success: function(res){
				alert(res);
			},
			error: function(){
				alert('Error!');
			}
		});
		return false;
	});

	/*$('#wfm-form').submit(function(){
		$.ajax({
			type: "POST",
			data: {'test': 'TEST'},
			url: 'http://plugins.loc/wp-content/plugins/wfm-ajax/wfm-ajax.php',
			success: function(res){
				alert(res);
			},
			error: function(){
				alert('Error!');
			}
		});
		return false;
	});*/

});