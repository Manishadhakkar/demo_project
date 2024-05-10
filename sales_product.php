<?php
include_once 'connection.php';

$cat_id = $_POST['c_id'];
$order_id = $_POST['order_id'];
$sql = "select product_id, products.product_name from sales inner join products on sales.product_id=products.id where category_id = '" . $cat_id . "' and `order_id` = '" . $order_id . "'";

$product = array();

// echo $sql;
$str = '';
$res = mysqli_query($conn, $sql) or die("query failed : sql");
if (mysqli_num_rows($res) > 0) {
    $str .= '<option value="">Select Product</option>';
    while ($row = mysqli_fetch_assoc($res)) {
        $product_name = $row['product_name'];
        $pro_id = $row['product_id'];
        if (!in_array($row['product_name'], $product)) {
            $product[$row['product_id']] = $row['product_name'];
        }
    }
    foreach ($product as $key => $value) {
        $str .= '<option value="' . $key . '">' . $value . '</option>';
    }
    echo $str;
}

?>