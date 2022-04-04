<?php
if (empty($_SESSION['role'])) {
    //権限が空の場合はログイン画面へ遷移
    header('Location: login.php');
}
?>
<br>
<nav class="navbar navbar-expand-sm navbar-default sidebar" style="background-color:#212529;" id="mainNav">
    <div class="container">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive1">
            <ul class="navbar-nav text-center" style="flex-direction:column;">
                <li class="nav-item">
                    <a class="nav-link" href="../auth/dashboard.php">Home</a>
                </li>
                <!-- 登録 -->
                <li class="nav-item">
                    <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'user') {
                        echo '<a href="../app/register.php" class="nav-link">Register</a>';
                    } ?>
                </li>
                <!-- リスト -->
                <li class="nav-item">
                    <a href="../app/list.php" class="nav-link">Details/Update</a>
                </li>
                <!-- SMS送信画面 -->
                <li class="nav-item">
                    <?php if ($_SESSION['role'] == 'admin') {
                        echo '<a href="../app/sms.php" class="nav-link">Send SMS</a>';
                    } ?>
                </li>
                <!-- 苦情リスト -->
                <li class="nav-item">
                    <?php if ($_SESSION['role'] == 'admin') {
                        echo '<a href="../app/cmplist.php" class="nav-link">Complaint List</a>';
                    } ?>
                </li>
            </ul>
        </div>
    </div>
</nav>