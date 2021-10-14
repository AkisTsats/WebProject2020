<?php

include('functions.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

include("dbConnection.php");

$userID = $_SESSION['user']['id'];

$ipAndIsp = file_get_contents('php://input');

$givenFile = json_decode($ipAndIsp);

$userISP = $givenFile->isp;

$userIP = $givenFile->query;

$query = "UPDATE files SET userIP='$userIP' , userISP='$userISP' WHERE user_id=$userID";
mysqli_query($db, $query);

$lastUpload = date("d/m/Y");

$query = "UPDATE users SET lastUpload='$lastUpload' WHERE id=$userID";
mysqli_query($db, $query);
