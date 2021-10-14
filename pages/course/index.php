<?php
    require_once("../../includes/required.php");
    $page = "Course Management";
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
                                        <h3 id="courseau" class="card-title">Add new Course</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cname">Course Name <span class="text-danger">*</span></label>
                                                    <input type="text" id="cname" class="form-control" placeholder="Enter Course Name">
                                                    <input type="hidden" id="cid" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cfee">Total Fees <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                                        </div>
                                                        <input id="cfee" class="form-control" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': 'Enter Course Fee'" placeholder="Enter Course Fee" inputmode="decimal" value="0.00" data-mask>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cp">Course Period <span class="text-danger">*</span></label>
                                                    <select id="cp" class="form-control select2bs4" style="width: 100%;">
                                                        <option selected="selected" value="" disabled>--Select System--</option>
                                                        <option value="1_1">1 Semester</option>
                                                        <option value="0_1">1 Year</option>
                                                        <option value="1_2">2 Semesters</option>
                                                        <option value="0_2">2 Years</option>
                                                        <option value="1_3">3 Semesters</option>
                                                        <option value="0_3">3 Years</option>
                                                        <option value="1_4">4 Semesters</option>
                                                        <option value="0_4">4 Years</option>
                                                        <option value="1_5">5 Semesters</option>
                                                        <option value="0_5">5 Years</option>
                                                        <option value="1_6">6 Semesters</option>
                                                        <option value="1_7">7 Semesters</option>
                                                        <option value="1_8">8 Semesters</option>
                                                        <option value="1_9">9 Semesters</option>
                                                        <option value="1_10">10 Semesters</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cremark">Remark (if any)</label>
                                                    <textarea id="cremark" class="form-control" rows="2" placeholder="Enter Any Remark..."></textarea>
                                                </div>
                                            </div>
                                            <div class="offset-md-2 col-md-2" style="align-self: center;">
                                                <button id="clear" class="btn btn-danger btn-block">Clear</button>
                                            </div>
                                            <div id="update" class="col-md-2" style="display: none; align-self: center;">
                                                <button id="updatebtn" class="btn btn-primary btn-block">Update Course</button>
                                            </div>
                                            <div id="add" class="col-md-2" style="align-self: center;">
                                                <button id="addbtn" class="btn btn-primary btn-block">Add Course</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div id="cOverlay" class="overlay" style="display: none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">All Courses</h3>
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
        <!-- InputMask -->
        <script src="../../plugins/moment/moment.min.js"></script>
        <script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
        <!-- Select2 -->
        <script src="../../plugins/select2/js/select2.full.min.js"></script>
        
        <script>
            $(function(){
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
            document.getElementById("clear").addEventListener("click", clearut);
            document.getElementById("updatebtn").addEventListener("click", updatecourse);
            document.getElementById("addbtn").addEventListener("click", addcourse);
            function clearut(){
                $('#courseau').html('Add new Course');
                $('#cname').val('');
                $('#cid').val('');
                $('#cfee').val(0.00);
                $('#cp').val('');
                $('#cp').trigger('change');
                $('#cremark').val('');
                $('#update').css('display', 'none');
                $('#add').css('display', 'block');
            }
            function del(cid){
                $('#userOverlay').css('display', 'flex');
                $('#overlay').css('display', 'flex');
                $.ajax({
                    type: 'POST',
                    url: '../../includes/ajax.php',
                    data: { 'cid': cid, 'request': 'delCourse' },
                    success: function(res){
                        if(res == 0)
                        {
                            Swal.fire('Error!', 'Invalid Course!', 'error');
                            $('#userOverlay').css('display', 'none');
                            $('#overlay').css('display', 'none');
                        }
                        else if(res == 1)
                        {
                            Swal.fire('Success!', 'Course deleted successfully...', 'success');
                            showcontent();
                            $('#userOverlay').css('display', 'none');
                            $('#overlay').css('display', 'none');
                        }
                        else if(res == 2)
                        {
                            Swal.fire('Error!', 'Something went wrong!', 'error');
                            $('#userOverlay').css('display', 'none');
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
            function setupdate(course_id, course_name, course_fee, cp, course_remark)
            {
                $('#courseau').html('Update Course');
                $('#cid').val(course_id);
                $('#cname').val(course_name);
                $('#cfee').val(course_fee);
                $('#cp').val(cp);
                $('#cp').trigger('change');
                $('#cremark').val(course_remark);
                $('#update').css('display', 'block');
                $('#add').css('display', 'none');
            }
            function updatecourse(){
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                var cid = $('#cid').val();
                var cname = $('#cname').val();
                var cfee = $('#cfee').val();
                var cp = $('#cp').val();
                var cremark = $('#cremark').val();
                if(cname == '')
                {
                    toastr.error('Please enter Course Name!');
                }
                else if(cname.length > 50)
                {
                    toastr.warning('Course name cannot be larger than 50 characters!');
                }
                else if(cfee == '')
                {
                    toastr.error('Please enter Course Fees!');
                }
                else
                {
                    $('#cOverlay').css('display', 'flex');
                    $('#overlay').css('display', 'flex');
                    $.ajax({
                        type: "POST",
                        url: '../../includes/ajax.php',
                        data: { 'cid': cid, 'cfee': cfee, 'course': cname, 'cp': cp, 'cremark': cremark, 'request': 'updateCourse' },
                        success: function(res){
                            if(res == 0)
                            {
                                Swal.fire('Error!', 'Invalid Course!', 'error');
                                clearut();
                                $('#cOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 1)
                            {
                                Swal.fire('Error!', 'Please enter Course name!', 'error');
                                $('#cOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 2)
                            {
                                Swal.fire('Warning!', 'Course name cannot be larger than 50 characters!', 'warning');
                                $('#cOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 3)
                            {
                                Swal.fire('Error!', 'This Course already exist', 'error');
                                $('#cOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 4)
                            {
                                Swal.fire('Error!', 'This Course fee cannot be blank!', 'error');
                                $('#cOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 5)
                            {
                                Swal.fire('Error!', 'This Course fee cannot be greater than 9999999!', 'error');
                                $('#cOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 6)
                            {
                                Swal.fire('Error!', 'This Course period cannot be blank!', 'error');
                                $('#cOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 7)
                            {
                                Swal.fire('Success', 'Course successfully updated...', 'success');
                                clearut();
                                showcontent();
                                $('#cOverlay').css('display', 'none');
                            }
                            else if(res == 8)
                            {
                                Swal.fire('Error!', 'Something went wrong!', 'error');
                                $('#cOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else
                            {
                                Swal.fire('Error!', 'Something went wrong!', 'error');
                                $('#cOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                        }
                    })
                }
            }
            function addcourse(){
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                var cname = $('#cname').val();
                var cfee = $('#cfee').val();
                var cp = $('#cp').val();
                var cremark = $('#cremark').val();
                if(cname == '')
                {
                    toastr.error('Please enter Course Name!');
                }
                else if(cname.length > 50)
                {
                    toastr.warning('Course name cannot be larger than 50 characters!');
                }
                else if(cfee == '')
                {
                    toastr.error('Please enter Course Fees!');
                }
                else if(cp == '')
                {
                    toastr.error('Please enter Course Period!');
                }
                else
                {
                    $('#cOverlay').css('display', 'flex');
                    $('#overlay').css('display', 'flex');
                    $.ajax({
                        type: 'POST',
                        url: '../../includes/ajax.php',
                        data: { 'cname': cname, 'cfee': cfee, 'cremark': cremark, 'cp': cp, 'request': 'addCourse' },
                        success: function(res){
                            if(res == 0)
                            {
                                Swal.fire('Error!', 'Please enter Course Name!', 'error');
                                $('#cOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 1)
                            {
                                Swal.fire('Warning!', 'Course name cannot be larger than 50 characters!', 'warning');
                                $('#cOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 2)
                            {
                                Swal.fire('Error!', 'This Course already exist', 'error');
                                $('#cOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 3)
                            {
                                Swal.fire('Error!', 'Course fee cannot be blank!', 'error');
                                $('#cOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 4)
                            {
                                Swal.fire('Error!', 'Course fee cannot be greater than ₹ 9999999!', 'error');
                                $('#cOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 5)
                            {
                                Swal.fire('Success', 'Course successfully added...', 'success');
                                clearut();
                                showcontent();
                                $('#cOverlay').css('display', 'none');
                            }
                            else if(res == 6)
                            {
                                Swal.fire('Error!', 'Something went wrong', 'error');
                                $('#cOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else
                            {
                                Swal.fire('Error!', 'Something went wrong', 'error');
                                $('#cOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
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
                    data: { 'request': 'showCourses' },
                    success: function(res){
                        $('#cardbody').html(res);
                        $('#overlay').css('display', 'none');
                    }
                })
            }
        </script>
    </body>
</html>