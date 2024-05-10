<?php
require_once 'connection.php';
session_start();

if (isset($_GET['id'])) {

    $pro_sql = "SELECT return.product_id, products.total_products, return.quantity,return.batch_no FROM `return` LEFT JOIN products ON return.product_id = products.id WHERE  `return`.`id` = '" . $_GET['id'] . "'";
    // echo $pro_sql; exit;
    $result = mysqli_query($conn, $pro_sql) or die("query failed");
    if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
            $total_product = $rows['total_products'];
            $pro_id = $rows['product_id'];
            $quantity = $rows['quantity'];
            $batch_id = $rows['batch_no'];
        }
    }
    $add_gift = $total_product - $quantity;


    $up_pro = "UPDATE `products` SET `total_products` = '" . $add_gift . "' WHERE `id` = '" . $pro_id . "'";
    $up_res = mysqli_query($conn, $up_pro) or die("query failed : up_pro");

    $sel_sql = "SELECT `rem_qty` FROM `batch_nos` WHERE `id` = '" . $batch_id . "'";
    $sel_res = mysqli_query($conn, $sel_sql) or die("query failed : sel_sql");
    if (mysqli_num_rows($sel_res) > 0) {
        while ($rows = mysqli_fetch_assoc($sel_res)) {
            $rem_qty = $rows['rem_qty'];
        }
    }
    $total_rem = $rem_qty - $quantity;

    $up_stocks = "UPDATE `batch_nos` SET `rem_qty` = '" . $total_rem . "' WHERE `id` = '" . $batch_id . "'";
    $res_stocks = mysqli_query($conn, $up_stocks) or die("query failed : up_stocks");

    $sql = "DELETE FROM `return` WHERE `id` = '" . $_GET['id'] . "'";
    $result = mysqli_query($conn, $sql) or die("query failed : sql");

    if ($result) {
        header('Location: return.php');
    } else {
        header('Location: return.php');
    }
}

mysqli_close($conn);
?>