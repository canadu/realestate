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
                    <a class="nav-link" href="#"><?php echo $_SESSION['fullname']; ?> <?php if ($_SESSION['role'] == 'admin') {
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

<?php include '../include/side-nav.php'; ?>

<section class="wrapper" style="margin-left:16%;margin-top:-11%;">
    <div class="col-md-12">
        <h1>Dashboard</h1>
        <div class="row">
            <!-- adminの場合 -->
            <?php if ($_SESSION['role'] == 'admin') : ?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="../app/users.php">
                                <div class="card-counter primary">
                                    <i class="fa fa-user"></i>
                                    <span class="count-numbers"><?php echo $count[0]['register_user']; ?></span>
                                    <span class="count-name">Users</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="../app/list.php">
                                <div class="card-counter danger">
                                    <i class="fa fa-home"></i>
                                    <span class="count-numbers"><?php echo (intval($total_rent[0]['total_rent'])) + (intval($total_rent_apartment[0]['total_rent_apartment'])); ?></span>
                                    <span class="count-name">Rentals</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($_SESSION['role'] == 'user') : ?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="../app/list.php">
                                <div class="card-counter success">
                                    <i class="fa fa-home"></i>
                                    <span class="count-numbers">'<?php $total_auth_user_rent[0]['total_auth_user_rent']; ?>'</span>
                                    <span class="count-name">Registered Rooms</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    .card-counter {
        box-shadow: 2px 2px 10px #DADADA;
        margin: 5px;
        padding: 20px 10px;
        background-color: #fff;
        height: 100px;
        border-radius: 5px;
        transition: .3s linear all;
    }

    .card-counter:hover {
        box-shadow: 4px 4px 20px #DADADA;
        transition: .3s linear all;
    }

    .card-counter.primary {
        background-color: #007bff;
        color: #FFF;
    }

    .card-counter.danger {
        background-color: #ef5350;
        color: #FFF;
    }

    .card-counter.success {
        background-color: #66bb6a;
        color: #FFF;
    }

    .card-counter.info {
        background-color: #26c6da;
        color: #FFF;
    }

    .card-counter i {
        font-size: 5em;
        opacity: 0.2;
    }

    .card-counter .count-numbers {
        position: absolute;
        right: 35px;
        top: 20px;
        font-size: 32px;
        display: block;
    }

    .card-counter .count-name {
        position: absolute;
        right: 35px;
        top: 65px;
        text-transform: capitalize;
        opacity: 0.8;
        display: block;
        font-size: 18px;
    }
</style>
<?php include '../include/footer.php'; ?>