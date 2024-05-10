<?php include_once 'header.php'; ?>

<?php
$id = $_GET['id'];
$query = "SELECT * FROM `sales` WHERE `id` = '" . $id . "'";
$res_query = mysqli_query($conn, $query) or die("query failed : query");
if (mysqli_num_rows($res_query) > 0) {
    while ($row = mysqli_fetch_assoc($res_query)) {
        $plateform = $row['plateform_id'];
        $sdate = $row['date'];
        $order_id = $row['order_id'];
        $category_id = $row['category_id'];
        $product_id = $row['product_id'];
        $old_batch_no = $row['batch_no'];
        $qty = $row['quantity'];
        $rate = $row['rate'];
        $tot_amount = $row['total_amount'];
    }
}
// echo '<pre>';print_r($row);exit;

if (isset($_POST['update'])) {

    // echo '<pre>';print_r($_POST);exit;
    $uid = $_POST['id'];
    $plateform_name = $_POST['plateform_name'];
    $orderid = $_POST['order_id'];
    $s_date = $_POST['s_date'];
    $category = $_POST['category'];
    $product_name = $_POST['product_name'];
    $old_productId = $_POST['old_productId'];
    $new_batch = $_POST['new_batch'];
    $old_batch = $_POST['old_batch'];
    $old_qty = $_POST['old_qty'];
    $quantity = $_POST['quantity'];
    $rate = $_POST['rate'];
    $tot_amount = $_POST['tot_amount'];

    // $created_at = date("Y-m-d");
    if ($plateform_name == '' || $orderid == '' || $s_date == '' || $category == '' || $product_name == '' || $quantity == '' || $rate == '' || $tot_amount == '' || $new_batch == '') {
        $message = "All * Fields Are required.";
    } else {

        $oldbatchsql = "SELECT `rem_qty` FROM `stocks` WHERE `batch_no` = '" . $old_batch . "'";
        $oldbatchres = mysqli_query($conn, $oldbatchsql) or die("query failed : oldbatchsql");
        if (mysqli_num_rows($oldbatchres) > 0) {
            while ($oldBatchrows = mysqli_fetch_assoc($oldbatchres)) {
                $oldbatchrem_qty = $oldBatchrows['rem_qty'];
            }
        }
        $newbatchsql = "SELECT `rem_qty` FROM `stocks` WHERE `batch_no` = '" . $new_batch . "'";
        $newbatchres = mysqli_query($conn, $newbatchsql) or die("query failed : newbatchsql");
        if (mysqli_num_rows($newbatchres) > 0) {
            while ($newBatchrows = mysqli_fetch_assoc($newbatchres)) {
                $newbatchrem_qty = $newBatchrows['rem_qty'];
            }
        }

        $oldProductssql = "SELECT `total_products` FROM `products` WHERE `id` = '" . $old_productId . "'";
        $oldProductres = mysqli_query($conn, $oldProductssql) or die("query failed : oldProductssql");
        if (mysqli_num_rows($oldProductres) > 0) {
            while ($oldProductsrows = mysqli_fetch_assoc($oldProductres)) {
                $oldProductsqty = $oldProductsrows['total_products'];
            }
        }

        $newProductssql = "SELECT `total_products` FROM `products` WHERE `id` = '" . $product_name . "'";
        $newProductres = mysqli_query($conn, $newProductssql) or die("query failed : newProductssql");
        if (mysqli_num_rows($newProductres) > 0) {
            while ($newProductsrows = mysqli_fetch_assoc($newProductres)) {
                $newProductsqty = $newProductsrows['total_products'];
            }
        }

        echo 'old stock ' . $oldbatchrem_qty . "<br>";
        echo 'new stock ' . $newbatchrem_qty . "<br>";
        echo 'old products ' . $oldProductsqty . "<br>";
        echo 'new products ' . $newProductsqty . "<br>";
        if ($old_productId !== $product_name) {
            if ($old_qty > $quantity) {
                $rem = $old_qty - $quantity;
                $total_oldpro = $oldProductsqty + $rem;
                $total_oldrem = $oldbatchrem_qty + $rem;
                $total_newpro = $newProductsqty - $rem;
                $total_newrem = $newbatchrem_qty - $rem;
            } else {
                $rem = $quantity - $old_qty;
                $total_oldpro = $oldProductsqty - $rem;
                $total_oldrem = $oldbatchrem_qty - $rem;
                $total_newpro = $newProductsqty + $rem;
                $total_newrem = $newbatchrem_qty + $rem;

                echo $rem . '<br>';
                echo $total_oldpro . '<br>';
                echo $total_oldrem . '<br>';
                echo $total_newpro . '<br>';
                echo $total_newrem . '<br>';
                exit;
            }

        }
        // exit;
        // quantity change condition start

        // if($qty > $quantity){
        //     $rem = $qty - $quantity;
        //     $total_pro = $bal_products + $rem;
        //     $total_rem = $rem_qty + $rem;
        // }else{
        //     $rem = $quantity - $qty;
        //     $total_pro = $bal_products - $rem;
        //     $total_rem = $rem_qty - $rem;
        // }

        // $up_pro = "UPDATE `products` SET `total_products` = '".$total_pro."' WHERE `id` = '".$product_name."'";
        // $up_res = mysqli_query($conn, $up_pro) or die("query failed : up_pro");

        // $up_stocks = "UPDATE `stocks` SET `rem_qty` = '".$total_rem."' WHERE `batch_no` = '".$batch_no."'";
        // $res_stocks = mysqli_query($conn, $up_stocks) or die("query failed : up_stocks");

        //  quantity change condition end

        $sql = "UPDATE `sales` SET `plateform_id` = '" . $plateform_name . "', `date` = '" . $s_date . "', `order_id` = '" . $orderid . "', `category_id` = '" . $category . "', `product_id` = '" . $product_name . "',`batch_no` = '" . $batch . "', `quantity` = '" . $quantity . "', `rate` = '" . $rate . "',`total_amount` = '" . $tot_amount . "' WHERE `id` = '" . $uid . "'";
        $result = mysqli_query($conn, $sql) or die("query failed : sql");
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                swal({
                    title: "Done",
                    text: "Sales Information Update Successfully!!",
                    icon: "success",
                    button: "OK",
                    timer: 2000
                });
            });
        </script>
        <script>
            const myTimeout = setTimeout(
                function location() {
                    window.location.href = "sales.php";
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
            <div class="col-sm-4 p-2">
                <h3 class="">Sales Information</h3>
            </div>
            <div class="col-sm-3 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-3 p-2"><a href="sales.php"><button class="btn btn-success">Sales</button></a></div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <span style="background-color:white; color:red; font-size:20px;">
                    <?php echo isset($message) ? $message : ''; ?>
                </span>
                <form class="form1" action="" method="POST">
                    <div class="mt-2">
                        <label class="block text-gray-700">Plateform *</label>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="old_batch" value="<?php echo $old_batch_no; ?>">
                        <input type="hidden" name="old_productId" value="<?php echo $product_id; ?>">
                        <input type="hidden" name="old_qty" value="<?php echo $qty; ?>">
                        <select name="plateform_name" id="" class="form-control input">
                            <option value="">Select</option>
                            <?php
                            $vendor_sql = "SELECT * FROM `plateform`";
                            $vendor_res = mysqli_query($conn, $vendor_sql) or die("query failed : vendor_sql");
                            if (mysqli_num_rows($vendor_res) > 0) {
                                while ($row = mysqli_fetch_assoc($vendor_res)) {
                                    if ($row['id'] == $plateform) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }
                                    ?>
                                    <option <?php echo $select; ?> value="<?php echo $row['id']; ?>"><?php echo $row['plateform_name']; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Order ID *</label>
                        <input type="number" name="order_id" id="" value="<?php if (isset($_POST['order_id'])) {
                            echo $_POST['order_id'];
                        } else {
                            echo $order_id;
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Sale Date *</label>
                        <input type="date" name="s_date" id="" value="<?php if (isset($_POST['date'])) {
                            echo $_POST['date'];
                        } else {
                            echo $sdate;
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Category *</label>
                        <select id="category" name="category" class="form-control input">
                            <option value="" selected disabled>Select</option>
                            <?php
                            $sql_cat = "SELECT * FROM `category`";
                            $res_cat = mysqli_query($conn, $sql_cat) or die("query failed : sql_cat");
                            if (mysqli_num_rows($res_cat) > 0) {
                                while ($row_cat = mysqli_fetch_assoc($res_cat)) {
                                    if ($row_cat['id'] == $category_id) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }
                                    ?>
                                    <option <?php echo $select; ?> value="<?php echo $row_cat['id']; ?>"><?php echo $row_cat['category_name']; ?></option>
                                <?php }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Product Name *</label>
                        <select name="product_name" id="product_name" class="form-control input product_name">
                            <option value="" selected disabled>Select</option>
                            <?php
                            $product_sql = "SELECT * FROM `products` WHERE `category` = '" . $category_id . "'";
                            $product_res = mysqli_query($conn, $product_sql) or die("query failed : product_sql");
                            if (mysqli_num_rows($product_res) > 0) {
                                while ($row = mysqli_fetch_assoc($product_res)) {
                                    if ($row['id'] == $product_id) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }
                                    ?>
                                    <option <?php echo $select; ?> value="<?php echo $row['id'] ?>"><?php echo $row['product_name'] ?></option>
                                <?php }
                            } ?>

                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Batch No *</label>
                        <select name="new_batch" id="batch_no" class="form-control input">
                            <option value="" selected disabled>Select</option>
                            <?php
                            $batch_sql = "SELECT `batch_no` FROM `stocks` WHERE `product_id` = '" . $product_id . "'";
                            $batch_res = mysqli_query($conn, $batch_sql) or die("query failed : batch_sql");
                            if (mysqli_num_rows($batch_res) > 0) {
                                while ($row = mysqli_fetch_assoc($batch_res)) {
                                    if ($row['batch_no'] == $old_batch_no) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }
                                    ?>
                                    <option <?php echo $select; ?> value="<?php echo $row['batch_no'] ?>"><?php echo $row['batch_no'] ?></option>
                                <?php }
                            } ?>

                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Quantity *</label>
                        <input type="number" name="quantity" id="" value="<?php if (isset($_POST['quantity'])) {
                            echo $_POST['quantity'];
                        } else {
                            echo $qty;
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Rate/Pcs *</label>
                        <input type="number" name="rate" id="" value="<?php if (isset($_POST['rate'])) {
                            echo $_POST['rate'];
                        } else {
                            echo $rate;
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Total Amount *</label>
                        <input type="number" name="tot_amount" id="" value="<?php if (isset($_POST['tot_amount'])) {
                            echo $_POST['tot_amount'];
                        } else {
                            echo $tot_amount;
                        } ?>" class="form-control input">
                    </div>
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

        $("#product_name").on("change", function () {
            var p_id = $(this).val();
            $.ajax({
                url: "pro_batch.php",
                type: "POST",
                data: { p_id, p_id },
                success: function (data) {
                    $("#batch_no").html(data);
                }
            });
        });
    });

</script>
<?php include_once 'footer.php'; ?>