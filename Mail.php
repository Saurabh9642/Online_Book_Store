<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once("Connection.php");
require 'smtp/PHPMailerAutoload.php';

function generateVerificationToken($length = 6)
{
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= mt_rand(0, 9); // Generate a random digit from 0 to 9
    }
    
    return $otp;
}

// Generate a random customer ID
function generateRandomDigits($length = 6) {
    $digits = '';
    for ($i = 0; $i < $length; $i++) {
        $digits .= mt_rand(0, 9); // Generate a random digit from 0 to 9
    }
    return $digits;
}

// Usage example:
$customerId = generateRandomDigits(6); // Generates a 6-digit random number
//echo $customerId; // Output the generated customer ID


function sendVerificationEmail($email, $verificationToken) {
    $subject = 'Email Verification';
    $message = "Hello,\n\nPlease use the following OTP for email verification: $verificationToken";
    
    smtp_mailer($email, $subject, $message);
}

if(isset($_POST['submit'])) {
    $userotp = $_POST['userotp'];
    $query = "SELECT * FROM `register` WHERE OTP='$userotp' ";
    $res = mysqli_query($connection, $query);

    if(mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $verificationTokenFromDatabase = $row['OTP'];

        if ($userotp === $verificationTokenFromDatabase) {
            // Set the Customer_Id session variable after successful verification
            $_SESSION["Customer_Id"] = $row['Customer_Id'];
            echo '<script>alert("Sign_Up Successful")</script>';
            echo '<script>window.location.href = "Register1.php";</script>';
            exit();
        } else {
            header("Location: Mail.php?error=invalid_otp");
            exit();
        }
    } else {
        header("Location: Mail.php?error=otp_not_found");
        exit();
    }
}

if(isset($_POST['new'])) {
    $Username = $_POST['Username'];
    $Email_Id = $_POST['Email_Id'];
    $Password = $_POST['Password'];

     // Password validation
     if (!preg_match('/[A-Z]/', $Password) || !preg_match('/[^\w\s]/', $Password)) {
        echo '<script>alert("Password must contain at least one uppercase letter and one symbol.")</script>';
        echo '<script>window.location.href = "Register1.php";</script>';
        exit();
    }

    $checkQuery = "SELECT * FROM `register` WHERE Email_Id='$Email_Id'";
    $checkResult = mysqli_query($connection, $checkQuery);
    if(mysqli_num_rows($checkResult) > 0) {
        echo '<script>alert("Email already registered. Please use a different email address.")</script>';
        echo '<script>window.location.href = "Register1.php";</script>';
        exit(); // Stop execution if the email is already registered
    }

    $expirationTime = date('Y-m-d H:i:s', strtotime('+1 minute'));
        $verificationToken = generateVerificationToken();
        $sql = "INSERT INTO `register`(`Sr_No`, `Customer_Id`, `Username`, `Email_Id`, `User_Password`, `OTP`, `ExpirationTime`) 
                VALUES (NULL, '$customerId', '$Username', '$Email_Id', '$Password', '$verificationToken', '$expirationTime')";

    if($connection->query($sql) === TRUE) {
        sendVerificationEmail($Email_Id, $verificationToken);
        // Success message
        
        //echo "Verification email sent successfully. Please check your email.";
    } else {
        // Error message
        echo "Error: " . $sql . "<br>" . $connection->error;
    }

    if(mysqli_stmt_affected_rows($stmt) == 1) {
        // After successfully registering the user, retrieve the Customer_Id and set the session variable
        $customer_id = mysqli_insert_id($connection); // Assuming Customer_Id is auto-generated upon registration
        $_SESSION["Customer_Id"] = $customer_id;
        // Redirect the user to another page or perform any other action
        header("Location: Account.php");
        exit;
    } else {
        // Handle registration failure
        echo "Registration failed.";
    }
}


function smtp_mailer($to, $subject, $msg) {
    $mail = new PHPMailer(); 
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'tls'; 
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587; 
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Username = "saurabhjadhav9642@gmail.com";
    $mail->Password = "hubejqkszeehqbyj";
    $mail->SetFrom("saurabhjadhav9642@gmail.com", "Book Buddies");
    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->AddAddress($to);
    $mail->SMTPOptions = array('ssl'=>array(
        'verify_peer'=>false,
        'verify_peer_name'=>false,
        'allow_self_signed'=>false
    ));
    
    if(!$mail->Send()) {
        echo $mail->ErrorInfo;
    } else {
        return 'Sent';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            margin: 100px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        input[type="text"]:focus {
            border-color: #007bff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .btn-submit {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: #dc3545;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Email Verification</h1>
        <p class="text-muted">Please enter the OTP sent to your email address to complete the verification process.</p>
        <form action="Mail.php" method="post">
            <div class="form-group">
                <label for="userotp">Enter OTP:</label>
                <input type="text" id="userotp" name="userotp" placeholder="Enter OTP" required>
                <?php if(isset($_GET['error']) && $_GET['error'] === 'invalid_otp'): ?>
                    <p class="error-message">Invalid OTP. Please try again.</p>
                <?php elseif(isset($_GET['error']) && $_GET['error'] === 'otp_not_found'): ?>
                    <p class="error-message">OTP not found. Please check your email or request a new OTP.</p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn-submit" name="submit">Submit</button>
        </form>
    </div>
</body>
</html>

