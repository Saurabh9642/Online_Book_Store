<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once("Connection.php");

// Check if user is logged in
if (!isset($_SESSION["login_sess"])) {
    header("location: Register1.php");
    exit();
}

// Check if session email is set
if (!isset($_SESSION["login_email"])) {
    echo "Session email not set."; // You can handle this error as needed
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
    $Username = $res['Username'];
    $cutomerid = $res['Customer_Id'];
    $category = $res['category']; 
    $class = $res['class'];
    $phoneno = $res['Phoneno']; 
    $Address = $res['Address'];   

} else {
    echo "No user found with email: $email"; // You can handle this case as needed
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bookstore Feedback</title>
<link rel="stylesheet" href="css/Feedback.css">
</head>
<body background="img/Background.jpg">
<div class="container">
    <h2>Feedback Form</h2>
    <form method="post">
        <input type="hidden" name="customerid" value="<?php echo $cutomerid; ?>" >
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $Username; ?>" placeholder="Enter Name" required>

        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder="Enter Email" required>

        <label for="phone">Your Phone Number:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $phoneno; ?>"  placeholder="Enter Phone Number" required readonly>

        <label for="visit">How often do you visit our bookstore?</label>
        <select id="visit" name="visit" required>
            <option value="">Select...</option>
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
            <option value="rarely">Rarely</option>
        </select>

        <label for="recommend">Would you recommend our bookstore to a friend?</label>
        <input type="radio" id="recommend_yes" name="recommend" value="yes" required> Yes
        <input type="radio" id="recommend_no" name="recommend" value="no"> No
        <br><br>
        <label for="feedback">Your Feedback:</label>
        <textarea id="feedback" name="feedback" required></textarea>

        <input type="submit" value="Submit Feedback" name="submit">
    </form>
    <?php
    if(isset($_POST['submit'])){
        $cutomer_id=$_POST['customerid'];
        $name=$_POST['name'];
        $Email=$_POST['email'];
        $contactno=$_POST['phone'];
        $visit=$_POST['visit'];
        $recommend=$_POST['recommend'];
        $feedback=$_POST['feedback'];
        
        $insert="INSERT INTO `feedback`(`Customer_Id`, `Name`, `Email`, `Phone_No`, `vist`, `recommend`, `Feedback`)  VALUES ('$cutomer_id','$name','$Email','$contactno','$visit','$recommend','$feedback')";
        
        $checkQuery = "SELECT * FROM `feedback` WHERE Email='$Email'";
        $checkResult = mysqli_query($connection, $checkQuery);
        if(mysqli_num_rows($checkResult) > 0) {
            echo '<script>alert("Email already Feedback Submited. Please use a different email address.")</script>';
            echo '<script>window.location.href = "Account.php";</script>';
            exit(); // Stop execution if the email is already registered
        }
        
        if($connection->query($insert) === TRUE) {
            echo '<script>alert("Feedback Submitted")</script>';
            echo '<script>window.location.href = "Account.php";</script>';
        } else {
           echo "Error: " . $insert . "<br>" . $connection->error;
        }
    }
    ?>
</div>
</body>
</html>
