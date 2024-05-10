<?php
require_once 'connection.php';
require_once 'function.php';
session_start();
if (isset($_GET['id'])) {


    $pro_sql = "SELECT products.id,products.product_name, products.total_products, gifts.quantity,gifts.batch_no,gifts.product_id FROM `gifts` LEFT JOIN products ON gifts.product_id = products.id WHERE gifts.`id` = '" . $_GET['id'] . "'";
    $result = mysqli_query($conn, $pro_sql) or die("query failed");
    if (mysqli_num_rows($result) > 0) {
        $rows = mysqli_fetch_assoc($result);
        $product_name = $rows['product_name'];
        $total_product = $rows['total_products'];
        $pro_id = $rows['id'];
        $quantity = $rows['quantity'];
        $batch_id = $rows['batch_no'];
    }

    // $query_gift = "SELECT * FROM `gifts` WHERE `id` = '".$_GET['id']."'";
    // $res_query = mysqli_query($conn, $query_gift) or die("query failed : query");
    // if(mysqli_num_rows($res_query) > 0){
    //     $row = mysqli_fetch_assoc($res_query);
    //     $fetch_gifted_by = $row['gifted_by'];
    // }
    $add_gift = $quantity + $total_product;

    $up_pro = "UPDATE `products` SET `total_products` = '" . $add_gift . "' WHERE `id` = '" . $pro_id . "'";
    $up_res = mysqli_query($conn, $up_pro) or die("query failed : up_pro");

    $sel_sql = "SELECT `rem_qty` FROM `batch_nos` WHERE `id` = '" . $batch_id . "'";
    $sel_res = mysqli_query($conn, $sel_sql) or die("query failed : sel_sql");
    if (mysqli_num_rows($sel_res) > 0) {
        while ($rows = mysqli_fetch_assoc($sel_res)) {
            $rem_qty = $rows['rem_qty'];
        }
    }
    $total_rem = $rem_qty + $quantity;

    $up_stocks = "UPDATE `batch_nos` SET `rem_qty` = '" . $total_rem . "' WHERE `id` = '" . $batch_id . "'";
    $res_stocks = mysqli_query($conn, $up_stocks) or die("query failed : up_stocks");


    $sql = "DELETE FROM `gifts` WHERE `id` = '" . $_GET['id'] . "'";
    $result = mysqli_query($conn, $sql) or die("query failed : sql");

    if ($_SESSION['role'] == '1') {
        $by = 'Admin';
    } else {
        $by = 'User';
    }
    $activity_type = "Gift Deleted";
    $activity_msg = $quantity . " Gifted Quantity of " . $product_name . " Deleted by" . $by;
    user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);

    if ($result) {
        header('Location: gifts.php');
    } else {
        header('Location: gifts.php');
    }
}

mysqli_close($conn);
?>