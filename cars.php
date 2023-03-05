<?php
require('database.php');
   $query=mysqli_query($database_connection,"select * from car"); 
   $count=mysqli_num_rows($query);
   if($count!=0){       
    echo '
    <br><br><br><br>
    <h1>Cars</h1>
    <link href="stylefile.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <table class="table table-striped" border="0" cellspacing="2" cellpadding="2"> 
    <tr> 
    <thead class="thead-dark">    
          <th  scope="col"> <font face="Arial">Plate ID</font> </th> 
          <th  scope="col"> <font face="Arial">Model</font> </th> 
          <th  scope="col"> <font face="Arial">Year</font> </th> 
          <th  scope="col"> <font face="Arial">Colour</font> </th> 
          <th  scope="col"> <font face="Arial">Price</font> </th> 
          <th  scope="col"> <font face="Arial">Office ID</font> </th> 
        </thead>
        </tr>
        ';
        while($row = mysqli_fetch_assoc($query)){
      $field1name = $row["plate_id"];
      $field2name = $row["model"];
      $field3name = $row["year"];
      $field4name = $row["colour"];
      $field5name = $row["price"];
      $field6name = $row["office_id"]; 
      echo '<tr> 
            <td>'.$field1name.'</td> 
            <td>'  .$field2name.'</td> 
            <td>'  .$field3name.'</td> 
            <td>'  .$field4name.'</td> 
            <td>'  .$field5name.'</td> 
            <td>'  .$field6name.'</td> 
        </tr>';
  }
}
else
{
  echo' <div style="position: relative; top: 100;">
  <h2 style="position: relative; color: red; left: 600px; top: 200px; font-size:50px;"> No Cars On System</h2>
  </div>';
}

?>