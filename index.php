<?php
include_once 'lib/confirm.php';
include_once 'lib/mail.php';
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
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h1>確認</h1>
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						<form id="mail" method="post">
							<div class="hidden_form">
								<?php
								$mail->html->text('name');
								$mail->html->text('email');
								$mail->html->option('menu&');
								$mail->html->option('kind+');
								$mail->html->textarea('message');
								$mail->html->nonce();
								?>
							</div>
							<button class="pure-button back-button" data-dismiss="modal" aria-hidden="true">フォームに戻る</button>
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
	<script src="js/main.js" charset="utf-8"></script>
</body>
</html>
