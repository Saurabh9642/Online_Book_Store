<?php
                      require_once("Connection.php");
                      if (isset($_POST['remove'])) {
                        // Get the Sr_No of the item to be removed from the form
                        $id = $_POST['Id'];
                    
                        // Prepare the SQL statement to delete the item from the cart
                        $sql = "DELETE FROM `addbook` WHERE Id = ?";
                    
                        // Prepare and bind the statement
                        $stmt = $connection->prepare($sql);
                        $stmt->bind_param("i", $id);
                    
                        // Execute the statement
                        if ($stmt->execute()) {
                            // Item removed successfully, redirect back to the cart page
                            echo '<script>alert("Book removed successfully.")</script>';
                            echo '<script>window.location.href = "Admin_Home.php";</script>';
                        } else {
                            // Error occurred during removal, display the error message
                            echo "Error: " . $stmt->error;
                        }
                    
                        // Close the statement
                        $stmt->close();
                    }
                      ?>
