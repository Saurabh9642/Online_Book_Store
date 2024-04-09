<?php session_start(); ?>
<?php
require_once("Connection.php");
if(isset($_POST['signin']))
{
    $login=$_POST['login_var'];
    $Password=$_POST['password'];
    $query="SELECT * FROM `register` WHERE Email_Id='$login' ";
    $res=mysqli_query($connection,$query);
    $numrows=mysqli_num_rows($res);
    if($numrows == 1)
    {
        $row=mysqli_fetch_assoc($res);
        $hashedPasswordFromDatabase = $row['User_Password'];
        $userSubmittedPassword = $_POST['password'];
        if ($userSubmittedPassword === $hashedPasswordFromDatabase) 
        {
            $_SESSION["login_sess"]="1";
            $_SESSION["login_email"]=$row['Email_Id'];
            header("location:Account.php");
        }
        else
        {
            header("location:Register1.php?signinerror=@".$login);
        }
    }   
    else
    {
            header("location:Register1.php?signinerror=$".$login);
    }
    
}

?>