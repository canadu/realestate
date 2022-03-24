<?php
require '../db/dbConnect.php';
include '../include/header.php';
include '../include/side-nav.php';
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
                    <a class="nav-link" href="#"><?= $_SESSION['fullname'] ?><?php if($_SESSION['role'] == 'admin'){echo "(Admin)";} ?>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<section class="wrapper" style="margin-left:16%;margin-top:-11%;">
    <div class="col-md-12">
        <h1>Dashboard</h1>


        <div class="row">
            <!-- adminの場合 -->
            <?php if($_SESSION['role'] == 'admin'): ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <a href="../app/users.php">
                            <div class="card-counter primary">
                                <i class="fa fa-user"></i>
                                <span class="count-numbers">'<?php $count['register_user']; ?>'</span>
                                <span class="count-name">Users</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="../app/list.php">
                            <div class="card-counter danger">
                                <i class="fa fa-home"></i>
                                <span class="count-numbers">'<?php (intval($total_rent['total_rent']) + intval($total_rent_apartment['total_rent_apartment'])) ?>'</span>
                                <span class="count-name">Rentals</span>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>


    </div>
</section>