<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
require_once "../config.php";
session_start();

if(!isset($_POST['privateKey']) || $_POST['privateKey'] == "")
{
    echo "Private key have not provided.";
    echo "<button onclick=\"window.window.location.href='passenger_home.php'\"\>";
}
else
{
    // Attempt insert query execution
    try{
        // Create prepared statement
        // $sql = "INSERT INTO persons (first_name, last_name, email) VALUES (:first_name, :last_name, :email)";
        $sql = "INSERT INTO history( passengerName, startTime, status, passenger_pk) VALUES (:username,:date_time, 0, :privateKey)";
        $stmt = $pdo->prepare($sql);
        
        date_default_timezone_set("Asia/Hong_Kong");
        $current_date = date("Y-m-d H:i:s");

        // Bind parameters to statement
        $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
        $stmt->bindParam(":date_time", $param_datetime, PDO::PARAM_STR);
        $stmt->bindParam(":privateKey", $param_privateKey, PDO::PARAM_STR);

        $param_username = $_SESSION['username'];
        $param_datetime = $current_date;
        $param_privateKey = $_POST['privateKey'];
        
        // Execute the prepared statement
        $stmt->execute();
        $_SESSION['requested'] =  true;
        header("Location: passenger_home.php");
        unset($stmt);
        unset($pdo);
       exit;
    } catch(PDOException $e){
        die("ERROR: Could not able to execute $sql. " . $e->getMessage());
    } 
}
?>