<?php

include("common/db.php");

if (!empty($_SESSION['admin'])) {
    header('location:index.php');
}

if (isset($_POST["submit"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];
    if (empty($email)) {
        $email_err = "Email is Required !";
    }
    if (empty($password)) {
        $password_err = "Password is Required !";
    }

    if (!empty($email) || !empty($password)) {
        $login_users = "SELECT * FROM users WHERE `email`='$email' AND `password`='$password'";
        $login_exe = mysqli_query($con, $login_users);
        $login_data = mysqli_fetch_assoc($login_exe);

        if ($login_data) {
            $_SESSION['admin'] = $login_data;
            header('location:index.php');
        } else {
            $error = "Invalid email and password !";
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
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .m-3 {
            margin: 10px 0px !important
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
                                    <h4>LOGIN</h4>
                                </a>

                                <form class="mt-5 mb-5 login-input" method="post">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Email" name="email">
                                    </div>
                                    <div class="m-3 text-danger">
                                        <?php if (isset($email_err)) { ?>
                                            <?php echo $email_err; ?>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Password"
                                            name="password">
                                    </div>
                                    <div class="m-3 text-danger">
                                        <?php if (isset($password_err)) { ?>
                                            <?php echo $password_err; ?>
                                        <?php } elseif (isset($error)) { ?>

                                            <?php echo $error; ?>
                                        <?php } ?>
                                        <button class="btn login-form__btn submit w-100" name="submit"
                                            type="submit">Sign In</button>
                                </form>
                                <p class="mt-5 login-form__footer">Dont have account? <a href="page-register.php"
                                        class="text-primary">Sign Up</a> now</p>
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
    <script>if (window.history.replaceState) {
         window.history.replaceState(null, null, window.location.href);
      }</script>
</body>

</html>