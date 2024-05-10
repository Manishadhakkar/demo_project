<?php 
include_once 'connection.php';

$qty = $_POST['qty'];
$rate = $_POST['rate'];
$igst = $_POST['igst'];

$total = $qty * $rate * (100 + $igst)/100;

echo $total;


mysqli_close($conn);


?>