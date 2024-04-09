<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign_In</title>
        <!-- CSS -->
        <link rel="stylesheet" href="./css/Register.css">
                
        <!-- Boxicons CSS -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

        <style>
            .new{
    height: 100%;
    width: 100%;
    border: none;
    font-size: 16px;
    font-weight: 400;
    border-radius: 6px;
    color: #fff;
    background-color: #0171d3;
    padding : 14px;
    padding-left: 160px;
    padding-right: 160px;
    transition: all 0.3s ease;
    cursor: pointer;
}


.new:hover{
    background-color: #016dcb;
}
        </style>
                        
    </head>
    <body background="img/Background.jpg">
        <section class="container forms">
            <div class="form login">
                <div class="form-content">
                    <header>Login</header>
                    <?php
                    if(isset($_GET['signinerror'])){
                        $signinerror=$_GET['signinerror'];
                    }
                    if(!empty($signinerror)){
                        echo '<script>alert("Invaild Login credentials...please Try Again")</script>';
                    }
                    ?>
                    <form  action="Sign_In.php" method="post">
                        <div class="field input-field">
                            <input type="email"  name="login_var" values="<?php if(!empty($signinerror)){echo $signinerror;}?>"  placeholder="Email" class="input">
                        </div>
                        <div class="field input-field">
                            <input type="password"  name="password" placeholder="Enter the Password" minlength="6" maxlength="8" required class="password">
                            <i class='bx bx-hide eye-icon'></i>
                        </div>
                        <div class="form-link">
                            <a href="Forget_password.php" class="forgot-pass">Forgot password?</a>
                        </div>
                        <div class="field button-field">
                            <button name="signin">Login</button>
                        </div>
                    </form>
                    <div class="form-link">
                        <span>Don't have an account? <a href="#" class="link signup-link">Signup</a></span>
                    </div>
                </div>
                <div class="line"></div>
                <div class="media-options">
                    <a href="https://www.facebook.com" class="field facebook">
                        <i class='bx bxl-facebook facebook-icon'></i>
                        <span>Login with Facebook</span>
                    </a>
                </div>
                <div class="media-options">
                    <a href="https://www.google.com" class="field google">
                        <img src="img/google.png" alt="" class="google-img">
                        <span>Login with Google</span>
                    </a>
                </div>
            </div>

            
            <!-- Signup Form -->
            <div class="form signup">
                <div class="form-content">
                    <header>Signup</header>
                    <form action="Mail.php" method="post">
                        <div class="field input-field">
                            <input type="text" id="username" name="Username" placeholder="Username" minlength="4" maxlength="20" required class="input">
                        </div>
                        <div class="field input-field">
                            <input type="email" id="email" name="Email_Id" placeholder="Email" required class="input">
                        </div>
                        <div class="field input-field">
                            <input type="password" id="password" name="Password" placeholder="Create Password" minlength="6" maxlength="8" required class="password">
                        </div>
                        <div class="field button-field">
                        <button name="new"><span class="new">Signup</span></button>
                        </div>
                    </form>
                    <div class="form-link">
                        <span>Already have an account? <a href="#" class="link login-link">Login</a></span>
                    </div>
                </div>
                <div class="line"></div>
                <div class="media-options">
                    <a href="https://www.facebook.com" class="field facebook">
                        <i class='bx bxl-facebook facebook-icon'></i>
                        <span>Login with Facebook</span>
                    </a>
                </div>
                <div class="media-options">
                    <a href="https://www.google.com" class="field google">
                        <img src="img/google.png" alt="" class="google-img">
                        <span>Login with Google</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- JavaScript -->
        <script src="js/Register.js"></script>
    </body>
</html>