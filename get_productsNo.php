<?php

include_once 'connection.php';

$pro_id = $_POST['pro_id'];

$sql = "SELECT `total_products` FROM `products` WHERE `id` = '" . $pro_id . "'";

$res = mysqli_query($conn, $sql) or die("query failed : sql");

if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $total_products = $row['total_products'];
    }
}
echo $total_products;

mysqli_close($conn);
?>