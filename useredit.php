<?php
require_once('header.php');
$id = $_GET['id'];
$invt_sql = "SELECT * FROM `users` WHERE `id`= '" . $id . "' LIMIT 1";
$invt_res = mysqli_query($conn, $invt_sql);
if (mysqli_num_rows($invt_res) > 0) {
    $row = mysqli_fetch_assoc($invt_res);
    // echo '<pre>'; print_r($row);
    $role = $row['role'];
    $fetch_name = $row['name'];
    $fetch_email = $row['email'];
    $fetch_password = $row['password'];
    $fetch_phone = $row['phone'];
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
                window.location.href = "users.php";
            }, 2000);
    </script>
<?php }

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $status = $_POST['status'];


    $update_user = "UPDATE `users` SET `name`= '" . $name . "',`email` = '" . $email . "',`password` = '" . $password . "', `phone` = '" . $phone . "', `status` = '" . $status . "' WHERE `id`='" . $id . "'";

    $update_result = mysqli_query($conn, $update_user) or die("query failed");

    if ($_SESSION['role'] == '1') {
        $by = 'Admin';
    } else {
        $by = 'User';
    }
    $activity_type = "User Updated";
    $activity_msg = " User " . $name . " Updated by " . $by;
    user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);
    // echo $update_result; exit;
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            swal({
                title: "Done",
                text: "User Edit Successfully!!",
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
                <h3 class="">Edit User</h3>
            </div>
            <div class="col-sm-3 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-3  p-3"><a href="users.php"><button class="btn btn-success">Users</button></a></div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <form class="form1" action="" method="POST">
                    <div class="mt-2">
                        <label class="block text-gray-700"> Name</label>
                        <input type="text" name="name" id="" placeholder="Enter Full Name" class="form-control input"
                            value="<?php echo $fetch_name ?>">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Email</label>
                        <input type="text" name="email" id="" placeholder="Enter Email Id" class="form-control input"
                            value="<?php echo $fetch_email ?>">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Phone</label>
                        <input type="number" name="phone" id="" class="form-control input"
                            value="<?php echo $fetch_phone ?>">
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700">Password</label>
                        <input name="password" id="" type="password" class="form-control input"
                            value="<?php echo $fetch_password ?>">
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