<?php

include('functions.php');

if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}

include("dbConnection.php");
?>

<!DOCTYPE html>
<html>

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
			<?php include("includes/header.php"); ?>
			<div class="content-desc">
				<h2>PARSE EASILY YOUR HAR FILE</h2>
				<p>HARamata offers you a simple way to upload and parse your har files.</p>
				<img src="images/image2.svg" id="testing" />
			</div>

		</div>
	</div>
</body>

</html>