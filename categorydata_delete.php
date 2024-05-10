<?php
require_once 'connection.php';
require_once 'function.php';
session_start();

if (isset($_GET['id'])) {
    $query = "SELECT * FROM `category` WHERE `id` = '" . $_GET['id'] . "'";
    $res_query = mysqli_query($conn, $query) or die("query failed : query");
    if (mysqli_num_rows($res_query) > 0) {
        $row = mysqli_fetch_assoc($res_query);
        $fetch_category = $row['category_name'];
    }

    $sql = "DELETE FROM `category` WHERE `id` = '" . $_GET['id'] . "'";
    $result = mysqli_query($conn, $sql) or die("query failed : sql");


    if ($_SESSION['role'] == '1') {
        $by = 'Admin';
    } else {
        $by = 'User';
    }
    $activity_type = "Category Delete";
    $activity_msg = $fetch_category . " Deleted by " . $by;
    user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);

    if ($result) {
        header('Location: category.php');
    } else {
        header('Location: category.php');
    }
}

mysqli_close($conn);
?>