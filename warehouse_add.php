<?php include_once 'header.php'; ?>
<?php
if (isset($_POST['submit'])) {
    $warehouse_name = $_POST['name'];
    $warehouse_code = $_POST['code'];
    $warehouse_address = $_POST['address'];
    $created_at = date("Y-m-d");


    if ($warehouse_name == '' or $warehouse_code == '' or $warehouse_address == '') {
        $message = "Please Fill All fields....!!";
    } else {
        $warehouse_sql = "INSERT INTO `warehouse`(`w_name`,`w_code`,`w_address`,`status`,`created_at`) VALUES('" . $warehouse_name . "','" . $warehouse_code . "', '" . $warehouse_address . "','1','" . $created_at . "')";
        $result_sql = mysqli_query($conn, $warehouse_sql);

        if ($_SESSION['role'] == '1') {
            $by = 'Admin';
        } else {
            $by = 'User';
        }
        $activity_type = "Warehouse Added";
        $activity_msg = $warehouse_name . " warehouse added by" . $by;
        user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);

        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                swal({
                    title: "Done",
                    text: "Warehouse Add Successfully!!",
                    icon: "success",
                    button: "OK",
                    timer: 2000
                });
            });
        </script>
        <script>
            const myTimeout = setTimeout(
                function location() {
                    window.location.href = "warehouse.php";
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
                <h3 class="">Add Warehouse</h3>
            </div>
            <div class="col-sm-3 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-3 p-2"><a href="warehouse.php"><button class="btn btn-success">Warehouses</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <span style="background-color:white; color:red; font-size:20px;">
                    <?php echo isset($message) ? $message : ''; ?>
                </span>
                <form class="form1" action="" method="POST">
                    <div class="mt-2">
                        <label class="block text-gray-700"> Warehouse Name</label>
                        <input type="text" name="name" id=""
                            value="<?php if (isset($_POST['name'])) {
                                echo $_POST['name'];
                            } else {
                                echo '';
                            } ?>"
                            placeholder="Enter Full Name" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Warehouse Code</label>
                        <input type="text" name="code" id="" placeholder="Enter Warehouse Code "
                            value="<?php if (isset($_POST['code'])) {
                                echo $_POST['code'];
                            } else {
                                echo '';
                            } ?>"
                            class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Warehouse Address</label>
                        <input type="text" name="address" id="" placeholder="Enter Warehouse Address"
                            value="<?php if (isset($_POST['address'])) {
                                echo $_POST['address'];
                            } else {
                                echo '';
                            } ?>"
                            class="form-control input">
                    </div><br>
                    <!-- <div class="mt-3">
        <label class="block text-gray-700">Password</label>
        <input name="password" id="" type="password" class="form-
    </div><br> -->
                    <button type="submit" name="submit" class="btn btn-primary btn-sm btn-block">Add Warehouse</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</section>
<?php include_once 'footer.php'; ?>