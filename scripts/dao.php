<?php
session_start();
date_default_timezone_set('America/Chicago');

require('model.php');
require('dao_admin.php');

/** ============================================================================
 * Function that provides a link to the database for data access and interaction
 */
function connect_db() {
	$prod = false;
	$ubuntu = false;
	
	$host = "";
	$username = "";
	$password = "";
	$db = "";
	
	if ($prod) {
		$host = "";
		$username = "";
		$password = "";
		$db = "";
	}
	else {
		$host = "localhost";
		$username = "root";
		if ($ubuntu) {
			$password = "root";
		}
		else $password = "";
		
		$db = "ucmo_kiosk";
	}

	$link = new mysqli($host, $username, $password, $db) or trigger_error($link->error);
	return $link;
}

function validateUser($input_username, $input_password) {
	// Connect and initialize sql template
	$link = connect_db();
	$sql = "SELECT id, type FROM user WHERE BINARY username = ? AND BINARY password = ?";
	
	// Create prepared statement and bind passed in variables username and password
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('ss', $link->real_escape_string($input_username), $input_password);
	$stmt->execute();
	$result = $stmt->get_result();
	$userid = 0;
	$usertype = "";
    
	$counter = 0;
	while ($row = $result->fetch_array(MYSQLI_BOTH)) {
		$userid = $row['id'];
		$usertype = $row['type'];
		$counter++;
	}
	
	// Make sure that userid is 0 if there was nothing returned
	if ($counter === 0) {
		$userid = 0;
	}
	
	// If the user id doesn't equal zero, assume login is valid and returned a valid id number from user table
	if ($userid !== 0 && $counter !== 0) {
		$_SESSION['auth_id'] = $userid;
	}
	
	mysqli_stmt_close($stmt);
	return $userid;
}

function getUserObject($userid) {
	$theUser = null;
	
	// Connect and initialize sql and prepared statement template
	$link = connect_db();
	$sql = "SELECT * FROM user WHERE id = ? LIMIT 1";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $userid);
	$stmt->execute();
	$result = $stmt->get_result();

	// Bind results to User object for passing back to the user
	while ($user = $result->fetch_object("User")) {
		$theUser = $user;
	}
	
	mysqli_stmt_close($stmt);
	return $theUser;
}

?>