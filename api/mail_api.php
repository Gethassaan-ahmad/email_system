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

$allHeaders = getallheaders();
$auth = new Auth($db, $allHeaders);

$mail = new PHPMailer;

$data = json_decode(file_get_contents("php://input"));
$returnData = [];

$myMail = new myMail($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $myMail->to = $data->to;
    $myMail->subject = $data->subject;
    $myMail->body = $data->body;
    if (isset($data->cc)) {
        $myMail->cc = $data->cc;
    }
    if (isset($data->bcc)) {
        $myMail->bcc = $data->bcc;
    }

    // $from_username = $myMail->test_inputs($myMail->from_username);
    // $from = $myMail->test_email($myMail->from);
    $to = $myMail->test_email($myMail->to);
    $subject = $myMail->test_inputs($myMail->subject);
    $body = $myMail->test_inputs($myMail->body);
    $cc = $myMail->test_email($myMail->cc);
    $bcc = $myMail->test_email($myMail->bcc);

    if ($to == null or $subject == null or $body == null) {
        $fields = ['fields' => ['To', 'Subject', 'Body']];
        $returnData = msg(0, 422, 'Please Fill! All Required Fields!', $fields);
    } elseif ($to == 1) {
        $returnData = msg(0, 422, 'There is an Invalid Email Address!');
    } elseif ($data = $auth->isAuth()) {
        // $merchant_role = $data['role'];
        if (isset($data['role']) and $data['role'] == 'Merchant') {
            $mailBy = $data['id'];
            $from_username = $data['name'];
            $from = $data['email'];
            $myMail->from = $from;
            $sender_password = $data['password'];
        } elseif (isset($data['send_email']) and ($data['send_email'] == 'Yes' or $data['send_email'] == 'yes')) {
            $mailBy = $data['merchant_id'];
            $fetch_user = "SELECT * FROM users WHERE id=:id";
            $query_stmt = $db->prepare($fetch_user);
            $query_stmt->bindValue(':id', $mailBy);
            $query_stmt->execute();
            $row = $query_stmt->fetch(PDO::FETCH_ASSOC);
            $from_username = $row['name'];
            $from = $row['email'];
            $myMail->from = $from;
            $sender_password = $row['password'];
        } else {
            $returnData = [
                'success' => 0,
                'status' => 422,
                'message' => 'You are not Authorized to send Email'
            ];
        }


        $mail->isSMTP();                        // Set mailer to use SMTP 
        $mail->Host = 'smtp.gmail.com';         // Specify main and backup SMTP servers 
        $mail->SMTPAuth = true;                 // Enable SMTP authentication 
        $mail->Username = $from;      // SMTP username (sender email address)
        $mail->Password = $sender_password;          // SMTP password 
        $mail->SMTPSecure = 'tls';              // Enable TLS encryption, `ssl` also accepted 
        $mail->Port = 587;                      // TCP port to connect to 

        // Sender info 
        $mail->setFrom($from, $from_username);
        $mail->addReplyTo($from, $from_username);

        // Add a recipient 
        $mail->addAddress($to);

        $mail->addCC($cc);
        $mail->addBCC($bcc);

        // Set email format to HTML 
        $mail->isHTML(true);

        // Mail subject 
        $mail->Subject = $subject;
        // $mail->addAttachment('download.png','Programmers Force');

        // Mail body content 
        $bodyContent = '<p>' . $body . '</p>';
        // $bodyContent .= '<p>Programmers Force</p>'; 
        $mail->Body    = $bodyContent;

        // Send email 
        $query = "SELECT *,COUNT(email) AS num FROM users WHERE id= :id";
        $insert = $db->prepare($query);
        $insert->bindValue(':id', $mailBy);
        $insert->execute();

        $row = $insert->fetch(PDO::FETCH_ASSOC);
        if ($row['num'] > 0) {
            $balance = $row['balance'];
            if ($balance >= 0.0489) {
                if ($mail->send()) {
                    $status = 'Sent';
                    if ($myMail->insert($mailBy, $status)) {
                        $returnData = [
                            'success' => 1,
                            'status' => 201,
                            'message' => 'Email has been sent.'
                        ];
                    } else {
                        $returnData = [
                            'success' => 0,
                            'status' => 422,
                            'message' => 'Email Cannot Insert in Database.'
                        ];
                    }
                } else {
                    $status = 'Sending Failed';
                    $myMail->insert($mailBy, $status);
                    $returnData = [
                        'success' => 0,
                        'status' => 422,
                        'message' => 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo
                    ];
                }
            } else {
                $returnData = [
                    'success' => 1,
                    'status' => 422,
                    'message' => 'Your Balance is Low. Please Add Credit'
                ];
            }
        }
    } else {
        $returnData = [
            "success" => 0,
            "status" => 401,
            "message" => "Unauthorized"
        ];
    }
} else {
    $returnData = msg(0, 404, 'Page Not Found!');
}

echo json_encode($returnData);
