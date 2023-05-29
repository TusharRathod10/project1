<?php

include("common/db.php");

if(!empty($_SESSION['admin'])){
    header('location:index.php');
 }

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ((isset($name) && empty($name)) || (isset($email) && empty($email)) || (isset($password) && empty($password)) || (isset($cpassword) && empty($cpassword))) {
        if (empty($name)) {
            $name_err = "Please Enter Name !";
        }
        if (empty($email)) {
            $email_err = "Please Enter Email !";
        }
        if (empty($password)) {
            $password_err = "Please Enter Password !";
        }
        if (empty($cpassword)) {
            $cpassword_err = "Please Enter Confirm Password !";
        }
    } elseif ((!empty($name)) && (!empty($email)) && (!empty($password)) && (!empty($cpassword))) {
        $pass_length = strlen($password);
        $split_email = explode('@', $email);
        if ($password != $cpassword) {
            $match_err = "Password Not Matched !";
        } elseif ($pass_length < 8) {
            $length_err = "Password Length must be 8 characters !";
        } elseif (($split_email[1] != 'gmail.com') && ($split_email[1] != 'mailinator.com')) {
            $mail_only = "Please Enter Valid Mail !";
        } else {
            $user = "SELECT email FROM users WHERE `email`='$email'";
            $user_exe = mysqli_query($con, $user);
            $user_count = mysqli_num_rows($user_exe);

            if ($user_count > 0) {
                $no_repeat = "Email Already Exists !";
            } else {
                $insert = "INSERT INTO users (`name`,`email`,`password`) VALUES ('$name','$email','$password')";
                $insert_exe = mysqli_query($con, $insert);
                header("location:index.php");
            }
        }
    }
}

?>
<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Quixlab - Bootstrap Admin Dashboard Template by Themefisher.com</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
        integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .error {
            font-weight: bold;
            color: red;
            <?php if (
                isset($name_err) || isset($email_err) || isset($password_err) || isset($cpassword_err) || isset($match_err) || isset($length_err) || isset($mail_only) || isset($no_repeat)
            ) { ?>                           
                               margin-top: 0px;
                               margin-bottom: 10px;
            <?php } ?>
        }
    </style>
</head>

<body class="h-100">

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">

                                <a class="text-center" href="index.php">
                                    <h4>REGISTER</h4>
                                </a>

                                <form class="mt-5 mb-5 login-input" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Name" name="name">
                                    </div>
                                    <div class="error">
                                        <?php if (isset($name_err)) { ?>
                                            <?php echo $name_err; ?>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Email" name="email">
                                    </div>
                                    <div class="error">
                                        <?php if (isset($email_err)) { ?>
                                            <?php echo $email_err; ?>
                                        <?php } ?>
                                        <?php if (isset($mail_only)) { ?>
                                            <?php echo $mail_only; ?>
                                        <?php } ?>
                                        <?php if (isset($no_repeat)) { ?>
                                            <?php echo $no_repeat; ?>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Password"
                                            name="password">
                                    </div>
                                    <div class="error">
                                        <?php if (isset($password_err)) { ?>
                                            <?php echo $password_err; ?>
                                        <?php } ?>
                                        <?php if (isset($length_err)) { ?>
                                            <?php echo $length_err; ?>
                                        <?php } ?>
                                        <?php if (isset($match_err)) { ?>
                                            <?php echo $match_err; ?>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Confirm Password"
                                            name="cpassword">
                                    </div>
                                    <div class="error">
                                        <?php if (isset($cpassword_err)) { ?>
                                            <?php echo $cpassword_err; ?>
                                        <?php } ?>
                                    </div>
                                    <button class="btn login-form__btn submit w-100"   name="submit" type="submit">Sign
                                        in</button>
                                </form>
                                <p class="mt-5 login-form__footer">Have account <a href="page-login.php"
                                        class="text-primary">Sign In </a> now</p>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
    <script> if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }</script>
</body>

</html>