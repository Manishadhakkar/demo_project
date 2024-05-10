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
	crg.batch_no like '%" . $searchValue . "%')";
}


## Total number of records without filtering
$sel1 = "select count(*) as allcount from batch_nos where `rem_qty` > 0";
// echo $sel1;exit;
$sel = mysqli_query($conn, $sel1);
if (mysqli_num_rows($sel) > 0) {
	$records = mysqli_fetch_assoc($sel);
	$totalRecords = $records['allcount'];
} else {
	$totalRecords = 1;
}

## Total number of records with filtering
$sel2 = "select count(*) as allcount,products.product_name from batch_nos crg LEFT JOIN products ON crg.product_id = products.id where 1 and crg.`rem_qty` > 0" . $searchQuery;

// echo $sel2; exit;
$sel2 = mysqli_query($conn, $sel2);
if (mysqli_num_rows($sel2) > 0) {
	$records = mysqli_fetch_assoc($sel2);
	$totalRecordwithFilter = $records['allcount'];
} else {
	$totalRecordwithFilter = 1;
}
## Fetch records

$empQuery = "select crg.*,products.product_name from batch_nos crg LEFT JOIN products ON products.id = crg.product_id  WHERE 1 and crg.`rem_qty` > 0 " . $searchQuery . " order by crg.id DESC limit " . $row . "," . $rowperpage;
// echo $empQuery;exit;
$empRecords = mysqli_query($conn, $empQuery);
// echo mysqli_num_rows($empRecords);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
	$data[] = array(
		"id" => $i,
		// "category" => $row['category_name'],
		"product_name" => $row['product_name'],
		"batch_no" => $row['batch_no'],
		"rem_qty" => $row['rem_qty'],
		"action" => '
<a href="javascript:void(0)" onclick="return deleteStocks(' . $row['id'] . ');" type="button" class=""><button class="item btn btn-sm btn-outline-danger"><i class="fa fa-trash-o"></i></button></a>');
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

?>
