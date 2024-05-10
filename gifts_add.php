<?php include_once 'header.php';

if (isset($_POST['submit'])) {

    if ($_POST['gift'] == 'other') {
        $gifted_by = $_POST['other_name'];
    } else {
        $gifted_by = $_POST['gift'];
    }
    // echo $gifted_by;exit;
    $customer_name = $_POST['name'];
    $customer_email = $_POST['email'];
    $customer_phone = $_POST['phone'];
    $customer_address = $_POST['address'];
    $category = $_POST['category'];
    $product = $_POST['product'];
    $batch_id = $_POST['batch_no'];
    $quantity = $_POST['quantity'];
    if ($_POST['total_products'] < $_POST['quantity']) {
        $msg = "Not Sufficient Quantity";
    } else {
        $bal_pro = $_POST['total_products'] - $_POST['quantity'];
        $date = date("Y-m-d");
        if ($customer_name == '' or $category == '' or $product == '' or $quantity == '') {
            $message = "Please Fill All fields....!!";
        } else {

            $pro_sql = "SELECT `total_products` FROM `products`WHERE `id`= '" . $product . "'";
            $result = mysqli_query($conn, $pro_sql) or die("query failed");
            if (mysqli_num_rows($result) > 0) {
                while ($rows = mysqli_fetch_assoc($result)) {
                    $total_product = $rows['total_products'];
                }
            }
            $rem = $total_product - $quantity;
            $up_sql = "UPDATE `products` SET `total_products`='" . $rem . "' WHERE `id`= '" . $product . "'";
            $res = mysqli_query($conn, $up_sql) or die("query failed");

            $up_stocks = "UPDATE `batch_nos` SET `rem_qty` = '" . $bal_pro . "' WHERE `id` = '" . $batch_id . "'";
            $res_stocks = mysqli_query($conn, $up_stocks) or die("query failed : up_stocks");


            $sql = "INSERT INTO `gifts`(`gifted_by`,`customer_name`,`customer_email`,`customer_phone`,`customer_address`,`category_id`,`product_id`,`batch_no`,`quantity`,`date`) VALUES ('" . $gifted_by . "','" . $customer_name . "','" . $customer_email . "','" . $customer_phone . "','" . $customer_address . "','" . $category . "','" . $product . "','" . $batch_id . "','" . $quantity . "','" . $date . "')";

            $result = mysqli_query($conn, $sql) or die("query failed : sql");

            if ($_SESSION['role'] == '1') {
                $by = 'Admin';
            } else {
                $by = 'User';
            }
            $activity_type = "Gift Added";
            $activity_msg = "Gift send by" . $gifted_by . " To " . $customer_name . " @ " . $customer_email;
            user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);

            ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    swal({
                        title: "Done",
                        text: "GIFT Add Successfully!!",
                        icon: "success",
                        button: "OK",
                        timer: 2000
                    });
                });
            </script>
            <script>
                const myTimeout = setTimeout(
                    function location() {
                        window.location.href = "gifts.php";
                    }, 2000);
            </script>
            <?php
        }
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
                <h3 class="">ADD GIFTS</h3>
            </div>
            <div class="col-sm-3 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-3 p-2"><a href="gifts.php"><button class="btn btn-success">GIFTS</button></a></div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <span style="background-color:white; color:red; font-size:20px;">
                    <?php echo isset($message) ? $message : ''; ?>
                </span>
                <form class="form1" action="" method="POST">
                    <div class="mt-3">
                        <label class="block text-gray-700">Gifted By * </label>
                        <select name="gift" id="gift" class="form-control input">
                            <option value="Atul Sir">Atul Sir</option>
                            <option value="Jatin Sir">Jatin Sir</option>
                            <option value="other">Others</option>
                        </select>
                    </div>
                    <div class="mt-3 other_name" style="display:none;">
                        <!-- <label class="block text-gray-700">Customer Name</label> -->
                        <input type="text" name="other_name" id="" placeholder="Enter name" value="<?php if (isset($_POST['other_name'])) {
                            echo $_POST['other_name'];
                        } else {
                            echo '';
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Customer Name</label>
                        <input type="text" name="name" id="" placeholder="Enter customer name" value="<?php if (isset($_POST['name'])) {
                            echo $_POST['name'];
                        } else {
                            echo '';
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Customer Email</label>
                        <input type="email" name="email" id="" placeholder="Enter customer Email" value="<?php if (isset($_POST['email'])) {
                            echo $_POST['email'];
                        } else {
                            echo '';
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Customer Phone</label>
                        <input type="number" name="phone" id="" placeholder="Enter customer Phone No." value="<?php if (isset($_POST['phone'])) {
                            echo $_POST['phone'];
                        } else {
                            echo '';
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Customer Address</label>
                        <input type="text" name="address" id="" placeholder="Enter customer Address." value="<?php if (isset($_POST['address'])) {
                            echo $_POST['address'];
                        } else {
                            echo '';
                        } ?>" class="form-control input">
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
                        <b><span id="total_products" style="color:green;font-size:16px;">
                                <?php if (isset($_POST['total_products'])) {
                                    echo $_POST['total_products'];
                                } ?>
                            </span></b>
                        <input type="hidden" name="total_products" class="total_products" value="<?php if (isset($_POST['total_products'])) {
                            echo $_POST['total_products'];
                        } ?>" />
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Quantity</label>
                        <input type="number" name="quantity" id="" placeholder="" value="<?php if (isset($_POST['quantity'])) {
                            echo $_POST['quantity'];
                        } else {
                            echo '';
                        } ?>" class="form-control input">
                        <span style="background-color:white; color:red; font-size:20px;">
                            <?php echo isset($msg) ? $msg : ''; ?>
                        </span>
                    </div><br>
                    <button type="submit" name="submit" class="btn btn-success btn-sm btn-block">ADD GIFT </button>
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

        $("#gift").on("change", function () {
            var gift_by = $("#gift").val();
            // alert(gift_by);
            if (gift_by == 'other') {
                $('.other_name').show();
            } else {
                $('.other_name').hide();
            }
        });
    });
</script>
<?php include_once 'footer.php'; ?>