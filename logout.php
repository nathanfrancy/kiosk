<?php
session_start();
session_destroy();

$_SESSION['auth_admin_id'] = 0;

unset($_SESSION['auth_admin_id']);
unset($_SESSION['auth_editor_id']);

header("Location: index.php");