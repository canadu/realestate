<?php
if (empty($_SESSION['role'])) {
    //権限が空の場合はログイン画面へ遷移
    header('Location: login.php');
}
?>
<nav id="sidebar">
    <!-- <div class="sidebar-header">
        <a class="navbar-brand js-scroll-trigger" href="../index.php">SHRS</a>
    </div> -->
    <ul class="list-unstyled components">
        <li>
            <a class="nav-link" href="../auth/dashboard.php">Home</a>
        </li>
        <li>
            <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'user') {
                echo '<a href="../app/register.php" class="nav-link">Register</a>';
            } ?>
        </li>
        <li>
            <a href="../app/list.php" class="nav-link">Details/Update</a>
        </li>
        <li>
            <?php if ($_SESSION['role'] == 'admin') {
                echo '<a href="../app/sms.php" class="nav-link">Send SMS</a>';
            } ?>
        </li>
        <li>
            <?php if ($_SESSION['role'] == 'admin') {
                echo '<a href="../app/cmplist.php" class="nav-link">Complaint List</a>';
            } ?>
        </li>
    </ul>
</nav>