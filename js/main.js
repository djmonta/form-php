$(function(){
	$('.nav__trigger').on('click', function(e){
		e.preventDefault();
		$(this).parent().toggleClass('nav--active');
	});
	$('.nav__link').on('click', function(e){
		$('#header').toggleClass('nav--active');
	});

	var options = {
		data : { _ajax_call: '1' },
		dataType : 'json',
		beforeSubmit : showRequest,
		success : showResponse,
		url : 'confirm.php',
	};
	$('#cf').ajaxForm(options);

	function showRequest(formData, jqForm, options) {
		//debugger;
		var queryString = $.param(formData);
		console.log('About to submit: \n' + queryString + '\n');

		$('.submit_button').text('送信中').attr('type', 'button').addClass('pure-button-disabled');
		return true;
	};
	function showResponse(response, status, xhr, $form) {
		console.log('response:' + JSON.stringify(response) + '\nstatus:' + status);

		if (response.processed == true) {
			$('.submit_button').text('完了');
			$('.submit_button').after('<p>お問い合わせありがとうございました</p>');
			if ($('.error')[0]) {
				$('.error').empty();
			}
			$form.clearForm();
			return true;
		} else if (response.error_count > 0) {
			alert('フォームのエラーがあります');
			// {"processed":false,"error_message":{"name":"required","email":"required"},"error_count":2}
			$.each(response.error_message, function(index, value){
				//console.log('index:' + index + '\nvalue: ' + value);
				if (value == 'required' && index == 'name') {
					$('.after_name').remove();
					$('#cf-'+index).after('<p class="error">お名前を入力してください</p>');
				} else if (value == 'required' && index == 'email') {
					$('.after_email').remove();
					$('#cf-'+index).after('<p class="error">メールアドレスを入力してください</p>');
				} else if (value == 'invalid' && index == 'email') {
					$('.after_email').remove();
					$('#cf-'+index).after('<p class="error">メールアドレスが正しくありません</p>');
				} else if (value !== 'valid') {
					$('#cf-'+index).after('<p class="error">'+value+'</p>');
				}

			});
			$('.submit_button').text('送信').attr('type', 'submit').removeClass('pure-button-disabled');
			return false;
		} else {
			alert('送信エラー');
			return false;
		}
	};
});
