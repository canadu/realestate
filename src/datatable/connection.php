<?php
$con = mysqli_connect('db', 'user', 'pass', 'estate');
$con->set_charset("utf8mb4");
// $con = mysqli_connect('localhost', 'root', 'root', 'db1');
if (mysqli_connect_errno()) {
    echo 'Database Connect Error';
    exit;
}
