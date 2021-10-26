<?php
    require_once("../../includes/required.php");
    $page = "Add Invoice";
    if(isset($_GET['id']))
    {
        $sid = $_GET['id'];
        if(getrows('student', json_encode(['student_id' => $sid]), '') == 1)
        {
            $result = getresult('*', 'student', json_encode(['student_id' => $sid]), '', '', '', '');
            $row = mysqli_fetch_array($result);
            $cfee = $row['course_fee'];
            $ctype = $row['course_type'];
            $cperiod = $row['course_period'];
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
                                        <h3 id="invoiceau" class="card-title">Add Payment Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="ihead">Payment Head: <span class="text-danger">*</span></label>
                                                    <select id="ihead" class="form-control">
                                                        <option value="" selected disabled>--Select Payment Head--</option>
                                                        <?php
                                                            $j = 1;
                                                            for($i = 1; $i <= $cperiod; $i++)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $j; ?>"><?php if($ctype == 0){ echo "Year "; }else{ echo "Semester "; }echo $i; ?></option>
                                                                <?php
                                                                $j++;
                                                            }
                                                        ?>
                                                        <option value="100">Caution Money</option>
                                                        <option value="101">Development Fee</option>
                                                        <option value="102">ID Card Fee</option>
                                                        <option value="103">Laboratory Fee</option>
                                                        <option value="104">Library Fee</option>
                                                        <option value="105">Training & Placement</option>
                                                        <option value="106">Late Fee</option>
                                                        <option value="107">Fee Concession</option>
                                                        <option value="108">Other</option>
                                                    </select>
                                                    <input type="hidden" id="icid" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="idesc">Description: <span class="text-danger">*</span></label>
                                                    <select id="idesc" class="form-control" disabled>
                                                        <option value="" selected disabled>--Select Description--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="amount">Amount: <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                                        </div>
                                                        <input id="amount" class="form-control" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': 'Enter Amount'" placeholder="Enter Amount" inputmode="decimal" value="0.00" data-mask>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="itax">GST Rate: <span class="text-danger">*</span></label>
                                                    <select id="itax" class="form-control">
                                                        <option value="" disabled>--Select GST Rate--</option>
                                                        <option value="0" selected>Nil</option>
                                                        <option value="5">5%</option>
                                                        <option value="12">12%</option>
                                                        <option value="18">18%</option>
                                                        <option value="28">28%</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="etotal">Subtotal Amount:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                                        </div>
                                                        <input id="etotal" class="form-control" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': 'Subtotal Amount'" placeholder="Subtotal Amount" inputmode="decimal" value="0.00" data-mask disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="remark">Remark:</label>
                                                    <textarea id="remark" rows="3" class="form-control" style="resize: none;" placeholder="Enter Payment Remark"></textarea>
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
                                                    <button id="updatebtn" class="btn btn-primary btn-block">Update Payment</button>
                                                </div>
                                            </div>
                                            <div id="add" class="col-md-3">
                                                <div class="form-group">
                                                    <button id="addbtn" class="btn btn-primary btn-block">Add Payment</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div id="paymentOverlay" class="overlay" style="display: none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Generate Invoice</h3>
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
                //Money Rupee
                $('[data-mask]').inputmask()
            })
            document.getElementById("ihead").addEventListener("change", ihead);
            document.getElementById("amount").addEventListener("keyup", subt);
            document.getElementById("itax").addEventListener("change", subt);
            document.getElementById("idesc").addEventListener("change", amo);
            document.getElementById("clear").addEventListener("click", clearu);
            document.getElementById("addbtn").addEventListener("click", addpay);
            document.getElementById("updatebtn").addEventListener("click", update);
            function clearu(){
                $('#invoiceau').html('Add Payment Details');
                $('#icid').val('');
                $('#ino').val('');
                $('#idesc').html('<option value="" selected disabled>--Select Description--</option>');
                $('#ihead').val('');
                $('#idesc').attr('disabled', 'disabled');
                $('#amount').removeAttr('disabled');
                $('#amount').val('0.00');
                $('#itax').val('0');
                $('#etotal').val('0.00');
                $('#remark').val('');
                $('#update').css('display', 'none');
                $('#add').css('display', 'inline-block');
            }
            function addin(){
                var idate = $('#idate').val();
                $('#paymentOverlay').css('display', 'flex');
                $('#overlay').css('display', 'flex');
                if(idate == ''){
                    $('#paymentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Please enter Invoice Date!');
                }
                else{
                    $.ajax({
                        type: 'POST',
                        url: '../../includes/ajax.php',
                        data: { 'sid': <?php echo $sid; ?>, 'idate': idate, 'request': 'addIn' },
                        success: function(res){
                            if(res == 0)
                            {
                                $('#paymentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Invalid Invoice date!', 'error');
                            }
                            else if(res == 1)
                            {
                                clearu();
                                showcontent();
                                $('#paymentOverlay').css('display', 'none');
                                Swal.fire('success!', 'Invoice added successfully!', 'success');
                            }
                            else if(res == 2)
                            {
                                $('#paymentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Invoice content is not updated!', 'error');
                            }
                            else if(res == 3)
                            {
                                $('#paymentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Invoice generated but invoice content is not updated!', 'error');
                            }
                            else if(res == 4)
                            {
                                $('#paymentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Invoice not properly generated!', 'error');
                            }
                            else if(res == 5)
                            {
                                $('#paymentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Something went wrong!', 'error');
                            }
                            else
                            {
                                $('#paymentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Something went wrong!', 'error');
                            }
                        }
                    })
                }
            }
            function subt(){
                var amount = parseFloat($('#amount').val());
                var itax = parseFloat($('#itax').val());
                if((amount != '' || amount == 0) && (itax != '' || itax == 0))
                {
                    if(itax == 0)
                    {
                        var subt = amount.toFixed(2);
                    }
                    else
                    {
                        var subt = (((amount * itax)/100) + amount).toFixed(2);
                    }
                    $('#etotal').val(subt);
                }
            }
            function amo(){
                var cfee = <?php echo $cfee; ?>;
                var cp = <?php echo $cperiod; ?>;
                var syfee = (cfee/cp).toFixed(2);
                var idesc = $('#idesc').val();
                if(idesc == 'Tuition Fee'){
                    $('#amount').val(syfee);
                    $('#amount').attr('disabled', 'disabled');
                }
                else{
                    $('#amount').val('0.00');
                    $('#amount').removeAttr('disabled');
                }
                subt();
            }
            function ihead(){
                var ihead = $('#ihead').val();
                if(ihead == '')
                {
                    $('#idesc').html('<option value="" selected disabled>--Select Description--</option>');
                    $('#ihead').val('');
                    $('#idesc').attr('disabled', 'disabled');
                    amo();
                }
                else
                {
                    var sid = <?php echo $sid; ?>;
                    $.ajax({
                        type: 'POST',
                        url: '../../includes/ajax.php',
                        data: { 'ihead': ihead, 'sid': sid, 'request': 'headStatus' },
                        success: function(res){
                            if(res == 0){
                                $('#idesc').html('<option value="" selected disabled>--Select Description--</option>');
                                $('#ihead').val('');
                                $('#idesc').attr('disabled', 'disabled');
                            }
                            else if(res == 1){
                                $('#idesc').html('<option value="" disabled>--Select Description--</option><option value="NA" selected>NA</option>');
                                $('#idesc').attr('disabled', 'disabled');
                            }
                            else if(res == 2){
                                $('#idesc').html('<option value="" selected disabled>--Select Description--</option><option value="Tuition Fee">Tuition Fee</option><option value="Exam Fee (Regular)">Exam Fee (Regular)</option><option value="Exam Fee (Backlog)">Exam Fee (Backlog)</option>');
                                $('#idesc').removeAttr('disabled');
                            }
                            else if(res == 3){
                                $('#idesc').html('<option value="" selected disabled>--Select Description--</option>');
                                $('#idesc').attr('disabled', 'disabled');
                            }
                            else if(res == 4){
                                $('#idesc').html('<option value="" selected disabled>--Select Description--</option>');
                                $('#idesc').attr('disabled', 'disabled');
                            }
                            amo();
                        }
                    })
                }
            }
            function setupdate(icid, ihead, idesc, amount, itax, subt, remark, astatus){
                clearu();
                $('#add').css('display', 'none');
                $('#update').css('display', 'block');
                $('#invoiceau').html('Edit Payment Details');
                $('#icid').val(icid);
                $('#ihead').val(ihead);
                $('#idesc').html("<option value='' disabled>--Select Description--</option><option value='"+ idesc +"' selected>"+ idesc +"</option>");
                $('#idesc').attr('disabled', 'disabled');
                $('#amount').val(amount);
                $('#itax').val(itax);
                $('#etotal').val(subt);
                $('#remark').val(remark);
                if(astatus == 1)
                {
                    $('#amount').attr('disabled', 'disabled');
                }
            }
            function update(){
                var icid = $('#icid').val();
                var ihead = $('#ihead').val();
                var idesc = $('#idesc').val();
                var amount = $('#amount').val();
                var itax = $('#itax').val();
                var remark = $('#remark').val();
                if(icid != '')
                {
                    $('#paymentOverlay').css('display', 'flex');
                    $('#overlay').css('display', 'flex');
                    if(ihead == '' || ihead == null)
                    {
                        $('#paymentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Please select payemnt head!');
                    }
                    else if(idesc == '' || idesc == null)
                    {
                        $('#paymentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error("Please select description!");
                    }
                    else if(amount == null)
                    {
                        $('#paymentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error("Please enter payment amount!");
                    }
                    else if(itax == null)
                    {
                        $('#paymentOverlay').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        toastr.error('Please select GST rate!');
                    }
                    else
                    {
                        $.ajax({
                            type: 'POST',
                            url: '../../includes/ajax.php',
                            data: { 'sid': <?php echo $sid; ?>, 'icid': icid, 'ihead': ihead,'idesc': idesc, 'amount': amount, 'itax': itax, 'remark': remark, 'request': 'updatePayment' },
                            success: function(res){
                                if(res == 0 || res == 1)
                                {
                                    $('#paymentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Invalid update request!', 'error');
                                }
                                else if(res == 2)
                                {
                                    $('#paymentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Please select payment head!', 'error');
                                }
                                else if(res == 3)
                                {
                                    $('#paymentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Please select payment description!', 'error');
                                }
                                else if(res == 4)
                                {
                                    $('#paymentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'This payment head already added!', 'error');
                                }
                                else if(res == 5)
                                {
                                    $('#paymentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Please enter amount!', 'error');
                                }
                                else if(res == 6)
                                {
                                    $('#paymentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Please enter GST rate!', 'error');
                                }
                                else if(res == 7)
                                {
                                    showcontent();
                                    clearu();
                                    $('#paymentOverlay').css('display', 'none');
                                    Swal.fire('success!', 'Payment updated successfully!', 'success');
                                }
                                else if(res == 8)
                                {
                                    $('#paymentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Something went wrong!', 'error');
                                }
                                else
                                {
                                    $('#paymentOverlay').css('display', 'none');
                                    $('#overlay').css('display', 'none');
                                    Swal.fire('Error!', 'Something went wrong!', 'error');
                                }
                            }
                        })
                    }
                }
                else
                {
                    $('#paymentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    Swal.fire('Error!', 'Something went wrong!', 'error');
                }
            }
            function addpay(){
                var ihead = $('#ihead').val();
                var idesc = $('#idesc').val();
                var amount = parseFloat($('#amount').val());
                var itax = parseFloat($('#itax').val());
                var remark = $('#remark').val();
                $('#paymentOverlay').css('display', 'flex');
                $('#overlay').css('display', 'flex');
                if(ihead == '' || ihead == null)
                {
                    $('#paymentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Please select payemnt head!');
                }
                else if(idesc == '' || idesc == null)
                {
                    $('#paymentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error("Please select description!");
                }
                else if(amount == null)
                {
                    $('#paymentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error("Please enter payment amount!");
                }
                else if(itax == null)
                {
                    $('#paymentOverlay').css('display', 'none');
                    $('#overlay').css('display', 'none');
                    toastr.error('Please select GST rate!');
                }
                else
                {
                    $.ajax({
                        type: 'POST',
                        url: '../../includes/ajax.php',
                        data: { 'sid': <?php echo $sid; ?>, 'ihead': ihead, 'idesc': idesc, 'amount': amount, 'itax': itax, 'remark': remark, 'request': 'addPayment' },
                        success: function(res){
                            if(res == 0 || res == 1)
                            {
                                $('#paymentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Invalid Student ID!', 'error');
                            }
                            else if(res == 2)
                            {
                                $('#paymentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Please select payment head!', 'error');
                            }
                            else if(res == 3)
                            {
                                $('#paymentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Please select payment description!', 'error');
                            }
                            else if(res == 4)
                            {
                                $('#paymentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'This payment head already added!', 'error');
                            }
                            else if(res == 5)
                            {
                                $('#paymentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Please enter amount!', 'error');
                            }
                            else if(res == 6)
                            {
                                $('#paymentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Please enter GST rate!', 'error');
                            }
                            else if(res == 7)
                            {
                                showcontent();
                                clearu();
                                $('#paymentOverlay').css('display', 'none');
                                Swal.fire('success!', 'Payment added successfully!', 'success');
                            }
                            else if(res == 8)
                            {
                                $('#paymentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Something went wrong!', 'error');
                            }
                            else
                            {
                                $('#paymentOverlay').css('display', 'none');
                                $('#overlay').css('display', 'none');
                                Swal.fire('Error!', 'Something went wrong!', 'error');
                            }
                        }
                    })
                }
            }
            function delut(icid){
                $('#paymentOverlay').css('display', 'flex');
                $('#overlay').css('display', 'flex');
                $.ajax({
                    type: 'POST',
                    url: '../../includes/ajax.php',
                    data: { 'icid': icid, 'request': 'delPay' },
                    success: function(res){
                        if(res == 0)
                        {
                            Swal.fire('Error!', 'Invalid delete request!', 'error');
                            $('#paymentOverlay').css('display', 'none');
                            $('#overlay').css('display', 'none');
                        }
                        else if(res == 1)
                        {
                            Swal.fire('Success!', 'Payment deleted successfully...', 'success');
                            showcontent();
                            $('#paymentOverlay').css('display', 'none');
                            $('#overlay').css('display', 'none');
                        }
                        else if(res == 2)
                        {
                            Swal.fire('Error!', 'Something went wrong!', 'error');
                            $('#paymentOverlay').css('display', 'none');
                            $('#overlay').css('display', 'none');
                        }
                        else
                        {
                            Swal.fire('Error!', 'Something went wrong!', 'error');
                            $('#paymentOverlay').css('display', 'none');
                            $('#overlay').css('display', 'none');
                        }
                    }
                })
            }
            function showcontent()
            {
                $.ajax({
                    type: 'POST',
                    url: '../../includes/ajax.php',
                    data: { 'sid': <?php echo $sid; ?>, 'request': 'getPaymentDetails' },
                    success: function(res){
                        $('#cardbody').html(res);
                        $('#overlay').css('display', 'none');
                    }
                })
            }
            function showModal(remark){
                $('#modal-remark').html(remark);
                $('#student-modal').modal('show')
            }
        </script>
    </body>
</html>