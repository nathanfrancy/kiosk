<?php
session_start();

if ( isset($_SESSION['auth_editor_id']) || isset($_SESSION['auth_admin_id']) ) { 
    echo "<a href='home.php'>Go home</a>"; 
}
else {
    echo "<a href='login.php'>Login</a>";
}