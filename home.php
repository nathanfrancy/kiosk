<?php

require("scripts/dao.php");
session_start();

// User attributes
$userid = 0;
$user = "";

// Logged in variables
$admin_logged_in = false;
$editor_logged_in = false;


/** Check session variables for admin or editor id numbers. Here are some rules: */
if (isset($_SESSION['auth_admin_id']) || isset($_SESSION['auth_editor_id']) ) {
	
    /** Get the userid number from session variables, determine what type of user is logged in **/
    if (isset($_SESSION['auth_editor_id'])) {
        $userid = $_SESSION['auth_editor_id'];
    }
    if (isset($_SESSION['auth_admin_id'])) {
        $userid = $_SESSION['auth_admin_id'];
    }
	
	if ($userid !== 0) {
		$user = getUserObject($userid);
        
		if ($user->type === "admin") {
			$admin_logged_in = true;
		}
		else if ($user->type === "editor") {
			$editor_logged_in = true;
		}
	}
	else { header("Location: login.php"); }
}
else { header("Location: login.php"); }



/*   At this point, it is determined who is logged in, and what type of user they are 
|
|      - If not logged in correctly, user is redirected to login.php, nothing under 
|        here will be executed
|      - 
|                                                                                     */
/*====================================================================================*/



if ($editor_logged_in) {
    require('home-editor.php');
}

else if ($admin_logged_in) {
    require('home-admin.php');
}