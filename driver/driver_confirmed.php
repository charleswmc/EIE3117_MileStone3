<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
require_once "../config.php";
session_start();

 
// Attempt insert query execution
try{
    // Create prepared statement
    // $sql = "INSERT INTO persons (first_name, last_name, email) VALUES (:first_name, :last_name, :email)";
    // $sql = "UPDATE `users` SET `wallet`=(:walletAddr) WHERE `username` = (:username) ";
    $sql = "UPDATE `history` SET `status`= 1 ,  `driverName`=  (:driverName) WHERE `passengerName` = (:passengerName) AND`startTime` = (:startTime)";
    
    $stmt = $pdo->prepare($sql);
    

    // Bind parameters to statement
    $stmt->bindParam(':driverName', $param_driverName, PDO::PARAM_STR);
    $stmt->bindParam(':passengerName', $param_passengerName, PDO::PARAM_STR);
    $stmt->bindParam(':startTime', $param_startTime, PDO::PARAM_STR);

    $param_driverName = $_SESSION['username'];
    $param_passengerName = $_POST['passengerName'];
    $param_startTime = $_POST['startTime'];
    
    // Execute the prepared statement
    $stmt->execute();
    echo "Records inserted successfully.";
    header('Location: driver_confirmed_page.php'); 
    unset($stmt);
    unset($pdo);
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}
