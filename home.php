<?php

require("scripts/dao.php");

session_start();

// User attributes
$userid = 0;
$user = "";

// Logged in variables
$admin_logged_in = false;
$editor_logged_in = false;


/**== Check session variables for admin or editor id numbers. 
      - if an editor
*/
if (isset($_SESSION['auth_admin_id']) || isset($_SESSION['auth_editor_id']) ) {
	$userid = $_SESSION['auth_admin_id'];
	
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


/*==========================================================================================*/


