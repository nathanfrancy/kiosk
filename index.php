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
		
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="border: 0px white solid;">
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
            </div><!-- /.navbar-collapse -->
          </div>
        </nav>
    

        <div class="pub-container-master group">
			<div class="container-fluid pub-department-master">
					<h1 class="text-center">Find a Professor</h1>

                        <div id="pub-container-department-input" class="col-sm-4 col-sm-offset-4">

                            <div class="text-center">
                                <div class="btn-group btn-group-lg" style="margin-bottom: 10px; margin-top: 10px;">
                                  <button type="button" id="filter-Program" class="btn btn-default active">By Program</button>
                                  <button type="button" id="filter-lastName" class="btn btn-default">By Last Name</button>
                                </div>
                            </div>

                            <br>
							<div class="list-group" id="list-group-departments"></div>

							<div id="filter-lastname-container">
                                <center>
                                    <br>
                                    <button type="button" class="btn btn-primary btn-lg">A</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">B</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">C</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">D</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">E</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">F</button>
                                    <br><br>
                                    <button type="button" class="btn btn-primary btn-lg">G</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">H</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">I</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">J</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">K</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">L</button>
                                    <br><br>
                                    <button type="button" class="btn btn-primary btn-lg">M</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">N</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">O</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">P</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">Q</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">R</button>
                                    <br><br>
                                    <button type="button" class="btn btn-primary btn-lg">S</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">T</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">U</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">V</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">W</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">X</button>
                                    <br><br>
                                    <button type="button" class="btn btn-primary btn-lg">Y</button>&nbsp;
                                    <button type="button" class="btn btn-primary btn-lg">Z</button>
                                </center>
							</div>
						</div>
                        <div id="pub-container-professor-input">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-6">
                                <h2 id="selected-section" class="text-center"></h2>
                                <button class="btn btn-default text-center" id="nav-back-button"><span class="glyphicon glyphicon-arrow-left"></span> &nbsp;Back</button>
                                <div class="list-group" id="list-group-professors"></div>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>

			</div>
			
			<div class="container-fluid pub-news-master">
				<h1 class="text-center" style="margin-bottom: 10px;">Recent Posts</h1>
				<div class="list-group col-sm-6 col-sm-offset-3" id="list-group-newspost"></div>
			</div>
		</div>
		
		
		<div class="modal fade" id="professorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<h1 style="padding-top: 0px;" id="name">Kerry, Henson</h1>
					<div class="row">
						<div class="col-sm-9">
							<p id="office">Office: Dockery 300B</p>
							<p id="phone">Phone: 508340324832</p>
							<p id="email">Email: henson@ucmo.edu</p>
						</div>
						<div class="col-sm-3">
							<img id="img" src="https://www.ucmo.edu/cis/faculty/images/Henson_wb.jpg" class="img-responsive img-thumbnail">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<h3>Classes</h3>
							<ul id="courses"></ul>
						</div>
						<div class="col-sm-6">
							<h3>Office Hours</h3>
							<ul id="officehours"></ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		
		<div class="modal fade" id="newspost-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<h1 id="title"></h1>
					<p id="body"></p>
					
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
