<?php
include_once 'lib/confirm.php';
include_once 'lib/mail.php';
?>
<!DOCTYPE html>
<html lang="ja">
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
			<?php $cf->html->text('name'); ?><br>
			<label for="cf-email" class="bold">メールアドレス</label><span class="req">必須</span><br>
			<?php $cf->html->text('email'); ?><br>
			<label for="cf-phone" class="bold">電話番号</label><span class="req">必須</span><br>
			<?php $cf->html->text('phone'); ?><br>
			<label for="cf-zip" class="bold">郵便番号</label><br>
			<?php $cf->html->text('zip'); ?><br>
			<label for="cf-address" class="bold">ご住所</label><br>
			<?php $cf->html->text('address'); ?><br>
			<label class="bold">ご希望のメニュー</label><span class="req">必須</span><br>
			<ul>
				<?php $cf->html->option('menu&'); ?>
			</ul>
			<label class="bold">作りたいサイトの種類</label><br>
			<?php $cf->html->select('kind&'); ?>
			<label class="bold">希望オプション</label><br>
			<ul>
				<?php $cf->html->option('option+'); ?>
			</ul>
			<label for="cf-message" class="bold">ご要望・ご質問など</label><br>
			<?php $cf->html->textarea('message'); ?><br>
			<?php $cf->html->nonce(); ?>
			<input type="hidden" id="zipaddr_param" value="zip=cf-zip,addr=cf-address">
			<button type="submit" class="pure-button confirm_button">確認</button>
		</form>
		<div id="confirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h1>入力内容をご確認ください</h1>
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						<form id="mail" method="post">
							<div class="hidden_form">
								<?php
                                $mail->html->text('name');
                                $mail->html->text('email');
                                $mail->html->text('phone');
                                $mail->html->text('zip');
                                $mail->html->text('address');
                                $mail->html->option('menu&');
                                $mail->html->select('kind&');
                                $mail->html->option('option+');
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
