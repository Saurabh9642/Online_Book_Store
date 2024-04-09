<?php

include "Connection.php";

if (isset($_POST["submit"])) {
    // Fetching book details from the form
    $BookName = $_POST["Book_name"];
    $BookQuantity = $_POST["Book_quantity"];
    $BookPrice = $_POST["Book_price"];

    // File upload handling
    if ($_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = 'uploads/';
        $target_file = $target_dir . basename($_FILES['product_image']['name']);

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
            // File uploaded successfully, proceed with database insertion
            $sql = "INSERT INTO `addbook`(`Image`, `Book_Name`,`Quantity`, `Price`) VALUES (?, ?, ?,?)";
            
            // Prepare statement
            $stmt = $connection->prepare($sql);
            if ($stmt) {
                // Bind parameters
                $stmt->bind_param("ssii", $target_file, $BookName, $BookQuantity, $BookPrice);
                
                // Execute statement
                if ($stmt->execute()) {
                    echo "<script> alert('Book Added Successfully'); </script>";
                    header("refresh: 0; url = Admin_Home.php");
                } else {
                    echo "<script> alert('Error inserting Book: " . $stmt->error . "'); </script>";
                }
                
                // Close statement
                $stmt->close();
            } else {
                echo "<script> alert('Error preparing statement: " . $connection->error . "'); </script>";
            }
        } else {
            echo "<script> alert('Error moving uploaded file.'); </script>";
        }
    } else {
        echo "<script> alert('Error uploading file: " . $_FILES['product_image']['error'] . "'); </script>";
    }

    // Close connection
    $connection->close();
}
?>