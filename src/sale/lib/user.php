<?php


require_once(__DIR__ . '/datasource.php');

/*ユーザー関連の処理を行うクラス */

class User
{
    //ユーザー情報を取得する
    function getUser($email)
    {
        $db = new DataSource();
        $result = $db->selectOne(
            'SELECT * FROM user WHERE email = :email',
            [':email' => $email]
        );
        return $result;
    }

    //バリデーション処理
    function validate($user): array
    {
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

        //ユーザーの存在確認
        if (count($errors) == 0) {
            //エラーがなかった場合のみ存在確認を行う
            if ($this->getUser($user['email']) > 0) {
                $errors['email'] = '同じユーザーが既に存在します。';
            }
        }
        return $errors;
    }

    //ユーザーの追加
    function AddUser($user, $password)
    {
        // try {
        $db = new DataSource;
        $sql = 'INSERT INTO user(email,password) VALUES (:email, :password)';
        $db->execute($sql, [
            ':email' => $user,
            ':password' => $password,
        ]);
        // } catch () {

        // }

    }
}
