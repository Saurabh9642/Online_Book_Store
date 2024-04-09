<?php
session_start();
require_once("Connection.php");
require 'smtp/PHPMailerAutoload.php';

function generateOrderContentAndSendEmail($bookName, $quantity, $unitPrice, $totalAmount, $email, $username) {
    // Get the current date
    $currentDate = new DateTime();
    
    // Add three days to the current date
    $deliveryDate = clone $currentDate;
    $deliveryDate->add(new DateInterval('P3D'));

    // Format the delivery date as "YYYY-MM-DD"
    $formattedDeliveryDate = $deliveryDate->format('Y-m-d');

    // Generate HTML content for the order
    $orderContent = '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Order Confirmation</title>
                        <style>
                            table {
                                border-collapse: collapse;
                                width: 100%;
                                margin-top: 50px;
                            }
                            th, td {
                                border: 1px solid #ddd;
                                padding: 8px;
                            }
                        </style>
                    </head>
                    <body>
                        <table>
                            <tr>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                            <tr>
                                <td>' . $bookName . '</td>
                                <td>' . $quantity . '</td>
                                <td>' . $unitPrice . '</td>
                                <td>' . $totalAmount . '</td>
                            </tr>
                        </table>
                        <h4>Book Delivery Date: ' . $formattedDeliveryDate . '</h4>
                    </body>
                    </html>';

    // Send verification email
    $subject = 'Book Buddies, Order Confirmation';
    $message = "Hello, " . $username . ". Your Order is Confirmed. The Book details are: <br>" . $orderContent;

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
    $customerid = $res['Customer_Id'];
    $phoneno = $res['Phoneno']; 
    $address = $res['Address'];
} else {
    echo "No user found with email: $email"; // You can handle this case as needed
    exit();
}

if(isset($_POST['submit'])){
    // Handle form submission
    // Retrieve form data
    $bookName = $_POST['bookname'];
    $dueDate = $_POST['dueDate'];
    $payeeName = $_POST['payeeName'];
    $address = $_POST['address'];
    $phonenumber = $_POST['phonenumber'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $unitPrice = $_POST['unitPrice'];
    $totalAmount = $_POST['totalAmount'];
    $upiID = $_POST['upiID'];
    $additionalNotes = $_POST['additionalNotes'];
    $paymethod=$_POST['paymentMethod'];
    $image=$_POST['product_Image'];

    // Insert order into database
    $insert = "INSERT INTO `order_book`(`ID`, `Customer_id`, `Image`, `Book_Name`, `Order_Date`, `Payee_Name`, `Address`, `Contact_number`, `Description`, `Quantity`, `price_unit`, `Total_amount`, `Pay_method`, `UPI_ID`, `Comments`) VALUES (NULL,'$customerid','$image','$bookName','$dueDate','$payeeName','$address','$phonenumber','$description','$quantity','$unitPrice','$totalAmount','$paymethod','$upiID','$additionalNotes')";
    
    if($connection->query($insert) === TRUE) {
        // Send verification email
        $result = generateOrderContentAndSendEmail($bookName, $quantity, $unitPrice, $totalAmount, $email, $username);
        if($result === 'Sent') {
            echo '<script>alert("Order Successful. Check the Email.")</script>';
            echo '<script>window.location.href = "Account.php";</script>';
            exit;
        } else {
            // Error sending email
            echo "Error sending email: " . $result;
        }
    } else {
        // Error inserting into database
        echo "Error: " . $connection->error;
    }
}
?>
