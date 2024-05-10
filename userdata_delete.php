<?php
require_once 'connection.php';
require_once 'function.php';
session_start();

if (isset($_GET['id'])) {

    $user_sql = "SELECT `name` FROM `users` WHERE `id` = '" . $_GET['id'] . "'";
    $user_result = mysqli_query($conn, $user_sql);
    if (mysqli_num_rows($user_result) > 0) {
        $row = mysqli_fetch_assoc($user_result);
        $fetch_name = $row['name'];
    }

    $sql = "DELETE FROM `users` WHERE `id` = '" . $_GET['id'] . "'";
    $result = mysqli_query($conn, $sql) or die("query failed : sql");

    if ($_SESSION['role'] == '1') {
        $by = 'Admin';
    } else {
        $by = 'User';
    }
    $activity_type = "User Deleted";
    $activity_msg = $fetch_name . " User Deleted by " . $by;
    user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);


    if ($result) {
        header('Location: users.php');
    } else {
        header('Location: users.php');
    }
}

mysqli_close($conn);
?>