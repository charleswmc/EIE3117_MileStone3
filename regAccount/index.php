<?php
// Include config file
require_once "../config.php";
require_once ("../PHPMailer/PHPMailer.php");

//session_start();
//REQUIRE_ONCE "PHPmailer";
// Define variables and initialize with empty values
$username = $password = $confirm_password = $phoneNumber = $email = $verified = $verification_code = $fullname = "";            //data need to be stored in the users database
$username_err = $password_err = $confirm_password_err = $phoneNumber_err = $email_err = $verified_err = $fullname_err = "";

$verified = 0;
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = :username";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        unset($stmt);
    }
    // Validate fullname
    if(empty(trim($_POST["fullname"]))){
        $fullname_err = "Please enter your full name.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE fullname = :fullname";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":fullname", $param_fullname, PDO::PARAM_STR);

            // Set parameters
            $param_fullname = trim($_POST["fullname"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $fullname_err = "You have registered an account before.";
                } else{
                    $fullname = trim($_POST["fullname"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        unset($stmt);
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    //Validate phone Number
    if(empty(trim($_POST["phoneNumber"]))){
        $phoneNumber_err = "Please enter your phone number.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE phoneNumber = :phoneNumber";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":phoneNumber", $param_phoneNumber, PDO::PARAM_STR);

            // Set parameters
            $param_phoneNumber = trim($_POST["phoneNumber"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $phoneNumber_err = "This phone number is already used.";
                } else{
                    $phoneNumber = trim($_POST["phoneNumber"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    } 
    /*else{
        $phoneNumber = trim($_POST["phoneNumber"]);
    }*/

    // Validate Email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email";
    } else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        echo "Your email address is not valid!";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = :email";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $email_err = "This email is already used.";
                } else{
                    $email = trim($_POST["email"]);
                    //$verification_code = md5($email);
                    //setcookie("c_email", $_POST["email"], time()+3600);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }   

        /*else{
        $email = trim($_POST["email"]);
        }*/

    // Check input errors before inserting in database
    if(empty($username_err) && empty($fullname_err) && empty($password_err) && empty($confirm_password_err) && empty($phoneNumber_err) && empty($email_err) && empty($verified_err) && empty($verification_code)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, fullname, password, phoneNumber, email, verified, verification_code) VALUES (:username, :fullname, :password, :phoneNumber, :email, :verified, :verification_code)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":fullname", $param_fullname, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":phoneNumber", $param_phoneNumber, PDO::PARAM_STR);
            $stmt->bindParam(":verified", $param_verified, PDO::PARAM_STR);
            $stmt->bindParam("verification_code", $param_verification_code, PDO::PARAM_STR);

            // Set parameters
            $param_username = $username;
            $param_fullname = $fullname;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_email = $email;
            $param_phoneNumber = $phoneNumber;
            $param_verified = $verified;
            $param_verification_code = md5($email);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: pleaseactivate.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
}

/*$verification_code = md5($email);
$verificationLink = "https://eie3117black.cf/milestone3/regAccount/activate.php?code=" . $verification_code;
 
                $htmlStr = "";
                $htmlStr .= "Hi " . $username . "\r\n\n";
 
                $htmlStr .= "Please click the link below to activate your account. \r\n\n";
                $htmlStr .= "{$verificationLink}";


$to = $email;
$subject = "Email Verification!!!!";
$header = "From: eie3117group7b@gmail.com";
//$header = "From: eie3117group7b@gmail.com" . "\r\n" . "CC: somebodyelse@example.com";

mail($to, $subject, $htmlStr, $header);*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
        .btn_home:link{ color: white; text-decoration: none; font-weight: normal }
        .btn_home:visited{ color: white; text-decoration: none; font-weight: normal }
        .btn_home:active{ color: white; text-decoration: none }
        .btn_home:hover{ color: white; text-decoration: none; font-weight: none }
        #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
    </style>
</head>
<body>
    <!--Nav Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" >
        <div class="navbar-brand" >
            <a href="../home.php" class="btn_home">
                <img src="../photo/polyu.png" width="30" height="30" class="d-inline-block align-top" alt="">
                EIE3117 - Integrated Project 
            </a>
            
        </div>

    </nav>
    <!-- Nav Bar-->
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($fullname_err)) ? 'has-error' : ''; ?>">
                <label>Full Name</label>
                <input type="text" name="fullname" class="form-control">
                <span class="help-block"><?php echo $fullname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($phoneNumber_err)) ? 'has-error' : ''; ?>">
                <label>Phone Number (HK phone number (8 digit))</label>
                <input type="tel" pattern="\d{8}" name="phoneNumber" class="form-control">
                <span class="help-block"><?php echo $phoneNumber_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
                <input type="submit" class="btn btn-primary" value="NEXT">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="../login.php">Login here</a>.</p>
        </form>
    </div>
</body>
</html>
