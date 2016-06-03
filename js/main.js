$(function(){
	$('.nav__trigger').on('click', function(e){
		e.preventDefault();
		$(this).parent().toggleClass('nav--active');
	});
	$('.nav__link').on('click', function(e){
		$('#header').toggleClass('nav--active');
	});

	var form = {};
	var options = {
		data : { _ajax_call: '1' },
		dataType : 'json',
		beforeSubmit : showRequest,
		success : showResponse,
		url : 'lib/confirm.php',
	};
	$('#cf').ajaxForm(options);

	function showRequest(formData, jqForm, options) {
		//debugger;
		//var queryString = $.param(formData);
		//console.log('About to submit: \n' + queryString + '\n');
		//console.log(formData);
		form = formData;
		$('.confirm_button').text('送信中').attr('type', 'button').addClass('pure-button-disabled');
		return true;
	};
	function showResponse(response, status, xhr, $form) {
		//console.log(response);
		if (response.processed == true) {
			//$('.confirm_button').text('完了');
			//$('.submit_button').after('<p>お問い合わせありがとうございました</p>');
			//console.log(response);
			var result = response.body.replace(/^(.+): ?(.+)?$/gm, '<label>$1</label>$2');
			//$('.moda-body').append(result.replace(/\n/g, '<br>'));
			$('#confirm').on('show.bs.modal', function (event) {
				var modal = $(this);
				modal.find('.modal-body').html(result.replace(/\n/g, '<br>'));
			});
			$('#confirm').modal('show');
			$('#confirm').on('hidden.bs.modal', function (event) {
				var modal = $(this);
				$('.confirm_button').text('確認').attr('type', 'submit').removeClass('pure-button-disabled');
				$('.submit_button').text('送信').attr('type', 'submit').removeClass('pure-button-disabled');
			});
			if ($('.error')[0]) {
				$('.error').empty();
			}
			var values = {};
			var arr = [];
			$.each(form, function(index, value) {
				var name = value.name.replace('cf-', 'mail-').replace('[]', '+');
				if (value.type == 'radio') {
					//name = name + '&';
					$('#'+name+'-'+value.value).prop('checked', true);
				} else if (value.type == 'checkbox') {
					arr.push(value.value);
					values[name] = arr;
					name = name.replace('+', '');
					$('#'+name+'-'+value.value).prop('checked', true);
				} else {
					values[name] = value.value;
					$('#'+name).val(value.value);
				}
			});
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
			$('.confirm_button').text('確認').attr('type', 'submit').removeClass('pure-button-disabled');
			return false;
		} else {
			alert('送信エラー');
			return false;
		}
	};

	var mail_options = {
		data : {
			_ajax_call: '1',
		},
		dataType : 'json',
		beforeSubmit : beforeSubmit,
		success : success,
		url : 'lib/mail.php',
	};
	$('#mail').ajaxForm(mail_options);

	function beforeSubmit(formData, jqForm, options) {
		//debugger;
		//var queryString = $.param(formData);
		//console.log('About to submit: \n' + queryString + '\n');
		//console.log(formData);

		$('.submit_button').text('送信中').attr('type', 'button').addClass('pure-button-disabled');
		return true;
	};
	function success(response, status, xhr, $form) {
		if (response.processed == true) {
			$('.submit_button').text('完了');
			$('.confirm_button').text('完了').attr('type', 'button').addClass('pure-button-disabled');
			//$('.confirm_button').after('<p class="error">お問い合わせありがとうございました</p>');
			$('.modal-header h1').text('ありがとうございました');
			$('.modal-body').html('<p>お問い合わせありがとうございました<br>お送りいただいたメールアドレスに確認のメールをお送りしましたので、ご確認ください。</p><button type="button" data-dismiss="modal" aria-hidden="true" class="pure-button close-button">閉じる</button>');
			$('.modal-footer').remove();
			if ($('.error')[0]) {
				$('.error').empty();
			}
			$('#cf').clearForm();
			return true;
		} else if (response.error_count > 0) {
			//console.log('error:'+JSON.stringify(response.error_message)+'\ndata:'+JSON.stringify(response.data));
			alert('フォームのエラーがあります');
			return false;
		} else {
			alert('送信エラー');
			return false;
		}
	};
});
