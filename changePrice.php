<?php
require('database.php');
if(isset($_POST['validate']))
{
   $plate_id=$_POST['plate_id'];
   $price= $_POST['price'];
 
   $query1=mysqli_query($database_connection,"select * from car where plate_id='".$plate_id."'"); 
   if(mysqli_num_rows($query1) == 0)
    {
        echo ("fail");
        exit();
    }
   
        $sql = "update car set price = '".$price."' where plate_id = '".$plate_id."'";
        if (mysqli_query($database_connection, $sql)) {
            echo ("success");
            exit();
        }
    }
mysqli_close($database_connection);
?>
