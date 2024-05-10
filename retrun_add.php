<?php include_once 'header.php'; ?>
<?php
if (isset($_POST['submit'])) {
$plateform = $order_id = $category = $product = $batch_id = $sku = $quantity = $bal_pro = $claim_amount = $total = $total_product = '';
    // echo '<pre>';print_r($_POST);exit;
    $plateform = $_POST['plateform'];
    $order_id = $_POST['order_id'];
    $category = $_POST['category'];
    $product = $_POST['product'];
    $batch_id = $_POST['batch_no'];
    $sku = $_POST['sku'];
    $quantity = $_POST['quantity'];
    $bal_pro = $_POST['total_products'] + $_POST['quantity'];
    $claim_amount = $_POST['claim_amount'];
    $dateofreturn = $_POST['dateofreturn'];
    $reason = $_POST['reason'];
    $created_at = date("Y-m-d");

    if ($plateform == '' || $product == '' || $quantity == '' ||$batch_id == '' || $order_id == '' || $category == '' || $sku == '' || $dateofreturn == '' || $reason == '') {
        $message = "Please * Fill All fields....!!";
    } else {
        $pro_sql = "SELECT `total_products` FROM `products` WHERE `id`= '" . $product . "'";
        $result = mysqli_query($conn, $pro_sql) or die("query failed");
        if (mysqli_num_rows($result) > 0) {
            while ($rows = mysqli_fetch_assoc($result)) {
                $total_product = $rows['total_products'];
            }
        }

        $total = $total_product + $quantity;

        // echo $total;exit;

        $up_sql = "UPDATE `products` SET `total_products`='" . $total . "' WHERE `id`= '" . $product . "'";
        $res = mysqli_query($conn, $up_sql) or die("query failed");

        $up_stocks = "UPDATE `batch_nos` SET `rem_qty` = '" . $bal_pro . "' WHERE `id` = '" . $batch_id . "'";
        $res_stocks = mysqli_query($conn, $up_stocks) or die("query failed : up_stocks");


        $sql = "INSERT INTO `return`(`plateform_id`,`category_id`,`product_id`,`batch_no`,`order_id`,`sku`,`quantity`,`claim_amount`,`date_of_return`,`reason`,`created_at`) VALUES ('" . $plateform . "','" . $category . "','" . $product . "','" . $batch_id . "','" . $order_id . "','" . $sku . "','" . $quantity . "','" . $claim_amount . "','" . $dateofreturn . "','" . $reason . "','" . $created_at . "')";


        // echo $sql; exit;
        $result = mysqli_query($conn, $sql) or die("query failed : sql");

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
                    <?php echo isset($message) ? $message : ''; ?>
                </span>
                <form class="form1" action="" method="POST">
                    <div class="mt-3 row">
                        <label class="block text-gray-700">Order ID *</label>
                        <div class="col-sm-10">
                            <input name="order_id" id="order_id" type="text" class="form-control input" value="<?php if (isset($_POST['order'])) {
                                echo $_POST['order'];
                            } else {
                                echo '';
                            } ?>" placeholder="">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" id="search" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                    <b><span style="background-color:white; color:red; font-size:17px;" id="orderid"></span></b>
                    <div class="mt-2">
                        <label class="block text-gray-700">Plateform *</label>
                        <select name="plateform" id="plateform" class="form-control input">
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
                        <label class="block text-gray-700">Category *</label>
                        <select name="category" id="category" class="form-control input">
                            <option value="">Select Category</option>
                            <?php
                            $category_sql = "SELECT * FROM `category`";
                            $category_res = mysqli_query($conn, $category_sql) or die("query failed : category_sql");
                            if (mysqli_num_rows($category_res) > 0) {
                                while ($row = mysqli_fetch_assoc($category_res)) {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['category_name']; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Product Name *</label>
                        <select name="product" id="product" class="form-control input">
                            <option value="">Select Product</option>
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Batch No.</label>
                        <select name="batch_no" id="batch_no" rel="total_products" class="form-control input batch_no">
                            <option value="">Select Batch</option>
                            <option value=""></option>
                        </select>
                        <b><span id="total_products" style="color:green;font-size:16px;"></span></b>
                        <input type="hidden" name="total_products" class="total_products" value="" />
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">SKU *</label>
                        <input type="text" name="sku" id="sku" placeholder="" value="<?php if (isset($_POST['sku'])) {
                            echo $_POST['sku'];
                        } else {
                            echo '';
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Quantity *</label>
                        <input type="number" name="quantity" id="" placeholder="" value="<?php if (isset($_POST['quantity'])) {
                            echo $_POST['quantity'];
                        } else {
                            echo '';
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Claim Amount *</label>
                        <input type="number" name="claim_amount" id="" placeholder="" value="<?php if (isset($_POST['claim_amount'])) {
                            echo $_POST['claim_amount'];
                        } else {
                            echo '';
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Date Of Return *</label>
                        <input type="date" name="dateofreturn" id="" placeholder="" value="<?php if (isset($_POST['dateofreturn'])) {
                            echo $_POST['dateofreturn'];
                        } else {
                            echo '';
                        } ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700"> Reason *</label>
                        <input type="text" name="reason" id="" placeholder="Reason Of Return" value="<?php if (isset($_POST['reason'])) {
                            echo $_POST['reason'];
                        } else {
                            echo '';
                        } ?>" class="form-control input">
                    </div>

                    <br>
                    <button type="submit" name="submit" class="btn btn-danger btn-sm btn-block">Add Return</button>
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
            var order_id = $("#order_id").val();
            // alert(order_id);
            $.ajax({
                url: "sales_product.php",
                type: "POST",
                data: { c_id: c_id, order_id: order_id },
                success: function (data) {
                    $("#product").html(data);
                }
            });
        });


        $("#search").on("click", function () {
            var order_id = $("#order_id").val();
            // alert(order_id);
            if (order_id == '') {
                $("#orderid").html("Please Enter Order ID");
            } else {
                $.ajax({
                    url: "order_id.php",
                    type: "POST",
                    data: { order_id, order_id },
                    success: function (data) {
                        if (data == 0) {
                            $("#orderid").html("Order ID Not Exists");
                        } else {
                            dataArr = data.split('###');
                            $('#plateform').html(dataArr[1]);
                            $('#category').html(dataArr[0]);
                            $("#orderid").fadeOut();
                        }
                    }
                });
            }
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
            var order_id = $("#order_id").val();
            // alert(p_id);
            $.ajax({
                url: "pro_batch_no.php",
                type: "POST",
                data: { p_id: p_id, order_id: order_id },
                success: function (data) {
                    $("#batch_no").html(data);
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