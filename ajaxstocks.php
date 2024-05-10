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
	$searchQuery = " and (products.product_name like '%" . $searchValue . "%' or 
	category.category_name like '%" . $searchValue . "%' or 
	crg.invoice_no like '%" . $searchValue . "%' or 
	batch_nos.batch_no like '%".$searchValue."%')";
}


// echo $searchQuery;

## Total number of records without filtering

if ($_SESSION['role'] == 1) {
	$queuenamesid = '';
	$queuenamesidss = '';
} else {
	$queuenames = "SELECT crg.id AS id FROM stocks as crg";
	// echo $queuenames;exit;
	$resultqueue = mysqli_query($conn, $queuenames);


	$array_result = array();
	// $sizeofvalue = sizeof($resultqueue);
	$resultqueue->num_rows;
	foreach ($resultqueue as $transfer_record) {
		$destination = $transfer_record['id'];
		array_push($array_result, $destination);
	}
	$resultings = $array_result;
	$ring_id = "'" . implode("','", $resultings) . "'";
	// echo $ring_id;exit; 
	$queuenamesid = 'where id in (' . $ring_id . ')';
	$queuenamesidss = 'crg.id in (' . $ring_id . ')';

}

if ($_SESSION['role'] == 1) {
	$sel1 = "select count(*) as allcount from stocks " . $queuenamesid . "";
} else {
	$sel1 = "select count(*) as allcount from stocks " . $queuenamesid . "";
}
// echo $sel1;exit;
$sel = mysqli_query($conn, $sel1);
if (mysqli_num_rows($sel) > 0) {
	$records = mysqli_fetch_assoc($sel);
	$totalRecords = $records['allcount'];
} else {
	$totalRecords = 1;
}


## Total number of records with filtering
if ($_SESSION['role'] == 1) {
	$sel2 = "select count(*) as allcount from stocks crg left join products on crg.product_id = products.id left join category on crg.category_id = category.id left join batch_nos on crg.batch_no = batch_nos.id WHERE 1 " . $queuenamesidss . " " . $searchQuery;
} else {
	$sel2 = "select count(*) as allcount from stocks crg left join products on crg.product_id = products.id left join category on crg.category_id = category.id left join batch_nos on crg.batch_no = batch_nos.id WHERE " . $queuenamesidss . " " . $searchQuery;
}

// echo $sel2; exit;
$sel2 = mysqli_query($conn, $sel2);
if (mysqli_num_rows($sel2) > 0) {
	$records = mysqli_fetch_assoc($sel2);
	$totalRecordwithFilter = $records['allcount'];
} else {
	$totalRecordwithFilter = 1;
}
## Fetch records
if ($_SESSION['role'] == 1) {
	$empQuery = "select crg.*,vendors.vendor_name,products.product_name, batch_nos.batch_no, category.category_name from stocks crg LEFT JOIN category ON crg.category_id = category.id LEFT JOIN vendors ON crg.vendor_id = vendors.id LEFT JOIN products ON crg.product_id = products.id LEFT JOIN batch_nos ON crg.batch_no = batch_nos.id WHERE 1 " . $queuenamesidss . " " . $searchQuery . " order by crg.id DESC limit " . $row . "," . $rowperpage;
} else {
	$empQuery = "select crg.*,vendors.vendor_name,products.product_name, batch_nos.batch_no, category.category_name from stocks crg LEFT JOIN category ON category.id = crg.category_id LEFT JOIN vendors ON vendors.id = crg.vendor_id LEFT JOIN products ON products.id = crg.product_id LEFT JOIN batch_nos ON crg.batch_no = batch_nos.id WHERE " . $queuenamesidss . " " . $searchQuery . " order by crg.id DESC limit " . $row . "," . $rowperpage;
}
// echo $empQuery;
$empRecords = mysqli_query($conn, $empQuery);
// echo mysqli_num_rows($empRecords);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {

	// echo '<pre>';print_r($row);

	if($_SESSION['role'] == 1){
		$action = '<a href="stock_edit.php?id=' . $row['id'] . '">
		<button class="item btn btn-sm btn-outline-success"><i class="fa fa-pencil"></i></button></a><a href="javascript:void(0)" onclick="return deleteStocks(' . $row['id'] . ');" type="button" class=""><button class="item btn btn-sm btn-outline-danger"><i class="fa fa-trash-o"></i></button></a>';
	}else{
		$action = '<a href="javascript:void(0)" onclick="return deleteStocks(' . $row['id'] . ');" type="button" class=""><button class="item btn btn-sm btn-outline-danger"><i class="fa fa-trash-o"></i></button></a>';
	}


	$data[] = array(
		"id" => $i,
		"invoice_no" => $row['invoice_no'],
		"date" => $row['p_date'],
		"category" => $row['category_name'],
		"product_name" => $row['product_name'],
		"batch_no" => $row['batch_no'],
		"mfg_date" => $row['mfg_date'],
		"exp_date" => $row['exp_date'],
		"quantity" => $row['quantity'],
		"rem_qty" => $row['rem_qty'],
		"rate/pcs" => $row['rate/pcs'],
		"igst" => $row['igst'] . '%',
		"total_amount" => $row['total_amount'],
		"action" => $action);
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
	