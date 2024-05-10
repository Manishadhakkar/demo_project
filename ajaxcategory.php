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
	$searchQuery = " and (crg.category_name like '%" . $searchValue . "%')";
}
## Total number of records without filtering
$sel1 = "select count(*) as allcount from category";
$sel = mysqli_query($conn, $sel1);
if (mysqli_num_rows($sel) > 0) {
	$records = mysqli_fetch_assoc($sel);
	$totalRecords = $records['allcount'];
} else {
	$totalRecords = 1;
}

## Total number of records with filtering
$sel2 = "select count(*) as allcount from category crg WHERE 1 " . $searchQuery;
// echo $sel2; exit;
$sel2 = mysqli_query($conn, $sel2);
if (mysqli_num_rows($sel2) > 0) {
	$records = mysqli_fetch_assoc($sel2);
	$totalRecordwithFilter = $records['allcount'];
} else {
	$totalRecordwithFilter = 1;
}
## Fetch records
$empQuery = "select crg.* from category crg WHERE 1 " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
$empRecords = mysqli_query($conn, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {

	$data[] = array(
		"id" => $i,
		"category_name" => $row['category_name'],
		"igst"=>$row['igst'].'%',
		"created_at" => $row['created_at'],
		"action" => '<a href="categoryedit.php?id=' . $row['id'] . '">
<button class="item btn btn-sm btn-outline-success"><i class="fa fa-pencil"></i></button></a>
<a href="javascript:void(0)" onclick="return deleteCategory(' . $row['id'] . ');" type="button" class=""><button class="item btn btn-sm btn-outline-danger"><i class="fa fa-trash-o"></i></button></a>
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