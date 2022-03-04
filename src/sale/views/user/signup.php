<main>
    <div class="container" style="margin-top: 90px; max-width: 540px;">
        <h3 class="text-center">ユーザー登録</h3>
        <div class="card container mt-4 p-4 shadow-sm">
            <form action="signup.php" method="POST">
                <div class="form-group">
                    <label for="email"><span class="badge bg-danger text-white">必須</span> メールアドレス</label>
                    <input class="form-control" type="email" placeholder="メールアドレス" id="email" name="email" value="" autofocus required="required">
                    <?php if (isset($errors['email'])) : ?>
                        <ul class="text-danger">
                            <li><?= $errors['email'] ?></li>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="password"><span class="badge bg-danger text-white">必須</span> パスワード</label>

                        <input class="form-control js-password" type="password" placeholder="パスワード" id="password" name="password" value="" autocomplete="off" required="required">
                            <?php if (isset($errors['password'])) : ?>
                                <ul class="text-danger">
                                    <li><?= $errors['password'] ?></li>
                                </ul>
                            <?php else : ?>
                                <ul class="text-dark small">
                                    <?php if (isset($_SESSION['user']['password'])) : ?>
                                        <li class="text-danger">恐れ入りますが、パスワードを改めて入力してください</li>
                                    <?php endif; ?>
                                    <li>パスワードは半角英数字をそれぞれ１文字以上含んだ、８文字以上</p>
                                </ul>
                            <?php endif; ?>
                            <div class="btn">
                                <input class="btn-input js-password-toggle" id="eye" type="checkbox">
                                <label class="btn-label js-password-label" for="eye"><i class="fas fa-eye"></i>パスワード表示</label>
                            </div>
                        <script>
                            const passwordToggle = document.querySelector('.js-password-toggle');
                            passwordToggle.addEventListener('change', function() {
                                const password = document.querySelector('.js-password'),
                                    passwordLabel = document.querySelector('.js-password-label');
                                if (password.type === 'password') {
                                    password.type = 'text';
                                    passwordLabel.innerHTML = '<i class="fas fa-eye-slash"></i>パスワード表示しない';
                                } else {
                                    password.type = 'password';
                                    passwordLabel.innerHTML = '<i class="fas fa-eye"></i>パスワード表示';
                                }
                                password.focus();
                            });
                        </script>
                    <button class="btn btn-lg btn-info btn-block" type="submit">ユーザー登録</button>
            </form>
        </div>
    </div>
</main>