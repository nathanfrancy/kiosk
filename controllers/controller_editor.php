<?php
require_once('../dao/dao.php');

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
else if ($controllerType === "editProfessor") {
	$id = $_POST['id'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$officebuilding = $_POST['officebuilding'];
	$officeroom = $_POST['officeroom'];
	$phonenumber = $_POST['phonenumber'];
	$email = $_POST['email'];
	$imageurl = $_POST['imageurl'];
	$departmentid = $_POST['departmentid'];
	$newprofessor = updateProfessor($id, $firstname, $lastname, $officebuilding, $officeroom, $phonenumber, $email, $imageurl, $departmentid);
	echo json_encode($newprofessor);
}
else if ($controllerType === "getOfficeHours") {
	$professorid = $_POST['professorid'];
	$officehours = getOfficeHours($professorid);
	echo json_encode($officehours);
}
else if ($controllerType === "deleteOfficeHours") {
	$id = $_POST['id'];
	$message['affected'] = deleteOfficeHours($id);
	if ($message['affected'] !== 0) {
		$message['message'] = "Successfully deleted office hours.";
	}
	else {
		$message['message'] = "Unsuccessfully deleted office hours.";
	}
	
	echo json_encode($message);
}
else if ($controllerType === "addOfficeHours") {
	$professorid = $_POST['professorid'];
	$days = $_POST['days'];
	$times = $_POST['times'];
	$id = addOfficeHours($days, $times, $professorid);
	echo json_encode($id);
}
else if ($controllerType === "enableProfessor") {
	$id = $_POST['id'];
	$professor = enableProfessor($id);
	echo json_encode($professor);
}
else if ($controllerType === "disableProfessor") {
	$id = $_POST['id'];
	$professor = disableProfessor($id);
	echo json_encode($professor);
}
else if ($controllerType === "getDepartmentsCourses") {
	$id = $_POST['id'];
	$courses = getDepartmentsCourses($id);
	echo json_encode($courses);
}
else if ($controllerType === "addCourse") {
	$name = $_POST['name'];
	$number = $_POST['number'];
	$departmentid = $_POST['departmentid'];
	$course = addCourse($number, $name, $departmentid);
	echo json_encode($course);
}
else if ($controllerType === "getCourse") {
	$id = $_POST['id'];
	$course = getCourse($id);
	echo json_encode($course);
}

?>