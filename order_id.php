<?php
include_once 'connection.php';


$order_id = $_POST['order_id'];

$sql = "SELECT sales.`dest_id`,sales.category_id, `sellType`, category.category_name, plateform.plateform_name FROM `sales` 
INNER JOIN category ON sales.category_id = category.id 
INNER JOIN `plateform` ON sales.dest_id = plateform.id 
WHERE sales.order_id = '" . $order_id . "'";

// echo $sql; exit;

$res = mysqli_query($conn, $sql) or die("query failed : sql");
$result = array();
$category = array();
$str_cat = '';
$str_plateform = '';
if (mysqli_num_rows($res) > 0) {
    $str_cat .= '<option value="" selected disabled>Select Category</option>';
    while ($row = mysqli_fetch_assoc($res)) {
        //print_r($row);
        $plateform_name = $row['plateform_name'];
        $dest_id = $row['dest_id'];
        if (!in_array($row['category_name'], $category)) {
            $category[$row['category_id']] = $row['category_name'];
        }

    }
    foreach ($category as $key => $catName) {
        $str_cat .= '<option value="' . $key . '">' . $catName . '</option>';
    }
    $str_plateform = '<option value="' . $dest_id . '">' . $plateform_name . '</option>';

    echo $str_cat . '###' . $str_plateform;
    //$result[] = $str_cat;    
    //$result[] = $str_plateform;    
    //echo json_encode($result);
    //echo '<pre>'; print_r($result);
} else {
    echo 0;
}

mysqli_close($conn);
?>