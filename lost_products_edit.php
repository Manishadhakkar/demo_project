<?php include_once 'header.php'; ?>
<?php
$id = $_GET['id'];
$product_sql = "SELECT * FROM `lost_product` WHERE `id`= '" . $id . "'";
$product_res = mysqli_query($conn, $product_sql);
if (mysqli_num_rows($product_res) > 0) {
    $row = mysqli_fetch_assoc($product_res);

    // echo '<pre>'; print_r($row);
    $fetch_plateform = $row['plateform_id'];
    $fetch_category = $row['category_id'];
    $fetch_product = $row['product_id'];
    $fetch_batch_no = $row['batch_no'];
    $fetch_quantity = $row['quantity'];
    $fetch_order = $row['order_id'];
}
if (isset($_POST['update'])) {
    $plateform = $_POST['plateform'];
    $category = $_POST['category'];
    $product = $_POST['product'];
    $batch_no = $_POST['batch_no'];
    $quantity = $_POST['quantity'];
    $order_id = $_POST['order'];

    if ($plateform == '' or $category == '' or $product == '' or $quantity == '' or $order_id == '' or $batch_no == '') {
        $message = "Please Fill All fields....!!";
    } else {
        $sql = "UPDATE `lost_product` SET `plateform_id`='" . $plateform . "',`category_id`= '" . $category . "',`product_id`= '" . $product . "',`batch_no`='" . $batch_no . "',`quantity`='" . $quantity . "' , `order_id`= '" . $order_id . "' WHERE `id`='" . $id . "'";

        $result = mysqli_query($conn, $sql) or die("query failed : sql");

        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                swal({
                    title: "Done",
                    text: "Lost Product Updated Successfully!!",
                    icon: "success",
                    button: "OK",
                    timer: 2000
                });
            });
        </script>
        <script>
            const myTimeout = setTimeout(
                function location() {
                    window.location.href = "lost_products.php";
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
                <h3 class=""> UPDATE LOST PRODUCTS</h3>
            </div>
            <div class="col-sm-3 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-3 p-2"><a href="lost_products.php"><button class="btn btn-success">Lost
                        Products</button></a></div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <span style="background-color:white; color:red; font-size:20px;">
                    <?php echo isset($message) ? $message : ''; ?>
                </span>
                <form class="form1" action="" method="POST">
                    <div class="mt-2">
                        <label class="block text-gray-700">Plateform Name</label>
                        <select name="plateform" id="" class="form-control input">
                            <option value="">Select Plateform</option>
                            <?php
                            $plateform_sql = "SELECT * FROM `plateform` WHERE `status` = '1'";
                            $plateform_res = mysqli_query($conn, $plateform_sql) or die("query failed : vendor_sql");
                            if (mysqli_num_rows($plateform_res) > 0) {
                                while ($row = mysqli_fetch_assoc($plateform_res)) {
                                    if ($row['id'] == $fetch_plateform) {
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
                        <label class="block text-gray-700">Category </label>
                        <select name="category" id="category" class="form-control input">
                            <option value="">Select Category</option>
                            <?php
                            $category_sql = "SELECT * FROM `category`";
                            $category_res = mysqli_query($conn, $category_sql) or die("query failed : sql");
                            if (mysqli_num_rows($category_res) > 0) {
                                while ($row = mysqli_fetch_assoc($category_res)) {
                                    if ($row['id'] == $fetch_category) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }
                                    ?>
                                    <option <?php echo $select; ?> value="<?php echo $row['id']; ?>"><?php echo $row['category_name']; ?></option>
                                <?php }
                            } ?>
                        </select>

                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Product Name</label>
                        <select name="product" id="product" class="form-control input">
                            <option value="">select </option>
                            <?php
                            $options = '';
                            $product_sql = "SELECT * FROM `products` WHERE `category` = '" . $fetch_category . "' AND `status` = '1'";
                            $product_res = mysqli_query($conn, $product_sql) or die("query failed : product_sql");
                            if (mysqli_num_rows($product_res) > 0) {
                                while ($row = mysqli_fetch_assoc($product_res)) {
                                    if ($row['id'] == $fetch_product) {
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
                        <select name="batch_no" id="batch_no" rel="total_products" class="form-control input batch_no">
                            <option value="">Select Batch</option>
                            <?php
                            $batch_sql = "SELECT `batch_no` FROM `stocks` WHERE `product_id` = '" . $fetch_product . "' AND `rem_qty`>0";
                            $batch_res = mysqli_query($conn, $batch_sql) or die("query failed : batch_sql");
                            if (mysqli_num_rows($batch_res) > 0) {
                                while ($brow = mysqli_fetch_assoc($batch_res)) {
                                    if ($fetch_batch_no == $brow['batch_no']) {
                                        $select = "selected";
                                    } else {
                                        $select = " ";
                                    }
                                    ?>
                                    <option <?php echo $select; ?> value="<?php echo $brow['batch_no']; ?>"><?php echo $brow['batch_no']; ?></option>
                                <?php }
                            }
                            ?>
                        </select>
                        <b><span id="total_products" style="color:green;font-size:16px;"></span></b>
                        <input type="hidden" name="total_products[]" class="total_products" value="" />
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Quantity</label>
                        <input type="number" name="quantity" id="" placeholder="" value="<?php echo $fetch_quantity ?>"
                            class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Order ID</label>
                        <input name="order" id="" type="text" class="form-control input"
                            value="<?php echo $fetch_order ?>" placeholder="">
                    </div><br>
                    <button type="submit" name="update" class="btn btn-danger btn-sm btn-block">Update Lost Product
                    </button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $("#category").on("change", function () {
            var c_id = $("#category").val();
            $.ajax({
                url: "product_catg.php",
                type: "POST",
                data: { c_id: c_id },
                success: function (data) {
                    $("#product").html(data)
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
    });
</script>
<?php include_once 'footer.php'; ?>