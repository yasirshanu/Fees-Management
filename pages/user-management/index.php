<?php
    require_once("../../includes/required.php");
    $page = "User Type Management";
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
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-warning">
                                            <!-- /.card-body -->
                                            <div class="card-header">
                                                <h3 id="userau" class="card-title">Add new User Type</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="usertype">User Type <span class="text-danger">*</span></label>
                                                    <input type="text" id="usertype" class="form-control" placeholder="Enter User Type">
                                                    <input type="hidden" id="usertype_id" class="form-control" value="">
                                                </div>
                                                <div class="form-group">
                                                    <button id="clear" class="btn btn-danger float-left">Clear</button>
                                                    <button id="update" class="btn btn-primary float-right" style="display: none;">Update User Type</button>
                                                    <button id="add" class="btn btn-primary float-right">Add User Type</button>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div id="userOverlay" class="overlay" style="display: none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">All User Type</h3>
                                            </div>
                                            <div id="cardbody" class="card-body" style="overflow: auto;"></div>
                                            <div id="overlay" class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">New User Type Permissions</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table" id="table1">
                                            <tr>
                                                <th>Setting Name</th>
                                                <th>View</th>
                                                <th>Add</th>
                                                <th>Update</th>
                                                <th>Delete</th>
                                                <th>All</th>
                                            </tr>
                                            <tr>
                                                <td>Basic Settings</td>
                                                <td><input id="basic" type="checkbox"></td>
                                                <td><input id="basic" type="checkbox"></td>
                                                <td><input id="basic" type="checkbox"></td>
                                                <td><input id="basic" type="checkbox"></td>
                                                <td><input id="basic" type="checkbox"></td>
                                            </tr>
                                            <tr>
                                                <td>Mailer Settings</td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                            </tr>
                                            <tr>
                                                <td>User Type</td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                            </tr>
                                            <tr>
                                                <td>User</td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                            </tr>
                                            <tr>
                                                <td>Course</td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                            </tr>
                                            <tr>
                                                <td>Student</td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                            </tr>
                                            <tr>
                                                <td>Fees Status</td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox" disabled></td>
                                                <td><input type="checkbox" disabled></td>
                                                <td><input type="checkbox" disabled></td>
                                                <td><input type="checkbox"></td>
                                            </tr>
                                            <tr>
                                                <td>Advanced Student Search</td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox" disabled></td>
                                                <td><input type="checkbox" disabled></td>
                                                <td><input type="checkbox" disabled></td>
                                                <td><input type="checkbox"></td>
                                            </tr>
                                            <tr>
                                                <td>Invoice</td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                                <td><input type="checkbox"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
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
        
        <script>
            document.getElementById("clear").addEventListener("click", clearut);
            document.getElementById("update").addEventListener("click", updateut);
            document.getElementById("add").addEventListener("click", addusertype);
            function clearut(){
                $('#userau').html('Add new User Type');
                $('#usertype').val('');
                $('#usertype_id').val('');
                $('#update').css('display', 'none');
                $('#add').css('display', 'inline-block');
            }
            function updateut(){
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                var utid = $('#usertype_id').val();
                var ut = $('#usertype').val();
                if(ut == '')
                {
                    toastr.error('Please enter User Type!');
                }
                else if(ut.length > 20)
                {
                    toastr.warning('User Type cannot be larger than 20 characters!');
                }
                else
                {
                    $('#userOverlay').css('display', 'flex');
                    $('#overlay').css('display', 'flex');
                    $.ajax({
                        type: "POST",
                        url: '../../includes/ajax.php',
                        data: { 'usertype': ut, 'usertype_id': utid, 'request': 'updateut' },
                        success: function(res){
                            if(res == 0)
                            {
                                Swal.fire('Error!', 'Invalid User Type!', 'error');
                                clearut();
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 1)
                            {
                                Swal.fire('Error!', 'Please enter User Type!', 'error');
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 2)
                            {
                                Swal.fire('Warning!', 'User Type cannot be larger than 20 characters!', 'warning');
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 3)
                            {
                                Swal.fire('Error!', 'This User Type already exist', 'error');
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 4)
                            {
                                Swal.fire('Success', 'User Type successfully updated...', 'success');
                                clearut();
                                $('#userOverlay').css('display', 'none');
                                showcontent();
                            }
                            else if(res == 5)
                            {
                                Swal.fire('Error!', 'Something went wrong', 'error');
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
            }
            function addusertype(){
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                var usertype = $('#usertype').val();
                if(usertype == '')
                {
                    toastr.error('Please enter User Type!');
                }
                else if(usertype.length > 20)
                {
                    toastr.warning('User Type cannot be larger than 20 characters!');
                }
                else
                {
                    $('#userOverlay').css('display', 'flex');
                    $('#overlay').css('display', 'flex');
                    $.ajax({
                        type: 'POST',
                        url: '../../includes/ajax.php',
                        data: { 'usertype': usertype, 'request': 'addusertype' },
                        success: function(res){
                            if(res == 0)
                            {
                                Swal.fire('Error!', 'Please enter User Type!', 'error');
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 1)
                            {
                                Swal.fire('Warning!', 'User Type cannot be larger than 20 characters!', 'warning');
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 2)
                            {
                                Swal.fire('Error!', 'This User Type already exist', 'error');
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                            }
                            else if(res == 3)
                            {
                                Swal.fire('Success', 'User Type successfully added...', 'success');
                                $('#usertype').val('');
                                $('#userOverlay').css('display', 'none');
                                showcontent();
                            }
                            else if(res == 4)
                            {
                                Swal.fire('Error!', 'Something went wrong', 'error');
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
            }
            function delut(utid){
                $('#userOverlay').css('display', 'flex');
                $('#overlay').css('display', 'flex');
                $.ajax({
                    type: 'POST',
                    url: '../../includes/ajax.php',
                    data: { 'usertype_id': utid, 'request': 'detut' },
                    success: function(res){
                        if(res == 0)
                        {
                            Swal.fire('Error!', 'Invalid User Type!', 'error');
                            $('#userOverlay').css('display', 'none');
                            $('#overlay').css('display', 'none');
                        }
                        else if(res == 1)
                        {
                            Swal.fire('Success!', 'User Type deleted successfully...', 'success');
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
            function showcontent(){
                $.ajax({
                    type: 'POST',
                    url: '../../includes/ajax.php',
                    data: { 'request': 'getUserTypeData' },
                    success: function(res){
                        $('#cardbody').html(res);
                        $('#overlay').css('display', 'none');
                    }
                })
            }
            function setupdate(usertype_id, usertype_name)
            {
                $('#userau').html('Update User Type');
                $('#usertype').val(usertype_name);
                $('#usertype_id').val(usertype_id);
                $('#update').css('display', 'inline-block');
                $('#add').css('display', 'none');
            }
        </script>
    </body>
</html>