<?php
include_once 'mail.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="css/pure-min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<form id="cf" action="mail.php" class="contact_form pure-form" method="post">
		<div class="pure-g">
			<div class="pure-u-1"><h1>お問い合わせ</h1></div>
			<div class="pure-u-1-4">
				<label for="name">お名前</label><span class="req">必須</span>
			</div>
			<div class="pure-u-3-4">
				<?php $cf->html->text('name'); ?>
			</div>
			<div class="pure-u-1-4">
				<label for="email">メールアドレス</label><span class="req">必須</span>
			</div>
			<div class="pure-u-3-4">
				<?php $cf->html->text('email'); ?>
			</div>
			<div class="pure-u-1-4">
				<label>ご希望のメニュー</label><span class="req">必須</span>
			</div>
			<div class="pure-u-3-4">
				<?php $cf->html->option('menu&'); ?>
			</div>
			<div class="pure-u-1-4">
				<label>作りたいサイトの種類</label>
			</div>
			<div class="pure-u-3-4 checkbox">
				<?php $cf->html->option('kind+'); ?>
			</div>
			<div class="pure-u-1-4">
				<label for="request">ご要望・ご質問など</label>
			</div>
			<div class="pure-u-3-4">
				<?php $cf->html->textarea('message'); ?>
			</div>
			<div class="pure-u-1">
				<?php $cf->html->nonce(); ?>
				<button type="submit" class="pure-button submit_button">送信</button>
			</div>
		</div>
	</form>

	<script src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
	<script src="js/jquery.form.min.js" charset="utf-8"></script>
	<script>
		$(document).ready(function() {
			var options = {
				data : { _ajax_call: '1' },
				dataType : 'json',
				beforeSubmit : showRequest,
				success : showResponse,
				clearForm : true,
			};
			$('#cf').ajaxForm(options);
		});
		function showRequest(formData, jqForm, options) {
			//debugger;
			var queryString = $.param(formData);
			console.log('About to submit: \n' + queryString + '\n');

			// TODO: display the progress view
			$('.submit_button').text('送信中').attr('type', 'button').addClass('pure-button-disabled');
			return true;
		};
		function showResponse(response, status, xhr, $form) {
			console.log('response:' + JSON.stringify(response) + '\nstatus:' + status);

			if (response.processed == true) {
				// TODO: show succeeded message
				$('.submit_button').text('完了');

				return true;
			} else if (response.error_count > 0) {
				alert('data error');
				// {"processed":false,"error_message":{"name":"required","email":"required"},"error_count":2}
				$.each(response.error_message, function(){
					console.log(JSON.stringify(this));
					// TODO: show error message

				});

			} else {
				alert('posting data error');
				return false;
			}
		};
	</script>
</body>
</html>
