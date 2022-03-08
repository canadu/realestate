<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/css/app.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title><?php echo $title; ?></title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-light bg-light">
            <div class="container d-flex">
                <a class="navbar-brand" href="index.php">
                    <img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
                    ××不動産
                </a>
                <!-- ハンバーガーメニュー -->
                <!-- data-targetにcollapseを指定したdivのidを指定すること -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- idは、上記ボタンのdata-targetに指定したものと揃えること -->
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="login.php" class="nav-link">マイページログイン</a></li>
                        <li class="nav-item"><a href="signup.php" class="nav-link">会員登録</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <?php include $content; ?>
    <div class="bg-teal1 text-white" style="margin-top: 74px;">
        <footer class="footer">
            <div class="container text-center">
                <ul class="footer-list">
                    <li><a href="/term" class="">利用規約</a></li>
                    <li><a href="/privacy" class="">プライバシーポリシー</a></li>
                    <li><a href="/tokutei" class="">特定商取引に関する表記</a></li>
                    <li><a href="/contact" class="">お問い合わせ</a></li>
                </ul> 
                <p class="text-muted">©︎<?php echo date('Y'); ?>××不動産</p>
            </div>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>