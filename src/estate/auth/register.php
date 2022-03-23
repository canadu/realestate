<?php
require '../db/dbConnect.php';
include '../include/header.php';

if(isset($_POST['register'])) {
    $errMsg = '';

    $userInfo = [];

    //本来は入力チェックを行うべし
    
    $userInfo['username'] = $_POST['username'];
    $userInfo['mobile'] = $_POST['mobile'];
    $userInfo['email'] = $_POST['email'];
    $userInfo['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $userInfo['fullname'] = $_POST['fullname'];

    try {
        $db = new DataSource;
        $db->execute("INSERT INTO users (fullname, mobile, username, email, password) VALUES (:fullname, :mobile, :username, :email, :password)",$userInfo);
        header('Location: register.php?action=joined');
        exit;
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}
if(isset($_GET['action']) && $_GET['action'] == 'joined') {
    $errMsg = '登録しました。';
}
?>
<!-- nav -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#212529;" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="../index.php">SHRS</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php">ログイン</a>
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="register.php">Register</a> -->
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- section -->
<div class="mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="alert alert-info" role="alert">
                    <?php
                    if(isset($errMsg)){
                        echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
                    }
                    ?>
                    <h2 class="text-center mb-3">新規登録</h2>
                    <!-- 登録フォーム -->
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="fullName">名前</label>
                                    <input type="text" class="form-control" id="fullName" placeholder="例）山田太郎" name="fullname" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="userName">ユーザー名</label>
                                    <input type="text" class="form-control" id="userName" placeholder="例）タロウ" name="username" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="mobile">電話番号</label>
                                    <input type="text" class="form-control" pattern="^(\d{10})$" id="mobile" title="10 digit mobile number" placeholder="例）0312345678 ※ハイフン無し" name="mobile" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="例）xxx@example.co.jp" name="email" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">パスワード</label>
                            <input type="password" class="form-control" id="password" placeholder="例）パスワード ※半角英数字で入力" name="password" required>
                        </div>

                        <div class="form-group">
                            <label for="c_password">パスワード（確認）</label>
                            <input type="password" class="form-control" id="c_password" placeholder="例）パスワード ※半角英数字で入力" name="c_password" required>
                        </div>

                        <div class="text-right">
                            <button class="btn btn-info w-25" type="submit" name="register">登録</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../include/footer.php'; ?>