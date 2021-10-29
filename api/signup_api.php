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

// INCLUDING DATABASE AND MAKING OBJECT
require '../config/Database.php';
require '../classes/signup.php';

$db_connection = new Database();
$db = $db_connection->dbConnection();

$data = json_decode(file_get_contents("php://input"));
$returnData = [];

$signup = new signup($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $signup->name = $data->name;
    $signup->email = $data->email;
    $signup->password = $data->password;
    $signup->image = $data->image;

    $name = $signup->test_inputs($signup->name);
    $email = $signup->test_email($signup->email);
    $password = $signup->test_inputs($signup->password);
    $image = $signup->image;

    if ($name == null or $password == null or $email == null or $image == '') {
        $fields = ['fields' => ['name', 'email', 'password', 'image']];
        $returnData = msg(0, 422, 'Please Fill! All Required Fields!', $fields);
    } elseif ($email == 1) {
        $returnData = msg(0, 422, 'Invalid Email Address!');
    } elseif ($signup->useralreadyexists()) {
        $returnData = msg(0, 422, 'This E-mail already Registered!');
    } elseif ($signup->insert($image)) {
        $returnData = msg(1, 201, 'You have successfully registered.');
    } else {
        $returnData = msg(0, 500, 'Something went Wrong');
    }
} else {
    $returnData = msg(0, 404, 'Page Not Found!');
}

echo json_encode($returnData);
