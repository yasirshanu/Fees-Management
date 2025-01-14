<?php
    require_once("../../includes/required.php");
    $page = "Consolided Receipt Print";
    if(isset($_GET['id']))
    {
        $sid = $_GET['id'];
        if(getrows('student', json_encode(['student_id' => $sid]), '') == 1)
        {
            $result = getresult('*', 'student', json_encode(['student_id' => $sid]), '', '', '', '');
            $row = mysqli_fetch_array($result);
            $sname = $row['student_name'];
            $course = $row['course'];
            $cname = getvalue('course_name', 'course', json_encode(['course_id' => $course]), '');
            $ctype = $row['course_type'];
            $cperiod = $row['course_period'];
            $eyear = $row['enroll_year'];
            $enroll = $row['enroll'];
            $semail = $row['student_email'];
            $smob1 = $row['student_mob1'];
            $smob2 = $row['student_mob2'];
            $sadd1 = $row['student_add1'];
            $sadd2 = $row['student_add2'];
            $sadd3 = $row['student_add3'];
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
                        <b>Consolided Invoice</b><br><br>
                        <b>Course:</b> <?php echo $cname; ?><br>
                        <b>Enrollment No.: </b><?php echo $enroll; ?><br>
                        <b>Enrollment Year: </b><?php echo $eyear; ?><br>
                        <b>No. of <?php if($ctype == 0){ echo "Years"; }else{ echo "Semester"; } ?>:</b> <?php echo $cperiod; ?><br>
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
                                    <th>Invoice #</th>
                                    <th>Invoice Date</th>
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
                                    $result = getresult("*", "invoice_content", "", "student_id='$sid' AND (invoice_id!='' OR invoice_id IS NOT NULL)", "", "", "");
                                    if(mysqli_num_rows($result) > 0)
                                    {
                                        $i = 1;
                                        while($row = mysqli_fetch_array($result))
                                        {
                                            $invid = $row['invoice_id'];
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <?php
                                                        echo getvalue('invoice_no', 'invoice', json_encode(['invoice_id' => $invid]), '');
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        echo date('d M Y', getvalue('invoice_date', 'invoice', json_encode(['invoice_id' => $invid]), ''));
                                                    ?>
                                                </td>
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