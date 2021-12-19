<?php
    // use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\Exception;
    // use PHPMailer\PHPMailer\SMTP;
    
    // require '../plugins/PHPMailer/Exception.php';
    // require '../plugins/PHPMailer/PHPMailer.php';
    // require '../plugins/PHPMailer/SMTP.php';

    //Create an instance; passing `true` enables exceptions
    // $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'yasirshanu@gmail.com';                 //SMTP username
        $mail->Password   = 'wttrltzpdoaaklke';                          //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('yasirshanu@gmail.com', 'Admin (MAT College)');
        $mail->addAddress($senderset);                  //Add a recipient
        
        // $mail->addAttachment('../dist/img/avatar.png', 'Test.png');

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subset;
        $mail->Body    = $bodyset;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    }
    catch (Exception $e)
    {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>