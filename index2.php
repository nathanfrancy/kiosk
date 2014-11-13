<?php

// Start a session if one doesn't already exist
if ( (session_status() == PHP_SESSION_NONE) || (session_id() == '') ) {
    session_start();
}

// See if logged in and give link for each case
if ( isset($_SESSION['auth_id']) ) {
    echo "<a href='home.php'>Go home</a>"; 
}
?>

<!doctype html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/bootstrap/simplex.css" id="bootstrapsource">
        <link rel="stylesheet" href="assets/css/style.css">
		<link rel="stylesheet" href="assets/css/public.css">
		<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>kiosk</title>
    </head>

    <body>
        
        <div id="alertBox">
		  <div id="alertBoxBody" class="alert" role="alert"></div>
	    </div>
        
        <nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation" style="border: 0px white solid;">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">kiosk</a>
            </div>
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li class="active" id="nav-button-professor"><a href="#">Find a Professor</a></li>
                <li id="nav-button-news"><a href="#">News Posts</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <!--<li><a href="#">Link</a></li>-->
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Help <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Help Section</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Help Section 2</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        
        <div class="group">
            <div class="container-left">
                <h3 class="sidebar-label text-center">&nbsp;Programs</h3>
                <div id="list-group-departments" class="list-special"></div>
            </div>
            
            <div class="container-middle greyed">
                <h3 class="sidebar-label-professors text-center" style="display: none;">&nbsp;Professors</h3>
                <div id="list-group-professors" class="list-special"></div>
            </div>

            <div class="container-right greyed"></div>
        </div>
        
	</body>
	
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/moment.js"></script>
	<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
	<script src="assets/js/public2.js"></script>
    <script type="text/javascript" src="assets/js/sitewide.js"></script>
	
</html>