<?php
require('database.php');
if(isset($_POST['validate']))
{
   $email=$_POST['email'];
   $password=$_POST['password'];
   $query1 = mysqli_query($database_connection,"select * from customer where email='$email' and password='$password'");
   $res1 = mysqli_fetch_row($query1);
   if($res1)
    {   
           
        session_start();
        $_SESSION['reservation_confirmation'] = ' ';
        $_SESSION['id']=$res1[0];
        $_SESSION['fname'] = $res1[1];
        $_SESSION['lname'] = $res1[2];
        echo "success";
        
    }
}
?>