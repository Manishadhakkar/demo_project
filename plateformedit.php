<?php include_once 'header.php'; ?>

<?php
$id = $_GET['id'];

$query = "SELECT * FROM `plateform` WHERE `id` = '" . $id . "'";
$res_query = mysqli_query($conn, $query) or die("query failed : query");
if (mysqli_num_rows($res_query) > 0) {
    $row = mysqli_fetch_assoc($res_query);
    $fetch_plateform = $row['plateform_name'];
    $fetch_status = $row['status'];
}
?>
<?php
if (isset($_POST['update'])) {
    $plateform_name = $_POST['name'];
    $status = $_POST['status'];
    if ($plateform_name == '') {
        $message = "Please Fill Plateform....!!";
    } else {
        $sql = "UPDATE `plateform` SET `plateform_name` = '" . $plateform_name . "', status = '" . $status . "' WHERE `id` = '" . $id . "'";

        $result = mysqli_query($conn, $sql) or die("query failed : sql");

        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                swal({
                    title: "Done",
                    text: "Platform Update Successfully!!",
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
?>
<section class="home">
    <div class="container">
        <?php include 'navbar.php'; ?>
        <div class="row">
            <div class="col-sm-2 p-2">
                <h3 class=""></h3>
            </div>
            <div class="col-sm-4 p-3">
                <h3 class="">Platform Information</h3>
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
                        <label class="block text-gray-700">Platform Name*</label>
                        <input type="text" name="name" id=""
                            value="<?php if (isset($_POST['name'])) {
                                echo $_POST['name'];
                            } else {
                                echo $fetch_plateform;
                            } ?>"
                            class="form-control input">
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
                    <button type="submit" name="update" class="btn btn-primary btn-sm btn-block">Update</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</section>

<?php include_once 'footer.php'; ?>