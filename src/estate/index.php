<?php

require_once __DIR__ . '/db/dbConnect.php';

//マージ用配列
$content = [];
$errors = [];

if (isset($_POST['search'])) {
    //フォームからデータを取得
    $keywords = $_POST['keywords'];
    $location = $_POST['location'];

    $keyword = explode(',', $keywords);
    $concats = "(";
    $numItems = count($keyword);
    $i = 0;
    foreach ($keyword as $key => $value) {
        if (++$i === $numItems) {
            $concats .= "'" . $value . "'";
        } else {
            $concats .= "'" . $value . "',";
        }
    }
    $concats .= ")";

    $locations = explode(',', $location);
    $loc = "(";
    $numItems = count($locations);
    $i = 0;
    foreach ($locations as $key => $value) {
        if (++$i === $numItems) {
            $loc .= "'" . $value . "'";
        } else {
            $loc .= "'" . $value . "',";
        }
    }
    $loc .= ")";

    $sql = <<<EOM
    SELECT *
    FROM
        room_rental_registrations_apartment
    WHERE
        country IN $concats OR
        country IN $loc OR
        state IN $concats OR
        state IN $loc OR
        city IN $concats OR
        city IN $loc OR
        address IN $concats OR
        address IN $loc OR
        rooms IN $concats OR
        landmark IN $concats OR
        landmark IN $loc OR
        rent IN $concats OR
        deposit IN $concats
EOM;
    $dbCon = new DataSource;
    $data2 = $dbCon->select($sql);

    $sql = <<<EOM
    SELECT *
    FROM
        room_rental_registrations
    WHERE
        country IN $concats OR
        country IN $loc OR
        state IN $concats OR
        state IN $loc OR
        city IN $concats OR
        city IN $loc OR
        rooms IN $concats OR
        address IN $concats OR
        address IN $loc OR
        landmark IN $concats OR
        rent IN $concats OR
        deposit IN $concats
EOM;
    $data8 = $dbCon->select($sql);
    $content = array_merge($data2, $data8);
}

include __DIR__ .  '/views/index.php';