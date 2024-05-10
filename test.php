<?php

echo date('Y-m-d H:i:s');


/* include 'connection.php';
header('Content-Type:application/json');
if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);
    $checkToken_sql = "SELECT * FROM `api_token` WHERE `token` = '" . $token . "'";
    $sql_res = mysqli_query($conn, $checkToken_sql) or die("query failed : checkToken_sql");
    if (mysqli_num_rows($sql_res) > 0) {
        $row = mysqli_fetch_assoc($sql_res);
        if ($row['status'] == 1) {
            $sql = "SELECT * FROM `user`";
            $result = mysqli_query($conn, $sql) or die("query failed : sql");
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
                $status = "true";
                $code = '5';
            } else {
                $status = "true";
                $data = "Data Not Found";
                $code = '4';
            }
        } else {
            $status = "true";
            $data = "API Token Deactivated";
            $code = '3';
        }
    } else {
        $status = "true";
        $data = "Please Provide Valid API Token";
        $code = '2';
    }
} else {
    $status = "true";
    $data = "Please Provide API Token";
    $code = '1';
}
echo json_encode(['status' => $status, 'data' => $data, 'code' => $code]); */
?>