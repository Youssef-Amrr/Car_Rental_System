<!DOCTYPE html>
<?php
    session_start();
    require('database.php');
?>
<html>
    <head>
        <title>
            Customer Page
        </title>
        <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
        <script type="text/javascript"></script>
        <link href="stylefile.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <meta name=”viewport” content=”width=device-width, initial-scale=1″>
    </head>
    <style>
        h1 {
    font-weight: bold; 
    position: relative; 
    bottom: 70px; 
    color:#483D8B;
}
#leftDIV {
                float:left; 
                width:50%;
                height:280px;
            }
            #rightDIV{
                float:left;
                width:50%;
                height:280px;
            }
        </style>
        

    <body>
        <br><br><br>
    <div id = "leftDIV" style="position: relative; top: 0;">
        <h1 style="position: relposition:relative; top:-50px">Welcome <?php echo $_SESSION['fname'];?>  !</h1><br>
        <h1 style="position: relative;"><?php echo $_SESSION['reservation_confirmation'];?></h1>
    <?php
        $customer_id=$_SESSION['id'];
        $query2 = mysqli_query($database_connection,"select * from reservation where cust_id='$customer_id'");
        $reserved_cars = array();
        $count=mysqli_num_rows($query2);
        if($count!=0){
            echo '
            <p style="font-size:30px; position:relative; top:-40px;left:20px; font-weight:bold;">Your Reservations<p>
            <table class="table table-striped" style="position:  max-width: 500px;relative; left: 10px; position: relative; top: 10px;"'; 
            echo '
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <tr> 
            <thead class="thead-dark">   
              <th> <font face="Arial">Plate ID</font> </th> 
              <th> <font face="Arial">PickUp Date</font> </th> 
              <th> <font face="Arial">Return Date</font> </th> 
              <th> <font face="Arial">Cost</font> </th> 
              <th> <font face="Arial">Period</font> </th> 
              <th> <font face="Arial">PickedUp?</font> </th> 
              <th> <font face="Arial">Returned?</font> </th> 
            </thead>   
            </tr>
            ';
        while($row = mysqli_fetch_assoc($query2)){
            $field1name = $row["plate_id"];
            $field2name = $row["pickup_date"];
            $field3name = $row["return_date"];
            $field4name = $row["cost"];
            $field5name = $row["period"]; 
            $field6name = $row["picked_up"];
            $field7name = $row["returned"];
            echo '<tr> 
                  <td>'  .$field1name.'</td> 
                  <td>'  .$field2name.'</td> 
                  <td>'  .$field3name.'</td> 
                  <td>'  .$field4name.'</td> 
                  <td>'  .$field5name.'</td> 
                  <td>'  .$field6name.'</td> 
                  <td>'  .$field7name.'</td>
                </tr>';
        }
        echo '</table>';
    }
    else 
         {
           echo' <div style="position: relative;font-color:red;">
            <h2 style="position: relative; left: 0px;"> No Rented Cars yet </h2>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br>
            ';


         }   
        ?>
        <?php
         if(isset($_POST['submit'])){
            $pickupdate=$_POST['pickupdate']; $returndate=$_POST['returndate'];
            $sql = "SELECT C.model,C.year,C.colour,C.price,O.location,C.plate_id,CS.`from`,CS.`to`
            FROM CAR AS C NATURAL JOIN CAR_STATUS AS CS NATURAL JOIN OFFICE AS O
            WHERE CS.state = 'Available' AND '".$pickupdate."' >= CS.`from` AND ('" .$returndate. "' <= CS.`to` OR CS.`to` IS NULL )";

            if(!empty($_POST['model'])){
                $model=$_POST['model'];
                $sql = $sql . " AND C.model = '" .$model."'"; 
            }
            if(!empty($_POST['office'])){
                $office=$_POST['office'];
                $sql = $sql . " AND O.location = '" .$office."'"; 
            }
            if(!empty($_POST['color'])){
                $color=$_POST['color'];
                $sql = $sql . " AND C.colour = '" .$color."'";
            }
            if(!empty($_POST['minprice'])){
                $minprice=$_POST['minprice'];
                $sql = $sql . " AND C.price >= " .$minprice;
            }
            if(!empty($_POST['maxprice'])){
                $maxprice=$_POST['maxprice'];
                $sql = $sql . " AND C.price <= " .$maxprice;
            }
            if(!empty($_POST['year'])){
                $model=$_POST['year'];
                $sql = $sql . " AND C.`year` = " .$year;
            }
            $_SESSION['myquery']=$sql;
            $_SESSION['pickupdate']=$pickupdate;
            $_SESSION['returndate']=$returndate;
            $_SESSION['cust_id']=$customer_id;
            header("Location: available_cars.php");
        }
    ?>
    </div>
        <div id="rightDIV">
            <br>
            <h1 style="position:relative; right:3px;">Search for a car</h1>
            <div style="position: relative; bottom:70px;">
            <form style="width: 450px;position: relative;left: 150px" onsubmit="return validate()" name="searchForm" action="#" method = "POST">
                <div class="form-group">
                    <h3>Enter the required period</h3>
                    <input id='pickupdate' type="text" class="form-control" name="pickupdate" autocomplete="on" placeholder="Pickup Date (YYYY-MM-DD)">
                    <br>
                    <input id='returndate' type="text" class="form-control" name="returndate" autocomplete="on" placeholder="Return Date (YYYY-MM-DD)">
                    <br>
                    <h3>Enter car specifications</h3>
                    <input id="office" type="text" class="form-control" name="office" autocomplete="on" placeholder="Office Location...">
                    <br>
                    <input id="model" type="text" class="form-control" name="model" autocomplete="on" placeholder="Model...">
                    <br>
                    <input id="year" type="text" class="form-control" name="year" autocomplete="on"  placeholder="Year...">
                    <br>
                    <input id="color" type="text" class="form-control" name="color" autocomplete="on" placeholder="Color...">
                    <br>
                    <h3>Enter the price range</h3>
                    <input id='minprice' type="text" class="form-control" name="minprice" autocomplete="on" placeholder="Minimum Price...">
                    <br>
                    <input id='maxprice' type="text" class="form-control" name="maxprice" autocomplete="on" placeholder="Maximum Price...">
                    <button style="position:relative; top:15px; left: 160px;"id='search-button' type="submit" name="submit" class="btn btn-primary">Search</button>
                    <br>
                    <p style="position:relative; bottom:15px; left: 300px;">Back to <a href="index.html">Login</a></p>
                </div>
            </form>
        </div>
    </div>
    </body>
    <script>
        function validate()
        {            
            // Validate empty inputs
            var pickupdate=document.forms["searchForm"]["pickupdate"].value;
            var returndate=document.forms["searchForm"]["returndate"].value;
            var office=document.forms["searchForm"]["office"].value;
            var model=document.forms["searchForm"]["model"].value;
            var minprice=document.forms["searchForm"]["minprice"].value;
            var maxprice=document.forms["searchForm"]["maxprice"].value;
            var color=document.forms["searchForm"]["color"].value;
            var year=document.forms["searchForm"]["year"].value;
            var regExp=/^(19|20)\d\d([- /.])(0[1-9]|1[012])\2(0[1-9]|[12][0-9]|3[01])$/;
            var stringRegExp= /^[A-Za-z]+$/;
            var numericRegExp=/^\d*\.?\d*$/;
            var yearRegExp=/^(19|20)\d{2}$/;
            x = ""
            if (pickupdate=="")
            {
                x = x + 'YOU MUST ENTER THE PICKUP DATE \n';
            }
            if (returndate=="")
            {
                x = x + 'YOU MUST ENTER THE RETURN DATE \n';
            }
            if (x != "")
            {
                alert(x);
                return false;
            }
            if (!regExp.test(pickupdate)) {
                    alert("INVALID PICKUP DATE!");
                    return false;
            }
            if (!regExp.test(returndate)) {
                    alert("INVALID RETURN DATE!");
                    return false;
            }
            var pickupdatesplit =pickupdate.split('-');
            var date1 =new Date(pickupdatesplit[0], pickupdatesplit[1] - 1, pickupdatesplit[2]); 
            var returndatesplit =returndate.split('-');
            var date2 =new Date(returndatesplit[0], returndatesplit[1] - 1, returndatesplit[2]); 
            if(date1 > date2)
            {
                alert("INVALID DATES: RETURN DATE IS BEFORE PICKUP DATE");
                return false;
            }
            if(office!="" && !stringRegExp.test(office)){
                alert("INVALID OFFICE ENTRY: OFFICE FIELD MUST BE STRING");
                return false;
            }
            if(model!="" && !stringRegExp.test(model)){
                alert("INVALID MODEL ENTRY: MODEL FIELD MUST BE STRING");
                return false;
            }
            if(year!="" && !yearRegExp.test(year)){
                alert("INVALID YEAR ENTRY: YEAR FIELD MUST BE NUMERIC");
                return false;
            }
            if(color!="" && !stringRegExp.test(color)){
                alert("INVALID COLOR ENTRY: COLOR FIELD MUST BE STRING");
                return false;
            }
            if(minprice!="" && !numericRegExp.test(minprice)){
                alert("INVALID MINIMUM PRICE ENTRY: PRICE FIELD MUST BE NUMERIC");
                return false;
            }
            if(maxprice!="" && !numericRegExp.test(maxprice)){
                alert("INVALID MAXIMUM PRICE ENTRY: PRICE FIELD MUST BE NUMERIC");
                return false;
            }
            

        }
    </script>
   

</html>


