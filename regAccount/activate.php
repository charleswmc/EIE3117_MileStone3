


<!DOCTYPE html>
<html>
<head>
    <title>Please Activate</title>
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
            <a href="home.php" class="btn_home">
            <img src="../photo/polyu.png" width="30" height="30" class="d-inline-block align-top" alt="">
            EIE3117 - Integrated Project
            </a>
        </div>
        <ul class="nav justify-content-end">
        <li class="nav-item">
        <a href="../logout.php" class="btn btn-danger">Login Here</a>
        </li>
        </ul>
    </nav>
  <!-- Nav Bar-->
<?php
require_once "../config.php";

// check first if record exists
$sql = "SELECT id FROM users WHERE verification_code = ? and verified = '0'";
$stmt = $pdo->prepare( $sql );
$stmt->bindParam(1, $_GET['code']);
$stmt->execute();
$num = $stmt->rowCount();
 
if($num>0){
 
    // update the 'verified' field, from 0 to 1 (unverified to verified)
    $sql = "UPDATE users
                set verified = '1'
                where verification_code = :verification_code";
 
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':verification_code', $_GET['code']);
 
    if($stmt->execute()){
        // tell the user
        echo "<div>Your email is valid, thanks!. You may now login.</div>";
    }else{
        echo "<div>Unable to update verification code.</div>";
        //print_r($stmt->errorInfo());
    } 
}else{
    // tell the user he should not be in this page
    echo "<div>Your account have been verified already.</div>";
}
?>


</body>
</html>