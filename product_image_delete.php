<?php
// require_once('header.php');
include_once 'connection.php';
$id = $_POST['id'];

$sql = "SELECT `product_name`,`product_image` FROM `products` WHERE `id`= '" . $id . "'";

// echo $sql; exit;
$result = mysqli_query($conn, $sql) or die("query failed : sql");

// echo $result;exit;
// echo mysqli_num_rows($result);exit;
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $product_name = $row['product_name'];
        $product_image = $row['product_image'];
    }
}
// echo '<pre>';print_r($row);exit;



$querry = "UPDATE `products` SET product_image='' WHERE `id`= '" . $id . "'";

// echo $querry; exit;
if (mysqli_query($conn, $querry)) {
    $folder = "products_image/" . $product_image;
    unlink($folder);
    echo "1";
} else {
    echo "";
}


mysqli_close($conn);
?>