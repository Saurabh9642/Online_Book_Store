<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["login_sess"])) {
    // Redirect to the login page if not logged in
    header("Location: Register1.php");
    exit();
}

include "Connection.php";
include "add_to_cart.php";

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
    $category = $res['category']; 
    $class = $res['class'];
    $phoneno = $res['Phoneno']; 
    $city = $res['city'];   // Assuming `category` is a field in the `register` table
} else {
    // You can handle this case as needed
    echo "No user found with email: $email";
    exit();
}

// Fetch products from database
$selectQuery = "SELECT * FROM `addbook`";
$result = mysqli_query($connection, $selectQuery);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Buddies</title>
    <!-- Css File -->
    <link rel="stylesheet" type="text/css" href="css/shop.css" />
    <!--Favicon  -->
    <link rel="shortcut icon" href="simages/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="images/apple-touch-icon.png" type="image/x-icon" />
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css" />
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css" />
    <!-- Swiper Js Css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <style>
        .logo h1{
            font-weight: 600;
            font-size: 35px;
        }
        :root {
            --primary: #586ffe;
            --flex-furniture-20: #ffffff;
            --flex-furniture-50: #f6f6f6;
            --flex-furniture-100: #e7e7e7;
            --flex-furniture-200: #d1d1d1;
            --flex-furniture-300: #b0b0b0;
            --flex-furniture-400: #888888;
            --flex-furniture-500: #6d6d6d;
            --flex-furniture-600: #5d5d5d;
            --flex-furniture-700: #4f4f4f;
            --flex-furniture-800: #454545;
            --flex-furniture-900: #3d3d3d;
            --flex-furniture-950: #56c1eb;
        }
        .top-bar span {
            color: var(--flex-furniture-20);
            font-size: 1.3rem;
            font-weight: 500;
            font-size: 24px;
            letter-spacing: 1px;
        }

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
                <h1>Shop</h1>
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
    <br><br>
    <br><br>
    <br> <br><br><br><br>  <br> <br><br><br><br>
    <!-- Product Section -->
    <section class="product-section">
        <main class="product-container">
            <article class="products">
                <?php while ($fetchResult = mysqli_fetch_assoc($result)) { ?>
                    <form action="add_to_cart.php" method="post" enctype="multipart/form-data">
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
                                <h2><?php echo $fetchResult["Book_Name"] ?></h2>
                                <ul class="rating">
                                    <li><i class="fi fi-sr-star"></i></li>
                                    <li><i class="fi fi-sr-star"></i></li>
                                    <li><i class="fi fi-sr-star"></i></li>
                                    <li><i class="fi fi-sr-star"></i></li>
                                    <li><i class="fi fi-rr-star-sharp-half-stroke"></i></li>
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
                                    <h2>Quantity</h2>
                                    <div class="quantity">
                                        <select id="quantity" name="quantity">
                                            <option selected>Qty: 1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <p><i class="fi fi-rr-indian-rupee-sign"></i> <?php echo $fetchResult["Price"] ?></p>
                            </div>
                            <div class="btn">
                                <button type="submit" name="cart">Add to Cart</button>
                            </div>
                        </div>
                    </form>
                <?php } ?>
            </article>
        </main>
    </section>
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="js/slider.js"></script>
    <script src="js/shopeScript.js"></script>
    
    
    
</body>
</html>
