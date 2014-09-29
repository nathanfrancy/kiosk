<!doctype html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/bootstrap/<?php echo $user->theme; ?>.css" id="bootstrapsource">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/editor.css">
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/sitewide.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Information Coordinator Dashboard</title>
    </head>

    <body>
        
        <div id="alertBox">
		  <div id="alertBoxBody" class="alert" role="alert"></div>
	    </div>
    
		<div class="container-fluid" id="headerBox">
			<div class="btn-group pull-right" style="margin-top: 10px;">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					<span class="glyphicon glyphicon-user"></span> &nbsp;
					<?php echo $user->username; ?> &nbsp;<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a id="changeThemeButton" data-target="#changeThemeModal" href="#">Change Theme</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>
			<h2>Information Coordinator Dashboard</h2>
			<nav class="nav-editor">
				<div class="btn-group">
					<button type="button" class="btn btn-primary navigation active">Professor Manager</button>
				</div>
			</nav>
		</div>
		
        <div class="container-fluid">