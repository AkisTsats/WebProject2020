<?php

include('functions.php');

// if (!isLoggedIn()) {
//     $_SESSION['msg'] = "You must log in first";
//     header('location: login.php');
// }

include("dbConnection.php");

$userID = $_SESSION['user']['id'];

$ip = array();

$query = "SELECT DISTINCT serverIPAddress FROM allentries WHERE userID ='$userID' ";
$result = mysqli_query($db,$query);

//$ip = mysqli_fetch_array($result);

// $result = mysqli_query($db, "SELECT serverIPAddress FROM entries, users 
// WHERE (entries.user_id = users.user_id) AND users.user_id = 1");


while ($row = mysqli_fetch_array($result)) {
    $ip[] = $row['serverIPAddress'];
}

$ipArray = json_encode($ip);



echo $ipArray;


