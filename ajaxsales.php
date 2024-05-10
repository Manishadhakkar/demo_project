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
    category.category_name like '%" . $searchValue . "%' or
    products.product_name like '%" . $searchValue . "%' or
	plateform.plateform_name like '%" . $searchValue . "%' or 
	crg.date like '%" . $searchValue . "%' or 
	batch_nos.batch_no like '%".$searchValue."%')";
}


## Total number of records without filtering

if ($_SESSION['role'] == 1) {
	$queuenamesid = '';
	$queuenamesidss = '';
} else {
	$queuenames = "SELECT crg.id AS id FROM sales as crg";
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
	$ring_id = "'" . implode("', '", $resultings) . "'";
	$queuenamesid = 'where id in (' . $ring_id . ')';
	$queuenamesidss = 'crg.id in (' . $ring_id . ')';

}

if ($_SESSION['role'] == 1) {
	$sel1 = "select count(*) as allcount from sales " . $queuenamesid . "";
} else {
	$sel1 = "select count(*) as allcount from sales " . $queuenamesid . "";
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
	$sel2 = "select count(*) as allcount,category.category_name,products.product_name,plateform.plateform_name,batch_nos.batch_no from sales crg LEFT JOIN category ON crg.category_id = category.id LEFT JOIN products ON crg.product_id = products.id LEFT JOIN plateform ON crg.dest_id = plateform.id LEFT JOIN batch_nos ON crg.batch_no = batch_nos.id WHERE 1 " . $queuenamesidss . " " . $searchQuery;
} else {
	$sel2 = "select count(*) as allcount,category.category_name,products.product_name,plateform.plateform_name,batch_nos.batch_no from sales crg LEFT JOIN category ON crg.category_id = category.id LEFT JOIN products ON crg.product_id = products.id LEFT JOIN plateform ON crg.dest_id = plateform.id LEFT JOIN batch_nos ON crg.batch_no = batch_nos.id WHERE " . $queuenamesidss . " " . $searchQuery;
}

// echo $sel2; exit;
$sel2 = mysqli_query($conn, $sel2);
// echo mysqli_num_rows($sel2);
if (mysqli_num_rows($sel2) > 0) {
	$records = mysqli_fetch_assoc($sel2);
	$totalRecordwithFilter = $records['allcount'];
} else {
	$totalRecordwithFilter = 1;
}
## Fetch records
if ($_SESSION['role'] == 1) {
	$empQuery = "select crg.*, products.product_name, batch_nos.batch_no, category.category_name from sales crg LEFT JOIN category ON category.id = crg.category_id LEFT JOIN products ON products.id = crg.product_id LEFT JOIN batch_nos ON crg.batch_no = batch_nos.id LEFT JOIN `plateform` ON crg.dest_id = plateform.id WHERE 1 " . $queuenamesidss . " " . $searchQuery . " order by crg.id DESC limit " . $row . "," . $rowperpage;
} else {
	$empQuery = "select crg.*, products.product_name, batch_nos.batch_no, category.category_name from sales crg LEFT JOIN category ON category.id = crg.category_id LEFT JOIN products ON products.id = crg.product_id LEFT JOIN batch_nos ON crg.batch_no = batch_nos.id LEFT JOIN `plateform` ON crg.dest_id = plateform.id WHERE " . $queuenamesidss . " " . $searchQuery . " order by crg.id DESC limit " . $row . "," . $rowperpage;
}
// echo $empQuery;exit;
$empRecords = mysqli_query($conn, $empQuery);
// echo mysqli_num_rows($empRecords);exit;
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {

	if ($row['sellType'] == 'Warehouse') {
		$sql = "select w_name from warehouse where id = '" . $row['dest_id'] . "'";
		$res = mysqli_query($conn, $sql) or die("query failed : sql");
		if (mysqli_num_rows($res) > 0) {
			$rows = mysqli_fetch_assoc($res);
			$dest_name = $rows['w_name'];
		}
	} else {
		$sql = "select plateform_name from plateform where id = '" . $row['dest_id'] . "'";
		$res = mysqli_query($conn, $sql) or die("query failed : sql");
		if (mysqli_num_rows($res) > 0) {
			$rows = mysqli_fetch_assoc($res);
			$dest_name = $rows['plateform_name'];
		}
	}

	$data[] = array(
		"id" => $i,
		"sellType" => $row['sellType'],
		"dest_id" => $dest_name,
		"order_id" => $row['order_id'],
		"date" => $row['date'],
		"category" => $row['category_name'],
		"product_name" => $row['product_name'],
		"batch_no" => $row['batch_no'],
		"quantity" => $row['quantity'],
		"rate/pcs" => $row['rate'],
		"total_amount" => $row['total_amount'],
		"action" => '<a href="javascript:void(0)" onclick="return deleteSales(' . $row['id'] . ');" type="button" class=""><button class="item btn btn-sm btn-outline-danger"><i class="fa fa-trash-o"></i></button></a>'
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