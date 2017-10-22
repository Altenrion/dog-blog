<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

////Load composer's autoloader
//require 'vendor/autoload.php';


if (isset($_POST['email'])) {

    $link = mysqli_connect("localhost", "altenrion_gbland", "Altenrion", "altenrion_gbland") or die("Error " . mysqli_error($link));

    $query = "INSERT INTO subscription (`email`) VALUES ('{$_POST['email']}')" or die("Error in the consult.." . mysqli_error($link));

    $result = $link->query($query);
    if (empty($link->insert_id))
        echo json_encode(array(
            'status' => 'error',
            'msg' => "Subscription Failed"
        ));die();

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.timeweb.ru';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'admin@grafstvobagiry.ru';                 // SMTP username
        $mail->Password = 'Altenrion1991';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 2525;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('admin@grafstvobagiry.ru', 'Altenrion');
        $mail->addAddress('landerfeld@gmail.com', 'Nik Sabbuk');     // Add a recipient
        $mail->addAddress('ellen@example.com');               // Name is optional
//    $mail->addReplyTo('info@example.com', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

        //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
//        echo 'Message could not be sent.';
//        echo 'Mailer Error: ' . $mail->ErrorInfo;
        echo json_encode(array(
            'status' => 'error',
            'msg' => "Sending message failed ". $e. "___ ". $mail->ErrorInfo
        ));die();

//        throw new \Exception("Sending message failed ". $e. "___ ". $mail->ErrorInfo);
    }

    echo json_encode(array(
        'status' => 'success',
        'msg' => "Subscribtion + messaging successfully done!"
    ));die();
}
