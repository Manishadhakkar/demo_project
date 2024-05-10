<?php 

$conn = mysqli_connect("localhost","root","tumko34h1se","inventory_new") or die("conneciton failed");
// $query = 'SHOW STATUS WHERE variable_name LIKE "Threads_%" OR variable_name = "Connections"';
// //$query = 'SHOW PROCESSLIST';
// $result = mysqli_query($conn , $query);
// while($row = mysqli_fetch_array($result)){
//     echo '<pre>'; print_r($row);
// }
// exit;
session_start();
?>
