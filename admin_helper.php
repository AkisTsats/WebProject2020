<?php
// if (!isLoggedIn()) {
//   $_SESSION['msg'] = "You must log in first";
//   header('location: login.php');
// }

include("dbConnection.php");

$query = "SELECT COUNT(id) FROM ( SELECT id FROM users GROUP BY id HAVING COUNT(*) = 1 ) AS ONLY_ONCE";
$result = mysqli_query($db,$query);
$numOfUsers = mysqli_fetch_array($result);
$numUsers = $numOfUsers[0];
//echo $numUsers;

$query = "SELECT DISTINCT userISP FROM files WHERE 1";
$result = mysqli_query($db,$query);
$numOfISP = mysqli_fetch_array($result);
$num = count($numOfISP);
$num--;
//echo $num;

$query2 = "SELECT DISTINCT reqUrl FROM allentries WHERE 1";
$result2 = mysqli_query($db,$query2);
$numOfDomains = mysqli_fetch_array($result2);
var_dump($numOfDomains);
$num2 = count($numOfDomains);
echo $num2;
