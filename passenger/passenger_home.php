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
    .form-group { text-align: center; }
	  .btn_home:link { color: white; text-decoration: none; font-weight: normal }
	  .btn_home:visited { color: white; text-decoration: none; font-weight: normal }
	  .btn_home:active { color: white; text-decoration: none }
	  .btn_home:hover { color: white; text-decoration: none; font-weight: none }
	</style>
</head>
<body>
  <!--Nav Bar -->
<?php
if(isset($_SESSION["disputeComplete"])){
  if ($_SESSION['disputeComplete']){
    echo "<script type='text/javascript'>alert('Records dispute successfully!')</script>";
    $_SESSION['disputeComplete'] = false;
	}
}
      
    
  ?>

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
  <form action="request.php" method="post">
    <div class="form-group">
      <button type="submit"  class="btn btn-success btn-lg btn-block">Request</button>
      Private Key: <input name="privateKey"/>
    </div>
  </form>
  <button type="button" onclick="window.location.href='./history.php'" class="btn btn-outline-dark btn-lg btn-block">History</button>

</body>
</html>