<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function msg($success, $status, $message, $extra = [])
{
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ], $extra);
}

// MY FILES
require '../config/Database.php';
require '../classes/mail.php';
require '../middlewares/Auth.php';
// PHP MAILER FILES
require '../PHPMailer/vendor/phpmailer/phpmailer/src/Exception.php';
require '../PHPMailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../PHPMailer/vendor/phpmailer/phpmailer/src/SMTP.php';

// Import PHPMailer classes into the global namespace 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$db_connection = new Database();
$db = $db_connection->dbConnection();

$mail = new PHPMailer;


$data = json_decode(file_get_contents("php://input"));
$returnData = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender_username = 'Admin';
    $sender_key = $data->password;
    $from = $data->from;
    $to = $data->to;
    $subject = $data->subject;
    $body = $data->body;

    $mail->isSMTP();                      // Set mailer to use SMTP 
    $mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers 
    $mail->SMTPAuth = true;               // Enable SMTP authentication 
    $mail->Username = $from;              // SMTP username (sender email address)
    $mail->Password = $sender_key;        // SMTP password 
    $mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted 
    $mail->Port = 587;                    // TCP port to connect to 

    // Sender info 
    $mail->setFrom($from, $sender_username);
    $mail->addReplyTo($from, $sender_username);

    // Add a recipient 
    $mail->addAddress($to);

    if (isset($data->cc)) {
        $mail->addCC($cc);
    }


    if (isset($data->cc)) {
        $mail->addBCC($bcc);
    }

    // Set email format to HTML 
    $mail->isHTML(true);

    // Mail subject 
    $mail->Subject = $subject;
    // $mail->addAttachment('download.png', 'Programmers Force');

    // Mail body content 
    $bodyContent = '<h1>Email by ' . $sender_username . '</h1>';
    $bodyContent .= '<p>' . $body . '</p>';
    $mail->Body    = $bodyContent;

    // Send email 
    if (!$mail->send()) {
        echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    } else {

        echo 'Email has been sent.';
    }
} else {
    $returnData = msg(0, 404, 'Page Not Found!');
}

echo json_encode($returnData);
