<?php include_once 'header.php'; ?>

<?php
$id = $_GET['id'];
$query = "SELECT * FROM `return` WHERE `id` = '" . $id . "'";
$res_query = mysqli_query($conn, $query) or die("query failed : query");
if (mysqli_num_rows($res_query) > 0) {
    while ($row = mysqli_fetch_assoc($res_query)) {
        $plateform = $row['plateform_id'];
        $category_id = $row['category_id'];
        $product_id = $row['product_id'];
        $batch_no = $row['batch_no'];
        $order_id = $row['order_id'];
        $sku = $row['sku'];
        $quantity = $row['quantity'];
        $dateofreturn = $row['date_of_return'];
        $fetch_reason = $row['reason'];
        $claim_amount = $row['claim_amount'];
    }
}
// echo '<pre>';print_r($row);exit;

if (isset($_POST['update'])) {
    $uid = $_POST['id'];
    // $plateform_name = $_POST['plateform_name'];
    // $orderid = $_POST['order_id'];
    // $category = $_POST['category'];
    // $product_name = $_POST['product_name'];
    // $batch_no = $_POST['batch_no'];
    // $quantity = $_POST['quantity'];
    // $sku = $_POST['sku'];
    // $dateOfreturn = $_POST['dateofreturn'];
    $claim_amount = $_POST['claim_amount'];
    $reason = $_POST['reason'];

    // $created_at = date("Y-m-d");
    if ($quantity == '' || $claim_amount == '') {
        $message = "All * Fields Are required.";
    } else {
        $sql = "UPDATE `return` SET `claim_amount` = '" . $claim_amount . "', `reason`= '" . $reason . "' WHERE `id` = '" . $uid . "'";

        // echo $sql; exit;
        $result = mysqli_query($conn, $sql) or die("query failed : sql");
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                swal({
                    title: "Done",
                    text: "Return Information Update Successfully!!",
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
            <div class="col-sm-4 p-2">
                <h3 class="">Return Information</h3>
            </div>
            <div class="col-sm-3 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-3 p-2"><a href="return.php"><button class="btn btn-success">Return</button></a></div>
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
                        <input readonly type="hidden" name="id" value="<?php echo $id; ?>">
                        <select name="plateform_name" id="" class="form-control input" disabled>
                            <option value="">Select</option>
                            <?php
                            $palteform_sql = "SELECT * FROM `plateform`";
                            $plateform_res = mysqli_query($conn, $palteform_sql) or die("query failed : palteform_sql");
                            if (mysqli_num_rows($plateform_res) > 0) {
                                while ($row = mysqli_fetch_assoc($plateform_res)) {
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
                        <input type="text" name="order_id" id="" value="<?php echo $order_id ?>"
                            class="form-control input" readonly>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Category *</label>
                        <select id="category" name="category" class="form-control input" disabled>
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
                        <select disabled name="product_name" id="product" class="form-control input product_name">
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
                        <label class="block text-gray-700">Batch No.</label>
                        <select disabled name="batch_no" id="batch_no" rel="total_products"
                            class="form-control input batch_no">
                            <option value="">Select Batch</option>
                            <?php
                            $batch_sql = "SELECT `batch_no` FROM `stocks` WHERE `product_id`= '" . $product_id . "'";
                            $batch_res = mysqli_query($conn, $batch_sql) or die("query failed : vendor_sql");
                            if (mysqli_num_rows($batch_res) > 0) {
                                while ($rows = mysqli_fetch_assoc($batch_res)) {
                                    if ($rows['batch_no'] == $batch_no) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }
                                    ?>
                                    <option <?php echo $select; ?> value="<?php echo $rows['batch_no']; ?>"><?php echo $rows['batch_no']; ?></option>
                                <?php }
                            } ?>
                        </select>
                        <b><span id="total_products" style="color:green;font-size:16px;"></span></b>
                        <input type="hidden" name="total_products" class="total_products" value="" />
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">SKU *</label>
                        <input readonly type="text" name="sku" id="sku" value="<?php if (isset($_POST['sku'])) {
                            echo $_POST['sku'];
                        } else {
                            echo $sku;
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Quantity *</label>
                        <input type="number" name="quantity" id="" value="<?php if (isset($_POST['quantity'])) {
                            echo $_POST['quantity'];
                        } else {
                            echo $quantity;
                        } ?>" class="form-control input" readonly>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Claim Amount *</label>
                        <input type="number" name="claim_amount" id="" value="<?php if (isset($_POST['claim_amount'])) {
                            echo $_POST['claim_amount'];
                        } else {
                            echo $claim_amount;
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Date of Return *</label>
                        <input type="date" name="dateofreturn" id="" value="<?php if (isset($_POST['dateofreturn'])) {
                            echo $_POST['dateofreturn'];
                        } else {
                            echo $dateofreturn;
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700"> Reason *</label>
                        <input type="text" name="reason" id="" placeholder="" value="<?php echo $fetch_reason; ?>"
                            class="form-control input">
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
                    $("#product").html(data);
                }
            });
        });


        $("#product").on("change", function () {
            var p_id = $("#product").val();
            // alert(p_id);
            $.ajax({
                url: "product_sku.php",
                type: "POST",
                data: { p_id: p_id },
                success: function (data) {
                    $("#sku").val(data);
                }
            });
        });
        $("#product").on("change", function () {
            var p_id = $("#product").val();
            $.ajax({
                url: "pro_batch.php",
                type: "POST",
                data: { p_id: p_id },
                success: function (data) {
                    $("#batch_no").html(data)
                }
            });
        });
        $(document).on("change", ".batch_no", function () {
            var bid = $(this).attr('rel');
            var batch_id = $(this).val();
            // alert(pro_id);
            // alert(bid);
            $.ajax({
                url: "getProductsno.php",
                type: "POST",
                data: { batch_id, batch_id },
                success: function (data) {
                    $("#" + bid).text(data);
                    $("." + bid).val(data);
                }
            });
        });
    });

</script>
<?php include_once 'footer.php'; ?>