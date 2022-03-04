<?php

session_start();

function validate($user) {
    
    $errors = [];

    //email
    if (!strlen($user['email'])) {
        $errors['email'] = 'Emailを入力してください';
    } elseif (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Emailが正しくありません。';
    }

    //パスワード
    if (!strlen($user['password'])) {
        $errors['password'] = 'パスワードを入力してください';
    } elseif (strlen($user['password']) > 20) {
        $errors['password'] = 'パスワードは20文字以内で入力してください';
    }
    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $user = [
        'email'=> $_POST['email'],
        'password'=> $_POST['password']
    ];
    
    //パスワードの入力チェック
    $errors = validate($user);

    if(!$errors) {
        $user['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $_POST['password'] = $user['password'];
        $_SESSION['user'] = $_POST;
        header("Location: check_signup.php");
        exit();
    } else {
        $user['password'] = '';
    }
// } elseif ($_REQUEST['action'] === 'rewrite' && isset($_SESSION['user'])) {
//     $_POST = $_SESSION['us   er'];
//     $user = [
//         'email' => $_POST['email'],
//         'password' => '', 
//     ];
}
$title = 'ユーザー登録';
$content = __DIR__ . '/views/user/signup.php';
include __DIR__ .  '/views/layout.php';