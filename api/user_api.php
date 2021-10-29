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

require '../config/Database.php';
require '../classes/user.php';
require '../middlewares/Auth.php';

$db_connection = new Database();
$db = $db_connection->dbConnection();

$allHeaders = getallheaders();
$auth = new Auth($db, $allHeaders);

$data = json_decode(file_get_contents("php://input"));
$returnData = [];

// IF REQUEST METHOD IS NOT EQUAL TO POST

$user = new addUser($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($data_role = $auth->isAuth()) {
        $merchant_role = $data_role['role'];
        if (isset($merchant_role) and $merchant_role == 'Merchant') {
            $user->name = $data->name;
            $user->email = $data->email;
            $user->password = $data->password;
            $user->view_email = $data->view_email;
            $user->send_email = $data->send_email;
            $user->view_billing_info = $data->view_billing_info;

            $name = $user->test_inputs($user->name);
            $email = $user->test_email($user->email);
            $password = $user->test_password($user->password);
            $view_email = $user->test_permission($user->view_email);
            $send_email = $user->test_permission($user->send_email);
            $view_billing_info = $user->test_permission($user->view_billing_info);

            if ($name == null or $password == null or $email == null or $view_email == null or $send_email == null or $view_billing_info == null) {
                $fields = ['fields' => ['name', 'email', 'password', 'view_email', 'send_email', 'view_billing_info']];
                $returnData = msg(0, 422, 'Please Fill! All Required Fields!', $fields);
            } elseif ($email == 1) {
                $returnData = msg(0, 422, 'Invalid Email Address!');
            } elseif ($view_email == 1 or $send_email == 1 or $view_billing_info == 1) {
                $returnData = msg(0, 422, 'To give Permission you have to use only Yes/No');
            } else {
                if ($data = $auth->isAuth()) {
                    $merchant_id = $data['id'];
                    $user->addUser($merchant_id);
                    $returnData = [
                        'success' => 1,
                        'status' => 201,
                        'message' => 'Your Secondary User Successfully Created.',
                    ];
                } else {
                    $returnData = [
                        "success" => 0,
                        "status" => 401,
                        "message" => "Unauthorized"
                    ];
                }
            }
        } else {
            $returnData = [
                "success" => 0,
                "status" => 401,
                "message" => "Your are not a Merchant"
            ];
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
