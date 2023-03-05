<!DOCTYPE html>
<head>
        <title>
            Update Car
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
    
    $value = 'Available';
    $value2 = 'Out of Service';
    $query=mysqli_query($database_connection,"select * from car_status where state='".$value."' or state='".$value2."'"); 
    $count=mysqli_num_rows($query);
    if($count!=0){       
    echo '
    <br><br><br><br>
    <h1>Update Car State</h1>
    <table class="table table-striped" style="position: relative;left: 0px; position: relative; top: 50px;"'; 
    echo '
    <tr> 
    <thead class="thead-dark">
    <th scope="col"> <font face="Arial">Plate Id</font> </th>  
    <th scope="col"> <font face="Arial">State</font> </th> 
    <th scope="col"> <font face="Arial">From</font> </th> 
    <th scope="col"> <font face="Arial">To</font> </th>  
    <th scope="col"> <font face="Arial">Button</font> </th>  
    </thead>
    </tr>

    ';
    $i=0;
    while($row = mysqli_fetch_assoc($query))          
    {
        $field1name = $row["plate_id"];
        $field2name = $row["state"];
        $field3name = $row["from"];
        $field4name = $row["to"];
        if ($row["state"] == 'Available')
            $buttonVal = 'OutofService';
        else
            $buttonVal = 'Available'; 
        echo '<tr >
            <td >'  .$field1name.'</td> 
            <td >'  .$field2name.'</td> 
            <td>'  .$field3name.'</td> 
            <td>'  .$field4name.'</td>'; 
            echo "<td>" . '<form type="POST"><input type="hidden" name="id" value='.$row["plate_id"].';'.$row["state"].';'.$row["from"].'><input id="butID"  type="submit" name="pick_btn" value='.$buttonVal.'></form>' . "</td>";
            echo "</tr>";
            
            $i = $i + 1;
    }
    echo '</table>';
}
else{
    echo' <div style="position: relative; top: 100;">
            <h2 style="position: relative; color: red; left: 900px; top: 200px; font-size:50px;"> No Cars Pending Pick Up</h2>
            </div>';
}
if(isset($_REQUEST['pick_btn']))
{
    $value=$_REQUEST['id'];
    $plate_id = strtok($value, ';');
    $state = strtok(";");
    $from = strtok(";");
    $rented = 'Rented';
    $out = 'Out of Service';
    $av = 'Available';
    $today = date("Y-m-d");
    if ($state == 'Available')
    { 
        $sql = "delete from car_status where `from` >= '".$from."' and plate_id = '".$plate_id."'";
        echo $sql;
        mysqli_query($database_connection, $sql);
        $sql = "insert into car_status (plate_id, state, `from`) values ('".$plate_id."', '".$out."', '".$from."')";
        mysqli_query($database_connection, $sql);
        $query=mysqli_query($database_connection,"select * from reservation where (pickup_date >= '".$from."'  or return_date >= '".$from."') and plate_id = '".$plate_id."'"); 
        $count=mysqli_num_rows($query);
        $sql = "delete from reservation where (pickup_date >= '".$from."'  or return_date >= '".$from."')  and plate_id = '".$plate_id."'";
        if (mysqli_query($database_connection, $sql)) {
            echo '
            <script type="text/javascript">
            var x = '.$count.';
            if (x == 0)
                alert("This car has no current or upcoming reservations.");
            else
                alert(x + " reservation(s) are canceled for this car.");
            window.location = "http://localhost/phpmyadmin/Final/updatecar.php";
            </script>'
            ;
        }  
    }
    else {
        $sql ="delete from car_status where ((state != 'Rented') or state != 'Not Available') and plate_id= '".$plate_id."' ";
        if (mysqli_query($database_connection, $sql)) {

        }
        $sql = "insert into car_status values ('".$plate_id."', '".$av."', '".$today."', NULL)";
        if (mysqli_query($database_connection, $sql)) {
            header("Location: http://localhost/phpmyadmin/Final/updatecar.php");
        }
    }
}
    ?>
    <br><br><br> 
<a href="http://localhost/phpmyadmin/final/adminHome.html">Back To Admin Page.</a> 
<br><br><br>
   
</html>


