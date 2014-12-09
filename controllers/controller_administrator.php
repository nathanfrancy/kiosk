<?php
require_once('../dao/dao.php');

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
	if (isAdmin() === 1) {
		$name = $_POST['name'];
		$prefix = $_POST['prefix'];
        $office = $_POST['office'];
		$newid = addDepartment($name, $prefix, $office);
		$department = getDepartment($newid);
        addUserTrack($_SESSION['auth_id'], "INSERT_DEPARTMENT", "Added department '{$department->name}' (id={$department->id}).");
        header('Content-Type: application/json');
		echo json_encode($department);
	}
	else { echo "You are not authorized to perform this action."; }
}
else if ($controllerType === "getAllDepartments") {
    if (isAdmin() === 1) {
		$departments = getAllDepartments();
        header('Content-Type: application/json');
		echo json_encode($departments);
	}
	else { echo "You are not authorized to perform this action."; }
}
else if ($controllerType === "getDepartment") {
    $id = $_POST['id'];
    $department = getDepartment($id);
    header('Content-Type: application/json');
    echo json_encode($department);
}
else if ($controllerType === "updateDepartment") {
	if (isAdmin() === 1) {
		$id = $_POST['id'];
		$name = $_POST['name'];
		$prefix = $_POST['prefix'];
        $office = $_POST['office'];
		$department = updateDepartment($id, $name, $prefix, $office);
        addUserTrack($_SESSION['auth_id'], "UPDATE_DEPARTMENT", "Updated department '{$department->name}' (id={$department->id})");
        header('Content-Type: application/json');
		echo json_encode($department);
	}
	else { echo "You are not authorized to perform this action."; }
}
else if ($controllerType === "deleteDepartment") {
	if (isAdmin() === 1) {
		$id = $_POST['id'];
        addUserTrack($_SESSION['auth_id'], "DELETE_DEPARTMENT", "Deleted department (id={$id})");
        header('Content-Type: application/json');
		echo json_encode(deleteDepartment($id));
	}
	else { echo "You are not authorized to perform this action."; }
}
else if ($controllerType === "addUser") {
	if (isAdmin() === 1) {
		$nicename = $_POST['nicename'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$type = $_POST['type'];
		$username = $_POST['username'];
		$status = $_POST['status'];
		$userid = addUser($username, $password, $nicename, $email, $type, $status);
		$user = getUser($userid);
        addUserTrack($_SESSION['auth_id'], "INSERT_USER", "Added user '{$user->nicename}' (id={$user->id}).");
        header('Content-Type: application/json');
		echo json_encode($user);
	}
	else { echo "You are not authorized to perform this action."; }
}
else if ($controllerType === "getUser") {
	if (isAdmin() === 1) {
		$id = $_POST['id'];
		$user = getUser($id);
        header('Content-Type: application/json');
		echo json_encode($user);
	}
	else { echo "You are not authorized to perform this action."; }
}
else if ($controllerType === "updateUser") {
	if (isAdmin() === 1) {
		$id = $_POST['id'];
		$username = $_POST['username'];
		$nicename = $_POST['nicename'];
		$email = $_POST['email'];
		$type = $_POST['type'];
		$status = $_POST['status'];
		$user = updateUser($id, $nicename, $username, $email, $type, $status);
        addUserTrack($_SESSION['auth_id'], "UPDATE_USER", "Updated user '{$user->nicename}' (id={$user->id}).");
        header('Content-Type: application/json');
		echo json_encode($user);
	}
	else { echo "You are not authorized to perform this action."; }
}
else if ($controllerType === "deleteUser") {
	if (isAdmin() === 1) {
		$id = $_POST['id'];
        addUserTrack($_SESSION['auth_id'], "DELETE_USER", "Deleted user (id={$id}).");
        header('Content-Type: application/json');
		echo json_encode(deleteUser($id));
	}
	else { echo "You are not authorized to perform this action."; }
}
else if ($controllerType === "getAllUsers") {
	if (isAdmin() === 1) {
        header('Content-Type: application/json');
    	echo json_encode(getAllUsers());
	}
	else { echo "You are not authorized to perform this action."; }
}
else if ($controllerType === "resetPassword") {
	if (isAdmin() === 1) {
		$id = $_POST['id'];
		$password = $_POST['password'];
		$newuser = resetPassword($id, $password);
        addUserTrack($_SESSION['auth_id'], "RESET_PASSWORD_ADMIN", "Password reset for '{$newuser->nicename}' (id={$newuser->id}).");
        header('Content-Type: application/json');
		echo json_encode($newuser);
	}
	else { echo "You are not authorized to perform this action."; }
}
else if ($controllerType === "grantDepartmentAccess") {
	if (isAdmin() === 1) {
		$departmentid = $_POST['departmentid'];
		$userid = $_POST['userid'];
		$userid = grantDepartmentAccess($userid, $departmentid);
        addUserTrack($_SESSION['auth_id'], "ACCESS_GRANTED", "Granted user(id={$userid}) to department(id={$departmentid}).");
        header('Content-Type: application/json');
		echo json_encode($userid);
	}
	else { echo "You are not authorized to perform this action."; }
}
else if ($controllerType === "revokeDepartmentAccess") {
	if (isAdmin() === 1) {
		$departmentid = $_POST['departmentid'];
		$userid = $_POST['userid'];
		$userid = revokeDepartmentAccess($userid, $departmentid);
        addUserTrack($_SESSION['auth_id'], "ACCESS_REVOKED", "Revoked access from user(id={$userid}) to department(id={$departmentid}).");
        header('Content-Type: application/json');
		echo json_encode($userid);
	}
	else { echo "You are not authorized to perform this action."; }
}   
else if ($controllerType === "getGrantedDepartmentIds") {
	if (isAdmin() === 1) {
		$userid = $_POST['userid'];
		$departments = getGrantedDepartmentIds($userid);
        header('Content-Type: application/json');
		echo json_encode($departments);
	}
	else { echo "You are not authorized to perform this action."; }
}
else if ($controllerType === "changeTheme") {
	$userid = $_POST['userid'];
	$theme = $_POST['theme'];
	$newuser = updateTheme($userid, $theme);
    addUserTrack($_SESSION['auth_id'], "UPDATE_THEME", "User changed theme to {$theme}.");
    header('Content-Type: application/json');
	echo json_encode($newuser);
}
else if ($controllerType === "changePassword") {
    $auth_id = $_SESSION['auth_id'];
    $message = changePassword($auth_id, $_POST['newpassword']);
    addUserTrack($_SESSION['auth_id'], "RESET_PASSWORD_SELF", "User reset password.");
    header('Content-Type: application/json');
    echo $message;
}
else if ($controllerType === "getAllTrackings") {
    if (isAdmin() === 1) {
        $tracks = getAllTrackings();
        header('Content-Type: application/json');
        echo json_encode($tracks);
    }
}
else if ($controllerType === "clearAllTrackings") {
    if (isAdmin() === 1) {
        $track_msg = clearAllTrackings();
        header('Content-Type: application/json');
        echo json_encode($track_msg);
    }
}

?>
