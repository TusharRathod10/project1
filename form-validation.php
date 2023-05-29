<?php

include("common/db.php");

if (isset($_POST['submit'])) {

    $ename = $_POST['ename'];
    $eamount = $_POST['eamount'];
    $etype = $_POST['etype'];
    $etitle = $_POST['etitle'];

    $oldid = isset($_SESSION['admin']['id']) ? $_SESSION['admin']['id'] : '';

    if (empty($ename)) {
        $ename_err = "Name is required";
    }
    if (empty($eamount)) {
        $eamount_err = "Amount is required";
    }
    if (empty($etype)) {
        $etype_err = "Type is required";
    }
    if (empty($etitle)) {
        $etitle_err = "Title is required";
    }

    if (empty($_FILES['image']['name'])) {
        $image_err = "Image is required";
    } else {
        $explode = explode('.', $_FILES['image']['name']);
        $extension = end($explode);
        $image = time() . "." . $extension;
        $tmp_name = $_FILES['image']['tmp_name'];
        $file = 'images/' . $image;
        if (move_uploaded_file($tmp_name, $file)) {
            $insert = "INSERT INTO form (`user_id`,`name`,`title`,`select`,`amount`,`image`) VALUES ('$oldid','$ename','$etitle','$etype','$eamount','$image')";
            $insert_exe = mysqli_query($con, $insert);
            if ($insert_exe) {
                $success = "Expence add successfully.";
            } else {
                $error = "Somthing went wrong.";
            }
        }
    }
}
$select_data = "SELECT * FROM form";
$select_exe = mysqli_query($con, $select_data);

$getuser = "SELECT * FROM users";
$getuser_exe = mysqli_query($con, $getuser);

if (isset($_GET['delete_id'])) {
    $id = base64_decode($_GET['delete_id']);
    $select_data1 = "SELECT * FROM form WHERE `id`='$id'";
    $select_exe1 = mysqli_query($con, $select_data1);
    $data = mysqli_fetch_assoc($select_exe1);
    $image = $data['image'];

    if (!empty($image)) {
        if (unlink('images/' . $image)) {
            $delete_data = "DELETE FROM form WHERE `id`='$id'";
            $delete_exe = mysqli_query($con, $delete_data);
            header('location:form-validation.php');
        } else {
            $derror = "Something went wrong.";
        }
    }
}

if (isset($_GET['update_id'])) {
    $update_id = base64_decode($_GET['update_id']);

    $get_data = "SELECT * FROM form WHERE `id`='$update_id' ";
    $data_exe = mysqli_query($con, $get_data);
    $data_arr = mysqli_fetch_assoc($data_exe);

}

if (isset($_POST['update'])) {
    $id = base64_decode($_GET['update_id']);

    $newename = $_POST['ename'] ? $_POST['ename'] : $data_arr['name'];
    $newetype = $_POST['etype'] ? $_POST['etype'] : $data_arr['select'];
    $neweamount = $_POST['eamount'] ? $_POST['eamount'] : $data_arr['amount'];
    $newetitle = $_POST['etitle'] ? $_POST['etitle'] : $data_arr['title'];

    $data_update = "UPDATE form SET `name`='$newename',`select`='$newetype',`amount`='$neweamount',`title`='$neweamount' WHERE `id`='$id'";
    $updated_data_exe = mysqli_query($con, $data_update);

    if ($updated_data_exe) {
        header('location:form-validation.php');
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
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-valide" action="#" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Name <span
                                                    class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" placeholder="Enter Name"
                                                    aria-label="Username" aria-describedby="basic-addon1" name="ename" value="<?php if(isset($data_arr['name'])){echo $data_arr['name'];}?>">
                                                <div class="text-danger">
                                                    <?php if (isset($ename_err)) { ?>
                                                        <?php echo $ename_err; ?>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-email">Title <span
                                                    class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" placeholder="Enter Title"
                                                    aria-label="Username" aria-describedby="basic-addon1" name="etitle"value="<?php if(isset($data_arr['title'])){echo $data_arr['title'];}?>">
                                                <div class="text-danger">
                                                    <?php if (isset($etitle_err)) { ?>
                                                        <?php echo $etitle_err; ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-skill">User<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="etype" id="val-skill" >
                                                    <option value="0" hidden selected>Select User</option>
                                                    <?php while($users=mysqli_fetch_assoc($getuser_exe)){?>
                                                        <option value="<?php echo $users['name'];?>"><?php echo $users['name'];?></option>
                                                    <?php }?>
                                                </select>
                                                <div class="text-danger">
                                                    <?php if (isset($etype_err)) { ?>
                                                        <?php echo $etype_err; ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-digits">Amount <span
                                                    class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="number" class="form-control" placeholder="Enter Amount"
                                                    aria-label="Username" aria-describedby="basic-addon1"
                                                    name="eamount"value="<?php if(isset($data_arr['amount'])){echo $data_arr['amount'];}?>">
                                                <div class="text-danger">
                                                    <?php if (isset($eamount_err)) { ?>
                                                        <?php echo $eamount_err; ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if(!isset($_GET['update_id'])){?><div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-digits">File <span
                                                    class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <div class="input-group">
                                                    <input type="file" class="form-control"
                                                        aria-describedby="basic-addon1" onchange="preview()"
                                                        name="image">
                                                </div>
                                                <div class="text-danger">
                                                    <?php if (isset($image_err)) { ?>
                                                        <?php echo $image_err; ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div><?php }?>
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <?php if(isset($_GET['update_id'])){?><button type="submit" class="btn btn-primary"
                                                    name="update">Update</button><?php } else {?>
                                                <button type="submit" class="btn btn-primary"
                                                    name="submit">Submit</button><?php }?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php if (!isset($_GET['update_id'])) { ?>
                            <div class="row mt-5 px-3">
                                <div class="col-12 box-margin">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title m-2">Your Data</h4>
                                            <?php if (isset($dsuccess)) { ?>
                                                <div class="alert alert-success">
                                                    <?php echo $dsuccess; ?>
                                                </div>
                                            <?php } else if (isset($derror)) { ?>
                                                    <div class="alert alert-danger">
                                                    <?php echo $derror; ?>
                                                    </div>
                                            <?php } ?>
                                            <table id="datatable-buttons"
                                                class="table table-striped dt-responsive nowrap w-100">
                                                <div class="dt-buttons btn-group m-2"> <button
                                                        class="btn btn-secondary buttons-copy buttons-html5 mr-2"
                                                        tabindex="0" aria-controls="datatable-buttons"
                                                        type="button"><span>Copy</span></button>
                                                    <button class="btn btn-secondary buttons-print" tabindex="0"
                                                        aria-controls="datatable-buttons"
                                                        type="button"><span>Print</span></button>
                                                </div>
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>User Id</th>
                                                        <th>Name</th>
                                                        <th>Title</th>
                                                        <th>Users</th>
                                                        <th>Amount</th>
                                                        <th>Image</th>
                                                        <th>Date/Time</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($data = mysqli_fetch_assoc($select_exe)) { ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $data['id'] ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $data['user_id'] ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $data['name'] ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $data['title'] ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $data['select'] ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $data['amount'] ?>
                                                            </td>
                                                            <td>
                                                                <?php echo '<img id="frame" src="images/' . $data['image'] . '" alt="Image" style="width:100px;height:100px;" class="img-fluid" /> ' ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $data['create'] ?>
                                                            </td>
                                                            <td><a
                                                                    href="form-validation.php?update_id=<?php echo base64_encode($data['id']); ?>"><button
                                                                        class="btn btn-primary btn-circle"><i
                                                                            class="fa fa-edit"></i></button></a></td>
                                                            <td><a
                                                                    href="form-validation.php?delete_id=<?php echo base64_encode($data['id']); ?>"><button
                                                                        class="btn btn-danger btn-circle"><i
                                                                            class="fa fa-trash"></i></button></a></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                        </div> <!-- end card body-->
                                    </div> <!-- end card -->
                                </div><!-- end col-->
                            </div>
                        <?php } ?>
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

    <script src="./plugins/validation/jquery.validate.min.js"></script>
    <script src="./plugins/validation/jquery.validate-init.js"></script>
    <script>
        function preview() {
            frame.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
    <script>if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }</script>
</body>

</html>