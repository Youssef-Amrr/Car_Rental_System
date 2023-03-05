<?php
require('database.php');
if(isset($_POST['validate']))
{
   $plate_id=$_POST['plate_id'];
   $model=$_POST['model'];
   $year=$_POST['year'];
   $colour=$_POST['colour'];
   $price= $_POST['price'];
   $office_id=$_POST['office_id'];

   $query1=mysqli_query($database_connection,"select * from car where plate_id='".$plate_id."'"); 
   if(mysqli_num_rows($query1) >= 1)
    {
        echo ("fail1");
        exit();
    }
    $query2=mysqli_query($database_connection,"select * from office where office_id='".$office_id."'"); 
   if(mysqli_num_rows($query2) == 0)
    {
        echo ("fail2");
        exit();
    }
        $sql = "insert into car (plate_id, model, year, colour, price, office_id) values ('".$plate_id."', '".$model."', '".$year."', '".$colour."', '".$price."', '".$office_id."')";
        if (mysqli_query($database_connection, $sql)) {
            echo ("success");
            exit();
        }
    }
mysqli_close($database_connection);
?>