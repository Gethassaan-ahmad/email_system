<?php

class addUser{

    public $name, $email, $password, $merchant_id;

    public function __construct($db) {
     	  $this->conn = $db;
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

    public function test_password($data){
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

	public function test_permission($data){
		if(empty($data)){
			return null;
		}else{
		 	$data= strip_tags($data);
		 	$data= htmlspecialchars($data);
		 	$data= stripslashes($data);
		 	$data= trim($data);
		 	// return $data;
			if($data == 'Yes' OR $data == 'yes' OR $data == 'No' OR $data == 'no'){
				return $data;
			}else{
				return 1;
			}
		}
 	}

 	// Login function
	public function addUser($merchant_id){
        $sql = 'INSERT INTO secondary_users (name,email,password,view_email,send_email,view_billing_info,merchant_id) VALUES (:name,:email,:password,:view_email,:send_email,:view_billing_info,:merchant_id)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':password', $this->password);
        $stmt->bindValue(':view_email', $this->view_email);
        $stmt->bindValue(':send_email', $this->send_email);
        $stmt->bindValue(':view_billing_info', $this->view_billing_info);
        // $stmt->bindValue(':password', password_hash($this->password, PASSWORD_DEFAULT),PDO::PARAM_STR);
        $stmt->bindValue(':merchant_id', $merchant_id);
        
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}
?>