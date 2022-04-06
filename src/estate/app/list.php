<?php
session_start();
require '../db/dbConnect.php';

if (empty($_SESSION['username'])) {
    header('Location:login.php');
} else {
    try {
        $db = new DataSource;
        if ($_SESSION['role'] == 'admin') {
            //管理者の場合
            $register_ap = $db->select('SELECT * FROM room_rental_registrations_apartment', []);
            $register = $db->select('SELECT * FROM room_rental_registrations');
            $data = array_merge($register_ap, $register);
        } elseif ($_SESSION['role'] == 'user') {
            //ユーザーの場合
            $register_ap = $db->select('SELECT * FROM room_rental_registrations_apartment WHERE :user_id = user_id', [':user_id' => $_SESSION['id']]);
            $register = $db->select('SELECT * FROM room_rental_registrations WHERE :user_id = user_id', [':user_id' => $_SESSION['id']]);
            $data = array_merge($register_ap, $register);
        }
    } catch (Exception $e) {
        $errMsg = $e->getMessage();
    }
}
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
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="wrapper">

    <!-- サイドバー -->
    <?php include '../include/side-nav.php'; ?>

    <div id="content">
        
        <!-- サイドバーの開閉ナビゲーション -->
        <button type="button" id="sidebarCollapse" class="navbar-btn">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <?php if (isset($errMsg)) : ?>
                        <div style="color:#FF0000;text-align:center;font-size:17px;"><?php echo $errMsg; ?></div>';
                    <?php endif; ?>
                    <h2>List of Property Details</h2>
                    <?php foreach($data as $key => $value); ?>
                    <div class="card card-inverse card-info mb-3" style="padding:1%;">
                        <div class="card-block">
                            <a href="update.php?id="<?php echo $value['id']."&act=" ?> class="btn btn-warning float-right"></a>
                        </div>
                    </div>
                </div>
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