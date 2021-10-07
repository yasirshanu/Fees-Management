<?php
    require_once("../../includes/required.php");
    $page = "User Management";
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
                                        <h3 id="userau" class="card-title">Add new User</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="ufname">First Name <span class="text-danger">*</span></label>
                                                    <input type="text" id="ufname" class="form-control" placeholder="Enter First Name">
                                                    <input type="hidden" id="uid" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="umname">Middle Name</label>
                                                    <input type="text" id="umname" class="form-control" placeholder="Enter Middle Name">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="ulname">Last Name <span class="text-danger">*</span></label>
                                                    <input type="text" id="ulname" class="form-control" placeholder="Enter Last Name">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="usertype">User Type <span class="text-danger">*</span> <a href="../user-management"><i class="fas fa-plus-circle"></i></a></label>
                                                    <select id="usertype" class="form-control select2bs4" style="width: 100%;">
                                                        <option selected="selected" value="" disabled>--Select User Type--</option>
                                                        <?php
                                                            $result = getresult('*', 'usertype', '', 'usertype_id > 0', '', '', '');
                                                            while($row = mysqli_fetch_array($result))
                                                            {
                                                                if($row['usertype_id'] != 1)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $row['usertype_id']; ?>"><?php echo $row['usertype_name']; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="uname">Username <span class="text-danger">*</span><span id="ustatus"></span></label>
                                                    <input type="text" id="uname" class="form-control" placeholder="Enter Username">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="email">Email <span class="text-danger">*</span><span id="mstatus"></span></label>
                                                    <input type="email" id="email" class="form-control" placeholder="Enter Email">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="pass1">Password <span class="text-danger">*</span></label>
                                                    <input type="password" id="pass1" class="form-control" placeholder="Enter Password">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="pass2">Repeat Password <span class="text-danger">*</span></label>
                                                    <input type="password" id="pass2" class="form-control" placeholder="Repeat Password">
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
                                    <div id="userOverlay" class="overlay" style="display: none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">All Users</h3>
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
            document.getElementById("ufname").addEventListener("keyup", validate);
            document.getElementById("umname").addEventListener("keyup", validate);
            document.getElementById("ulname").addEventListener("keyup", validate);
            document.getElementById("usertype").addEventListener("change", validate);
            document.getElementById("uname").addEventListener("keyup", ucheck);
            document.getElementById("email").addEventListener("keyup", emailcheck);
            document.getElementById("pass1").addEventListener("change", validate);
            document.getElementById("pass2").addEventListener("change", validate);
            document.getElementById("clear").addEventListener("click", clearu);
            document.getElementById("addbtn").addEventListener("click", addu);
            document.getElementById("updatebtn").addEventListener("click", updateu);
            function clearu(){
                $('#userau').html('Add new User');
                $('#uid').val('');
                $('#ufname').val('');
                $('#ufname').removeClass('is-valid');
                $('#ufname').removeClass('is-invalid');
                $('#umname').val('');
                $('#umname').removeClass('is-valid');
                $('#umname').removeClass('is-invalid');
                $('#ulname').val('');
                $('#ulname').removeClass('is-valid');
                $('#ulname').removeClass('is-invalid');
                $('#usertype').val('');
                $('#ustatus').html('');
                $('#uname').val('');
                $('#uname').removeClass('is-valid');
                $('#uname').removeClass('is-invalid');
                $('#mstatus').html('');
                $('#email').val('');
                $('#email').removeClass('is-valid');
                $('#email').removeClass('is-invalid');
                $('#pass1').val('');
                $('#pass2').val('');
                $('#update').css('display', 'none');
                $('#add').css('display', 'inline-block');
                $('#pass1').removeAttr('disabled');
                $('#pass2').removeAttr('disabled');
            }
            function validate(){
                if($("#ufname").val() == '')
                {
                    $('#ufname').removeClass("is-valid");
                    $('#ufname').addClass("is-invalid");
                }
                else if($("#ufname").val().length > 15)
                {
                    $('#ufname').removeClass("is-valid");
                    $('#ufname').addClass("is-invalid");
                }
                else
                {
                    $('#ufname').removeClass("is-invalid");
                    $('#ufname').addClass("is-valid");
                }
                if($("#umname").val().length > 15)
                {
                    $('#umname').removeClass("is-valid");
                    $('#umname').addClass("is-invalid");
                }
                else
                {
                    $('#umname').removeClass("is-invalid");
                    $('#umname').addClass("is-valid");
                }
                if($("#ulname").val() == '')
                {
                    $('#ulname').removeClass("is-valid");
                    $('#ulname').addClass("is-invalid");
                }
                else if($("#ulname").val().length > 15)
                {
                    $('#ulname').removeClass("is-valid");
                    $('#ulname').addClass("is-invalid");
                }
                else
                {
                    $('#ulname').removeClass("is-invalid");
                    $('#ulname').addClass("is-valid");
                }
            }
            function ucheck(){
                var uid = $('#uid').val();
                var uname = $('#uname').val();
                $('#ustatus').html('');
                if(uname == '')
                {
                    $('#uname').removeClass("is-valid");
                    $('#uname').addClass("is-invalid");
                    $('#ustatus').html("Enter Username!");
                    $('#ustatus').addClass("text-danger");
                    $('#ustatus').removeClass("text-green");
                }
                else if(uname.length < 5)
                {
                    $('#uname').removeClass("is-valid");
                    $('#uname').addClass("is-invalid");
                    $('#ustatus').html("Must have 5 charaters!");
                    $('#ustatus').addClass("text-danger");
                    $('#ustatus').removeClass("text-green");
                }
                else if(uname.length > 15)
                {
                    $('#uname').removeClass("is-valid");
                    $('#uname').addClass("is-invalid");
                    $('#ustatus').html("Too long!");
                    $('#ustatus').addClass("text-danger");
                    $('#ustatus').removeClass("text-green");
                }
                else
                {
                    $.ajax({
                        type: 'POST',
                        url: '../../includes/ajax.php',
                        data: { 'uid': uid, 'username': uname, 'request': 'unamecheck' },
                        success: function(res){
                            if(res == 0)
                            {
                                $('#uname').removeClass("is-valid");
                                $('#uname').addClass("is-invalid");
                                $('#ustatus').html("Enter Username!");
                                $('#ustatus').addClass("text-danger");
                                $('#ustatus').removeClass("text-green");
                            }
                            else if(res == 1)
                            {
                                $('#uname').removeClass("is-valid");
                                $('#uname').addClass("is-invalid");
                                $('#ustatus').html("Must have 5 charaters!");
                                $('#ustatus').addClass("text-danger");
                                $('#ustatus').removeClass("text-green");
                            }
                            else if(res == 2)
                            {
                                $('#uname').removeClass("is-valid");
                                $('#uname').addClass("is-invalid");
                                $('#ustatus').html("Too long!");
                                $('#ustatus').addClass("text-danger");
                                $('#ustatus').removeClass("text-green");
                            }
                            else if(res == 3)
                            {
                                $('#uname').removeClass("is-valid");
                                $('#uname').addClass("is-invalid");
                                $('#ustatus').html("Unavailable!");
                                $('#ustatus').addClass("text-danger");
                                $('#ustatus').removeClass("text-green");
                            }
                            else if(res == 4)
                            {
                                $('#uname').removeClass("is-invalid");
                                $('#uname').addClass("is-valid");
                                $('#ustatus').html("Available!");
                                $('#ustatus').removeClass("text-danger");
                                $('#ustatus').addClass("text-green");
                            }
                            else if(res == 5)
                            {
                                $('#uname').removeClass("is-invalid");
                                $('#uname').addClass("is-valid");
                                $('#ustatus').html("No Change!");
                                $('#ustatus').removeClass("text-danger");
                                $('#ustatus').addClass("text-green");
                            }
                            else
                            {
                                $('#uname').removeClass("is-valid");
                                $('#uname').addClass("is-invalid");
                                $('#ustatus').html("Something went wrong!");
                                $('#ustatus').addClass("text-danger");
                                $('#ustatus').removeClass("text-green");
                            }
                        }
                    })
                }
            }
            function emailcheck(){
                var m = $('#email').val();
                var uid = $('#uid').val();
                $('#mstatus').html('');
                if(m == '')
                {
                    $('#email').removeClass("is-valid");
                    $('#email').addClass("is-invalid");
                    $('#mstatus').html("Enter Email!");
                    $('#mstatus').addClass("text-danger");
                    $('#mstatus').removeClass("text-green");
                }
                else if(m.length < 5)
                {
                    $('#email').removeClass("is-valid");
                    $('#email').addClass("is-invalid");
                    $('#mstatus').html("Must have 5 charaters!");
                    $('#mstatus').addClass("text-danger");
                    $('#mstatus').removeClass("text-green");
                }
                else if(m.length > 50)
                {
                    $('#email').removeClass("is-valid");
                    $('#email').addClass("is-invalid");
                    $('#mstatus').html("Too long!");
                    $('#mstatus').addClass("text-danger");
                    $('#mstatus').removeClass("text-green");
                }
                else
                {
                    $.ajax({
                        type: 'POST',
                        url: '../../includes/ajax.php',
                        data: { 'uid': uid, 'email': m, 'request': 'emailcheck' },
                        success: function(res){
                            if(res == 0)
                            {
                                $('#email').removeClass("is-valid");
                                $('#email').addClass("is-invalid");
                                $('#mstatus').html("Enter Username!");
                                $('#mstatus').addClass("text-danger");
                                $('#mstatus').removeClass("text-green");
                            }
                            else if(res == 1)
                            {
                                $('#email').removeClass("is-valid");
                                $('#email').addClass("is-invalid");
                                $('#mstatus').html("Must have 5 charaters!");
                                $('#mstatus').addClass("text-danger");
                                $('#mstatus').removeClass("text-green");
                            }
                            else if(res == 2)
                            {
                                $('#email').removeClass("is-valid");
                                $('#email').addClass("is-invalid");
                                $('#mstatus').html("Too long!");
                                $('#mstatus').addClass("text-danger");
                                $('#mstatus').removeClass("text-green");
                            }
                            else if(res == 3)
                            {
                                $('#email').removeClass("is-valid");
                                $('#email').addClass("is-invalid");
                                $('#mstatus').html("Unavailable!");
                                $('#mstatus').addClass("text-danger");
                                $('#mstatus').removeClass("text-green");
                            }
                            else if(res == 4)
                            {
                                $('#email').removeClass("is-valid");
                                $('#email').addClass("is-invalid");
                                $('#mstatus').html("Invalid Email!");
                                $('#mstatus').addClass("text-danger");
                                $('#mstatus').removeClass("text-green");
                            }
                            else if(res == 5)
                            {
                                $('#email').removeClass("is-invalid");
                                $('#email').addClass("is-valid");
                                $('#mstatus').html("Available!");
                                $('#mstatus').removeClass("text-danger");
                                $('#mstatus').addClass("text-green");
                            }
                            else if(res == 6)
                            {
                                $('#email').removeClass("is-invalid");
                                $('#email').addClass("is-valid");
                                $('#mstatus').html("No Change!");
                                $('#mstatus').removeClass("text-danger");
                                $('#mstatus').addClass("text-green");
                            }
                            else
                            {
                                $('#email').removeClass("is-valid");
                                $('#email').addClass("is-invalid");
                                $('#mstatus').html("Something went wrong!");
                                $('#mstatus').addClass("text-danger");
                                $('#mstatus').removeClass("text-green");
                            }
                        }
                    })
                }
            }
            function updateuser(uid, fname, mname, lname, ut, uname, email){
                clearu();
                $('#add').css('display', 'none');
                $('#update').css('display', 'block');
                $('#userau').html('Edit User');
                $('#pass1').attr('disabled', 'disabled');
                $('#pass2').attr('disabled', 'disabled');
                $('#uid').val(uid);
                $('#ufname').val(fname);
                $('#umname').val(mname);
                $('#ulname').val(lname);
                $('#usertype').val(ut);
                $('#uname').val(uname);
                $('#email').val(email);
            }
            function updateu(){
                var uid = $('#uid').val();
                var fname = $('#ufname').val();
                var mname = $('#umname').val();
                var lname = $('#ulname').val();
                var usertype = $('#usertype').val();
                var uname = $('#uname').val();
                var email = $('#email').val();
                if(uid != '')
                {
                    $('#userOverlay').css('display', 'flex');
                    $('#overlay').css('display', 'flex');
                    if(fname == '')
                    {
                        $('#userOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Please enter First Name!');
                    }
                    else if(fname.length > 15)
                    {
                        $('#userOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('First Name cannot be more than 15 characters!');
                    }
                    else if(mname !== '' && mname.length > 15)
                    {
                        $('#userOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Middle Name cannot be more than 15 characters!');
                    }
                    else if(lname == '')
                    {
                        $('#userOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Please enter Last Name!');
                    }
                    else if(lname.length > 15)
                    {
                        $('#userOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Last Name cannot be more than 15 characters!');
                    }
                    else if(usertype == '')
                    {
                        $('#userOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Please select User Type!');
                    }
                    else if(uname == '')
                    {
                        $('#userOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Please enter Username!');
                    }
                    else if(uname.length < 5)
                    {
                        $('#userOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Username must have atleast 5 characters!');
                    }
                    else if(uname.length > 15)
                    {
                        $('#userOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Username must have atmost 15 characters!');
                    }
                    else if(email == '')
                    {
                        $('#userOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Please enter Email!');
                    }
                    else if(email.length < 5)
                    {
                        $('#userOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Email must have atleast 5 characters!');
                    }
                    else if(email.length > 50)
                    {
                        $('#userOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Email must have atmost 50 characters!');
                    }
                    else
                    {
                        $.ajax({
                            type: 'POST',
                            url: '../../includes/ajax.php',
                            data: { 'uid': uid, 'fname': fname, 'mname': mname, 'lname': lname, 'usertype': usertype, 'username': uname, 'email': email, 'request': 'updateUser' },
                            success: function(res){
                                if(res == 0)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Invalid User Type!', 'error');
                                }
                                else if(res == 1)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Please enter First Name!', 'error');
                                }
                                else if(res == 2)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'First Name cannot have more than 15 characters!', 'error');
                                }
                                else if(res == 3)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Middle Name cannot have more than 15 characters!', 'error');
                                }
                                else if(res == 4)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Please enter Last Name!', 'error');
                                }
                                else if(res == 5)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Last Name cannot have more than 15 characters!', 'error');
                                }
                                else if(res == 6)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Invalid User Type!', 'error');
                                }
                                else if(res == 7)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Invalid User Type!', 'error');
                                }
                                else if(res == 8)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Please enter Username!', 'error');
                                }
                                else if(res == 9)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Username must have atleast 5 characters!', 'error');
                                }
                                else if(res == 10)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Username must have atmost 15 characters!', 'error');
                                }
                                else if(res == 11)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Username is not available!', 'error');
                                }
                                else if(res == 12)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Please enter Email!', 'error');
                                }
                                else if(res == 13)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Email must have atleast 5 characters!', 'error');
                                }
                                else if(res == 14)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Email must have atmost 50 characters!', 'error');
                                }
                                else if(res == 15)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Email is not available!', 'error');
                                }
                                else if(res == 16)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    clearu();
                                    showcontent();
                                    Swal.fire('success!', 'User updated successfully!', 'success');
                                }
                                else if(res == 17)
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Something went wrong!', 'error');
                                }
                                else
                                {
                                    $('#userOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Something went wrong!', 'error');
                                }
                            }
                        })
                    }
                }
                else
                {
                    $('#userOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    Swal.fire('Error!', 'Something went wrong!', 'error');
                }
            }
            function addu(){
                var fname = $('#ufname').val();
                var mname = $('#umname').val();
                var lname = $('#ulname').val();
                var usertype = $('#usertype').val();
                var uname = $('#uname').val();
                var email = $('#email').val();
                var pass1 = $('#pass1').val();
                var pass2 = $('#pass2').val();
                $('#userOverlay').css('display', 'flex');
                $('#overlay').css('display', 'flex');
                if(fname == '')
                {
                    $('#userOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Please enter First Name!');
                }
                else if(fname.length > 15)
                {
                    $('#userOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('First Name cannot be more than 15 characters!');
                }
                else if(mname !== '' && mname.length > 15)
                {
                    $('#userOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Middle Name cannot be more than 15 characters!');
                }
                else if(lname == '')
                {
                    $('#userOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Please enter Last Name!');
                }
                else if(lname.length > 15)
                {
                    $('#userOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Last Name cannot be more than 15 characters!');
                }
                else if(usertype == '')
                {
                    $('#userOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Please select User Type!');
                }
                else if(uname == '')
                {
                    $('#userOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Please enter Username!');
                }
                else if(uname.length < 5)
                {
                    $('#userOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Username must have atleast 5 characters!');
                }
                else if(uname.length > 15)
                {
                    $('#userOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Username must have atmost 15 characters!');
                }
                else if(email == '')
                {
                    $('#userOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Please enter Email!');
                }
                else if(email.length < 5)
                {
                    $('#userOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Email must have atleast 5 characters!');
                }
                else if(email.length > 50)
                {
                    $('#userOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Email must have atmost 50 characters!');
                }
                else if(pass1 !== pass2)
                {
                    $('#userOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Passwords are not same!');
                }
                else
                {
                    $.ajax({
                        type: 'POST',
                        url: '../../includes/ajax.php',
                        data: { 'fname': fname, 'mname': mname, 'lname': lname, 'usertype': usertype, 'username': uname, 'email': email, 'pass1': pass1, 'pass2': pass2, 'request': 'addUser' },
                        success: function(res){
                            if(res == 0)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Please enter First Name!', 'error');
                            }
                            else if(res == 1)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'First Name cannot have more than 15 characters!', 'error');
                            }
                            else if(res == 2)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Middle Name cannot have more than 15 characters!', 'error');
                            }
                            else if(res == 3)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Please enter Last Name!', 'error');
                            }
                            else if(res == 4)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Last Name cannot have more than 15 characters!', 'error');
                            }
                            else if(res == 5)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Invalid User Type!', 'error');
                            }
                            else if(res == 6)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Invalid User Type!', 'error');
                            }
                            else if(res == 7)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Please enter Username!', 'error');
                            }
                            else if(res == 8)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Username must have atleast 5 characters!', 'error');
                            }
                            else if(res == 9)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Username must have atmost 15 characters!', 'error');
                            }
                            else if(res == 10)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Username is not available!', 'error');
                            }
                            else if(res == 11)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Please enter Email!', 'error');
                            }
                            else if(res == 12)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Email must have atleast 5 characters!', 'error');
                            }
                            else if(res == 13)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Email must have atmost 50 characters!', 'error');
                            }
                            else if(res == 14)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Email is not available!', 'error');
                            }
                            else if(res == 15)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Passwords are not matching!', 'error');
                            }
                            else if(res == 16)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Passwords must have atleast 5 characters!', 'error');
                            }
                            else if(res == 17)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Passwords must have atmost 25 characters!', 'error');
                            }
                            else if(res == 18)
                            {
                                showcontent();
                                clearu();
                                $('#userOverlay').css('display', 'none');
                                Swal.fire('Success!', 'User added successfully!', 'success');
                            }
                            else if(res == 19)
                            {
                                $('#userOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Something went wrong!', 'error');
                            }
                            else
                            {
                                $('#userOverlay').css('display', 'none');
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
                    data: { 'request': 'getUsersData' },
                    success: function(res){
                        $('#cardbody').html(res);
                        $('#overlay').css('display', 'none');
                    }
                })
            }
        </script>
    </body>
</html>