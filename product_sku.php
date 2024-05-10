<?php
include_once 'connection.php';

$str = '';

$p_id = $_POST['p_id'];

// echo $c_id;

$sql = "SELECT * FROM `products` WHERE `id` = '" . $p_id . "'";

$res = mysqli_query($conn, $sql) or die("query failed : sql");

if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $str .= $row['sku'];
    }
    echo $str;
} else {
    echo 'No Record Found';
}

mysqli_close($conn);
?>