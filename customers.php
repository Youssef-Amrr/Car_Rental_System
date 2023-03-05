<?php
require('database.php');
    $query=mysqli_query($database_connection,"select * from customer"); 
    $count=mysqli_num_rows($query);
    if($count!=0){  
    echo 
    '
    <link href="stylefile.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <br><br><br><br>
    <h1>Customers</h1>
    <table class="table table-striped "cellspacing="2" cellpadding="2"> 
    <tr> 
    <thead class="thead-dark">
      <th scope="col"> <font face="Arial">Customer Id</font> </th> 
      <th scope="col"> <font face="Arial"> First Name</font> </th> 
      <th scope="col"> <font face="Arial"> Last Name</font> </th> 
      <th scope="col"> <font face="Arial"> Email</font> </th> 
    </thead>
    </tr>
    '
    ;

 
  while($row = mysqli_fetch_assoc($query)){
      $field1name = $row["cust_id"];
      $field2name = $row["fname"];
      $field3name = $row["lname"];
      $field4name = $row["email"];
      echo '<tr> 
            <td>'.$field1name.'</td> 
            <td>'  .$field2name.'</td> 
            <td>'  .$field3name.'</td> 
            <td>'  .$field4name.'</td> 
        </tr>';
  }
}
else
{
  echo' <div style="position: relative; top: 100;">
  <h2 style="position: relative; color: red; left: 600px; top: 200px; font-size:50px;"> No Customers are registered on system</h2>
  </div>';
}

?>