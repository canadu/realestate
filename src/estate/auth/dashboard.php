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
include '../include/auth-header.php';

?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">

  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="../index.php" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- user name -->
    <li class="nav-item">
      <a class="nav-link" href="#">
        <?php echo $_SESSION['fullname']; ?><?php if ($_SESSION['role'] == 'admin') {
                                              echo "(Admin)";
                                            } ?></a>
    </li>
    <li class="nav-item">
      <a href="logout.php" class="nav-link">Logout</a>
    </li>
  </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="../img/logo.svg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SHRS</span>
  </a>
  
  <!-- sidebar -->
  <?php include '../include/auth-sidebar.php'; ?>

</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dash Board</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dash Board</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">

        <?php if ($_SESSION['role'] == 'admin') : ?>
            
            <!-- users -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?php echo $count[0]['register_user']; ?></h3>
                  <p>Users</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user"></i>
                </div>
                <a href="../app/users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            <!-- Rentals -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?php echo (intval($total_rent[0]['total_rent']) + intval($total_rent_apartment[0]['total_rent_apartment'])); ?></h3>
                  <p>Rentals</p>
                </div>
                <div class="icon">
                  <i class="fa fa-home"></i>
                </div>
                <a href="../app/list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

        <?php elseif ($_SESSION['role'] == 'users') : ?>

            <!-- Registered Rooms -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-secondary">
                <div class="inner">
                  <h3><?php echo $total_auth_user_rent['total_auth_user_rent']; ?></h3>
                  <p>Rentals</p>
                </div>
                <div class="icon">
                  <i class="fa fa-home"></i>
                </div>
                <a href="../app/list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
        <?php endif; ?>
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
  <div class="p-3">
    <h5>Title</h5>
    <p>Sidebar content</p>
  </div>
</aside>
<!-- /.control-sidebar -->

<?php include '../include/auth-footer.php'; ?>