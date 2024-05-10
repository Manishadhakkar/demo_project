<?php
include_once 'connection.php';

function user_activity_log($user_id, $activity_type, $activity_message){
    global $conn;
    // $activity_date = date('Y-m-d');
    // $IP_address = $_SERVER['REMOTE_ADDR'];
    $activity_date = date("Y-m-d H:i:s");
    $log_query = "INSERT INTO `user_activity_log`(`user_id`,`activity_type`,`activity_message`,`activity_date`,`status`) VALUES('".$user_id."','".$activity_type."','".$activity_message."','".$activity_date."','0')";
    $result_query = mysqli_query($conn, $log_query);
}
?>