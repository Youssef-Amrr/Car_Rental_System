<?php
require('database.php');
  if(isset($_POST['submit2']))
  {
    $start=$_POST['start2'];
    $end=$_POST['end2'];

    if ($start == "" && $end == "")
    {
       $query="select pickup_date, sum(cost) from reservation group by pickup_date";
    }
    else if ($start == "")
    {
     $query="select pickup_date, sum(cost) from reservation where return_date<='".$end."' group by pickup_date";
    }
    else if ($end == "")
    {
     $query="select pickup_date, sum(cost) from reservation where pickup_date>='".$start."' group by pickup_date";
    }
    else
    {
     $query="select pickup_date, sum(cost) from reservation where pickup_date>='".$start."' and pickup_date<='".$end."' group by pickup_date";
    }

    $query=mysqli_query($database_connection,$query); 
    $count=mysqli_num_rows($query);
    if($count!=0){       
 
    echo 
    '
    <link href="stylefile.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <br><br><br><br>
    <h1>Daily Payments</h1>
    <table class="table table-striped" border="0" cellspacing="2" cellpadding="2"> 
    <tr> 
    <thead class="thead-dark">
      <th scope="col"> <font face="Arial">Day</font> </th> 
      <th scope="col"> <font face="Arial">Total Payment</font> </th> 
    </thread>    
    </tr>
    ';
    

 
  while($row = mysqli_fetch_assoc($query)){
      $field1name = $row["pickup_date"];
      $field2name = $row["sum(cost)"];
      echo '<tr> 
            <td>'.$field1name.'</td> 
            <td>'  .$field2name.'</td> 
        </tr>';
  }
    }
    else
    {
      echo' <div style="position: relative; top: 100;">
      <h2 style="position: relative; color: red; left: 600px; top: 200px; font-size:50px;"> No payments are made in this period.</h2>
      </div>';
    }
  }

?>