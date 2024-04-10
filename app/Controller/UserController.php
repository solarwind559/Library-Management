<?php

include_once('../../config/db.php');

class UserController {
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

    public function verifyPassword($enteredPassword, $confirmPassword) {
        // Verify that the entered password matches the confirmed password
        return $enteredPassword === $confirmPassword;
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

        // Validate password strength
        if (strlen($this->password) < 8) {
            return  '<div class="alert alert-danger" role="alert">
            Password must be at least 8 characters long.
            </div>';
        }
        return null; // Input is valid
    }

    function viewAll($from_record_num, $records_per_page){
  
        $query = "SELECT
                    id, name, surname, email
                FROM
                    " . $this->table_name . "
                ORDER BY
                    name ASC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    }
        // used for paging products
        public function countAll(){
    
            $query = "SELECT id FROM " . $this->table_name . "";
        
            $stmt = $this->conn->prepare( $query );
            $stmt->execute();
        
            $num = $stmt->rowCount();
        
            return $num;
        }
    
        function viewOne(){
        
            $query = "SELECT
                        name, surname, email
                    FROM
                        " . $this->table_name . "
                    WHERE
                        id = ?
                    LIMIT
                        0,1";
        
            $stmt = $this->conn->prepare( $query );
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
        
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            $this->name = $row['name'];
            $this->surname = $row['surname'];
            // $this->category_id = $row['category_id'];
        }
    
        function update(){
      
            $query = "UPDATE
                        " . $this->table_name . "
                    SET
                        name = :name,
                        surname = :surname,
                    WHERE
                        id = :id";
          
            $stmt = $this->conn->prepare($query);
          
            // posted values
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->surname=htmlspecialchars(strip_tags($this->surname));
            // $this->category_id=htmlspecialchars(strip_tags($this->category_id));
            $this->id=htmlspecialchars(strip_tags($this->id));
          
            // bind parameters
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':surname', $this->surname);
            // $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);
          
            // execute the query
            if($stmt->execute()){
                return true;
            }
          
            return false;
              
        }
}

?>
