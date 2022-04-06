<?php
session_start();
require '../db/dbConnect.php';

if (empty($_SESSION['username'])) {
    header('Location:login.php');
} else {
    try {
        $db = new DataSource;
        $data = $db->select('SELECT * FROM users', []);
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

    <!-- Page Content  -->
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
                    <h2>List Of Users</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $key => $value) : ?>
                                    <tr>
                                        <th scope="row"><?php echo $key; ?></th>
                                        <td><?php echo $value['fullname']; ?></td>
                                        <td><?php echo $value['email']; ?></td>
                                        <td><?php echo $value['username']; ?></td>
                                        <td><?php echo $value['role']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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