<?php include_once 'header.php'; ?>

<?php
$id = $_GET['id'];
$query = "SELECT stocks.vendor_id,stocks.p_date,stocks.invoice_no,stocks.product_id,stocks.category_id,stocks.mfg_date,stocks.exp_date,stocks.batch_no,stocks.quantity,stocks.`rate/pcs`,stocks.igst,stocks.total_amount,batch_nos.batch_no, batch_nos.rem_qty FROM `stocks` INNER JOIN `batch_nos` ON stocks.batch_no = batch_nos.id WHERE `stocks`.`id` = '" . $id . "'";
// echo $query;exit;
$res_query = mysqli_query($conn, $query) or die("query failed : query");
if (mysqli_num_rows($res_query) > 0) {
    $row = mysqli_fetch_assoc($res_query);
       /*  $vendor = $row['vendor_id'];
        $pdate = $row['p_date'];
        $invoiceno = $row['invoice_no'];
        
        $category = $row['category_id'];
        $mfg = $row['mfg_date'];
        $exp = $row['exp_date']; */
        $product = $row['product_id'];
        $batchno = $row['batch_no'];
        $qty = $row['quantity'];
        $rate = $row['rate/pcs'];
        $igst = $row['igst'];
        $tot_amount = $row['total_amount'];
    }

$batch_sql = "SELECT `rem_qty` FROM `batch_nos` WHERE `batch_no` = '".$batchno."'";
$batch_res = mysqli_query($conn, $batch_sql) or die("query failed : batch_sql");
if (mysqli_num_rows($batch_res) > 0) {
    $brow = mysqli_fetch_assoc($batch_res);
    $brem_qty = $brow["rem_qty"];
}
$pro_sql = "SELECT `total_products` FROM `products` WHERE `id` = '" . $product . "'";
$pro_res = mysqli_query($conn, $pro_sql) or die("query failed : pro_sql");

if (mysqli_num_rows($pro_res) > 0) {
    $rows = mysqli_fetch_assoc($pro_res);
        $bal_products = $rows['total_products'];
}

// echo $bal_products ;exit;

if (isset($_POST['update'])) {
    $uid = $_POST['id'];
    /* $vendor_name = $_POST['vendor_name'];
    $p_date = $_POST['p_date'];
    $invoice_no = $_POST['invoice_no'];
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $mfg_date = $_POST['mfg_date'];
    $exp_date = $_POST['exp_date'];
    $batch_no = $_POST['batch_no']; */
    $quantity = $_POST['quantity'];
   /*  $rate = $_POST['rate'];
    $igst = $_POST['igst'];
    $tot_amount = $_POST['tot_amount'];
    $old_product = $_POST['old_product'];
    $old_qty = $_POST['old_qty']; */

    // echo '<pre>'; print_r($_POST);exit;

   /*  if ($old_product !== $product_name) {
        $old_sql = "SELECT `total_products` FROM `products` WHERE `id` = '" . $old_product . "'";
        $old_res = mysqli_query($conn, $old_sql) or die("query failed : old_sql");
        if (mysqli_num_rows($old_res) > 0) {
            while ($oldrow = mysqli_fetch_assoc($old_res)) {
                $old_pro = $oldrow['total_products'];
            }
        }
        $bal_old_qty = $old_pro - $old_qty;
        $up_old = "UPDATE `products` SET `total_products` = '" . $bal_old_qty . "' WHERE `id` = '" . $old_product . "'";
        $res_old = mysqli_query($conn, $up_old) or die("query failed : up_old");

        $new_sql = "SELECT `total_products` FROM `products` WHERE `id` = '" . $product_name . "'";
        $new_res = mysqli_query($conn, $new_sql) or die("query failed : new_sql");
        if (mysqli_num_rows($new_res) > 0) {
            while ($oldrow = mysqli_fetch_assoc($new_res)) {
                $new_pro = $oldrow['total_products'];
            }
        }
        $bal_new_qty = $new_pro + $quantity;
        $up_new = "UPDATE `products` SET `total_products` = '" . $bal_new_qty . "' WHERE `id` = '" . $product_name . "'";
        $res_new = mysqli_query($conn, $up_new) or die("query failed : up_new");
    } else {
        $pro_sql = "SELECT `total_products` FROM `products` WHERE `id` = '" . $product_name . "'";
        $pro_res = mysqli_query($conn, $pro_sql) or die("query failed : pro_sql");

        if (mysqli_num_rows($pro_res) > 0) {
            while ($rows = mysqli_fetch_assoc($pro_res)) {
                $bal_products = $rows['total_products'];
            }
        }
    } */

    if ($qty > $quantity) {
        $rem = $qty - $quantity;
        $total_pro = $bal_products - $rem;
        $total_batch_pro = $brem_qty - $rem;
    } else {
        $rem = $quantity - $qty;
        $total_pro = $bal_products + $rem;
        $total_batch_pro = $brem_qty + $rem;
    }
    $up_pro = "UPDATE `products` SET `total_products` = '" . $total_pro . "' WHERE `id` = '" . $product . "'";
    $up_res = mysqli_query($conn, $up_pro) or die("query failed : up_pro");

    $sql = "UPDATE `stocks` SET `quantity` = '" . $quantity . "' WHERE `id` = '" . $id . "'";
    $result = mysqli_query($conn, $sql) or die("query failed : sql");
    $up_batch = "UPDATE `batch_nos` SET `rem_qty` = '".$total_batch_pro."' WHERE `batch_no` = '".$batchno."'";
    $up_batch_res = mysqli_query($conn, $up_batch) or die("query failed : up_batch");

    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            swal({
                title: "Done",
                text: "Stocks Information Update Successfully!!",
                icon: "success",
                button: "OK",
                timer: 2000
            });
        });
    </script>
    <script>
        const myTimeout = setTimeout(
            function location() {
                window.location.href = "stocks.php";
            }, 2000);
    </script>
    <?php
}
?>

<section class="home">
    <div class="container">

        <?php include 'navbar.php'; ?>

        <div class="row">
            <div class="col-sm-2 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-4 p-2">
                <h3 class="">Stocks Information</h3>
            </div>
            <div class="col-sm-3 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-3 p-2"><a href="stocks.php"><button class="btn btn-success">Stocks</button></a></div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <span style="background-color:white; color:red; font-size:20px;">
                    <?php echo isset($message) ? $message : ''; ?>
                </span>
                <form class="form1" action="" method="POST">
                    <!-- <div class="mt-2">
                        <label class="block text-gray-700">Vendor</label>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="old_product" value="<?php echo $product; ?>">
                        <input type="hidden" name="old_qty" value="<?php echo $qty; ?>">
                        <select name="vendor_name" id="" class="form-control input">
                            <option value="">Select</option>
                            <?php
                            $vendor_sql = "SELECT * FROM `vendors`";
                            $vendor_res = mysqli_query($conn, $vendor_sql) or die("query failed : vendor_sql");
                            if (mysqli_num_rows($vendor_res) > 0) {
                                while ($row = mysqli_fetch_assoc($vendor_res)) {
                                    if ($row['id'] == $vendor) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }
                                    ?>
                                    <option <?php echo $select; ?> value="<?php echo $row['id']; ?>">
                                        <?php echo $row['vendor_name']; ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Purchase Date</label>
                        <input type="date" name="p_date" id="" value="<?php if (isset($_POST['date'])) {
                            echo $_POST['date'];
                        } else {
                            echo $pdate;
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Invoice No.</label>
                        <input type="number" name="invoice_no" id="" value="<?php if (isset($_POST['invoice_no'])) {
                            echo $_POST['invoice_no'];
                        } else {
                            echo $invoiceno;
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Category</label>
                        <select id="category" name="category" class="form-control input">
                            <option value="" selected disabled>Select</option>
                            <?php
                            $sql_cat = "SELECT * FROM `category`";
                            $res_cat = mysqli_query($conn, $sql_cat) or die("query failed : sql_cat");
                            if (mysqli_num_rows($res_cat) > 0) {
                                while ($row_cat = mysqli_fetch_assoc($res_cat)) {
                                    if ($row_cat['id'] == $category) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }
                                    ?>
                                    <option <?php echo $select; ?> value="<?php echo $row_cat['id']; ?>">
                                        <?php echo $row_cat['category_name']; ?>
                                    </option>
                                <?php }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Product Name</label>
                        <select name="product_name" id="product_name" class="form-control input product_name">
                            <option value="" selected disabled>Select</option>
                            <?php
                            $options = '';
                            $product_sql = "SELECT * FROM `products` WHERE `category` = '" . $category . "'";
                            $product_res = mysqli_query($conn, $product_sql) or die("query failed : product_sql");
                            if (mysqli_num_rows($product_res) > 0) {
                                while ($row = mysqli_fetch_assoc($product_res)) {
                                    if ($row['id'] == $product) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }
                                    ?>
                                    <option <?php echo $select; ?> value="<?php echo $row['id'] ?>">
                                        <?php echo $row['product_name'] ?>
                                    </option>
                                <?php }
                            } ?>

                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">MFG Date</label>
                        <input type="date" name="mfg_date" id="" value="<?php if (isset($_POST['date'])) {
                            echo $_POST['mfg_date'];
                        } else {
                            echo $mfg;
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">EXP Date</label>
                        <input type="date" name="exp_date" id="" value="<?php if (isset($_POST['date'])) {
                            echo $_POST['exp_date'];
                        } else {
                            echo $exp;
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Batch No.</label>
                        <input type="number" name="batch_no" id="" value="<?php if (isset($_POST['batch_no'])) {
                            echo $_POST['batch_no'];
                        } else {
                            echo $batchno;
                        } ?>" class="form-control input">
                    </div> -->
                    <div class="mt-3">
                        <label class="block text-gray-700">Quantity</label>
                        <input type="number" name="quantity" id="" value="<?php if (isset($_POST['quantity'])) {
                            echo $_POST['quantity'];
                        } else {
                            echo $qty;
                        } ?>" class="form-control input">
                    </div>
                    <!-- <div class="mt-3">
                        <label class="block text-gray-700">Rate/Pcs</label>
                        <input type="number" name="rate" id="" value="<?php if (isset($_POST['rate'])) {
                            echo $_POST['rate'];
                        } else {
                            echo $rate;
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">IGST</label>
                        <input type="number" name="igst" id="" value="<?php if (isset($_POST['igst'])) {
                            echo $_POST['igst'];
                        } else {
                            echo $igst;
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Total Amount</label>
                        <input type="number" name="tot_amount" id="" value="<?php if (isset($_POST['tot_amount'])) {
                            echo $_POST['tot_amount'];
                        } else {
                            echo $tot_amount;
                        } ?>" class="form-control input">
                    </div> -->
                    <br>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $("#category").on("change", function () {
            // var cid = $(this).attr('rel');
            var c_id = $(this).val();
            // alert(cid);
            $.ajax({
                url: "product_catg.php",
                type: "POST",
                data: { c_id, c_id },
                success: function (data) {
                    $("#product_name").html(data);
                }
            });
        });
    });

</script>
<?php include_once 'footer.php'; ?>