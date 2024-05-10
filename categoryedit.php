<?php include_once 'header.php'; ?>

<?php
$id = $_GET['id'];

$query = "SELECT * FROM `category` WHERE `id` = '" . $id . "'";
$res_query = mysqli_query($conn, $query) or die("query failed : query");
if (mysqli_num_rows($res_query) > 0) {
    while ($row = mysqli_fetch_assoc($res_query)) {
        $fetch_category = $row['category_name'];
        $fetch_igst = $row['igst'];
    }
}
?>
<?php
if (isset($_POST['update'])) {
    $category_name = $_POST['name'];
    $igst = $_POST['igst'];
    if ($category_name == '' || $igst == '') {
        $message = "Please Fill Category....!!";
    } else {
        $sql = "UPDATE `category` SET `category_name` = '" . $category_name . "',`igst` = '".$igst."' WHERE `id` = '" . $id . "'";

        $result = mysqli_query($conn, $sql) or die("query failed : sql");

        if ($_SESSION['role'] == '1') {
            $by = 'Admin';
        } else {
            $by = 'User';
        }
        $activity_type = "Category Updated";
        $activity_msg = $fetch_category . " Category Updated by " . $by;
        user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);

        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                swal({
                    title: "Done",
                    text: "Category Update Successfully!!",
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
?>
<section class="home">
    <div class="container">
        <?php include 'navbar.php'; ?>
        <div class="row">
            <div class="col-sm-2 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-4 p-3">
                <h3 class="">Category Information</h3>
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
                                echo $fetch_category;
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
                                echo $fetch_igst;
                            } ?>"
                            placeholder="Enter IGST" class="form-control input">
                    </div>
                    <br>
                    <button type="submit" name="update" class="btn btn-primary btn-sm btn-block">Update</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</section>
<?php include_once 'footer.php'; ?>