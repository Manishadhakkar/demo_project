<?php include_once 'header.php'; ?>
<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $fssai = $_POST['fssai'];
    $firm_name = $_POST['firm_name'];
    $address = $_POST['address'];
    $created_at = date("Y-m-d");

    if ($name == '' or $email == '' or $phone == '' or $fssai == '' or $firm_name == '' or $address == '') {
        $message = "Please Fill All fields....!!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid Email Format....!!";
    } else {
        $email_sql = "SELECT `email` FROM `vendors` WHERE `email` = '" . $email . "'";
        $email_res = mysqli_query($conn, $email_sql) or die("query failed : email_sql");
        if (mysqli_num_rows($email_res) > 0) {
            $email_error = "Email ID Already Exist...!!";
        } else {
            $sql = "INSERT INTO `vendors`(`vendor_name`,`email`,`phone`,`fssai`,`firm_name`,`address`,`created_at`) VALUES ('" . $name . "','" . $email . "','" . $phone . "','" . $fssai . "','" . $firm_name . "','" . $address . "','" . $created_at . "')";
            $result = mysqli_query($conn, $sql) or die("query failed : sql");

            if ($_SESSION['role'] == '1') {
                $by = 'Admin';
            } else {
                $by = 'User';
            }
            $activity_type = "Vendor Added";
            $activity_msg = $name . " " . "Vendor add" . " by " . $by . " " . "From" . " " . $address;
            user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);
            ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    swal({
                        title: "Done",
                        text: "Vendor Information Add Successfully!!",
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
                <h3 class="">Add Vendor</h3>
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
                        <label class="block text-gray-700"> Name</label>
                        <input type="text" name="name" id=""
                            value="<?php if (isset($_POST['name'])) {
                                echo $_POST['name'];
                            } else {
                                echo '';
                            } ?>"
                            placeholder="Enter Name" class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Email</label>
                        <input type="text" name="email" id="" placeholder="Enter Email Id"
                            value="<?php if (isset($_POST['email'])) {
                                echo $_POST['email'];
                            } else {
                                echo '';
                            } ?>"
                            class="form-control input">
                        <span style="background-color:white; color:red; font-size:20px;">
                            <?php echo isset($email_error) ? $email_error : ''; ?>
                        </span>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Phone</label>
                        <input type="number" name="phone" id="" placeholder="Enter phone Number"
                            value="<?php if (isset($_POST['phone'])) {
                                echo $_POST['phone'];
                            } else {
                                echo '';
                            } ?>"
                            class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">FSSAI</label>
                        <input type="text" name="fssai" id="" placeholder="Enter FSSAI Number"
                            value="<?php if (isset($_POST['fssai'])) {
                                echo $_POST['fssai'];
                            } else {
                                echo '';
                            } ?>"
                            class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">FIRM Name</label>
                        <input type="text" name="firm_name" id="" placeholder="Enter Firm Name"
                            value="<?php if (isset($_POST['firm_name'])) {
                                echo $_POST['firm_name'];
                            } else {
                                echo '';
                            } ?>"
                            class="form-control input">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Address</label>
                        <textarea name="address" type="text" id="" class="form-control input"
                            placeholder="Enter Address"></textarea>
                    </div><br>
                    <button type="submit" name="submit" class="btn btn-primary">Add Vendor</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</section>
<?php include_once 'footer.php'; ?>