<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Login</title>
<link rel="stylesheet" href="css/Login.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body>
<div class="container">
<a href="Index.html" class="social"><i class="fa-sharp fa-solid fa-arrow-left"></i></a>
<h2 style="margin-top:-30px;">SIGN IN</h2>
<div class="social-container">
                    <a href="https://www.facebook.com/" class="social"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://accounts.google.com/" class="social"><i class="fab fa-google-plus-g"></i></a>
                        <a href="https://www.linkedin.com/login" class="social"><i class="fab fa-linkedin-in"></i></a>
                    </div>
		    <form action="Sign_In.php" method="post">
					<?php
                    if(isset($_GET['signinerror'])){
                        $signinerror=$_GET['signinerror'];
                    }
                    if(!empty($signinerror)){
                        echo '<script>alert("Invaild Login credentials...please Try Again")</script>';
                    }
                    ?>
	<label>Username</label><br>
	<input type="text" id="username" name="login_var" values="<?php if(!empty($signinerror)){echo $signinerror;}?>" placeholder="Enter the Username" required><br>
	<label>Password</label><br>
	<input type="password" id="password" name="password" placeholder="Enter the Password" minlength="6" maxlength="8" required><br>
	<button name="signin">SIGN IN</button>
	<a href="Register.php"><p style="margin-left:250px; margin-top:-20px;">SIGN UP</p></a>
</form>
<p style="margin-left:80px; margin-top:30px;"><a href="#">Forget Password</a></p>

	
</div>



</body>
</html>