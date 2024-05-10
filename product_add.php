<?php
// include_once 'connection.php';
include_once 'header.php';
if (isset($_POST['submit'])) {

    $error = 'false';
    // $vendor = $_POST['vendor_name'];
    $category = $_POST['category'];
    $product = $_POST['product'];
    $sku = $_POST['sku'];
    $minimum_qty = $_POST['minimum'];
    // $price = $_POST['price'];
    // $quantity = $_POST['quantity'];

    // echo '<pre>'; print_r($_POST);exit;
    $created_date = date("Y-m-d");
    $filename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $folder = "products_image/" . $filename;
    $FileType = pathinfo($filename, PATHINFO_EXTENSION);
    $fileName = pathinfo($filename, PATHINFO_FILENAME);
    $fileErr = '';
    $sizeErr = '';

    if ($category == '' or $product == '' or $sku == '' or $filename == '') {
        $message = "All Fields are Required";
    } elseif ($_FILES["fileToupload"]["size"] > 200000) {
        $sizeErr = "image size is not greater than 2MB";
        $error = 'true';
    } elseif ($FileType !== "jpg" && $FileType !== "jpeg" && $FileType !== "png" && $FileType !== "webp") {
        $fileErr = "only jpg , jpeg ,webp, png files are allowed";
        $error = 'true';
    } else {
        $product_sql = "INSERT INTO `products`(`vendor`,`category`,`product_name`,`sku`,`min_qty`,`created_date`,`product_image`) VALUES ('" . $vendor . "','" . $category . "','" . $product . "','" . $sku . "','" . $minimum_qty . "','" . $created_date . "','" . $filename . "')";
        //   echo $product_sql; exit;
        $product_result = mysqli_query($conn, $product_sql) or die("query failed : sql");
        move_uploaded_file($tempname, $folder);

        //echo $result; exit;
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                swal({
                    title: "Done",
                    text: "Products Add Successfully!!",
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
}
?>

<?php include_once 'header.php'; ?>
<section class="home">
    <div class="container">

        <?php include 'navbar.php'; ?>

        <div class="row">
            <div class="col-sm-2 p-2">
                <h3 class=""></h3>
            </div>

            <div class="col-sm-4 p-2">
                <h3 class="">Add Product</h3>
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
                    <!-- <div class="mt-3">
        <label class="block text-gray-700">Vendor*</label>
        <select name="vendor_name" id="vendor_name" class="form-control input">
        <option value="">Select</option>
        <?php
        $vendor_sql = "SELECT * FROM `vendors`";
        $vendor_res = mysqli_query($conn, $vendor_sql) or die("query failed : vendor_sql");
        if (mysqli_num_rows($vendor_res) > 0) {
            while ($row = mysqli_fetch_assoc($vendor_res)) {
                if (isset($_POST['vendor_name']) && $_POST['vendor_name'] == $row['id']) {
                    $select = "selected";
                } else {
                    $select = "";
                }
                ?>
            <option <?php echo $select; ?> value = "<?php echo $row['id']; ?>"><?php echo $row['vendor_name']; ?></option>
            <?php }
        } ?>
       </select>
    </div> -->
                    <div class="mt-3">
                        <label class="block text-gray-700"> Category*</label>
                        <select name="category" class="form-control input">
                            <option value="">Select</option>
                            <?php
                            $query = "SELECT * FROM `category`";
                            $res_query = mysqli_query($conn, $query) or die('query failed : query');
                            if (mysqli_num_rows($res_query) > 0) {
                                while ($row = mysqli_fetch_assoc($res_query)) {
                                    if (isset($_POST['category']) && $_POST['category'] == $row['id']) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }
                                    ?>
                                    <option <?php echo $select; ?> value="<?php echo $row['id']; ?>"><?php echo $row['category_name']; ?></option>
                                <?php }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Product Name*</label>
                        <input type="text" name="product" id="" placeholder="Enter Product Name"
                            class="form-control input"
                            value="<?php if (isset($_POST['product'])) {
                                echo $_POST['product'];
                            } else {
                                echo '';
                            } ?>">
                        <!-- <span style="text-align:center; color:red; font-size:16px;"><b><?php echo isset($emsg) ? $emsg : ''; ?></b></span> -->
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">SKU*</label>
                        <input type="text" name="sku" id="" placeholder="" class="form-control input"
                            value="<?php if (isset($_POST['sku'])) {
                                echo $_POST['sku'];
                            } else {
                                echo '';
                            } ?>">

                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Alert Quantity*</label>
                        <input type="text" name="minimum" id="" placeholder="" class="form-control input"
                            value="<?php if (isset($_POST['minimum'])) {
                                echo $_POST['minimum'];
                            } else {
                                echo '';
                            } ?>">

                    </div>
                    <!-- <div class="mt-3">
        <label class="block text-gray-700">Price*</label>
        <input type="number" name="price" id="" placeholder="" class="form-control input" value="">
       
    </div>
    <div class="mt-3">
        <label class="block text-gray-700">Quantity*</label>
        <input type="number" name="quantity" id="" placeholder="" class="form-control input" value="">
       
    </div> -->
                    <div class="mt-3">
                        <label class="block text-gray-700">Product Image*</label>
                        <input name="image" id="" type="file" class="form-control input"
                            value="<?php if (isset($_POST['image'])) {
                                echo $_POST['image'];
                            } else {
                                echo '';
                            } ?>">
                        <?php
                        if ($error == 'true') {
                            echo "<span style='color:red;'>" . $sizeErr . "</span>";
                            echo "<span style='color:red;'>" . $fileErr . "</span>";
                            ?>
                        <?php } ?>


                    </div><br>
                    <button type="submit" name="submit" class="btn btn-success btn-sm btn-block">Add Product</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</section>
<?php include_once 'footer.php'; ?>