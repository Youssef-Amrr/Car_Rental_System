<?php
    $database_connection = mysqli_connect("localhost","root","","car_rental_system");
    // mysqli_connect() takes host name, database username, password, and database name.
    // i did not set a password for my data base
    // mysqli_connect() function opens a new connection to the MySQL server. 
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    //else{
      //  echo "Connected Succesfully ";
    //}
    // check if error happened during connection trial
    // mysqli_connect_error() function returns the error description from the last connection error, if any.
?>
