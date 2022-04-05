<?php
session_start();
require '../db/dbConnect.php';

if (empty($_SESSION['username'])) {
    //ログインしていない場合はログイン画面に遷移する
    header('Location: login.php');
}
$db = new DataSource;

if ($_SESSION['role'] == 'admin') {
    //ユーザーの登録人数を取得
    $sql = "SELECT count(*) as register_user FROM users";
    $count = $db->select($sql, []);
    //物件の数を取得
    $total_rent = $db->select('SELECT count(*) as total_rent FROM room_rental_registrations');
    //物件の数(アパート)を取得
    $total_rent_apartment = $db->select('SELECT count(*) as total_rent_apartment FROM room_rental_registrations_apartment');
}

$sql = "SELECT count(*) as total_auth_user_rent FROM room_rental_registrations WHERE user_id = :user_id";
$total_auth_user_rent = $db->selectOne($sql, [':user_id' => $_SESSION['id']]);

$sql = "SELECT count(*) as total_auth_user_rent_ap FROM room_rental_registrations_apartment WHERE user_id = :user_id";
$total_auth_user_rent_ap = $db->selectOne($sql, [':user_id' => $_SESSION['id']]);
include '../include/header.php';
?>

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
                    <a class="nav-link" href="#"><?php echo $_SESSION['fullname']; ?><?php if ($_SESSION['role'] == 'admin') {
                                                                                            echo "(Admin)";
                                                                                        } ?></a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- end header nav -->

<div class="wrapper">

    <!-- サイドバー -->
    <?php include '../include/side-nav.php'; ?>

    <!-- Page Content  -->
    <div id="content">

        <!-- サイドバーの開閉ナビゲーション -->
        <button type="button" id="sidebarCollapse" class="navbar-btn">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="col-md-12">
            <div class="row">
                <?php if ($_SESSION['role'] == 'admin') : ?>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <a href="../app/users.php">
                                    <div class="card-counter primary"><i class="fa fa-user"></i>
                                        <span class="count-numbers"><?php echo $count[0]['register_user']; ?></span>
                                        <span class="count-name">Users</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="../app/list.php">
                                    <div class="card-counter danger"><i class="fa fa-home"></i>
                                        <span class="count-numbers"><?php echo (intval($total_rent[0]['total_rent']) + intval($total_rent_apartment[0]['total_rent_apartment'])); ?></span>
                                        <span class="count-name">Rentals</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php elseif ($_SESSION['role'] == 'user') : ?>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <a href="../app/list.php">
                                    <div class="card-counter success"><i class="fa fa-home"></i>
                                        <span class="count-numbers"><?php echo $total_auth_user_rent['total_auth_user_rent']; ?></span>
                                        <span class="count-name">Registered Rooms</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include '../include/footer.php'; ?>
<script>
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
            $(this).toggleClass('active');
        });
    });
</script>