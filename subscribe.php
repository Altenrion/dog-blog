<?php

use Alt\PHPMailer;
use Alt\Exception;

require '_Exception.php';
require '_PHPMailer.php';
require '_SMTP.php';

function jsonResponse($status, $message)
{
    return json_encode(array('status' => $status, 'msg' => $message));
}

function reply($response){
    echo $response; die();
}


$json = file_get_contents('php://input');
$received_data = json_decode($json, true);

if (!isset($received_data["email"]) || empty($received_data))
    reply(jsonResponse("fail", "Email was not sent correctly"));


$email = $received_data['email'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    reply(jsonResponse("fail", "Text '$email' is not a valid email"));


$link = mysqli_connect("localhost", "altenrion_gbland", "Altenrion", "altenrion_gbland") or die("Error " . mysqli_error($link));
$query = "INSERT INTO subscription (`email`) VALUES ('$email')" or die("Error.." . mysqli_error($link));

$result = $link->query($query);

if (empty($link->insert_id))
    reply(jsonResponse('fail', "Saving subscription failed"));



$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.timeweb.ru';                      // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'admin@grafstvobagiry.ru';                 // SMTP username
    $mail->Password = 'Altenrion1991';                           // SMTP password
//    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 2525;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('admin@grafstvobagiry.ru', 'Admin');
    $mail->addAddress('landerfeld@gmail.com', 'Nik Sabbuk');     // Add a recipient
//    $mail->addAddress('ellen@example.com');               // Name is optional
//    $mail->addReplyTo('info@example.com', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');
    //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);

    //@todo: set the text info about the subscriber and edit the emails when finished

    $mail->Subject = 'Оформлена подписка на сайте';
    $mail->Body = file_get_contents('message_templates/notify.html');


//    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

} catch (Exception $e) {
    reply(jsonResponse('fail', "Sending message failed : " . $e . "___ " . $mail->ErrorInfo));
}

reply(jsonResponse('success', "Ваша подписка успешно оформлена"));

