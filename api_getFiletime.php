<?php

include('functions.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

include("dbConnection.php");

$times = array();

$userID = $_SESSION['user']['id'];

$query = "SELECT dateOfUpload FROM files WHERE user_ID ='$userID' ";

$result = mysqli_query($db,$query);

//$files = mysqli_fetch_array($result);

while ($row = mysqli_fetch_array($result)) {
    $times[] = $row['dateOfUpload'];
}

//echo $files;


foreach ($times as $value){
   echo $value;
}