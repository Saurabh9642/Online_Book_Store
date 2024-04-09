<?php
            error_reporting(0);
            $severname = 'localhost';
            $username = 'root';
            $password = "Mangal@2848";
            $dbname = 'books_galore';
     
            $connection=new mysqli($severname,$username,$password,$dbname);
            if($connection->connect_error)
            {
                  die("Connection Fail.....". $connection->connect_error);
            }
            
?>