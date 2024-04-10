<?php
include_once('../../config/db.php'); // Include the database connection

class AdminModel {
    private $conn; // Database connection

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function validateLogin($email, $password) {
        $query = "SELECT id FROM admins WHERE email = :email AND password = :password";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->execute();

        $result = $stmt->fetchColumn();
        return $result; // Return user_id if login is successful, or false if not
    }
}
