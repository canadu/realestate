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

                    <?php foreach ($data as $key => $value) : ?>
                        
                        <div class="card card-info mb-3" style="padding:1%;">

                            <div class="card-header">

                            </div>

                            <div class="card-block">
                                <a href="update.php?id=" <?php echo $value['id'] . "&act=" ?> class="btn btn-warning float-right"></a>
                                <div class="row">
                                    <div class="col4">
                                        <h4 class="text-center">Owner Details</h4>
                                        <p><b>Owner Name:</b><?php echo $value['fullname'] ?></p>
                                        <p><b>Contact Number:</b><?php echo $value['mobile'] ?></p>
                                        <p><b>Alternate Number:</b><?php echo $value['alternat_mobile'] ?></p>
                                        <p><b>Email:</b><?php echo $value['email'] ?></p>
                                        <p><b>Country:</b><?php echo $value['country'] ?></p>
                                        <p><b>State:</b><?php echo $value['state'] ?></p>
                                        <p><b>City:</b><?php echo $value['city'] ?></p>
                                        <?php if ($value['image'] == 'uploads/') : ?>
                                            <img src="<?php echo $value['image']; ?>" alt="" width="200">
                                        <?php endif; ?>
                                        <p><b>Address:</b><?php echo $value['address'] ?></p>
                                        <p><b>Landmark:</b><?php echo $value['landmark'] ?></p>
                                    </div>
                                    <div class="col-5">
                                        <h4 class="text-center">Room Details</h4>
                                        <p><b>Plot Number:</b><?php echo $value['plot_number']; ?></p>
                                        <?php if (isset($value['sale'])) : ?>
                                            <p><b>Sale:</b><?php echo $value['sale']; ?></p>
                                        <?php endif; ?>
                                        <?php if (isset($value['apartment_name'])) : ?>
                                            <div class="alert alert-success" role="alert">
                                                <p><b>Apartment Name:</b><?php echo $value['apartment_name']; ?>/p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($value['ap_numbers_of_plats'])) : ?>
                                            <div class="alert alert-success" role="alert">
                                                <p><b>Flat Number:</b><?php echo $value['ap_numbers_of_plats']; ?>/p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($value['own'])) : ?>
                                            <p><b>Available Area:</b><?php echo $value['area']; ?></p>
                                            <p><b>Floor:</b><?php echo $value['floor']; ?></p>
                                            <p><b>Owner/Rented:</b><?php echo $value['own']; ?></p>
                                            <p><b>Purpose:</b><?php echo $value['purpose']; ?></p>
                                        <?php endif; ?>
                                        <p><b>Available Rooms:</b><?php echo $value['rooms']; ?></p>
                                    </div>
                                    <div class="col-3">
                                        <h4>Other Details</h4>
                                        <p><b>Accommodation:</b><?php echo $value['accommodation']; ?></p>
                                        <p><b>Description:</b><?php echo $value['description']; ?></p>
                                        <?php if ($value['vacant'] == 0) : ?>
                                            <div class="alert alert-danger" role="alert">
                                                <p><b>Occupied</b></p>
                                            </div>
                                        <?php else : ?>
                                            <div class="alert alert-danger" role="alert">
                                                <p><b>Vacant</b></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <a href="../app/complaint.php" class="btn btn-warning float-right">Complaint</a>
                        </div>
                    <?php endforeach; ?>

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