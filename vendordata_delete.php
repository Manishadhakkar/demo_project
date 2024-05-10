<?php
require_once 'connection.php';
session_start();

if (isset($_GET['id'])) {

    $sql = "DELETE FROM `vendors` WHERE `id` = '" . $_GET['id'] . "'";
    $result = mysqli_query($conn, $sql) or die("query failed : sql");

    if ($result) {
        header('Location: vendors.php');
    } else {
        header('Location: vendors.php');
    }
}

mysqli_close($conn);
?>