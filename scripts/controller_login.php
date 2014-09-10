<?php

require('dao.php');

$controllerType = $_POST['controllerType'];

if ($controllerType === "userLogin") {
	
	$input_username = $_POST['username'];
	$input_password = $_POST['password'];
	
	$userid = validateUser($input_username, $input_password);
	
	if ($userid !== 0) {
		header("Location: ../home.php");
	}
}

else {
	echo "No operation defined";
}


?>