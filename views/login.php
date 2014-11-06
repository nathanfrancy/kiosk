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
	<script src="../assets/js/sitewide.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign In</title>
</head>

<body>
	
	<div id="alertBox">
		  <div id="alertBoxBody" class="alert" role="alert"></div>
	    </div>

	<div class="container">
			<center>
				<!--<img src="../assets/img/logofull.png" class="img-responsive" style="width: 450px;">-->
				<h1>kiosk login</h1>
			</center>
			
		<form id="signInForm" class="form-signin" action="../controllers/controller_login.php" method="post" role="form">
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
	
	<script>
		
		$("#signInButton").click(function(e) {
			e.preventDefault();
			var username_length = parseInt($("#username").val().length);
			var password_length = parseInt($("#password").val().length);
			
			if (username_length > 0 && password_length > 0) {
				$('#signInForm').submit();
			}
			else {
				showAlertBox("Both fields are required.", "danger", 3);
			}
		});
		
	</script>

</body>

</html>