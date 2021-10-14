<?php

include('functions.php');

// if (!isLoggedIn()) {
//     $_SESSION['msg'] = "You must log in first";
//     header('location: login.php');
// }

$filename = $_GET["filename"];

$attachment_location = "./uploads/". $filename;

if (file_exists($attachment_location)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
    header("Cache-Control: public"); // needed for internet explorer
    header("Content-Type: application/har");
    header("Content-Transfer-Encoding: Binary");
    header("Content-Length:".filesize($attachment_location));
    header("Content-Disposition: attachment; filename=file.har");
    readfile($attachment_location);
    die();        
} else {
    die("Error: File not found.");
} 
