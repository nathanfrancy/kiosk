<?php

// Start a session if one doesn't already exist
if ( (session_status() == PHP_SESSION_NONE) || (session_id() == '') ) {
    session_start();
}

session_destroy();

$_SESSION['auth_id'] = 0;

unset($_SESSION['auth_id']);

header("Location: index.php");