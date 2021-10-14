<?php
session_start();

include("dbConnection.php");

//$sqlDownload = "SELECT * FROM files";
//$resultDownload = mysqli_query($db, $sqlDownload);
//$files = mysqli_fetch_all($resultDownload, MYSQLI_ASSOC);

// variable declaration
$newUsername = "";
$username = "";
$email = "";
$loggedUserId = "";
$errors = array();

// log user out if logout button clicked
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}

// call the login() function if login_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}

// call the settings() function if settings_btn is clicked
if (isset($_POST['settings1_btn'])) {
	setUsername();
}

// call the settings() function if settings_btn is clicked
if (isset($_POST['settings2_btn'])) {
	setPassword();
}

function setUsername()
{

	global $db, $errors, $username;
	//var_dump($_SESSION['user']['id']);
	$userID = $_SESSION['user']['id'];
	
	$newUsername = e($_POST['newUsername']);

	if ($newUsername) {
		$query = "UPDATE users SET username='$newUsername' WHERE id=$userID";
		mysqli_query($db, $query);
	}
}

function setPassword()
{

	global $db, $errors, $password;
	//var_dump($_SESSION['user']['id']);
	$userID = $_SESSION['user']['id'];
	//$password = e($_POST['password']);
	$newPassword1 = e($_POST['password1']);
	$newPassword2 = e($_POST['password2']);
	$secure_password = preg_match('/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}$/i', $newPassword1) ? 'PASS' : 'FAIL';

	if ($newPassword1 != $newPassword2) {
		array_push($errors, "The two passwords do not match");
	}
	if ($secure_password == 'FAIL') {
		array_push($errors, "Password must contain at least 1 lowercase letter, 1 uppercase letter, 1 number and 1 special character and also have at least length of 8 characters");
	}

	if (count($errors) == 0) {
		if ($newPassword1) {
			$password = md5($newPassword1);
			$query = "UPDATE users SET password='$password' WHERE id=$userID";
			mysqli_query($db, $query);
		}
	}
}


// REGISTER USER
function register()
{
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
	// defined below to escape form values
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$password1  =  e($_POST['password1']);
	$password2  =  e($_POST['password2']);
	$secure_password = preg_match('/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}$/i', $password1) ? 'PASS' : 'FAIL';

	$userCheckQuery = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
	$result = mysqli_query($db, $userCheckQuery);
	$user = mysqli_fetch_assoc($result);

	if ($user) { // if user exists
		if ($user['username'] === $username) {
			array_push($errors, "Username already exists");
		}

		if ($user['email'] === $email) {
			array_push($errors, "Email already exists");
		}
	}

	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($password1)) {
		array_push($errors, "Password is required");
	}
	if ($password1 != $password2) {
		array_push($errors, "The two passwords do not match");
	}
	if ($secure_password == 'FAIL') {
		array_push($errors, "Password must contain at least 1 lowercase letter, 1 uppercase letter, 1 number and 1 special character and also have at least length of 8 characters");
	}


	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password1); //encrypt the password before saving in the database

		if (isset($_POST['user_type'])) {
			$user_type = e($_POST['user_type']);
			$query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', '$user_type', '$password')";
			mysqli_query($db, $query);
			$_SESSION['success']  = "New user successfully created!!";
			header('location: home.php');
		} else {
			$query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', 'user', '$password')";
			mysqli_query($db, $query);

			// get id of the created user
			$loggedUserId = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($loggedUserId); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: index.php');
		}
	}
}

// return user array from their id
function getUserById($id)
{
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val)
{
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error()
{
	global $errors;

	if (count($errors) > 0) {
		echo '<div class="error">';
		foreach ($errors as $error) {
			echo $error . '<br>';
		}
		echo '</div>';
	}
}

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	} else {
		return false;
	}
}



// LOGIN USER
function login()
{
	global $db, $username, $errors;

	// grap form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {
		$password = md5($password);

		$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			// check if user is admin or user
			$loggedUser = mysqli_fetch_assoc($results);
			if ($loggedUser['user_type'] == 'admin') {

				$_SESSION['user'] = $loggedUser;
				$_SESSION['success']  = "You are now logged in";
				header('location: admin_home.php');
			} else {
				$_SESSION['user'] = $loggedUser;
				$_SESSION['success']  = "You are now logged in";

				header('location: index.php');
			}
		} else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}

function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin') {
		return true;
	} else {
		return false;
	}
}
