<?php

require("scripts/dao.php");

/*=========================================================
 * Start the session and redirect if the user is logged in
 */
session_start();
if (isset($_SESSION['auth_editor_id'])) { header("Location: home.php"); }
if (isset($_SESSION['auth_admin_id'])) { header("Location: home.php"); }

/*=========================================================
 * If there is feedback, save in variable for later
 */
$feedback = "";
$feedbackValid = false;
if (isset($_GET['feedback'])) { $feedback = $_GET['feedback']; $feedbackValid = true; }

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/signin.css">
	<script src="js/jquery.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign In</title>
</head>

<body>

	<div class="container">

		<form class="form-signin" action="scripts/controller_login.php" method="post" role="form">
			<h1>Login</h1>
<!--<img src="img/logo.png" class="img-responsive"> -->
			<input type="hidden" name="controllerType" value="userLogin">
			<input type="text" class="form-control" name="username" id="username" placeholder="Username" required autofocus>
			<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
			<button class="btn btn-lg btn-primary btn-block" id="signInButton">Sign in</button>
			<br /><br />
			<div class="alert alert-danger" id="loginAlert" role="alert" style="display: none;"></div>
		</form>

	</div>

</body>

</html>