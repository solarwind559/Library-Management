<?php

namespace App\Controllers;

include_once(__DIR__ . '/../Model/Book.php');


class BookController{
    private $conn; // Database connection
    private $table_name = "borrowed_books";
    public $user_id;
    public $book_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function showBorrowedBooks(){

        $query = 
        "SELECT
        borrowed_books.*,
        CONCAT(users.name, ' ', users.surname) AS full_name,
        books.id AS book_id,
        books.title AS book_name,
        GROUP_CONCAT(books.title SEPARATOR ',<br>') AS book_names,
        books.title
        FROM
            borrowed_books
        JOIN users ON borrowed_books.user_id = users.id
        JOIN books ON borrowed_books.book_id = books.id
        GROUP BY borrowed_books.borrow_id";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;

        $this->title = $row['title'];
    
    }

    public function getBorrowerDetails($book_id) {
        $query = "
        SELECT
            users.id AS user_id,
            CONCAT(users.name, ' ', users.surname) AS full_name
        FROM
            borrowed_books
        JOIN users ON borrowed_books.user_id = users.id
        WHERE
            borrowed_books.book_id = ?
        LIMIT 1";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$book_id]);
    
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
        

    public function borrowBook($user_id, $book_id) {
        try {
            // Insert into borrowed_books table and update status in books table
            $query = "INSERT INTO borrowed_books (user_id, book_id, borrow_date, return_date)
                    VALUES (?, ?, CURDATE(), CURDATE() + INTERVAL 14 DAY);

                    UPDATE books
                    SET status = 1
                    WHERE id = ?;
                ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$user_id, $book_id, $book_id]); //we pass $book_id twice, one for each table. You can directly use this $book_id to update the status of the corresponding book in the books table.

            echo "<div class='alert alert-success alert-dismissable'>
            The book has been borrowed.
            </div><br>";
            echo "<meta http-equiv='refresh' content='5;assign_book_to_user.php'>";
        } catch (Exception $e) {
            echo "Error borrowing book: " . $e->getMessage() . "<br>";
        }
    }

    function returnBook($book_id) {
        try {
            $this->conn->beginTransaction();
    
            // Delete from borrowed_books
            $delete_query = "DELETE FROM borrowed_books WHERE book_id = ?";
            $stmt_delete = $this->conn->prepare($delete_query);
            $stmt_delete->execute([$book_id]);
    
            // Update status in books
            $update_query = "UPDATE books SET status = 0 WHERE id = ?";
            $stmt_update = $this->conn->prepare($update_query);
            $stmt_update->execute([$book_id]);
    
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function setStatement($stmt) {
        $this->stmt = $stmt;
    }

    public function searchBooks($keyword) {
        $books = Book::search($keyword);
        include 'views/book_list.php';
    }
    
}

