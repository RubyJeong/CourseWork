<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="project2.css">
    <meta charset="UTF-8">
    <title>XYZ Travel Agency - Register</title>
</head>
<body>
<h1>Register Page</h1>

<form method="post">
    <div id="cus_info">
        <h3>User Information</h3>
        <label>Name:</label>
        <input type="text" name="name" placeholder="Your Name"/><br><br>

        <label>Email:</label>
        <input type="email" name="email" placeholder="userN@gmail.com"/><br><br>

        <label>Password:</label>
        <input type="password" name="password"/><br><br>

        <label>Confirm-Password:</label>
        <input type="password" name="confirm_password"/><br><br>

        <label>Address:</label>
        <input type="text" name="address" placeholder="Toronto"/><br><br>
    </div>

    <h3>Tour Information</h3>
    <label>Tour</label>
    <select name="tour">
        <option value="CN Tower">CN Tower</option>
        <option value="Wonderland">Wonderland</option>
        <option value="Thousand Islands">Thousand Islands</option>
    </select>

    <label>Travel Date:</label>
    <input type="date" name="date"/><br><br>

    <input type="submit" value="Create" name="create"/><br><br>
    <input type='submit' value="Back" name="back"/><br><br>
</form>
</body>
</html>

<?php
if (isset($_POST['create'])) {

    $con = mysqli_connect("localhost", "root", "","Project02")
    or die  ("Connection is failed ");

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $address = $_POST['address'];
    $tour = $_POST['tour'];
    $date = $_POST['date'];

    if (empty($name)||empty($email)||empty($password)||empty($address)||empty($date)){
        echo "Please fill all the missing fields!";
    } else if ($password != $confirm_password) {
        echo "Confirm-password doesn't match with the password!";
    } else {
        //Insert to Users table.
        $re_id = rand(100000,999999);
        $query = "insert into Users value ('$re_id','$email','$password','$name','$address')";
        $result = mysqli_query($con, $query) or die ("Query is failed: " . mysqli_error($con));
        if (mysqli_affected_rows($con) > 0) {
            echo "Account is created successfully. Your Registration ID: $re_id<br><br>";
        } else {
            echo "Fail to create an account!";
        }

        //Insert to Tours table
        $query = "select * from tours where tour_name = '$tour' && travel_date = '$date'";
        $result = mysqli_query($con, $query) or die ("Query is failed: " . mysqli_error($con));
        if (mysqli_num_rows($result) == 0) {
            $tour_id = rand(100,999);
            $query = "insert into tours value ('$tour_id','$tour','$date')";
            $result = mysqli_query($con, $query) or die ("Query is failed: " . mysqli_error($con));
        }
        $query = "select tour_id from tours where tour_name = '$tour' && travel_date = '$date'";
        $result = mysqli_query($con, $query) or die ("Query is failed: " . mysqli_error($con));
        $tour_id = mysqli_fetch_row($result)[0];

        $query = "insert into groups value ('$tour_id','$re_id')";
        $result = mysqli_query($con, $query) or die ("Query is failed: " . mysqli_error($con));
    }
}

if (isset($_POST['back'])) {
    header('location: start.php');
}
?>