<?php

include_once('../../config/db.php'); // Include the database connection

class AdminController {
    private $conn; // Database connection

    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }

    // Validate email format
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    // Validate password strength (at least 8 characters)
    public static function validatePassword($password) {
        return strlen($password) >= 8;
    }

    // Validate login credentials
    public function validateLogin($email, $password) {
        $query = "SELECT id FROM admins WHERE email = :email AND password = :password";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->execute();

        $result = $stmt->fetchColumn();
        return $result; // Return user_id if login is successful, or false if not
    }

    // Logout: Destroy the session
    public static function logout() {
        session_start();
        session_unset();
        session_destroy();
        // Redirect to the login page (adjust the URL as needed)
        header('Location: login.php');
        exit();
    }
}
?>
