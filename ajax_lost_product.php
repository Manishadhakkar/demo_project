<?php
include 'connection.php';
session_start();
// echo '<pre>'; print_r($_POST);exit;
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = 'crg.' . $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($conn, $_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if ($searchValue != '') {
	$searchQuery = " and (crg.order_id like '%" . $searchValue . "%' or 
         products.product_name like '%" . $searchValue . "%' or
		 category.category_name like '%".$searchValue."%' or
		 batch_nos.batch_no like '%".$searchValue."%' or
		 plateform.plateform_name like '%".$searchValue."%')";
}


## Total number of records without filtering

$sel1 = "select count(*) as allcount from lost_product";
// echo $sel1;exit;
$sel = mysqli_query($conn, $sel1);
if (mysqli_num_rows($sel) > 0) {
	$records = mysqli_fetch_assoc($sel);
	$totalRecords = $records['allcount'];
} else {
	$totalRecords = 1;
}

## Total number of records with filtering

$sel2 = "select count(*) as allcount from lost_product crg LEFT JOIN category ON category.id = crg.category_id LEFT JOIN plateform ON plateform.id = crg.plateform_id LEFT JOIN batch_nos  ON crg.batch_no = batch_nos.id LEFT JOIN products ON products.id = crg.product_id WHERE 1 " . $searchQuery;
// echo $sel2; exit;
$sel2 = mysqli_query($conn, $sel2);
if (mysqli_num_rows($sel2) > 0) {
	$records = mysqli_fetch_assoc($sel2);
	$totalRecordwithFilter = $records['allcount'];
} else {
	$totalRecordwithFilter = 1;
}
## Fetch records

$empQuery = "select crg.*,plateform.plateform_name, category.category_name, batch_nos.batch_no, products.product_name from lost_product crg LEFT JOIN category ON category.id = crg.category_id LEFT JOIN plateform ON plateform.id = crg.plateform_id LEFT JOIN batch_nos  ON crg.batch_no = batch_nos.id LEFT JOIN products ON products.id = crg.product_id WHERE 1  " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
//  echo $empQuery;exit;
$empRecords = mysqli_query($conn, $empQuery);
// echo mysqli_num_rows($empRecords);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
	// $row['product_image']
	// $view = 
	// $image = '<img src="products_image/'.$row['product_image'].'" width="80px" height="80px"/>';

	$data[] = array(
		"id" => $i,
		"plateform" => $row['plateform_name'],
		"category" => $row['category_name'],
		"product" => $row['product_name'],
		"batch_no" => $row['batch_no'],
		"quantity" => $row['quantity'],
		"order_id" => $row['order_id'],
		"action" => '<a href="lost_products_edit.php?id=' . $row['id'] . '">
<button class="item btn btn-sm btn-outline-success"><i class="fa fa-pencil"></i></button></a>
<a href="javascript:void(0)" onclick="return deleteUser(' . $row['id'] . ');" type="button" class=""><button class="item btn btn-sm btn-outline-danger"><i class="fa fa-trash-o"></i></button></a>
'
	);
	$i++;
}
## Response
$response = array(
	"draw" => intval($draw),
	"iTotalRecords" => $totalRecords,
	"iTotalDisplayRecords" => $totalRecordwithFilter,
	"aaData" => $data
);

echo json_encode($response);
mysqli_close($conn);