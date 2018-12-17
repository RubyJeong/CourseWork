<?php
session_start();
if(isset($_SESSION['editID'])){
    $con = mysqli_connect("localhost", "root", "", "Project02")
    or die  ("Connection is failed.");

    $editID = $_SESSION['editID'];
    $query = "select s.re_id, email, s.customer_name, s.address, t.tour_name, t.travel_date
              from users s, tours t, groups g
              where s.re_id = g.re_id && t.tour_id = g.tour_id && s.re_id='$editID'
              order by t.travel_date, t.tour_name";
    $result = mysqli_query($con, $query)
    or die ("Failed: " . mysqli_error($con));

    $row = mysqli_fetch_row($result);
    $email = $row[1];
    $name = $row[2];
    $address = $row[3];
    $tour = $row[4];
    $date = $row[5];

    if(isset($_POST['save'])){
        $name = $_POST['name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $tour = $_POST['tour'];
        $date = $_POST['date'];

        if (empty($name)||empty($email)||empty($address)||empty($date)){
            echo "Please fill all the missing fields!";
        } else {
            $query = "update users set email='$email',customer_name='$name',address='$address' where re_id='$editID'";
            $result = mysqli_query($con, $query) or die ("query is failed: " . mysqli_error($con));
            if (mysqli_affected_rows($con) > 0){
                header('location: adminPage.php');
            } else {
                echo "Fail.";
            }

            //Update the new tour to Tours Table
            $query = "select * from tours where tour_name = '$tour' && travel_date = '$date'";
            $result = mysqli_query($con, $query) or die ("Query is failed: " . mysqli_error($con));
            if (mysqli_num_rows($result) == 0) {
                $tour_id = rand(100,999);
                $query = "insert into tours value ('$tour_id','$tour','$date')";
                $result = mysqli_query($con, $query) or die ("Query is failed: " . mysqli_error($con));
            }

            //Update Groups Table
            $query = "select tour_id from tours where tour_name = '$tour' && travel_date = '$date'";
            $result = mysqli_query($con, $query) or die ("Query is failed: " . mysqli_error($con));
            $tour_id = mysqli_fetch_row($result)[0];

            $query = "update groups set tour_id='$tour_id' where re_id='$editID'";
            $result = mysqli_query($con, $query) or die ("Query is failed: " . mysqli_error($con));
        }
        mysqli_close($con);
    }

    if (isset($_POST['back'])) {
        header('location: adminPage.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="project2.css">
    <meta charset="UTF-8">
    <title>XYZ Travel Agency - Edit Customer</title>
</head>
<body>
<h1>Edit Information</h1>

<form method="post">
    <h3>Customer Information - Registration ID: <?php echo $_SESSION['editID']?></h3>
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo $name?>"/><br><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $email?>"/><br><br>

    <label>Address:</label>
    <input type="text" name="address" value="<?php echo $address?>"/><br><br>

    <h3>Tour Information</h3>
    <label>Tour</label>
    <select name="tour">
        <option value="CN Tower">CN Tower</option>
        <option value="Wonderland">Wonderland</option>
        <option value="Thousand Islands">Thousand Islands</option>
    </select>

    <label>Travel Date:</label>
    <input type="date" name="date" value="<?php echo $date?>"/><br><br>

    <input type="submit" value="Save" name="save"/><br><br>
    <input type='submit' value='Back' name='back'/><br><br>
</form>
</body>
</html>
