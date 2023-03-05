<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Payment Confirmation</title>
    <link href="stylefile.css" rel="stylesheet" type="text/css"/>
</head>
<?php
    session_start();
    require('database.php');
?>
<?php
$O_id=$_SESSION['office_id'];
$cust_id=$_SESSION['cust_id'];
$plate_id=$_SESSION['p_id'];
$c_model=$_SESSION['c_model'];
$c_year=$_SESSION['c_year'];
$c_colour=$_SESSION['c_colour'];
$c_price=$_SESSION['c_price'];
$c_location=$_SESSION['c_location'];
$date_diff=$_SESSION['date_diff'];
$cost=$_SESSION['cost'];
$return_date=$_SESSION['returndate'];
$pickup_date=$_SESSION['pickupdate'];
if(isset($_POST['pay'])){
$q1="INSERT INTO RESERVATION (cust_id, plate_id, pickup_date, return_date, cost, `period`, picked_up, returned) values ('".$cust_id."', '".$plate_id."','".$pickup_date."','".$return_date."','".$cost."','".$date_diff."','n','n')";
$q2="UPDATE CAR_STATUS SET `state` = 'Rented' where plate_id = '".$plate_id."' AND `state`='Not Available' AND `from`='".$pickup_date."'";
$q3="Select fname from customer where cust_id='".$cust_id."'";
mysqli_query($database_connection,$q1);
mysqli_query($database_connection,$q2);
$row=mysqli_query($database_connection,$q3);
$rowfname = mysqli_fetch_assoc($row);
$_SESSION['id']= $cust_id;
$_SESSION['fname']= $rowfname["fname"];
$_SESSION['reservation_confirmation'] = "Your reservation is confirmed!";
header("Location: customer_start.php");
}
else if (isset($_POST['cancel'])){
    $AF1=$_SESSION['available_from'];
    $AT1=$_SESSION['available_to'];
    if (is_null($AT1)){
        $q1="DELETE FROM CAR_STATUS WHERE `from` >= '".$AF1."' AND plate_id='".$plate_id."'";
        $q2="INSERT INTO CAR_STATUS (plate_id, `state`, `from`, `to`) values ('".$plate_id."', 'Available','".$AF1."', NULL)";
    }
    else{
        $q1="DELETE FROM CAR_STATUS WHERE `from` >= '".$AF1."' AND (`to` <= '".$AT1."' )AND plate_id='".$plate_id."'";
        $q2="INSERT INTO CAR_STATUS (plate_id, `state`, `from`, `to`) values ('".$plate_id."', 'Available','".$AF1."','".$AT1."')";
    }
    $q3="Select fname from customer where cust_id='".$cust_id."'";
    mysqli_query($database_connection,$q1);
    mysqli_query($database_connection,$q2);
    $row=mysqli_query($database_connection,$q3);
    $rowfname = mysqli_fetch_assoc($row);
    $_SESSION['id']= $cust_id;
    $_SESSION['fname']= $rowfname["fname"];
    $_SESSION['reservation_confirmation'] = "No Reservation has been made!";
    header("Location: customer_start.php");
}
?>
<form class="form" name="Payment" method="post" onsubmit="return allvalidations()" action="#">
        <h1 class="login-title">Payment Confirmation</h1>
        <h2>Car Model: <?php echo $c_model  ?></h2><br>
        <h2>Colour: <?php echo $c_colour  ?></h2><br>
        <h2>Year: <?php echo $c_year  ?></h2><br>
        <h2>Price per day: <?php echo $c_price  ?></h2><br>
        <h2>Total cost: <?php echo $cost  ?></h2><br>
        <h2>Rent period: <?php echo $date_diff ?></h2><br>
        <h2>Office Location: <?php echo $c_location  ?></h2><br>
        <input type="submit" name="pay" value="Confirm Payment" class="login-button"><br>
        <input type="submit" name="cancel" value="Cancel Reservation" class="login-button">
    </form>
</html>    