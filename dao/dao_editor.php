<?php

function getAccessedDepartments($userid) {
    $departments = array();

    $link = connect_db();
    $sql = "SELECT * FROM `access_department`, `department` WHERE `user_id` = ? AND `access_department`.`department_id` = `department`.`id`";
    $stmt = $link->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_array(MYSQLI_BOTH)) {
        $department['id'] = $row['department_id'];
        $department['name'] = $row['name'];
        array_push($departments, $department);
    }
    mysqli_stmt_close($stmt);
    
    return $departments;
}

function getDepartmentsProfessors($departmentid) {
    $professors = array();

    $link = connect_db();
    $sql = "SELECT *, `professor`.`id` AS `professorid` FROM `professor`, `department` WHERE `department`.`id` = ? AND `department`.`id` = `professor`.`department_id` ORDER BY `professor`.`lastname`";
    $stmt = $link->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param('i', $departmentid);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($professor = $result->fetch_object('Professor')) {
        $theProfessor = $professor;
        array_push($professors, $professor);
    }

    mysqli_stmt_close($stmt);
    
    return $professors;
}

function getProfessor($id) {
	$theProfessor = null;
	
	// Connect and initialize sql and prepared statement template
	$link = connect_db();
	$sql = "SELECT * FROM professor WHERE id = ? LIMIT 1";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();

	// bind the result to $theBook for json encoding
	while ($professor = $result->fetch_object('Professor')) {
		$theProfessor = $professor;
	}
	
	mysqli_stmt_close($stmt);
	return $theProfessor;
}

function addProfessor($firstname, $lastname, $officebuilding, $officeroom, $phonenumber, $email, $imageurl, $departmentid) {
	$link = connect_db();
	$sql = "INSERT INTO  `professor` (`department_id`, `firstname`, `lastname`, `officebuilding`, `officeroom`, `phonenumber`, `email`, `pictureurl`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('issssiss', $departmentid, 
					  $link->real_escape_string($firstname),
					  $link->real_escape_string($lastname),
					  $link->real_escape_string($officebuilding),
					  $link->real_escape_string($officeroom),
					  $phonenumber,
					  $link->real_escape_string($email),
					  $link->real_escape_string($imageurl));
	$stmt->execute();
	$id = $link->insert_id;
	mysqli_stmt_close($stmt);
	$link->close();
	
	$professor = getProfessor($id);
	
	return $professor;
}

function updateProfessor($id, $firstname, $lastname, $officebuilding, $officeroom, $phonenumber, $email, $imageurl, $departmentid) {
	$link = connect_db();
	$sql = "UPDATE  `professor` SET `firstname`=?, `lastname`=?, `officebuilding`=?, `officeroom`=?, `phonenumber`=?, `email`=?, `pictureurl`=?, `department_id`=? WHERE id = ?";
	
	// Create prepared statement and bind parameters
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('ssssissii', 
					  $link->real_escape_string($firstname), 
					  $link->real_escape_string($lastname), 
					  $link->real_escape_string($officebuilding), 
					  $link->real_escape_string($officeroom), 
					  $phonenumber,
					  $link->real_escape_string($email),
					  $link->real_escape_string($imageurl), 
					  $departmentid, $id);
	
    // Execute the query, get the new user object from the database
    $stmt->execute();
	mysqli_stmt_close($stmt);
	$link->close();
    $professor = getProfessor($id);
	
	return $professor;
}

function addOfficeHours($days, $times, $professorid) {
	$link = connect_db();
	$sql = "INSERT INTO  `professor_officehours` (`days`, `times`, `professor_id`) VALUES (?, ?, ?)";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('ssi',
					  $link->real_escape_string($days),
					  $link->real_escape_string($times),
					 $professorid);
	$stmt->execute();
	$id = $link->insert_id;
	mysqli_stmt_close($stmt);
	$link->close();
	
	return $id;
}

function getOfficeHours($professorid) {
	$officehours = array();

    $link = connect_db();
    $sql = "SELECT * FROM `professor_officehours` WHERE `professor_officehours`.`professor_id` = ?";
    $stmt = $link->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param('i', $professorid);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($officehour = $result->fetch_object('OfficeHours')) {
        $theOfficeHours = $officehour;
        array_push($officehours, $theOfficeHours);
    }

    mysqli_stmt_close($stmt);
    
    return $officehours;
}

function deleteOfficeHours($id) {
	$link = connect_db();
	$sql = "DELETE FROM `professor_officehours` WHERE id = ?";
	
	// Create prepared statement and bind parameters
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $id);
    $stmt->execute();
	$rows = $link->affected_rows;
	mysqli_stmt_close($stmt);
	$link->close();
    return $rows;
}











?>