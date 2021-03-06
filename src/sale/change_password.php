<?php

require_once(__DIR__ . '/lib/user.php');
require_once(__DIR__ . "/lib/config.php");
require_once(__DIR__ . "/lib/mail.php");


function isTokenValid($resetLimit): bool
{
    try {
        if ($resetLimit == '') {
            return false;
        }
        $now = new DateTime('now');
        $limit = new DateTime($resetLimit);
        $diff = $now->diff($limit);
        if ($diff->invert > 0) {
            //マイナスの場合、24時間以上経過しているとみなし無効とする
            return false;
        } else {
            return true;
        }
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = [
        'email' => $_POST['email'],
        'password' => '',
    ];
    $objUser = new User;
    $errors = $objUser->mail_validate($user);
    if (count($errors) == 0) {

        //DBからユーザー情報を取得
        $dbUser = $objUser->getUser($user['email']);

        if (!$dbUser) {
            //セキュリティのため、登録されていない場合も完了画面を表示する
            echo 'いないよ';
        } else {
            //トークンを作成する
            $passRestToken = md5(uniqid(rand(), true));
            //トークンとユーザーIDをパラメーターに含める
            $resetUrl =  getUrl($_SERVER['REQUEST_URI']) . '?id=' . urlencode($dbUser['id']) . '&token=' . urlencode($passRestToken);
            echo $resetUrl;

            //パスワードリセット用テーブルにデータを登録
            $objUser->updResetToken($dbUser['id'], $passRestToken, date("Y-m-d H:i:s", strtotime("+1 day")));

            //URLをメールで送信

            //             //送信元の設定
            //             //$from_address = 'from@'. $_SERVER['HTTP_HOST'];
            //             $from_address = '';
            //             //送信者の名前
            //             $from_name = mb_encode_mimeheader('××不動産');
            //             $from_header  = sprintf('%s <%s>', $from_name, $from_address);
            //             //$return_path  = 'noreply@'. $_SERVER['HTTP_HOST'];
            //             $return_path  = '';
            //             //送信者の組織名
            //             $organization = mb_encode_mimeheader('××不動産');

            //             //送信先の設定（複数の場合はカンマ区切り）
            //             $to_address = $user['email'];

            //             //件名
            //             $subject = 'パスワード再設定のお知らせ【××不動産】';

            //             //メール本文
            //             $message = <<<EOD
            //             文字列を
            //             連結すると
            //             どうなるんだろうね。
            // EOD;;
            //             //メールヘッダの設定
            //             $headers = [
            //                 'MIME-Version' => '1.0',
            //                 'Content-Transfer-Encoding' => '7bit',
            //                 'Content-Type' => 'text/plain;charset=UTF-8',
            //                 'Return-Path' => $return_path,
            //                 'From' => $from_header,
            //                 'Sender' => $from_header,
            //                 'Reply-To' => $from_address,
            //                 'Organization' => $organization,
            //                 'X-Sender' => $from_address,
            //                 'X-Mailer' => 'Postfix/2.10.1',
            //                 'X-Priority' => '3',
            //             ];
            //         }
            //         // メールを送信
            //         if ($objSendMail->send_mail($to_address, $subject, $message, $headers)) {
            //             //送信成功
            //             echo 'メールを送信しました。';
            //         } else {
            //             //送信失敗
            //             $errors['email'] = 'メールが送信できませんでした。';
        };
    }
} else {
    if (isset($_GET['id']) && isset($_GET['token'])) {
        $id = $_GET['id'];
        $token = $_GET['token'];
        $objUser = new User;
        //パラメーターを持つユーザーが存在するか確認する
        $resutl = $objUser->getRestToken($id, $token);

        if ($resutl) {
            //トークンの有効性を確認する
            if (isTokenValid($resutl['pass_reset_limit'])) {
                //パスワード再設定画面に遷移
                //トークンを空にする
            } else {
                //トークンが無効の場合、エラーを表示する
                //DBのトークンを空にする
                $objUser->updResetToken($id, "", "");
                $errors['email'] = "無効なURLです。お手数ですが、再度「メール送信」ボタンをクリックし、メールを受信してください。";
            }
        } else {
            //トークンを持つユーザーが居ない場合
            $errors['email'] = "無効なURLです。お手数ですが、再度「メール送信」ボタンをクリックし、メールを受信してください。";
        }
        $user = [
            'email' => '',
            'password' => '',
        ];
    } else {
        $user = [
            'email' => '',
            'password' => '',
        ];
    }
}
$title = 'パスワード再設定';
$content = __DIR__ . '/views/user/change_password.php';
include __DIR__ .  '/views/layout.php';
