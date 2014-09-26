<?php
require('dao.php');

/*
    
*/

$controllerType = $_POST['controllerType'];

if ($controllerType === "getDepartmentsProfessors") {
    $departmentid = $_POST['departmentid'];
    $professors = getDepartmentsProfessors($departmentid);
    echo json_encode($professors);
}
else if ($controllerType === "getProfessor") {
    $professorid = $_POST['professorid'];
    $professor = getProfessor($professorid);
    echo json_encode($professor);
}
else if ($controllerType === "addProfessor") {
	
}

?>