<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["login_sess"])) {
    // Redirect to the login page if not logged in
    header("Location: Register1.php");
    exit();
}

include "Connection.php";

$email = $_SESSION["login_email"];

// Fetch user data from database
$findresult = mysqli_query($connection, "SELECT * FROM `register` WHERE Email_Id='$email' ");

// Check if query executed successfully
if (!$findresult) {
    // Log the error or display a user-friendly error message
    echo "Error: Unable to fetch user data. Please try again later.";
    exit();
}

// Check if user data exists
if (mysqli_num_rows($findresult) > 0) {
    $res = mysqli_fetch_assoc($findresult);
    $customer_id = $res['Customer_Id'];
    $Username = $res['Username'];
} else {
    // You can handle this case as needed
    echo "No user found with email: $email";
    exit();
}


if (isset($_POST['remove'])) {
    // Get the Sr_No of the item to be removed from the form
    $Sr_No = $_POST['ID'];

    // Prepare the SQL statement to delete the item from the cart
    $sql = "DELETE FROM `order_book` WHERE ID = ?";

    // Prepare and bind the statement
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $Sr_No);

    // Execute the statement
    if ($stmt->execute()) {
        // Item removed successfully, redirect back to the cart page
        echo '<script>alert("Order Cancelled.")</script>';
        echo '<script>window.location.href = "Account.php?Order_Cancelled";</script>';
    } else {
        // Error occurred during removal, display the error message
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Buddies</title>
    <!-- Css File -->
    <link rel="stylesheet" type="text/css" href="css/Order_bill.css" />
    <!--Favicon  -->
    <link rel="shortcut icon" href="simages/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="images/apple-touch-icon.png" type="image/x-icon" />
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css" />
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css" />
    <!-- Swiper Js Css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <style>
        /* Basic styling for the form */
        body {
            font-family: Arial, sans-serif;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 16px;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #35d0f7;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #5449f0;
        }
    </style>
</head>
<body>
    <!-- Preloader  -->
    <div class="preloader">
        <div class="preloader-img">
        </div>
    </div>
    <!-- Go To Top Button -->
    <div class="top-btn">
        <button id="top"><i class="fi fi-rr-chevron-double-up"></i></button>
    </div>
    <!-- Top Bar -->
    <div class="top-bar">
        <span >
            UP TO 60% OFF Book. <a href="./shop.php">SHOP NOW</a>
        </span>
    </div>
    <!-- Header -->
    <header class="header">
        <div class="left-side">
            <div class="menu" id="menu">
            </div>
            <div class="search" id="search">
            </div>
        </div>
        <div class="logo">
                <h1>Return Form </h1>
        </div>
        <div class="right-side">
            <div class="user">
                <i class="fi fi-rr-user"></i>
                <ul class="user-menu">
                    <li>
                        <a href="myaccount.php">
                            <div class="profile-picture">
                                <span><?php echo $Username; ?></span>
                            </div>
                        </a>
                    </li>
                    <li><a href="./logout.php">Logout</a></li>
                </ul>
            </div>
            <div class="cart">
                <a href="./cart.php">
                    <i class="fi fi-rr-shopping-cart"></i>
                </a>
            </div>
        </div>
    </header>
    <!-- Search Section -->
    <section class="search-section">
        <div class="close-icon" id="close-search">
        </div>
        <div class="search-form">
            <form action="#">
                <div class="input-field">
                    <i class="fi fi-rr-search"></i>
                    <input type="text" name="search-product" id="search-product" placeholder="Search for product..." />
                </div>
            </form>
        </div>
    </section>
    <br><br>
 
    <form action="return_process.php" method="post">
        <label for="order_id">Customer Id:</label>
        <input type="text" id="order_id" name="customer_id" required>

        <label for="order_id">Order ID:</label>
        <input type="text" id="order_id" name="order_id" required>
    
        <label for="book_name">Book Name:</label>
        <input type="text" id="book_name" name="book_name" required>
    
        <label for="reason">Reason for Return:</label>
        <textarea id="reason" name="reason" rows="4" required></textarea>
    
        <input type="submit" value="Submit Return Request">
    </form>
      
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="js/slider.js"></script>
    <script src="js/shopeScript.js"></script>    
</body>
</html>
