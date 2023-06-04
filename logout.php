<?php
include './connections.php';

// Start the session
session_start();

// Destroy all session data
session_destroy();

// Redirect the user to the login page or any other desired page
header("Location:resident-login.php");
?>
