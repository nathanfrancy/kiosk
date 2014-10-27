<?php

/* The variable $extend is created in home.php and will equal 1 if the page
 * is being included into home.php. If this page is requested on its own
 * $extend will not equal 1 and will redirect back to the homepage.
 * Also checking to make sure the pagename (or filename) is equal to home.php.
 * Therefore, this page will only render if it is required by home.php.
 *
 * ==========================================================================
 */
if (($extend !== 1) || (basename($_SERVER['PHP_SELF']) !== "home.php")) {
	header("Location: ../../index.php");
}
?>

<!doctype html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/bootstrap/<?php echo $theme; ?>.css" id="bootstrapsource">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/editor.css">
		<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Information Coordinator Dashboard</title>
    </head>

    <body>
        
        <div id="alertBox">
		  <div id="alertBoxBody" class="alert" role="alert"></div>
	    </div>
    
		<div class="container-fluid" id="headerBox">
			<center>
			<h2>Information Coordinator Dashboard</h2>
				<nav class="nav-editor">
					<div class="btn-group">
						<a href="home.php?page=department" class="btn btn-default navigation">Department Manager</a>
					</div>
					<div class="btn-group" style="margin-left: 25px;">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-user"></span> &nbsp;
							<?php echo $user->username; ?> &nbsp;<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a id="changeThemeButton" data-target="#changeThemeModal" href="#">Change Theme</a></li>
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</div>
				</nav>
			</center>
		</div>
		
        <div class="container-fluid">
