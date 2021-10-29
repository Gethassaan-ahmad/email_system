<?php

class login{

    public $name, $email, $password;

    public function __construct($db) {
     	  $this->conn = $db;
    }
	
	
 	//FILTER EMAIL ADDRESS
 	function test_email($emails){
         if(empty($emails)){
			return null;
		}else{
            $email = filter_var($emails, FILTER_SANITIZE_EMAIL);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $email;
            }else{
                return 1;
            }
        }
 	}

    //validation and required 
    public function test_inputs($data){
        if(empty($data)){
            return null;
        }else{
            $data= strip_tags($data);
            $data= htmlspecialchars($data);
            $data= stripslashes($data);
            $data= trim($data);
            return $data;
        }
    }

 	// Login function
	public function login(){
        $select_user = "SELECT * FROM users WHERE email=:email";
        $stmt = $this->conn->prepare($select_user);
        $stmt->bindValue(':email', $this->email,PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // $check_password = password_verify($this->password, $row['password']);
            // $check_password = $this->password;

            // VERIFYING THE PASSWORD (IS CORRECT OR NOT?)
            // IF PASSWORD IS CORRECT THEN SEND THE LOGIN TOKEN
            if($this->password == $row['password']){

                $jwt = new JwtHandler();
                $token = $jwt->_jwt_encode_data(
                    'http://localhost/php_auth_api/',
                    array("user_id"=> $row['id'])
                );
                return $token;

            // IF INVALID PASSWORD
            }else{
                return 0;
            }

        // IF THE USER IS NOT FOUNDED BY EMAIL THEN SHOW THE FOLLOWING ERROR
        }else{
            // return 1;

            $select_user = "SELECT * FROM secondary_users WHERE email=:email";
            $stmt = $this->conn->prepare($select_user);
            $stmt->bindValue(':email', $this->email,PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount()){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                // $check_password = password_verify($this->password, $row['password']);
                // $check_password = $this->password;

                // VERIFYING THE PASSWORD (IS CORRECT OR NOT?)
                // IF PASSWORD IS CORRECT THEN SEND THE LOGIN TOKEN
                if($this->password == $row['password']){

                    $jwt = new JwtHandler();
                    $token = $jwt->_jwt_encode_data(
                        'http://localhost/php_auth_api/',
                        array("user_id"=> $row['id'])
                    );
                    return $token;

                // IF INVALID PASSWORD
                }else{
                    return 0;
                }

            // IF THE USER IS NOT FOUNDED BY EMAIL THEN SHOW THE FOLLOWING ERROR
            }else{
                return 1;
            }

        }
    }
}
?>