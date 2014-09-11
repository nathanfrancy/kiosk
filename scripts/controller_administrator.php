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

?>