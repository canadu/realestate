<?php

session_start();

$title = 'ログイン';
require_once(__DIR__ . "/lib/escape.php");
$content = __DIR__ . '/views/user/login.php';
include __DIR__ .  '/views/layout.php';