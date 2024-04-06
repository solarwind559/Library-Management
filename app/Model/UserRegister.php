<?php

include_once('../../config/db.php');

class UserRegister {
    private $conn;
    private $table_name = "users";
    public $name;
    public $surname;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function getFullName() {
        return $this->name . ' ' . $this->surname;
    }


    public function saveToDatabase() {
        try {
            $stmt = $this->conn->prepare("INSERT INTO users (name, surname, email, password) VALUES (?, ?, ?, ?)");
            $stmt->execute([$this->name, $this->surname, $this->email, $this->password]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function validateInput() {
        // Validate required fields
        if (empty($this->name) || empty($this->surname) || empty($this->email) || empty($this->password)) {
            return '<div class="alert alert-danger" role="alert">
            All fields are required.
            </div>';
        }

        // Validate email format
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return '<div class="alert alert-danger" role="alert">
            Invalid email address.
            </div>';
        }

        // Validate password strength (you can add more rules here)
        if (strlen($this->password) < 8) {
            return  '<div class="alert alert-danger" role="alert">
            Password must be at least 8 characters long.
            </div>';
            
        }

        return null; // Input is valid
    }
}

?>
