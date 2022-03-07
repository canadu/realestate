<main>
    <div class="container" style="margin-top: 90px;">
        <p>ログインパスワードの再設定を行います。</p>
        <p>登録済みのメールアドレスを入力し、「メール送信ボタン」をクリックしてください。</p>
        <div class="card container mt-4 p-4 shadow-sm">
            <form action="check_signup.php" method="POST">
                <div class="form-group">
                    <label for="email">メールアドレス</label>>
                    <input class="form-control" type="email" id="email" name="email" value="">
                </div>
                <div class="text-center">
                    <button class="btn btn-md btn-info" type="submit">メール送信</button>
                </div>
            </form>
        </div>
    </div>
</main>