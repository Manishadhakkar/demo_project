<script src="js/cdn.bootcss.com_jquery_3.3.1_jquery.js"></script>
<script src="js/unpkg.com_sweetalert@2.1.2_dist_sweetalert.min.js"></script>
<?php
include_once 'connection.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username == '') {
        $umsg = "Please Fill the Username";
    } elseif ($password == '') {
        $pmsg = "Please Fill the Password";
    } else {
        $login_sql = "SELECT * FROM `users` WHERE `email`='" . $username . "' AND `password` = '" . $password . "'";
        $login_res = mysqli_query($conn, $login_sql) or die("query failed : login_sql");
        if (mysqli_num_rows($login_res) > 0) {
            while ($row = mysqli_fetch_assoc($login_res)) {
                if ($row['status'] == '1') {
                    
                    $_SESSION['login_user_id'] = $row['id'];
                    $_SESSION['username'] = $row['email'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['name'] = $row['name'];

                    ?>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            swal({
                                title: "Welcome Back",
                                text: "You Logged In Successfully!!",
                                icon: "success",
                                button: "OK",
                                timer: 2000
                            });
                        });
                    </script>
                    <script>
                        const myTimeout = setTimeout(
                            function location() {
                                window.location.href = "dashboard.php";
                            }, 2000);

                    </script>
                    <?php
                } else {
                    $error_msg = "You are not Active User.<br>Please Contact Admin";
                }
            }
        } else {
            $error_msg = "Username and Password Not Matched";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="icon" href="images/logo.webp" sizes="32x32" />
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div class="container">
        <div class="login">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                <center><img src="images/logo.webp"></center>
                <hr>
                <p><b>WELCOME</b></p>
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter Email ID"
                    value="<?php if (isset($_POST['username'])) {
                        echo $_POST['username'];
                    } else {
                        echo '';
                    } ?>">
                <span style="text-align:center; color:red; font-size:16px;"><b>
                        <?php echo isset($umsg) ? $umsg : ''; ?>
                    </b></span>
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter Password"
                    value="<?php if (isset($_POST['password'])) {
                        echo $_POST['password'];
                    } else {
                        echo '';
                    } ?>">
                <span style="text-align:center; color:red; font-size:16px;"><b>
                        <?php echo isset($pmsg) ? $pmsg : ''; ?>
                    </b></span>
                <button class="login_btn" type="submit" name="login">Login</button>
                <span style="text-align:center; color:red; font-size:18px;"><b>
                        <?php echo isset($error_msg) ? $error_msg : ''; ?>
                    </b></span>
                <!-- <p>
                    <a href="#">Forgot Password?</a>
                </p> -->
            </form>
        </div>
    </div>
</body>

</html>