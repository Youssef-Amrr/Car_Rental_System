<?php
require('database.php');
if(isset($_POST['submit4']))
{
   $start=$_POST['start4'];
   $end=$_POST['end4'];
   if ($start == "" && $end == "")
   {
      $query="SELECT * FROM CAR as C NATURAL JOIN reservation as R";
   }
   else if ($start == "")
   {
    $query="SELECT * FROM CAR as C NATURAL JOIN reservation as R where R.return_date<='".$end."'";
   }
   else if ($end == "")
   {
    $query="SELECT * FROM CAR as C NATURAL JOIN reservation as R where  R.pickup_date>='".$start."'";
   }
   else
   {
    $query="SELECT * FROM CAR as C NATURAL JOIN reservation as R where R.pickup_date>='".$start."' and R.return_date<='".$end."'";
   }

   if(!empty($_POST['plate_id4'])){
       $plate_id=$_POST['plate_id4'];
       $query = $query . " AND C.plate_id = '" .$plate_id."'"; 
   }
   if(!empty($_POST['model4'])){
       $model=$_POST['model4'];
       $query = $query . " AND C.model = '" .$model."'"; 
   }
   if(!empty($_POST['price4'])){
       $price=$_POST['price4'];
       $query = $query . " AND C.price = '" .$price."'";
   }
   if(!empty($_POST['year4'])){
       $year=$_POST['year4'];
       $query = $query . " AND C.year >= " .$year;
   }
   if(!empty($_POST['colour4'])){
       $colour=$_POST['colour4'];
       $query = $query . " AND C.colour = '".$colour."'";
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

      <th scope="col"> <font face="Arial">Plate Id</font> </th> 
      <th scope="col"> <font face="Arial"> Model</font> </th> 
      <th scope="col"> <font face="Arial"> Year</font> </th> 
      <th scope="col"> <font face="Arial"> Colour</font> </th> 
      <th scope="col"> <font face="Arial"> Price</font> </th> 
      <th scope="col"> <font face="Arial"> Office Id</font> </th> 
      <th scope="col"> <font face="Arial"> Customer Id</font> </th> 
      <th scope="col"> <font face="Arial">Pickup_Date</font> </th> 
      <th scope="col"> <font face="Arial">Return_Date</font> </th> 
      <th scope="col"> <font face="Arial">Cost</font> </th> 
      <th scope="col"> <font face="Arial">Period</font> </th> 
      <th scope="col"> <font face="Arial"> PickedUp</font> </th> 
      <th scope="col"> <font face="Arial"> Returned</font> </th> 
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
      $field7name = $row["cust_id"];
      $field8name = $row["pickup_date"];
      $field9name = $row["return_date"];
      $field10name = $row["cost"];
      $field11name = $row["period"]; 
      $field12name = $row["picked_up"];
      $field13name = $row["returned"];
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
        </tr>';
  }
}
  else
  {
    echo' <div style="position: relative; top: 100;">
    <h2 style="position: relative; color: red; left: 600px; top: 200px; font-size:50px;"> This Car is not reserved in this period.</h2>
    </div>';
  }
}
?>



