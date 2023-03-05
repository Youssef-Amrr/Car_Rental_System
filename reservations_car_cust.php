<?php
require('database.php');
  if(isset($_POST['submit']))
  {
    $start=$_POST['start'];
    $end=$_POST['end'];
  if ($start == "" && $end == "")
   {
      $query="select cust_id, fname, lname, email, plate_id, pickup_date, return_date, cost, period, picked_up, returned,  model, year, colour, price, office_id  from reservation Natural Join car Natural Join customer";
   }
   else if ($start == "")
   {
    $query="select cust_id, fname, lname, email, plate_id, pickup_date, return_date, cost, period, picked_up, returned,  model, year, colour, price, office_id  from reservation Natural Join car Natural Join customer where return_date<='".$end."'";
   }
   else if ($end == "")
   {
    $query="select cust_id, fname, lname, email, plate_id, pickup_date, return_date, cost, period, picked_up, returned,  model, year, colour, price, office_id  from reservation Natural Join car Natural Join customer where pickup_date>='".$start."'";
   }
   else
   {
    $query="select cust_id, fname, lname, email, plate_id, pickup_date, return_date, cost, period, picked_up, returned,  model, year, colour, price, office_id  from reservation Natural Join car Natural Join customer where pickup_date>='".$start."' and return_date<='".$end."'";
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
      <th scope="col"> <font face="Arial"> First Name</font> </th> 
      <th scope="col"> <font face="Arial"> Last Name</font> </th> 
      <th scope="col"> <font face="Arial"> Email</font> </th> 
      <th scope="col"> <font face="Arial">Plate Id</font> </th> 
      <th scope="col"> <font face="Arial">Pickup_Date</font> </th> 
      <th scope="col"> <font face="Arial">Return_Date</font> </th> 
      <th scope="col"> <font face="Arial">Cost</font> </th> 
      <th scope="col"> <font face="Arial">Period</font> </th> 
      <th scope="col"> <font face="Arial"> PickedUp</font> </th> 
      <th scope="col"> <font face="Arial"> Returned</font> </th> 
      <th scope="col"> <font face="Arial"> Model</font> </th> 
      <th scope="col"> <font face="Arial"> Year</font> </th> 
      <th scope="col"> <font face="Arial"> Color</font> </th> 
      <th scope="col"> <font face="Arial"> Price</font> </th> 
      <th scope="col"> <font face="Arial"> Office Id</font> </th> 
      </thead>    
    </tr>';

 
  while($row = mysqli_fetch_assoc($query)){
      $field1name = $row["cust_id"]; 
      $field2name = $row["fname"]; 
      $field3name = $row["lname"]; 
      $field4name = $row["email"]; 
      $field5name = $row["plate_id"]; 
      $field6name = $row["pickup_date"];
      $field7name = $row["return_date"];
      $field8name = $row["cost"];
      $field9name = $row["period"]; 
      $field10name = $row["picked_up"];
      $field11name = $row["returned"];
      $field12name = $row["model"]; 
      $field13name = $row["year"];
      $field14name = $row["colour"]; 
      $field15name = $row["price"];
      $field16name = $row["office_id"]; 

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
            <td>'  .$field13name.'</td> 
            <td>'  .$field14name.'</td> 
            <td>'  .$field15name.'</td> 
            <td>'  .$field16name.'</td> 
        </tr>';
  }
}
  else
{
  echo' <div style="position: relative; top: 100;">
  <h2 style="position: relative; color: red; left: 600px; top: 200px; font-size:50px;"> No reservations in this period.</h2>
  </div>';
}
}


?>