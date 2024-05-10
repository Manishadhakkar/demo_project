<?php
include_once 'connection.php';

$batch_id = $_POST['batch_id'];

// echo $batch_id;

$sql = "SELECT `rem_qty` FROM `batch_nos` WHERE `id` = '" . $batch_id . "'";

$res = mysqli_query($conn, $sql) or die("query failed : sql");
$total_qty = 0;
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $rem_qty = $row['rem_qty'];
    }
}
echo $rem_qty;

mysqli_close($conn);
?>