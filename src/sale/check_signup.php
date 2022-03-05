<?php

require_once(__DIR__ . '/lib/user.php');
require_once(__DIR__ . "/lib/escape.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userAdd'])) {
    $user = new User;
    $user->AddUser($_SESSION['user']['email'], $_SESSION['user']['password']);
}
$title = '会員登録確認';
$content = __DIR__ . '/views/user/check_signup.php';
include __DIR__ .  '/views/layout.php';
