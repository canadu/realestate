<?php

require_once(__DIR__ . "/lib/user.php");
require_once(__DIR__ . "/lib/escape.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = [
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ];
    $objUser = new User;
    //パスワードの入力チェック
    $errors = $objUser->validate($user);
    if (!$errors) {
        $user['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $_POST['password'] = $user['password'];
        $_SESSION['user'] = $_POST;
        header("Location: check_signup.php");
        exit();
    } else {
        $user['password'] = '';
    }
} elseif (!isset($_REQUEST['action'])) {
    $user = [
        'email' => '',
        'password' => '',
    ];
} elseif ($_REQUEST['action'] === 'rewrite' && isset($_SESSION['user'])) {
        $_POST = $_SESSION['user'];
        $user = [
            'email' => $_POST['email'],
            'password' => '',
        ];
}
$title = '会員登録';
$content = __DIR__ . '/views/user/signup.php';
include __DIR__ .  '/views/layout.php';
