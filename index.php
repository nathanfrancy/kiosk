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
        
        <div id="newsPosts" style="background-image: url(assets/img/mule.png); background-repeat: no-repeat;; background-position: bottom left;">
            <h2 class="text-center" style="padding-top: 15px; padding-bottom: 30px;">HCBPS News</h2>
            <div class="row">
                <div class="col-sm-offset-4 col-sm-4">
                    <div id="list-newspost"></div>
                </div>
            </div>
        </div>
        
        <div id="mapsContainer">
            <div class="container-left">
                <h2 class="sidebar-label text-center">&nbsp;Maps</h3>
                <br>
                <div id="list-group-maps" class="list-special">
                    <a href="#" class="list-group-item list-group-item-map" mapid="1">
                        <h4 class="list-group-item-heading">Dockery 1st Floor</h4>
                    </a>
                    <a href="#" class="list-group-item list-group-item-map" mapid="2">
                        <h4 class="list-group-item-heading">Dockery 2nd Floor</h4>
                    </a>
                    <a href="#" class="list-group-item list-group-item-map" mapid="3">
                        <h4 class="list-group-item-heading">Dockery 3rd Floor</h4>
                    </a>
                    <a href="#" class="list-group-item list-group-item-map" mapid="4">
                        <h4 class="list-group-item-heading">Dockery 4th Floor</h4>
                    </a>
                </div>
            </div>
            <div class="container-middle greyed" style="width: 75%;">
                <img src="" class="img-responsive" width="100%" id="mapBox">
            </div>
        </div>
        
        <nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation" style="border: 0px white solid; font-size: 18px !important;">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li class="active" id="nav-button-professor"><a href="#" style="padding-top: 10px; padding-bottom: 10px;">Find a Person</a></li>
                <li id="nav-button-news"><a href="#" style="padding-top: 10px; padding-bottom: 10px;">News Posts</a></li>
                <li id="nav-button-maps"><a href="#" style="padding-top: 10px; padding-bottom: 10px;">Maps</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <!--<li><a href="#">Link</a></li>-->
                <!--<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Help <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Help Section</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Help Section 2</a></li>
                  </ul>
                </li>-->
              </ul>
            </div>
          </div>
        </nav>
        
        <div class="group">
            <div class="container-left">
                <h2 class="sidebar-label text-center">&nbsp;Find a Person</h3>
                <center>
                <div class="btn-group text-center" style="margin-bottom: 20px;">
                      <button type="button" class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
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
                        
                        <br>
                        <br>
                        <button type="button" class="btn btn-primary btn-lg">F</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">G</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">H</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">I</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">J</button>&nbsp;
                        
                        <br>
                        <br>
                        <button type="button" class="btn btn-primary btn-lg">K</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">L</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">M</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">N</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">O</button>&nbsp;
                        
                        <br>
                        <br>
                        <button type="button" class="btn btn-primary btn-lg">P</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">Q</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">R</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">S</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">T</button>&nbsp;
                
                        <br>
                        <br>
                        <button type="button" class="btn btn-primary btn-lg">U</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">V</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">W</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">X</button>&nbsp;
                        <button type="button" class="btn btn-primary btn-lg">Y</button>&nbsp;
                        <br>
                        <br>
                        <button type="button" class="btn btn-primary btn-lg">Z</button>
                    </center>
                </div>
            </div>
            
            <div class="container-middle greyed">
                <div style="height: 100%; max-height: 100%; overflow: auto;">
                    <h4 class="sidebar-label-location text-center" style="display: none;">Location: <span id="office-duh"></span></h4>
                    <h2 class="sidebar-label-professors text-center" style="display: none;">&nbsp;People</h2>
                    <div id="list-group-professors" class="list-special"></div>
                    <h2 class="sidebar-label-classes text-center" style="display: none; margin-top: 40px;">&nbsp;Classes</h2>
                    <div id="list-group-courses" class="list-special"></div>
                </div>
            </div>

            <div class="container-right greyed mulebg">
                <h1 id="prof-el-name" class="prof-el text-center"></h1>
                <div class="row">
                    
                    <div class="col-sm-3 prof-el">
                        <center>
                            <img class="prof-el img-responsive img-thumbnail" id="prof-el-img">
                        </center>
                    </div>
                    <div class="col-sm-9">
                        <div class="panel panel-primary prof-el">
                          <div class="panel-heading">
                            <h3 class="panel-title">About this Person</h3>
                          </div>
                          <table class="table">
                              <tr><td><strong><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Office</strong></td><td><span id="prof-el-office"></span></td></tr>
                              <tr><td><strong><span class="glyphicon glyphicon-phone-alt"></span>&nbsp;&nbsp;Phone Number</strong></td><td><span id="prof-el-phone"></span></td></tr>
                              <tr><td><strong><span class="glyphicon glyphicon-envelope"></span>&nbsp;&nbsp;Email</strong></td><td><span id="prof-el-email"></span></td></tr>
                          </table>
                        </div>
                        <div class="panel panel-primary prof-el">
                          <div class="panel-heading">
                            <h3 class="panel-title">Courses</h3>
                          </div>
                          <table class="table" id="prof-el-courses"></table>
                        </div>
                        <div class="panel panel-primary prof-el">
                          <div class="panel-heading">
                            <h3 class="panel-title">Office Hours</h3>
                          </div>
                          <table class="table" id="prof-el-officehours"></table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h1 id="course-el-title" class="course-el text-center"></h1>
                    <br>
                    <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <div class="panel panel-primary course-el">
                            <div class="panel-heading">
                                <h3 class="panel-title">Available Courses</h3>
                            </div>
                            <table class="table" id="course-el-courses" class="course-el"></table>
                        </div>
                    </div>
                    <div class="col-sm-2"></div>
                    </div>
                </div>
            </div>
            <div id="mapsContainer" class="container-right greyed">
                Hello
            </div>
        </div>
        
        <div class="modal fade" id="newspost-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="newspost-title">Modal title</h4>
              </div>
              <div class="modal-body">
                <p id="newspost-body"></p>
                  <br>
                <p id="newspost-postedby"></p>
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
