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
require '../classes/admin.php';
require '../middlewares/Auth.php';

$db_connection = new Database();
$db = $db_connection->dbConnection();

$allHeaders = getallheaders();
$auth = new Auth($db, $allHeaders);

// Employees Listing
$read = new read($db);

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $data = $auth->isAuth();
    $role = $data['role'];
    if ($role == 'Admin') {
        $result = $read->fetch_billing_info();
        if (count($result) > 0) {
            echo json_encode($result);
        } else {
            $returnData = [
                "success" => 0,
                "status" => 422,
                "message" => "No Record Found"
            ];
        }
    } elseif ($role == 'Merchant') {
        $merchant_id = $data['id'];
        $result = $read->fetch_merchant_billing_info($merchant_id);
        if (count($result) > 0) {
            echo json_encode($result);
        } else {
            $returnData = [
                "success" => 0,
                "status" => 422,
                "message" => "No Record Found"
            ];
        }
    } elseif ($data['view_billing_info'] == 'Yes' or $data['view_billing_info'] == 'yes') {
        $merchant_id = $data['id'];

        $result = $read->fetch_merchant_billing_info($merchant_id);
        if (count($result) > 0) {
            echo json_encode($result);
        } else {
            $returnData = [
                "success" => 0,
                "status" => 422,
                "message" => "No Record Found"
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
