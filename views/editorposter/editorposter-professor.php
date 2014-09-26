<!doctype html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/editorposter.css">
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Coordinator Dashboard</title>
    </head>

    <body>
        
        <div id="alertBox">
		  <div id="alertBoxBody" class="alert" role="alert"></div>
	    </div>
    
		<div class="container-fluid" style="background-color: #f5f5f5; border-bottom: 1px rgb(221, 221, 221) solid;">
			<div class="btn-group pull-right" style="margin-top: 10px;">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					<span class="glyphicon glyphicon-user"></span> &nbsp;
					<?php echo $user->username; ?> &nbsp;<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="logout.php">Logout</a>
					</li>
				</ul>
			</div>
			<h2>Editor/Poster Dashboard</h2>
			<nav class="nav-editor">
				<div class="btn-group">
					<a href="home.php?page=professor" type="button" class="btn btn-primary navigation active" openview="user">Professor Manager</a>
				</div>
			</nav>
		</div>
		
        <div class="container-fluid"> 
            <div class="container-body">
			
				
			</div>
		</div>
	</body>
	
	<script type="text/javascript" src="assets/js/editorposter.js"></script>
    <script type="text/javascript" src="assets/js/sitewide.js"></script>
	
</html>