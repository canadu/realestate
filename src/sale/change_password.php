<?php

require_once(__DIR__ . '/lib/user.php');
require_once(__DIR__ . "/lib/escape.php");
require_once(__DIR__ . "/lib/mail.php");

if($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $user = [
        'email' => $_POST['email'],
        'password' => '',
    ];
    $objUser = new User;
    $errors = $objUser->mail_validate($user);
    if (count($errors) == 0) {
        if ($objUser->getUser($user['email']) == 0) {
            //セキュリティのため、登録されていない場合も完了画面を表示する
        } else {
            
            //メール送信処理を行う
            $objSendMail = new Mail;
            
            //送信元の設定
            //$from_address = 'from@'. $_SERVER['HTTP_HOST'];
            $from_address = 'nakada.keisuke@ring-and-link.co.jp';
            //送信者の名前
            $from_name = mb_encode_mimeheader('××不動産');
            
            $from_header  = sprintf( '%s <%s>', $from_name, $from_address );
            //$return_path  = 'noreply@'. $_SERVER['HTTP_HOST'];
            $return_path  = 'nakada.keisuke@ring-and-link.co.jp';

            //送信者の組織名
            $organization = mb_encode_mimeheader('××不動産');
            
            //送信先の設定（複数の場合はカンマ区切り）
            $to_address = $user['email'];
            
            //件名
            $subject = 'パスワード再設定のお知らせ【××不動産】';
            
            //メール本文
            $message = <<<EOD
            文字列を
            連結すると
            どうなるんだろうね。           
EOD;;
            //メールヘッダの設定
            $headers = [
                'MIME-Version'=>'1.0',
                'Content-Transfer-Encoding'=>'7bit',
                'Content-Type'=>'text/plain;charset=UTF-8',
                'Return-Path'=>$return_path,
                'From'=>$from_header,
                'Sender'=>$from_header,
                'Reply-To'=>$from_address,
                'Organization'=>$organization,
                'X-Sender'=>$from_address,
                'X-Mailer' =>'Postfix/2.10.1',
                'X-Priority'=>'3',
            ];
        }

        // メールを送信
        if($objSendMail->send_mail($to_address, $subject, $message, $headers))
        {
            //送信成功
            echo 'メールを送信しました。';
        } else {
            //送信失敗
            $errors['email'] = 'メールが送信できませんでした。';
        };
    }
} else {
    $user = [
        'email' => '',
        'password' => '',
    ];
}
$title = 'パスワード再設定';
$content = __DIR__ . '/views/user/change_password.php';
include __DIR__ .  '/views/layout.php';