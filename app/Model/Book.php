<?php
class Book{
  
    // database connection and table title
    private $conn;
    private $table_name = "books";
  
    // object properties
    public $id;
    public $title;
    public $author;
    public $category_id;
    public $status;
    public $timestamp;
  
    public function __construct($db){
        $this->conn = $db;
    }
  
    function create(){
  
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    title=:title, author=:author, category_id=:category_id, created=:created, status=:status";
  
        $stmt = $this->conn->prepare($query);
  
        // posted values
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->author=htmlspecialchars(strip_tags($this->author));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->status=htmlspecialchars(strip_tags($this->status ?? ''));

  
        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');
  
        // bind values 
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":created", $this->timestamp);
  
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
  
    }

    function readAll($from_record_num, $records_per_page){
  
        // joining tables by using aliases: b = books, c = categories;
        $query = "SELECT b.id, b.title, b.author, b.category_id, c.name AS category_name, b.status 
                FROM books b
                JOIN categories c ON b.category_id = c.id
                ORDER BY b.title ASC
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

    function readOne(){
    
        $query = "SELECT
                    id, title, author, category_id, status
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
    
        $this->title = $row['title'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->status = $row['status'];

    }

    function update(){
  
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    title = :title,
                    author = :author,
                    category_id  = :category_id,
                    status  = :status

                WHERE
                    id = :id";
      
        $stmt = $this->conn->prepare($query);
      
        // posted values
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->author=htmlspecialchars(strip_tags($this->author));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->status=htmlspecialchars(strip_tags($this->status));

      
        // bind parameters
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':status', $this->status);

      
        // execute the query
        if($stmt->execute()){
            return true;
        }
      
        return false;
          
    }

    function delete(){
    
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
    
        if($result = $stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function searchBooks($search, $from_record_num, $records_per_page) { 
        $query = "SELECT b.id, b.title, b.author, b.category_id, c.name AS category_name, b.status 
                FROM " . $this->table_name . " b 
                JOIN categories c ON b.category_id = c.id 
                WHERE b.title LIKE ? OR b.author LIKE ? OR c.name LIKE ? 
                ORDER BY b.title ASC 
                LIMIT ?, ?";
        $stmt = $this->conn->prepare($query); 
        $search = "%{$search}%"; 
        $stmt->bindParam(1, $search, PDO::PARAM_STR); 
        $stmt->bindParam(2, $search, PDO::PARAM_STR); 
        $stmt->bindParam(3, $search, PDO::PARAM_STR); 
        $stmt->bindParam(4, $from_record_num, PDO::PARAM_INT); 
        $stmt->bindParam(5, $records_per_page, PDO::PARAM_INT); 
        $stmt->execute(); 
        return $stmt; 
    }
}
?>