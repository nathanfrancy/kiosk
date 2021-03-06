<?php
require_once('../dao/dao.php');

$controllerType = $_POST['controllerType'];

if ($controllerType === "getDepartmentsProfessors") {
    $departmentid = $_POST['departmentid'];
    $professors = getDepartmentsProfessors($departmentid);
    header('Content-Type: application/json');
    echo json_encode($professors);
}
else if ($controllerType === "getProfessor") {
    $professorid = $_POST['professorid'];
    $professor = getProfessor($professorid);
    header('Content-Type: application/json');
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
    addUserTrack($_SESSION['auth_id'], "INSERT_PROFESSOR", "Added professor '{$firstname} {$lastname}'.");
    header('Content-Type: application/json');
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
    addUserTrack($_SESSION['auth_id'], "UPDATE_PROFESSOR", "Updated professor '{$firstname} {$lastname}'.");
    header('Content-Type: application/json');
	echo json_encode($newprofessor);
}
else if ($controllerType === "getOfficeHours") {
	$professorid = $_POST['professorid'];
	$officehours = getOfficeHours($professorid);
    header('Content-Type: application/json');
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
    addUserTrack($_SESSION['auth_id'], "DELETE_OFFICEHOURS", "Deleted office hours (id={$id}).");
	header('Content-Type: application/json');
	echo json_encode($message);
}
else if ($controllerType === "addOfficeHours") {
	$professorid = $_POST['professorid'];
	$days = $_POST['days'];
	$times = $_POST['times'];
	$id = addOfficeHours($days, $times, $professorid);
    addUserTrack($_SESSION['auth_id'], "INSERT_OFFICEHOURS", "Added office hours to professor (id={$professorid}), office hours (id={$id}).");
    header('Content-Type: application/json');
	echo json_encode($id);
}
else if ($controllerType === "enableProfessor") {
	$id = $_POST['id'];
	$professor = enableProfessor($id);
    addUserTrack($_SESSION['auth_id'], "ENABLE_PROFESSOR", "Enabled professor (id={$professor['id']}).");
    header('Content-Type: application/json');
	echo json_encode($professor);
}
else if ($controllerType === "disableProfessor") {
	$id = $_POST['id'];
	$professor = disableProfessor($id);
    addUserTrack($_SESSION['auth_id'], "DISABLE_PROFESSOR", "Disabled professor (id={$professor['id']}).");
    header('Content-Type: application/json');
	echo json_encode($professor);
}
else if ($controllerType === "getDepartmentsCourses") {
	$id = $_POST['id'];
	$courses = getDepartmentsCourses($id);
    header('Content-Type: application/json');
	echo json_encode($courses);
}
else if ($controllerType === "addCourse") {
	$name = $_POST['name'];
	$number = $_POST['number'];
	$departmentid = $_POST['departmentid'];
	$course = addCourse($number, $name, $departmentid);
    addUserTrack($_SESSION['auth_id'], "INSERT_COURSE", "Added course (id={$course['id']}).");
    header('Content-Type: application/json');
	echo json_encode($course);
}
else if ($controllerType === "getCourse") {
	$id = $_POST['id'];
	$course = getCourse($id);
    header('Content-Type: application/json');
	echo json_encode($course);
}
else if ($controllerType === "editCourse") {
	$id = $_POST['id'];
	$name = $_POST['name'];
	$number = $_POST['number'];
	$departmentid = $_POST['departmentid'];
	$course = editCourse($id, $number, $name, $departmentid);
    addUserTrack($_SESSION['auth_id'], "UPDATE_COURSE", "Updated course (id={$course['id']}).");
    header('Content-Type: application/json');
	echo json_encode($course);
}
else if ($controllerType === "linkCourseToProfessor") {
    $days = $_POST['days'];
    $time = $_POST['time'];
    $courseid = $_POST['courseid'];
    $professorid = $_POST['professorid'];
    $linkedcourse = addLinkedCourseToProfessor($days, $time, $courseid, $professorid);
    addUserTrack($_SESSION['auth_id'], "LINK_COURSE", "Linked course (id={$courseid}) to professor (id={$professorid}) .");
    header('Content-Type: application/json');
    echo json_encode($linkedcourse);
}
else if ($controllerType === "deleteProfessorCourseLink") {
	$professorcourse_id = $_POST['professorcourse_id'];
	$professor_id = $_POST['professor_id'];
	$new_professor = deleteProfessorCourseLink($professorcourse_id, $professor_id);
    addUserTrack($_SESSION['auth_id'], "UNLINK_COURSE", "Unlinked course (id={$professorcourse_id}) from professor (id={$professor_id}) .");
    header('Content-Type: application/json');
	echo json_encode($new_professor);
}

?>
