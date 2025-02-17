<?php
    require_once("../../includes/required.php");
    $page = "Single Invoice";
    if(isset($_GET['id']))
    {
        $iid = $_GET['id'];
        if(getrows('invoice', json_encode(['invoice_id' => $iid]), '') == 1)
        {
            $invno = getvalue('invoice_no', 'invoice', json_encode(['invoice_id' => $iid]), '');
            $invdate = getvalue('invoice_date', 'invoice', json_encode(['invoice_id' => $iid]), '');
            $result = getresult('*', 'invoice_content', json_encode(['invoice_id' => $iid]), '', '', 'student_id', '');
            $row = mysqli_fetch_array($result);
            $sid = $row['student_id'];
            $result1 = getresult('*', 'student', json_encode(['student_id' => $sid]), '', '', '', '');
            $row1 = mysqli_fetch_array($result1);
            $sname = $row1['student_name'];
            $course = $row1['course'];
            $cname = getvalue('course_name', 'course', json_encode(['course_id' => $course]), '');
            $ctype = $row1['course_type'];
            $cperiod = $row1['course_period'];
            $eyear = $row1['enroll_year'];
            $enroll = $row1['enroll'];
            $semail = $row1['student_email'];
            $smob1 = $row1['student_mob1'];
            $smob2 = $row1['student_mob2'];
            $sadd1 = $row1['student_add1'];
            $sadd2 = $row1['student_add2'];
            $sadd3 = $row1['student_add3'];
        }
        else
        {
            ?>
            <script>
                window.location.href="../student";
            </script>
            <?php
        }
    }
    else
    {
        ?>
        <script>
            window.location.href="../student";
        </script>
        <?php
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
    <body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">
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
                            <div class="col-12">
                                <!-- Main content -->
                                <div class="invoice p-3 mb-3">
                                    <!-- title row -->
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>
                                                <i class="fas fa-globe"></i> MAT College of Education
                                            </h4>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- info row -->
                                    <div class="row invoice-info">
                                        <div class="col-sm-4 invoice-col">
                                            From
                                            <address>
                                                <strong><?php echo $insti_name; ?></strong><br>
                                                <?php if($insti_add1 != ''){ echo $insti_add1."<br>"; } ?>
                                                <?php if($insti_add2 != ''){ echo $insti_add2."<br>"; } ?>
                                                <?php if($insti_add3 != ''){ echo $insti_add3."<br>"; } ?>
                                                <?php if($insti_contact1 != '' || $insti_contact2 != ''){ echo "Contact No.: "; if($insti_contact1 != '' && $insti_contact2 == ''){ echo $insti_contact1."<br>"; }else if($insti_contact1 == '' && $insti_contact2 != ''){ echo $insti_contact2."<br>"; }else if($insti_contact1 != '' && $insti_contact2 != ''){ echo $insti_contact1.", ".$insti_contact2."<br>"; }} ?>
                                                <?php if($insti_email != ''){ echo "Email: ".$insti_email; } ?>
                                            </address>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4 invoice-col">
                                            To
                                            <address>
                                                <strong><?php echo $sname; ?></strong><br>
                                                <?php if($sadd1 != ''){ echo $sadd1."<br>"; } ?>
                                                <?php if($sadd2 != ''){ echo $sadd2."<br>"; } ?>
                                                <?php if($sadd3 != ''){ echo $sadd3."<br>"; } ?>
                                                <?php if($smob1 != '' || $smob2 != ''){ echo "Contact No.: "; if($smob1 != '' && $smob2 == ''){ echo $smob1."<br>"; }else if($smob1 == '' && $smob2 != ''){ echo $smob2."<br>"; }else if($smob1 != '' && $smob2 != ''){ echo $smob1.", ".$smob2."<br>"; }} ?>
                                                <?php if($semail != ''){ echo "Email: ".$semail; } ?>
                                            </address>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4 invoice-col">
                                            <b>Invoice #: </b><?php echo $invno; ?><br>
                                            <b>Invoice date: </b><?php echo date('d M Y', $invdate); ?><br>
                                            <b>Course:</b> <?php echo $cname; ?><br>
                                            <b>Enrollment No.: </b><?php echo $enroll; ?><br>
                                            <b>Enrollment Year: </b><?php echo $eyear; ?><br>
                                            <b>No. of <?php if($ctype == 0){ echo "Years"; }else{ echo "Semester"; } ?>:</b> <?php echo $cperiod; ?><br><br>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->

                                    <!-- Table row -->
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Head</th>
                                                        <th>Description</th>
                                                        <th>Amount</th>
                                                        <th>GST</th>
                                                        <th>Subtotal</th>
                                                        <th>Added By</th>
                                                        <th>Added Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $tot = 0;
                                                        $result = getresult("*", "invoice_content", json_encode(['student_id' => $sid, 'invoice_id' => $iid]), "", "", "", "");
                                                        if(mysqli_num_rows($result) > 0)
                                                        {
                                                            $i = 1;
                                                            while($row = mysqli_fetch_array($result))
                                                            {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td>
                                                                        <?php
                                                                            $h = $row['head'];
                                                                            if($h == 100)
                                                                            {
                                                                                echo "Caution Money";
                                                                            }
                                                                            else if($h == 101)
                                                                            {
                                                                                echo "Development Fee";
                                                                            }
                                                                            else if($h == 102)
                                                                            {
                                                                                echo "ID Card Fee";
                                                                            }
                                                                            else if($h == 103)
                                                                            {
                                                                                echo "Laboratory Fee";
                                                                            }
                                                                            else if($h == 104)
                                                                            {
                                                                                echo "Library Fee";
                                                                            }
                                                                            else if($h == 105)
                                                                            {
                                                                                echo "Training & Placement";
                                                                            }
                                                                            else if($h == 106)
                                                                            {
                                                                                echo "Late Fee";
                                                                            }
                                                                            else if($h == 107)
                                                                            {
                                                                                echo "Fee Concession";
                                                                            }
                                                                            else if($h == 200)
                                                                            {
                                                                                echo "Other";
                                                                            }
                                                                            else
                                                                            {
                                                                                if($ctype == 0)
                                                                                {
                                                                                    $set = '';
                                                                                    for($a = 1; $a <= $cperiod; $a++)
                                                                                    {
                                                                                        if($a == $h)
                                                                                        {
                                                                                            $set = $h;
                                                                                        }
                                                                                    }
                                                                                    if(isset($set) && $set != '')
                                                                                    {
                                                                                        echo "Year ".$set;
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        echo "Unknown";
                                                                                    }
                                                                                }
                                                                                else if($ctype == 1)
                                                                                {
                                                                                    $set = '';
                                                                                    for($a = 1; $a <= $cperiod; $a++)
                                                                                    {
                                                                                        if($a == $h)
                                                                                        {
                                                                                            $set = $h;
                                                                                        }
                                                                                    }
                                                                                    if(isset($set) && $set != '')
                                                                                    {
                                                                                        echo "Semester ".$set;
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        echo "Unknown";
                                                                                    }
                                                                                }
                                                                                else
                                                                                {
                                                                                    echo "Unknown";
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo $row['dsc']; ?></td>
                                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $row['amount']); ?></td>
                                                                    <td style="text-align: right;"><?php echo $row['tax']; ?>%</td>
                                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $row['subt']); ?></td>
                                                                    <td>
                                                                        <?php
                                                                            $first = getvalue('fname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                                                            $middle = getvalue('mname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                                                            $last = getvalue('lname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                                                            $added_by = $first." ".$middle." ".$last;
                                                                            echo $added_by;
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo date('d M Y h:i:s A', $row['added_time']); ?></td>
                                                                </tr>
                                                                <?php
                                                                $tot += $row['subt'];
                                                                $i++;
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->

                                    <div class="row">
                                        <!-- /.col -->
                                        <div class="offset-md-9 col-md-3">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <th>Total Amount Paid:</th>
                                                        <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tot); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->

                                    <!-- this row will not appear when printing -->
                                    <div class="row no-print">
                                        <div class="col-12">
                                            <a href="../single-invoice-print/?id=<?php echo $iid; ?>" target="_blank" class="btn btn-primary float-right"><i class="fas fa-print"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.invoice -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
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