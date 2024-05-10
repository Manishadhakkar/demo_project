<?php
require_once 'connection.php';
session_start();

if (isset($_GET['id'])) {

    $sql = "DELETE FROM `products` WHERE `id` = '" . $_GET['id'] . "'";
    $result = mysqli_query($conn, $sql) or die("query failed : sql");

    if ($result) {
        header('Location: products.php');
    } else {
        header('Location: products.php');
    }
}

mysqli_close($conn);
?>