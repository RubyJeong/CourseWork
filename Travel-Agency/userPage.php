<?php
session_start();
if(isset($_SESSION['email'])){
    $con = mysqli_connect("localhost", "root", "", "Project02")
    or die  ("Connection is failed.");

    $email = $_SESSION['email'];
    $query = "select s.re_id, email, s.customer_name, s.address, t.tour_name, t.travel_date
              from users s, tours t, groups g
              where s.re_id = g.re_id && t.tour_id = g.tour_id && email='$email'";
    $result = mysqli_query($con, $query)
    or die ("Failed: " . mysqli_error($con));

    $row = mysqli_fetch_row($result);
    $id = $row [0];
    $email = $row[1];
    $name = $row[2];
    $address = $row[3];
    $tour = $row[4];
    $date = $row[5];

    if (isset($_POST['logout'])) {
        header('location: start.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="project2.css">
    <meta charset="UTF-8">
    <title>XYZ Travel Agency - Customer</title>
</head>
<body>


<div id="cus_info">
    <h3>Customer Information</h3>
    <p>Email: <?php echo $email?></p>
    <p>Name: <?php echo $name?></p>
    <p>Address: <?php echo $address?>
</div>

<div id="cus_info">
    <h3>Tour Information</h3>
    <p>Tour: <?php echo $tour?></p>
    <p>Date: <?php echo $date?></p>
    <p>Registration ID: <?php echo $id?>
</div>

<div id="cus_info">
    <h3>Group Information</h3>
    <?php
    $con = mysqli_connect("localhost", "root", "","Project02")
    or die  ("Connection is failed.");

    $query = "select group_id, group_size from users where re_id='$id'";
    $result = mysqli_query($con, $query) or die ("Query is failed: " . mysqli_error($con));
    $groupInfo = mysqli_fetch_row($result);
    $group_id = $groupInfo[0];
    $group_size = $groupInfo[1];

    $query = "select email, customer_name, address from users
              where group_id='$group_id'";
    $result = mysqli_query($con, $query) or die ("Failed: " .mysqli_error($con));

    if($group_id > 0) {
        echo "<p>Group of $group_size - ID: $group_id</p>";
    } else {
        $miss = mysqli_num_rows($result) - $group_size;
        echo "<p>Group of $group_size is not confirmed, waiting for $miss more peoples to join.</p>";
    }

    echo "<table border ='1' align='center'>";
    echo "<tr id='table_title'><td><b>Email</b></td><td><b>Name</b></td>
              <td><b>Address</b></td></tr>";

    while($row = mysqli_fetch_row($result)) {
        echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td>";
    }
    echo "</table><br><br>";
    mysqli_close($con);
    ?>
</div>
<form method="post">
    <input type="submit" value="Log out" name="logout"/>
    <?php
    if(isset($_POST['logout'])){
        header('location: start.php');
    }
    ?>
</form>

</body>
</html>
