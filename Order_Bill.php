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
  .product-items .item-remove .remove-button {
  width: 7rem;
  height: 5rem;
  color: var(--flex-furniture-200);
  border: 0;
  border-radius: 0.8rem;
  cursor: pointer;
}

#removeButton{
    padding: 10px 10px;
  background-color: #007bff;
  font-size: 20px;
  font-weight: 500;
  font-family: "Montserrat", sans-serif;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;  
}
#removeButton:disabled {
    background-color: #444647;
}

#removeButton:enabled {
    background-color: red;
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
                <h1>Orders</h1>
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
    <br><br>
    <br> <br><br><br><br>  <br> <br><br><br><br>
    <!-- Product Section -->
    <div class="content">
        <main>
          <section class="product-section">
            <div class="product-container">
              <ul class="product-info">
                <li class="prod-id">Id</li>
                <li class="prod-img">Image</li>
                <li class="prod-title"style="color :#56c1eb;">Title</li>
                <li class="prod-price">Price</li>
                <li class="prod-quantity">Quantity</li>
                <li class="prod-quantity">Cancel</li>
              </ul>

              <?php
              require_once("Connection.php");
              $sql = "SELECT * FROM `order_book` WHERE Customer_id='$customer_id' ";

              // Execute the query
              $result = mysqli_query($connection, $sql);

              // Check if there are results
              if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
              ?>
                  <form action="return.php" method="post">
                    <ul class="product-items">
                      <li class="item-id" style="color:black;">
                        <input type="hidden" name="ID" value="<?php echo $row["ID"]; ?>">
                        <?php echo $row["ID"]; ?>
                      </li>
                      <li class="item-img">
                        <img src="<?php echo $row["Image"]; ?>">
                      </li>
                      <li class="item-title">
                        <?php echo $row["Book_Name"]; ?>
                      </li>
                      <li class="item-price">
                        <input type="number" name="product_price" id="product_price" value="<?php echo $row['price_unit']; ?>">
                      </li>
                      <li class="item-quantity">
                        <input type="number" name="product_quantity" value="<?php echo $row['Quantity']; ?>" />
                      </li>
                      <li class="item-remove">
                      <input type="hidden" name="product_id" value="<?php echo $row['Id']; ?>" />
                      <button type="submit" class="remove-button" name="remove"><i class="fi fi-rr-trash"></i></button>
                      </li>
                      </ul>
                  </form>
                  <?php
                            }
                        } 
                        else {
                            echo "<h1 style='text-align:center; font-size: 20px;'>$Username Don't have any order </h1>";
                        }
                    ?>
            </div>
          </section>
        </main>
      </div>
      
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="js/slider.js"></script>
    <script src="js/shopeScript.js"></script>    
</body>
</html>
