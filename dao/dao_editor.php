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
		$department['prefix'] = $row['prefix'];
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
	$theDepartment = null;
	
	// Connect and initialize sql and prepared statement template
	$link = connect_db();
	$sql = "SELECT * FROM professor WHERE id = ? LIMIT 1";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();

	// bind the result to $theProfessor for json encoding
	while ($row = $result->fetch_array(MYSQLI_BOTH)) {
		$theProfessor['id'] = $row['id'];
		$theProfessor['department_id'] = $row['department_id'];
		$theDepartment = $row['department_id'];
		$theProfessor['firstname'] = $row['firstname'];
		$theProfessor['lastname'] = $row['lastname'];
		$theProfessor['title'] = $row['title'];
		$theProfessor['officebuilding'] = $row['officebuilding'];
		$theProfessor['officeroom'] = $row['officeroom'];
		$theProfessor['phonenumber'] = $row['phonenumber'];
		$theProfessor['email'] = $row['email'];
		$theProfessor['pictureurl'] = $row['pictureurl'];
		$theProfessor['status'] = $row['status'];
    }

	mysqli_stmt_close($stmt);
	
	// Make a second query for the courses linked to the professor
	$link2 = connect_db();
	$sql2 = "SELECT *, `professor_courses`.`id` as `profcourse_id`, `professor_courses`.`days` as `profcourse_days` FROM `professor_courses`, `course` WHERE `professor_courses`.`professor_id` = ? AND `professor_courses`.`course_id` = `course`.`id`";
	$stmt2 = $link2->stmt_init();
	$stmt2->prepare($sql2);
	$stmt2->bind_param('i', $id);
	$stmt2->execute();
	$result2 = $stmt2->get_result();
	
	// compile a courses array and add to $theProfessor object at the end
	$courses = array();
	while ($row2 = $result2->fetch_array(MYSQLI_BOTH)) {
		$course = null;
        $course['id'] = $row2['profcourse_id'];
		$course['days'] = $row2['profcourse_days'];
		$course['time'] = $row2['time'];
		$course['status'] = $row2['status'];
		$course['courseid'] = $row2['course_id'];
		$course['coursename'] = $row2['name'];
		$course['department_id'] = $row2['department_id'];
        array_push($courses, $course);
    }
	
	$theProfessor['courses'] = $courses;
	$theProfessor['availableCourses'] = getDepartmentsCourses($theDepartment);
	mysqli_stmt_close($stmt2);
	
	return $theProfessor;
}

function addProfessor($firstname, $lastname, $officebuilding, $officeroom, $phonenumber, $email, $imageurl, $departmentid) {
	$link = connect_db();
	$sql = "INSERT INTO  `professor` (`department_id`, `firstname`, `lastname`, `officebuilding`, `officeroom`, `phonenumber`, `email`, `pictureurl`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'enabled')";
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

function disableProfessor($id) {
	$link = connect_db();
	$sql = "UPDATE  `professor` SET `status`='disabled' WHERE id = ?";
	
	// Create prepared statement and bind parameters
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $id);
    
    $stmt->execute();
	mysqli_stmt_close($stmt);
	$link->close();
    $user = getProfessor($id);
	
	return $user;
}

function enableProfessor($id) {
	$link = connect_db();
	$sql = "UPDATE  `professor` SET `status`='enabled' WHERE id = ?";
	
	// Create prepared statement and bind parameters
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $id);
    
    $stmt->execute();
	mysqli_stmt_close($stmt);
	$link->close();
    $user = getProfessor($id);
	
	return $user;
}

function getDepartmentsCourses($departmentid) {
    $courses = array();

    $link = connect_db();
    $sql = "SELECT *, `course`.`id` AS `courseid`, `course`.`name` AS `coursename` FROM `course`, `department` WHERE `department`.`id` = ? AND `department`.`id` = `course`.`department_id` ORDER BY `course`.`number`";
    $stmt = $link->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param('i', $departmentid);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_array(MYSQLI_BOTH)) {
        $course['id'] = $row['courseid'];
		$course['name'] = $row['coursename'];
		$course['number'] = $row['number'];
		$course['departmentid'] = $row['department_id'];
		
		array_push($courses, $course);
    }

    mysqli_stmt_close($stmt);
    
    return $courses;
}

function addCourse($number, $name, $departmentid) {
	$link = connect_db();
	$sql = "INSERT INTO  `course` (`number`, `name`, `department_id`) VALUES (?, ?, ?)";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('isi', $number, $link->real_escape_string($name), $departmentid);
	$stmt->execute();
	$id = $link->insert_id;
	mysqli_stmt_close($stmt);
	$link->close();
	
	$course = getCourse($id);
	
	return $course;
}

function getCourse($id) {
	$theCourse = null;
	
	// Connect and initialize sql and prepared statement template
	$link = connect_db();
	$sql = "SELECT * FROM course WHERE id = ? LIMIT 1";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();

	// bind the result to $theBook for json encoding
	while ($row = $result->fetch_array(MYSQLI_BOTH)) {
		$theCourse['id'] = $row['id'];
        $theCourse['number'] = $row['number'];
        $theCourse['name'] = $row['name'];
        $theCourse['department_id'] = $row['department_id'];
	}
	
	mysqli_stmt_close($stmt);
	return $theCourse;
}

function editCourse($id, $number, $name, $departmentid) {
	$link = connect_db();
	$sql = "UPDATE  `course` SET `number`=?, `name`=?, `department_id`=? WHERE id = ?";
	
	// Create prepared statement and bind parameters
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('isii', $number, $link->real_escape_string($name), $departmentid, $id);
    
    $stmt->execute();
	mysqli_stmt_close($stmt);
	$link->close();
    $course = getCourse($id);
	
	return $course;
}


function addLinkedCourseToProfessor($days, $time, $courseid, $professorid) {
    $status = 'enabled';
    $link = connect_db();
	$sql = "INSERT INTO  `professor_courses` (`days` ,`time` ,`status` ,`professor_id` ,`course_id`) VALUES ( ?,  ?,  ?,  ?,  ?)";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('sssii', $days, $time, $status, $professorid, $courseid);
	$stmt->execute();
	$id = $link->insert_id;
	mysqli_stmt_close($stmt);
	$link->close();
	
	$course = getLinkedCourseToProfessor($id);
	
	return $course;
}

function getLinkedCourseToProfessor($id) {
	$theCourse = null;
	
	$link = connect_db();
	$sql = "SELECT * FROM `professor_courses` WHERE id = ? LIMIT 1";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();
    
	// bind the result to $theProfessor for json encoding
	while ($row = $result->fetch_array(MYSQLI_BOTH)) {
        $theCourse['id'] = $row['id'];
        $theCourse['days'] = $row['days'];
        $theCourse['time'] = $row['time'];
        $theCourse['status'] = $row['status'];
        $theCourse['professor_id'] = $row['professor_id'];
        $theCourse['course_id'] = $row['course_id'];
    }
    
    $theCourse['courseinfo'] = getCourse($theCourse['course_id']);

	mysqli_stmt_close($stmt);
	
	return $theCourse;
}










?>