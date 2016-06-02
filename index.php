<?php
include_once 'confirm.php';
include_once 'mail.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="css/modal.css">
	<link rel="stylesheet" href="css/pure-min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<section id="form">
		<h1>お問い合わせ</h1>
		<form id="cf" class="contact_form pure-form" method="post">
			<label for="cf-name" class="bold">お名前</label><span class="req">必須</span><br>
			<?php $cf->html->text('name'); ?><br class="after_name">
			<label for="cf-email" class="bold">メールアドレス</label><span class="req">必須</span><br>
			<?php $cf->html->text('email'); ?><br class="after_email">
			<label class="bold">ご希望のメニュー</label><span class="req">必須</span><br>
			<ul>
			<?php $cf->html->option('menu&'); ?>
			</ul>
			<label class="bold">作りたいサイトの種類</label><br>
			<ul>
			<?php $cf->html->option('kind+'); ?>
			</ul>
			<label for="cf-message" class="bold">ご要望・ご質問など</label><br>
			<?php $cf->html->textarea('message'); ?><br>
			<?php $cf->html->nonce(); ?>
			<button type="submit" class="pure-button confirm_button">確認</button>
		</form>
		<div id="confirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h1>確認</h1>
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						<form id="mail" method="post">
							<?php $mail->html->nonce(); ?>
							<button class="pure-button" data-dismiss="modal" aria-hidden="true">フォームに戻る</button>
							<button type="submit" class="pure-button submit_button">送信</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
	<script src="js/jquery.form.min.js" charset="utf-8"></script>
	<script src="js/modal.js" charset="utf-8"></script>
	<!-- <script src="js/main.js" charset="utf-8"></script> -->
	<script>
	$(function(){
		var last_data = {};
		var form_data = {};
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
			//var queryString = $.param(formData);
			//console.log('About to submit: \n' + queryString + '\n');

			$('.confirm_button').text('送信中').attr('type', 'button').addClass('pure-button-disabled');
			return true;
		};
		function showResponse(response, status, xhr, $form) {
			if (response.processed == true) {
				//$('.confirm_button').text('完了');
				//$('.submit_button').after('<p>お問い合わせありがとうございました</p>');
				console.log(response);
				var result = response.body.replace(/^(.+): ?(.+)?$/gm, '<label>$1</label>$2<br>');
				//$('.moda-body').append(result.replace(/\n/g, '<br>'));
				$('#confirm').on('show.bs.modal', function (event) {
					var modal = $(this);
					modal.find('.modal-body').html(result.replace(/\n/g, '<br>'));
				});
				$('#confirm').modal('show');
				$('#confirm').on('hidden.bs.modal', function (event) {
					var modal = $(this);
					$('.confirm_button').text('確認').attr('type', 'submit').removeClass('pure-button-disabled');
				});
				if ($('.error')[0]) {
					$('.error').empty();
				}
				last_data = response.data;
				var key;
				$.each(last_data, function(index, value) {
					key = index.replace(/([\w&+]+)/g, 'mail-$1');
					form_data[key] = value;
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
			url : 'mail.php',
		};
		$.extend(mail_options.data, form_data);
		$('#mail').ajaxForm(mail_options);

		function beforeSubmit(formData, jqForm, options) {
			//debugger;
			var queryString = $.param(formData);
			console.log('About to submit: \n' + queryString + '\n');

			console.log(mail_options.data);

			$('.submit_button').text('送信中').attr('type', 'button').addClass('pure-button-disabled');
			return true;
		};
		function success(response, status, xhr, $form) {
			if (response.processed == true) {
				$('.confirm_button').text('完了').attr('type', 'button').addClass('pure-button-disabled');
				$('.confirm_button').after('<p>お問い合わせありがとうございました</p>');
				console.log(response.data);
				$('#confirm').modal('hide');
				if ($('.error')[0]) {
					$('.error').empty();
				}
				$('#cf').clearForm();
				return true;
			} else if (response.error_count > 0) {
				console.log('error:'+JSON.stringify(response.error_message)+'\ndata:'+JSON.stringify(response.data));
				alert('フォームのエラーがあります');
				return false;
			} else {
				alert('送信エラー');
				return false;
			}
		};

	});

	</script>
</body>
</html>
