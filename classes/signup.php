<?php

class signup{

	public $name, $email, $password;

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

    //if user already exits function
	public function useralreadyexists(){
		$query = "SELECT COUNT(email) AS num FROM users WHERE email= :email";
		$insert = $this->conn->prepare($query);
		$insert->bindValue(':email', $this->email);
		$insert->execute();

		$row = $insert->fetch(PDO:: FETCH_ASSOC);
		if($row['num'] > 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function base64($image){
		// $image = $postData['image']; //This a postdata here we going to collect the base64 image.
		$image_name = ""; //declaring the image name variable
		$image_name = round(microtime(true) * 1000). ".jpg"; //Giving new name to image.
		$image_upload_dir = $_SERVER['DOCUMENT_ROOT'].'../email_system/image/'.$image_name; //Set the path where we need to upload the image.
		$flag = file_put_contents($image_upload_dir, base64_decode($image));
		//Here is the main code to convert Base64 image into the real image/Normal image.
		//file_put_contents is function of php. first parameter is the path where you neeed to upload the image. second parameter is the base64image and with the help of base64_decode function we decoding the image.

		if($flag){ //Basically flag variable is set for if image get uploaded it will give us true then we will save it in database or else we give response for fail.
			return $image_name;
		}else{
			return false;
		}
	}

 	// signup function
	public function insert($image){
		$image = $this->base64($image);
		if($image == false){
			return false;
		}else{
			$sql = 'INSERT INTO users (name,email,password,role,image,balance) VALUES (:name,:email,:password,:role,:image,:balance)';
			$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(':name', $this->name);
			$stmt->bindValue(':email', $this->email);
			$stmt->bindValue(':password', $this->password);
			// $stmt->bindValue(':password', password_hash($this->password, PASSWORD_DEFAULT),PDO::PARAM_STR);
			$stmt->bindValue(':role', 'Merchant');
			$stmt->bindValue(':image', $image);
			$stmt->bindValue(':balance', '0');
			
			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}
	}
}
?>