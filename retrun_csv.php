<?php
include_once 'header.php';

if (isset($_POST['submit'])) {

    //echo '<pre>'; print_r($_POST); echo '</pre>'; exit;
    $plateform = $_POST['plateform'];
    $filename = $_FILES["return_file"]["name"];
    $tempname = $_FILES["return_file"]["tmp_name"];
    $_FILES["return_file"]["size"];

    $folder = "return_files/" . $filename;
    $FileType = pathinfo($filename, PATHINFO_EXTENSION);
    $fileName = pathinfo($filename, PATHINFO_FILENAME);
    $created_at = date("Y-m-d");

    if ($plateform == '' && !isset($_FILES["return_file"]["name"]) && $_FILES["return_file"]["size"] > 0) {
        $fileErr = "All Fields are Required";
        $error = 'true';
    } elseif ($_FILES["fileToupload"]["size"] > 200000) {
        $fileErr = "image size is not greater than 2MB";
        $error = 'true';
    } elseif ($FileType !== "csv") {
        $fileErr = "only csv files are allowed";
        $error = 'true';
    } else {

        move_uploaded_file($tempname, $folder);

        $handle = fopen($folder, "r");
        $headers = fgetcsv($handle, 1000, ",");
        $created_at = date("Y-m-d");

        while (($line = fgetcsv($handle)) !== FALSE) {
            //$data[] = array_combine($headers, $line);
            $data = $line;
            $query = "SELECT `category`,`id`,`total_products` FROM `products` WHERE `sku` = '" . $data[2] . "'";

            // // echo $query.'<br>';

            $res = mysqli_query($conn, $query) or die("query failed : query");
            $total_pro = $category_id = $pro_id = '';
            if (mysqli_num_rows($res) > 0) {
                $rows = mysqli_fetch_assoc($res);
                $total_pro = $rows['total_products'];
                $category_id = $rows['category'];
                $pro_id = $rows['id'];
            }


            //  echo 'total_product'.$total_pro.'<br>';
            //  echo 'category_id'.$category_id.'<br>';
            //  echo 'product_id'.$pro_id.'<br>';

            $sql = "INSERT INTO `return`(`plateform_id`,`category_id`,`product_id`,`batch_no`,`order_id`,`sku`,`quantity`,`claim_amount`,`date_of_return`,`created_at`,`reason`) VALUES ('" . $plateform . "','" . $category_id . "','" . $pro_id . "','" . $batch_no . "','" . $data[1] . "','" . $data[2] . "','" . $data[6] . "','" . $claim_amount . "','" . $data[0] . "','" . $created_at . "','" . $data[9] . "')";

            $result = mysqli_query($conn, $sql) or die("query failed : sql");


            // echo $total_pro.'<br><br>';
            // $total_pro = $total_pro + 10;
            // echo $total_pro.'<br><br>';


            // echo '<pre>'; print_r($data); echo '</pre';

        }
        fclose($handle);
        // exit;
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                swal({
                    title: "Done",
                    text: "Return Add Successfully!!",
                    icon: "success",
                    button: "OK",
                    timer: 2000
                });
            });
        </script>
        <script>
            const myTimeout = setTimeout(
                function location() {
                    window.location.href = "return.php";
                }, 2000);
        </script>
        <?php
    }
}

?>
<section class="home">
    <div class="container">

        <?php include 'navbar.php'; ?>

        <div class="row">
            <div class="col-sm-2 p-2">
                <h3 class=""></h3>
            </div>

            <div class="col-sm-4 p-3">
                <h3 class="">Add Return</h3>
            </div>
            <div class="col-sm-3 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-3 p-2"><a href="return.php"><button class="btn btn-success">Returns</button></a></div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <span style="background-color:white; color:red; font-size:20px;">
                    <?php echo isset($fileErr) ? $fileErr : ''; ?>
                </span>
                <form class="form1" action="" method="POST" enctype="multipart/form-data">
                    <div class="mt-2">
                        <label class="block text-gray-700">Plateform *</label>
                        <select name="plateform" id="" class="form-control input">
                            <option value="">Select Plateform</option>
                            <?php
                            $plateform_sql = "SELECT * FROM `plateform`";
                            $plateform_res = mysqli_query($conn, $plateform_sql) or die("query failed : plateform_sql");
                            if (mysqli_num_rows($plateform_res) > 0) {
                                while ($row = mysqli_fetch_assoc($plateform_res)) {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['plateform_name']; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">CSV *</label>
                        <input name="return_file" id="return_file" type="file" class="form-control input" value=""
                            placeholder="">
                    </div>

                    <div class="mt-3">
                        <button type="submit" name="submit" class="btn btn-success btn-sm btn-block">Upload
                            Return</button>
                    </div>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</section>
<?php include_once 'footer.php'; ?>