<?php
include 'connection.php';

$sql = "UPDATE `user_activity_log` SET `status` = '1' WHERE `status`= '0'";

// echo $sql; exit;
$result =  mysqli_query($conn, $sql) or die("query failed");
if($result){
    echo 1;
}else{
    echo 0;
}

?>

