<?php
include('functions.php');
if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}
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
			<div class="header">
				
			</div>
			<form method="post" action="settings.php">
				<?php echo display_error(); ?>
				<h1>Account Settings</h1>

				<div class="input-group">
					<label>New Username</label>
					<input type="text" name="newUsername" placeholder="Set your new username">
				</div>

				<div class="input-group">
					<label>New password</label>
					<input type="password" placeholder="Set your new password" name="password1">
				</div>
				<div class="input-group">
					<label>Confirm password</label>
					<input type="password" placeholder="Confirm new password" name="password2">
				</div>

				<div class="input-group">
					<button type="submit" class="btn" name="settings1_btn">Set Username</button>
				</div>
				<div class="input-group">
					<button type="submit" class="btn" name="settings2_btn">Set Password</button>
				</div>
			</form>
			<div class="content-desc">
				<h2>PARSE EASILY YOUR HAR FILE</h2>
				<p>HARamata offers you a simple way to upload and parse your har files.</p>
				<img src="images/settings.svg" id="testing" />
			</div>
		</div>

	</div>
</body>

</html>