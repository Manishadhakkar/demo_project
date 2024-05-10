<?php include_once 'header.php';

if (isset($_POST['submit'])) {
    //echo '<pre>';print_r($_POST);    exit;
    $category = $product_name = $old_product = $quantity = $batch_id = $rate = $total_amount = $bal_pro = $rem_products = $total_products ='';
    
    $sellType = $_POST['sellType'];
    if ($sellType == 'Warehouse') {
        $dest_id = $_POST['warehouse'];
        $sql = "SELECT `w_name` FROM `warehouse` WHERE `id` = '" . $dest_id . "'";
        $res = mysqli_query($conn, $sql) or die("query failed : warehouse sql");
        if (mysqli_num_rows($res) > 0) {
            $wrow = mysqli_fetch_assoc($res);
            $dest_name = $wrow['w_name'];
        }
    } else {
        $dest_id = $_POST['plateform_name'];
        $sql = "SELECT `plateform_name` FROM `plateform` WHERE `id` = '" . $dest_id . "'";
        $res = mysqli_query($conn, $sql) or die("query failed : warehouse sql");
        if (mysqli_num_rows($res) > 0) {
            $prow = mysqli_fetch_assoc($res);
            $dest_name = $prow['plateform_name'];
        }
    }
    $sale_date = $_POST['date'];
    $order_id = trim($_POST['order_id']);
    for ($i = 0; $i < count($_POST['category']); $i++) {

        $category = $_POST['category'][$i];
        $product_name = $_POST['product_name'][$i];
        $old_product = $_POST['total_products'][$i];
        $quantity = $_POST['quantity'][$i];
        $batch_id = $_POST['batch_no'][$i];
        $rate = $_POST['rate'][$i];
        $total_amount = $_POST['total_amount'][$i];
        $bal_pro = $_POST['total_products'][$i] - $_POST['quantity'][$i];
        $date = date("Y-m-d");
        
        if ($dest_id == '' || $sale_date == '' || $order_id == '' || $category == '' || $product_name == '' || $quantity == '' || $rate == '' || $total_amount == '') {
            $message = "All * Fields are Required";
        } else {

            $sel_sql = "SELECT `product_name`,`total_products` FROM `products` WHERE `id` = '" . $product_name . "'";
            $sel_res = mysqli_query($conn, $sel_sql) or die("query failed : sel_sql");
            if (mysqli_num_rows($sel_res) > 0) {
                $row = mysqli_fetch_assoc($sel_res);
                $total_products = $row['total_products'];
                $product = $row['product_name'];
            }

            $rem_products = $total_products - $_POST['quantity'][$i];

            $up_query = "UPDATE `products` SET `total_products` = '" . $rem_products . "' WHERE `id` = '" . $product_name . "'";
           // $res_query = mysqli_query($conn, $up_query) or die("query failed : up_query");

            $ins_sql = "INSERT INTO `sales` (`sellType`,`dest_id`,`date`,`order_id`,`category_id`,`product_id`,`quantity`,`batch_no`,`rate`,`total_amount`,`created_at`) VALUES ('" . $sellType . "','" . $dest_id . "','" . $sale_date . "','" . $order_id . "','" . $category . "','" . $product_name . "','" . $quantity . "','" . $batch_id . "','" . $rate . "','" . $total_amount . "','" . $date . "')";
            
            $result = mysqli_query($conn, $ins_sql) or die("query failed : ins_sql");

            $up_stocks = "UPDATE `batch_nos` SET `rem_qty` = '" . $bal_pro . "' WHERE `id` = '" . $batch_id . "'";
            $res_stocks = mysqli_query($conn, $up_stocks) or die("query failed : up_stocks");

            if ($_SESSION['role'] == '1') {
                $by = 'Admin';
            } else {
                $by = 'User';
            }
            $activity_type = "Sell Add";
            $activity_msg = $quantity . " " . $product . " sell by " . $by . " From Batch No : " . $batch_no . " To " . $dest_name . " " . $sellType;
            user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);
        }
    }
    
    ?>

    <script type="text/javascript">
        $(document).ready(function () {
            swal({
                title: "Done",
                text: "Sales Add Successfully!!",
                icon: "success",
                button: "OK",
                timer: 2000
            });
        });
        const myTimeout = setTimeout(
            function location() {
                window.location.href = "sales.php";
            }, 2000);
    </script>
    <?php
}
?>

<section class="home">
    <div class="container">

        <?php include 'navbar.php'; ?>

        <div class="row">

            <div class="col-sm-4 p-2">
                <h3 class="">Add Sales</h3>
            </div>
            <div class="col-sm-2 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-5 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-1 p-2"><a href="sales.php"><button class="btn btn-success">Sales</button></a></div>
        </div>
        <div class="row">
            <!-- <div class="col-sm-2"></div> -->
            <div class="col-sm-12">
                <span style="background-color:white; color:red; font-size:20px;">
                    <?php echo isset($message) ? $message : ''; ?>
                </span>
                <form class="form1" action="" method="POST">
                    <div class="mt-2">
                        <input type="radio" id="Plateform" name="sellType" value="Plateform" checked>
                        <label for="Plateform">Plateform</label> &nbsp;&nbsp;
                        <input type="radio" id="Warehouse" name="sellType" value="Warehouse">
                        <label for="Warehouse">Warehouse</label>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-sm-4 plateformOption">
                            <div class="mt-2">
                                <label class="block text-gray-700">Plateform *</label>
                                <select name="plateform_name" id="plateform_name" class="form-control input">
                                    <option value="">Select Plateform</option>
                                    <?php
                                    $plateform_sql = "SELECT * FROM `plateform` WHERE `status` = '1'";
                                    $plateform_res = mysqli_query($conn, $plateform_sql) or die("query failed : plateform_sql");
                                    if (mysqli_num_rows($plateform_res) > 0) {
                                        while ($row = mysqli_fetch_assoc($plateform_res)) {
                                            if ($_POST['plateform_name'] == $row['id']) {
                                                $select = "selected";
                                            } else {
                                                $select = "";
                                            }
                                            ?>
                                            <option <?php echo $select; ?> value="<?php echo $row['id']; ?>">
                                                <?php echo $row['plateform_name']; ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 warehouseOption" style="display:none;">
                            <div class="mt-2">
                                <label class="block text-gray-700">Warehouse *</label>
                                <select name="warehouse" id="" class="form-control input">
                                    <option value="">Select Warehouse</option>
                                    <?php
                                    $warehouse_sql = "SELECT * FROM `warehouse` WHERE `status` ='1'";
                                    $warehouse_res = mysqli_query($conn, $warehouse_sql) or die("query failed : plateform_sql");
                                    if (mysqli_num_rows($warehouse_res) > 0) {
                                        while ($wrow = mysqli_fetch_assoc($warehouse_res)) {
                                            if ($_POST['warehouse'] == $wrow['id']) {
                                                $select = "selected";
                                            } else {
                                                $select = "";
                                            }
                                            ?>
                                            <option <?php echo $select; ?> value="<?php echo $wrow['id']; ?>">
                                                <?php echo $wrow['w_name']; ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="mt-2">
                                <label class="block text-gray-700" for="date">Date *</label>
                                <input type="date" name="date" id="" value="<?php if (isset($_POST['date'])) {
                                    echo $_POST['date'];
                                } else {
                                    echo '';
                                } ?>" class="form-control input">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="mt-2">
                                <label class="block text-gray-700">Order ID *</label>
                                <input type="text" name="order_id" id="" value="<?php if (isset($_POST['order_id'])) {
                                    echo $_POST['order_id'];
                                } else {
                                    echo '';
                                } ?>" class="form-control input">
                            </div>

                        </div>
                    </div>

                    <table id="queueTable" class="table manage_queue_table">
                        <thead>
                            <tr>
                                <th>Category*</th>
                                <th>Product Name*</th>
                                <th>Batch No*</th>
                                <th>Quantity*</th>
                                <th>Rate/Pcs*</th>
                                <th>Total Amount*</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="dynamicadd">
                            <tr class="tr-shadow">
                                <td>
                                    <?php
                                    $options = '';
                                    $cat_sql = "SELECT * FROM `category`";
                                    $cat_res = mysqli_query($conn, $cat_sql) or die("query failed : cat_sql");
                                    if (mysqli_num_rows($cat_res) > 0) {
                                        while ($row = mysqli_fetch_assoc($cat_res)) {
                                            $options .= '<option value="' . $row['id'] . '">' . $row['category_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                    <select id="" name="category[]" rel="category" class="form-control input category">
                                        <option value="">Select Category</option>
                                        <?php echo $options; ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="product_name[]" id="category" rel="batch_no"
                                        class="form-control input product_name">
                                        <option value="">Select Product</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="batch_no[]" id="batch_no" rel="total_products"
                                        class="form-control input batch_no">
                                        <option value="">Select Batch</option>
                                    </select>
                                    <b><span id="total_products" style="color:green;font-size:16px;"></span></b>
                                    <input type="hidden" name="total_products[]" class="total_products" value="" />
                                </td>
                                <td>
                                    <input id="quantity" name="quantity[]" class="form-control input" type="number"
                                        value="" />
                                </td>

                                <td>
                                    <input id="rate" name="rate[]" class="form-control input" type="number" value="" />
                                </td>

                                <td>
                                    <input id="total_amount" name="total_amount[]" class="form-control input"
                                        type="text" value="" />
                                </td>

                                <td>
                                    <button type="button" id="add" name="add" value=""
                                        class="btn btn-primary">+</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" name="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        var option = '<?php echo $options ?>';
        var i = 1;
        $("#add").on("click", function (e) {
            e.preventDefault();
            $("#dynamicadd").append('<tr id=row' + i + ' class="tr-shadow"><td><select id="category" name="category[]" rel="category' + i + '" class="form-control input category"><option value="" selected disabled>Select Category</option>' + option + '</select></td><td><select name="product_name[]" id="category' + i + '" rel="batch_no' + i + '" class="form-control input product_name"><option value="" selected disabled>Select Product</option></select></td><td><select name="batch_no[]" id="batch_no' + i + '" rel="total_products' + i + '" class="form-control input batch_no"><option value="">Select Batch</option></select><b><span id="total_products' + i + '" style="color:green;font-size:16px;"></span></b><input type="hidden" name="total_products[]" class="total_products' + i + '" value="" /></td><td><input id="quantity" name="quantity[]" class="form-control input" type="number" value="" /></td></td><td><input id="rate" name="rate[]" class="form-control input" type="number" value="" /></td><td><input id="total_amount" name="total_amount[]" class="form-control input" type="text" value="" /></td><td><button type="button" id="' + i + '" name="add" value="" class="btn btn-danger remove_row">-</button></td></tr>');
            i++;
        });

        // var typingTimer;                //timer identifier
        // var doneTypingInterval = 2000;  //time in ms, 2 seconds for example
        // var $input = $('#rate');

        // //on keyup, start the countdown
        // $input.on('keyup', function () {
        //     clearTimeout(typingTimer);
        //     typingTimer = setTimeout(doneTyping, doneTypingInterval);
        // });

        // //on keydown, clear the countdown 
        // $input.on('keydown', function () {
        //     clearTimeout(typingTimer);
        // });

        // //user is "finished typing," do something
        // function doneTyping() {
        //     //do something
        //     var qty = $("#quantity").val();
        //     var igst = $("#igst").val();
        //     var rate = $("#rate").val();
        //     // console.log(qty + igst + rate);
        //     $.ajax({
        //         url: "sale_cal.php",
        //         type: "POST",
        //         data: { rate: rate, qty: qty, igst: igst },
        //         success: function (data) {
        //             $("#total_amount").val(data);
        //         }
        //     });
        // }
    });
    $(document).on("click", ".remove_row", function () {
        var row_id = $(this).attr('id');
        $('#row' + row_id + '').remove();
        i--;
    });


    $(document).on("change", ".category", function () {
        var cid = $(this).attr('rel');
        var c_id = $(this).val();
        // alert(cid);
        $.ajax({
            url: "product_catg.php",
            type: "POST",
            data: { c_id, c_id },
            success: function (data) {
                $("#" + cid).html(data);
            }
        });
    });

    $(document).on("change", ".product_name", function () {
        var pid = $(this).attr('rel');
        var p_id = $(this).val();
        // alert(p_id);
        $.ajax({
            url: "pro_batch.php",
            type: "POST",
            data: { p_id, p_id },
            success: function (data) {

                $("#" + pid).html(data);

            }
        });
    });


    $(document).on("change", ".batch_no", function () {
        var bid = $(this).attr('rel');
        var batch = $(this).val();
        data = batch.split('##');
        $.ajax({
            url: "getProductsno.php",
            type: "POST",
            data: { batch_id: data[0], date: data[1] },
            success: function (data) {
                $("#" + bid).text(data);
                $("." + bid).val(data);
            }
        });
    });
    $(document).ready(function () {
        $('input[type=radio][name=sellType]').change(function () {
            if (this.value == 'Plateform') {
                $('.warehouseOption').hide();
                $('.plateformOption').show();
            }
            else if (this.value == 'Warehouse') {
                $('.warehouseOption').show();
                $('.plateformOption').hide();
            }
        });
    });


</script>
<?php include_once 'footer.php'; ?>