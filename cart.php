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
    $Customer_Id= $res['Customer_Id'];
    $Username = $res['Username'];
    $category = $res['category']; 
    $class = $res['class'];
    $phoneno = $res['Phoneno']; 
} else {
    // You can handle this case as needed
    echo "No user found with email: $email";
    exit();
}

// Fetch products from database
$selectQuery = "SELECT * FROM `cart` WHERE Customer_Id ='$Customer_Id' ";
//$selectQuery = "SELECT * FROM `cart`";

$result = mysqli_query($connection, $selectQuery);



if(isset($_POST['By_now']) && isset($_POST['Book_Id'])) {
  // Retrieve the selected book_id from the form
  $book_id = $_POST['Book_Id'];

  // Redirect to the bill.php page with the selected book_id as a query parameter
  header("Location: Bill.php?book_id=$book_id");
  exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Shopping Cart - Book Buddiess</title>

  <!-- Css File -->
  <link rel="stylesheet" type="text/css" href="./css/cart1.css">
  <!--Favicon  -->
  <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="./assets/images/apple-touch-icon.png" type="image/x-icon" />

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.1.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
  <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css" />
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css" />

  <!-- Swiper Js Css -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

  <style>
    .quantity_container .quantity select{
            width: 9rem;
            height: 5rem;
            background-color: var(--flex-furniture-20);
            border: 1px solid var(--flex-furniture-200);
            border-radius: 0 1rem 1rem 0;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size : 18px;
        }

        .quantity_container .quantity option{
            width: 10rem;
            height: 5rem;
        }
  </style>
 
</head>

<body>


  <!-- Go To Top Button -->
  <div class="top-btn">
    <button id="top"><i class="fi fi-rr-chevron-double-up"></i></button>
  </div>

  <!-- Top Bar -->
  <div class="top-bar">
    <span>
      UP TO 60% OFF BEST-SELLING BOOK. <a href="./shop.php">SHOP NOW</a>
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
        <h1>Cart</h1>
      </a>
    </div>

    <div class="right-side">
      <div class="user">
        <a href="#">
          <i class="fi fi-rr-user"></i>
        </a>
        <ul class="user-menu">
          <li>
            <a href="./myaccount.php">
              <div class="profile-picture">
              <span><?php echo $Username; ?></span>
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

  <!-- Menu Section -->
  <section class="menu-container">
    <div class="close-icon" id="close-menu">
      <i class="fi fi-rr-cross-small"></i>
    </div>
    </nav>
  </section>

  <!-- Search Section -->
  <section class="search-section">
    <div class="close-icon" id="close-search">
      <i class="fi fi-rr-cross-small"></i>
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
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
  <section class="product-section">
        <main class="product-container">
            <article class="products">
                <?php
                if (mysqli_num_rows($result) > 0) { 
                while ($fetchResult = mysqli_fetch_assoc($result)) { ?>
                    <form action="Bill.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="Sr_No" value="<?php echo $fetchResult["Sr_No"] ?>">
                        <input type="hidden" name="Book_Id" value="<?php echo $fetchResult["Book_Id"] ?>">
                        <input type="hidden" name="product_id" value="<?php echo $fetchResult["Id"] ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetchResult["Price"] ?>">
                        <input type="hidden" name="product_title" value="<?php echo $fetchResult["Book_Name"]; ?>">
                        <input type="hidden" name="product_Image" value="<?php echo $fetchResult["Image"]; ?>">
                        <div class="product-card">
                            <div class="product-img">
                                <img name="Image" src="<?php echo $fetchResult["Image"]; ?>" alt="Product Image">
                            </div>
                            <div class="product-detail">
                                <h2><?php echo $fetchResult["Name"] ?></h2>
                                <ul class="rating">
                                   <li><i class="fi fi-sr-star"></i></li>
                                   <li><i class="fi fi-sr-star"></i></li>
                                   <li><i class="fi fi-sr-star"></i></li>
                                   <li><i class="fi fi-sr-star"></i></li>
                                    <li><i class="fi fi-sr-star-sharp-half-stroke"></i></li>
                                </ul>
                                <?php if ($fetchResult["Quantity"] >= 8) { ?>
                                    <span style="font-size: 1.6rem; font-weight: 500; color: green;">In Stock</span>
                                <?php } elseif ($fetchResult["Quantity"] >= 4 && $fetchResult["Quantity"] <= 6) { ?>
                                    <span style="font-size: 1.6rem; font-weight: 500; color: #FF502A;">Only few left</span>
                                <?php } elseif ($fetchResult["Quantity"] == 0) { ?>
                                    <span style="font-size: 1.6rem; font-weight: 500; color: #ff0000;">Out of stock</span>
                                <?php } elseif ($fetchResult["Quantity"] <= 4) { ?>
                                    <span style="font-size: 1.6rem; font-weight: 500; color: #ff0000;">Very few left</span>
                                <?php } ?>
                                <div class="quantity_container">
                                    <h2>Selected Quantity</h2>
                                    <div class="quantity">
                                    <select id="quantity" name="quantity">
                                            <option selected>Qty: <?php echo $fetchResult["Quantity"] ?></option>
                                        </select>
                                    </div>
                                </div>

                                <p><i class="fi fi-rr-indian-rupee-sign"></i> <?php echo $fetchResult["Price"] ?></p>
                            </div>
                            <div class="btn">
                                <button type="submit" name="By_now">By Now</button>
                                <button type="submit" name="remove">Remove</button>
                            </div>
                        </div>
                    </form>
                    <?php
                            }
                        } else {
                            echo "<h1 style='margin-left: 250px; font-size: 30px;'>$Username Don't have any Cart !..Please add the book </h1>";
                        }
                    ?>            </article>
        </main>
    </section>
        
          <form action="cart.php" method="post">
            <?php
            if (mysqli_num_rows($productResult) > 0) {
              while ($row = mysqli_fetch_assoc($productResult)) {
                ?>
                <form action="cart.php" method="post">
                  <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                  <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                  <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
                  <input type="hidden" name="product_quantity" value="<?php echo $row['product_quantity']; ?>">
                  <input type="hidden" name="total_price" value="<?php echo $row['total_price']; ?>">
                  <input type="submit" name="checkout" id="checkout" hidden>
                </form>
              <?php } ?>
            <?php } ?>
            <div class="btn">
              <div class="checkout">
                <label for="checkout">Checkout</label>
              </div>
            </div>
          </form>
        >
          <div class="no_items">
            <span>No Items in cart <a href="./shop.php">Shop Now</a></span>
          </div>
       
      </div>
    </div>
  </section>

  

  <!-- JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="js/slider.js"></script>
    <script src="js/shopeScript.js"></script>
    <script>
         // Get references to the decrease and increase buttons and the quantity input field
  const decreaseButton = document.getElementById('decrease_quantity');
  const increaseButton = document.getElementById('increase_quantity');
  const quantityInput = document.getElementById('quantity');
  
  document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners for the decrease buttons
    document.querySelectorAll('.decrease_quantity').forEach(button => {
        button.addEventListener('click', () => {
            // Get the corresponding quantity input field within the same product container
            let quantityInput = button.nextElementSibling;
            
            // Get the current value of the quantity input field
            let currentValue = parseInt(quantityInput.value);
            
            // Ensure the value is greater than 1 before decrementing
            if (currentValue > 1) {
                // Decrease the value by 1
                quantityInput.value = currentValue - 1;
            }
        });
    });
    
    // Add event listeners for the increase buttons
    document.querySelectorAll('.increase_quantity').forEach(button => {
        button.addEventListener('click', () => {
            // Get the corresponding quantity input field within the same product container
            let quantityInput = button.previousElementSibling;
            
            // Get the current value of the quantity input field
            let currentValue = parseInt(quantityInput.value);
            
            // Increase the value by 1
            quantityInput.value = currentValue + 1;
        });
    });
});


    </script>
 
</body>

</html>