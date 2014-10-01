<?php


function publicGetDepartmentsProfessors($departmentid) {
    $professors = array();

    $link = connect_db();
    $sql = "SELECT *, `professor`.`id` AS `professorid` FROM `professor`, `department` WHERE `department`.`id` = ? AND `department`.`id` = `professor`.`department_id` ORDER BY `professor`.`lastname`";
    $stmt = $link->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param('i', $departmentid);
    $stmt->execute();
    $result = $stmt->get_result();

	while ($row = $result->fetch_array(MYSQLI_BOTH)) {
		$professor = null;
		$officehours = null;
		
		if ($row['professorid'] !== null) {
			
			// Put all variables into the $professor variable
			$professor['id'] = $row['professorid'];
			$professor['firstname'] = $row['firstname'];
			$professor['lastname'] = $row['lastname'];
			$professor['officebuilding'] = $row['officebuilding'];
			$professor['officeroom'] = $row['officeroom'];
			$professor['phonenumber'] = $row['phonenumber'];
			$professor['email'] = $row['email'];
			$professor['pictureurl'] = $row['pictureurl'];
			
			// Department related variables
			$professor['department']['id'] = $row['department_id'];
			$professor['department']['name'] = $row['name'];
			
			// Compile office hours into $professor
			$professor['officehours'] = getOfficeHours($professor['id']);
		}
		
		array_push($professors, $professor);
	}

    mysqli_stmt_close($stmt);
    
    return $professors;
}

?>