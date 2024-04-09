<?php

// Start session and include database connection
session_start();
require_once("Connection.php");

// Get user email from session
$email = $_SESSION["login_email"];

// Fetch user data from database
$findresult = mysqli_query($connection, "SELECT * FROM `register` WHERE Email_Id='$email' ");


// Check if user data exists
if (mysqli_num_rows($findresult) > 0) 
{
    $res = mysqli_fetch_assoc($findresult);
    $customer_id = $res['Customer_Id'];
} 


// Generate a random cart Id
function generateRandomDigits($length = 4)
{
    $digits = '';
    for ($i = 0; $i < $length; $i++) {
        $digits .= mt_rand(0, 9); // Generate a random digit from 0 to 9
    }
    return $digits;
}
        $Cart_Id = generateRandomDigits(4); 

// Handle adding to cart functionality
        $product_id = intval($_POST["product_id"]);
        $quantity = intval($_POST["quantity"]);
        $product_price = floatval($_POST["product_price"]);
        $image = mysqli_real_escape_string($connection, $_POST["product_Image"]);
        $title = mysqli_real_escape_string($connection, $_POST["product_title"]);

        // Calculate total price
        $totalPrice = $product_price * $quantity;

        // Prepare and execute the SQL statement using a prepared statement
        $sql = "INSERT INTO `cart`(`Sr_No`, `Cart_Id`, `Customer_Id`, `Image`, `Book_Name`, `Book_Id`, `Quantity`, `Price`, `Total`) VALUES (NULL,'$Cart_Id','$customer_id','$image','$title','$product_id','$quantity','$product_price','$totalPrice')";
        // Check if the insertion was successful
        if(isset($_POST['cart']))
        {
            if($connection->query($sql)==TRUE)
            {
              echo '<script>alert("Book added to cart successfully")</script>';
              echo '<script>window.location.href = "shop.php";</script>';
            }
            else
            {
                echo "Welcome.....";
            }
        }

?>
