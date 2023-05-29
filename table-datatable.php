<?php

include("common/db.php");

if (isset($_GET['delete_id'])) {
    $id = base64_decode($_GET['delete_id']);
    $delete_data = "DELETE FROM users WHERE `id`='$id'";
    $delete_exe = mysqli_query($con, $delete_data);

    if ($delete_exe) {
        $success = "Admin deleted successfully.";
    } else {
        $error = "Something went wrong.";
    }
}
$select_data = "SELECT * FROM users";
$select_exe = mysqli_query($con, $select_data);

if (isset($_GET['update_id'])) {
    $update_id = base64_decode($_GET['update_id']);

    $get_data = "SELECT * FROM users WHERE `id`='$update_id' ";
    $data_exe = mysqli_query($con, $get_data);
    $data_arr = mysqli_fetch_assoc($data_exe);
}

if (isset($_POST['update'])) {
    $id = base64_decode($_GET['update_id']);

    $newname = $_POST['name'] ? $_POST['name'] : $data_arr['name'];
    $newemail = $_POST['email'] ? $_POST['email'] : $data_arr['email'];
    $newpassword = $_POST['password'] ? $_POST['password'] : $data_arr['password'];

    $data_update = "UPDATE users SET `name`='$newname',`email`='$newemail',`password`='$newpassword' WHERE `id`='$id'";
    $updated_data_exe = mysqli_query($con, $data_update);

    if ($updated_data_exe) {
        header('location:table-datatable.php');
    } else {
        $error = "Something went wrong";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Quixlab - Bootstrap Admin Dashboard Template by Themefisher.com</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
    <link href="./plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

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


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Header start
        ***********************************-->
        <?php include('common/header.php'); ?>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <?php include('common/sidebar.php'); ?>
        <!--**********************************
                    Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <?php if (isset($_GET['update_id'])) { ?>
                                    <div class="form1">
                                        <form method="post">
                                            <fieldset>
                                                <div class="form-group">
                                                    <input type="text" name="name" placeholder="Enter Fullname" class="form-control" value="<?php if (isset($_POST['name'])) {
                                                        echo $_POST['name'];
                                                    }
                                                    if (isset($_GET['update_id'])) {
                                                        echo $data_arr['name'];
                                                    } ?>" />
                                                </div><br>
                                                <div class="form-group">
                                                    <input type="email" name="email" placeholder="Enter E-mail" class="form-control" value="<?php if (isset($_POST['email'])) {
                                                        echo $_POST['email'];
                                                    }
                                                    if (isset($_GET['update_id'])) {
                                                        echo $data_arr['email'];
                                                    } ?>" />
                                                </div><br>
                                                <div class="form-group">
                                                    <input type="password" name="password" placeholder="Enter Password" class="form-control" value="<?php if (isset($_POST['password'])) {
                                                        echo $_POST['password'];
                                                    }
                                                    if (isset($_GET['update_id'])) {
                                                        echo $data_arr['password'];
                                                    } ?>" />
                                                </div><br>

                                                <div class="field " style="padding:10px;">
                                                    <button class="btn login-form__btn submit w-100" name="update" type="submit">Update</button>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                <?php } ?><br><br>
                                <h4 class="card-title">Data Table</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>NAME</th>
                                                <th>EMAIL</th>
                                                <th>PASSWORD</th>
                                                <th>CREATE</th>
                                                <th>UPDATE</th>
                                                <th>DELETE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($data = mysqli_fetch_assoc($select_exe)) { ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $data['id'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['name'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['email'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['password'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['create'] ?>
                                                    </td>
                                                    <td><a
                                                            href="table-datatable.php?update_id=<?php echo base64_encode($data['id']); ?>"><button
                                                                class="btn btn-primary btn-circle"><i
                                                                    class="fa fa-edit"></i></button></a></td>
                                                    <td><a
                                                            href="table-datatable.php?delete_id=<?php echo base64_encode($data['id']); ?>"><button
                                                                class="btn btn-danger btn-circle"><i
                                                                    class="fa fa-trash"></i></button></a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <?php include('common/footer.php'); ?>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>

    <script src="./plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="./plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="./plugins/tables/js/datatable-init/datatable-basic.min.js"></script>

</body>

</html>