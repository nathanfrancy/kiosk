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

?>