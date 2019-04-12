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
       	 <a href="../logout.php" class="btn btn-danger">Sign Out</a>
      	</li>
    	</ul>
  </nav>
  <!-- Nav Bar-->
<!-- <form action="insert.php" method="post"> -->
  <form action="updateWallet.php" method="post">
  <div class="form-group">
    <h1 align="center" for="walletAddr">Wallet Information</h1>
    <input class="form-control" name= "walletAddr" id="walletAddr" aria-describedby="emailHelp" placeholder="Enter Wallet">
    <small id="emailHelp" class="form-text text-muted">Please entry your wallet address.</small>
  </div>
 
  <button type="submit" class="btn btn-primary">Save</button>
</form>

</body>
</html>