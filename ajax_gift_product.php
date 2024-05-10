<?php
include 'connection.php';
session_start();
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = 'crg.' . $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = trim(mysqli_real_escape_string($conn, $_POST['search']['value'])); // Search value

## Search 
$searchQuery = " ";
if ($searchValue != '') {
	$searchQuery = " and (crg.customer_name like '%" . $searchValue . "%' or 
         products.product_name like '%" . $searchValue . "%' or 
		 category.category_name like '%" . $searchValue . "%' or
		 batch_nos.batch_no like '%" . $searchValue . "%')";
}

## Total number of records without filtering
$sel1 = "select count(*) as allcount from gifts";
$sel = mysqli_query($conn, $sel1);
if (mysqli_num_rows($sel) > 0) {
	$records = mysqli_fetch_assoc($sel);
	$totalRecords = $records['allcount'];
} else {
	$totalRecords = 1;
}

## Total number of records with filtering
$sel2 = "select count(*) as allcount from gifts crg LEFT JOIN category ON category.id = crg.category_id LEFT JOIN products ON products.id = crg.product_id LEFT JOIN batch_nos ON crg.batch_no = batch_nos.id WHERE 1  " . $searchQuery;
$sel2 = mysqli_query($conn, $sel2);
if (mysqli_num_rows($sel2) > 0) {
	$records = mysqli_fetch_assoc($sel2);
	$totalRecordwithFilter = $records['allcount'];
} else {
	$totalRecordwithFilter = 1;
}
## Fetch records
$empQuery = "select crg.*,category.category_name, batch_nos.batch_no, products.product_name from gifts crg LEFT JOIN category ON category.id = crg.category_id LEFT JOIN products ON products.id = crg.product_id LEFT JOIN batch_nos ON crg.batch_no = batch_nos.id WHERE 1  " . $searchQuery . " order by crg.id DESC limit " . $row . "," . $rowperpage;
$empRecords = mysqli_query($conn, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
	$data[] = array(
		"gifted_by" => $row['gifted_by'],
		"customer_name" => $row['customer_name'],
		"customer_email" => $row['customer_email'],
		"customer_phone" => $row['customer_phone'],
		"customer_address" => $row['customer_address'],
		"category" => $row['category_name'],
		"product" => $row['product_name'],
		"batch_no" => $row['batch_no'],
		"quantity" => $row['quantity'],
		"date" => $row['date'],
		"action" => '<a href="javascript:void(0)" onclick="return deleteUser(' . $row['id'] . ');" type="button" class=""><button class="item btn btn-sm btn-outline-danger"><i class="fa fa-trash-o"></i></button></a>'
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