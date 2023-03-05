<?php
require('database.php');
if(isset($_POST['submit5']))
{
   $query="SELECT C.cust_id, car.plate_id, car.model,R.pickup_date, R.return_date, R.cost, R.period, R.picked_up, R.returned, C.fname, c.lname, c.email  FROM Reservation as R NATURAL JOIN Customer as C JOIN Car on R.plate_id = Car.plate_id";
    $s = 0;

   if(!empty($_POST['cust_id5'])){
       $cust_id=$_POST['cust_id5'];
       if ($s == 0)
       {
        $s = $s+1;
        $query = $query . " WHERE C.cust_id = '" .$cust_id."'"; 
       }
   }
   if(!empty($_POST['fname5'])){
       $fname=$_POST['fname5'];
       if ($s == 0)
       {
        $s = $s+1;
        $query = $query . " WHERE C.fname = '" .$fname."'"; 
       }
       else
       {
        $query = $query . " AND C.fname = '" .$fname."'"; 
       }
   }
   if(!empty($_POST['lname5'])){
       $lname=$_POST['lname5'];
       if ($s == 0)
       {
        $s = $s+1;
        $query = $query . " WHERE C.lname = '" .$lname."'"; 
       }
       else
       {
        $query = $query . " AND C.lname = '" .$lname."'"; 
       }
   }
   if(!empty($_POST['email5'])){
       $email=$_POST['email5'];
       if ($s == 0)
       {
        $s = $s+1;
        $query = $query . " WHERE C.email = '" .$email."'"; 
       }
       else
       {
        $query = $query . " AND C.email = '" .$email."'"; 
       }
   }
    $query=mysqli_query($database_connection,$query); 
    $count=mysqli_num_rows($query);
    if($count!=0){ 
    echo 
    '
    <br><br><br><br>
    <h1>Reservations</h1>
    <link href="stylefile.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <table class="table table-striped" border="0" cellspacing="2" cellpadding="2"> 
    <tr> 
    <thead class="thead-dark">    
    <th scope="col"> <font face="Arial">Customer Id</font> </th> 
      <th scope="col"> <font face="Arial">Plate Id</font> </th>
      <th scope="col"> <font face="Arial"> Car Model</font> </th> 
      <th scope="col"> <font face="Arial">Pickup_Date</font> </th> 
      <th scope="col"> <font face="Arial">Return_Date</font> </th> 
      <th scope="col"> <font face="Arial">Cost</font> </th> 
      <th scope="col"> <font face="Arial">Period</font> </th> 
      <th scope="col"> <font face="Arial"> PickedUp</font> </th> 
      <th scope="col"> <font face="Arial"> Returned</font> </th> 
      <th scope="col"> <font face="Arial"> First Name</font> </th> 
      <th scope="col"> <font face="Arial"> Last Name</font> </th> 
      <th scope="col"> <font face="Arial"> Email</font> </th> 
    </thead> 
    </tr>   
    ';

 
  while($row = mysqli_fetch_assoc($query)){
    $field1name = $row["cust_id"];
    $field2name = $row["plate_id"];
    $field3name = $row["model"];
      $field4name = $row["pickup_date"];
      $field5name = $row["return_date"];
      $field6name = $row["cost"];
      $field7name = $row["period"]; 
      $field8name = $row["picked_up"];
      $field9name = $row["returned"];
      $field10name = $row["fname"];
      $field11name = $row["lname"];
      $field12name = $row["email"];

      echo '<tr> 
            <td>'.$field1name.'</td> 
            <td>'  .$field2name.'</td> 
            <td>'  .$field3name.'</td> 
            <td>'  .$field4name.'</td> 
            <td>'  .$field5name.'</td> 
            <td>'  .$field6name.'</td> 
            <td>'  .$field7name.'</td> 
            <td>'  .$field8name.'</td> 
            <td>'  .$field9name.'</td> 
            <td>'  .$field10name.'</td> 
            <td>'  .$field11name.'</td> 
            <td>'  .$field12name.'</td> 
        </tr>';
  }
}
  else
  {
    echo' <div style="position: relative; top: 100;">
    <h2 style="position: relative; color: red; left: 600px; top: 200px; font-size:50px;"> This Customer did not reserve any car in this period.</h2>
    </div>';
  }
}
?>



