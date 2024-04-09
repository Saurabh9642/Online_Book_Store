<?php
session_start();
require_once("Connection.php");
require 'smtp/PHPMailerAutoload.php';

function generateOrderContentAndSendEmail($email, $username) {
    // Send verification email
    $subject = 'Book Buddies, Order Confirmation';
    $message = "Hello, " . $username . ". Your Order is Confirmed." ;

    return smtp_mailer($email, $subject, $message);
}

// Function to send email via SMTP
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
        return $mail->ErrorInfo;
    } else {
        return 'Sent';
    }
}

// Check if the user is logged in
if (!isset($_SESSION["login_sess"])) {
    // Redirect to the login page if not logged in
    header("Location: Register1.php");
    exit();
}

$email = $_SESSION["login_email"];

// Fetch user data from database
$findresult = mysqli_query($connection, "SELECT * FROM `register` WHERE Email_Id='$email' ");

// Check if query executed successfully
if (!$findresult) {
    echo "Error: " . mysqli_error($connection);
    exit();
}

// Check if user data exists
if (mysqli_num_rows($findresult) > 0) {
    $res = mysqli_fetch_array($findresult);
    $username = $res['Username'];
} else {
    echo "No user found with email: $email"; // You can handle this case as needed
    exit();
}

if(isset($_POST['submit']))
{
        // Send verification email
        $result = generateOrderContentAndSendEmail($email, $username);
        if($result === 'Sent') {
            echo '<script>alert("Order Successful.")</script>';
            echo '<script>window.location.href = "Account.php";</script>';
            exit;
        } else {
            // Error sending email
            echo "Error sending email: " . $result;
        }
}
?>
