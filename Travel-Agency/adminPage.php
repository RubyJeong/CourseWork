<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="project2.css">
    <meta charset="UTF-8">
    <title>XYZ Travel Agency - Admin Page</title>
</head>
<body>
<h1>Admin Page</h1>
<form method="post">
    <h3>Customer Information</h3>
    <?php
    $con = mysqli_connect("localhost", "root", "","Project02")
    or die  ("Connection is failed.");

    $query = "select s.re_id, email, s.customer_name, s.address, t.tour_name, t.travel_date
              from users s, tours t, groups g
              where s.re_id = g.re_id && t.tour_id = g.tour_id
              order by t.travel_date, t.tour_name";

    $result = mysqli_query($con, $query)
    or die ("Failed: " .mysqli_error($con));
    echo "<table border ='1' align='center'>";
    echo "<tr id='table_title'><td><b>Registration ID</b></td><td><b>Email</b></td><td><b>Name</b></td>
          <td><b>Address</b></td><td><b>Tour</b></td><td><b>Date</b></td></tr>";

    while($row = mysqli_fetch_row($result)) {
        echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td>
                <td>$row[3]</td><td>$row[4]</td><td>$row[5]</td></tr>";
    }
    echo "</table><br><br>";
    mysqli_close($con);
    ?>

    <label>Edit customer: </label>
    <input type="number" name="editID" placeholder="Registration Id">
    <input type="submit" value="Edit" name="edit"/><br><br>
    <?php
    session_start();
    if(isset($_POST['edit'])){
        if(empty($_POST['editID'])){
            echo "Please enter Registration ID.";
        } else {
            $con = mysqli_connect("localhost", "root", "","Project02")
            or die  ("Connection is failed.");
            $value = $_POST['editID'];
            $query = "select * from users where re_id='$value'";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) != 0) {
                $_SESSION['editID'] = $_POST['editID'];
                header('location: editUser.php');
            } else {
                echo "Account is not found!<br><br>";
            }
        }
    }
    ?>

    <label>Delete customer:</label>
    <input type="text" name="deleteID" placeholder="Registration ID">
    <input type='submit' value='Delete' name='delete'><br><br>
    <?php
    $con = mysqli_connect("localhost", "root", "","Project02")
    or die  ("Connection is failed.");
    if (isset($_POST['delete'])) {
        if (empty($_POST['deleteID'])){
            echo "Please enter Registration ID";
        } else {
            $value = $_POST['deleteID'];

            $query = "delete from groups where re_id='$value'";
            $result = mysqli_query($con, $query)
            or die ("Failed" .mysqli_error($con));

            $query = "delete from users where re_id='$value'";
            $result = mysqli_query($con, $query)
            or die ("Failed" .mysqli_error($con));


            if (mysqli_affected_rows($con) > 0)
                header('location: adminPage.php');
            else
                echo "The account is not deleted.<br><br>";

        }
    }
    ?>

    <h3>Create a group</h3>
    <label>Enter group size: </label>
    <input type="number" name="size"/>
    <input type="submit" name="group" value="Group"><br><br>
    <?php
    if(isset($_POST['group'])){
        echo"<h4>Group information</h4>";
        $size = $_POST['size'];
        $con = mysqli_connect("localhost", "root", "","Project02")
        or die  ("Connection is failed.");

        //Get tours information to group
        $query = "select * from tours";
        $result = mysqli_query($con, $query) or die ("Failed: " .mysqli_error($con));

        //Group on each tour
        while ($row = mysqli_fetch_row($result)) {
            //Get each tour_id
            $queryFind = "select s.re_id, email, s.customer_name, s.address, t.tour_name, t.travel_date
              from users s, tours t, groups g
              where s.re_id = g.re_id && t.tour_id = g.tour_id && t.tour_id='$row[0]'";
            $resultFind = mysqli_query($con, $queryFind) or die ("Failed: " .mysqli_error($con));

            //Calculate how many group with the group size
            $numRow = mysqli_num_rows($resultFind);
            if (($numRow % $size) != 0){
                $isEnough = false;
                $numberOfGroup = intdiv($numRow, $size) + 1;
            } else {
                $numberOfGroup = $numRow / $size;
                $isEnough = true;
            }

            //Group
            for ($x = 1; $x <= $numberOfGroup; $x++){
                echo "<h3>Group of $size to $row[1] on $row[2] </h3>";
                echo "<table border ='1'  align='center'>";
                echo "<tr id='table_title'><td><b>Registration ID</b></td><td><b>Email</b></td><td><b>Name</b></td>
          <td><b>Address</b></td><td><b>Tour</b></td><td><b>Date</b></td></tr>";

                if($x == $numberOfGroup) {
                    if ($isEnough) {
                        $groupID = rand(11,99);
                        echo "<h5>Group ID: $groupID</h5>";
                    } else {
                        $groupID = rand(-99,-1);
                        echo "<h5>Group is not confirmed.</h5>";
                    }
                    while ($rowFind = mysqli_fetch_row($resultFind)){
                        echo "<tr id='table_title'  align='center'><td>$rowFind[0]</td><td>$rowFind[1]</td><td>$rowFind[2]</td>
                <td>$rowFind[3]</td><td>$rowFind[4]</td><td>$rowFind[5]</td></tr>";
                        $queryUpdateGroup = "update users set group_id='$groupID', group_size='$size' where re_id='$rowFind[0]'";
                        mysqli_query($con, $queryUpdateGroup) or die ("Update group_id failed: " .mysqli_error($con));
                    }
                } else {
                    $groupID = rand(11,99);
                    echo "<h5>Group ID: $groupID</h5>";
                    for($i = 1; $i <= $size; $i++){
                        $rowFind = mysqli_fetch_row($resultFind);
                        echo "<tr id='table_title'  align='center'><td>$rowFind[0]</td><td>$rowFind[1]</td><td>$rowFind[2]</td>
                <td>$rowFind[3]</td><td>$rowFind[4]</td><td>$rowFind[5]</td></tr>";
                        $queryUpdateGroup = "update users set group_id='$groupID', group_size='$size' where re_id='$rowFind[0]'";
                        mysqli_query($con, $queryUpdateGroup) or die ("Update group_id failed: " .mysqli_error($con));
                    }
                }

                echo "</table><br>";
            }

        }

        mysqli_close($con);

    }
    ?>

    <input type="submit" value="Log out" name="logout"/>
    <?php
    if(isset($_POST['logout'])){
        header('location: start.php');
    }
    ?>

</form>
</body>
</html>