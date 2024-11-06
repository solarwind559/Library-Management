<?php
class Database{
   
    private $host = "fdb1030.awardspace.net";
    private $db_name = "4513047_library";
    private $username = "4513047_library";
    private $password = "j8x@xM3eZxNn@Bz";
    public $conn;
   
    // get the database connection
    public function getConnection(){
   
        $this->conn = null;
   
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
   
        return $this->conn;
    }
}
?>