<?php
require('database.php');

   $query=mysqli_query($database_connection,"select office_id, location, count(*) from office Natural Join car group by office_id"); 
   $count=mysqli_num_rows($query);
   if($count!=0){       
    echo '
    <br><br><br><br>
    <h1>Offices</h1>
    <link href="stylefile.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <table class="table table-striped" border="0" cellspacing="2" cellpadding="2"> 
    <tr> 
    <thead class="thead-dark">    
          <th  scope="col"> <font face="Arial">Office ID</font> </th> 
          <th  scope="col"> <font face="Arial">Location</font> </th> 
          <th  scope="col"> <font face="Arial">Number Of Cars</font> </th> 
        </thead>
        </tr>

        ';
        while($row = mysqli_fetch_assoc($query)){
      $field1name = $row["office_id"];
      $field2name = $row["location"];
      $field3name = $row["count(*)"];
      echo '<tr> 
            <td>'.$field1name.'</td> 
            <td>'  .$field2name.'</td> 
            <td>'  .$field3name.'</td> 
        </tr>';
  }
}
else
{
  echo' <div style="position: relative; top: 100;">
  <h2 style="position: relative; color: red; left: 600px; top: 200px; font-size:50px;">No Offices</h2>
  </div>';
}

?>