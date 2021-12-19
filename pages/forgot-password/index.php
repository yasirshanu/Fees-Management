<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    
    require '../../plugins/PHPMailer/Exception.php';
    require '../../plugins/PHPMailer/PHPMailer.php';
    require '../../plugins/PHPMailer/SMTP.php';
    require_once("../../includes/nonsessionrequire.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> :: Forgot Password</title>
        <?php include_once("../../includes/css.php"); ?>
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="#" class="h1"><?php echo $sitetitle; ?></a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
                    <?php
                        if(isset($_POST['reset']))
                        {
                            $email = $_POST['email'];
                            $rows = getrows('confidential', json_encode(['email' => $email]), '');
                            if($email == '')
                            {
                                ?>
                                <div class="alert alert-danger">
                                    <h5><i class="icon fas fa-ban"></i> Please Enter Email!</h5>
                                </div>
                                <?php
                            }
                            else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                            {
                                ?>
                                <div class="alert alert-danger">
                                    <h5><i class="icon fas fa-ban"></i> Invalid Email!</h5>
                                </div>
                                <?php
                            }
                            else if($rows == 1)
                            {
                                if(getvalue('passreset', 'confidential', json_encode(['email' => $email]), '') == 1)
                                {
                                    $key = getvalue('passresetkey', 'confidential', json_encode(['email' => $email]), '');
                                }
                                else
                                {
                                    $key = md5(rand());
                                }
                                $url = $siteURL."/pages/password-recovery/?email=".$email."&&key=".$key;
                                if(update('confidential', "passreset=1, passresetkey='$key'", json_encode(['email' => $email]), ''))
                                {
                                    $senderset = $email;
                                    $subset = $sitename.": Password reset request";
                                    $bodyset = '<html>
                                        <head>
                                            <style>
                                                .container{
                                                    width: 480px;
                                                    color: #333;
                                                    font-family: Arial, Helvetica, sans-serif;
                                                    border: 4px solid #007bff;
                                                    border-radius: 10px;
                                                    margin: 50px auto;
                                                    overflow: hidden;
                                                }
                                                .header{
                                                    font-size: 12px;
                                                    text-align: center;
                                                    padding: 5px 0;
                                                }
                                                .article{
                                                    width: 450px;
                                                    margin: 0 auto;
                                                }
                                                .col-25{
                                                    width: 25%;
                                                    float: left;
                                                }
                                                .col-75{
                                                    width: 75%;
                                                    float: left;
                                                }
                                                .col-100{
                                                    width: 100%;
                                                    float: left;
                                                }
                                                .button-click{
                                                    background-color: #007bff;
                                                    color: white;
                                                    font-size: 12px;
                                                    font-weight: bolder;
                                                    border: 2px solid #007bff;
                                                    border-radius: 10px;
                                                    margin: 8px auto;
                                                    padding: 6px 20px;
                                                }
                                                .button-click:hover
                                                {
                                                    background-color: #0062cc;
                                                    border-color: #005cbf;
                                                    color: white;
                                                }
                                            </style>
                                        </head>
                                        <body>
                                            <div class="container">
                                                <div class="header">
                                                    <h1><u>Password Reset Link</u></h1>
                                                </div>
                                                <div class="article">
                                                    <div class="col-100">
                                                        <p>This Email is send to you from '.$sitename.'.</p>
                                                        <p>We have received a password reset request from you. To reset your password click here the button given below.</p>
                                                        <a href='.$url.'><input type="submit" class="button-click" value="Reset Password"></a>
                                                        <p>If you have not requested for password reset, please login to your account to cancel the request</p><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </body>
                                    </html>';
                                    if($insti_email == '')
                                    {
                                        ?>
                                        <div class="alert alert-warning">
                                            <h5><i class="icon fas fa-exclamation-triangle"></i> Mailer is not configured. If you are Admin please configure mailer.</h5>
                                        </div>
                                        <?php
                                    }
                                    else if($mailer == 2)
                                    {
                                        if($PHPmailerhost == '' || $PHPmailerusername == '' || $PHPmailerpassword == '' || $PHPmailerport == '')
                                        {
                                            ?>
                                            <div class="alert alert-warning">
                                                <h5><i class="icon fas fa-exclamation-triangle"></i> Mailer is not configured. If you are Admin please configure mailer.</h5>
                                            </div>
                                            <?php
                                        }
                                        else
                                        {
                                            $mail = new PHPMailer(true);
                                            try {
                                                //Server settings
                                                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                   //Enable verbose debug output
                                                $mail->isSMTP();                                            //Send using SMTP
                                                $mail->Host       = $PHPmailerhost;                         //Set the SMTP server to send through
                                                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                                $mail->Username   = $PHPmailerusername;                     //SMTP username
                                                $mail->Password   = $PHPmailerpassword;                     //SMTP password
                                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                                                $mail->Port       = $PHPmailerport;                         //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                                        
                                                //Recipients
                                                $mail->setFrom($insti_email, 'Admin ('.$sitename.')');
                                                $mail->addAddress($senderset);                              //Add a recipient
                                        
                                                //Content
                                                $mail->isHTML(true);                                        //Set email format to HTML
                                                $mail->Subject = $subset;
                                                $mail->Body    = $bodyset;
                                        
                                                $mail->send();
                                                ?>
                                                <div class="alert alert-success">
                                                    <h5><i class="icon fas fa-check"></i> Password reset link has been sent to your Email!</h5>
                                                </div>
                                                <?php
                                            }
                                            catch (Exception $e)
                                            {
                                                ?>
                                                <div class="alert alert-danger">
                                                    <h5><i class="icon fas fa-ban"></i> Mail could not be sent. Mailer Error: '.{$mail->ErrorInfo}.'</h5>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    else if($mailer == 1)
                                    {
                                        $to = $senderset;
                                        $subject = $subset;
                                        $message = $bodyset;
                                        $header = "From:".$insti_email." \r\n";
                                        $header .= "MIME-Version: 1.0\r\n";
                                        $header .= "Content-type: text/html\r\n";
                                        
                                        $retval = mail ($to,$subject,$message,$header);
                                        
                                        if($retval == true)
                                        {
                                            ?>
                                            <div class="alert alert-success">
                                                <h5><i class="icon fas fa-check"></i> Password reset link has been sent to your Email!</h5>
                                            </div>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <div class="alert alert-danger">
                                                <h5><i class="icon fas fa-check"></i> Message could not be sent...!</h5>
                                            </div>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                        <div class="alert alert-warning">
                                            <h5><i class="icon fas fa-exclamation-triangle"></i> Mailer is not configured. If you are Admin please configure mailer.</h5>
                                        </div>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <div class="alert alert-warning">
                                        <h5><i class="icon fas fa-exclamation-triangle"></i> Something went wrong!</h5>
                                    </div>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <div class="alert alert-warning">
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> Account Not Found!</h5>
                                </div>
                                <?php
                            }
                        }
                    ?>
                    <form action="" method="post">
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" name="reset" class="btn btn-primary btn-block">Request new password</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    <p class="mt-3 mb-1">
                        <a href="../login">Login to Account</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->
        <?php include_once("../../includes/scripts.php"); ?>
    </body>
</html>