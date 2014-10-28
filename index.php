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
		
		<div class="pub-header-box">
			kiosk
		</div>
    
        <div class="pub-container-master group">
			<div class="pub-department-master">
				<div class="">
					<h2>Find a Professor</h2>
					<div class="btn-group">
					  <button type="button" id="filter-Program" class="btn btn-default">By Program</button>
					  <button type="button" id="filter-lastName" class="btn btn-default">By Last Name</button>
					</div>
					<br>
					<div class="row" style="margin-top: 10px;">
						<div class="col-sm-4">
							<div class="list-group" id="list-group-departments"></div>
							<div id="filter-lastname-container">
								<button type="button" class="btn btn-primary btn-sm">A</button>
							</div>
						</div>
						<div class="col-sm-8">
							<div class="list-group" id="list-group-professors"></div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="pub-news-master">
				<h2>Recent Posts</h2>
					<div class="list-group" id="list-group-newspost"></div>

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
