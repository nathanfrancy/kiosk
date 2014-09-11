<?php
require('dao.php');

/*
    This script is mainly used as a controller for ajax operations 
    for the administrator level. Make sure you are passing in a 
    controllerType variable, or else you will get an error, no matter
    what other data you are passing. Functions are separated by the 'if'
    statements, and should be considered completely independent of each 
    other as operations.
*/

$controllerType = $_POST['controllerType'];

if ($controllerType === "addDepartment") {
    $name = $_POST['name'];
    $newid = addDepartment($name);
    $department = getDepartment($newid);
    echo json_encode($department);
}
else if ($controllerType === "getDepartment") {
    $id = $_POST['id'];
    $department = getDepartment($id);
    echo json_encode($department);
}
else if ($controllerType === "updateDepartment") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $department = updateDepartment($id, $name);
    echo json_encode($department);
}
else if ($controllerType === "deleteDepartment") {
    $id = $_POST['id'];
    echo json_encode(deleteDepartment($id));
}
else if ($controllerType === "addUser") {
	$nicename = $_POST['nicename'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$type = $_POST['type'];
	$username = $_POST['username'];
	
	$userid = addUser($username, $password, $nicename, $email, $type);
	$user = getUser($userid);
	echo json_encode($user);
}
else if ($controllerType === "getUser") {
	$id = $_POST['id'];
	$user = getUser($id);
	echo json_encode($user);
}
else if ($controllerType === "updateUser") {
	$id = $_POST['id'];
	$username = $_POST['username'];
	$nicename = $_POST['nicename'];
	$email = $_POST['email'];
}

?>