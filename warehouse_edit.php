<?php
require_once('header.php');
$id = $_GET['id'];
$invt_sql = "SELECT * FROM `warehouse` WHERE `id`= '" . $id . "' LIMIT 1";
$invt_res = mysqli_query($conn, $invt_sql);
if (mysqli_num_rows($invt_res) > 0) {
    $row = mysqli_fetch_assoc($invt_res);
    // echo '<pre>'; print_r($row);
    $fetch_name = $row['w_name'];
    $fetch_code = $row['w_code'];
    $fetch_address = $row['w_address'];
    $fetch_status = $row['status'];
}

if ($role == 1) { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            swal({
                title: "! Sorry",
                text: "You can not edit this user details!",
                icon: "warning",
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
<?php }

if (isset($_POST['update'])) {
    $warehouse_name = $_POST['name'];
    $warehouse_code = $_POST['code'];
    $warehouse_address = $_POST['address'];
    $status = $_POST['status'];


    $update_user = "UPDATE `warehouse` SET `w_name`= '" . $warehouse_name . "',`w_code` = '" . $warehouse_code . "',`w_address` = '" . $warehouse_address . "',`status` = '" . $status . "' WHERE `id`='" . $id . "'";

    $update_result = mysqli_query($conn, $update_user) or die("query failed");

    if ($_SESSION['role'] == '1') {
        $by = 'Admin';
    } else {
        $by = 'User';
    }
    $activity_type = "Warehouse Updated";
    $activity_msg = $warehouse_name . " Warehouse Updated by " . $by;
    user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);
    // echo $update_result; exit;
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            swal({
                title: "Done",
                text: "Warehouse Update Successfully!!",
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
<?php }
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
                <h3 class="">Edit Warehouse</h3>
            </div>
            <div class="col-sm-3 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-3  p-3"><a href="warehouse.php"><button class="btn btn-success">Warehouses</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <form class="form1" action="" method="POST">
                    <div class="mt-2">
                        <label class="block text-gray-700"> Warehouse Name</label>
                        <input type="text" name="name" id="" value="<?php echo $fetch_name ?>"
                            placeholder="Enter Full Name" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Warehouse Code</label>
                        <input type="text" name="code" id="" placeholder="Enter Warehouse Code "
                            value="<?php echo $fetch_code ?>" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Warehouse Address</label>
                        <input type="text" name="address" id="" placeholder="Enter Warehouse Address"
                            value="<?php echo $fetch_address ?>" class="form-control input">
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
                    <br>
                    <button type="submit" name="update" class="btn btn-primary btn-sm btn-block">UPDATE</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</section>

<?php include_once 'footer.php'; ?>