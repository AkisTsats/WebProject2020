<?php

include('functions.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

include("dbConnection.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HARamata</title>
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
</head>

<body>
    <div class="wrapper">
        <div class="wrapper-body">
            <div class="header">
                <ul class="navbar">
                    <li><a href="admin_stats.php">STATISTICS</a></li>
                    <li><a href="#">TIMINGS</a></li>
                    <li><a href="#">HEADERS</a></li>
                    <li><a href="#">MAP</a></li>
                    <li><a href="index.php?logout='1'">LOGOUT</a></li>
                </ul>
            </div>
            <div class="content-desc">
                <h1>HARamata</h1>
                <p>Welcome back admin!</p>
                <img src="images/admin.svg" id="testing" />
            </div>
        </div>
    </div>


</body>

</html>