<?php include_once 'connection.php'; 
if (isset($_POST['download'])) {

    //readfile("/path/to/yourfile.csv");
// Create an array of elements
    $csv_array = array();
    // echo '<pre>';print_r($_POST);exit;
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    // echo $from_date;exit;
    if ($from_date == '' && $to_date == '') { ?>
        <script src="js/cdn.bootcss.com_jquery_3.3.1_jquery.js"></script>
        <script src="js/unpkg.com_sweetalert@2.1.2_dist_sweetalert.min.js"></script>
        <script>
            $(document).ready(function () {
                swal({
                    title: "Please Select Date!",
                    icon: "warning",
                    timer: 2000,
                });
                const myTimeout = setTimeout(
                    function location() {
                        window.location.href = "sales.php";
                    }, 2000);
            });

        </script>
    <?php } else {
        $filename = "sales_" . date('YmdHis') . ".csv";

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Pragma: no-cache');
        $sql = "SELECT sellType,dest_id,`date`,order_id, products.product_name, category.category_name, batch_no,quantity,`rate`,total_amount  FROM `sales` 
            INNER JOIN `products` ON sales.product_id = products.id 
            INNER JOIN `category` ON sales.category_id = category.id 
            WHERE `date` BETWEEN '" . $from_date . "' AND '" . $to_date . "'";
        //  echo $sql;exit;
        $res = mysqli_query($conn, $sql) or die("query failed : sql");

        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {

                if ($row['sellType'] == 'Plateform') {
                    $sql1 = "select plateform_name from plateform where id = '" . $row['dest_id'] . "'";
                    $ress = mysqli_query($conn, $sql1) or die("query failed : sql");
                    if (mysqli_num_rows($ress) > 0) {
                        $rows = mysqli_fetch_assoc($ress);
                        $dest_name = $rows['plateform_name'];
                    }
                }
                if ($row['sellType'] == 'Warehouse') {
                    $sqlw = "select w_name from warehouse where id = '" . $row['dest_id'] . "'";
                    $resw = mysqli_query($conn, $sqlw) or die("query failed : sql");
                    if (mysqli_num_rows($resw) > 0) {
                        $rowsw = mysqli_fetch_assoc($resw);
                        $dest_name = $rowsw['w_name'];
                    }
                }
                $row['dest_name'] = $dest_name;
                unset($row['dest_id']);
                // moveElement($row, 'dest_name', 'date');
                // var_export($row);


                $csv_array[] = $row;
                // moveElement('dest_name','date');           
            }
        }
        // echo '<pre>';print_r($csv_array);exit;
        $header = array('Sell In', 'S Date', 'Order ID', 'P Name', 'Category', 'Batch No.', 'Quantity', 'Rate', 'Total Amount', 'Sell Dest');
        // echo '<pre>';print_r($pro_name);exit;
        $fp = fopen('php://output', 'a+');
        fputcsv($fp, $header);
        foreach ($csv_array as $line) {
            fputcsv($fp, $line);
        }
        fclose($fp);
    }
}