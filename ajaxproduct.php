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
	$searchQuery = " and (crg.product_name like '%" . $searchValue . "%' or 
         crg.sku like '%" . $searchValue . "%')";
}


// echo $searchQuery;
## Total number of records without filtering

if ($_SESSION['role'] == 1) {
	$queuenamesid = '';
	$queuenamesidss = '';
} else {
	$queuenames = "SELECT crg.id AS id FROM products as crg";
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
	$sel1 = "select count(*) as allcount from products " . $queuenamesid . "";
} else {
	$sel1 = "select count(*) as allcount from products " . $queuenamesid . "";
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
	$sel2 = "select count(*) as allcount from products crg WHERE 1 " . $queuenamesidss . " " . $searchQuery;
} else {
	$sel2 = "select count(*) as allcount from products crg WHERE " . $queuenamesidss . " " . $searchQuery;
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
	$empQuery = "select crg.*,vendors.vendor_name, category.category_name from products crg LEFT JOIN category ON category.id = crg.category LEFT JOIN vendors ON vendors.id = crg.vendor WHERE 1 " . $queuenamesidss . " " . $searchQuery . " order by crg.id DESC limit " . $row . "," . $rowperpage;
} else {
	$empQuery = "select crg.*,vendors.vendor_name, category.category_name from products crg LEFT JOIN category ON category.id = crg.category LEFT JOIN vendors ON vendors.id = crg.vendor WHERE " . $queuenamesidss . " " . $searchQuery . " order by crg.id DESC limit " . $row . "," . $rowperpage;
}
// echo $empQuery;exit;
$empRecords = mysqli_query($conn, $empQuery);
// echo mysqli_num_rows($empRecords);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
	// $row['product_image']
	// echo"<pre>";print_r($row);
	$image = '<div id="thumbwrap">
		<a class="thumb" href=""><img src="products_image/' . $row['product_image'] . '" /><span><img src="products_image/' . $row['product_image'] . '" class="big_img" /></span></a>
    </div> ';
	if ($row['status'] == '1') {
		$status = "<div class='active'>Active</div>";
	} else {
		$status = "<div class='inactive'>Inactive</div>";
	}

	if ($row['total_products'] <= $row['min_qty'])
	{
		$total_products = "<div class='btn btn-lg btn-danger'>".$row['total_products']."</div>";
	} else {
		$total_products = $row['total_products'];
	}
	
	$data[] = array(
		"id" => $i,
		// "vendor"=>$row['vendor_name'],
		"category" => $row['category_name'],
		"product_name" => $row['product_name'],
		"sku" => $row['sku'],
		"total_products" => $total_products,
		"minimum_qty" => $row['min_qty'],
		// "price"=>$row['price'],
		//"quantity"=>$row['quantity'],
		"created_date" => $row['created_date'],
		"status" => $status,
		"view_image" => $image,
		//'<span class="'.if($row['status'] == 'Active' ) { echo "status--process"; } .'">Active</span>',
		// if($_SESSION['userroleforpage'] == 1){
		"action" => '<a href="products_edit.php?id=' . $row['id'] . '">
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