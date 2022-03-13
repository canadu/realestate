<?php

require_once(__DIR__ . '/datasource.php');

/*ユーザー関連の処理を行うクラス */
class User
{
    public string $mode = '';

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

    function mail_validate($user): array
    {
        $errors = [];
        if (!strlen($user['email'])) {
            $errors['email'] = 'メールアドレスを入力してください';
        } elseif (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'メールアドレスが正しくありません。';
        }
        return $errors;
    }

    //バリデーション処理
    function validate($user): array
    {
        $errors = [];

        //email
        if (!strlen($user['email'])) {
            $errors['email'] = 'メールアドレスを入力してください';
        } elseif (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'メールアドレスが正しくありません。';
        }
        //パスワード
        if (!strlen($user['password'])) {
            $errors['password'] = 'パスワードを入力してください';
        } elseif (strlen($user['password']) > 20) {
            $errors['password'] = 'パスワードは20文字以内で入力してください';
        }

        //ユーザーの存在確認
        if (empty($this->mode)) {
            if (count($errors) == 0) {
                //エラーがなかった場合のみ存在確認を行う
                if ($this->getUser($user['email']) > 0) {
                    $errors['email'] = '同じユーザーが既に存在します。';
                }
            }
        }
        return $errors;
    }

    /*
    ユーザーの追加
    */
    function AddUser($user, $password)
    {
        // try {
        $db = new DataSource;
        $sql = 'INSERT INTO user(email,password,create_datetime,update_datetime) VALUES (:email, :password, :create_datetime, :update_datetime)';
        $db->execute($sql, [
            ':email' => $user,
            ':password' => $password,
            ':create_datetime' => date("Y-m-d H:i:s"),
            ':update_datetime' => date("Y-m-d H:i:s"),
        ]);
    }
    /*
    ログイン時のバリデーションチェック
    */
    function Validate_login($user): array
    {
        $errors = [];
        $errors = $this->validate($user);
        if (count($errors) == 0) {
            // ユーザー情報を取得する
            $result = $this->getUser($user['email']);
            //パスワードがハッシュと一致するかの確認
            if (!password_verify($user['password'], $result['password'])) {
                $errors['user'] = 'メールアドレス、パスワードのどちらかに誤りがあります。';
            }
        }
        return $errors;
    }


    function updResetToken(string $id, string $token, string $limitDate)
    {
        $db = new DataSource;
        $sql = 'UPDATE user 
                SET pass_reset_token = :pass_reset_token, 
                    pass_reset_limit = :pass_reset_limit,
                    update_datetime = :update_datetime WHERE id = :id';
        $db->execute($sql, [
            ':id' => $id,
            ':pass_reset_token' => $token,
            ':pass_reset_limit' => $limitDate,
            ':update_datetime' => date("Y-m-d H:i:s"),
        ]);
    }

    function getRestToken(string $id, string $token)
    {
        $db = new DataSource();
        $result = $db->selectOne(
            'SELECT * FROM user WHERE id = :id and pass_reset_token = :pass_reset_token',
            [
                ':id' => $id,
                ':pass_reset_token' => $token,
            ]
        );
        return $result;
    }
}
