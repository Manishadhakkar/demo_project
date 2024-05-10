<?php include_once 'header.php'; ?>
<?php
if (isset($_POST['submit'])) {
    $plateform = $_POST['plateform'];
    $category = $_POST['category'];
    $product = $_POST['product'];
    $batch_no = $_POST['batch_no'];
    $quantity = $_POST['quantity'];
    $order_id = $_POST['order'];
    // $created_at = date("Y-m-d");

    if ($plateform == '' or $category == '' or $product == '' or $quantity == '' or $order_id == '' or $batch_no == '') {
        $message = "Please Fill All fields....!!";
    } else {
        $sql = "INSERT INTO `lost_product`(`plateform_id`,`category_id`,`product_id`,`batch_no`,`quantity`,`order_id`) VALUES ('" . $plateform . "','" . $category . "','" . $product . "','" . $batch_no . "','" . $quantity . "','" . $order_id . "')";

        $result = mysqli_query($conn, $sql) or die("query failed : sql");
        echo $sql;exit;
        

        if ($_SESSION['role'] == '1') {
            $by = 'Admin';
        } else {
            $by = 'User';
        }
        $activity_type = "Lost Product Added";
        $activity_msg = $quantity . " " . $product . " add to lost by " . $by;
        user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);


        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                swal({
                    title: "Done",
                    text: "Lost Product Add Successfully!!",
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
                <h3 class=""> ADD LOST PRODUCTS</h3>
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
                                    if ($_POST['plateform'] == $row['id']) {
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
                                    if ($_POST['category'] == $row['id']) {
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
                            <option value="">Select Product</option>
                            <?php
                            $pro_sql = "SELECT * FROM `products` WHERE `category` = '" . $_POST['category'] . "'";
                            $pro_res = mysqli_query($conn, $pro_sql) or die("query failed : pro_sql");
                            if (mysqli_num_rows($pro_res) > 0) {
                                while ($prow = mysqli_fetch_assoc($pro_res)) {
                                    if ($_POST['product'] == $prow['id']) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }
                                    ?>
                                    <option <?php echo $select; ?> value="<?php echo $prow['id']; ?>"><?php echo $prow['product_name']; ?></option>
                                <?php }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Batch No.</label>
                        <select name="batch_no" id="batch_no" rel="total_products" class="form-control input batch_no">
                            <option value="">Select Batch</option>
                            <?php
                            $batch_sql = "SELECT `batch_no` FROM `stocks` WHERE `product_id` = '" . $_POST['product'] . "'";
                            $batch_res = mysqli_query($conn, $batch_sql) or die("query failed : batch_sql");
                            if (mysqli_num_rows($batch_res) > 0) {
                                while ($brow = mysqli_fetch_assoc($batch_res)) {
                                    if ($_POST['batch_no'] == $brow['batch_no']) {
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
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Quantity</label>
                        <input type="number" name="quantity" id="" placeholder=""
                            value="<?php if (isset($_POST['quantity'])) {
                                echo $_POST['quantity'];
                            } else {
                                echo '';
                            } ?>"
                            class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Order ID</label>
                        <input name="order" id="" type="text" class="form-control input"
                            value="<?php if (isset($_POST['order'])) {
                                echo $_POST['order'];
                            } else {
                                echo '';
                            } ?>"
                            placeholder="">
                    </div><br>
                    <button type="submit" name="submit" class="btn btn-danger btn-sm btn-block">Add Lost Product
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