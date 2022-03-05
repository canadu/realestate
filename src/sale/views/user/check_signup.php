<main>
    <div class="container" style="margin-top: 90px;">
        <p>記入した内容を確認して、「新規登録する」ボタンをクリックしてください。</p>
        <form action="check_signup.php" method="POST">
            <input type="hidden" name="userAdd" value="submit" />
            <dl>
                <dt>メールアドレス</dt>
                <dd>
                    <?= escape($_SESSION['user']['email']); ?>
                    <?php if (isset($errors['email'])) : ?>
                        <div class="text-danger">
                            <p><?= $errors['email'] ?></p>
                        </div>
                    <?php endif; ?>
                </dd>
                <dt>パスワード</dt>
                <dd>
                    非表示
                </dd>
            </dl>
            <div>
                <a href="signup.php?action=rewrite">&laquo;&nbsp;修正する</a> | <button type="submit" class="btn btn-info text-decoration-none text-white">新規登録する</button>
            </div>
        </form>
    </div>
</main>