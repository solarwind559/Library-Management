<?php
class BookController{
    private $conn; // Database connection    private $conn;
    private $table_name = "borrowed_books";
    public $user_id;
    public $book_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function showBorrowedBooks(){
        $query = 
        // "SELECT
        //             borrow_id, book_id, user_id, borrow_date, return_date
        //         FROM
        //             " . $this->table_name . "
        //         ORDER BY
        //             book_id ASC
        //         LIMIT
        //             10";

        "SELECT borrowed_books.*, CONCAT(users.name, ' ', users.surname) AS full_name, books.title
        FROM borrowed_books
        JOIN users ON borrowed_books.user_id = users.id
        JOIN books ON borrowed_books.book_id = books.id";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    
    }

    public function borrowBook($user_id, $book_id) {
        try {
            // Insert into borrowed_books table
            $query = "INSERT INTO borrowed_books (user_id, book_id, borrow_date, return_date) VALUES (?, ?, CURDATE(),  CURDATE() + INTERVAL 14 DAY)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$user_id, $book_id]);

            echo "<div class='alert alert-success alert-dismissable'>
            The book has been borrowed.
            </div><br>";
        } catch (Exception $e) {
            echo "Error borrowing book: " . $e->getMessage() . "<br>";
        }
    }
}

