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
    echo "Error: " . mysqli_error($connection);
    exit();
}

// Check if user data exists
if (mysqli_num_rows($findresult) > 0) {
    $res = mysqli_fetch_array($findresult);
    $Username = $res['Username'];
    $cutomerid = $res['Customer_Id'];
    $phoneno = $res['Phoneno']; 
    $address = $res['Address'];

} else {
    echo "No user found with email: $email"; // You can handle this case as needed
    exit();
}


if (isset($_POST['remove'])) {
    // Get the Sr_No of the item to be removed from the form
    $Sr_No = $_POST['Sr_No'];

    // Prepare the SQL statement to delete the item from the cart
    $sql = "DELETE FROM `cart` WHERE Sr_No = ?";

    // Prepare and bind the statement
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $Sr_No);

    // Execute the statement
    if ($stmt->execute()) {
        // Item removed successfully, redirect back to the cart page
        echo '<script>alert("Book removed successfully.")</script>';
        echo '<script>window.location.href = "cart.php";</script>';
    } else {
        // Error occurred during removal, display the error message
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

include "Connection.php";

$book_id = $_POST['Book_Id'];

// Prepare an SQL query to select data for a specific book from the customer's cart
$selectQuery = "SELECT * FROM `cart` WHERE Customer_Id = '$cutomerid' AND Book_Id = '$book_id' ";
$result=mysqli_query($connection, $selectQuery);
// Check if a row was found
if(mysqli_num_rows($result) > 0){
    // Fetch the result as an associative array
    $row = mysqli_fetch_assoc($result);
    // Now you can access the data for the particular book
    $book_name = $row['Book_Name'];
    $quantity = $row['Quantity'];
    $price = $row['Price'];
    $total = $row['Total'];
    $image = $row['Image'];
    
    // Output or process the fetched data as needed
    //echo "Product Name: $book_name<br>";
    //echo "Quantity: $quantity<br>";
    //echo "Price: $price<br>";
    //echo "Total: $total<br>";
} else {
    // No record found, handle this case (e.g., display an error message)
    echo "Book with Book_Id $book_id not found in the cart for Customer_Id $customer_id";
}

     ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Buddies - Paying Bill</title>
    <!-- Css File -->
    <link rel="stylesheet" type="text/css" href="css/Bill.css" />
    <!--Favicon  -->
    <link rel="shortcut icon" href="simages/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="images/apple-touch-icon.png" type="image/x-icon" />
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css" />
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css" />
    <!-- Swiper Js Css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <style>
        .container label{
            font-weight: bold;
            font-size: 25px;
            margin-bottom: 50px;
        }
        h2{
            margin-top: 100px;
        }
        .container{
            width: 700px;
        }
        .online{
            text-align: center;
            padding: 10px;
        }
        .online h3{
            font-size: 32px;
            padding: 10px;

        }
        .online img{
            max-width: 500px;
            max-height: 350px;
        }
        .step label {
            font-size: 16px;
        }
        .step input {
            margin-top: 10px;
            width: 100%;
            height: 50px;
        }
        .step select {
            width: 100%;
            margin-top: 10px;
        }
        .step textarea {
            width: 100%;
            margin-top: 10px;
        }
        .step .btn {
            width: 100%;
            display: flex;
            align-items: center;
        }
        .btn input[type="button"],
        .btn input[type="submit"] {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 40px;
            background-color: #007bff;
            font-size: 20px;
            font-weight: 500;
            font-family: "Montserrat", sans-serif;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn input[type="button"]:hover,
        .btn input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .btn input[type="button"]:first-child,
        .btn input[type="submit"]:first-child {
             margin-right: 10px;
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
            <a href="./index.html">
                <h1>Purchasing - Order</h1>
            </a>
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
    <!---- Bill section  -->
    <form action="payment.php" method="post">
    <div class="container">
        <h2> Fetch Billing  - Step <span id="stepNum">1 </span> of 5</h2>
        <div class="progress">
            <div class="progress-bar"></div>
          </div>
        <div class="steps">
          <div class="step active" id="step1">
          <input type="hidden" name="product_Image" value="<?php echo $image; ?>">
            <label for="">customer Id :</label>
            <input type="text" id="customer_id" name="Customer_id" value="<?php echo $cutomerid; ?>" readonly>
            <label for="">Book Name :</label>
            <input type="text" id="date" name="bookname" placeholder="Book Title" value="<?php echo $book_name; ?>" readonly>
            <label for="">Date :</label>
            <input type="date" id="dueDate" name="dueDate" placeholder="Due Date" required readonly>
            <script>
                // Get the current date
                var currentDate = new Date();

                // Format the date as "YYYY-MM-DD" required by the input type="date"
                var year = currentDate.getFullYear();
                var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Month starts from 0
                var day = currentDate.getDate().toString().padStart(2, '0');

                // Set the value of the input field
                document.getElementById('dueDate').value = year + '-' + month + '-' + day;
            </script>
            <input type="button" value="Next" onclick="nextStep()">
          </div>
          <div class="step" id="step2">
            <label for="">Payee Name :</label>
            <input type="text" id="payeeName" name="payeeName" placeholder="Payee Name" value="<?php echo $Username; ?>" required readonly>
            <label for="">Delivery Address :</label>
            <textarea id="address" name="address" placeholder="Address"  required readonly><?php echo $address; ?></textarea>
            <label for="">Contact Number :</label>
            <input type="text" id="contactInfo" name="phonenumber" placeholder="Contact Number" value="<?php echo $phoneno; ?>" required readonly>
            <div class="btn">
                <input type="button" value="Previous" onclick="prevStep()">
                <input type="button" value="Next" onclick="nextStep()">
            </div>

          </div>
          <div class="step" id="step3">
          <label for="">Description :</label>
            <input type="text" id="description" name="description" placeholder="Description" >
            <label for="">Quantity :</label>
            <input type="number" id="quantity" name="quantity" placeholder="Quantity" value="<?php echo $quantity; ?>" required readonly>
            <label for="">Unit Price :</label>
            <input type="number" id="unitPrice" name="unitPrice" placeholder="Unit Price" value="<?php echo $price; ?>" required readonly>
            <label for="">Total Amount :</label>
            <input type="number" id="totalAmount" name="totalAmount" placeholder="Total Amount" value="<?php echo $total; ?>" required readonly>
            <div class="btn">
                <input type="button" value="Previous" onclick="prevStep()">
                <input type="button" value="Next" onclick="nextStep()">
            </div>
          </div>
          <div class="step" id="step4">
          <label for="paymentMethod">Payment Method:</label>
            <select id="paymentMethod" name="paymentMethod" onchange="showUPIField()">
                <option selected>Choose payment mode</option>
                <option value="online">Online</option>
                <option value="cash">Cash on Delivery</option>
            </select>

            <div id="upiField" style="display: none;">
            <label for="upiID">UPI ID:</label>
            <input type="text" id="upiID" name="upiID" placeholder="Enter UPI ID">
            <span id="upiError" style="color: red; display: none;">Please enter a valid UPI ID.</span>
                            <div class="online">
                                <h3>Book Buddies Payment</h3>
                                <div id="scanner-container">
                                <img src="img/Book_Buddies_pay.jpeg" alt="">
                                </div>
                            </div>
                            
            </div>
                        <script>
                            // Function to show UPI field when online payment is selected
                            function showUPIField() {
                                var paymentMethod = document.getElementById("paymentMethod").value;
                                var upiField = document.getElementById("upiField");

                                if (paymentMethod === "online") {
                                    upiField.style.display = "block";
                                } else {
                                    upiField.style.display = "none";
                                }
                            }
                        </script>

            <label for="">Paying Amount :</label>
            <input type="number" id="paymentDue" name="paymentDue" placeholder="Paying Amount"value="<?php echo $total; ?>" required readonly>
            <div class="btn">
                <input type="button" value="Previous" onclick="prevStep()">
                <input type="button" value="Next" onclick="nextStep()">
            </div>
          </div>
          <div class="step" id="step5">
          <label for="">Additional Note :</label>
            <textarea id="additionalNotes" name="additionalNotes" placeholder="Additional Notes/Comments"></textarea>
            <div class="btn">
                <input type="button" value="Previous" onclick="prevStep()">
                <input type="submit" name="submit" value="Submit">
            </div>
          </div>
        </div>
      </div>
    </form>
    <script>
        
    </script>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="js/slider.js"></script>
    <script src="js/shopeScript.js"></script>
    <script src="js/bill.js"></script>

    
</body>
</html>
