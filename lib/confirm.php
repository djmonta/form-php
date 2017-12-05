<?php

require_once 'Form.php';
$cf = new Form([
    'prefix' => 'cf', // 変更しないでください。変更する場合は、JavaScript も変更しないと動きません
    'nonce'  => '5cv3wx7|hu-OJl4q', // Secret
]);

/*  Validation Rules
-----------------------------------------------*/
$cf->add('name', true)->maxlen(50);

$cf->add('email', true)->type('email');

$cf->add('phone', true)->format('kana', 'nas')->format('phone')->type('tel');

$cf->add('zip')->format('kana', 'nas');
$cf->add('address');

$cf->add('menu&')->set_option([
    'デザインパック',
    'おまかせパック',
    '相談して決めたい',
])->set_val(0);

$cf->add('kind&')->set_option([
    '個人事業',
    '個人商店',
    'クリニック・調剤薬局',
    'ランディングページ',
    'イベント',
    'キャンペーンページ',
    '採用ページ',
    '政治家のページ',
    'その他',
])->set_val(0);

$cf->add('option+')->set_option([
    'SSLお問い合わせフォーム',
    'ドメイン・サーバーをご自身でご用意する',
]);

$cf->add('message')->maxlen(2000);

/*  Confirm
-----------------------------------------------*/
$cf->submit([
    'body' => '
お名前: {{name}}
メールアドレス: {{email}}
電話番号: {{phone}}
郵便番号: {{zip}}
ご住所: {{address}}
ご希望のメニュー: {{menu&}}
作りたいサイトの種類: {{kind&}}
オプション: {{option+}}
ご要望・ご質問など: {{message}}
',
]);
