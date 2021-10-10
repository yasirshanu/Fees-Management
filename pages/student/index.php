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
                $('#course').val('');
                $('#enroll').val('');
                $('#roll').val('');
                $('#update').css('display', 'none');
                $('#add').css('display', 'inline-block');
            }
            function setupdate(sid, sname, fname, mname, dob, course, enroll, roll){
                clearu();
                $('#add').css('display', 'none');
                $('#update').css('display', 'block');
                $('#studentau').html('Edit Student Enrollment');
                $('#sid').val(sid);
                $('#sname').val(sname);
                $('#fname').val(fname);
                $('#mname').val(mname);
                $('#dob').val(dob);
                $('#course').val(course);
                $('#enroll').val(enroll);
                $('#roll').val(roll);
            }
            function update(){
                var sid = $('#sid').val();
                var sname = $('#sname').val();
                var fname = $('#fname').val();
                var mname = $('#mname').val();
                var dob = $('#dob').val();
                var course = $('#course').val();
                var enroll = $('#enroll').val();
                var roll = $('#roll').val();
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
                    else if(course == '')
                    {
                        $('#studentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Please select course!');
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
                    else
                    {
                        $.ajax({
                            type: 'POST',
                            url: '../../includes/ajax.php',
                            data: { 'sid': sid, 'sname': sname,'fname': fname, 'mname': mname, 'dob': dob, 'course': course, 'enroll': enroll, 'roll': roll, 'request': 'updateStudent' },
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
                                    Swal.fire('Error!', 'Please select Course!', 'error');
                                }
                                else if(res == 9)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Invalid Course!', 'error');
                                }
                                else if(res == 10)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    clearu();
                                    showcontent();
                                    Swal.fire('success!', 'User updated successfully!', 'success');
                                }
                                else if(res == 11)
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Something went wrong!', 'error');
                                }
                                else
                                {
                                    $('#studentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', res, 'error');
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
                var enroll = $('#enroll').val();
                var roll = $('#roll').val();
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
                else
                {
                    $.ajax({
                        type: 'POST',
                        url: '../../includes/ajax.php',
                        data: { 'sname': sname, 'fname': fname, 'mname': mname, 'dob': dob, 'course': course, 'enroll': enroll, 'roll': roll, 'request': 'addStudent' },
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
                            else if(res == 9)
                            {
                                showcontent();
                                clearu();
                                $('#studentOverlay').css('display', 'none');
                                Swal.fire('Success!', 'Student enrolled successfully!', 'success');
                            }
                            else if(res == 10)
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
            function deluser(uid)
            {
                $('#overlay').css('display', 'flex');
                $.ajax({
                    type: 'POST',
                    url: '../../includes/ajax.php',
                    data: { 'userid': uid, 'request': 'delUser' },
                    success: function(res){
                        if(res == 0)
                        {
                            showcontent();
                            Swal.fire('Success!', 'User deleted successfully!', 'success');
                        }
                        else if(res == 1)
                        {
                            $('#overlay').css('display', 'none');
                            Swal.fire('Error!', 'Something went wrong!', 'error');
                        }
                        else if(res == 2)
                        {
                            $('#overlay').css('display', 'none');
                            Swal.fire('Error!', 'Invalid User!', 'error');
                        }
                        else
                        {
                            $('#overlay').css('display', 'none');
                            Swal.fire('Error!', 'Invalid User!', 'error');
                        }
                    }
                })
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
        </script>
    </body>
</html>