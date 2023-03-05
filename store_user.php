<?php
require('database.php');
if(isset($_POST['validate']))
{
   $fname=$_POST['fname'];
   $lname=$_POST['lname'];
   $email=$_POST['email'];
   $password=$_POST['password'];
   $query=mysqli_query($database_connection,"select * from customer where email='".$email."'"); 
   if(mysqli_num_rows($query) >= 1)
    {
        echo "fail";
    }
    else
    {
        $sql = "insert into customer (fname, lname, email, password) values ('$fname', '$lname', '$email', '$password')";
        if (mysqli_query($database_connection, $sql)) {
            $q3 = "SELECT cust_id FROM customer where email='".$email."' ";
            $row=mysqli_query($database_connection,$q3);
            $rowid = mysqli_fetch_assoc($row);
            session_start();
            $_SESSION['fname'] = $fname;
            $_SESSION['id']= $rowid["cust_id"];
            $_SESSION['reservation_confirmation'] = 'Successful Registration!';

            echo ("success");
            exit();
        }
    }
   }
mysqli_close($database_connection);
?>