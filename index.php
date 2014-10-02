<?php

// Start a session if one doesn't already exist
if ( (session_status() == PHP_SESSION_NONE) || (session_id() == '') ) {
    session_start();
}


// See if logged in and give link for each case
if ( isset($_SESSION['auth_id']) ) { 
    echo "<a href='home.php'>Go home</a>"; 
}
else {
    echo "<a href='views/login.php'>Login</a>";
}