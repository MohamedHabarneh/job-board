<?php
//Company name, Company Email, Company Phone number, Company address, and Role in Hiring Process. Company Address is optional. 
include("user.php");

class Employer extends User
{
    public $employerId;
    public $companyName;
    public $companyEmail;
    public $companyPhone;
    public $companyAddress = NULL;
    public $hiringRole;
    public $jobPosts;
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function addAddress()
    {
        $this->table_name = "Address";

        $query = "INSERT INTO " . $this->table_name . "
        SET
            StreetAddress = :streetAddress,
            State = :state,
            ZipCode = :zip,
            TimeStamp =  CURRENT_TIMESTAMP";

        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->companyAddress->zip = htmlspecialchars(strip_tags($this->companyAddress->zip));
        $this->companyAddress->streetAddress = htmlspecialchars(strip_tags($this->companyAddress->streetAddress));
        $this->companyAddress->state = htmlspecialchars(strip_tags($this->companyAddress->state));

        // bind the values

        $stmt->bindParam(':zip', $this->companyAddress->zip);
        $stmt->bindParam(':streetAddress', $this->companyAddress->streetAddress);
        $stmt->bindParam(':state', $this->companyAddress->state);
        if ($stmt->execute()) {
            $this->companyAddress->addressId = $this->conn->lastInsertId();
            return true;
        }
        echo "\nPDO::errorInfo():\n";
        print_r($stmt->errorInfo());
        $this->error = "Server Error";
        return false;
    }

    public function addHiringRole()
    {
        $this->table_name = "Employer";

        $query = "INSERT INTO " . $this->table_name . "
        SET
            AddressID = :addressId,
            TimeStamp = CURRENT_TIMESTAMP,
            EmployerEmail = :companyEmail,
            EmployerName =  :companyName,
            EmployerPhone = :companyPhone,
            UserID = :userId";

        $stmt = $this->conn->prepare($query);
    }


    public function addEmployerInfo()
    {
        $this->table_name = "Employer";

        $query = "INSERT INTO " . $this->table_name . "
        SET
            AddressID = :addressId,
            TimeStamp = CURRENT_TIMESTAMP,
            EmployerEmail = :companyEmail,
            EmployerName =  :companyName,
            EmployerPhone = :companyPhone,
            UserID = :userId,
            HiringRoleId = :hiringRoleId";

        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->companyName = htmlspecialchars(strip_tags($this->companyName));
        $this->companyPhone = htmlspecialchars(strip_tags($this->companyPhone));
        $this->companyEmail = htmlspecialchars(strip_tags($this->companyEmail));
        $this->hiringRole = htmlspecialchars(strip_tags($this->hiringRole));
        // bind the values
        $addID = empty($this->companyAddress->addressId) ? NULL : $this->companyAddress->addressId;
        $stmt->bindParam(':addressId', $addID);
        $stmt->bindParam(':companyEmail', $this->companyEmail);
        $stmt->bindParam(':companyName', $this->companyName);
        $stmt->bindParam(':companyPhone', $this->companyPhone);
        $stmt->bindParam(':userId', $this->id);
        $stmt->bindParam(':hiringRoleId', $this->hiringRole);
        if ($stmt->execute()) {
            $this->employerId = $this->conn->lastInsertId();
            return true;
        }
        echo "\nPDO::errorInfo():\n";
        print_r($stmt->errorInfo());
        $this->error = "Server Error";
        return false;
    }
}