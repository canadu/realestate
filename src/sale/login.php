<?php

require_once(__DIR__ . "/lib/user.php");
require_once(__DIR__ . "/lib/escape.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = [
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    ];
    $objUser = new User;
    $objUser->mode = 'login';
    
    //入力フォームのチェック
    $errors = $objUser->Validate_login($user);
    if (!count($errors)) {
        session_regenerate_id();
        $_SESSION['user'] = $_POST;
        header('Location:index.php');
        exit();
    }
} else {
    if (isset($_SESSION['user'])) {
        //セッションがある場合
        $user = [
            'email' => $_SESSION['user']['email'],
            'password' => '',
        ];
    } else {
        $user = [
            'email' => '',
            'password' => '',
        ];
    }
}
$title = 'ログイン';
$content = __DIR__ . '/views/user/login.php';
include __DIR__ .  '/views/layout.php';