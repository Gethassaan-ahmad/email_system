<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    function msg($success,$status,$message,$extra = []){
        return array_merge([
            'success' => $success,
            'status' => $status,
            'message' => $message
        ],$extra);
    }

    require '../config/Database.php';
    require '../classes/login.php';
    require '../classes/JwtHandler.php';

    $db_connection = new Database();
    $db = $db_connection->dbConnection();

    $data = json_decode(file_get_contents("php://input"));
    $returnData = [];

    // IF REQUEST METHOD IS NOT EQUAL TO POST

        $login = new login($db);

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $login->email = $data->email;
            $login->password = $data->password;

            $email = $login->test_email($login->email);
            $password = $login->test_inputs($login->password);

            if($password == null or $email == null){
                $fields = ['fields' => ['email','password']];
                $returnData = msg(0,422,'Please Fill! All Required Fields!',$fields);
            }elseif($email==1){
                $returnData = msg(0,422,'Invalid Email Address!');
            }else{
                $token = $login->login();
                if($token == 0) {
                    $returnData = msg(0,422,'Invalid Password!');
                }elseif ($token == 1) {
                    $returnData = msg(0,422,'Invalid Email Address!');
                }else{
                    $returnData = [
                                'success' => 1,
                                'message' => 'You have successfully logged in.',
                                'token' => $token
                                ];
                }
            }
        }else{
            $returnData = msg(0,404,'Page Not Found!');
        }

    echo json_encode($returnData);