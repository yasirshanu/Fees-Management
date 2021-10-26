<?php
    require_once("../../includes/required.php");
    $page = "Advanced Student Search";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename." :: ".$page; ?></title>
        <!-- Select2 -->
        <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
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
                            <div class="col-sm-12">
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
                        <h2 class="text-center display-4"><?php echo $page; ?></h2>
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="course">Enrolled Course:</label>
                                            <select id="course" class="select2" style="width: 100%;">
                                                <option value="" selected>--Select Enrolled Course--</option>
                                                <?php
                                                    $result = getresult('*', 'course', '', 'course_id > 0', '', '', '');
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        ?>
                                                        <option value="<?php echo $row['course_id']; ?>"><?php echo $row['course_name']; ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="enroll">Enrollment Number:</label>
                                            <input type="text" id="enroll" class="form-control" placeholder="Enter Enrollment Number">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="roll">Roll Number:</label>
                                            <input type="text" id="roll" class="form-control" placeholder="Enter Roll Number">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="eyear">Enrolled Year:</label>
                                            <select id="eyear" class="select2" style="width: 100%;">
                                                <option value="" selected>--Select Enrolled Year--</option>
                                                <?php
                                                    for($i = 2010; $i <= date('Y', time()); $i++)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name">Student Name:</label>
                                            <input type="text" id="name" class="form-control" placeholder="Enter Student Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="fname">Father's Name:</label>
                                            <input type="text" id="fname" class="form-control" placeholder="Enter Father's Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="mname">Mother's Name:</label>
                                            <input type="text" id="mname" class="form-control" placeholder="Enter Mother's Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dob">Date of Birth:</label>
                                            <input type="date" id="dob" class="form-control" placeholder="Enter Date of Birth">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="email" id="email" class="form-control" placeholder="Enter Email">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="mob">Contact Number:</label>
                                            <input type="text" id="mob" class="form-control" placeholder="Enter Contact Number">
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="align-self: center;">
                                        <button type="button" id="search" class="btn btn-block btn-primary">Search Students</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" id="searchresult"></div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.content-wrapper -->
            <?php include_once("../../includes/footer.php"); ?>
        </div>
        <!-- ./wrapper -->
        <?php include_once("../../includes/scripts.php"); ?>

        <!-- Select2 -->
        <script src="../../plugins/select2/js/select2.full.min.js"></script>
        <!-- DataTables  & Plugins -->
        <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="../../plugins/jszip/jszip.min.js"></script>
        <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
        <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
        <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
        <script>
            $(function () {
                $('.select2').select2()
            });

            document.getElementById("search").addEventListener("click", search);

            function search(){
                var course = $('#course').val();
                var enroll = $('#enroll').val();
                var roll = $('#roll').val();
                var eyear = $('#eyear').val();
                var name = $('#name').val();
                var fname = $('#fname').val();
                var mname = $('#mname').val();
                var dob = $('#dob').val();
                var email = $('#email').val();
                var mob = $('#mob').val();
                $('#overlay').css('display', 'flex');
                $.ajax({
                    type: 'POST',
                    url: '../../includes/ajax.php',
                    data: { 'course': course, 'enroll': enroll, 'roll': roll, 'eyear': eyear, 'name': name, 'fname': fname, 'mname': mname, 'dob': dob, 'email': email, 'mob': mob, 'request': 'advstusearch' },
                    success: function(res){
                        $('#searchresult').html(res);
                        $('#overlay').css('display', 'none');
                    }
                })
            }

            function showModal(sid, sname, fname, mname, dob, course, eyear, enroll, roll, semail, smob1, smob2, sadd1, sadd2, sadd3, added_by, added_time){
                $('#modal-head').html(sname);
                $('#modal-sname').html(sname);
                $('#modal-fname').html(fname);
                $('#modal-mname').html(mname);
                $('#modal-dob').html(dob);
                $('#modal-course').html(course);
                $('#modal-eyear').html(eyear);
                $('#modal-enroll').html(enroll);
                $('#modal-roll').html(roll);
                $('#modal-email').html(semail);
                $('#modal-mob1').html(smob1);
                $('#modal-mob2').html(smob2);
                $('#modal-address').html(sadd1 + " " + sadd2 + " " + sadd3);
                $('#modal-added_by').html(added_by);
                $('#modal-added_time').html(added_time);
                $('#modal-receipt').attr('href', '../consolided-invoice/?id=' + sid);
                $('#student-modal').modal('show');
            }
        </script>
    </body>
</html>