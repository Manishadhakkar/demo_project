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
	$searchQuery = " and (plateform.plateform_name like '%" . $searchValue . "%' or 
         category.category_name like '%" . $searchValue . "%' or 
         products.product_name like '%" . $searchValue . "%' or 
         crg.order_id like '%" . $searchValue . "%')";
}

## Total number of records without filtering
$sel1 = "select count(*) as allcount from `return`";
// echo $sel1;exit;
$sel = mysqli_query($conn, $sel1);
if (mysqli_num_rows($sel) > 0) {
	$records = mysqli_fetch_assoc($sel);
	$totalRecords = $records['allcount'];
} else {
	$totalRecords = 1;
}


## Total number of records with filtering
$sel2 = "select count(*) as allcount from `return` crg left join plateform ON crg.plateform_id=plateform.id left join category ON crg.category_id=category.id left join products on crg.product_id = products.id WHERE 1 " . $searchQuery;
$sel2 = mysqli_query($conn, $sel2);
if (mysqli_num_rows($sel2) > 0) {
	$records = mysqli_fetch_assoc($sel2);
	$totalRecordwithFilter = $records['allcount'];
} else {
	$totalRecordwithFilter = 1;
}
## Fetch records
$empQuery = "select crg.*,plateform.plateform_name, batch_nos.batch_no, category.category_name, products.product_name from `return` crg LEFT JOIN category ON category.id = crg.category_id LEFT JOIN plateform ON plateform.id = crg.plateform_id LEFT JOIN products ON products.id = crg.product_id LEFT JOIN batch_nos ON crg.batch_no = batch_nos.id WHERE 1 " . $queuenamesidss . " " . $searchQuery . " order by crg.id desc limit " . $row . "," . $rowperpage;
$empRecords = mysqli_query($conn, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
	$data[] = array(
		"id" => $i,
		"plateform" => $row['plateform_name'],
		"order_id" => $row['order_id'],
		"category" => $row['category_name'],
		"product" => $row['product_name'],
		"batch_no" => $row['batch_no'],
		"sku" => $row['sku'],
		"quantity" => $row['quantity'],
		"claim_amount" => $row['claim_amount'],
		"reason" => $row['reason'],
		"dateofreturn" => $row['date_of_return'],

		"action" => '<a href="return_edit.php?id=' . $row['id'] . '">
			<button class="item btn btn-sm btn-outline-success"><i class="fa fa-pencil"></i></button></a>
			<a href="javascript:void(0)" onclick="return deleteReturn(' . $row['id'] . ');" type="button" class=""><button class="item btn btn-sm btn-outline-danger"><i class="fa fa-trash-o"></i></button></a>
			
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
// <a href="return_edit.php?id='.$row['id'].'">
// <button class="item btn btn-sm btn-outline-success"><i class="fa fa-pencil"></i></button></a> 