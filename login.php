<?php include('functions.php') ?>
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

			<form method="post" action="login.php">

				<?php echo display_error(); ?>

				<div class="input-group">
					<label>Username</label>
					<input type="text" name="username" placeholder="Username">
				</div>
				<div class="input-group">
					<label>Password</label>
					<input type="password" name="password" placeholder="Password">
				</div>
				<div class="input-group">
					<button type="submit" class="btn" name="login_btn">Login</button>
				</div>
				<p>
					Not a member? <a href="register.php">Sign up</a>
				</p>
			</form>

			<div class="content-desc">
				<h2>LOGIN AND UPLOAD YOUR HAR FILE WITH EASE</h2>
				<img src="images/image1.svg" id="testing" />
			</div>
			
		</div>

		
	</div>

</body>

</html>