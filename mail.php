<?php
require_once 'Form.php';
$cf = new Form(array(
		'prefix' => 'cf',
		//'ajax'   => true,
		// 'mail'   => true,
		'nonce'  => '3AYBpaa3ZyVHPaz9',
));

/*  Validation Rules
-----------------------------------------------*/
$cf->add('name', true)->maxlen(50);

$cf->add('email', true)->type('email');

$cf->add('menu')->set_option(array(
	'デザインパック',
	'おまかせパック',
	'相談して決めたい',
));

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

$cf->add('message')->maxlen(1000);

/*  Send Email
-----------------------------------------------*/
$cf->submit(array(
		'from' => 'Contact <contact@example.com>',
		'bcc' => 'contact@example.com',
		'to' => 'sachiko.miyamoto@gmail.com',
		'subject' => 'Contact',
		'body' => '
----------------------------------------
Timestamp: {{DATE}}
----------------------------------------
Name: {{name}}
----------------------------------------
Email: {{email}}
----------------------------------------
Birthdate: {{birthdate}}
----------------------------------------
Gender: {{gender}}
----------------------------------------
Colors:
{{color+}}
----------------------------------------
Message:
{{message}}
----------------------------------------
',
));
?>
