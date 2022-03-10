<main>
    <div class="container" style="margin-top: 90px; max-width: 540px;">
        <p>ログインパスワードの再設定を行います。</p>
        <p>登録済みのメールアドレスを入力し、「メール送信」ボタンをクリックしてください。</p>
        <div class="card container mt-4 p-4 shadow-sm">
            <form action="change_password.php" method="POST">
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input class="form-control" type="email" id="email" name="email" value="<?= escape($user['email']); ?>">
                    <?php if (isset($errors['email'])) : ?>
                        <div class="text-danger">
                            <p><?= $errors['email'] ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="text-center">
                    <button class="btn btn-md btn-info" type="submit">メール送信</button>
                </div>
            </form>
        </div>
    </div>
</main>