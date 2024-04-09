
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Book Buddies</title>

  <!-- Css File -->
  <link rel="stylesheet" href="css/admin.css" />

  <!--Favicon  -->
  <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="./assets/images/apple-touch-icon.png" type="image/x-icon" />

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css" />
  <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- JavaScript -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="js/tabs.js" defer></script>
  <script src="js/admin.js" defer></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" defer></script>

  <script>
    $(function() {
      var dateFormat = "dd/mm/yy",
        from = $("#select-date")
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1,
          dateFormat: "dd/mm/yy"
        })
        .on("change", function() {
          to.datepicker("option", "minDate", getDate(this));
        })

      function getDate(element) {
        var date;
        try {
          date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
          date = null;
        }

        return date;
      }
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Selecting all the remove buttons
      const removeButtons = document.querySelectorAll('.remove-button');

      // Attaching a click event to each remove button
      removeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
          // Get the cart_id from the data attribute
          const productId = this.getAttribute('data-productid');

          // Sending an AJAX request to remove the item from the cart
          fetch('../assets/php/deleteProduct.php', {
              method: 'POST',
              body: JSON.stringify({
                product_id: productId
              }),
              headers: {
                'Content-Type': 'application/json',
              },
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                // Removing the item from the cart UI
                const itemToRemove = this.closest('.product-items');
                itemToRemove.remove();
              } else {
                alert('Failed to remove the product');
              }
            });
        });
      });
    });
  </script>
  <style>


.color-container {
  text-align: center; /* Center align the inline-block elements */
}
.color-container > div {
  display: inline-block; /* Display the divs as inline-block */
}
.color-container h1{
font-size: 40px;
display: block;
margin-left: 50px;
}
.color-container h2{
font-size: 40px;
margin-left: -100px;
margin-top: 60px;
}
  .color-container span{
    width: 600px;
    height: 200px;
    margin: 20px;
    padding-right: 200px;
    padding-top: 50px;
    padding-bottom: 50px;
  }
  span{
    display: flex;
  }
  .color-container img{
    width: 100px;
    height: 100px;
    margin-left: 50px;
    margin-bottom: -50px;
    }

  .color1 span{ 
border: 1px solid rgba(255, 255, 255, .25);
border-radius: 20px;
background-color: rgba(255, 255, 255, 0.45);
box-shadow: 0 0 10px 1px rgba(0, 0, 0, 0.25);
backdrop-filter: blur(5px);
}

.color2 span{
border: 1px solid rgba(255, 255, 255, .25);
border-radius: 20px;
background-color: rgba(255, 255, 255, 0.45);
box-shadow: 0 0 10px 1px rgba(0, 0, 0, 0.25);
backdrop-filter: blur(5px);
}

.color3 span{
border: 1px solid rgba(255, 255, 255, .25);
border-radius: 20px;
background-color: rgba(255, 255, 255, 0.45);
box-shadow: 0 0 10px 1px rgba(0, 0, 0, 0.25);
backdrop-filter: blur(5px);
}

.color4 span{
border: 1px solid rgba(255, 255, 255, .25);
border-radius: 20px;
background-color: rgba(255, 255, 255, 0.45);
box-shadow: 0 0 10px 1px rgba(0, 0, 0, 0.25);
backdrop-filter: blur(5px);
}

.container .tabs {
  width: 80vmin;
  height: 6rem;
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 6rem;
}
.print {
  padding: 1.4rem 3.4rem;
  border-radius: 1rem;
  font-size: 1.6rem;
  cursor: pointer;
  font-weight: 600;
  background-color: #2652dc;
  float: right;
  margin-top: 20px;
  color: white;
}

.customer-info .cust-bill {
  width: 20rem;
  height: 5rem;
  padding: 0 1.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.4rem;
  font-weight: 500;
  color: var(--flex-furniture-950);
  letter-spacing: 0.15rem;
}

.customer-items .customer-bill {
  width: 20rem;
  padding: 2rem;
  display: flex;
  align-items: center;
  color: var(--flex-furniture-950);
  font-size: 1.6rem;
  justify-content: center;
}

.bill {
  padding: 1.4rem 3.4rem;
  border-radius: 1rem;
  font-size: 1.6rem;
  cursor: pointer;
  font-weight: 600;
  background-color: #2652dc;
  float: right;
  color: white;
}
  </style>
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <div class="preloader-img">
    </div>
  </div>

  <!-- Header -->
  <header class="header">
    <div class="logo">
      <a href="">
      </a>
      <h1>Book Buddies</h1>
      <h1 style="font-size: 14px; margin-top: 70px; margin-left: -220px;">S.G.M.College, Karad</h1>
    </div>

    <div class="right-side">
      <div class="search" id="search">
      </div>
      <div class="logout">
        <a href="./logout.php">
          <i class="fi fi-rr-sign-out-alt"></i>
        </a>
      </div>
    </div>

 
  </header>

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

  <!-- Tabs -->
  <section class="tabs-section">
    <div class="container">
      <div class="tabs">
      <div class="tab active">
          <h3>Dashborad</h3>
        </div>
        <div class="tab">
          <h3>Customers</h3>
        </div>
        <div class="tab">
          <h3>Book</h3>
        </div>
        <div class="tab">
          <h3>Add Book</h3>
        </div>
        <div class="tab">
          <h3>Orders</h3>
        </div>
        <div class="tab">
          <h3>Order-Report</h3>
        </div>
        <div class="tab">
          <h3>Book-Stoke</h3>
        </div>
      </div>
    </div>

    <div class="tab-content">
    <div class="content active">
        <header>
          <h2>Dashboard</h2>
        </header>
        <main>
          <div class="color-container">
                    <div class="color1">
                    <span><img src="img/user1.png" alt="">
                    <?php
                        // Assuming you have already connected to your database
                        require_once("Connection.php");

                        // Perform a SQL query to select all rows from your table
                        $query = "SELECT * FROM `register`";
                        $result = mysqli_query($connection, $query); // $connection is assumed to be your database connection variable

                        if ($result) {
                            // Count the number of rows returned by the query
                            $num_rows = mysqli_num_rows($result);
                        } else {
                            // Handle the case where the query fails
                            echo "Error executing query: " . mysqli_error($connection);
                        }

                        // Close the database connection
                        ?>
                        <h1>Cutomers</h1>
                        <h2 style=""><?php echo $num_rows; ?></h2>
                  </span>
                    </div>
                    <div class="color2">
                    <span><img src="img/user2.png" alt="">
                    <?php
                      require_once "Connection.php";
                      $sql = "SELECT * FROM `addbook`";
                      $result1=mysqli_query($connection, $sql);
                      $rows=mysqli_num_rows($result1);
                    ?>
                    <h1>Book</h1>
                        <h2 style=""><?php echo $rows; ?></h2></span>
                    </div>
                    <div class="color3">
                    <span><img src="img/delivery.png" alt="">
                    <?php
                      require_once "Connection.php";
                      $sql = "SELECT * FROM `order_book`";
                      $result2=mysqli_query($connection, $sql);
                      $row=mysqli_num_rows($result2);
                    ?>
                    <h1>Order</h1>
                        <h2 style=""><?php echo $row; ?></h2></span>
                    </div>
                    <div class="color4">
                    <span><img src="img/feedback.png" alt="">
                    <?php
                      require_once "Connection.php";
                      $sql = "SELECT * FROM `feedback`";
                      $result3=mysqli_query($connection, $sql);
                      $row=mysqli_num_rows($result3);
                    ?>
                    <a href="feedback1.php"><h1 style="color: black;">Feedback</h1></a>
                        <h2 style=""><?php echo $row; ?></h2></span>
                    </div>
            </div>
        </main>
      </div>


      <div class="content">
        <header>
          <h2>Customers</h2>
        </header>
        <main>
          <section class="customer-section">
            <div class="customer-container">
              <ul class="customer-info">
                <li class="cust-id">Id</li>
                <li class="cust-img">Username</li>
                <li class="cust-name">Email</li>
                <li class="cust-mobile">Mobile Number</li>
                <li class="cust-email">languages</li>
                <li class="cust-gender">Occupation</li>
                <li class="cust-address">Address</li>
                <li class="cust-bill">Generate Bill</li>
              </ul>
            
              <!-- Cart Items -->
              <?php
              require_once("Connection.php");
              $sql = "SELECT * FROM `register`";

              // Execute the query
              $result = mysqli_query($connection, $sql);

              // Check if there are results
              if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
              ?>
                  <form action="Customer_bill.php" method="post">
                    <ul class="customer-items">
                      <li class="customer-id" style="color:black;">
                      <input type="hidden" value=" <?php echo $row["Customer_Id"]; ?>" name="CustomerID">
                        <?php echo $row["Customer_Id"]; ?>
                      </li>
                      <li class="customer-img" style="color:black;">
                      <?php echo $row["Username"]; ?>
                      </li>
                      <li class="customer-name" style="color:black;">
                      <?php echo $row["Email_Id"]; ?>
                      </li>
                      <li class="customer-mobile" style="color:black;">
                        <?php echo $row['Phoneno']; ?>
                      </li>
                      <li class="customer-email" style="color:black;">
                        <?php echo $row['Spoken_languages']; ?>
                      </li>
                      <li class="customer-gender" style="color:black;">
                        <?php echo $row['Occupation']; ?>
                      </li>
                      <li class="customer-address" style="color:black;">
                        <?php echo $row['Address']; ?>
                      </li>
                      <li class="customer-bill">
                      <input type="submit" class="bill" value="Bill">
                      </li>
                    </ul>
                  </form>
                <?php
                }
                ?>
              <?php
              }
              ?>
            
            </div>
          </section>
        </main>
      </div>

      <div class="content">
        <header>
          <h2>Book</h2>
        </header>
        <main>
          <section class="product-section">
            <div class="product-container">
              <ul class="product-info">
                <li class="prod-id">Id</li>
                <li class="prod-img">Image</li>
                <li class="prod-title">Title</li>
                <li class="prod-price">Price</li>
                <li class="prod-quantity">Quantity</li>
                <li class="prod-remove">Remove</li>
              </ul>

              <?php
              require_once("Connection.php");
              $sql = "SELECT * FROM `addbook`";

              // Execute the query
              $result = mysqli_query($connection, $sql);

              // Check if there are results
              if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
              ?>
                  <form action="removebook.php" method="post">
                    <ul class="product-items">
                      <li class="item-id" style="color:black;">
                      <input type="hidden" value="<?php echo $row["Id"]; ?>" name="Id">
                        <?php echo $row["Id"]; ?>
                      </li>
                      <li class="item-img">
                        <img src="<?php echo $row["Image"]; ?>">
                      </li>
                      <li class="item-title">
                        <?php echo $row["Book_Name"]; ?>
                      </li>
                      <li class="item-price">
                        <input type="number" name="product_price" id="product_price" value="<?php echo $row['Price']; ?>">
                      </li>
                      <li class="item-quantity">
                        <input type="number" name="product_quantity" value="<?php echo $row['Quantity']; ?>" />
                      </li>
                      <li class="item-remove">
                      <button type="submit" class="remove-button" name="remove"><i class="fi fi-rr-trash"></i></button>
                      </li>
                      </ul>
                  </form>
                <?php
                }
                ?>
              <?php
              }
              ?>
            </div>
          </section>
        </main>
      </div>
      <div class="content">
        <header>
          <h2>Add New Book</h2>
        </header>

        <main>
          <div class="product-form">
            <form action="addbook12.php" method="post" enctype="multipart/form-data">
              <div class="input-group">
                <div class="product-input file-input">
                  <i class="fi fi-sr-document"></i>
                  <input type="file" name="product_image" id="product-img" accept="img/*" hidden />
                  <label for="product-img">Book Image</label>
                </div>
                <div class="product-input">
                  <i class="fi fi-sr-box-open"></i>
                  <input type="text" name="Book_name" id="product_name" placeholder="Book Name" />
                </div>
              </div>
              <div class="input-group">
                <div class="product-input">
                  <i class="fi fi-sr-hand-holding-medical"></i>
                  <input type="text" name="Book_quantity" id="product_quantity" placeholder="Book Quantity" />
                </div>
                <div class="product-input">
                  <i class="fi fi-sr-indian-rupee-sign"></i>
                  <input type="text" name="Book_price" id="product_price" placeholder="Book Price" />
                </div>
              </div>
              <div class="btn-input">
                <i class="fi fi-sr-plus"></i>
                <input type="submit" name="submit" id="add_product" value="Add Book" />
              </div>
            </form>
          </div>
        </main>
      </div>
      <div class="content">
        <header>
          <h2>All Orders</h2>
        </header>

        <main>
          <section class="order-section">
            <div class="order-container">
              <ul class="order-info">
                <li class="or-id">Order Id</li>
                <li class="cust-id">Customer Id</li>
                <li class="cust-name">Customer Name</li>
                <li class="prod-id">Book Name</li>
                <li class="prod-name">Address</li>
                <li class="prod-quantity">Quantity</li>
                <li class="prod-price">Price</li>
                <li class="or-date">Order Date</li>
              </ul>

              <?php
                  require_once("Connection.php");
                  $sql = "SELECT * FROM `order_book` ";
                  // Execute the query
                  $orderResult = mysqli_query($connection, $sql);
              if (mysqli_num_rows($orderResult) > 0) {
                while ($row = mysqli_fetch_assoc($orderResult)) {
              ?>
                  <form action="admin.php" method="post">
                    <ul class="order-items">
                      <li style="color:black;"class="order-id"><?php echo $row["ID"]; ?></li>
                      <li style="color:black;"class="customer-id"><?php echo $row["Customer_id"]; ?></li>
                      <li style="color:black;"class="customer-name"><?php echo $row["Payee_Name"]; ?></li>
                      <li style="color:black;"class="product-id"><?php echo $row["Book_Name"]; ?></li>
                      <li style="color:black;"class="product-name"><?php echo $row["Address"]; ?></li>
                      <li style="color:black;"class="product-quantity"><?php echo $row["Quantity"]; ?></li>
                      <li style="color:black;"class="product-price"><?php echo $row["price_unit"]; ?></li>
                      <li style="color:black;" class="order-date"><?php echo $row["Order_Date"]; ?></li>
                    </ul>
                  </form>
              <?php
                }
              }
              ?>
            </div>
          </section>
        </main>
      </div>
      <div class="content">
        <header>
            <h2>Report</h2>
        </header>
        <main>
            <div class="date-form">
                <form action="" method="post">
                    <label for="select-date">Select Date: </label>
                    <div class="date-input">
                        <i class="fi fi-rr-calendar"></i>
                        <input type="text" name="select-date" id="select-date" placeholder="Select Date" required>
                    </div>
                    <input type="submit" name="search" value="Search">
                </form>
            </div>

            <section class="order-section">
                <div class="order-container">
                    <ul class="order-info">
                        <li class="or-id">Order Id</li>
                        <li class="cust-id">Customer Id</li>
                        <li class="cust-name">Customer Name</li>
                        <li class="prod-id">Address</li>
                        <li class="prod-name">Book Name</li>
                        <li class="prod-quantity">Quantity</li>
                        <li class="prod-price">Price</li>
                        <li class="or-date">Order Date</li>
                    </ul>

                    <?php
                    require_once("Connection.php");

                    if(isset($_POST["search"])) {
                        $selectDate = $_POST["select-date"];
                        $selectDateArr = explode("/", $selectDate);
                        $selectDate = $selectDateArr[2].'-'.$selectDateArr[1].'-'.$selectDateArr[0];

                        $selectQuery = "SELECT * FROM `order_book` WHERE Order_Date = '$selectDate'";
                        $orderResult = mysqli_query($connection, $selectQuery);

                        if(mysqli_num_rows($orderResult) > 0) {
                            while ($row = mysqli_fetch_assoc($orderResult)) {
                    ?>
                                <ul class="order-items">
                                    <li style="color:black;"class="order-id"><?php echo $row["ID"]; ?></li>
                                    <li style="color:black;"class="customer-id"><?php echo $row["Customer_id"]; ?></li>
                                    <li style="color:black;"class="customer-name"><?php echo $row["Payee_Name"]; ?></li>
                                    <li style="color:black; font-size: 14px;"class="prod-id"><?php echo $row["Address"]; ?></li>
                                    <li style="color:black;"class="product-name"><?php echo $row["Book_Name"]; ?></li>
                                    <li style="color:black;"class="product-quantity"><?php echo $row["Quantity"]; ?></li>
                                    <li style="color:black;"class="product-price"><?php echo $row["price_unit"]; ?></li>
                                    <li style="color:black;"class="order-date"><?php echo $row["Order_Date"]; ?></li>
                                </ul>
                    <?php
                            }
                            echo "
                            <div class='no-print'>
                            <button class='print' id='printButton'>Print</button>
                            </div> ";    
                        } else {
                            echo "<h1 style='text-align:center; font-size: 20px;'>No orders found for the selected date.</h1>";
                        }
                    }
                    ?>
                </div>
            </section>
        </main>
    </div>

    <div class="content">
        <header>
            <h2>Book Stoke</h2>
        </header>
        <main>
            <div class="date-form">
                <form action="" method="post">
                    <label for="select-date">Enter the Book Name: </label>
                    <div class="date-input">
                    <i class="fas fa-book"></i>
                    <input type="text" name="select-Book" placeholder="Book Name" required>
                    </div>
                    <input type="submit" name="Search_Book" value="Search">
                </form>
            </div>
            <section class="product-section">
            <div class="product-container">
              <ul class="product-info">
                <li class="prod-id">Id</li>
                <li class="prod-img">Image</li>
                <li class="prod-title" style="color: skyblue;">Title</li>
                <li class="prod-price">Price</li>
                <li class="prod-quantity">Quantity</li>
              </ul>
              <?php
                    require_once("Connection.php");

                    if(isset($_POST["Search_Book"])) {
                        $selectbook = $_POST["select-Book"];

                        $selectQuery = "SELECT * FROM `addbook` WHERE Book_Name = '$selectbook'";
                        $orderResult = mysqli_query($connection, $selectQuery);

                        if(mysqli_num_rows($orderResult) > 0) {
                            while ($row = mysqli_fetch_assoc($orderResult)) {
                    ?>
                  <form method="post">
                    <ul class="product-items">
                      <li class="item-id" style="color:black;">
                        <?php echo $row["Id"]; ?>
                      </li>
                      <li class="item-img">
                        <img src="<?php echo $row["Image"]; ?>">
                      </li>
                      <li class="item-title"style="color:black;">
                        <?php echo $row["Book_Name"]; ?>
                      </li>
                      <li class="item-price" style="color:black;">
                        <?php echo $row['Price']; ?>
                      </li>
                      <li class="item-quantity" style="color:black;">
                        <?php echo $row['Quantity']; ?>
                      </li>
                      </ul>
                      <div class="no-print">
                         <button class="print" id="printButton">Print</button>    
                      </div>
              </form>
                  <?php
                            }
                        } else {
                            echo "<h1 style='text-align:center; font-size: 20px;'>No Book in Stock.</h1>";
                        }
                    }
                    ?>
            </div>
          </section>
           
        </main>
    </div>

    <script>
    document.getElementById('printButton').addEventListener('click', function() {
        // Hide elements that you don't want to print
        var elementsToHide = document.querySelectorAll('.no-print');
        elementsToHide.forEach(function(element) {
            element.style.display = 'none';
        });

        // Trigger the print dialog
        window.print();

        // Restore the hidden elements after printing
        elementsToHide.forEach(function(element) {
            element.style.display = 'block';
        });
    });
</script>
</body>

</html>