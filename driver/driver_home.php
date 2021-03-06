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

  <br>
  <div class="form-group">
    <button type="button" onclick="window.location.href='./driver_confirmed_page.php'" class="btn btn-info btn-outline-dark btn-lg btn-block">Confirmed Ride</button>
  </div>
  <div class="form-group">
    <button type="button" onclick="window.location.href='./driver_history.php'" class="btn btn-outline-dark btn-lg btn-block">History</button>
  </div>
  <h3>Current Requests</h3>
 <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Passenger Name</th>
                <th>Start Time</th>
                <th>Confirm</th>
            </tr>
<?php
    $sql = "SELECT * FROM history WHERE status = 0 ";

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
                echo "<form id='form".++$count."' action='driver_confirmed.php' method='post'>";

                echo "<td>";
                echo $record['passengerName'];
                echo "<input type='hidden' name='passengerName' value='".$record["passengerName"]."' /> ";
                echo "</td>";

                echo "<td>";
                echo $record['startTime']; 
                echo "<input type='hidden' name='startTime' value='".$record['startTime']."' /> ";
                echo "</td>";

                echo "<td>";
                echo "<button type='submit' class='btn btn-primary'>Confirm</button>";
                echo "</td>";

                echo "</form>";
                echo "</tr>";
            }
        
                
        }
    }
}
?>

        </thead>
  </table>




<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

