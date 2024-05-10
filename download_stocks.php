<?php include_once 'connection.php';
if (isset($_POST['download'])) {
    $csv_array = array();
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
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
                        window.location.href = "stocks.php";
                    }, 2000);
            });

        </script>
    <?php } else {
        $filename = "stocks_" . date('YmdHis') . ".csv";
        header('Pragma: no-cache');
        $sql = "SELECT stocks.p_date, stocks.invoice_no, products.product_name, category.category_name, stocks.mfg_date, stocks.exp_date, batch_nos.batch_no, stocks.quantity, batch_nos.rem_qty, stocks.igst,total_amount  FROM `stocks` INNER JOIN `products` ON stocks.product_id = products.id INNER JOIN `batch_nos` ON stocks.batch_no = batch_nos.id INNER JOIN `category` ON stocks.category_id = category.id WHERE stocks.p_date BETWEEN '" . $from_date . "' AND '" . $to_date . "'";
        // echo $sql;exit;
        $res = mysqli_query($conn, $sql) or die("query failed : sql");
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $csv_array[] = $row;
            }
        }
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename='.$filename);  
        $header =array('P Date', 'Invoice No', 'Product', 'Category', 'MFG', 'EXP', 'Batch No.', 'Quantity', 'Remaining Qty', 'IGST', 'Total Amount');      
        $fp= fopen('php://output','w');
        fputcsv($fp, $header);
        foreach($csv_array as $line) {
            fputcsv($fp, $line);
        }
        fclose($fp);

    }
}