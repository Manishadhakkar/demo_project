<?php include_once 'header.php'; ?>
<?php
if (isset($_POST['submit'])) {
    $category_name = $_POST['name'];
    $igst = $_POST['igst'];
    $created_at = date("Y-m-d");

    if ($category_name == '') {
        $message = "Please Fill Category....!!";
    } else {
        $category_sql = "SELECT `category_name` FROM `category` WHERE `category_name` = '" . $category_name . "'";
        $category_res = mysqli_query($conn, $category_sql) or die("query failed : category_sql");
        if (mysqli_num_rows($category_res) > 0) {
            $category_error = "Category Already Exist...!!";
        } else {
            $sql = "INSERT INTO `category`(`category_name`,`igst`,`created_at`) VALUES ('" . $category_name . "','".$igst."','" . $created_at . "')";

            $result = mysqli_query($conn, $sql) or die("query failed : sql");

            if ($_SESSION['role'] == '1') {
                $by = 'Admin';
            } else {
                $by = 'User';
            }
            $activity_type = "Category Add";
            $activity_msg = $category_name . " " . "category added by " . $by;
            user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);

            ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    swal({
                        title: "Done",
                        text: "Category Add Successfully!!",
                        icon: "success",
                        button: "OK",
                        timer: 2000
                    });
                });
            </script>
            <script>
                const myTimeout = setTimeout(
                    function location() {
                        window.location.href = "category.php";
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
                <h3 class="">Add Category</h3>
            </div>
            <div class="col-sm-3 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-3 p-2"><a href="category.php"><button class="btn btn-success">Category</button></a></div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <span style="background-color:white; color:red; font-size:20px;">
                    <?php echo isset($message) ? $message : ''; ?>
                </span>
                <form class="form1" action="" method="POST">
                    <div class="mt-2">
                        <label class="block text-gray-700">Category Name</label>
                        <input type="text" name="name" id=""
                            value="<?php if (isset($_POST['name'])) {
                                echo $_POST['name'];
                            } else {
                                echo '';
                            } ?>"
                            placeholder="Enter Category" class="form-control input">
                        <span style="background-color:white; color:red; font-size:20px;">
                            <?php echo isset($category_error) ? $category_error : ''; ?>
                        </span>
                    </div>
                    <div class="mt-2">
                        <label class="block text-gray-700">IGST %</label>
                        <input type="number" name="igst" id=""
                            value="<?php if (isset($_POST['igst'])) {
                                echo $_POST['igst'];
                            } else {
                                echo '';
                            } ?>"
                            placeholder="Enter IGST" class="form-control input">
                    </div>
                    <br>
                    <button type="submit" name="submit" class="btn btn-primary btn-sm btn-block">Add Category</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</section>
<?php include_once 'footer.php'; ?>