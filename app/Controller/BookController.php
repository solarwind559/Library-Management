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
        } catch (Exception $e) {
            echo "Error borrowing book: " . $e->getMessage() . "<br>";
        }
    }

    // public function returnBook($book_id){
    //     try {
    //         // Delete the borrowed book record from the borrowed_books table
    //         $delete_query = "DELETE FROM borrowed_books WHERE book_id = ?";
    //         $stmt_delete = $this->conn->prepare($delete_query);
    //         $stmt_delete->execute([$book_id]);
    
    //         // Update the status of the book in the books table to indicate it's not borrowed
    //         $update_query = "UPDATE books SET status = 0 WHERE id = ?";
    //         $stmt_update = $this->conn->prepare($update_query);
    //         $stmt_update->execute([$book_id]);
    
    //         echo "<div class='alert alert-success alert-dismissable'>
    //             The book has been returned.
    //         </div><br>";
    //     } catch (Exception $e) {
    //         echo "Error returning book: " . $e->getMessage() . "<br>";
    //     }
    // }

    function returnBook($book_id) {
        try {
            $this->conn->beginTransaction();
    
            // Step 1: Delete from borrowed_books
            $delete_query = "DELETE FROM borrowed_books WHERE book_id = ?";
            $stmt_delete = $this->conn->prepare($delete_query);
            $stmt_delete->execute([$book_id]);
    
            // Step 2: Update status in books
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
    
}

