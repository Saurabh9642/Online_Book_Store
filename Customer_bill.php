<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
$currentDate = date("F j, Y"); // Format: April 3, 2024
$currentTime = date("h:i A"); // Format: 09:47 AM


// Assuming you have a database connection already established
require_once "Connection.php";

// Check if CustomerID is set and not empty
if(isset($_POST["CustomerID"]) && !empty($_POST["CustomerID"])) {
    $customerid = $_POST["CustomerID"];
    $findresult = mysqli_query($connection, "SELECT * FROM `register` WHERE `Customer_id`= $customerid ");

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
        echo "No user found with CustomerID: $customerid"; // You can handle this case as needed
        exit();
    }
} else {
    echo "CustomerID is not set or empty"; // You can handle this case as needed
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/customerbill.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<title>Bookstore Bill</title>
</head>
<body>
<div class="container">
    <div class="company-info">
        <img src="img/billlogo.png" alt="" />
        <p><strong><i class="fas fa-building"></i>Book Buddies</strong></p>
        <p><strong><i class="fas fa-address-book"></i>S.G.M College, karad, Maharashtra</strong> </p>
        <p><strong><i class="fas fa-phone"></i>+918421569642</strong> </p>
        <p><strong><i class="fas fa-envelope"></i>bookbuddies@gmail.com</strong></p>
    </div>
    <div class="customer-info">
        <p><strong>Customer Name:</strong> <?php echo $Username; ?></p>
        <p><strong>Phone No:</strong> <?php echo $phoneno; ?></p>
        <p><strong>Address:</strong> <?php echo  $Address; ?></p>
        <p><strong>Date & Time:</strong> <?php echo $currentDate . " " . $currentTime; ?></p>
    </div>
    <h1>Books Bill</h1>
    <table>
        <thead>
            <tr>
                <th>Book Title</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Date</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $customerid = $_POST["CustomerID"];
            $sql = "SELECT * FROM `order_book` WHERE `Customer_id`= $customerid";
            $result = mysqli_query($connection, $sql);

            // Check if there are results
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['Book_Name']; ?></td>
                        <td><?php echo $row['Quantity']; ?></td>
                        <td><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo $row['price_unit']; ?></td>
                        <td><?php echo $row['Order_Date']; ?></td>
                        <td><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo $row['Total_amount']; ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr class="total">
                    <td colspan="4">Total</td>
                    <td>
                        <?php
                        // Calculate total from database records
                        $total_query = "SELECT SUM(Total_amount) AS total FROM `order_book` WHERE `Customer_id`= $customerid";
                        $total_result = mysqli_query($connection, $total_query);
                        $total_row = mysqli_fetch_assoc($total_result);
                        echo '<i class="fa-solid fa-indian-rupee-sign"></i> ' . $total_row['total'];
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <div class="footer">
        <p>Thank you for shopping with us!</p>
        <p>Contact us at <a href="mailto:saurabhjadhav@gmail.com">saurabhjadhav9642@gmail.com</a></p>
        <div class="no-print">
        <input type="button" value="Print" id="printButton">
        </div>
    </div>
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
