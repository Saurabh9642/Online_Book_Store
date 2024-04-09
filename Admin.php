<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            padding: 40px;
            width: 500px;
            text-align: center;
        }

        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333333;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 10px);
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #dddddd;
            border-radius: 4px;
            box-sizing: border-box;

        }

        button {
            background-color: blue;
            font-size: 20px;

            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body background="img/Background.jpg">
    <div class="container">
        <h1>Admin Login</h1>
        <form method="post" action="Admin.php">
            <input type="text" name="username" placeholder="Username" required>
            <br>
            <input type="password" name="password" placeholder="Password" required>
            <br>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>

<?php session_start(); ?>
<?php
// Ensure you have a database connection and other necessary setup.

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform user authentication
    // Replace the following code with your authentication logic
    if ($username === 'Book_Buddies' && $password === 'Book_Buddies') {
        // Authentication successful
        // You can redirect the user to a secure page
        $_SESSION["Adminlogin_sess"]="1";
        header('Location: Admin_Home.php');
        exit;
    } else {
        // Authentication failed
        echo '<script>alert("Invalid username or password")</script>';
        //echo 'Invalid username or password. Please try again.';
    }
}
?>
