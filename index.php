<?php
// Initialize the session
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 365);
ini_set('session.gc-maxlifetime', 60 * 60 * 24 * 365);
ini_set("session.cookie_httponly", 1);
ini_set('session.cookie_secure', 1);

session_start();
//echo $_COOKIE["username"];
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $verified = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password, verified FROM users WHERE username = :username";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        $verified = $row["verified"];
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session

                            // Store data in session variables
                            //$_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["verified"] = $verified;

                            if($verified == 1){
                                $_SESSION["verified"] = 1;
                                $secretKey = "6LeKd5gUAAAAAMzHFOf1exDtgXXetWSBmv3Mjxu1";
                                $responseKey = $_POST['g-recaptcha-response'];
                                $userIP = $_SERVER['REMOTE_ADDR'];

                                $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$responseKey."&remoteip=".$userIP;
                                $response = file_get_contents($url);                                
                                $response = json_decode($response);
                                if ($response->success){
                                    $_SESSION["loggedin"] = true;
                                    header("location: home.php");
                                }
                                else{                                    
                                    $message = "Please complete the reCAPTCHA test!!";
                                    echo "<script type='text/javascript'>alert('$message');</script>";
                                    //unset($_SESSION["username"]);
                                    //unset($_SESSION["verified"]);
                                    //unset($_SESSION["id"]);
                                    //unset($_SESSION["loggedin"]);
                                }
                            }else {
                                header("location: regAccount/pleaseactivate.php");
                            }
                            
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }


    // Close connection
    unset($pdo);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
                <img src="photo/polyu.png" width="30" height="30" class="d-inline-block align-top" alt="">
                EIE3117 - Integrated Project
            </a>
        </div>
    </nav>
    <!-- Nav Bar-->
    <div class="heading">
        <h1>Welcome to Weder</h1>
        Milestone 3
    </div> 
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="g-recaptcha" data-sitekey="6LeKd5gUAAAAAFtLffIlymsyn0PysaIAhOS9S4R3"></div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="regAccount/index.php">Sign up now</a>.</p>
            <p><a href="forgetpw.php">Forget password?</a></p>
        </form>
    </div>
    <!--js-->
    <script src="https://www.google.com/recaptcha/api.js"></script>
</body>
</html>

