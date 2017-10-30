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

if (!isset($received_data["name"], $received_data["phone"]) || empty($received_data))
    reply(jsonResponse("fail", "Name or Phone were not sent correctly"));

if (empty($received_data["name"]) || empty($received_data["phone"]))
    reply(jsonResponse("fail", "Name or Phone were not sent correctly"));



$name = $received_data['name'];
$phone = $received_data['phone'];
$puppy = isset($received_data['puppy'])? $received_data['puppy']:"";


$saving_puppy = $puppy==""?"":" ( ".$puppy." ) ";

$link = mysqli_connect("localhost","altenrion_gbland","Altenrion","altenrion_gbland") or die("Error " . mysqli_error($link));
$query = "INSERT INTO requests (`name`, `phone`) VALUES ('$name.$saving_puppy','$phone')" or die("Error in the consult.." . mysqli_error($link));

$result = $link->query($query);

if (empty($link->insert_id))
    reply(jsonResponse('fail', "Saving visit request failed"));



$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.timeweb.ru';                      // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'admin@grafstvobagiry.ru';                 // SMTP username
    $mail->Password = 'Altenrion1991';                           // SMTP password
    $mail->Port = 2525;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('admin@grafstvobagiry.ru', 'Графство Багиры');
    $mail->addAddress('landerfeld@gmail.com', 'Nikita');
    $mail->addAddress('olgadogi@mail.ru', 'Olga');
    $mail->addAddress('7964485@gmail.com', 'Yulia');

    //Content
    $mail->isHTML(true);

    $mail->Subject = 'Оформлена заявка на визит';

    $bodyHtml = file_get_contents('message_templates/notify.html');

    $patterns = array("{{HEADER}}","{{SUBHEADER}}","{{TEXT}}");
    $data = array(
        "Активность на сайте",
        "Заявка на визит питомника",
        "На сайте grafstvobagiry.ru посетитель ". ucfirst($name) ." оставил заявку на визит питомника.".
        ($puppy==""?"":" Пользователь выбрал <b>щенка ".$puppy."</b>.")
        ." Для связи указан телефон : <a href='tel:$phone'> $phone </a>. <br>
         Необходимо оправдать ожидания, связатья с ним и согласовать встречу."
    );

    $messageBody = str_replace($patterns, $data, $bodyHtml);

    $mail->Body = $messageBody;
    $mail->CharSet = 'utf-8';

    $mail->send();

} catch (Exception $e) {
    reply(jsonResponse('fail', "Sending message failed : " . $e . "___ " . $mail->ErrorInfo));
}

reply(jsonResponse('success', "Ваша заявка успешно оформлена"));
