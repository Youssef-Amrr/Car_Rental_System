<!DOCTYPE html>
<?php
    session_start();
    require('database.php');
?>
<head>
        <title>
            Available Cars
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

    $sql = $_SESSION['myquery'];
    $pickupdate = $_SESSION['pickupdate'];
    $returndate = $_SESSION['returndate'];
    $cust_id=$_SESSION['cust_id'];
    $date11 = strtotime($pickupdate); 
    $PD = getDate($date11); 
    $date22 = strtotime($returndate); 
    $RD = getDate($date22);
    $query2 = mysqli_query($database_connection,$sql);   
    $count=mysqli_num_rows($query2);
    if($count!=0){       
    echo '
    <br><br>
    <h1>Choose your Car</h1>
    <table class="table table-striped" style="position: relative;  position: relative; top: 50px;"'; 
    echo '
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <tr> 
    <thead class="thead-dark">
    <th  scope="col"> <font face="Arial">Car Model</font> </th> 
    <th  scope="col"> <font face="Arial">Year</font> </th> 
    <th  scope="col"> <font face="Arial">Colour</font> </th> 
    <th  scope="col"> <font face="Arial">Price</font> </th>
    <th  scope="col"> <font face="Arial">Office Location</font> </th> 
    <th scope="col"> <font face="Arial">Reserve</font> </th>
    </thead>
    </tr>
    ';
    $i=0;
    while($row = mysqli_fetch_assoc($query2))          
    {
        $field1name = $row["model"];
        $field2name = $row["year"];
        $field3name = $row["colour"];
        $field4name = $row["price"];
        $field5name = $row["location"];

        echo '<tr> 
            <td class="row-data">'  .$field1name.'</td> 
            <td class="row-data">'  .$field2name.'</td> 
            <td>'  .$field3name.'</td> 
            <td>'  .$field4name.'</td>
            <td>'  .$field5name.'</td>';
            echo "<td>" . '<form type="POST"><input type="hidden" name="id" value='.$row['plate_id'].'><input type="submit" name="reserve_btn" value="Reserve"></form>' . "</td>";
            echo "</tr>";
    }
    echo '</table>';
}
else{
    echo' <div style="position: relative; top: 100;">
            <h2 style="position: relative; left: 10px;"> No cars available for the specified criteria </h2>
            </div>';
}
if(isset($_REQUEST['reserve_btn']))
{
    $plate_id=$_REQUEST['id'];
    $sql_car_state = "SELECT CS.`from`,CS.`to`
            FROM  CAR_STATUS AS CS 
            WHERE CS.plate_id = '".$plate_id."' AND CS.state = 'Available' AND '".$pickupdate."' >= CS.`from` AND ('" .$returndate. "' <= CS.`to` OR CS.`to` IS NULL )";
    $query = mysqli_query($database_connection,$sql_car_state);
    $my_row = mysqli_fetch_assoc($query);
    $AF1=$my_row["from"];
    $AT1=$my_row["to"];
    $date1 = strtotime($AF1); 
    $AF = getDate($date1); 
    $date2 = strtotime($AT1); 
    $AT = getDate($date2);
    if($AF == $PD and $AT == $RD){
    $q1="UPDATE CAR_STATUS AS CS SET CS.state= 'Not Available' WHERE CS.plate_id= '".$plate_id."' AND state='Available' AND CS.`from`='".$AF1."'";
    mysqli_query($database_connection,$q1);
    }
    elseif($AF == $PD){
        $q1="DELETE FROM CAR_STATUS WHERE plate_id='".$plate_id."' AND `from`='".$AF1."' AND state='Available'";
        $q2="INSERT INTO CAR_STATUS (plate_id, state, `from`, `to`) values ('".$plate_id."', 'Not Available', '".$pickupdate."', '".$returndate."')";
        if(is_null($AT1)){
            $q3="INSERT INTO CAR_STATUS (plate_id, state, `from`, `to`) values ('".$plate_id."', 'Available',DATE_ADD('".$returndate."', INTERVAL +1 DAY),NULL)";
        }
        else $q3="INSERT INTO CAR_STATUS (plate_id, state, `from`, `to`) values ('".$plate_id."', 'Available',DATE_ADD('".$returndate."', INTERVAL +1 DAY),'".$AT1."')";
        mysqli_query($database_connection,$q1);
        mysqli_query($database_connection,$q2);
        mysqli_query($database_connection,$q3);
    }        
    elseif ($AT == $RD){
        $q1="UPDATE CAR_STATUS AS CS SET CS.`to`=DATE_ADD('".$pickupdate."', INTERVAL -1 DAY) WHERE CS.plate_id='".$plate_id."' AND CS.`from`='".$AF1."' AND CS.state='Available'";
        $q2="INSERT INTO CAR_STATUS (plate_id, state, `from`, `to`) values ('".$plate_id."', 'Not Available', '".$pickupdate."', '".$returndate."')";
        mysqli_query($database_connection,$q1);
        mysqli_query($database_connection,$q2);

    } 
    else
    {
        $q1="UPDATE CAR_STATUS AS CS SET CS.`to`=DATE_ADD('".$pickupdate."', INTERVAL -1 DAY) WHERE CS.plate_id='".$plate_id."' AND CS.`from`='".$AF1."' AND CS.state='Available'";
        $q2="INSERT INTO CAR_STATUS (plate_id, state, `from`, `to`) values ('".$plate_id."', 'Not Available', '".$pickupdate."', '".$returndate."')";
        if(is_null($AT1)){
            $q3="INSERT INTO CAR_STATUS (plate_id, state, `from`, `to`) values ('".$plate_id."', 'Available',DATE_ADD('".$returndate."', INTERVAL +1 DAY), NULL)";
        }
        else {
        $q3="INSERT INTO CAR_STATUS (plate_id, state, `from`, `to`) values ('".$plate_id."', 'Available',DATE_ADD('".$returndate."', INTERVAL +1 DAY), '".$AT1."')";
        }
        mysqli_query($database_connection,$q1);
        mysqli_query($database_connection,$q2);
        mysqli_query($database_connection,$q3);
    }
    $sql_car_info = "SELECT C.model,C.`year`,C.colour,C.price,O.location,C.office_id
            FROM  CAR AS C NATURAL JOIN OFFICE AS O
            WHERE C.plate_id = '".$plate_id."'";
    $query = mysqli_query($database_connection,$sql_car_info);
    $car_row = mysqli_fetch_assoc($query);
    $date_diff = ceil((abs($date11-$date22)/(60*60*24))+1);
    $c_model=$car_row["model"];
    $c_year=$car_row["year"];
    $c_colour=$car_row["colour"];
    $c_price=$car_row["price"];
    $c_location=$car_row["location"];
    $O_id=$car_row["office_id"];
    $_SESSION['office_id']=$O_id;
    $_SESSION['cust_id']=$cust_id;
    $_SESSION['p_id']=$plate_id;
    $_SESSION['c_model']=$c_model;
    $_SESSION['c_year']=$c_year;
    $_SESSION['c_colour']=$c_colour;
    $_SESSION['c_price']=$c_price;
    $_SESSION['c_location']=$c_location;
    $_SESSION['date_diff']= $date_diff;
    $_SESSION['returndate']= $returndate;
    $_SESSION['pickupdate']= $pickupdate;
    $_SESSION['cost']=$date_diff*$c_price;
    $_SESSION['available_from']=$AF1;
    $_SESSION['available_to']=$AT1;
    header("Location: payment.php");
}
?>
      
</html>

