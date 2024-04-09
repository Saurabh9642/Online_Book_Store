<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forget Password</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    
    .container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 800px;
    }
    
    h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    
    label {
        display: block;
        margin-bottom: 5px;
        color: 1px solid #ccc;
    }
    
    input[type="password"],
    input[type="email"] {
        width: 700px;
        margin-left : 20px;
        padding: 15px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        font-size : 18px;
        border-radius: 4px;
    }
    
    button {
        margin-left : 30px;
        width: 700px;
        padding: 15px;
        font-size: 18px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
    }
    
    button:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body background="img/Background.jpg">
<div class="container">
    <h2>Forget Password</h2>
    <form action="forget.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="previousPassword">Previous Password:</label>
        <input type="password" id="previousPassword" name="previousPassword" required>
        <label for="newPassword">New Password:</label>
        <input type="password" id="newPassword" name="newPassword" required>
        <button type="submit" name="submit">Reset Password</button>
    </form>
</div>
</body>
</html>
