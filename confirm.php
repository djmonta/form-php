<?php
require_once 'Form.php';
$cf = new Form(array(
		'prefix' => 'cf',
		//'ajax'   => true,
		//'mail'   => true,
		'confirm' => true,
		'nonce'  => '5cv3wx7|hu-OJl4q',
));

/*  Validation Rules
-----------------------------------------------*/
$cf->add('name', true)->maxlen(50);

$cf->add('email', true)->type('email');

$cf->add('menu&')->set_option(array(
	'デザインパック',
	'おまかせパック',
	'相談して決めたい',
))->set_val(0);

$cf->add('kind+')->set_option(array(
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

$cf->add('message')->maxlen(2000);

/*  Confirm
-----------------------------------------------*/
$cf->confirm(array(
	'body' => '
お名前: {{name}}
メールアドレス: {{email}}
ご希望のメニュー: {{menu&}}
作りたいサイトの種類:
{{kind+}}
ご要望・ご質問など:
{{message}}
',
));
?>
