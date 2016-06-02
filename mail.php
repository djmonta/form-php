<?php
require_once 'Form.php';
$mail = new Form(array(
		'prefix' => 'mail',
		//'ajax'   => true,
		'mail'   => true,
		'confirm' => false,
		'nonce'  => 'wF)3QdE8N8jowLDU',
));

/*  Validation Rules
-----------------------------------------------*/
$mail->add('name', true)->maxlen(50);

$mail->add('email', true)->type('email');

$mail->add('menu&')->set_option(array(
	'デザインパック',
	'おまかせパック',
	'相談して決めたい',
))->set_val(0);

$mail->add('kind+')->set_option(array(
	'個人事業',
	'個人商店',
	'クリニック・調剤薬局',
	'ランディングページ',
	'イベント',
	'キャンペーンページ',
	'採用ページ',
	'政治家のページ',
	'その他',
));

$mail->add('message')->maxlen(2000);

/*  Send Email
-----------------------------------------------*/
$mail->submit(array(
		'from' => 'Contact <contact@single-web.site>',
		'bcc' => '{{email}}',
		'to' => 'sachiko.miyamoto@gmail.com',
		'subject' => 'Contact',
		'body' => '
----------------------------------------
日時: {{DATE}} {{TIME}}
----------------------------------------
お名前: {{name}}
----------------------------------------
メールアドレス: {{email}}
----------------------------------------
ご希望のメニュー: {{menu&}}
----------------------------------------
作りたいサイトの種類:
{{kind+}}
----------------------------------------
ご要望・ご質問など:
{{message}}
----------------------------------------
',
));
?>
