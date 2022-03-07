<?php

require_once(__DIR__ . '/lib/user.php');
require_once(__DIR__ . "/lib/escape.php");

$title = 'パスワード再設定';
$content = __DIR__ . '/views/user/change_password.php';
include __DIR__ .  '/views/layout.php';