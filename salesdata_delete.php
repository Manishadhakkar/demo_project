<?php
require_once 'connection.php';
require_once 'function.php';
session_start();

if (isset($_GET['id'])) {

    $pro_sql = "SELECT products.total_products,products.product_name, sales.product_id,sales.quantity,sales.batch_no FROM `sales` INNER JOIN products ON sales.product_id = products.id WHERE sales.`id` = '" . $_GET['id'] . "'";

    
    $pro_res = mysqli_query($conn, $pro_sql) or die("query failed : pro_sql");
    if (mysqli_num_rows($pro_res) > 0) {
        $row = mysqli_fetch_assoc($pro_res);
            $qty = $row['quantity'];
            $total_pro = $row['total_products'];
            $pro_id = $row['product_id'];
            $batch_id = $row['batch_no'];
            $product_name = $row['product_name'];
    }
    $bal_pro = $total_pro + $qty;

    $up_pro = "UPDATE `products` SET `total_products` = '" . $bal_pro . "' WHERE `id` = '" . $pro_id . "'";
    $up_res = mysqli_query($conn, $up_pro) or die("query failed : up_pro");


    $sel_sql = "SELECT `rem_qty`,`batch_no` FROM `batch_nos` WHERE `id` = '" . $batch_id . "'";
    $sel_res = mysqli_query($conn, $sel_sql) or die("query failed : sel_sql");
    if (mysqli_num_rows($sel_res) > 0) {
        $rows = mysqli_fetch_assoc($sel_res);
            $rem_qty = $rows['rem_qty'];
            $batch_no = $rows['batch_no'];
    }
    $total_rem = $rem_qty + $qty;

    $up_stocks = "UPDATE `batch_nos` SET `rem_qty` = '" . $total_rem . "' WHERE `id` = '" . $batch_id . "'";
    $res_stocks = mysqli_query($conn, $up_stocks) or die("query failed : up_stocks");


    $sql = "DELETE FROM `sales` WHERE `id` = '" . $_GET['id'] . "'";
    $result = mysqli_query($conn, $sql) or die("query failed : sql");

    if ($result) {
        if ($_SESSION['role'] == '1') {
            $by = 'Admin';
        } else {
            $by = 'User';
        }
        $activity_type = "Sale Deleted";
        $activity_msg = $qty. " Quantity of" . " " . $product_name . " Deleted by " . $by . " From Batch No : " . $batch_no;
        user_activity_log($_SESSION['login_user_id'],$activity_type,$activity_msg);
        header('Location: sales.php');
    } else {
        header('Location: sales.php');
    }
}


mysqli_close($conn);
?>
