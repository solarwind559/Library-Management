<?php

namespace Model;


class User {

    public $name;
    public $surname;
    public $email;
    public $password;

    function __construct($name, $surname, $email, $password){
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->setPassword($password);
    }

    private function setPassword($password) {
        // You can hash the password here (e.g., using password_hash())
        // For simplicity, let's store it as-is in this example
        $this->password = $password;
    }

    // Method to get the user's full name
    public function getFullName() {
        return $this->name . ' ' . $this->surname;
    }

    // Method to save user data to the database (you'll need to implement this)
    public function saveToDatabase() {
        $sql = "INSERT INTO users (name, surname, email, password)
                VALUES ('$name', '$surname', '$email', '$password')";

    }

}