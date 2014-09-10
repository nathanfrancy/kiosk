<?php
date_default_timezone_set('America/Chicago');

/** ============================================================================
 * Function that provides a link to the database for data access and interaction
 */
function connect_db() {
	$prod = false;
	$ubuntu = false;
	
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

?>