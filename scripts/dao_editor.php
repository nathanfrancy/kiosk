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
    $sql = "SELECT * FROM `professor`, `department` WHERE `department`.`id` = ? AND `department`.`id` = `professor`.`department_id` ORDER BY `professor`.`lastname`";
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


?>