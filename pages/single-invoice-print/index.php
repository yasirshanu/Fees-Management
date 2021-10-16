<?php
    require_once("../../includes/required.php");
    $page = "Consolided Receipt Print";
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
            $cfee = $row1['course_fee'];
            $ctype = $row1['course_type'];
            $cperiod = $row1['course_period'];
            $eyear = $row1['enroll_year'];
            $enroll = $row1['enroll'];
            $semail = $row1['student_email'];
            $smob1 = $row1['student_mob1'];
            $smob2 = $row1['student_mob2'];
            $saddress = $row1['student_address'];
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
    <body>
        <div class="wrapper">
            <!-- Main content -->
            <section class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <h2 class="page-header">
                            <i class="fas fa-globe"></i> MAT College of Education
                        </h2>
                    </div>
                <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        From
                        <address>
                            <strong>MAT College of Education</strong><br>
                            A.B. Road, Satanwada,<br>
                            Shivpuri (M.P.) PIN - 473551<br>
                            Phone: +91-9039898978<br>
                            Email: matcollege@gmail.com
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        To
                        <address>
                            <strong><?php echo $sname; ?></strong><br>
                            <?php echo $saddress; ?><br>
                            Contact No.: <?php if($smob1 == ''){ echo $smob2; }else{ echo $smob1; } ?><br>
                            Email: <?php echo $semail; ?>
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
                                                        else if($h == 108)
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
                    <!-- /.col -->
                    <div class="offset-md-8 col-md-4">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Total Amount Paid:</th>
                                    <td>₹<?php echo sprintf('%.2f', $tot); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- ./wrapper -->
        <!-- Page specific script -->
        <script>
            window.addEventListener("load", window.print());
        </script>
    </body>
</html>