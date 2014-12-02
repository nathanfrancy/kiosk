<?php

// Start a session if one doesn't already exist
if ( (session_status() == PHP_SESSION_NONE) || (session_id() == '') ) {
    session_start();
}

date_default_timezone_set('America/Chicago');
set_magic_quotes_runtime(0);

require('dao_admin.php');
require('dao_editor.php');
require('dao_poster.php');
require('dao_public.php');

// if the model.php file exists relative to this location, we need it for some operations
// this is primarily for ajax calls
if (file_exists("../models/model.php")) {
	require("../models/model.php");
}

// whitelist of bootstrap themes available
$boots = array("cerulean", "cosmo", "cyborg", "darkly", "flatly", "journal", "lumen", "paper", "readable", "sandstone", "simplex", "slate", "spacelab", "superhero", "united", "yeti");

/** ============================================================================
 * Function that provides a link to the database for data access and interaction
 */
function connect_db() {
	$prod = false;
	
	$host = "";
	$username = "";
	$password = "";
	$db = "";
	
	if ($prod) {
		// place production variables here
	}
	else {
		$connection_array = parse_ini_file("connection.ini");
        $host = $connection_array['host'];
        $username = $connection_array['username'];
        $password = $connection_array['password'];
        $db = $connection_array['db'];
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

function updateTheme($id, $theme) {
	$link = connect_db();
	$sql = "UPDATE  `user` SET `theme`=? WHERE id = ?";
	
	// Create prepared statement and bind parameters
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('si', $link->real_escape_string($theme), $id);
	
    // Execute the query, get the last inserted id
    $stmt->execute();
	$rows = $link->affected_rows;
	mysqli_stmt_close($stmt);
	$link->close();
    $user = getUser($id);
	
	return $user;
}


function isAdmin() {
	$authorized = 0;
	$session_auth_id = $_SESSION['auth_id'];
	
	// Connect and initialize sql template
	$link = connect_db();
	$sql = "SELECT * FROM `user` WHERE `user`.`id` = ? AND `user`.`type` = 'admin'";
	
	// Create prepared statement and bind passed in variables username and password
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $session_auth_id);
	$stmt->execute();
	$result = $stmt->get_result();
	
	while ($row = $result->fetch_array(MYSQLI_BOTH)) {
		$authorized = 1;
	}
	
	mysqli_stmt_close($stmt);
	return $authorized;
}

function isEditor() {
	$authorized = 0;
	$session_auth_id = $_SESSION['auth_id'];
	
	// Connect and initialize sql template
	$link = connect_db();
	$sql = "SELECT * FROM `user` WHERE `user`.`id` = ? AND (`user`.`type` = 'editor' OR `user`.`type` = 'editorposter')";
	
	// Create prepared statement and bind passed in variables username and password
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $session_auth_id);
	$stmt->execute();
	$result = $stmt->get_result();
    
	while ($row = $result->fetch_array(MYSQLI_BOTH)) {
		$authorized = 1;
	}
	
	mysqli_stmt_close($stmt);
	return $authorized;
}

function isPoster() {
	$authorized = 0;
	$session_auth_id = $_SESSION['auth_id'];
	
	// Connect and initialize sql template
	$link = connect_db();
	$sql = "SELECT * FROM `user` WHERE `user`.`id` = ? AND (`user`.`type` = 'poster' OR `user`.`type` = 'editorposter')";
	
	// Create prepared statement and bind passed in variables username and password
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $session_auth_id);
	$stmt->execute();
	$result = $stmt->get_result();
 
	while ($row = $result->fetch_array(MYSQLI_BOTH)) {
		$authorized = 1;
	}
	
	mysqli_stmt_close($stmt);
	return $authorized;
}

function updateRank($professorid) {
    $link = connect_db();
	$sql = "UPDATE  `professor` SET `rank`=`rank`+1 WHERE `professor`.`id` = ?";
	
	// Create prepared statement and bind parameters
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $professorid);
	
    // Execute the query, get the last inserted id
    $stmt->execute();
	$rows = $link->affected_rows;
	mysqli_stmt_close($stmt);
	$link->close();
	
	return true;
}

function addUserTrack($user_id, $track_code, $description) {
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $current_time = time();
    $link = connect_db();
	$sql = "INSERT INTO `user_track` (`user_id` ,`track_code` ,`description` ,`date_executed`, `ip_address`) VALUES (?, ?,  ?,  ?, ?)";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('issss', $user_id, $link->real_escape_string($track_code), $link->real_escape_string($description), $current_time, $user_ip);
	$stmt->execute();
	$id = $link->insert_id;
	mysqli_stmt_close($stmt);
	$link->close();
}

?>
