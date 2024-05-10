<?php
require_once 'connection.php';
session_start();

if (isset($_GET['id'])) {

    $sql = "DELETE FROM `warehouse` WHERE `id` = '" . $_GET['id'] . "'";
    $result = mysqli_query($conn, $sql) or die("query failed : sql");

    if ($result) {
        header('Location: warehouse.php');
    } else {
        header('Location: warehouse.php');
    }
}

mysqli_close($conn);


?>