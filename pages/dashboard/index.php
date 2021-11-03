<?php
    require_once("../../includes/required.php");
    $page = "Dashboard";
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
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3><?php echo getrows('course', '', 'course_id > 0'); ?></h3>
                                        <p>Available Courses</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <a href="../course" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3><?php echo getrows('student', '', 'student_id > 0'); ?></h3>
                                        <p>Enrolled Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <a href="../student" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3><?php echo getrows('confidential', '', 'user_id > 1'); ?></h3>
                                        <p>Number of Users</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../user" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo getrows('usertype', '', 'usertype_id > 1'); ?></h3>
                                        <p>User Types</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <a href="../user-management" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3>
                                            <?php
                                                $amount = 0;
                                                $result = getresult("*", "invoice_content", json_encode(['dsc' => 'Tuition Fee']), "", "", "", "");
                                                while($row = mysqli_fetch_array($result))
                                                {
                                                    $amount += $row['subt'];
                                                }
                                                echo "₹".number_format($amount);
                                            ?>
                                        </h3>
                                        <p>Total Tuition Fees Collected</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-rupee-sign"></i>
                                    </div>
                                    <a href="../invoices" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>
                                            <?php
                                                $pending = 0;
                                                $result = getresult('*', 'student', '', 'student_id > 0', '', '', '');
                                                while($row = mysqli_fetch_array($result))
                                                {
                                                    $sid = $row['student_id'];
                                                    $c_fee = $row['course_tuition_fee'];
                                                    $amount = 0;
                                                    $result1 = getresult('*', 'invoice_content', json_encode(['student_id' => $sid, 'dsc' => 'Tuition Fee']), '', '', '', '');
                                                    while($row1 = mysqli_fetch_array($result1))
                                                    {
                                                        $amount += $row1['amount'];
                                                    }
                                                    $bal = $c_fee - $amount;
                                                    $pending += $bal;
                                                }
                                                echo "₹".number_format($pending);
                                            ?>
                                        </h3>
                                        <p>Pending Tuition Fees</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-rupee-sign"></i>
                                    </div>
                                    <a href="../invoices" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3>
                                            <?php
                                                $amount = 0;
                                                $result = getresult("*", "invoice_content", json_encode(['dsc' => 'Exam Fee (Regular)']), "", "", "", "");
                                                while($row = mysqli_fetch_array($result))
                                                {
                                                    $amount += $row['subt'];
                                                }
                                                echo "₹".number_format($amount);
                                            ?>
                                        </h3>
                                        <p>Total Exam Fees Collected</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-rupee-sign"></i>
                                    </div>
                                    <a href="../invoices" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>
                                            <?php
                                                $pending = 0;
                                                $result = getresult('*', 'student', '', 'student_id > 0', '', '', '');
                                                while($row = mysqli_fetch_array($result))
                                                {
                                                    $sid = $row['student_id'];
                                                    $c_fee = $row['course_exam_fee'];
                                                    $amount = 0;
                                                    $result1 = getresult('*', 'invoice_content', json_encode(['student_id' => $sid, 'dsc' => 'Exam Fee (Regular)']), '', '', '', '');
                                                    while($row1 = mysqli_fetch_array($result1))
                                                    {
                                                        $amount += $row1['amount'];
                                                    }
                                                    $bal = $c_fee - $amount;
                                                    $pending += $bal;
                                                }
                                                echo "₹".number_format($pending);
                                            ?>
                                        </h3>
                                        <p>Pending Exam Fees</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-rupee-sign"></i>
                                    </div>
                                    <a href="../invoices" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3>
                                            <?php
                                                $amount = 0;
                                                $result = getresult("*", "invoice_content", "", "invoice_content_id > 0", "", "", "");
                                                while($row = mysqli_fetch_array($result))
                                                {
                                                    $amount += $row['subt'];
                                                }
                                                echo "₹".number_format($amount);
                                            ?>
                                        </h3>
                                        <p>Total Fees Collected</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-rupee-sign"></i>
                                    </div>
                                    <a href="../invoices" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
