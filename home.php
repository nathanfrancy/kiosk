<?php

require("scripts/dao.php");
session_start();

// User attributes
$userid = 0;
$user = "";

// Logged in variables
$admin_logged_in = false;
$editor_logged_in = false;
$poster_logged_in = false;
$editor_poster_logged_in = false;



/** Check session variables for admin or editor id numbers. Here are some rules: */
if (isset($_SESSION['auth_id'])) {
    
    // Get the auth_id from the session
    $userid = $_SESSION['auth_id'];
	
	if ($userid !== 0) {
		$user = getUserObject($userid);
        
		if ($user->type === "admin") {
			$admin_logged_in = true;
		}
        else if ($user->type === "editorposter") {
            $editor_poster_logged_in = true;
        }
		else if ($user->type === "editor") {
			$editor_logged_in = true;
		}
        else if ($user->type === "poster") {
            $poster_logged_in = true;
        }
        
	}
	else { header("Location: login.php"); }
}
else { header("Location: login.php"); }



/*   At this point, it is determined who is logged in, and what type of user they are 
|
|      - If not logged in correctly, user is redirected to login.php, nothing under 
|        here will be executed
|      - Based on which boolean is true above, the correct view will be pulled prefixed
|        with home-****.php. 
|                                                                                     */
/*====================================================================================*/



if ($editor_logged_in) {
    require('home-editor.php');
}

else if ($editor_poster_logged_in) {
    require("home-editorposter.php");
}

else if ($poster_logged_in) {
    require("home-poster.php");
}

else if ($admin_logged_in) {
    require('home-admin.php');
}