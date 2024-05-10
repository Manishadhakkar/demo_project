<?php
require_once 'connection.php';
session_start();

if (isset($_GET['id'])) {

    $sql = "DELETE FROM `plateform` WHERE `id` = '" . $_GET['id'] . "'";
    $result = mysqli_query($conn, $sql) or die("query failed : sql");

    if ($result) {
        header('Location: plateform.php');
    } else {
        header('Location: plateform.php');
    }
}

mysqli_close($conn);
?>