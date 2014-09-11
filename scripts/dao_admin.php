<?php

function getAllDepartments() {
    $departments = array();
	
	// Connect and initialize sql and prepared statement template
	$link = connect_db();
	$sql = "SELECT * FROM department";
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

function addDepartment($name) {
    $link = connect_db();
	$sql = "INSERT INTO  `department` (`name`) VALUES (?)";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('s', $link->real_escape_string($name));
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

?>