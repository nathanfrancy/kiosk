<?php
require('../dao/dao.php');

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
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$officebuilding = $_POST['officebuilding'];
	$officeroom = $_POST['officeroom'];
	$phonenumber = $_POST['phonenumber'];
	$email = $_POST['email'];
	$imageurl = $_POST['imageurl'];
	$departmentid = $_POST['departmentid'];
	$newprofessor = addProfessor($firstname, $lastname, $officebuilding, $officeroom, $phonenumber, $email, $imageurl, $departmentid);
	echo json_encode($newprofessor);
}
else if ($controllerType === "getOfficeHours") {
	$professorid = $_POST['professorid'];
	$officehours = getOfficeHours($professorid);
	echo json_encode($officehours);
}

?>