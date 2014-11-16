<?php

// Start a session if one doesn't already exist
if ( (session_status() == PHP_SESSION_NONE) || (session_id() == '') ) {
    session_start();
}

// See if logged in and give link for each case
if ( isset($_SESSION['auth_id']) ) {
    require('models/model.php');
    require('dao/dao.php');
    $user = getUserObject($_SESSION['auth_id']);
    echo "<div style='z-index: 1000; background-color: #000000; color: white; padding: 5px; border-bottom-left-radius: 5px; position: fixed; top: 0; right: 0; opacity: 0.3'><center>Welcome back {$user->nicename}! <a href='home.php' style='color: white; font-weight: 700;'> Go home</a></center></div>"; 
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
                <h3 class="sidebar-label text-center">&nbsp;Find a Professor</h3>
                <center>
                <div class="btn-group text-center" style="margin-bottom: 20px;">
                      <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        Find by&nbsp;&nbsp;<span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#" id="filter-program">Program</a></li>
                        <li><a href="#" id="filter-lastname">Last Name</a></li>
                      </ul>
                    </div>
                </center>
                <div id="list-group-departments" class="list-special"></div>
                   <div id="filter-lastname-container">
                    <center>
                        <br>
                        <button type="button" class="btn btn-primary btn-lg">A</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">B</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">C</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">D</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">E</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">F</button>
                        <br>
                        <br>
                        <button type="button" class="btn btn-primary btn-lg">G</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">H</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">I</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">J</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">K</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">L</button>
                        <br>
                        <br>
                        <button type="button" class="btn btn-primary btn-lg">M</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">N</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">O</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">P</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">Q</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">R</button>
                        <br>
                        <br>
                        <button type="button" class="btn btn-primary btn-lg">S</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">T</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">U</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">V</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">W</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">X</button>
                        <br>
                        <br>
                        <button type="button" class="btn btn-primary btn-lg">Y</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">Z</button>
                    </center>
                </div>
            </div>
            
            <div class="container-middle greyed">
                <div style="height: 3%; max-height: 3%;">
                    <h3 class="sidebar-label-professors text-center" style="display: none;">&nbsp;Professors</h3>
                </div>
                <div style="height: 65%; max-height: 65%; overflow: auto;">
                    <div id="list-group-professors" class="list-special"></div>
                </div>
                <div style="height: 3%; max-height: 3%;">
                    <h3 class="sidebar-label-classes text-center" style="display: none;">&nbsp;Classes</h3>
                </div>
                <div style="height: 25%; max-height: 25%; overflow: auto;">
                    <div id="list-group-courses" class="list-special"></div>
                </div>
            </div>

            <div class="container-right greyed">
                <h1 id="prof-el-name" class="prof-el text-center"></h1>
                <div class="row">
                    <br><br>
                    
                    <div class="col-sm-3 prof-el">
                        <center>
                            <img class="prof-el img-responsive img-thumbnail" id="prof-el-img">
                        </center>
                    </div>
                    <div class="col-sm-9">
                        <div class="panel panel-primary prof-el">
                          <div class="panel-heading">
                            <h3 class="panel-title">About this Professor</h3>
                          </div>
                          <table class="table">
                              <tr><td><strong><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Office</strong></td><td><span id="prof-el-office"></span></td></tr>
                              <tr><td><strong><span class="glyphicon glyphicon-phone-alt"></span>&nbsp;&nbsp;Phone Number</strong></td><td><span id="prof-el-phone"></span></td></tr>
                              <tr><td><strong><span class="glyphicon glyphicon-envelope"></span>&nbsp;&nbsp;Email</strong></td><td><span id="prof-el-email"></span></td></tr>
                          </table>
                        </div>
                        <br>
                        <div class="panel panel-primary prof-el">
                          <div class="panel-heading">
                            <h3 class="panel-title">Courses</h3>
                          </div>
                          <table class="table" id="prof-el-courses"></table>
                        </div>
                        <br>
                        <div class="panel panel-primary prof-el">
                          <div class="panel-heading">
                            <h3 class="panel-title">Office Hours</h3>
                          </div>
                          <table class="table" id="prof-el-officehours"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
	</body>
	
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/moment.js"></script>
	<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
	<script src="assets/js/public.js"></script>
    <script type="text/javascript" src="assets/js/sitewide.js"></script>
	
</html>