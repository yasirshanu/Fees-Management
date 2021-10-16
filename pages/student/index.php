<?php
    require_once("../../includes/required.php");
    $page = "Student Management";
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
        <!-- DataTables -->
        <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    </head>
    <body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" onload="showcontent()">
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-warning">
                                    <!-- /.card-body -->
                                    <div class="card-header">
                                        <h3 id="studentau" class="card-title">Enroll new student</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="sname">Student Name: <span class="text-danger">*</span></label>
                                                    <input type="text" id="sname" class="form-control" placeholder="Enter Student Name">
                                                    <input type="hidden" id="sid" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="fname">Father's Name: <span class="text-danger">*</span></label>
                                                    <input type="text" id="fname" class="form-control" placeholder="Enter Father's Name">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="mname">Mother's Name: <span class="text-danger">*</span></label>
                                                    <input type="text" id="mname" class="form-control" placeholder="Enter Mother's Name">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="dob">Date of Birth: <span class="text-danger">*</span></label>
                                                    <input type="date" id="dob" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="course">Course: <span class="text-danger">*</span> <a href="../course"><i class="fas fa-plus-circle"></i></a></label>
                                                    <select id="course" class="form-control select2bs4" style="width: 100%;">
                                                        <option selected="selected" value="" disabled>--Select Course--</option>
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
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="eyear">Enrollment Year:</label>
                                                    <select id="eyear" class="form-control">
                                                        <option value="" disabled>--Select Enrollment Year--</option>
                                                        <?php
                                                            $j = date('Y', time());
                                                            for($i = 2010; $i <= $j; $i++)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $i; ?>" <?php if($i == $j)echo "selected"; ?>><?php echo $i; ?></option>
                                                                <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="enroll">Enrollment Number:</label>
                                                    <input type="text" id="enroll" class="form-control" placeholder="Enter Enrollment Number">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="roll">Roll Number:</label>
                                                    <input type="number" id="roll" class="form-control" placeholder="Enter Roll Number">
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
                                                    <label for="mob1">Primary Mobile Number:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                                        </div>
                                                        <input type="text" id="mob1" class="form-control" data-inputmask='"mask": "9999999999"' placeholder="Enter Mobile Number" data-mask>
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="mob2">Secondary Mobile Number:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                                        </div>
                                                        <input type="text" id="mob2" class="form-control" data-inputmask='"mask": "9999999999"' placeholder="Enter Mobile Number" data-mask>
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="address">Complete Address:</label>
                                                    <textarea id="address" rows="3" class="form-control" style="resize: none;" placeholder="Enter Complete Address"></textarea>
                                                    <!-- <input type="text" id="address" class="form-control" placeholder="Enter Complete Address"> -->
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="offset-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <button id="clear" class="btn btn-danger btn-block">Clear</button>
                                                </div>
                                            </div>
                                            <div id="update" class="col-md-3" style="display: none;">
                                                <div class="form-group">
                                                    <button id="updatebtn" class="btn btn-primary btn-block">Update User</button>
                                                </div>
                                            </div>
                                            <div id="add" class="col-md-3">
                                                <div class="form-group">
                                                    <button id="addbtn" class="btn btn-primary btn-block">Add User</button>
                                                </div>
                                            </div>
                                        </div>
                                        <span><b><span class="text-danger">*Note: </span>This module is under development.</b></span>
                                    </div>
                                    <!-- /.card-body -->
                                    <div id="studentOverlay" class="overlay" style="display: none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">All Enrolled Students</h3>
                                    </div>
                                    <div id="cardbody" class="card-body" style="overflow: auto;"></div>
                                    <div id="overlay" class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                                </div>
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
        <!-- Select2 -->
        <script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>

        <script>
            $(function () {
                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                //Money Euro
                $('[data-mask]').inputmask()
            })
            document.getElementById("clear").addEventListener("click", clearu);
            document.getElementById("addbtn").addEventListener("click", addstudent);
            document.getElementById("updatebtn").addEventListener("click", update);
            function clearu(){
                $('#studentau').html('Enroll new student');
                $('#sid').val('');
                $('#sname').val('');
                $('#fname').val('');
                $('#mname').val('');
                $('#dob').val('');
                $('#course').removeAttr('disabled');
                $('#course').val('');
                $('#course').trigger('change');
                $('#eyear').val('2021');
                $('#eyear').removeAttr('disabled');
                $('#enroll').val('');
                $('#roll').val('');
                $('#email').val('');
                $('#mob1').val('');
                $('#mob2').val('');
                $('#address').val('');
                $('#update').css('display', 'none');
                $('#add').css('display', 'inline-block');
            }
            function delut(sid){
                $('#studentOverlay').css('display', 'flex');
                $('#overlay').css('display', 'flex');
                $.ajax({
                    type: 'POST',
                    url: '../../includes/ajax.php',
                    data: { 'sid': sid, 'request': 'delStu' },
                    success: function(res){
                        if(res == 0)
                        {
                            Swal.fire('Error!', 'Invalid delete request!', 'error');
                            $('#studentOverlay').css('display', 'none');
                            $('#overlay').css('display', 'none');
                        }
                        else if(res == 1)
                        {
                            Swal.fire('Success!', 'Student deleted successfully...', 'success');
                            showcontent();
                            $('#studentOverlay').css('display', 'none');
                            $('#overlay').css('display', 'none');
                        }
                        else if(res == 2)
                        {
                            Swal.fire('Error!', 'Something went wrong!', 'error');
                            $('#studentOverlay').css('display', 'none');
                            $('#overlay').css('display', 'none');
                        }
                        else
                        {
                            Swal.fire('Error!', 'Something went wrong!', 'error');
                            $('#userOverlay').css('display', 'none');
                            $('#overlay').css('display', 'none');
                        }
                    }
                })
            }
            function setupdate(sid, sname, fname, mname, dob, enroll, roll, email, mob1, mob2, address){
                clearu();
                $('#add').css('display', 'none');
                $('#update').css('display', 'block');
                $('#studentau').html('Edit Student Enrollment');
                $('#sid').val(sid);
                $('#sname').val(sname);
                $('#fname').val(fname);
                $('#mname').val(mname);
                $('#dob').val(dob);
                $('#course').attr('disabled', 'disabled');
                $('#eyear').val('');
                $('#eyear').attr('disabled', 'disabled');
                $('#enroll').val(enroll);
                $('#roll').val(roll);
                $('#email').val(email);
                $('#mob1').val(mob1);
                $('#mob2').val(mob2);
                $('#address').val(address);
            }
            function update(){
                var sid = $('#sid').val();
                var sname = $('#sname').val();
                var fname = $('#fname').val();
                var mname = $('#mname').val();
                var dob = $('#dob').val();
                var enroll = $('#enroll').val();
                var roll = $('#roll').val();
                var email = $('#email').val();
                var mob1 = $('#mob1').val().replace("_", "");
                var mob2 = $('#mob2').val().replace("_", "");
                var address = $('#address').val();
                if(sid != '')
                {
                    $('#studentOverlay').css('display', 'flex');
                    $('#overlay').css('display', 'flex');
                    if(sname == '')
                    {
                        $('#studentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Please enter student name!');
                    }
                    else if(sname.length > 50)
                    {
                        $('#studentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Student name cannot be more than 50 characters!');
                    }
                    else if(fname == '')
                    {
                        $('#studentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error("Please enter Father's name!");
                    }
                    else if(fname.length > 50)
                    {
                        $('#studentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error("Father's name cannot be more than 50 characters!");
                    }
                    else if(mname == '')
                    {
                        $('#studentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error("Please enter Mother's name!");
                    }
                    else if(mname.length > 50)
                    {
                        $('#studentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error("Mother's name cannot be more than 50 characters!");
                    }
                    else if(dob == '')
                    {
                        $('#studentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Please enter Date of Birth!');
                    }
                    else if(enroll.length > 30)
                    {
                        $('#studentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Enrollment number cannot be more than 50 characters!');
                    }
                    else if(roll.length > 30)
                    {
                        $('#studentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Roll number cannot be more than 50 characters!');
                    }
                    else if((email != '') && (email.length < 5))
                    {
                        $('#studentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Email must have atleast 5 characters!');
                    }
                    else if((email != '') && (email.length > 50))
                    {
                        $('#studentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Email must not have more than 50 characters!');
                    }
                    else if((email != '') && (!email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)))
                    {
                        $('#studentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Invaild Email!');
                    }
                    else if((mob1 != '') && (mob1.length != 10))
                    {
                        $('#studentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Invaild Primary Mobile number!');
                    }
                    else if((mob2 != '') && (mob2.length != 10))
                    {
                        $('#studentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Invaild Secondary Mobile number!');
                    }
                    else
                    {
                        $.ajax({
                            type: 'POST',
                            url: '../../includes/ajax.php',
                            data: { 'sid': sid, 'sname': sname,'fname': fname, 'mname': mname, 'dob': dob, 'enroll': enroll, 'roll': roll, 'email':email, 'mob1': mob1, 'mob2': mob2, 'address': address, 'request': 'updateStudent' },
                            success: function(res){
                                if(res == 0)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Invalid Student!', 'error');
                                }
                                else if(res == 1)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Please enter Student name!', 'error');
                                }
                                else if(res == 2)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Student name cannot have more than 50 characters!', 'error');
                                }
                                else if(res == 3)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', "Please enter Father's name!", 'error');
                                }
                                else if(res == 4)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', "Father's name cannot have more than 50 characters!", 'error');
                                }
                                else if(res == 5)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', "Please enter Mother's name!", 'error');
                                }
                                else if(res == 6)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', "Mother's name cannot have more than 50 characters!", 'error');
                                }
                                else if(res == 7)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Invalid Date of Birth!', 'error');
                                }
                                else if(res == 8)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'This Enrollment number already exist!', 'error');
                                }
                                else if(res == 9)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'This Roll number already exist!', 'error');
                                }
                                else if(res == 10)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Email must have atleast 5 characters!', 'error');
                                }
                                else if(res == 11)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Email must not have more than 50 characters!', 'error');
                                }
                                else if(res == 12)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Invalid Email!', 'error');
                                }
                                else if(res == 13)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Invalid Primary Mobile number!', 'error');
                                }
                                else if(res == 14)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Invalid Secondary Mobile number!', 'error');
                                }
                                else if(res == 15)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    clearu();
                                    showcontent();
                                    Swal.fire('success!', 'User updated successfully!', 'success');
                                }
                                else if(res == 16)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Something went wrong!', 'error');
                                }
                                else
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Something went wrong!', 'error');
                                }
                            }
                        })
                    }
                }
                else
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    Swal.fire('Error!', 'Something went wrong!', 'error');
                }
            }
            function addstudent(){
                var sname = $('#sname').val();
                var fname = $('#fname').val();
                var mname = $('#mname').val();
                var dob = $('#dob').val();
                var course = $('#course').val();
                var eyear = $('#eyear').val();
                var enroll = $('#enroll').val();
                var roll = $('#roll').val();
                var email = $('#email').val();
                var mob1 = $('#mob1').val().replace("_", "");
                var mob2 = $('#mob2').val().replace("_", "");
                var address = $('#address').val();
                $('#studentOverlay').css('display', 'flex');
                $('#overlay').css('display', 'flex');
                if(sname == '')
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Please enter student name!');
                }
                else if(sname.length > 50)
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Student name cannot be more than 50 characters!');
                }
                else if(fname == '')
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error("Please enter Father's name!");
                }
                else if(fname.length > 50)
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error("Father's name cannot be more than 50 characters!");
                }
                else if(mname == '')
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error("Please enter Mother's name!");
                }
                else if(mname.length > 50)
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error("Mother's name cannot be more than 50 characters!");
                }
                else if(dob == '')
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Please enter Date of Birth!');
                }
                else if(course == '')
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Please select course!');
                }
                else if(eyear == '' || eyear < 2010)
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Please select Enrollment Year!');
                }
                else if(enroll.length > 30)
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Enrollment number cannot be more than 50 characters!');
                }
                else if(roll.length > 30)
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Roll number cannot be more than 50 characters!');
                }
                else if((email != '') && (email.length < 5))
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Email must have atleast 5 characters!');
                }
                else if((email != '') && (email.length > 50))
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Email must not have more than 50 characters!');
                }
                else if((email != '') && (!email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)))
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Invaild Email!');
                }
                else if((mob1 != '') && (mob1.length != 10))
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Invaild Primary Mobile number!');
                }
                else if((mob2 != '') && (mob2.length != 10))
                {
                    $('#studentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Invaild Secondary Mobile number!');
                }
                else
                {
                    $.ajax({
                        type: 'POST',
                        url: '../../includes/ajax.php',
                        data: { 'sname': sname, 'fname': fname, 'mname': mname, 'dob': dob, 'course': course, 'eyear': eyear, 'enroll': enroll, 'roll': roll, 'email': email, 'mob1': mob1, 'mob2': mob2, 'address': address, 'request': 'addStudent' },
                        success: function(res){
                            if(res == 0)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Please enter Student name!', 'error');
                            }
                            else if(res == 1)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Student name cannot have more than 50 characters!', 'error');
                            }
                            else if(res == 2)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', "Please enter Father's name!", 'error');
                            }
                            else if(res == 3)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', "Father's name cannot have more than 50 characters!", 'error');
                            }
                            else if(res == 4)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', "Please enter Mother's name!", 'error');
                            }
                            else if(res == 5)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', "Mother's Name cannot have more than 50 characters!", 'error');
                            }
                            else if(res == 6)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Invalid Date of Birth!', 'error');
                            }
                            else if(res == 7)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Please select Course!', 'error');
                            }
                            else if(res == 8)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Invalid Course!', 'error');
                            }
                            else if(res == 9 || res == 10 || res == 11)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Invalid Enrollment Year!', 'error');
                            }
                            else if(res == 12)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'This Enrollment number already exist!', 'error');
                            }
                            else if(res == 13)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'This Roll number already exist!', 'error');
                            }
                            else if(res == 14)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Email must have atleast 5 characters!', 'error');
                            }
                            else if(res == 15)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Email must not have more than 50 characters!', 'error');
                            }
                            else if(res == 16)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Invalid Email!', 'error');
                            }
                            else if(res == 17)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Invalid Primary Mobile number!', 'error');
                            }
                            else if(res == 18)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Invalid Secondary Mobile number!', 'error');
                            }
                            else if(res == 19)
                            {
                                showcontent();
                                clearu();
                                $('#studentOverlay').css('display', 'none');
                                Swal.fire('Success!', 'Student enrolled successfully!', 'success');
                            }
                            else if(res == 20)
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Something went wrong!', 'error');
                            }
                            else
                            {
                                $('#studentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Something went wrong!', 'error');
                            }
                        }
                    })
                }
            }
            function showcontent()
            {
                $.ajax({
                    type: 'POST',
                    url: '../../includes/ajax.php',
                    data: { 'request': 'getStudentsData' },
                    success: function(res){
                        $('#cardbody').html(res);
                        $('#overlay').css('display', 'none');
                    }
                })
            }
            function showModal(sid, sname, fname, mname, dob, course, eyear, enroll, roll, email, mob1, mob2, address, added_by, added_time){
                $('#modal-head').html(sname);
                $('#modal-sname').html(sname);
                $('#modal-fname').html(fname);
                $('#modal-mname').html(mname);
                $('#modal-dob').html(dob);
                $('#modal-course').html(course);
                $('#modal-eyear').html(eyear);
                $('#modal-enroll').html(enroll);
                $('#modal-roll').html(roll);
                $('#modal-email').html(email);
                $('#modal-mob1').html(mob1);
                $('#modal-mob2').html(mob2);
                $('#modal-address').html(address);
                $('#modal-added_by').html(added_by);
                $('#modal-added_time').html(added_time);
                $('#modal-receipt').attr('href', '../consolided-invoice/?id=' + sid);
                $('#student-modal').modal('show')
            }
        </script>
    </body>
</html>