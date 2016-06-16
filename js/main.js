$(function(){
	var form = {};
	var options = {
		data : { _ajax_call: '1' },
		dataType : 'json',
		beforeSubmit : showRequest,
		success : showResponse,
		error : error,
		url : 'lib/confirm.php',
	};
	$('#cf').ajaxForm(options);

	function showRequest(formData, jqForm, options) {
		//debugger;
		//var queryString = $.param(formData);
		//console.log('About to submit: \n' + queryString + '\n');
		//console.log(formData);
		form = formData;
		if ($('.error')[0]) {
			$('.error').remove();
		}
		$('.confirm_button').text('送信中').attr('type', 'button').addClass('pure-button-disabled');
		return true;
	};
	function showResponse(response, status, xhr, $form) {
		//console.log(response);
		if (response.processed == true) {
			var result = response.body.replace(/^(.+):\s?(.+)?$/gm, '<label>$1</label>$2');
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
				$('.error').remove();
			}
			var values = {};
			var arr = [];
			$.each(form, function(index, value) {
				var name = value.name.replace('cf-', 'mail-');
				if (value.type == 'radio') {
					//name = name + '&';
					var radio = value.value - 1;
					$('#'+name+'-'+radio).prop('checked', true);
				} else if (value.type == 'checkbox') {
					name = name.replace('[]', '');
					var checkbox = value.value - 1;
					$('#'+name+'-'+checkbox).prop('checked', true);
				} else if (value.type == 'select-one') {
					$('#'+name+' option').attr('selected', false);
					$('#'+name).val(value.value);
				} else {
					if (value.type != 'hidden') {
						$('#'+name).val(value.value);
					}
				}
			});
			return true;
		} else if (response.error_count > 0) {
			alert('フォームのエラーがあります');
			// {"processed":false,"error_message":{"name":"required","email":"required"},"error_count":2}
			$.each(response.error_message, function(index, value){
				//console.log('index:' + index + '\nvalue: ' + value);
				if (value == 'required' && index == 'name') {
					$('#cf-'+index).after('<span class="error">お名前を入力してください</span>');
				} else if (value == 'required' && index == 'email') {
					$('#cf-'+index).after('<span class="error">メールアドレスを入力してください</span>');
				} else if (value == 'required' && index == 'phone') {
					$('#cf-'+index).after('<span class="error">電話番号を入力してください</span>');
				} else if (value == 'invalid' && index == 'email') {
					$('#cf-'+index).after('<span class="error">メールアドレスが正しくありません</span>');
				} else if (value == 'invalid' && index == 'phone') {
					$('#cf-'+index).after('<span class="error">電話番号が正しくありません</span>');
				} else if (value !== 'valid') {
					$('#cf-'+index).after('<span class="error">'+value+'</span>');
				}

			});
			$('.confirm_button').text('確認').attr('type', 'submit').removeClass('pure-button-disabled');
			return false;
		} else {
			alert('送信エラー');
			return false;
		}
	};
	function error() {
		alert('送信エラー');
		return false;
	};

	var mail_options = {
		data : {
			_ajax_call: '1',
		},
		dataType : 'json',
		beforeSubmit : beforeSubmit,
		success : success,
		error : errors,
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
		//console.log(response);
		if (response.processed == true) {
			$('.submit_button').text('完了');
			$('.confirm_button').text('完了').attr('type', 'button').addClass('pure-button-disabled');
			//$('.confirm_button').after('<p class="error">お問い合わせありがとうございました</p>');
			$('.modal-header h1').text('ありがとうございました');
			$('.modal-body').html('<p>お問い合わせありがとうございました<br>お送りいただいたメールアドレスに確認のメールをお送りしましたので、ご確認ください。</p><button type="button" data-dismiss="modal" aria-hidden="true" class="pure-button close-button">閉じる</button>');
			$('.modal-footer').remove();
			if ($('.error')[0]) {
				$('.error').remove();
			}
			$('#cf').clearForm();

			//ga('send', 'event',  'cv', 'send', location.href, { nonInteraction: true });

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
	function errors() {
		alert('送信エラー');
		return false;
	};
});
