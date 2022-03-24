<?php
require '../db/dbConnect.php';
include '../include/header.php';

if(isset($_POST['login'])) {
    $userInfo = [];
    $userInfo['username'] = $_POST['username'];
    $userInfo['email'] = $_POST['username'];
    $userInfo['password'] = $_POST['password'];
    $db = new DataSource;
    $sql = "SELECT * FROM users WHERE username = :username OR email = :email";
    $data = $db->select($sql, [
        ':username' => $userInfo['username'],
        ':email' => $userInfo['email'],
    ]);
    if($data == false) {
        $errMsg = "ユーザーは存在しません。";
    } else {
        //パスワードに誤りがないか
        if($data['password'] == password_hash($userInfo['password'], PASSWORD_BCRYPT)){
            $_SESSION['id'] = $data['id'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['fullname'] = $data['fullname'];
            $_SESSION['role'] = $data['role'];
            header('Location:dashboard.php');
            exit();
        } else {
            $errMsg = "ユーザーは存在しません。";
        }
    }
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
                    <!-- <a class="nav-link" href="login.php">Login</a> -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">登録</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- section -->
<section id="services">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <div class="alert alert-info" role="alert">
                    <?php
                    if (isset($errMsg)) {
                        echo '<div style="color:#FF0000;text-align:center;font-size:17px;">' . $errMsg . '</div>';
                    }
                    ?>
                    <h2 class="text-center">ログイン</h2>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email Address/Username</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Email" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-info w-50" name='login'>ログイン</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>
<?php include '../include/footer.php'; ?>