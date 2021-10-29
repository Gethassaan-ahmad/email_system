<?php
class read
{
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function fetch_email()
    {
        $select = "SELECT e.id,e.fromUser,e.toUser,e.cc,e.bcc,e.subject,e.body,u.name FROM emails as e LEFT JOIN users as u ON u.id = e.mailBy";
        $run_select = $this->conn->prepare($select);
        $run_select->execute();
        $fetch_data = $run_select->fetchAll(PDO::FETCH_ASSOC);
        //   $fetch_data += array("Status Code"=>"200");
        return $fetch_data;
    }

    public function fetch_merchant_email($role, $merchant_id)
    {
        $select = "SELECT e.id,e.fromUser,e.toUser,e.cc,e.bcc,e.subject,e.body,u.name FROM emails as e LEFT JOIN users as u ON u.id = e.mailBy WHERE u.role = '$role' OR u.id = '$merchant_id'";
        $run_select = $this->conn->prepare($select);
        $run_select->execute();
        $fetch_data = $run_select->fetchAll(PDO::FETCH_ASSOC);
        //   $fetch_data += array("Status Code"=>"200");
        return $fetch_data;
    }

    public function fetch_billing_info()
    {
        $select = "SELECT b.id,b.amount,b.card_number,b.exp_month,b.exp_year,b.cvc,u.name FROM billing_info as b LEFT JOIN users as u ON u.id = b.customer_id";
        $run_select = $this->conn->prepare($select);
        $run_select->execute();
        $fetch_data = $run_select->fetchAll(PDO::FETCH_ASSOC);
        //   $fetch_data += array("Status Code"=>"200");
        return $fetch_data;
    }

    public function fetch_merchant_billing_info($merchant_id)
    {
        $select = "SELECT b.id,b.amount,b.card_number,b.exp_month,b.exp_year,b.cvc,u.name FROM billing_info as b LEFT JOIN users as u ON u.id = b.customer_id WHERE u.id = '$merchant_id'";
        $run_select = $this->conn->prepare($select);
        $run_select->execute();
        $fetch_data = $run_select->fetchAll(PDO::FETCH_ASSOC);
        //   $fetch_data += array("Status Code"=>"200");
        return $fetch_data;
    }
}
