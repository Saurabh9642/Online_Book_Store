<?php
// Include your database connection file
require_once "Connection.php";

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get form input and sanitize
    $email =$_POST['email'];
    $previousPassword =$_POST['previousPassword'];
    $newPassword =$_POST['newPassword'];

    // Build SQL query with sanitized input
    $sql = "SELECT * FROM `register` WHERE Email_Id = '$email' AND User_Password = '$previousPassword'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            // Update password
            $updateSql = "UPDATE `register` SET `User_Password` = '$newPassword' WHERE Email_Id = '$email'";
            $updateResult = mysqli_query($connection, $updateSql);

            if ($updateResult) {
                echo '<script>alert("Password reset successfully");</script>';
                header("location:Register1.php");
                exit();
            } else {
                echo '<script>alert("Failed to reset password");</script>';
            }
        } else {
            echo '<script>alert("Invalid email or previous password");</script>';
        }
    } else {
        echo '<script>alert("Query failed");</script>';
    }

    // Close connection
    mysqli_close($conn);
}
?>
