<main>
    <div class="container" style="margin-top:90px; max-width: 540px;">
        <h3 class="text-center">ログイン</h3>
        <div class="card container mt-4 p-4 shadow-sm">
            <form action="login.php" method="POST">
                <?php if (isset($errors['user'])) : ?>
                    <div class="text-danger">
                        <p><?= $errors['user'] ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input class="form-control" type="email" id="email" name="email" value="<?= escape($user['email']); ?>">
                    <?php if (isset($errors['email'])) : ?>
                        <div class="text-danger">
                            <p><?= $errors['email'] ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input class="form-control" type="password" id="password" name="password" value="">
                    <?php if (isset($errors['password'])) : ?>
                        <div class="text-danger">
                            <p><?= $errors['password'] ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                <button class="btn btn-lg btn-info btn-block" type="submit">ログイン</button>
                <div class="mt-3">
                    <a href="change_password.php">パスワードを忘れた方はこちら</a>
                </div>
            </form>
        </div>
    </div>
</main>