<?php
include_once 'connection.php';

$str = '';

$c_id = $_POST['c_id'];

// echo $c_id;

$sql = "SELECT * FROM `products` WHERE `category` = '" . $c_id . "' AND `status` = '1'";

$res = mysqli_query($conn, $sql) or die("query failed : sql");

if (mysqli_num_rows($res) > 0) {
    echo '<option value="">Select Product</option>';
    while ($row = mysqli_fetch_assoc($res)) {
        $str .= '<option value="' . $row['id'] . '">' . $row['product_name'] . '</option>';
    }
} else {
    echo '<option>No Record Found</option>';
}

$query = "SELECT `igst` FROM `category` WHERE `id` = '".$c_id."'";
$result = mysqli_query($conn, $query) or die("query failed");
if(mysqli_num_rows($result) > 0){
    $rows = mysqli_fetch_assoc($result);
    $igst = $rows['igst'];
}

echo $str.'##'.$igst;
mysqli_close($conn);
?>
