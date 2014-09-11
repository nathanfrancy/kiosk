<?php
session_start();
session_destroy();

$_SESSION['auth_id'] = 0;

unset($_SESSION['auth_id']);

header("Location: index.php");