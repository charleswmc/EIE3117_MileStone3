<?php
session_start();
require_once "../config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
} 


?>

<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
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
  <!--Nav Bar -->

  <nav class="navbar navbar-dark bg-dark sticky-top" >
      <div class="navbar-brand" >
        <a href="../home.php" class="btn_home">
          <img src="../photo/polyu.png" width="30" height="30" class="d-inline-block align-top" alt="">
          EIE3117 - Integrated Project
        </a>
      </div>
      <ul class="nav justify-content-end">
        <li class="nav-item">
          <button onclick="window.location.href='.././wallet/save-wallet.php'" type="button" class="btn btn-info">Wallet</button>
         <a href="../logout.php" class="btn btn-danger">Sign Out</a>
        </li>
      </ul>
  </nav>
  <!-- Nav Bar-->

  

 <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Passenger Name</th>
                <th>Driver Name</th>
                <th>Start Time</th>
                <th>Finish Time</th>
                <th>Fare</th>
                <th>reason</th>
            </tr>
<?php

$sql = "SELECT * FROM history WHERE status = 4 and driverName = :username";

    if($stmt = $pdo->prepare($sql)){
    $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
    $param_username = $_SESSION["username"];


    if($stmt->execute())
    {
        if($stmt->rowCount() >= 1)
        {
            $count = 0;
            $records = $stmt->fetchAll();
       
            foreach ($records as $record) {
                
                echo "<tr>";
                echo "<form method='post'>";

                echo "<td>";
                echo $record['passengerName'];
                echo "<input type='hidden' name='passengerName' value='".$record["passengerName"]."' /> ";
                echo "</td>";

                echo "<td>";
                echo $record['driverName'];
                echo "<input type='hidden' name='driverName' value='".$record["driverName"]."' /> ";
                echo "</td>";

                echo "<td>";
                echo $record['startTime']; 
                echo "<input type='hidden' name='startTime' value='".$record["startTime"]."' /> ";
                echo "</td>";

                echo "<td>";
                echo $record['finishTime'];
                echo "<input type='hidden' name='finishTime' value='".$record["finishTime"]."' /> ";
                echo "</td>";

                echo "<td>";
                echo $record['fare'];
                echo "<input type='hidden' name='fare' value='".$record["fare"]."' /> ";
                echo "</td>";

                echo "<td>";
                echo $record['reason'];
                echo "</td>";

                echo "<td>";
                echo "<div><button type='submit' onclick=\"javascript: form.action='driver_accept_dispute.php';\" class='btn  btn-danger'>Accept dispute</button></div>";
                echo "Private Key: <input name='privateKey'/>";
                echo "</td>";

                echo "<td>";
                echo "<button type='submit' onclick=\"javascript: form.action='driver_reject_dispute.php';\" class='btn  btn-warning'>Reject dispute</button>";
                echo "</td>";

                echo "</form>";
                echo "</tr>";                
            }
        
                
        }
    }
    unset($stmt);
}

?>

<?php

$sql = "SELECT * FROM history WHERE (status = '3' OR  status = '5' OR status = '6') and driverName = :username";

    if($stmt = $pdo->prepare($sql)){
  $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
    $param_username = $_SESSION["username"];


    if($stmt->execute())
    {
        if($stmt->rowCount() >= 1)
        {
            $count = 0;
            $records = $stmt->fetchAll();
       
            foreach ($records as $record) {
                
                $_SESSION['passengerName'] = $record['passengerName'];
                $_SESSION['startTime'] = $record['startTime'];
                echo "<tr>";

                echo "<td>";
                echo $record['passengerName'];
                echo "</td>";

                  echo "<td>";
                echo $record['driverName'];
                echo "</td>";

                echo "<td>";
                echo $record['startTime']; 
                echo "</td>";


                echo "<td>";
                echo $record['finishTime'];
                echo "</td>";

                echo "<td>";
                echo $record['fare'];
                echo "</td>";

                echo"<td></td>";

                if ($record['status'] == '3'){
                  echo "<td>";
                  echo "completed";
                  echo "</td>";
                }
                else if ($record['status'] == '5'){
                  echo "<td>";
                  echo "Dispute Accepted";
                  echo "</td>";
                }
                else if ($record['status'] == '6'){
                  echo "<td>";
                  echo "Dispute Rejected";
                  echo "</td>";
                }

                echo "</tr>";                
            }
        
                
        }
    }
    unset($stmt);
    unset($pdo);
}

?>

        </thead>
 
  </table>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

