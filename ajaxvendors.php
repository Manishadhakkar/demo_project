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
	$searchQuery = " and (crg.vendor_name like '%" . $searchValue . "%' or 
         crg.email like '%" . $searchValue . "%')";
}
// Client.clientName like'%".$searchValue."%' ) ";
// crg.ringlist like '%".$searchValue."%' or 
// crg.ringtime like '%".$searchValue."%' or
// crg.description like '%".$searchValue."%' or
// $query_queue = "select crg.ringing as ringing,crg.name as name,Client.clientName as clientName, crg.strategy as strategy, crg.musicclass as musicclass , crg.status as status from cc_ring_group crg left join Client ON crg.clientid=Client.clientId";
// $result = mysqli_query($connection,$query_queue);

## Total number of records without filtering

if ($_SESSION['role'] == 1) {
	$queuenamesid = '';
	$queuenamesidss = '';
} else {
	$queuenames = "SELECT crg.id AS id FROM vendors as crg";
	// echo $queuenames;exit;
	$resultqueue = mysqli_query($conn, $queuenames);

	// while($rowsds = mysqli_fetch_array($resultqueue))
	// {
	// $queuenamesid = 'where name ='.$rowsds['name'];
	// $queuenamesidss = 'crg.name ='.$rowsds['name'];
	// }

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
	$sel1 = "select count(*) as allcount from vendors " . $queuenamesid . "";
} else {
	$sel1 = "select count(*) as allcount from vendors " . $queuenamesid . "";
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
	$sel2 = "select count(*) as allcount from vendors crg WHERE 1 " . $queuenamesidss . " " . $searchQuery;
} else {
	$sel2 = "select count(*) as allcount from vendors crg WHERE " . $queuenamesidss . " " . $searchQuery;
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
	$empQuery = "select crg.* from vendors crg WHERE 1 " . $queuenamesidss . " " . $searchQuery . " order by crg.id desc limit " . $row . "," . $rowperpage;
} else {
	$empQuery = "select crg.* from vendors crg WHERE " . $queuenamesidss . " " . $searchQuery . " order by crg.id desc limit " . $row . "," . $rowperpage;
}
// echo $empQuery;exit;
$empRecords = mysqli_query($conn, $empQuery);
// echo mysqli_num_rows($empRecords);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
	if ($row['status'] == '1') {
		$status = "<div class='active'>Active</div>";
	} else {
		$status = "<div class='inactive'>Inactive</div>";
	}

	$data[] = array(
		"id" => $i,
		"vendor_name" => $row['vendor_name'],
		"vendor_email" => $row['email'],
		"phone" => $row['phone'],
		"FSSAI" => $row['fssai'],
		"firm_name" => $row['firm_name'],
		"address" => $row['address'],
		"status" => $status,
		"created_at" => $row['created_at'],
		//'<span class="'.if($row['status'] == 'Active' ) { echo "status--process"; } .'">Active</span>',
		// if($_SESSION['userroleforpage'] == 1){
		"action" => '<a href="vendoredit.php?id=' . $row['id'] . '">
<button class="item btn btn-sm btn-outline-success"><i class="fa fa-pencil"></i></button></a>
<a href="javascript:void(0)" onclick="return deleteVendor(' . $row['id'] . ');" type="button" class=""><button class="item btn btn-sm btn-outline-danger"><i class="fa fa-trash-o"></i></button></a>
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