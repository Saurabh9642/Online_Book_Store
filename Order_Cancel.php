<?php
require_once("Connection.php");

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
