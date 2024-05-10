<?php
// include_once 'connection.php';
include_once('header.php');

$id = $_GET['id'];
$product_sql = "SELECT * FROM `products` WHERE `id`= '" . $id . "'";
$product_res = mysqli_query($conn, $product_sql);
if (mysqli_num_rows($product_res) > 0) {
    $row = mysqli_fetch_assoc($product_res);

    // echo '<pre>'; print_r($row);
    // $fetch_vendor = $row['vendor'];
    $fetch_category = $row['category'];
    $fetch_product = $row['product_name'];
    $fetch_sku = $row['sku'];
    $fetch_minimum_qty = $row['min_qty'];
    // $fetch_price = $row['price'];
    // $fetch_quantity = $row['quantity'];
    $created_date = $row['created_date'];
    $fetch_product_image = $row['product_image'];
    $fetch_status = $row['status'];
}

if (isset($_POST['update'])) {
    $error = 'false';
    // $vendor = $_POST['vendor_name'];
    $category = $_POST['category'];
    $product = $_POST['product'];
    $sku = $_POST['sku'];
    $minimum_qty = $_POST['minimum'];
    $status = $_POST['status'];
    // $price = $_POST['price'];
    // $quantity = $_POST['quantity'];


    $created_date = date("Y-m-d");
    $filename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $folder = "products_image/" . $filename;
    move_uploaded_file($tempname, $folder);
    $FileType = pathinfo($filename, PATHINFO_EXTENSION);
    $fileName = pathinfo($filename, PATHINFO_FILENAME);
    $fileErr = '';
    $sizeErr = '';

    if ($filename != '') {
        $product_update_sql = "UPDATE `products` SET `vendor`= '" . $vendor . "', `category`= '" . $category . "' , `product_name` = '" . $product . "' ,`sku`='" . $sku . "',`min_qty`='" . $minimum_qty . "',`status`='" . $status . "',`product_image` = '" . $filename . "' WHERE `id`='" . $id . "'";
    } else {
        $product_update_sql = "UPDATE `products` SET `vendor`= '" . $vendor . "', `category`= '" . $category . "' , `product_name` = '" . $product . "' ,`sku`='" . $sku . "',`min_qty`='" . $minimum_qty . "',`status`='" . $status . "' WHERE `id`='" . $id . "'";
    }

    $product_result = mysqli_query($conn, $product_update_sql) or die("query failed : product_update_sql");
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            swal({
                title: "Done",
                text: "Products Update Successfully!!",
                icon: "success",
                button: "OK",
                timer: 2000
            });
        });
    </script>
    <script>
        const myTimeout = setTimeout(
            function location() {
                window.location.href = "products.php";
            }, 2000);
    </script>

<?php }
?>

<section class="home">
    <div class="container">

        <?php include 'navbar.php'; ?>

        <div class="row">
            <div class="col-sm-2 p-2">
                <h3 class=""></h3>
            </div>

            <div class="col-sm-4 p-2">
                <h3 class="">Edit Product</h3>
            </div>
            <div class="col-sm-3 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-3  p-3"><a href="products.php"><button class="btn btn-success">Products</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <span style="background-color:white; color:red; font-size:20px;">
                    <?php echo isset($message) ? $message : ''; ?>
                </span>
                <form class="form1" action="" method="POST" enctype="multipart/form-data">

                    <div class="mt-3">
                        <label class="block text-gray-700"> Category*</label>
                        <select name="category" class="form-control">
                            <option value="">Select</option>
                            <?php
                            $query = "SELECT * FROM `category`";
                            $res_query = mysqli_query($conn, $query) or die('query failed : query');
                            if (mysqli_num_rows($res_query) > 0) {
                                while ($row = mysqli_fetch_assoc($res_query)) {
                                    if ($fetch_category == $row['id']) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }

                                    ?>
                                    <option <?php echo $select; ?> value="<?php echo $row['id']; ?>">
                                        <?php echo $row['category_name']; ?>
                                    </option>
                                <?php }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Product Name*</label>
                        <input type="text" name="product" id="" placeholder="" class="form-control input"
                            value="<?php echo $fetch_product ?>">
                        <!-- <span style="text-align:center; color:red; font-size:16px;"><b><?php echo isset($emsg) ? $emsg : ''; ?></b></span> -->
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">SKU*</label>
                        <input type="text" name="sku" id="" placeholder="" class="form-control input"
                            value="<?php echo $fetch_sku ?>">
                        <!-- <span style="text-align:center; color:red; font-size:16px;"><b><?php echo isset($pmsg) ? $pmsg : ''; ?></b></span> -->
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Alert Quantity*</label>
                        <input type="text" name="minimum" id="" placeholder="" class="form-control input"
                            value="<?php echo $fetch_minimum_qty ?>">

                    </div>
                    <div class="mt-2">
                        <label class="block text-gray-700">Status*</label>
                        <select name="status" class="form-control input">
                            <option value="" selected disabled>Select</option>
                            <option value="1" <?php
                            if ($fetch_status == '1') {
                                echo "selected";
                            }
                            ?>>Active</option>
                            <option value="0" <?php
                            if ($fetch_status == '0') {
                                echo "selected";
                            }
                            ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Product Image*</label>
                        <input name="image" id="" type="file" class="form-control input"
                            src='<?php // echo $folder; ?>' value="">
                        <img src="<?php echo "products_image/" . $fetch_product_image; ?>" alt="">
                        <?php
                        if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != '' && $error == 'true') {
                            echo "<span style='color:red;'>" . $sizeErr . "</span>";
                            echo "<span style='color:red;'>" . $fileErr . "</span>";
                            ?>
                        <?php } ?>
                        <div class="mt-3" id="image_div">
                            <?php
                            // if($row['image']!=''){
                            //     $folder = "products_image/".$id."_".$row['image'];
                            
                            // ?>
                            <?php ?>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm" id="delete"> Remove Image</button>

                    </div><br>
                    <div class="alert alert-danger" id="error-message" style="display:none;"></div>
                    <div class="alert alert-success" id="success-message" style="display:none;"></div>
                    <button type="submit" name="update" class="btn btn-success btn-sm btn-block">Update
                        Product</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $("#delete").on("click", function () {

            // if(confirm("Do you really want to delete this image?")){
            var id = $("#p_id").val();
            // alert(id);
            $.ajax({
                url: "product_image_delete.php",
                type: "POST",
                data: { id: id },
                success: function (data) {
                    if (data == 1) {
                        $('#image_div').hide();
                        $("#success-message").html("Image Deleted").slideDown();
                        $("#error-message").slideUp();
                    } else {
                        $("#error-message").html("can't delete image").slideDown();
                        $("#success-message").slideUp();
                    }
                }
            });
            // }
        });
    });
</script>
<?php include_once 'footer.php'; ?>