<?php
    require_once("../../includes/required.php");
    $page = "Profile";
    if(isset($_POST['update']))
    {
        $first = $_POST['fname'];
        $middle = $_POST['mname'];
        $last = $_POST['lname'];
        if($first == '' || $last == '')
        {
            $statuscode = 0;
            $status = "First name or Last name cannot be blank!";
        }
        else if(strlen($first) < 3 || strlen($last) < 3)
        {
            $statuscode = 0;
            $status = "First name or Last name is too short!";
        }
        else if($fname == $first && $mname == $middle && $lname == $last)
        {
            $statuscode = 2;
            $status = "No change found!";
        }
        else
        {
            if(update("confidential", "fname='$first', mname='$middle', lname='$last'", json_encode(['user_id'=>$_SESSION['user_id']]), ''))
            {
                $statuscode = 1;
                $status = "Settings updated successfully...";
                $fname = $first;
                $mname = $middle;
                $lname = $last;
                $fullname = $fname." ".$mname." ".$lname;
            }
            else
            {
                $statuscode = 0;
                $status = "Something went wrong!";
            }
        }
    }
    else if(isset($_POST['site-set']))
    {
        $sname = $_POST['site-name'];
        $stitle = $_POST['site-title'];
        $iname = $_POST['insti-name'];
        $iadd1 = $_POST['insti-add1'];
        $iadd2 = $_POST['insti-add2'];
        $iadd3 = $_POST['insti-add3'];
        $insemail = $_POST['insti-email'];
        $ic1 = $_POST['insti-contact1'];
        $ic2 = $_POST['insti-contact2'];
        if($sname == '' || $stitle == '' || $iname == '' || $iemail = '' || $ic1 == '')
        {
            $statuscode = 0;
            $status = "Please enter all required fields!";
        }
        else if(!filter_var($insemail, FILTER_VALIDATE_EMAIL))
        {
            $statuscode = 0;
            $status = "Invalid Email!";
        }
        else
        {
            update("settings", "setting_value='$stitle'", json_encode(['setting_name'=>'sitetitle']), '');
            update("settings", "setting_value='$sname'", json_encode(['setting_name'=>'sitename']), '');
            update("settings", "setting_value='$iname'", json_encode(['setting_name'=>'insti_name']), '');
            update("settings", "setting_value='$iadd1'", json_encode(['setting_name'=>'insti_add1']), '');
            update("settings", "setting_value='$iadd2'", json_encode(['setting_name'=>'insti_add2']), '');
            update("settings", "setting_value='$iadd3'", json_encode(['setting_name'=>'insti_add3']), '');
            update("settings", "setting_value='$ic1'", json_encode(['setting_name'=>'insti_contact1']), '');
            update("settings", "setting_value='$ic2'", json_encode(['setting_name'=>'insti_contact2']), '');
            update("settings", "setting_value='$insemail'", json_encode(['setting_name'=>'insti_email']), '');
            $statuscode = 1;
            $status = "Settings updated successfully...";
            $sitetitle = $stitle;
            $sitename = $sname;
            $insti_name = $iname;
            $insti_add1 = $iadd1;
            $insti_add2 = $iadd2;
            $insti_add3 = $iadd3;
            $insti_contact1 = $ic1;
            $insti_contact2 = $ic2;
            $insti_email = $insemail;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename." :: ".$page; ?></title>
        <?php include_once("../../includes/css.php"); ?>
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
        <!-- Toastr -->
        <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    </head>
    <body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="wrapper">
            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="../../dist/img/AdminLTELogo.png" alt="Logo" height="60" width="60">
            </div>

            <!-- Navbar -->
            <?php include_once("../../includes/navbar.php"); ?>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <?php include_once("../../includes/sidebar.php"); ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0"><?php echo $page; ?></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
                                    <li class="breadcrumb-item active"><?php echo $page; ?></li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <?php
                            if(isset($statuscode))
                            {
                                if($statuscode == 0)
                                {
                                    ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <i class="icon fas fa-ban"></i> <?php echo $status; ?>
                                    </div>
                                    <?php
                                }
                                else if($statuscode == 1)
                                {
                                    ?>
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <i class="icon fas fa-check"></i> <?php echo $status; ?>
                                    </div>
                                    <?php
                                }
                                else if($statuscode == 2)
                                {
                                    ?>
                                    <div class="alert alert-warning alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <i class="icon fas fa-exclamation-triangle"></i> <?php echo $status; ?>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <i class="icon fas fa-ban"></i> Something went wrong!
                                    </div>
                                    <?php
                                }
                            }
                        ?>
                        <div class="row">
                            <div class="col-md-3">
                                <!-- Profile Image -->
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle" src="../../dist/img/defaultuser.png" alt="User profile picture">
                                        </div>
                                        <h3 class="profile-username text-center"><?php echo $fullname; ?></h3>
                                        <p class="text-muted text-center"><?php echo $usert; ?></p>
                                        <a href="#" class="btn btn-primary btn-block btn-sm disabled"><b>Change Picture</b></a>
                                        <span><b><span class="text-danger">*Note: </span>This module is under development.</b></span>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#account-set" data-toggle="tab">Account Settings</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#password-set" data-toggle="tab">Change Password</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#site-set" data-toggle="tab">Portal Settings</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                                        </ul>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <!-- /.tab-pane -->
                                            <div class="active tab-pane" id="account-set">
                                                <form class="form-horizontal" method="POST" action="">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="inputFName">First Name: <span class="text-danger">*</span></label>
                                                                <input name="fname" type="text" class="form-control" id="inputFName" placeholder="Enter First Name" value="<?php echo $fname; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="inputMName">Middle Name:</label>
                                                                <input name="mname" type="text" class="form-control" id="inputMName" placeholder="Enter Middle Name" value="<?php echo $mname; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="inputLName">Last Name: <span class="text-danger">*</span></label>
                                                                <input name="lname" type="text" class="form-control" id="inputLName" placeholder="Enter Last Name" value="<?php echo $lname; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="inputUName">Username: <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="inputUName" placeholder="Enter Last Name" value="<?php echo $username; ?>" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="inputEmail">Email: <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="inputEmail" placeholder="Enter Email" value="<?php echo $email; ?>" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="offset-md-8 col-md-4">
                                                            <button name="update" type="submit" class="btn btn-primary btn-block">Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.tab-pane -->
                                            
                                            <!-- /.tab-pane -->
                                            <div class="tab-pane" id="password-set">
                                                <div class="form-group row">
                                                    <label for="old-pass" class="col-sm-3 col-form-label">Old Password: <span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="password" id="old-pass" class="form-control" placeholder="Enter Old Password">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="new-pass" class="col-sm-3 col-form-label">New Password: <span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="password" id="new-pass" class="form-control" placeholder="Enter New Password">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="repeat-pass" class="col-sm-3 col-form-label">Repeat New Password: <span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="password" id="repeat-pass" class="form-control" placeholder="Repeat New Password">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-8 col-sm-4">
                                                        <button id="passchange" type="submit" class="btn btn-primary btn-block">Change Password</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.tab-pane -->

                                            <!-- /.tab-pane -->
                                            <div class="tab-pane" id="site-set">
                                                <form class="form-horizontal" action="" method="post">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="insti-name">Institute Name: <span class="text-danger">*</span></label>
                                                                <input type="text" name="insti-name" id="insti-name" class="form-control" placeholder="Enter Institute Name" value="<?php echo $insti_name; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="site-title">Portal Title: <span class="text-danger">*</span></label>
                                                                <input type="text" name="site-title" id="site-title" class="form-control" placeholder="Enter Site Title" value="<?php echo $sitetitle; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="site-name">Portal Name: <span class="text-danger">*</span></label>
                                                                <input type="text" name="site-name" id="site-name" class="form-control" placeholder="Enter Site Name" value="<?php echo $sitename; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="insti-add1">Institute Address Line 1:</label>
                                                                <input type="text" name="insti-add1" id="insti-add1" class="form-control" placeholder="Enter Institute Address Line 1" value="<?php echo $insti_add1; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="insti-add2">Institute Address Line 2:</label>
                                                                <input type="text" name="insti-add2" id="insti-add2" class="form-control" placeholder="Enter Institute Address Line 2" value="<?php echo $insti_add2; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="insti-add3">Institute Address Line 3:</label>
                                                                <input type="text" name="insti-add3" id="insti-add3" class="form-control" placeholder="Enter Institute Address Line 3" value="<?php echo $insti_add3; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="insti-email">Institute Email: <span class="text-danger">*</span></label>
                                                                <input type="email" name="insti-email" id="insti-email" class="form-control" placeholder="Enter Institute Email" value="<?php echo $insti_email; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="insti-contact1">Institute Primary Contact: <span class="text-danger">*</span></label>
                                                                <input type="text" name="insti-contact1" id="insti-contact1" class="form-control" placeholder="Enter Institute Primary Contact" value="<?php echo $insti_contact1; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="insti-contact2">Institute Secondary Contact:</label>
                                                                <input type="text" name="insti-contact2" id="insti-contact2" class="form-control" placeholder="Enter Institute Secondary Contact" value="<?php echo $insti_contact2; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="offset-md-8 col-md-4">
                                                            <button name="site-set" type="submit" class="btn btn-primary btn-block">Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.tab-pane -->

                                            <!-- /.tab-pane -->
                                            <div class="tab-pane" id="timeline">
                                                <!-- The timeline -->
                                                <div class="timeline timeline-inverse">
                                                    <!-- timeline time label -->
                                                    <div class="time-label">
                                                        <span class="bg-danger"><?php echo date("d M Y", time()); ?></span>
                                                    </div>
                                                    <!-- /.timeline-label -->
                                                    <!-- timeline item -->
                                                    
                                                    <!-- END timeline item -->
                                                    <div>
                                                        <i class="far fa-clock bg-gray"></i>
                                                    </div>
                                                </div>
                                                <span><b><span class="text-danger">*Note: </span>This module is under development.</b></span>
                                            </div>
                                            <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                    </div>
                                    <!-- /.card-body -->
                                    <div id="overlay" class="overlay" style="display: none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php include_once("../../includes/footer.php"); ?>
        </div>
        <!-- ./wrapper -->
        <?php include_once("../../includes/scripts.php"); ?>
        <!-- SweetAlert2 -->
        <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
        <!-- Toastr -->
        <script src="../../plugins/toastr/toastr.min.js"></script>

        <script>
            document.getElementById("passchange").addEventListener("click", passChange);
            function passChange(){
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                oldPass = document.getElementById("old-pass").value;
                newPass = document.getElementById("new-pass").value;
                repeatPass = document.getElementById("repeat-pass").value;
                if(oldPass == '' || newPass == '' || repeatPass == '')
                {
                    toastr.error('Please enter all required fields!');
                }
                else if(newPass !== repeatPass)
                {
                    toastr.error('New password is not matching!');
                }
                else if(newPass.length < 5 || repeatPass.length < 5)
                {
                    toastr.warning('New password must be atleast 5 characters long.');
                }
                else
                {
                    $('#overlay').css('display', 'flex');
                    $.ajax({
                        type: 'POST',
                        url: '../../includes/ajax.php',
                        data: { 'oldpass': oldPass, 'newpass': newPass, 'repeatpass': repeatPass, 'request': 'passchange' },
                        success: function(res){
                            if(res == 0)
                            {
                                Swal.fire('Error!', 'Please enter all required fields!', 'error');
                            }
                            else if(res == 1)
                            {
                                Swal.fire('Error!', 'New password is not matching!', 'error');
                            }
                            else if(res == 2)
                            {
                                Swal.fire('warning!', 'New password must be atleast 5 characters long.', 'warning');
                            }
                            else if(res == 3)
                            {
                                Swal.fire('Error!', 'Invalid old password', 'error');
                            }
                            else if(res == 4)
                            {
                                Swal.fire('Success!', 'Password successfully changed...', 'success');
                                $('#old-pass').val('');
                                $('#new-pass').val('');
                                $('#repeat-pass').val('');
                            }
                            else if(res == 5)
                            {
                                Swal.fire('Error!', 'Something went wrong!', 'error');
                            }
                            else if(res == 6)
                            {
                                Swal.fire('Warning!', 'Old password & new password cannot be same!', 'warning');
                            }
                            else
                            {
                                Swal.fire('Error!', 'Something went wrong!', 'error');
                            }
                            $('#overlay').css('display', 'none');
                        }
                    })
                }
            }
        </script>
    </body>
</html>