<?php 

require_once "Connection.php";
if(isset($_POST["search"]))
{
  $selectDate = $_POST["select-date"];
  $selectDateArr = explode("/", $selectDate);
  $selectDate = $selectDateArr['2'].'-'.$selectDateArr['1'].'-'.$selectDateArr['0'];

  $selectQuery = "SELECT * FROM `order_book` WHERE 	Order_Date = '$selectDate'";
  $dateWiseOrder = mysqli_query($connection, $selectQuery);
}
else
{ 
  die(mysqli_error($connection));
}

?>