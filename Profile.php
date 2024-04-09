<?php
// Include the database connection file
require_once "Connection.php";

// Check if the form is submitted
if(isset($_POST['save'])) {
    // Retrieve form data
    $Username = $_POST['Username'];
    $languages = $_POST['languages'];
    $occupation = $_POST['occupation'];
    $phoneno = $_POST['phoneno'];
    $city = $_POST['city'];

    // Validate the city address
    if(!validateAddress($city)) {
        echo '<script>alert("Address can only contain letters, numbers, spaces, commas, periods, and hyphens.")</script>';
        echo '<script>window.location.href = "Account.php";</script>';
        exit();
    }

    // Prepare the SQL update query using prepared statements
    $sql = "UPDATE `register` SET `Spoken_languages`=?, `Occupation`=?, `Phoneno`=?, `Address`=? WHERE `Username`=?";

    // Prepare and bind parameters
    if($stmt = $connection->prepare($sql)) {
        $stmt->bind_param("sssss", $languages, $occupation, $phoneno, $city, $Username);
        
        // Execute the update query
        if($stmt->execute()) {
            echo '<script>alert("Successful change")</script>';
            echo '<script>window.location.href = "Account.php";</script>';
        } else {
            echo "Error: " . $stmt->error;
        }
        // Close statement
        $stmt->close();
    } else {
        echo "Error: " . $connection->error;
    }
}

// Function to validate the city address
function validateAddress($address) {
    // Trim extra whitespace
    $address = trim($address);
    
    // Check if the address is empty
    if(empty($address)) {
        return false;
    }
    
    // Check if the address contains only allowed characters
    if(!preg_match('/^[a-zA-Z0-9\s\.,\-]+$/', $address)) {
        return false;
    }
    
    // Address is valid
    return true;
}


if(isset($_POST['save'])) {
    $Username = $_POST['Username'];
    
    $folder = 'image/';
    $file = $_FILES['image']['tmp_name'];  
    $file_name = $_FILES['image']['name']; 
    $file_name_array = explode(".", $file_name); 
    $extension = strtolower(end($file_name_array)); // Convert extension to lowercase for consistency
    $new_image_name = 'profile_' . uniqid() . '.' . $extension; // Use uniqid() for unique file names
    
    if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
        $error[] = 'Error uploading image. Please try again.';
    } elseif ($_FILES["image"]["size"] > 1000000) {
        $error[] = 'Sorry, your image is too large. Upload less than 1 MB in size.';
    } elseif(!in_array($extension, array("jpg", "png", "jpeg", "gif"))) {
        $error[] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed';   
    }

    if(!isset($error)) { 
        if($file != "") {
            $sql = "SELECT image FROM register WHERE  Username='$Username'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result); 
            $deleteimage = $row['image'];
            unlink($folder . $deleteimage);
            if (move_uploaded_file($file, $folder . $new_image_name)) {
                $sql = "UPDATE `register` SET `Image`='$new_image_name' WHERE `Username`='$Username'";
                $update_result = mysqli_query($connection, $sql);
                if($update_result) {
                    header("location: Account.php?profile_updated=1");
                    exit(); // Exit to prevent further execution
                } else {
                    $error[] = 'Failed to update image in database.';
                }
            } else {
                $error[] = 'Failed to move uploaded file to destination folder.';
            }
        } else {
            $error[] = 'No file uploaded.';
        }
    }
}

?>
