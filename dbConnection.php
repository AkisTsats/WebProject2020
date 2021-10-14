<?php

//connect to database


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration";

$db = mysqli_connect($servername, $username, $password, $dbname); // Create connection
if ($db->connect_error) { // Check connection
    die("Connection failed: " . $db->connect_error);
}
