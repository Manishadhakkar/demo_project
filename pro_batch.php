<?php
include_once 'connection.php';

$p_id = $_POST['p_id'];

$sql = "SELECT `id`,`batch_no` FROM `batch_nos` WHERE `product_id` = '" . $p_id . "' AND `rem_qty` > '0' order by `id`";

// echo $sql;exit;
$res = mysqli_query($conn, $sql) or die("query failed : sql");

$str = '';
if (mysqli_num_rows($res) > 0) {
    echo '<option value="">Select Batch</option>';
    while ($row = mysqli_fetch_assoc($res)) {
        $str .= '<option value="' . $row['id'] . '">' . $row['batch_no'] . '</option>';
    }
    echo $str;
} else {
    echo '<option>No Record Found</option>';
}
mysqli_close($conn);
?>