<?php

session_start();

require_once(__DIR__ . "/lib/escape.php");
$title = 'ユーザー登録確認';
$content = __DIR__ . '/views/user/check_signup.php';
include __DIR__ .  '/views/layout.php';