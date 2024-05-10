<?php include_once 'header.php'; ?>
<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $phone_len = strlen($phone);
    $password = $_POST['password'];
    $created_at = date("Y-m-d");

    if ($name == '' or $email == '' or $phone == '' or $password == '') {
        $message = "Please Fill All fields....!!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid Email Format....!!";
    } elseif ($phone_len > 10 or $phone_len < 10) {
        $phone_err = "Invalid Mobile Number";
    } else {
        $email_sql = "SELECT `email` FROM `users` WHERE `email` = '" . $email . "'";
        $email_res = mysqli_query($conn, $email_sql) or die("query failed : email_sql");
        if (mysqli_num_rows($email_res) > 0) {
            $email_error = "Email ID Already Exist...!!";
        } else {
            $sql = "INSERT INTO `users`(`name`,`email`,`password`,`phone`,`role`,`created_at`) VALUES ('" . $name . "','" . $email . "','" . $password . "','" . $phone . "','2','" . $created_at . "')";

            $result = mysqli_query($conn, $sql) or die("query failed : sql");

            if ($_SESSION['role'] == '1') {
                $by = 'Admin';
            } else {
                $by = 'User';
            }
            $activity_type = "User Added";
            $activity_msg = $name . " " . "User add" . " by " . $by;
            user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);

            ?>

            <script type="text/javascript">
                $(document).ready(function () {
                    swal({
                        title: "Done",
                        text: "User Add Successfully!!",
                        icon: "success",
                        button: "OK",
                        timer: 2000
                    });
                });
            </script>
            <script>
                const myTimeout = setTimeout(
                    function location() {
                        window.location.href = "users.php";
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
                <h3 class="">Add User</h3>
            </div>
            <div class="col-sm-3 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-3 p-2"><a href="users.php"><button class="btn btn-success">Users</button></a></div>
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
                            placeholder="Enter Full Name" class="form-control input">
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
                        <span style="background-color:white; color:red; font-size:20px;"><b>
                                <?php echo isset($email_error) ? $email_error : ''; ?>
                            </b></span>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Phone</label>
                        <input type="number" name="phone" id="" placeholder="Enter phone number"
                            value="<?php if (isset($_POST['phone'])) {
                                echo $_POST['phone'];
                            } else {
                                echo '';
                            } ?>"
                            class="form-control input">
                        <span style="background-color:white; color:red; font-size:20px;"><b>
                                <?php echo isset($phone_err) ? $phone_err : ''; ?>
                            </b></span>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Password</label>
                        <input name="password" id="" type="password" class="form-control input"
                            value="<?php if (isset($_POST['password'])) {
                                echo $_POST['password'];
                            } else {
                                echo '';
                            } ?>"
                            placeholder="Enter Password">
                    </div><br>
                    <button type="submit" name="submit" class="btn btn-primary btn-sm btn-block">Add User</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</section>
<?php include_once 'footer.php'; ?>