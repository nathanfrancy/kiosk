<?php

/*=========================================================
 * Start the session and redirect if the user is logged in
 */
session_start();
if (isset($_SESSION['auth_id'])) { header("Location: ../home.php"); }

/*=========================================================
 * If there is feedback, save in variable for later
 */
$feedback = "";
$feedbackValid = false;
if (isset($_GET['feedback']) && ($_GET['feedback'] !== "")) { $feedback = $_GET['feedback']; $feedbackValid = true; }


?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../assets/css/bootstrap.css">
	<link rel="stylesheet" href="../assets/css/style.css">
	<link rel="stylesheet" href="../assets/css/signin.css">
	<script src="../assets/js/jquery.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign In</title>
</head>

<body>

	<div class="container">
			<center>
				<img src="../assets/img/logofull.png" class="img-responsive" style="width: 450px;">
			</center>
			
		<form class="form-signin" action="../controllers/controller_login.php" method="post" role="form">
			<br />
			<?php if ($feedbackValid) { ?>
			<div class="alert alert-danger" id="loginAlert" role="alert">
				<?php echo $feedback; ?>
			</div>
			<?php } ?>
			<input type="hidden" name="controllerType" value="userLogin">
			<input type="text" class="form-control" name="username" id="username" placeholder="Username" required autofocus>
			<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
			<button class="btn btn-lg btn-default btn-block" id="signInButton">Sign in</button>
			<br /><br />
		</form>

	</div>

</body>

</html>