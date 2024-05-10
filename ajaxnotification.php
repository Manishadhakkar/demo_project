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
	$searchQuery = " and (users.name like '%" . $searchValue . "%' or 
	crg.activity_type like '%" . $searchValue . "%')";
}

## Total number of records without filtering

if ($_SESSION['role'] == 1) {
	$queuenamesid = '';
	$queuenamesidss = '';
} else {
	$queuenames = "SELECT crg.id AS id FROM user_activity_log as crg";
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
	$sel1 = "select count(*) as allcount from user_activity_log " . $queuenamesid . "";
} else {
	$sel1 = "select count(*) as allcount from user_activity_log " . $queuenamesid . "";
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
	$sel2 = "select count(*) as allcount, users.name from user_activity_log crg LEFT JOIN users ON crg.user_id = users.id WHERE 1 " . $queuenamesidss . " " . $searchQuery;
} else {
	$sel2 = "select count(*) as allcount, users.name from user_activity_log crg LEFT JOIN users ON crg.user_id = users.id WHERE 1 " . $queuenamesidss . " " . $searchQuery;
}

// echo $sel2; exit;
$sel2 = mysqli_query($conn, $sel2);
if (mysqli_num_rows($sel2) > 0) {
	$records = mysqli_fetch_assoc($sel2);
	$totalRecordwithFilter = $records['allcount'];
	// echo $totalRecordwithFilter;
} else {
	$totalRecordwithFilter = 1;
}
## Fetch records
if ($_SESSION['role'] == 1) {
	$empQuery = "select crg.*, users.id, users.name, users.status, users.role from user_activity_log crg left join users ON crg.user_id=users.id  WHERE 1 ".$queuenamesidss." ".$searchQuery." order by crg.id desc limit ".$row.",".$rowperpage;
} else {
	$empQuery = "select crg.*, users.id, users.name, users.status, users.role from user_activity_log crg left join users ON crg.user_id=users.id  WHERE 1 ".$queuenamesidss." ".$searchQuery." order by crg.id desc limit ".$row.",".$rowperpage;
}
// echo $empQuery;exit;
$empRecords = mysqli_query($conn, $empQuery);
// echo mysqli_num_rows($empRecords);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {


	$data[] = array(
		"id" => $i,
		"username" => $row['name'],
		"activity_type" => $row['activity_type'],
		"message" => $row['activity_message'],
		"activity_time" => $row['activity_date'],
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

	