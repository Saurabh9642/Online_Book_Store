
<!DOCTYPE html>
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
    $category = $res['Spoken_languages']; 
    $class = $res['Occupation'];
    $phoneno = $res['Phoneno']; 
    $Address = $res['Address'];  
    $image=$res['Image'];    // Assuming `category` is a field in the `register` table

} else {
    echo "No user found with email: $email"; // You can handle this case as needed
    exit();
}
?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book_Store</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/styles.css">

<link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
<link rel="manifest" href="favicon_io/site.webmanifest">
<style>

.footer .box-container{
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(25rem, 1fr));
    gap:1.5rem;
    width: 1200px;
    margin-left: 40px;
    padding: 30px;
    background-color: white;
}

.footer .box-container .box h3{
    font-size: 2.2rem;
    color:var(--black);
    padding:1rem 0;
    color: rgb(17, 17, 17);

}

.footer .box-container .box a{
    display: block;
    font-size: 1.4rem;
    color:var(--light-color);
    padding:1rem 0;
    color: rgb(19, 18, 18);
}

.footer .box-container .box a i{
    color:var(--green);
    padding-right: .5rem;
}

.footer .box-container .box a:hover i{
    padding-right: 2rem;
}

.footer .box-container .box .map{
    width:100%;
}

.footer .share{
    padding:1rem 0;
    text-align: center;
}

.footer .share a{
    height: 5rem;
    width: 5rem;
    line-height: 5rem;
    font-size: 2rem;
    color:#fff;
    background:var(--green);
    margin:0 .3rem;
    border-radius: 50%;
}

.footer .share a:hover{
    background:var(--black);
}

.footer .credit{
    border-top: var(--border);
    margin-top: 2rem;
    padding:0 1rem;
    padding-top: 2.5rem;
    font-size: 2rem;
    color:var(--light-color);
    text-align: center;
}

.footer .credit span{
    color:var(--green);
}
textarea{
    font-size: 1.6rem;
    padding:0 1.2rem;
    height:50px;
    width:100%;
    text-transform: none;
    color:var(--black);
    border:var(--border);
}

.login-form-container form{
    width: 700px;
}
</style>
</head>
<body>

<!-- header section starts  -->

<header class="header">

    <div class="header-1">

        <a href="#" class="logo"> <i class="fas fa-book"></i> Books Buddies </a>


        <div class="icons">
            <div id="search-btn" class="fas fa-search"></div>
            <div id="login-btn" class="fas fa-user"></div>            
            <a href="./cart.php" class="fas fa-shopping-cart"></a>
            <a href="Order_Bill.php"><button class="btn">MY Order</button></a>
            <a href="Logout.php"><button class="btn">Logout</button></a>
        </div>
    </div>

    <div class="header-2">
        <nav class="navbar">
            <a href="#home">home</a>
            <a href="#featured">featured</a>
            <a href="http://localhost/book_Store/shop.php">shop</a>
            <a href="#reviews">reviews</a>
            <a href="#blogs">feedback</a>
        </nav>
    </div>

</header>

<!-- header section ends -->

<!-- bottom navbar  -->

<nav class="bottom-navbar">
    <a href="#home" class="fas fa-home"></a>
    <a href="#featured" class="fas fa-list"></a>
    <a href="#arrivals" class="fas fa-tags"></a>
    <a href="#reviews" class="fas fa-comments"></a>
    <a href="#feedback" class="fas fa-feedback"></a>
</nav>

<!-- login form  -->

<div class="login-form-container">

    <div id="close-login-btn" class="fas fa-times"></div>

    <form action="Profile.php" method="post" enctype='multipart/form-data'> 
        <br><br>  
        <h3>Profile</h3>
        <?php
        if($image == NULL) {
            echo '<img src="img/user1.png" style="width:100px;height:100px;margin-top:6px;margin-left:250px; border-radius:50%;">';
        } else {
            echo '<img src="image/'.$image.'" style="width:170px;height:160px;margin-top:6px; margin-left:250px; border-radius:50%;">';
        }
    ?>
    <input class="form-control" type="file" name="image" style="width:100%; margin-left:250px; margin-top:10px;" >
    <span>Customer Id : <?php echo $cutomerid; ?></span>
    <span>Username</span>
    <input type="text" class="box" name="Username" placeholder="Enter the Username" value="<?php echo $Username; ?>">
    <span>Languages Spoken :</span>
    <input type="text" class="box" name="languages" placeholder="Enter the Spoken language" minlength="6" maxlength="25" value="<?php echo $category; ?>">
    <span>Occupation :</span>
    <input type="text" class="box" name="occupation" placeholder="Enter the Occupation" minlength="4" maxlength="10" value="<?php echo $class; ?>">
    <br><br>
    <span>Phone No :</span>
    <input type="tel" class="box" name="phoneno" placeholder="Enter the Phone No" minlength="10" maxlength="10" value="<?php echo $phoneno; ?>"> 
    <span>Address : </span>
    <textarea name="city" cols="5" rows="7" placeholder="Enter the Address" minlength="5" maxlength="100"><?php echo $Address; ?></textarea>
    <br><br>
    <button class="btn" name="save">Save Changes</button>
        </form>
</div>

<!-- home section starts  -->

<section class="home" id="home">

    <div class="row">

        <div class="content">
           <marquee behavior="" direction=""><h3>60% off</h3> </marquee> 
            <p>If you’re an Engineering student and need a books, Books has great deals on a wide range of books. Shop for these books from top authors and avail hugely discounted prices</p>
            <a href="./shop.php" class="btn">shop now</a>
        </div>

        <div class="swiper books-slider">
            <div class="swiper-wrapper">
                <a href="#" class="swiper-slide"><img src="img/Book1.jpeg" alt=""></a>
                <a href="#" class="swiper-slide"><img src="img/Book2.jpeg" alt=""></a>
                <a href="#" class="swiper-slide"><img src="img/Book3.jpg" alt=""></a>
                <a href="#" class="swiper-slide"><img src="img/Book4.png" alt=""></a>
                <a href="#" class="swiper-slide"><img src="img/Book5.jpg" alt=""></a>
                <a href="#" class="swiper-slide"><img src="img/Book6.jpeg" alt=""></a>
            </div>
            <img src="https://raw.githubusercontent.com/KordePriyanka/Books4MU-Book-Store-Website-/main/image/stand.png" class="stand" alt="">
        </div>

    </div>

</section>

<!-- home section ense  -->

<!-- icons section starts  -->

<section class="icons-container">

    <div class="icons">
        <i class="fas fa-shipping-fast"></i>
        <div class="content">
            <h3>free shipping</h3>
            <p>order over &#8377;100</p>
        </div>
    </div>

    <div class="icons">
        <i class="fas fa-lock"></i>
        <div class="content">
            <h3>secure payment</h3>
            <p>100 secure payment</p>
        </div>
    </div>

    <div class="icons">
        <i class="fas fa-redo-alt"></i>
        <div class="content">
            <h3>easy returns</h3>
            <p>10 days returns</p>
        </div>
    </div>

    <div class="icons">
        <i class="fas fa-headset"></i>
        <div class="content">
            <h3>24/7 support</h3>
            <p>call us anytime</p>
        </div>
    </div>

</section>

<!-- icons section ends -->

<!-- featured section starts  -->

<section class="featured" id="featured">

    <h1 class="heading"> <span>Books</span> </h1>

    <div class="swiper featured-slider">

        <div class="swiper-wrapper">

            <div class="swiper-slide box" id="box">
                <div class="icons">
                <a href="./shop.php">View</a>
                </div>
                <div class="image">
                   <a href="./shop.php"><img src="img/Book1.jpeg" alt=""></a>
                </div>
                <div class="content" id="content">
                    <h3>featured books</h3>
                    <div class="price">699 <span>899</span></div>
             
                </div>
            </div>

            <div class="swiper-slide box">
                <div class="icons">
                <a href="./shop.php">View</a>
                </div>
                <div class="image">
                    <a href="./shop.php"> <img src="https://raw.githubusercontent.com/KordePriyanka/Books4MU-Book-Store-Website-/main/image/book-2.png" alt=""> </a>
                </div>
                <div class="content" id="content">
                    <h3>featured books</h3>
                    <div class="price">548 <span>899</span></div>
               
                </div>
            </div>

            <div class="swiper-slide box">
                <div class="icons">
                <a href="./shop.php">View</a>
                </div>
                <div class="image">
                    <a href="./shop.php"><img src="img/Book2.jpeg" alt=""> </a>
                </div>
                <div class="content" id="content">
                    <h3>featured books</h3>
                    <div class="price">799 <span>999</span></div>
                </div>
            </div>

            <div class="swiper-slide box">
                <div class="icons">
                <a href="./shop.php">View</a>
                </div>
                <div class="image">
                   <a href="./shop.php"> <img src="https://raw.githubusercontent.com/KordePriyanka/Books4MU-Book-Store-Website-/main/image/book-4.png" alt=""></a>
                </div>
                <div class="content" id="content">
                    <h3>featured books</h3>
                    <div class="price">689<span>987</span></div>
                </div>
            </div>

            <div class="swiper-slide box">
                <div class="icons">
                <a href="./shop.php">View</a>
                </div>
                <div class="image">
                   <a href="./shop.php"> <img src="img/Book7.jpg" alt=""></a>
                </div>
                <div class="content" id="content">
                    <h3>featured books</h3>
                    <div class="price">555 <span>865</span></div>
                </div>
            </div>

            <div class="swiper-slide box">
                <div class="icons">
                <a href="./shop.php">View</a>
                </div>
                <div class="image">
                   <a href="./shop.php"><img src="img/Book8.jpg" alt=""></a>
                </div>
                <div class="content" id="content">
                    <h3>featured books</h3>
                    <div class="price">889 <span>1299</span></div>
                </div>
            </div>

            <div class="swiper-slide box">
                <div class="icons">
                <a href="./shop.php">View</a>
                </div>
                <div class="image">
                  <a href="./shop.php">  <img src="https://raw.githubusercontent.com/KordePriyanka/Books4MU-Book-Store-Website-/main/image/book-7.png" alt=""></a>
                </div>
                <div class="content" id="content">
                    <h3>featured books</h3>
                    <div class="price">589 <span>889</span></div>
                </div>
            </div>

            <div class="swiper-slide box">
                <div class="icons">
                <a href="./shop.php">View</a>
                </div>
                <div class="image">
                   <a href="./shop.php"> <img src="img/Book9.jpg" alt=""></a>
                </div>
                <div class="content" id="content">
                    <h3>featured books</h3>
                    <div class="price">876 <span>1199</span></div>
                </div>
            </div>

            <div class="swiper-slide box">
                <div class="icons">
                <a href="./shop.php">View</a>
                </div>
                <div class="image">
                <a href="./shop.php">  <img src="https://raw.githubusercontent.com/KordePriyanka/Books4MU-Book-Store-Website-/main/image/book-9.png" alt=""></a>
                </div>
                <div class="content" id="content">
                    <h3>featured books</h3>
                    <div class="price">599 <span>899</span></div>
                </div>
            </div>

            <div class="swiper-slide box">
                <div class="icons">
                    <a href="./shop.php">View</a>
                </div>
                <div class="image">
                <a href="./shop.php"><img src="img/Book6.jpeg" alt=""></a>
                </div>
                <div class="content" id="content">
                    <h3>featured books</h3>
                    <div class="price">598<span>998</span></div>
                </div>
            </div>

        </div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

    </div>

</section>


<!-- reviews section starts  -->

<section class="reviews" id="reviews">

    <h1 class="heading"> <span>client's reviews</span> </h1>

    <div class="swiper reviews-slider">

        <div class="swiper-wrapper">

            <div class="swiper-slide box">
                <img src="img/Sagar.jpg" alt="">
                <h3>Sagar</h3>
                <p>First of all it customer service is excellent. We get all author book for Mumbai University. People should try here affordable and best price.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="img/Karan.jpg" alt="">
                <h3>Karan</h3>
                <p>Best book store almost all books are available for prepartion of exam related or other books are available on reaonable price also.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="img/Mandar.jpg" alt="">
                <h3>Mandar</h3>
                <p>Customer Service is good. Greetings to customer and making the required Books available to Customers is very good.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>
            <div class="swiper-slide box">
                <img src="img/Aagraj.jpeg" alt="">
                <h3>Aagraj </h3>
                <p>This book centre have large amount of a books. The engineering study material all semester books are available.then the peacefull and nice book centre.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="img/Sujal.png" alt="">
                <h3>Sujal </h3>
                <p>I migrated to the online platform on Just books because I was finding it difficult to go to their libraries before closing time.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="img/Akshay.png" alt="">
                <h3>Akshay </h3>
                <p>I love the product because it is very easy to find. The book are in really organized manner you can easily find the book you want.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

        </div>

    </div>

</section>

<!-- reviews section ends -->

<!-- feedback section starts  -->

<section class="blogs" id="blogs">

    <h1 class="heading"> <span>feedback</span> </h1>

    <section class="newsletter">

        <form action="">
            <h3>give your feedback here...</h3>
            <a href="./Feedback.php" class="btn">Feedback</a>
            </a>
        </form>

    </section>
</section>

<!-- feedback section ends -->

<!-- footer section starts  -->

<section class="footer">

    <div class="box-container">

        <div class="box">
            <h3>our locations</h3>
            <a href="#"> <i class="fas fa-map-marker-alt"></i> Pune </a>
            <a href="#"> <i class="fas fa-map-marker-alt"></i> Kolhapur</a>
            <a href="#"> <i class="fas fa-map-marker-alt"></i> Satara</a>
            <a href="#"> <i class="fas fa-map-marker-alt"></i> Sangli</a>

        </div>

        <div class="box">
            <h3>Links</h3>
            <a href="./index.html"> <i class="fas fa-arrow-right"></i> Home </a>
            <a href="#"> <i class="fas fa-arrow-right"></i> Featured </a>
            <a href="#"> <i class="fas fa-arrow-right"></i> Shop </a>
            <a href="#"> <i class="fas fa-arrow-right"></i> Reviews </a>
            <a href="./feedback.html"> <i class="fas fa-arrow-right"></i> Feedback </a>
        </div>

        <div class="box" >
            <h3>extra links</h3>
            <a href="#"> <i class="fas fa-arrow-right"></i> account info </a>
            <a href="#"> <i class="fas fa-arrow-right"></i> ordered items </a>
            <a href="#"> <i class="fas fa-arrow-right"></i> payment method </a>
            <a href="#"> <i class="fas fa-arrow-right"></i> our serivces </a>
        </div>

        <div class="box">
            <h3>contact info</h3>
            <a href="#"> <i class="fas fa-phone"></i> 8421569642 </a>
            <a href="#"> <i class="fas fa-envelope"></i> saurabhjadhav9642@gmail.com </a>
            <img src="https://raw.githubusercontent.com/KordePriyanka/Books4MU-Book-Store-Website-/main/image/worldmap.png" class="map" alt="">
        </div>

    </div>

    <div class="share" id="share">
        <a href="https://www.facebook.com" class="fab fa-facebook-f"></a>
        <a href="https://twitter.com" class="fab fa-twitter"></a>
        <a href="https://www.instagram.com" class="fab fa-instagram"></a>
        <a href="https://www.linkedin.com" class="fab fa-linkedin"></a>
        <a href="https://www.linkedin.com" class="fab fa-linkedin"></a>
    </div>

</section>

<!-- footer section ends -->

<!-- loader  -->

<div class="loader-container">
    <img src="https://raw.githubusercontent.com/KordePriyanka/Books4MU-Book-Store-Website-/main/image/loader-img.gif" alt="">
</div>


<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/Home.js"></script>

</body>
</html>