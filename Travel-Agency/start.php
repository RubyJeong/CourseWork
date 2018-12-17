<?php
session_start();
if (isset($_POST['login'])) {
    $con = mysqli_connect(
        "localhost",
        "root",
        "",
        "Project02")
    or die  ("Connection is failed.");

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $query = "select * from users where email = '$email' && password = '$password'";
    $result = mysqli_query($con, $query) or die ("Query is failed: " . mysqli_error($con));
    if (mysqli_num_rows($result) != 0) {
        if( $email == 'admin@gmail.com') {
            header('location: adminPage.php');
        } else {
            $_SESSION['email'] = $_POST['email'];
            header('location: userPage.php');
        }
    } else {
        echo "Login is failed.";
    }
    mysqli_close($con);
}

if (isset($_POST['create'])) {
    header('location: registerPage.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="project2.css">
    <meta charset="UTF-8">
    <title>XYZ Travel Agency - Login</title>
</head>
<body>

<h1>Welcome to XYZ Travel Agency</h1>
<h3>Login</h3>
<form method="post">
    <div id="login">
        <label>Email: </label>
        <input type="email" name="email"/><br><br>

        <label>Password: </label>
        <input type="password" name="password"/><br><br>
        <input type="submit" name="login" value="Login"/><br><br>
    </div>
    <div id="account">
        <p><label>Create an account: </label</p><br><br>
        <input type="submit" name="create" value="Create"/><br><br>
    </div>
</form>
</body>
</html>