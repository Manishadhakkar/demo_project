<?php
include_once 'connection.php';

$product_id = $_POST['p_id'];
$order_id = $_POST['order_id'];

$sql = "select batch_nos.`id`,batch_nos.batch_no from sales inner join batch_nos on sales.batch_no = batch_nos.id where sales.product_id = '" . $product_id . "' and order_id = '" . $order_id . "'";
// echo $sql;exit;
$str = '';
$res = mysqli_query($conn, $sql) or die('query failed : sql');
if (mysqli_num_rows($res) > 0) {
    $str .= "<option value=''>Select Batch</option>";
    while ($row = mysqli_fetch_assoc($res)) {
        $str .= "<option value='" . $row['id'] . "'>" . $row['batch_no'] . "</option>";
    }
    echo $str;
}

?>