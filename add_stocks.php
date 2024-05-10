<?php include_once 'header.php';
?>

<?php

if (isset($_POST['submit'])) {
$tot_brem_qty = 0;
$total_products = 0;
$tot_b_qty = 0;
    // echo '<pre>';print_r($_POST);exit;
    for ($i = 0; $i < count($_POST['product_name']); $i++) {
        $vendor = $_POST['vendor_name'];
        $pur_date = $_POST['date'];
        $invoice_no = $_POST['invoice_no'];
        $pro_id = $_POST['product_name'][$i];
		$sql_ = "SELECT `total_products` FROM `products` WHERE `id` = '" . $pro_id . "'";
		$res_ = mysqli_query($conn, $sql_) or die("query failed : sql");
		if(mysqli_num_rows($res_) > 0) {
			$row_ = mysqli_fetch_assoc($res_);
			$total_products = $row_['total_products'];
			$bal_product = $total_products;
		}else{
			$bal_product = $_POST['total_products'][$i];
		}
        $product_name = $_POST['product_name'][$i];
        $category = $_POST['category'][$i];
        $mfg_date = $_POST['mfg_date'][$i];
        $exp_date = $_POST['exp_date'][$i];
        $batch_no = $_POST['batch_no'][$i];
        $quantity = $_POST['quantity'][$i];
        $rate = $_POST['rate'][$i];
        $igst = $_POST['igst'][$i];
        $total_amount = $_POST['total_amount'][$i];
        $date = date("Y-m-d");
        $total_products = $bal_product + $_POST['quantity'][$i];

        // print_r($total_products);

        if ($vendor == '' or $pur_date == '' or $invoice_no == '' or $product_name == '' or $category == '' or $mfg_date == '' or $exp_date == '' or $batch_no == '' or $quantity == '' or $rate == '' or $igst == '' or $total_amount == '') {
            $message = "All Fields are Required";
        } else {
            $batch_sql = "SELECT `id`,`batch_no`,`quantity`,`rem_qty` FROM `batch_nos` WHERE `batch_no` = '" . $batch_no . "'";
            $batch_res = mysqli_query($conn, $batch_sql) or die("query failed : batch_sql");
            if (mysqli_num_rows($batch_res) > 0) {
                $rows = mysqli_fetch_assoc($batch_res);
                // echo '<pre>';print_r($rows);exit;
                $b_qty = $rows['quantity'];
                $brem_qty = $rows['rem_qty'];
                $batch_id = $rows['id'];
                $tot_b_qty = $b_qty + $quantity;
                $tot_brem_qty = $brem_qty + $quantity;

                $up_batch = "UPDATE `batch_nos` SET  `rem_qty` = '" . $tot_brem_qty . "' WHERE `batch_no` = '" . $batch_no . "'";
                $res_batch = mysqli_query($conn, $up_batch) or die("query failed : up_batch");
            } else {
                $ins_query = "INSERT INTO `batch_nos` (`product_id`,`batch_no`,`rem_qty`) VALUES ('" . $product_name . "','" . $batch_no . "','" . $quantity . "')";
                $res_query = mysqli_query($conn, $ins_query) or die("query failed : ins_query");
                $batch_id = mysqli_insert_id($conn);
            }

            $ins_sql = "INSERT INTO `stocks` (`vendor_id`,`p_date`,`invoice_no`,`product_id`,`category_id`,`mfg_date`,`exp_date`,`batch_no`,`quantity`,`rate/pcs`,`igst`,`total_amount`,`created_at`) VALUES ('" . $vendor . "','" . $pur_date . "','" . $invoice_no . "','" . $product_name . "','" . $category . "','" . $mfg_date . "','" . $exp_date . "','" . $batch_id . "','".$quantity."','" . $rate . "','" . $igst . "','" . $total_amount . "','" . $date . "')";
            // echo $ins_sql;exit;
            $result = mysqli_query($conn, $ins_sql) or die("query failed : ins_sql");

            $up_pro = "UPDATE `products` SET `total_products` = '" . $total_products . "' WHERE `id` = '" . $product_name . "'";

            $up_res = mysqli_query($conn, $up_pro) or die("query failed : up_pro");

            $sel_sql = "SELECT `product_name` FROM `products` WHERE `id` = '" . $product_name . "'";
            $sel_res = mysqli_query($conn, $sel_sql) or die("query failed : sel_sql");
            if (mysqli_num_rows($sel_res) > 0) {
                while ($row = mysqli_fetch_assoc($sel_res)) {
                    $product = $row['product_name'];
                }
            }

            if ($_SESSION['role'] == '1') {
                $by = 'Admin';
            } else {
                $by = 'User';
            }
            $activity_type = "Stock Add";
            $activity_msg = $quantity . "Quantity of" . " " . $product . " add by " . $by . " From Batch No : " . $batch_no . " on rate " . $rate . "with " . $invoice_no;
            user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);
            // echo $up_pro;exit;
        }
    }
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            swal({
                title: "Done",
                text: "Stocks Add Successfully!!",
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

            <div class="col-sm-4 p-2">
                <h3 class="">Add Stocks</h3>
            </div>
            <div class="col-sm-2 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-5 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-1 p-2"><a href="stocks.php"><button class="btn btn-success">Stocks</button></a></div>
        </div>
        <div class="row">
            <!-- <div class="col-sm-2"></div> -->
            <div class="col-sm-12">
                <span style="background-color:white; color:red; font-size:20px;">
                    <?php echo isset($message) ? $message : ''; ?>
                </span>
                <form class="form1" action="" method="POST">
                    <div class="row">
                    <div class="col-lg-4 col-sm-4">
                    <div class="mt-2">
                        <label class="block text-gray-700">Vendor</label>
                        <select name="vendor_name" id="" class="form-control input">
                            <option value="">Select Vendor</option>
                            <?php
                            $vendor_sql = "SELECT * FROM `vendors` WHERE `status` = '1'";
                            $vendor_res = mysqli_query($conn, $vendor_sql) or die("query failed : vendor_sql");
                            if (mysqli_num_rows($vendor_res) > 0) {
                                while ($row = mysqli_fetch_assoc($vendor_res)) {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['vendor_name']; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                    <div class="mt-2">
                        <label class="block text-gray-700">Purchase Date</label>
                        <input type="date" name="date" id="" value="<?php if (isset($_POST['date'])) {
                            echo $_POST['date'];
                        } else {
                            echo '';
                        } ?>" class="form-control input">
                    </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                    <div class="mt-2">
                        <label class="block text-gray-700">Invoice No.</label>
                        <input type="text" name="invoice_no" id="" value="<?php if (isset($_POST['invoice_no'])) {
                            echo $_POST['invoice_no'];
                        } else {
                            echo '';
                        } ?>" class="form-control input">
                    </div>
                    </div>
                    </div>
                    <table id="queueTable" class="table manage_queue_table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Products</th>
                                <th>MFG Date</th>
                                <th>EXP Date</th>
                                <th>Batch No.</th>
                                <th>Quantity</th>
                                <th>Rate/Pcs</th>
                                <th>IGST</th>
                                <th>Total Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="dynamicadd">
                            <tr id="row1" rel="1" class="tr-shadow">
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
                                    <select id="" name="category[]" rel="category" igst="igst1" class="form-control input category">
                                        <option value="" selected disabled>Select</option>
                                        <?php echo $options; ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="product_name[]" id="category"  rel="total_products"
                                        class="form-control input product_name">
                                        <option value="" selected disabled>Select</option>
                                        <option value=""></option>
                                    </select>
                                    <b><span id="total_products" style="color:green;font-size:16px;"></span></b>
                                    <input type="hidden" name="total_products[]" value="" class="total_products" />
                                </td>
                                <td>
                                    <input id="mfg_date" name="mfg_date[]" class="form-control input" type="date"
                                        value="" />
                                </td>
                                
                                <td>
                                    <input id="exp_date" name="exp_date[]" class="form-control input" type="date"
                                        value="" />
                                
                                </td>
                                <td>
                                    <input id="batch_no" name="batch_no[]" class="form-control input" type="text"
                                        value="" />
                                </td>
                                
                                <td>
                                    <input id="quantity1" name="quantity[]" class="form-control input" type="number"
                                        value=""  onchange="calculation(this);"/>
                                
                                </td>
                                <td>
                                    <input id="rate1" name="rate[]" class="form-control input" type="number" value="" onchange="calculation(this);" />
                                </td>
                                
                                <td>
                                    <input id="igst1" name="igst[]" class="form-control input" type="text" value="" onchange="calculation(this);" />
                                
                                </td>
                                <td>
                                    <input id="total_amount1" name="total_amount[]" class="form-control input"
                                        type="text" value="" onchange="calculation(this);"/>
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
    function calculation(v){
       
       var index_no = $(v).parent().parent().attr('rel');
       var quan = document.getElementById("quantity"+index_no).value;
       var rate = document.getElementById("rate"+index_no).value;
        var igst = document.getElementById("igst"+index_no).value;

        if(quan == '' || rate =='' || igst == ''){
           document.getElementById("total_amount"+index_no).value = 0;
        }else{
            var priqty = quan * rate ; 
            var total = (priqty * igst/100) + priqty;
           document.getElementById("total_amount"+index_no).value = total;
        }
      
       
    }
    $(document).ready(function () {
        var option = '<?php echo $options ?>';
        var i = 2;
        $("#add").on("click", function (e) {
            e.preventDefault();
            $("#dynamicadd").append('<tr id=row' + i + ' rel='+i+' class="tr-shadow"><td><select id="category" name="category[]" rel="category' + i + '" igst="igst' + i + '" class="form-control input category"><option value="" selected disabled>Select Category</option>' + option + '</select></td><td><select name="product_name[]" id="category' + i + '" rel="total_products' + i + '" class="form-control input product_name"><option value="" selected disabled>Select Product</option><option value=""></option></select><b><span id="total_products' + i + '" style="color:green;font-size:16px;"></span></b><input type="hidden" name="total_products[]" value="" class="total_products' + i + '" /></td><td><input id="mfg_date" name="mfg_date[]" class="form-control input" type="date" value="" /></td></td><td><input id="exp_date" name="exp_date[]" class="form-control input" type="date" value="" /></td></td><td><input id="batch_no" name="batch_no[]" class="form-control input" type="text" value="" /></td></td><td><input id="quantity'+i+'" name="quantity[]" class="form-control input" type="number" value="" onchange="calculation(this);" /></td></td><td><input id="rate'+i+'" name="rate[]" class="form-control input" type="number" value="" onchange="calculation(this);" /></td></td><td><input id="igst' + i + '" name="igst[]" class="form-control input" type="text" value="" onchange="calculation(this);" /></td><td><input id="total_amount'+i+'" name="total_amount[]" class="form-control input" type="text" value="0" /></td></td><td><button type="button" id="' + i + '" name="add" value="" class="btn btn-danger remove_row">-</button></td></tr>');
            i++;
        });

        $(document).on("click", ".remove_row", function () {
            var row_id = $(this).attr('id');
            $('#row' + row_id + '').remove();
            i--;
        });

        $(document).on("change", ".category", function () {
            var cid = $(this).attr('rel');
            var ci_d = $(this).attr('igst');
            var c_id = $(this).val();
            // alert(ci_d);
            $.ajax({
                url: "product_catg.php",
                type: "POST",
                data: { c_id, c_id },
                success: function (data) {
                    dataArr = data.split('##');
                    // console.log(dataArr);
                    $("#" + cid).html(dataArr[0]);
                    $("#" + ci_d).val(dataArr[1])
                }
            });
        });

        $(document).on("change", ".product_name", function () {
            var pid = $(this).attr('rel');
            var pro_id = $(this).val();
            // alert(pro_id);
            $.ajax({
                url: "get_productsNo.php",
                type: "POST",
                data: { pro_id, pro_id },
                success: function (data) {
                    $("#" + pid).text(data);
                    $("." + pid).val(data);
                }
            });
        });

        

    });
</script>

<?php include_once 'footer.php'; ?>