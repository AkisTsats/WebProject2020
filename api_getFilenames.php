<?php

include('functions.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

include("dbConnection.php");

$files = array();

$userID = $_SESSION['user']['id'];

$query = "SELECT name FROM files WHERE user_ID ='$userID' ";

$result = mysqli_query($db,$query);

//$files = mysqli_fetch_array($result);

while ($row = mysqli_fetch_array($result)) {
    $files[] = $row['name'];
}

//echo $files;


foreach ($files as $value){
   echo $value;
}


//var_dump($files);