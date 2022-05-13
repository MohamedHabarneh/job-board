<?php

class User
{
    // database connection and table name
    public $conn;
    private $table_name = "UserAccount";

    // object properties
    public $id;
    public $fName;
    public $lName;
    public $email;
    public $password;
    public $phone = NULL;
    public $userType;

    public $isAuthed = false;
    public $error;

    // constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function setDB($db)
    {
        $this->db = $db;
    }
    // create new user record
    function create()
    {
        // insert query
        $query = "INSERT INTO " . $this->table_name . "
            SET
                FirstName = :fName,
                LastName = :lName,
                UserEmail = :email,
                Phone = :phone,
                Password = :password,
                TimeStamp =  CURRENT_TIMESTAMP";

        // prepare the query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->fName = htmlspecialchars(strip_tags($this->fName));
        $this->lName = htmlspecialchars(strip_tags($this->lName));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->phone = htmlspecialchars(strip_tags($this->phone));

        // bind the values

        $stmt->bindParam(':fName', $this->fName);
        $stmt->bindParam(':lName', $this->lName);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);

        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
        // execute the query, also check if query was successful
        if ($this->emailExists()) {
            $this->error = "Email already used.";
            return false;
        }
        if ($stmt->execute()) {
            return true;
        }
        echo "\nPDO::errorInfo():\n";
        print_r($stmt->errorInfo());
        $this->error = "Server Error";
        return false;
    }

    function emailExists()
    {

        // query to check if email exists
        $query = "SELECT UserID, FirstName, LastName, Password
                FROM " . $this->table_name . "
                WHERE UserEmail = ?
                LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->email = htmlspecialchars(strip_tags($this->email));

        // bind given email value
        $stmt->bindParam(1, $this->email);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if ($num > 0) {

            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->id = $row['UserID'];
            $this->fName = $row['FirstName'];
            $this->lName = $row['LastName'];
            $this->password = $row['Password'];

            // return true because email exists in the database
            return true;
        }

        // return false if email does not exist in the database
        return false;
    }
}