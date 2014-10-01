<?php

/** 

This file is a controller for use with the "public" API in the kiosk 
application, used in the end-user interface. No operations are being done, 
and is only used to retrieve data. 

**/


require("../dao/dao.php");

$requestType = null;

if (isset($_GET['requestType'])) {
	$requestType = $_GET['requestType'];
}




/**
===========================================================================
Operations for the public API for use: 

[getDepartment] 			: Get department from specified id number
[getDepartments] 			: Get all departments
[getDepartmentsProfessors] 	: Get all professors from specified department


[getProfessor]				: Get professor with specified id number


===========================================================================
**/


if ($requestType === "getDepartment") {
	$response = null;
	$response['departments'] = getAllDepartments();
	$response['message'] = "Successful";
	echo json_encode($response);
}


else if ($requestType === "getDepartments") {
	$response = null;
	$response['departments'] = getAllDepartments();
	$response['message'] = "Successful";
	echo json_encode($response);
}


else if ($requestType === "getDepartmentProfessors") {
	$response = null;
	$id = 0;
	
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$professors = publicGetDepartmentsProfessors($id);
		
		if ($professors === null) {
			$response['message'] = "No professors found.";
		}
		else {
			$response['message'] = "Successful";
			$response['professors'] = $professors;
			
			foreach ($professors as $professor) {
				echo $professor->id;
			}
		}
	}
	else {
		$response['message'] = "Cannot complete operation without id number.";
	}
	
	echo json_encode($response);
}

else if ($requestType === "getProfessor") {
	$id = 0;
	$response = null;
	
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$professor = getProfessor($id);
		
		if ($professor === null) {
			$response['message'] = "No professor found.";
		}
		else {
			$response['message'] = "Successful";
			$response['professor'] = $professor;
			$response['officehours'] = getOfficeHours($id);
		}
	}
	else {
		$response['message'] = "Cannot complete operation without id number.";
	}
	
	echo json_encode($response);
}



?>