<!DOCTYPE html>
<head>
        <title>
            Return
        </title>
        <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
        <script type="text/javascript"></script>
        <link href="stylefile.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet"
              href=
"https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
              integrity=
"sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
              crossorigin="anonymous" />
        <meta name=”viewport” content=”width=device-width, initial-scale=1″>
    </head>

    <body>
    <?php
    require('database.php');
    $novalue='n';
    $yesvalue='y';
    $query=mysqli_query($database_connection,"select * from reservation where reservation.picked_up = '".$yesvalue."' AND reservation.returned='".$novalue."'"); 
    $count=mysqli_num_rows($query);
    if($count!=0){       
    echo 
    '
    <br><br><br><br>
    <h1>Return Car</h1>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <table class="table table-striped" style="position: relative;left: 0px; position: relative; top: 50px;"'; 
    echo '
    <tr>
    <thead class="thead-dark"> 
    <th scope="col"> <font face="Arial">Customer Id</font> </th> 
    <th scope="col"> <font face="Arial">Plate Id</font> </th>  
    <th scope="col"> <font face="Arial">Pick Up Date</font> </th> 
    <th scope="col"> <font face="Arial">Return Date</font> </th> 
    <th scope="col"> <font face="Arial">Cost</font> </th>  
    <th scope="col"> <font face="Arial">Period</font> </th> 
    <th scope="col"> <font face="Arial">Picked Up</font> </th> 
    <th scope="col"> <font face="Arial">Returned</font> </th> 
    <th scope="col"> <font face="Arial">Return</font> </th> 
    </thead>
    </tr>
    ';
    $i=0;
    while($row = mysqli_fetch_assoc($query))          
    {
        $field1name = $row["cust_id"];
        $field2name = $row["plate_id"];
        $field3name = $row["pickup_date"];
        $field4name = $row["return_date"];
        $field5name = $row["cost"];
        $field6name = $row["period"];
        $field7name = $row["picked_up"];
        $field8name = $row["returned"];

        echo '<tr >
            <td class="row-data">'  .$field1name.'</td> 
            <td class="row-data">'  .$field2name.'</td> 
            <td>'  .$field3name.'</td> 
            <td>'  .$field4name.'</td>
            <td>'  .$field5name.'</td> 
            <td>'  .$field6name.'</td> 
            <td>'  .$field7name.'</td> 
            <td>'  .$field8name.'</td>'; 
            echo "<td>" . '<form type="POST"><input type="hidden" name="id" value='.$row["cust_id"].';'.$row["plate_id"].';'.$row["pickup_date"].'><input type="submit" name="return_btn" value="Return"></form>' . "</td>";
            echo "</tr>";
            
            $i = $i + 1;
    }
    echo '</table>';
}
else{
    echo' <div style="position: relative; top: 100;">
    <h2 style="position: relative; color: red; left: 600px; top: 200px; font-size:50px;"> No Cars Pending Return</h2>
    </div>';
}
if(isset($_REQUEST['return_btn']))
{
    $value=$_REQUEST['id'];
    $cust_id = strtok($value, ';');
    $plate_id = strtok(";");
    $pickup_date = strtok(";");
    $returnquery = "update reservation set reservation.returned = '".$yesvalue."' where reservation.plate_id='".$plate_id."' AND reservation.cust_id='".$cust_id."' AND reservation.pickup_date='".$pickup_date."' "; 
    if (mysqli_query($database_connection, $returnquery)) {
        header("Location: http://localhost/phpmyadmin/Final/return.php");
    }}
?>
<br><br><br> 
<a href="http://localhost/phpmyadmin/Final/adminHome.html">Back To Admin Page.</a> 
<br><br><br>
</html>