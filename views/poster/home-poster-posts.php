<!doctype html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/poster.css">
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>News Posting Coordinator Dashboard</title>
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
			<h2>News Posting Coordinator Dashboard</h2>
			<nav class="nav-poster">
				<div class="btn-group">
					<button type="button" class="btn btn-primary navigation active" openview="department">Department Manager</button>
					<button type="button" class="btn btn-primary navigation" openview="user">User Manager</button>
				</div>
			</nav>
		</div>
		
        <div class="container-fluid"> 
            <div class="container-body">
			
				
			</div>
		</div>
	</body>
	
	<script type="text/javascript" src="js/poster.js"></script>
    <script type="text/javascript" src="js/sitewide.js"></script>
	
</html>