<?php
    require_once("../../includes/required.php");
    $page = "Fees Status";
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Search for Fees Status</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="course">Course:</label>
                                                    <select id="course" class="form-control">
                                                        <option value="">--Any--</option>
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
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="eyear">Enroll Year:</label>
                                                    <select id="eyear" class="form-control select2bs4" style="width: 100%;">
                                                        <option value="">--Any--</option>
                                                        <?php
                                                            for($y = date('Y', time()); $y >= 2010; $y--)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
                                                                <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="ps">Payment Status:</label>
                                                    <select id="ps" class="form-control">
                                                        <option value="">--All--</option>
                                                        <option value="0">Due</option>
                                                        <option value="1">Paid</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="ft">Fees Type:</label>
                                                    <select id="ft" class="form-control" disabled>
                                                        <option value="">--All--</option>
                                                        <option value="0">Tuition Fee</option>
                                                        <option value="1">Exam Fee</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="cp">Year/Semester:</label>
                                                    <select id="cp" class="form-control" disabled>
                                                        <option value="">--All--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="offset-md-8 col-md-2" style="align-self: end">
                                                <div class="form-group">
                                                    <button id="cleara" class="btn btn-danger btn-block">Clear</button>
                                                </div>
                                            </div>
                                            <div class="col-md-2" style="align-self: end">
                                                <div class="form-group">
                                                    <button id="search" class="btn btn-primary btn-block">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="soverlay" class="overlay" style="display: none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Search Result</h3>
                                    </div>
                                    <div id="cardbody" class="card-body" style="overflow: auto;"></div>
                                    <div id="overlay" class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.content-wrapper -->
            <?php include_once("../../includes/footer.php"); ?>
        </div>
        <!-- ./wrapper -->
        <?php include_once("../../includes/scripts.php"); ?>
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
            document.getElementById("course").addEventListener("change", cp);
            document.getElementById("ps").addEventListener("change", checkf);
            document.getElementById("cleara").addEventListener("click", uclear);
            document.getElementById("search").addEventListener("click", ssearch);

            $(function () {
                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
            })

            function uclear(){
                $('#soverlay').css('display', 'flex');
                $('#overlay').css('display', 'flex');
                $('#course').val('');
                $('#cp').html('<option>--All--</option>');
                $('#eyear').val('');
                $('#eyear').trigger('change');
                $('#ft').val('');
                $('#ps').val('');
                showcontent();
                checkf();
                $('#soverlay').css('display', 'none');
            }

            function cp(){
                var course = $('#course').val();
                $('#soverlay').css('display', 'flex');
                $('#overlay').css('display', 'flex');
                if(cp == '')
                {
                    $('#cp').html('<option>--All--</option>');
                }
                else
                {
                    $.ajax({
                        type: 'POST',
                        url: '../../includes/ajax.php',
                        data: { 'course': course, 'request': 'statusGetCp' },
                        success: function(res){
                            $('#cp').html(res);
                            $('#soverlay').css('display', 'none');
                            $('#overlay').css('display', 'none');
                            checkf();
                        }
                    })
                }
            }

            function checkf(){
                var ps = $('#ps').val();
                var course = $('#course').val();
                if(ps == ''){
                    $('#ft').val('');
                    $('#ft').attr('disabled', 'disabled');
                }
                else{
                    $('#ft').removeAttr('disabled');
                }
                if(ps != '' && course != ''){
                    $('#cp').removeAttr('disabled');
                }
                else{
                    $('#cp').attr('disabled', 'disabled');
                }
            }

            function ssearch(){
                var course = $('#course').val();
                var cp = $('#cp').val();
                var eyear = $('#eyear').val();
                var ft = $('#ft').val();
                var ps = $('#ps').val();
                $('#soverlay').css('display', 'flex');
                $('#overlay').css('display', 'flex');
                $.ajax({
                    type: 'POST',
                    url: '../../includes/ajax.php',
                    data: { 'course': course, 'period': cp, 'eyear': eyear, 'ft': ft, 'ps': ps, 'request': 'searchPStatus' },
                    success: function(res){
                        $('#soverlay').css('display', 'none');
                        $('#cardbody').html(res);
                        $('#overlay').css('display', 'none');
                    }
                })
            }

            function showcontent(){
                $.ajax({
                    type: 'POST',
                    url: '../../includes/ajax.php',
                    data: { 'request': 'pendingFees' },
                    success: function(res){
                        $('#cardbody').html(res);
                        $('#overlay').css('display', 'none');
                    }
                })
            }

            function showModal(sid, sname){
                $('#moverlay').attr('style', 'display: flex !important;');
                $.ajax({
                    type: 'post',
                    url: '../../includes/ajax.php',
                    data: { 'sid': sid, 'request': 'statusModal' },
                    success: function(res){
                        $('#modal-head').html(sname);
                        $('#modal-receipt').attr('href', '../consolided-invoice/?id=' + sid);
                        $('#status-modal').modal('show');
                        $('#modal-content').html(res);
                        $('#moverlay').attr('style', 'display: none !important;');
                    }
                })
            }
        </script>
    </body>
</html>