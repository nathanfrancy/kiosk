<?php

function getAllDepartments() {
    $departments = array();
	
	// Connect and initialize sql and prepared statement template
	$link = connect_db();
	$sql = "SELECT * FROM `department` ORDER BY `name`";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();
	
	// Bind result to Book object and push each one on the end of $books array
    while ($department = $result->fetch_object('Department')) {
		array_push($departments, $department);
	}
	
	mysqli_stmt_close($stmt);
	return $departments;
}

function addDepartment($name, $prefix, $office) {
    $link = connect_db();
	$sql = "INSERT INTO  `department` (`name`, `prefix`, `office`) VALUES (?, ?, ?)";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('sss', $link->real_escape_string($name), $link->real_escape_string($prefix), $link->real_escape_string($office));
	$stmt->execute();
	$id = $link->insert_id;
	mysqli_stmt_close($stmt);
	$link->close();
	
	return $id;
}

function getDepartment($id) {
	$theDepartment = null;
	
	// Connect and initialize sql and prepared statement template
	$link = connect_db();
	$sql = "SELECT * FROM department WHERE id = ? LIMIT 1";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();

	// bind the result to $theBook for json encoding
	while ($department = $result->fetch_object('Department')) {
		$theDepartment = $department;
	}
	
	mysqli_stmt_close($stmt);
	return $theDepartment;
}

function updateDepartment($id, $name, $prefix, $office) {
	$link = connect_db();
	$sql = "UPDATE  `department` SET `name`=?, `prefix`=?, `office`=? WHERE id = ?";
	
	// Create prepared statement and bind parameters
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('sssi', $link->real_escape_string($name), $link->real_escape_string($prefix), $link->real_escape_string($office), $id);
	
    // Execute the query, get the last inserted id
    $stmt->execute();
	$rows = $link->affected_rows;
	mysqli_stmt_close($stmt);
	$link->close();
    $department = getDepartment($id);
	
	return $department;
}

function deleteDepartment($id) {
	$link = connect_db();
	$sql = "DELETE FROM `department` WHERE id = ?";
	
	// Create prepared statement and bind parameters
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $id);
    $stmt->execute();
	mysqli_stmt_close($stmt);
	$link->close();
    return $id;
}



function addUser($username, $password, $nicename, $email, $type, $status) {
    $link = connect_db();
	$sql = "INSERT INTO  `user` (`username`, `password`, `nicename`, `email`, `type`, `status`, `theme`) VALUES (?, ?, ?, ?, ?, ?, 'simplex')";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('ssssss', 
					  $link->real_escape_string($username),
					  $link->real_escape_string(sha1($password)),
					  $link->real_escape_string($nicename),
					  $link->real_escape_string($email),
					  $link->real_escape_string($type),
                      $link->real_escape_string($status));
	$stmt->execute();
	$id = $link->insert_id;
	mysqli_stmt_close($stmt);
	$link->close();
	
	return $id;
}

function updateUser($id, $nicename, $username, $email, $type, $status) {
	$link = connect_db();
	$sql = "UPDATE  `user` SET `nicename`=?, `username`=?, `email`=?, `type`=?, `status`=? WHERE id = ?";
	
	// Create prepared statement and bind parameters
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('sssssi', $link->real_escape_string($nicename), $link->real_escape_string($username), $link->real_escape_string($email), $link->real_escape_string($type), $link->real_escape_string($status), $id);
	
    // Execute the query, get the new user object from the database
    $stmt->execute();
	mysqli_stmt_close($stmt);
	$link->close();
    $user = getUser($id);
	
	return $user;
}

function resetPassword($id, $password) {
	$link = connect_db();
	$sql = "UPDATE  `user` SET `password`=? WHERE id = ?";
	
	// Create prepared statement and bind parameters
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('si', $link->real_escape_string(sha1($password)), $id);
    
    $stmt->execute();
	mysqli_stmt_close($stmt);
	$link->close();
    $user = getUser($id);
	
	return $user;
}

function getAllUsers() {
    $users = array();
	
	// Connect and initialize sql and prepared statement template
	$link = connect_db();
	$sql = "SELECT * FROM user";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();
	
	// Bind result to Book object and push each one on the end of $books array
    while ($user = $result->fetch_object('User')) {
		array_push($users, $user);
	}
	
	mysqli_stmt_close($stmt);
	return $users;
}

function getUser($id) {
	$theUser = null;
	
	// Connect and initialize sql and prepared statement template
	$link = connect_db();
	$sql = "SELECT * FROM user WHERE id = ? LIMIT 1";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();

	// bind the result to $theBook for json encoding
	while ($user = $result->fetch_object('User')) {
		$theUser = $user;
	}
	
	mysqli_stmt_close($stmt);
	return $theUser;
}

function deleteUser($id) {
	$link = connect_db();
	$sql = "DELETE FROM `user` WHERE id = ?";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $id);
    $stmt->execute();
	mysqli_stmt_close($stmt);
	$link->close();
    return $id;
}

function grantDepartmentAccess($userid, $departmentid) {
    $link = connect_db();
	$sql = "INSERT INTO  `access_department` (`user_id`, `department_id`) VALUES (?, ?)";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('ii', $userid, $departmentid);
	$stmt->execute();
	mysqli_stmt_close($stmt);
	$link->close();
	
	return $userid;
}

function revokeDepartmentAccess($userid, $departmentid) {
    $link = connect_db();
	$sql = "DELETE FROM `access_department` WHERE `user_id` = ? AND `department_id` = ?";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('ii', $userid, $departmentid);
	$stmt->execute();
	mysqli_stmt_close($stmt);
	$link->close();
	
	return $userid;
}

function getGrantedDepartmentIds($userid) {
    $departments = array();
	
	// Connect and initialize sql and prepared statement template
	$link = connect_db();
	$sql = "SELECT * FROM `access_department` WHERE `user_id` = ?";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $userid);
	$stmt->execute();
	$result = $stmt->get_result();
	
	$count = 0;
	// Bind result to Book object and push each one on the end of $books array
    while ($row = $result->fetch_array(MYSQLI_BOTH)) {
		array_push($departments, $row['department_id']);
		$count++;
	}
	$departments['results'] = $count;
	
	mysqli_stmt_close($stmt);
	return $departments;
}

function changePassword($auth_id, $newpassword) {
	$link = connect_db();
	$sql = "UPDATE  `user` SET `password`=? WHERE id = ?";
    
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('si', $link->real_escape_string(sha1($newpassword)), $auth_id);
    
    $stmt->execute();
	mysqli_stmt_close($stmt);
	$link->close();
	
	return "Password changed successfully.";
}

function getAllTrackings() {
    $tracks = array();
	
	// Connect and initialize sql and prepared statement template
	$link = connect_db();
	$sql = "SELECT * FROM `user_track` ORDER BY `user_track`.`id` desc";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();
	
	// Bind result to Book object and push each one on the end of $books array
    while ($row = $result->fetch_array(MYSQLI_BOTH)) {
        
        if ($row['user_id'] !== 0) {
            $user = getUser($row['user_id']);
            $track['user']['id'] = $user->id;
            $track['user']['username'] = $user->username;
            $track['user']['nicename'] = $user->nicename;
            $track['user']['type'] = $user->type;
        }
        else {
            $track['user']['id'] = 0;
            $track['user']['username'] = "N/A";
            $track['user']['nicename'] = "N/A";
            $track['user']['type'] = "N/A";
        }
        
        $track['user']['ip_address'] = $row['ip_address'];
        $track['track']['id'] = $row['id'];
        $track['track']['track_code'] = $row['track_code'];
        $track['track']['description'] = $row['description'];
        $track['track']['date_executed'] = $row['date_executed'];
		array_push($tracks, $track);
	}
	
	mysqli_stmt_close($stmt);
	return $tracks;
}

function clearAllTrackings() {
    $link = connect_db();
	$sql = "truncate  `user_track`";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
    $stmt->execute();
	mysqli_stmt_close($stmt);
	$link->close();
	
	return "Table cleared.";
}

?>
