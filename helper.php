<?php
if (!isLoggedIn()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php');
}

include("dbConnection.php");

$files = array();
$userID = $_SESSION['user']['id'];
$query = "SELECT name FROM files WHERE user_ID ='$userID' ";
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_array($result)) {
  $files[] = $row['name'];
}

$times = array();
$query = "SELECT dateOfUpload FROM files WHERE user_ID ='$userID' ";
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_array($result)) {
  $times[] = $row['dateOfUpload'];
}

$rep = count($files);