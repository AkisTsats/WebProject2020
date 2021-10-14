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
			<form method="post" action="register.php">
				<?php echo display_error(); ?>
				<div class="input-group">
					<label>Username</label>
					<input type="text" name="username" placeholder="Ceidas" value="<?php echo $username; ?>">
				</div>
				<div class="input-group">
					<label>Email</label>
					<input type="email" name="email" placeholder="example@mail.com" value="<?php echo $email; ?>">
				</div>
				<div class="input-group">
					<label>Password</label>
					<input type="password" name="password1" placeholder="1234">
				</div>
				<div class="input-group">
					<label>Confirm password</label>
					<input type="password" name="password2" placeholder="NOOOO!">
				</div>
				<div class="input-group">
					<button type="submit" class="btn" name="register_btn">Register</button>
				</div>
				<p>
					Already a member? <a href="login.php">Sign in</a>
				</p>
			</form>
		</div>
	</div>

</body>

</html>