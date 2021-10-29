<?php
    class myMail{

        public $from, $to, $cc, $bcc, $subject, $body, $mailBy;

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

        // Insert Email function
        // public function insert($mailBy){
        public function insert($mailBy,$status){
            $sql = 'INSERT INTO emails(fromUser,toUser,cc,bcc,subject,body,status,mailBy) VALUES (:fromUser,:toUser,:cc,:bcc,:subject,:body,:status,:mailBy)';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':fromUser', $this->from);
            $stmt->bindValue(':toUser', $this->to);
            $stmt->bindValue(':cc', $this->cc);
            $stmt->bindValue(':bcc', $this->bcc);
            $stmt->bindValue(':subject', $this->subject);
            $stmt->bindValue(':body', $this->body);
            $stmt->bindValue(':status', $status);
            $stmt->bindValue(':mailBy', $mailBy);
            
            if($stmt->execute()){

                $query = "SELECT *,COUNT(email) AS num FROM users WHERE id= :id";
                $insert = $this->conn->prepare($query);
                $insert->bindValue(':id', $mailBy);
                $insert->execute();

                $row = $insert->fetch(PDO:: FETCH_ASSOC);
                if($row['num'] > 0){
                    $balance = $row['balance'];
                    $updatedBalance = $balance - 0.0489;
                    $sql = "UPDATE users SET balance = '$updatedBalance' WHERE id = '$mailBy'";
                    $stmt = $this->conn->prepare($sql);
                    if($stmt->execute()){
                        return true;
                    }else{
                        return false;
                    }
                }
                else{
                    return false;
                }
            }else{
                return false;
            }
        }
    }
?>