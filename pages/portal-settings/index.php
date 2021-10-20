<?php
    require_once("../../includes/required.php");
    $page = "Portal Settings";
    if(isset($_POST['site-set']))
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
                            <div class="col-md-12">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Portal Settings</h3>
                                    </div>
                                    <div class="card-body">
                                        <form class="form-horizontal" action="" method="post">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="insti-name">Institute Name: <span class="text-danger">*</span></label>
                                                        <input type="text" name="insti-name" id="insti-name" class="form-control" placeholder="Enter Institute Name" value="<?php echo $insti_name; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="site-title">Portal Title: <span class="text-danger">*</span></label>
                                                        <input type="text" name="site-title" id="site-title" class="form-control" placeholder="Enter Site Title" value="<?php echo $sitetitle; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="site-name">Portal Name: <span class="text-danger">*</span></label>
                                                        <input type="text" name="site-name" id="site-name" class="form-control" placeholder="Enter Site Name" value="<?php echo $sitename; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="insti-add1">Institute Address Line 1:</label>
                                                        <input type="text" name="insti-add1" id="insti-add1" class="form-control" placeholder="Enter Institute Address Line 1" value="<?php echo $insti_add1; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="insti-add2">Institute Address Line 2:</label>
                                                        <input type="text" name="insti-add2" id="insti-add2" class="form-control" placeholder="Enter Institute Address Line 2" value="<?php echo $insti_add2; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="insti-add3">Institute Address Line 3:</label>
                                                        <input type="text" name="insti-add3" id="insti-add3" class="form-control" placeholder="Enter Institute Address Line 3" value="<?php echo $insti_add3; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="insti-email">Institute Email: <span class="text-danger">*</span></label>
                                                        <input type="email" name="insti-email" id="insti-email" class="form-control" placeholder="Enter Institute Email" value="<?php echo $insti_email; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="insti-contact1">Institute Primary Contact: <span class="text-danger">*</span></label>
                                                        <input type="text" name="insti-contact1" id="insti-contact1" class="form-control" placeholder="Enter Institute Primary Contact" value="<?php echo $insti_contact1; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="insti-contact2">Institute Secondary Contact:</label>
                                                        <input type="text" name="insti-contact2" id="insti-contact2" class="form-control" placeholder="Enter Institute Secondary Contact" value="<?php echo $insti_contact2; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="offset-md-9 col-md-3">
                                                    <button name="site-set" type="submit" class="btn btn-primary btn-block">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    </body>
</html>