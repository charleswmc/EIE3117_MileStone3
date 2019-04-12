<?php
session_start();
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
  <form action="passenger_dispute.php" method="post">
    <div class="form-group">
      <?php
      $_SESSION['dispute']['passengerName'] = $_POST['passengerName'];
      $_SESSION['dispute']['driverName'] = $_POST['driverName'];
      $_SESSION['dispute']['startTime'] = $_POST['startTime'];
      $_SESSION['dispute']['finishTime'] = $_POST['finishTime'];
      $_SESSION['dispute']['fare'] = $_POST['fare'];
      ?>
      
      <h3>Dispute Record</h3>
      <h5>Driver: <?php echo $_POST["driverName"]; ?></h5>
      <h5>StartTime: <?php echo $_POST["startTime"]; ?></h5>
      <h5>FinishTime: <?php echo $_POST["finishTime"]; ?></h5>
      <h5>Fare : <?php echo $_POST["fare"]; ?></h5>
     
    </div>
    <div class="form-group">
      <h3 for="exampleFormControlTextarea1">Reason</h3>
      <textarea name= "disputeReason" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
    
    <button type="submit"   class="btn btn-warning btn-lg btn-block">Dispute</button>
  </form>
  <button type="button"  onclick="window.location.href='./passenger_home.php'" class="btn btn-danger btn-lg btn-block">Cancel</button>


</body>
</html>