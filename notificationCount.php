<?php 
include 'connection.php';

$sql = "SELECT count(id) as total_num FROM `user_activity_log` WHERE `status` = '0'";



// echo $sql; exit;

$result = mysqli_query($conn, $sql) or die("query failed : Notification Count");

   $count = mysqli_fetch_assoc($result);

   $total_count = $count['total_num'];
   if($total_count > 0){
    echo $total_count;
   }else{
    echo "";
   }
    // echo "<pre>";print_r($count);

?>