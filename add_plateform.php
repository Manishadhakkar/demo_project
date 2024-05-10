<?php include_once 'header.php'; ?>
<?php
if (isset($_POST['submit'])) {
    $plateform_name = $_POST['name'];
    $created_at = date("Y-m-d");

    if ($plateform_name == '') {
        $message = "Please Fill Plateform....!!";
    } else {
        $plateform_sql = "SELECT `plateform_name` FROM `plateform` WHERE `plateform_name` = '" . $plateform_name . "'";
        $plateform_res = mysqli_query($conn, $plateform_sql) or die("query failed : plateform_sql");
        if (mysqli_num_rows($plateform_res) > 0) {
            $plateform_error = "Plateform Already Exist...!!";
        } else {
            $sql = "INSERT INTO `plateform`(`plateform_name`,`created_at`) VALUES ('" . $plateform_name . "','" . $created_at . "')";

            $result = mysqli_query($conn, $sql) or die("query failed : sql");

            if ($_SESSION['role'] == '1') {
                $by = 'Admin';
            } else {
                $by = 'User';
            }
            $activity_type = "Plateform Add";
            $activity_msg = $plateform_name . " " . "added by" . $by;
            user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);
            ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    swal({
                        title: "Done",
                        text: "Platfrom Add Successfully!!",
                        icon: "success",
                        button: "OK",
                        timer: 2000
                    });
                });
            </script>
            <script>
                const myTimeout = setTimeout(
                    function location() {
                        window.location.href = "plateform.php";
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
                <h3 class="">Add Platfrom</h3>
            </div>
            <div class="col-sm-3 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-3 p-2"><a href="plateform.php"><button class="btn btn-success">Platform</button></a>
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
                        <label class="block text-gray-700">Platfrom Name</label>
                        <input type="text" name="name" id=""
                            value="<?php if (isset($_POST['name'])) {
                                echo $_POST['name'];
                            } else {
                                echo '';
                            } ?>"
                            placeholder="Enter Platfrom" class="form-control input">
                        <span style="background-color:white; color:red; font-size:20px;">
                            <?php echo isset($plateform_error) ? $plateform_error : ''; ?>
                        </span>
                    </div><br>
                    <button type="submit" name="submit" class="btn btn-primary btn-sm btn-block">Add Platfrom</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</section>
<?php include_once 'footer.php'; ?>