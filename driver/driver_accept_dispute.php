<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
require_once "../config.php";
require("MyWallet.class.php");
session_start();

$SdrAddr = $SdrPrivKey = "";
$RvrAddr = "";
$TranAmnt = $StartTime = "";

if(!isset($_POST['privateKey']) || $_POST['privateKey'] == "")
{
    echo "Private key have not provided.";
    echo "<button onclick=\"window.window.location.href='driver_history.php'\"\>";
}
else
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dispute</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <style type="text/css">
    body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
        .heading { padding: 20px; }
        .btn_home:link { color: white; text-decoration: none; font-weight: normal }
        .btn_home:visited { color: white; text-decoration: none; font-weight: normal }
        .btn_home:active { color: white; text-decoration: none }
        .btn_home:hover { color: white; text-decoration: none; font-weight: none }
    </style>
</head>
<body>    
    <div>
        <button type="button" class="btn btn-success" onclick="window.location.href='driver_home.php'">Dispute Success! Back to home page.</button>
    </div>

<?php
    $GLOBALS['SdrPrivKey'] = $_POST["privateKey"];
    $GLOBALS['TranAmnt'] = $_POST['fare'];
    $GLOBALS['StartTime'] = $_POST['startTime'];

    // Find driver's bitcoin account address
    // Prepare a select statement
    $sql = "SELECT wallet FROM users WHERE username = :username";

    if($stmt = $pdo->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

    // Set parameters
    $param_username = trim($_SESSION["username"]);

    // Attempt to execute the prepared statement
    if($stmt->execute()){
        if($record = $stmt->fetch()){
            $GLOBALS['SdrAddr'] = $record["wallet"];
        }
    }
    unset($stmt);
    }

    // Find passenger's bitcoin account address
    // Prepare a select statement
    $sql = "SELECT wallet FROM users WHERE username in (select passengerName from history where driverName = :username and startTime = :startTime)";

        if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
        $stmt->bindParam(":startTime", $param_startTime, PDO::PARAM_STR);

        // Set parameters
        $param_username = trim($_SESSION["username"]);
        $param_startTime = $GLOBALS['StartTime'];

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            if($record = $stmt->fetch()){
                $GLOBALS['RvrAddr'] = $record["wallet"];
            }
        }
        unset($stmt);
    }

    $wallet = new MyWallet($GLOBALS['SdrAddr']);
    $wallet->sendPayment($GLOBALS['SdrPrivKey'], $GLOBALS['RvrAddr'], $GLOBALS['TranAmnt']);


    // Attempt insert query execution
    try{
        // Create prepared statement
        // $sql = "INSERT INTO persons (first_name, last_name, email) VALUES (:first_name, :last_name, :email)";
        // $sql = "UPDATE `users` SET `wallet`=(:walletAddr) WHERE `username` = (:username) ";
        $sql = "UPDATE `history` SET `status`= 5 WHERE `passengerName` = (:passengerName) AND`startTime` = (:startTime)";
        
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
        unset($stmt);
        unset($pdo);
    } catch(PDOException $e){
        die("ERROR: Could not able to execute $sql. " . $e->getMessage());
    }


?>
</body>
</html>

