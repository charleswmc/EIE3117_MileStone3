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
    $sql = "UPDATE `history` SET `status`= 4 ,  `reason`=  (:reason) WHERE `passengerName` = (:passengerName) AND`startTime` = (:startTime)";
    
    $stmt = $pdo->prepare($sql);
    // Bind parameters to statement
    $stmt->bindParam(':reason', $param_reason, PDO::PARAM_STR);
    $stmt->bindParam(':passengerName', $param_passengerName, PDO::PARAM_STR);
    $stmt->bindParam(':startTime', $param_startTime, PDO::PARAM_STR);
    
    $param_reason = $_POST['disputeReason'];
    $param_passengerName = $_SESSION['dispute']['passengerName'];
    $param_startTime = $_SESSION['dispute']['startTime'];
    
    // Execute the prepared statement
    $stmt->execute();
    unset($stmt);
    unset($pdo);

    $_SESSION['disputeComplete'] = true;
    header("location: passenger_home.php");

    // header('Location: history.php'); 
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}
