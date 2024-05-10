<?php include_once 'header.php'; ?>

<?php
$id = $_GET['id'];
$query = "SELECT * FROM `vendors` WHERE `id` = '" . $id . "'";
$res_query = mysqli_query($conn, $query) or die("query failed : query");
if (mysqli_num_rows($res_query) > 0) {
    $row = mysqli_fetch_assoc($res_query);
    $fetch_name = $row['vendor_name'];
    $fetch_email = $row['email'];
    $fetch_phone = $row['phone'];
    $fetch_fssai = $row['fssai'];
    $fetch_firm = $row['firm_name'];
    $fetch_address = $row['address'];
    $fetch_status = $row['status'];
}

if (isset($_POST['update'])) {
    $uid = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $fssai = $_POST['fssai'];
    $firm_name = $_POST['firm_name'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    // $created_at = date("Y-m-d");

    if ($name == '' or $email == '' or $phone == '' or $fssai == '' or $firm_name == '' or $address == '') {
        $message = "Please Fill All fields....!!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid Email Format....!!";
    } else {
        $sql = "UPDATE `vendors` SET `vendor_name` = '" . $name . "', `email` = '" . $email . "', `phone` = '" . $phone . "', `fssai` = '" . $fssai . "', `firm_name` = '" . $firm_name . "', `address` = '" . $address . "', `status` = '" . $status . "' WHERE `id` = '" . $uid . "'";
        $result = mysqli_query($conn, $sql) or die("query failed : sql");

        if ($_SESSION['role'] == '1') {
            $by = 'Admin';
        } else {
            $by = 'User';
        }
        $activity_type = "Vendor Updated";
        $activity_msg = $name . " Vendor Updated by " . $by;
        user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                swal({
                    title: "Done",
                    text: "Vendor Information Update Successfully!!",
                    icon: "success",
                    button: "OK",
                    timer: 2000
                });
            });
        </script>
        <script>
            const myTimeout = setTimeout(
                function location() {
                    window.location.href = "vendors.php";
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

            <div class="col-sm-4 p-2">
                <h3 class="">Vendor Information</h3>
            </div>
            <div class="col-sm-3 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-3 p-2"><a href="vendors.php"><button class="btn btn-success">Vendors</button></a></div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <span style="background-color:white; color:red; font-size:20px;">
                    <?php echo isset($message) ? $message : ''; ?>
                </span>
                <form class="form1" action="" method="POST">
                    <div class="mt-2">
                        <label class="block text-gray-700">Name*</label>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="text" name="name" id=""
                            value="<?php if (isset($_POST['name'])) {
                                echo $_POST['name'];
                            } else {
                                echo $fetch_name;
                            } ?>"
                            placeholder="Enter Name" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Email*</label>
                        <input type="text" name="email" id="" placeholder="Enter Email Id"
                            value="<?php if (isset($_POST['email'])) {
                                echo $_POST['email'];
                            } else {
                                echo $fetch_email;
                            } ?>"
                            class="form-control input">
                        <span style="background-color:white; color:red; font-size:20px;">
                            <?php echo isset($email_error) ? $email_error : ''; ?>
                        </span>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Phone*</label>
                        <input type="number" name="phone" id="" placeholder="Enter phone Number"
                            value="<?php if (isset($_POST['phone'])) {
                                echo $_POST['phone'];
                            } else {
                                echo $fetch_phone;
                            } ?>"
                            class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">FSSAI*</label>
                        <input type="text" name="fssai" id="" placeholder="Enter FSSAI Number"
                            value="<?php if (isset($_POST['fssai'])) {
                                echo $_POST['fssai'];
                            } else {
                                echo $fetch_fssai;
                            } ?>"
                            class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">FIRM Name*</label>
                        <input type="text" name="firm_name" id="" placeholder="Enter Firm Name"
                            value="<?php if (isset($_POST['firm_name'])) {
                                echo $_POST['firm_name'];
                            } else {
                                echo $fetch_firm;
                            } ?>"
                            class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Address*</label>
                        <textarea name="address" type="text" id="" class="form-control input"
                            placeholder="Enter Address"><?php if (isset($_POST['address'])) {
                                echo $_POST['address'];
                            } else {
                                echo $fetch_address;
                            } ?></textarea>
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
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</section>

<?php include_once 'footer.php'; ?>