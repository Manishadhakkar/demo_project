<?php
require_once 'connection.php';
require_once 'function.php';
session_start();

if (isset($_GET['id'])) {

    $pro_sql = "SELECT products.id, products.total_products,products.product_name, stocks.product_id,stocks.quantity, stocks.batch_no FROM `stocks` INNER JOIN products ON stocks.product_id = products.id WHERE stocks.`id` = '" . $_GET['id'] . "'";

    // echo $pro_sql; exit;

    $pro_res = mysqli_query($conn, $pro_sql) or die("query failed : pro_sql");
    if (mysqli_num_rows($pro_res) > 0) {
        while ($row = mysqli_fetch_assoc($pro_res)) {
            $qty = $row['quantity'];
            $total_pro = $row['total_products'];
            $pro_id = $row['id'];
            $batch_id = $row['batch_no'];
            $product_name = $row['product_name'];
        }
    }

    $batch_sql = "SELECT * FROM `batch_nos` WHERE `id` = '".$batch_id."'";
    $batch_res = mysqli_query($conn, $batch_sql) or die("query failed : batch_sql");
    if(mysqli_num_rows($batch_res) > 0){
        $rows = mysqli_fetch_assoc($batch_res);
        $rem_qty = $rows['rem_qty'];
        $batch_no = $rows['batch_no'];
    }
    $total_rem = $rem_qty - $qty;
    $up_batch = "UPDATE `batch_nos` SET `rem_qty` = '".$total_rem."' WHERE `id` = '".$batch_id."'";
    $res_batch = mysqli_query($conn, $up_batch) or die("query failed : up_batch");

    $bal_pro = $total_pro - $qty;

    $up_pro = "UPDATE `products` SET `total_products` = '" . $bal_pro . "' WHERE `id` = '" . $pro_id . "'";

    // echo $up_pro; exit;

    $up_res = mysqli_query($conn, $up_pro) or die("query failed : up_pro");


    $sql = "DELETE FROM `stocks` WHERE `id` = '" . $_GET['id'] . "'";
    $result = mysqli_query($conn, $sql) or die("query failed : sql");

    if ($result) {
        if ($_SESSION['role'] == '1') {
            $by = 'Admin';
        } else {
            $by = 'User';
        }
        $activity_type = "Stock Deleted";
        $activity_msg = $qty. " Quantity of" . " " . $product_name . " Deleted by " . $by . " From Batch No : " . $batch_no;
        user_activity_log($_SESSION['login_user_id'],$activity_type,$activity_msg);
        header('Location: stocks.php');
    } else {
        header('Location: stocks.php');
    }
}

mysqli_close($conn);
?>