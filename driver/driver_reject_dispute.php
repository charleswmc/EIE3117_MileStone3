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
    $sql = "UPDATE `history` SET `status`= 3 WHERE `passengerName` = (:passengerName) AND`startTime` = (:startTime)";
    
    $stmt = $pdo->prepare($sql);
    date_default_timezone_set("Asia/Hong_Kong");
    $current_date = date("Y-m-d H:i:s");

    // Bind parameters to statement
    $stmt->bindParam(':passengerName', $param_passengerName, PDO::PARAM_STR);
    $stmt->bindParam(':startTime', $param_startTime, PDO::PARAM_STR);

    $param_passengerName = $_POST['passengerName'];
    $param_startTime = $_POST['startTime'];
    
    // Execute the prepared statement
    $stmt->execute();
    header('Location: driver_history.php'); 
    unset($stmt);
    unset($pdo);
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}
