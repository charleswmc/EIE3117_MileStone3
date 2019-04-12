<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
require_once "../config.php";
session_start();

 
// Attempt insert query execution
try{
    // Create prepared statement
    // $sql = "INSERT INTO persons (first_name, last_name, email) VALUES (:first_name, :last_name, :email)";
    $sql = "UPDATE `users` SET `wallet`=(:walletAddr) WHERE `username` = (:username) ";
    $stmt = $pdo->prepare($sql);
    

    // Bind parameters to statement

    $stmt->bindParam(':walletAddr', $_POST['walletAddr']);
    $stmt->bindParam(':username', $_SESSION['username']);
    
    // Execute the prepared statement
    if($stmt->execute())
    {
        echo "Records inserted successfully.";
        header("location: ../home.php");
    }
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}